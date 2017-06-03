<?php
class CheckoutAction extends checkout
{
    protected $pay_method;
    function __construct($data)
    {
        parent::__construct($data);
    }

    //生成订单
    function ActionAddOrder()
    {
        if(!isset($this->data['checkout'])){return;}
        $data = $this->GetCheckOutCartData();
        $result = $this->ActionCheckData($data);
        if($result['code'])
        {
            return $result;
        }
        $i= 0 ;
        $j = 0;
        $orderid = $this->OrderMakeOrderId();
        $date = date("Y-m-d H:i:s",time());
        $this->GetDBMaster()->StartTransaction();
        $order_total = 0;   //订单总金额
        $order_pro_total = 0;   //订单产品金额
        $order_goods_fee = 0;   //邮费
        $order_pro_count = 0;
        $order_pic = '';
        $goods_postage = $data['cart']['goods_postage'];
        $address = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SHIP_ADDRESS."  "
            ." WHERE id='".$this->data['address_id']."' AND userid='".SYS_USERID."'");
        if(empty($address))
        {
            return array('code'=>1,'msg'=>'地址信息错误');
        }
        $address_location = explode(' ',$address['address_location']);
        foreach($data['cart']['cart'] as $key=>$item)
        {
            $shop_pro_count = 0;      //店铺产品数量
            //$shop_pro_total = 0;    //店铺产品金额
            //$shop_fee_total = 0;    //店铺邮费
            //$shop_order_total = 0;  //店铺订单综合
            if($item['free_fee'])     //满减
            {
                if($goods_postage[$key]['shop_total']>=$item['free_fee_money'])
                {
                    $goods_postage[$key]['postage_total'] = 0;
                }
            }
            $order_goods_fee += $goods_postage[$key]['postage_total'];
            $order_pro_total += $goods_postage[$key]['shop_total'];
            foreach($item['cart_list'] as $val)
            {
                if($i==0 && $j==0)
                {
                    $order_pic = $val['product_img'];
                }

                if($val['product_status'] || $val['is_del'])
                {
                    return array('code'=>1,'msg'=>'【'.$val['product_name'].'】已下架，请从购物车移除后重试');
                    break;
                }

                if((!empty($val['bargain_price']) || !empty($val['seckill_price'])) && $val['product_count']>1)
                {
                    return array('code'=>1,'msg'=>'【'.$val['product_name'].'】最多只能购买一件');
                    break;
                }
                if (isset($data['cart']['goods_limit_buy'][$val['product_id']]))
                {
                    //限购处理
                    if ($data['cart']['goods_limit_buy'][$val['product_id']]['product_count']<$data['cart']['goods_limit_buy'][$val['product_id']]['min_buy'])
                    {
                        return array('code'=>1,'msg'=>$val['product_name'].'未达到最低购买数'.$data['cart']['goods_limit_buy'][$val['product_id']]['min_buy'].$val['product_unit']);
                    }elseif($data['cart']['goods_limit_buy'][$val['product_id']]['product_count']>$data['cart']['goods_limit_buy'][$val['product_id']]['max_buy'] && $data['cart']['goods_limit_buy'][$val['product_id']]['max_buy']>0)
                    {
                        return array('code'=>1,'msg'=>$val['product_name'].'超过最大购买数'.$data['cart']['goods_limit_buy'][$val['product_id']]['max_buy'].$val['product_unit']);
                    }
                }

                //计算循环店铺的产品数量
                $shop_pro_count += $val['product_count'];
                //计算循环店铺的产品总数量
                $order_pro_count += $val['product_count'];
                $j++;
                //写入订单产品表
                $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_ORDER_GOODS." "
                    ."(orderid,product_id,product_count,product_name,product_price,"
                    ."product_sum_price,userid,product_img,addtime,product_attr_name,"
                    ."product_attr_id,shop_id,seckill_price,bargain_price)VALUES('".$orderid."','".$val['product_id']."',"
                    ."'".$val['product_count']."','".$val['product_name']."','".$val['product_price']."',"
                    ."'".$val['product_price']*$val['product_count']."','".SYS_USERID."','".$val['product_img']."','".$date."',"
                    ."'".$val['attr_name']."','".$val['attr_id']."','".$key."','".$val['seckill_price']."','".$val['bargain_price']."')");
                if (!empty($val['bargain_create_id']) && $res)
                {
                    //砍价商品
                    $res=$this->GetDBMaster()->query("UPDATE ".TABLE_GAMES_BARGAIN_CREATE." SET over_status=1 "
                        ." WHERE id='".$val['bargain_create_id']."'");
                }
                if(!$res)
                {
                    $this->GetDBMaster()->RollbackTransaction();
                    return array('code'=>1,'msg'=>'订单提交失败');
                }
            }

            $coupon_money=$coupon_id=0;
            //优惠券使用减免程序
            if (isset($data['coupon']['use_coupon']['data'][$key]['coupon_money']) && $data['coupon']['use_coupon']['data'][$key]['coupon_money']<$goods_postage[$key]['shop_total'])
            {
                $coupon_money=$data['coupon']['use_coupon']['data'][$key]['coupon_money'];
                $coupon_id=$data['coupon']['use_coupon']['data'][$key]['coupon_id'];
                $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON."  "
                    ." SET orderid='".$orderid."',use_status=1,use_time='".date("Y-m-d H:i:s")."',store_id='".$key."' "
                    ." WHERE id='".$data['coupon']['use_coupon']['data'][$key]['coupon_id']."'");
            }

            //商户订单存储
            $shop_order_total = ($goods_postage[$key]['shop_total']-$coupon_money)+$goods_postage[$key]['postage_total'];
            $shop_res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_ORDER_SHOP."  "
                ." SET orderid='".$orderid."',shop_id='".$key."',userid='".SYS_USERID."',"
                ." pro_count='".$shop_pro_count."',"
                ." total_pro_money='".$goods_postage[$key]['shop_total']."',"
                ." total_money='".$shop_order_total."',addtime='".date("Y-m-d H:i:s",time())."',"
                ." ship_name='".$address['shop_name']."',ship_phone='".$address['shop_phone']."',"
                ." ship_province='".$address_location[0]."',ship_city='".$address_location[1]."',"
                ." liuyan='".$this->data['liuyan']."',"
                ." ship_area='".$address_location[2]."',ship_address='".$address['address_details']."',"
                ." order_status=1,pro_fee='".$goods_postage[$key]['postage_total']."',order_type=0,"
                ." pay_method='".$this->data['pay_method']."',coupon_money='".$coupon_money."',coupon_id='".$coupon_id."'");
            $goods_postage[$key]['orderid']=$orderid;
            if(!$shop_res)
            {
                $this->GetDBMaster()->RollbackTransaction();
                return array('code'=>1,'msg'=>'订单提交失败');
            }
            $i++;
        }

        $order_total = ($order_pro_total-$data['coupon']['use_coupon']['use_coupon_money'])+$order_goods_fee;
        $last_id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_ORDER."(orderid,userid,"
            ." total_money,pro_count,shop_count,freight_money,pay_method,"
            ." order_ship_name,order_ship_phone,order_ship_sheng,order_ship_shi,order_ship_qu,"
            ." order_ship_address,order_img,order_addtime,order_status,liuyan,total_coupon_money)"
            ." VALUES('".$orderid."','".SYS_USERID."','".$order_total."',"
            ."'".$order_pro_count."','".count($data['cart'])."',"
            ."'".$order_goods_fee."','".$this->data['pay_method']."','".$address['shop_name']."',"
            ."'".$address['shop_phone']."','".$address_location[0]."','".$address_location[1]."',"
            ."'".$address_location[2]."','".$address['address_details']."',"
            ."'".$order_pic."','".date("Y-m-d H:i:s",time())."',1,'".$this->data['liuyan']."',"
            ."'".$data['coupon']['use_coupon']['use_coupon_money']."')");
        $remove_cart = $this->GetDBMaster()->query("DELETE FROM ".TABLE_CART."  "
            ." WHERE select_status=1 "
            ." AND userid='".SYS_USERID."'");
        if(trim($this->data['pay_method'])=='user_money')
        {
            $user_money = $data['user']['user_money'];
            if($user_money<$order_total)
            {
                return array('code'=>1,'msg'=>'余额不足');
            }
            $before_money = $user_money-$order_total;
            $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                ." SET user_money='".$before_money."'  "
                ." WHERE userid='".SYS_USERID."'");
            $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER."  "
                ." SET pay_money='".$order_total."',"
                ." order_status=3,pay_addtime='".$date."',"
                ." is_all_pay=1"
                ." WHERE orderid='".$orderid."'");
            $res3 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." "
                ." SET order_status=3,pay_money=total_money,"
                ." pay_datetime='".date("Y-m-d H:i:s",time())."',is_pay_shop=2  "
                ." WHERE orderid='".$orderid."'");
            if($last_id && $res1 && $res2 && $res3 && $remove_cart)
            {
                foreach($goods_postage as $k=>$v)
                {
                    $_fee_array=array(
                        "fee_type"=>8,
                        "fee_money"=>$v['shop_total']+$v['postage_total'],
                        "title"=>"购买商品余额支付",
                        "beizhu"=>'余额支付',
                        "transaction_id"=>0,
                        "orderid"=>$v['orderid'],
                        "userid"=>SYS_USERID,
                        "adminid"=>0,
                        "pay_type"=>0,
                        "store_id"=>$k
                    );
                    $res4 = $this->AddCommFee($_fee_array);
                    $res5 = $this->GetDBMaster()->query("INSERT INTO ".TABLE_BALANCE_DETAILS." ".
                        " SET trans_terrace_orderid='".$orderid."',"
                        ." trans_title='订单支付',trans_type=2,"
                        ." trans_money='".$order_total."',"
                        ." trans_wx_orderid='',"
                        ." trans_userid='".SYS_USERID."',"
                        ." trans_addtime='".date("Y-m-d H:i:s",time())."'");
                    if (!$res4 || !$res5)
                    {
                        $this->GetDBMaster()->RollbackTransaction();
                        return array('code'=>1,'msg'=>'订单提交失败.');
                    }
                }
                $this->GetDBMaster()->SubmitTransaction();
                //支付成功
                redirect('/?mod=weixin&v_mod=checkout&_index=_pay_result&orderid='.$orderid);
            }else
            {

            }
        }else
        {

            if($last_id && $remove_cart)
            {
                $this->GetDBMaster()->SubmitTransaction();
                //去支付
                redirect('?mod=weixin&v_mod=checkout&_index=_pay&orderid='.$orderid);
            }
        }
    }

    /*
     * 开团
     * */
    function ActionAddGroupBuy()
    {
        if(!isset($this->data['action']))
        {
            return;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        if(!regExp::checkNULL($this->data['address_id']))
        {
            return array('code'=>1,'msg'=>'数量错误');
        }
        $quantity = isset($this->data['quantity']) && is_numeric($this->data['quantity']) && $this->data['quantity']>0 ?intval($this->data['quantity']):1;
        //查询团购是否结束
        $data = $this->GetDBSlave1()->queryrow("SELECT GP.store_id,GP.product_id,GP.people_nums,GP.allow_buy_nums,GP.group_price,"
            ." GP.group_valid_day,P.product_name,P.product_desc,P.product_img,P.product_status,S.store_logo,S.store_name,S.free_fee,"
            ." S.free_fee_money,S.ship_fee_money FROM ".TABLE_GROUP_PRODUCT." AS GP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON GP.product_id=P.product_id "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON GP.store_id=S.store_id "
            ." WHERE GP.product_id='".$this->data['id']."'  "
            ."");
        if($data['allow_buy_nums'] && $quantity>$data['allow_buy_nums'])
        {
            return array('code'=>1,'msg'=>'超出最大允许数量');
        }
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'团购产品或存在或者已经团购结束');
        }elseif($data['product_status'])
        {
            return array('code'=>1,'msg'=>'团购产品已下架');
        }
        if($data['allow_buy_nums']>0 && $quantity>$data['allow_buy_nums'])
        {
            return array('code'=>1,'msg'=>'产品数量不足');
        }
        //判断是否有属性
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." WHERE "
            ." product_id='".$this->data['id']."' AND is_del=0");
        $attr_id = $attr_name=array();
        if($attr)
        {
            if(!regExp::checkNULL($this->data['attr_id']))
            {
                return array('code'=>1,'msg'=>'请选择产品属性');
            }
            $attr_id_array = $attr_val_array=array();
            foreach($attr as $item)
            {
                $attr_id_array[] = $item['id'];
                $attr_val_array[$item['id']] = $item['attr_temp_name'];
            }
            foreach($this->data['attr_id'] as $k=>$val)
            {
                if(!in_array($val,$attr_id_array))
                {
                    return array('code'=>1,'msg'=>'产品属性'.$attr_val_array[$k].'已下架');
                }
                $attr_id[]= $val;
                $attr_name[]=addslashes($attr_val_array[$val]);
            }
        }
        if(!regExp::checkNULL($this->data['pay_method']))
        {
            return array('code'=>1,'msg'=>'请选择支付方式');
        }
        if(!regExp::checkNULL($this->data['address_id']))
        {
            return array('code'=>1,'msg'=>'请选择收货地址');
        }
        $address = module('address')->GetOneAddress($this->data['address_id']);
        if(empty($address))
        {
            return array('code'=>1,'msg'=>'地址无效');
        }
        $ship_total = 0;
        $order_total = 0;
        $pro_total = $data['group_price'] * $quantity;
        if($data['free_fee'] && $pro_total>=$data['ship_fee_money'])
        {
            $ship_total=0;
        }else
        {
            $ship_total=$data['ship_fee_money'];
        }
        $order_total = $ship_total+$pro_total;
        $user = $this->GetUserInfo(SYS_USERID);
        if($this->data['pay_method']=='user_money')
        {
            if($user['user_money']<$order_total)
            {
                return array('code'=>1,'msg'=>'余额不足');
            }
            $pay_method = 'user_money';
        }else{
            $pay_method = 'wechat';
        }
        $group_status = 0;
        $pay_status = 0;
        $date = date("Y-m-d H:i:s",time());
        $this->GetDBMaster()->StartTransaction();
        try{
            //扣除余额
            if($pay_method=='user_money')
            {
                $user_before_money = $user['user_money']-$order_total;
                $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET user_money='".$user_before_money."' "
                    ." WHERE userid='".SYS_USERID."'");
                if(!$res1)
                {
                    throw new error(array('code'=>1,'msg'=>'余额支付失败'));
                }
                $group_status = 1;
                $pay_status = 1;
            }
            $orderid = $this->OrderMakeOrderId();
            $group_id = 'go_'.$orderid;
            //生成团购
            $res2 = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GROUP." "
                ."(group_id,product_id,userid,group_all_count,group_present_nums,group_status,"
                ."group_addtime,group_price,group_valid_days,store_id) VALUES('".$group_id."','".$this->data['id']."',"
                ."'".SYS_USERID."','".$data['people_nums']."','".$data['people_nums']."',"
                ." ".$group_status.",'".$date."','".$data['group_price']."','".$data['group_valid_day']."','".$data['store_id']."')");
            if($group_status)
            {
                //假设团有效期3天
                $res3 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." "
                    ." SET group_present_nums=group_present_nums-1,"
                    ." start_time='".date("Y-m-d H:i:s")."',"
                    ." end_time='".date("Y-m-d H:i:s",strtotime("+".$data['group_valid_day']." days"))."',"
                    ." pay_money='".$order_total."',pay_datetime='".$date."' "
                    ." WHERE id='".$res2."'");
                if(!$res3)
                {
                    throw new error(array('code'=>1,'msg'=>'开团操作失败'));
                }
            }
            $address_location = explode(' ',$address['address_location']);
            $res4 = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ORDER_GROUP." "
                ." (group_id,userid,product_id,product_count,group_total,shop_name,shop_phone,"
                ."shop_province,shop_city,shop_area,shop_address,product_img,pay_status,orderid,"
                ."addtime,pay_method,store_id,group_buy_type,ship_fee,attr_id,atrr_name,group_price,"
                ."pro_name)"
                ." VALUES('".$group_id."','".SYS_USERID."','".$this->data['id']."',"
                ."'".$quantity."','".$order_total."','".$address['shop_name']."',"
                ."'".$address['shop_phone']."','".$address_location[0]."',"
                ."'".$address_location[1]."','".$address_location[2]."',"
                ."'".$address['address_details']."','".$data['product_img']."',"
                ."'".$pay_status."','".$orderid."','".$date."','".$pay_method."',"
                ."'".$data['store_id']."',1,'".$ship_total."','".implode(',',$attr_id)."',"
                ."'".implode(',',$attr_name)."','".$data['group_price']."',"
                ."'".$data['product_name']."')");
            if($res2 && $res4)
            {
                if($pay_method=='user_money')
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GROUP." SET "
                        ." pay_money='".$order_total."',pay_date='".date("Y-m-d H:i:s",time())."' "
                        ." WHERE orderid='".$orderid."'");
                    $_fee_array=array(
                        "fee_type"=>8,
                        "fee_money"=>$order_total,
                        "title"=>"团购商品支付",
                        "beizhu"=>'余额支付',
                        "transaction_id"=>0,
                        "orderid"=>$orderid,
                        "userid"=>SYS_USERID,
                        "adminid"=>0,
                        "pay_type"=>1,
                        "store_id"=>$data['store_id']
                    );
                    $this->AddCommFee($_fee_array);
                    $this->GetDBMaster()->query("INSERT INTO ".TABLE_BALANCE_DETAILS." ".
                        " SET trans_terrace_orderid='".$orderid."',"
                        ." trans_title='拼团支付',trans_type=2,"
                        ." trans_money='".$order_total."',"
                        ." trans_wx_orderid='',"
                        ." trans_userid='".SYS_USERID."',"
                        ." trans_addtime='".date("Y-m-d H:i:s",time())."'");
                }
                $this->GetDBMaster()->SubmitTransaction();
                if($pay_status)
                {
                    //跳转到成功开团页面
                    redirect('?mod=weixin&v_mod=checkout&_index=_group_pay_result&orderid='.$orderid);
                }
                //微信支付
                redirect('?mod=weixin&v_mod=checkout&_index=_group_pay&orderid='.$orderid);
            }
        }catch (error $e)
        {
            $this->GetDBMaster()->RollbackTransaction();
            return $e->getMessage();
        }
    }



    //加入团购
    function ActionJoinGroup()
    {
        $info = $this->GetGroupJoin();
        if($info['code'])
        {
            return $info;
        }
        $data = $info['data'];
        if(!regExp::checkNULL($this->data['quantity']) || !is_numeric($this->data['quantity']))
        {
            return array('code'=>1,'msg'=>'产品数量错误');
        }
        if(!regExp::checkNULL($this->data['address_id']))
        {
            return array('code'=>1,'msg'=>'数量错误');
        }
        $quantity = intval($this->data['quantity']);
        //判断是否有属性
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." WHERE "
            ." product_id='".$data['product_id']."' AND is_del=0");
        $attr_id = $attr_name=array();
        if($attr)
        {
            if(!regExp::checkNULL($this->data['attr_id']))
            {
                return array('code'=>1,'msg'=>'请选择产品属性');
            }
            $attr_id_array = $attr_val_array=array();
            foreach($attr as $item)
            {
                $attr_id_array[] = $item['id'];
                $attr_val_array[$item['id']] = $item['attr_temp_name'];
            }
            foreach($this->data['attr_id'] as $k=>$val)
            {
                if(!in_array($val,$attr_id_array))
                {
                    return array('code'=>1,'msg'=>'产品属性'.$attr_val_array[$k].'已下架');
                }
                $attr_id[]= $val;
                $attr_name[]=addslashes($attr_val_array[$val]);
            }
        }
        if(!regExp::checkNULL($this->data['pay_method']))
        {
            return array('code'=>1,'msg'=>'请选择支付方式');
        }
        if(!regExp::checkNULL($this->data['address_id']))
        {
            return array('code'=>1,'msg'=>'请选择收货地址');
        }
        $address = module('address')->GetOneAddress($this->data['address_id']);
        if(empty($address))
        {
            return array('code'=>1,'msg'=>'地址无效');
        }
        $pro_total = $data['group_price'] * $quantity;
        if($data['free_fee'] || $pro_total>=$data['free_fee_money'])
        {
           $ship_total = 0;
        }else
        {
            $ship_total = $data['ship_fee_money'];
        }
        $order_total = $ship_total+$pro_total;
        $order_total = 0.01;
        $user = $this->GetUserInfo(SYS_USERID);
        if(trim($this->data['pay_method'])=='user_money')
        {
            if($user['user_money']<$order_total)
            {
                return array('code'=>1,'msg'=>'余额不足');
            }
            $pay_method = 'user_money';
        }else{
            $pay_method = 'wechat';
        }
        $pay_status = 0;
        $date = date("Y-m-d H:i:s",time());
        $this->GetDBMaster()->StartTransaction();
        try{
            //扣除余额
            if($pay_method=='user_money')
            {
                $user_before_money = $user['user_money']-$order_total;
                $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                    ." SET user_money='".$user_before_money."' "
                    ." WHERE userid='".SYS_USERID."'");
                $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP."  "
                    ." SET group_present_nums=group_present_nums-1,"
                    ." group_status=IF(group_present_nums=0,2,group_status)  "
                    ." WHERE group_id='".$this->data['gid']."'");
                if(!$res1 || !$res2)
                {
                    throw new error(array('code'=>1,'msg'=>'余额支付失败'));
                }
                $pay_status = 1;
            }
            $orderid = $this->OrderMakeOrderId();
            $address_location = explode(' ',$address['address_location']);
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ORDER_GROUP." "
                ."(group_id,userid,product_id,product_count,group_total,shop_name,"
                ."shop_phone,shop_province,shop_city,shop_area,shop_address,product_img,"
                ."pay_status,orderid,addtime,pay_method,store_id,group_buy_type,ship_fee,"
                ."attr_id,atrr_name,group_price,pro_name)"
                ." VALUES('".$data['group_id']."','".SYS_USERID."','".$data['product_id']."',"
                ."'".$quantity."','".$order_total."','".$address['shop_name']."',"
                ."'".$address['shop_phone']."','".$address_location[0]."',"
                ."'".$address_location[1]."','".$address_location[2]."',"
                ."'".$address['address_details']."','".$data['product_img']."',"
                ."'".$pay_status."','".$orderid."','".$date."','".$pay_method."',"
                ."'".$data['store_id']."',0,'".$ship_total."','".implode(',',$attr_id)."',"
                ."'".implode(',',$attr_name)."','".$data['group_price']."','".$data['product_name']."')");
            if($id)
            {
                $this->GetDBMaster()->SubmitTransaction();
                if($pay_status)
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GROUP." SET pay_date='".$date."',"
                        ." pay_money='".$order_total."',pay_date='".date("Y-m-d H:i:s",time())."' "
                        ." WHERE orderid='".$orderid."'");
                    $_fee_array=array(
                        "fee_type"=>8,
                        "fee_money"=>$order_total,
                        "title"=>"团购商品支付",
                        "beizhu"=>'余额支付',
                        "transaction_id"=>0,
                        "orderid"=>$orderid,
                        "userid"=>SYS_USERID,
                        "adminid"=>0,
                        "pay_type"=>0,
                        "store_id"=>$data['store_id']
                    );
                    $this->AddCommFee($_fee_array);
                    $this->GetDBMaster()->query("INSERT INTO ".TABLE_BALANCE_DETAILS." ".
                        " SET trans_terrace_orderid='".$orderid."',"
                        ." trans_title='拼团支付',trans_type=2,"
                        ." trans_money='".$order_total."',"
                        ." trans_wx_orderid='',"
                        ." trans_userid='".SYS_USERID."',"
                        ." trans_addtime='".date("Y-m-d H:i:s",time())."'");
                    //跳转到成功开团页面
                    redirect('?mod=weixin&v_mod=checkout&_index=_group_pay_result&orderid='.$orderid);
                }
                //微信支付
                redirect('?mod=weixin&v_mod=checkout&_index=_group_pay&orderid='.$orderid);
            }
        }catch (Exception $e)
        {
            $this->GetDBMaster()->RollbackTransaction();
            return $e->getMessage();
        }
    }

    //检查结算的合法性
    function ActionCheckData($data)
    {
        if(empty($data['cart']['cart']))
        {
            return array('code'=>1,'msg'=>'没有结算的数据');
        }
        if(!regExp::checkNULL($this->data['pay_method']))
        {
            return array('code'=>1,'msg'=>'请选择付款方式');
        }
        if(empty($data['address']))
        {
            return array('code'=>1,'msg'=>'暂无收货地址');
        }
        $address_id = array();
        if (!empty($data['address']))
        {
            foreach($data['address'] as $item)
            {
                $address_id[] = $item['id'];
            }
        }

        if (!isset($this->data['address_id']))
        {
            return array('code'=>1,'msg'=>'请选择一个地址');
        }
        if(!is_numeric($this->data['address_id']) || !in_array($this->data['address_id'],$address_id))
        {
            return array('code'=>1,'msg'=>'无效的收货地址');
        }
    }

    //结算选择优惠券操作
    function ActionSelectCoupon()
    {
        $cart_obj = new cart($this->data);
        $cart_data = $cart_obj->GetCartList(true);
        $coupon = $this->GetValidCoupon($cart_data['goods_postage'],$cart_data['select_money']);
        $use_coupon=array();
        foreach($coupon['valid_coupon'] as $item)
        {
            if (isset($_POST['coupon_'.$item['store_id']]) && $_POST['coupon_'.$item['store_id']]==$item['id'])
            {
                $use_coupon[]=$item['id'];
            }
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON." SET select_status=0"
            ." WHERE userid='".SYS_USERID."'");
        if (!empty($use_coupon))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON." SET select_status=1"
                ." WHERE userid='".SYS_USERID."' AND id IN (".implode(',',$use_coupon).")");
        }
        $select = '';
        $select .= (isset($_GET['pay'])?'&pay='.$_GET['pay']:'').(isset($_GET['area'])?'&area='.$_GET['area']:'');
        redirect('/?mod=weixin&v_mod=checkout'.$select);
    }




    //使用余额付款
    function ActionUserMoneyPay()
    {
        if(!regExp::checkNULL($this->data['orderid']) ||
            !regExp::checkNULL($this->data['shop_id']) ||
            !regExp::checkNULL($this->data['pay_way']) ||
            $this->data['pay_way']!='user_money')
        {
            return array('code'=>1,'msg'=>'error');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER_SHOP." WHERE "
            ." orderid='".$this->data['orderid']."' AND shop_id='".$this->data['shop_id']."' "
            ." AND userid='".SYS_USERID."'");
        if(!$data)
        {
            return array('code'=>1,'msg'=>'未找到此订单或订单已删除');
        }elseif($data['order_status']!=1)
        {
            return array('code'=>1,'msg'=>'订单已支付或状态已更新');
        }
        $user = $this->GetUserInfo(SYS_USERID);
        if($data['total_money']>$user['user_money'])
        {
            return array('code'=>1,'msg'=>'余额不足以支付');
        }
        $this->GetDBMaster()->StartTransaction();

        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
            ." user_money=IF(user_money>='".$data['total_money']."',user_money-'".$data['total_money']."',user_money) "
            ." WHERE userid='".SYS_USERID."'");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET order_status=3,"
            ."pay_method='user_money',pay_datetime='".date("Y-m-d H:i:s",time())."',"
            ."pay_money='".$data['total_money']."',is_pay_shop=1 WHERE id='".$data['id']."'");
        $res3 = $this->GetDBMaster()->query("INSERT INTO ".TABLE_BALANCE_DETAILS." ".
            " SET trans_terrace_orderid='".($data['orderid'].'_'.$data['id'])."',"
            ." trans_title='下单支付',trans_type=2,"
            ." trans_money='".$data['total_money']."',"
            ." trans_wx_orderid='',"
            ." trans_userid='".SYS_USERID."',"
            ." trans_addtime='".date("Y-m-d H:i:s",time())."'");
        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER." SET is_all_pay=2,allow_pay=1 "
            ." WHERE orderid='".$data['orderid']."'");
        //添加销量
        $pro_list = $this->GetDBSlave1()->queryrows("SELECT product_id,product_count FROM ".TABLE_O_ORDER_GOODS." "
            ." WHERE orderid='".$data['orderid']."' AND shop_id='".$data['shop_id']."'");
        foreach($pro_list as $k=>$v)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET product_sold=product_sold+'".$v['product_count']."' "
                ." WHERE product_id='".$v['product_id']."'");
        }
        if($res1 && $res2 && $res3)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'余额支付成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'余额支付失败');
    }
}