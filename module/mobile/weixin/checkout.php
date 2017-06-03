<?php
include_once RPC_DIR.'/module/mobile/weixin/cart.php';
include_once RPC_DIR.'/module/mobile/weixin/address.php';
class checkout extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    function GetCheckOutCartData()
    {
        $array = array();
        $cart_obj = new cart($this->data);
        $address_obj = new address($this->data);
        $cart_data = $cart_obj->GetCartList(true);
        $address = $address_obj->GetShipAddress();
        $array['user'] = $user = $this->GetUserInfo(SYS_USERID);
        $array['cart'] = $cart_data;
        $array['coupon'] = $this->GetValidCoupon($cart_data['goods_postage'],$cart_data['select_money']);
        $array['address'] = $address;
        return $array;
    }
    function GetOneOrder()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            redirect(NOFOUND.'&msg=单号错误');
        }
        if(isset($this->data['shop_id']) && is_numeric($this->data['shop_id']))
        {
            $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER_SHOP." "
                ." WHERE orderid='".$this->data['orderid']."' AND shop_id='".$this->data['shop_id']."' "
                ." AND userid='".SYS_USERID."'  ");
        }else{
            $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER."  "
                ." WHERE orderid='".$this->data['orderid']."' AND userid='".SYS_USERID."'");
        }
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=订单不存在');
        }
        return $data;
    }


    //获取团购商品
    function GetGroupProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT GP.product_id,GP.people_nums,GP.allow_buy_nums,GP.group_price,"
            ." P.product_name,P.product_desc,P.product_img,P.product_status,S.store_logo,S.store_name,S.free_fee,"
            ." S.free_fee_money,S.ship_fee_money FROM ".TABLE_GROUP_PRODUCT." AS GP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON GP.product_id=P.product_id "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON GP.store_id=S.store_id "
            ." WHERE GP.product_id='".$this->data['id']."'");
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=团购不存在');
        }
        if($data['product_status'])
        {
            redirect(NOFOUND.'&msg=产品已下架');
        }
        return $data;
    }

    //待支付团购订单查询
    function GetGroupBuy()
    {
        //查询团购订单
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER_GROUP." WHERE "
            ." orderid='".$this->data['orderid']."' AND userid='".SYS_USERID."'");
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=订单不存在');
        }
        $group_buy = $this->GetDBSlave1()->queryrow("SELECT GP.product_id,GP.people_nums,GP.allow_buy_nums,GP.group_price,"
            ." P.product_name,P.product_desc,P.product_img,P.product_status,S.store_logo,S.store_name,S.free_fee,"
            ." S.free_fee_money FROM ".TABLE_GROUP_PRODUCT." AS GP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON GP.product_id=P.product_id "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON GP.store_id=S.store_id "
            ." WHERE GP.product_id='".$data['product_id']."'");
        if(empty($group_buy))
        {
            redirect(NOFOUND.'&msg=团购已结束');
        }
        if($group_buy['product_status'])
        {
            redirect(NOFOUND.'&msg=产品已下架');
        }
        //如果是加入 避免重复加入
        if($data['group_buy_type']==0)
        {
            $join = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER_GROUP."  "
                ." WHERE group_id='".$data['group_id']."' "
                ." AND userid='".SYS_USERID."' "
                ." AND pay_status=1");
            if($join)
            {
                redirect(NOFOUND.'&msg=订单已失效');
            }
        }
        if($data['pay_status'])
        {
            redirect(NOFOUND.'&msg=订单已支付，请勿重复支付');
        }
        return $data;
    }


    //团购支付订单查询
    function GetGroupBuyRes()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            redirect(NOFOUND.'&msg=订单号不存在');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER_GROUP."  "
            ." WHERE orderid='".$this->data['orderid']."' "
            ." AND userid='".SYS_USERID."'");
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=订单记录不存在');
        }
        return $data;
    }

    //参团订单查询
    function GetGroupJoin()
    {
        if(!regExp::checkNULL($this->data['gid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT GB.*,GP.people_nums,GP.allow_buy_nums,"
            ."P.product_name,P.product_desc,P.product_img,P.product_status,P.business_buy,S.store_logo,"
            ."S.store_name,S.free_fee,S.free_fee_money,S.store_id,S.ship_fee_money FROM "
            ."".TABLE_GROUP." AS GB LEFT JOIN ".TABLE_GROUP_PRODUCT." AS GP ON  "
            ."GB.product_id=GP.product_id LEFT JOIN ".TABLE_PRODUCT." AS P ON "
            ."GP.product_id=P.product_id LEFT JOIN ".TABLE_COMM_STORE." AS "
            ."S ON P.store_id=S.store_id WHERE GB.group_id='".$this->data['gid']."' "
            ."AND GB.group_status=1");
        //判断是否已经参与了
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'团购不存在');
        }elseif($data['group_status']==0)
        {
            return array('code'=>1,'msg'=>'团购无效');
        }elseif($data['group_status']==2)
        {
            return array('code'=>1,'msg'=>'团购已完成');
        }elseif($data['end_time']<date("Y-m-d H:i:s",time()) || $data['group_status']==-1)
        {
            return array('code'=>1,'msg'=>'团购已结束');
        }

        if ($data['business_buy'])
        {
            //商家专享权限判断
            $user=$this->GetUserWxDetail(SYS_USERID);
            if ($user['vip_lv']<$data['business_buy'])
            {
                return array('code'=>1,'msg'=>'该商品为商家专享，您暂无购买权限');
            }
        }

        $check = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER_GROUP." WHERE "
            ." group_id='".$this->data['gid']."' "
            ." AND pay_status=1 "
            ." AND userid='".SYS_USERID."'");
        if($check)
        {
            return array('code'=>1,'msg'=>'已经参与过了');
        }
        return array('code'=>0,'data'=>$data);
    }

    //订单店家支付
    function GetOrderPayByShop()
    {
        if(!regExp::checkNULL($this->data['orderid']) ||
        !regExp::checkNULL($this->data['shop_id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT OS.*,S.store_name,S.store_logo FROM "
            ." ".TABLE_O_ORDER_SHOP." AS OS LEFT JOIN ".TABLE_COMM_STORE." AS S ON "
            ." OS.shop_id=S.store_id WHERE OS.orderid='".$this->data['orderid']."' "
            ." AND OS.shop_id='".$this->data['shop_id']."' AND OS.userid='".SYS_USERID."'");
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'订单是不存在');
        }elseif ($data['order_status']>=3)
        {
            return array('code'=>1,'msg'=>'订单已支付');
        }
        return array('code'=>0,'data'=>$data);
    }


    //查询出可用优惠券
    protected  function GetValidCoupon($shop_money=array(),$all_total=0)
    {
        $coupon=$this->GetDBSlave1()->queryrows("SELECT C.* FROM ".TABLE_COUPON." AS C "
            ." WHERE C.userid='".SYS_USERID."' "
            ." AND C.use_status=0 "
            ." AND C.expire_time>='".date("Y-m-d")."'");
        $return=$use=$invalid=$universal_select=$universal=array();
        $use_coupon_money=$use_coupon_count=$universal_coupon=$universal_money=0;
        if (!empty($coupon))
        {
               foreach($coupon as $item)
               {
                       if ($item['store_id']>0)
                       {
                           if (isset($shop_money[$item['store_id']]['valid_coupon_total']) && $shop_money[$item['store_id']]['valid_coupon_total']>=$item['min_money'])
                           {
                               //店铺券
                               $return[]=$item;
                               if ($item['select_status'])
                               {
                                   //已使用
                                   $use[$item['store_id']]['coupon_money']=$item['coupon_money'];
                                   $use[$item['store_id']]['coupon_id']=$item['id'];
                               }
                           }else
                           {
                               $invalid[]=$item;
                           }
                       }
                    else
                    {
                        //通用券
                        $universal[]=$item;
                        $universal_select['valid_coupon_total']=0;
                        /*if ($item['select_status'])
                        {
                            //应该只有一张通用券可被选中
                            $universal_select=$item;

                        }*/
                    }
               }
           }

            //通用券分配给谁
            if (!empty($universal))
            {
                foreach($shop_money as $k=>$v)
                {
                    //通用券循环判断
                    foreach($universal as $item)
                    {
                        //商家没有用自己的券，商家有效的购物金额累计大于优惠券的金额
                        if (!isset($use[$k]['coupon_id']) && $v['valid_coupon_total']>=$item['min_money'] && $v['valid_coupon_total']>$universal_select['valid_coupon_total'])
                        {
                            $universal_select['valid_coupon_total']=$v['valid_coupon_total'];
                            $universal_select['store_id']=$k;
                            $universal_select['coupon']=$item;
                        }
                    }
                }

                if (!empty($universal_select['store_id']))
                {
                    $use[$universal_select['store_id']]=$universal_select['coupon'];
                }

                //计算出可用优惠券
                foreach($universal as $item)
                {
                    if ($item['min_money']<=$universal_select['valid_coupon_total'])
                    {
                        $return[]=$item;
                    }
                }
            }

           //取出已经使用到的
           if (!empty($use))
           {
              foreach($use as $k=>$v)
              {
                  $use_coupon_money+=$v['coupon_money'];
                  $use_coupon_count+=1;
              }
           }

        return array("invalid"=>$invalid,"valid_coupon"=>$return,
            "use_coupon"=>array("data"=>$use,
            "use_coupon_money"=>$use_coupon_money,
            "use_coupon_count"=>$use_coupon_count));
    }

    //获取会员折扣券百分比
    function GetDiscountCouponPer()
    {
        $conf=$this->GetCommonConf(8);
        if ($conf['conf_number']>0 && $conf['conf_number']<100)
        {
            return $conf['conf_number']/100;
        }else
        {
            return 0;
        }
    }


    function GetAgentData()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=error');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT AC.*,AP.product_id,AP.agent_price,P.product_name,"
            ."P.product_img,P.product_price,S.store_name,S.store_logo,S.free_fee,S.ship_fee_money,S.free_fee_money,S.product_ship_fee "
            ."FROM ".TABLE_AGENT_CART." AS AC "
            ."LEFT JOIN ".TABLE_PRODUCT_AGENT." AS AP ON AC.agent_id=AP.product_id LEFT JOIN "
            ."".TABLE_PRODUCT." AS P ON AC.agent_id=P.product_id LEFT JOIN ".TABLE_COMM_STORE." AS S "
            ."ON AC.store_id=S.store_id "
            ."WHERE AC.id='".$this->data['id']."' AND AC.status=0");
        if(!$data)
        {
            redirect(NOFOUND.'&msg=error');
        }
        if($data['attr_id'])
        {
            $attr = $this->GetDBSlave1()->queryrow("SELECT MAX(attr_change_price) AS attr_price FROM "
                ." ".TABLE_ATTR." WHERE id IN(".$data['attr_id'].")");
            if(!$attr)
            {
                redirect(NOFOUND.'&msg=属性不存在或已经下架');
            }
            $agent_price = $attr['attr_price'];
        }else{
            $agent_price = $data['agent_price'];
        }
        $pro_total = round($data['product_count'] * ($agent_price * ($data['agent_price']/$data['product_price'])),2);
        $agent_price = round($agent_price * ($data['agent_price']/$data['product_price']),2);
        $data['agent_price'] = $agent_price;
        $data['pro_total'] = $pro_total;
        $data['postage_total']=0;
        $data['user']=$this->GetUserWxDetail(SYS_USERID);
        if ($data['free_fee'] && $data['pro_total']>=$data['free_fee_money'])
        {
            $data['postage_total']=0;
        }else
        {
            //假如开启了单品运费，查出本店最高那个作为运费
            if ($data['product_ship_fee'])
            {
                if ($data['product_ship_fee']<=$data['ship_fee'])
                {
                    $data['postage_total']=$data['ship_fee'];
                }
            }else
            {
                $data['postage_total']=$data['ship_fee_money'];
            }
        }
        return $data;
    }
}