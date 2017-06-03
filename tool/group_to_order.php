<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
include '../config_wx.php';
include RPC_DIR .'/conf/conf.php';
include RPC_DIR .'/conf/config.php';
include RPC_DIR .'/module/common/common.php';
include RPC_DIR .'/module/common/common_wx.php';
/*
 * 自动生成团购订单
 * */
class auto extends wx
{
    const TEMPLATE_SUCCESS = 'lS8uxmdpAFsbL1u5WU6ogd5ilDibXIUrBczTfVfDgwg';
    const TEMPLATE_FAIL = 'ZM6dqz7vQulZGssJ4ZEv8u7MH5dJj28NYeBj8DVABA8';
    function __construct($data)
    {
        parent::__construct($data);
        $this->generateGroupOrder(); //创建订单
        $this->changeFailGroup();   //更改失败订单状态
        $this->GroupRefund();
    }

    //获取成功的团购订单
    function getSuccessGroup()
    {
        return $this->GetDBSlave1()->queryrow("SELECT G.*,P.product_name FROM ".TABLE_GROUP." "
            ." AS G LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id=P.product_id WHERE "
            ." G.group_status=2 AND G.to_order=0 ORDER BY id ASC LIMIT 1");
    }

    //团购失败订单
    function getFailGroup()
    {
        return $this->GetDBSlave1()->queryrow("SELECT G.*,P.product_name FROM ".TABLE_GROUP." "
            ." AS G LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id=P.product_id WHERE "
            ." G.group_status=1 AND G.to_order=0 AND G.end_time<'".date("Y-m-d H:i:s",time())."'"
            ." ORDER BY id ASC LIMIT 1");
    }

    //生成团购订单
    function generateGroupOrder()
    {
        $group = $this->getSuccessGroup();
        if(empty($group))
        {
            return false;
        }
        //查询成功的订单
        $list = $this->GetGroupList($group['group_id']);
        $this->GetDBMaster()->StartTransaction();
        //查询产品信息
        $date = date("Y-m-d H:i:s",time());
        $pro_count = 0;
        $arr = array();
        $arr['pro_name'] = $group['product_name'];
        $arr['group_id'] = $group['group_id'];
        try{
            $liuyan = '暂无';
            foreach($list as $item)
            {
                $arr['touser'][] = $item['openid'];
                $arr['orderid'][] = $item['orderid'];
                $arr['money'][] = $item['group_total'];
                //写入订单
                $res1 = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_ORDER_GOODS." "
                    ."(orderid,product_id,shop_id,product_count,product_name,product_price,"
                    ."product_sum_price,product_img,userid,addtime,product_attr_name,"
                    ."product_attr_id) VALUES('".$item['orderid']."','".$item['product_id']."',"
                    ."'".$item['store_id']."','".$item['product_count']."','".$item['pro_name']."',"
                    ."'".$item['group_price']."','".$item['product_count']*$item['group_price']."',"
                    ."'".$item['product_img']."','".$item['userid']."','".$date."',"
                    ."'".$item['atrr_name']."','".$item['attr_id']."')");
                if(!$res1)
                {
                    throw new Exception('产品写入失败');
                }
                $res2 = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_ORDER_SHOP." "
                    ."(orderid,shop_id,userid,pro_count,total_pro_money,total_money,addtime,"
                    ."order_status,pro_fee,order_type,ship_name,ship_phone,ship_province,"
                    ."ship_city,ship_area,ship_address,pay_method) VALUES('".$item['orderid']."',"
                    ."'".$item['store_id']."','".$item['userid']."','".$item['product_count']."',"
                    ."'".$item['product_count']*$item['group_price']."','".$item['group_total']."',"
                    ."'".$date."',3,'".$item['ship_fee']."',1,'".$item['shop_name']."',"
                    ."'".$item['shop_phone']."','".$item['shop_province']."','".$item['shop_city']."',"
                    ."'".$item['shop_area']."','".$item['shop_address']."','".$item['pay_method']."')");
                if(!$res2)
                {
                    throw new Exception('店铺订单写入失败');
                }
                $res3 = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_ORDER."(orderid,userid,"
                    ."total_money,pro_count,shop_count,freight_money,pay_method,"
                    ."order_ship_name,order_ship_phone,order_ship_sheng,order_ship_shi,order_ship_qu,"
                    ."order_ship_address,order_img,order_addtime,order_status,liuyan,order_type)"
                    ." VALUES('".$item['orderid']."','".$item['userid']."','".$item['group_total']."',"
                    ."'".$item['product_count']."',1,"
                    ."'".$item['ship_fee']."','".$item['pay_method']."','".$item['shop_name']."',"
                    ."'".$item['shop_phone']."','".$item['shop_province']."','".$item['shop_city']."',"
                    ."'".$item['shop_area']."','".$item['shop_address']."',"
                    ."'".$item['product_img']."','".$date."',3,'".$liuyan."',1)");
                if(!$res3)
                {
                    throw new Exception('总订单写入失败');
                }
                if(!$res1 || !$res2 || !$res3)
                {
                    throw new Exception('团购订单生成失败 ');
                }
                $pro_count += $item['product_count'];
            }
            /*更改订单状态*/
            $res4 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GROUP." SET "
                ."to_order=1 WHERE group_id='".$group['group_id']."'");
            $res5 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." SET to_order=1,"
                ." sold_pro_nums='".$pro_count."' "
                ." WHERE id='".$group['id']."'");
            /*增加团购销量*/
            $res6 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP_PRODUCT." SET "
                ." group_sold=group_sold+".$pro_count." WHERE product_id='".$group['product_id']."'");
            /*增加总销量*/
            $res7 = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
                ." product_sold=product_sold+".$pro_count." WHERE  "
                ." product_id='".$group['product_id']."'");
            if(!$res4)
            {
                throw new Exception('更改团购单状态失败');
            }
            if(!$res5)
            {
                throw new Exception('更改团购状态失败');
            }
            if(!$res6)
            {
                throw new Exception('增加团购销量失败');
            }
            if(!$res7)
            {
                throw new Exception('增加总销量失败');
            }
            //发送团购成功消息
            $this->GetDBMaster()->SubmitTransaction();
            $this->SendGroupBuySuccessNotice($arr);
        }catch (Exception $e)
        {
            $this->GetDBMaster()->RollbackTransaction();
            $this->AddLogAlert('团购成功订单'.$group['group_id'],$e->getMessage());
            return $e->getMessage();
        }
    }



    //更改失败订单状态
    function changeFailGroup()
    {
        //失败团购
        $data = $this->getFailGroup();
        if(!$data)
        {
            return false;
        }
        //查询列表
        $list = $this->GetGroupList($data['group_id']);
        if(!$list)
        {
            return false;
        }
        $this->GetDBMaster()->StartTransaction();
        try{
            $date = date("Y-m-d H:i:s",time());
            $tran_desc = '团购退款';
            $arr = array();
            $arr['group_id'] = $data['group_id'];
            $arr['pro_name'] = $data['product_name'];
            foreach($list as $item)
            {
                $arr['touser'][] = $item['openid'];
                $arr['money'][] = $item['group_total'];
                //余额支付
                if(trim($item['pay_method'])=='user_money')
                {
                    //余额 退款
                    $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_REFUND." "
                        ." SET userid='".$item['userid']."',orderid='".$item['orderid']."',"
                        ." refund_money='".$item['group_total']."',refund_status=2,"
                        ." addtime='".$date."',type_id=8");
                    $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET  "
                        ."user_money=user_money+'".$item['group_total']."' WHERE userid='".$item['userid']."'");
                    $this->GetDBMaster()->query("INSERT INTO ".TABLE_BALANCE_DETAILS." ".
                        " SET trans_terrace_orderid='".$item['orderid']."',"
                        ." trans_title='拼团失败退款',trans_type=1,"
                        ." trans_money='".$item['group_total']."',"
                        ." trans_wx_orderid='',"
                        ." trans_userid='".$item['userid']."',"
                        ." trans_addtime='".date("Y-m-d H:i:s",time())."'");
                    $_fee_array=array(
                        "fee_type"=>8,
                        "fee_money"=>$item['group_total'],
                        "title"=>"团购退款",
                        "beizhu"=>'余额退款',
                        "transaction_id"=>0,
                        "orderid"=>$item['orderid'],
                        "userid"=>$item['userid'],
                        "adminid"=>0,
                        "pay_type"=>0,
                        'store_id'=>$data['store_id']
                    );
                    $res4 = $this->AddCommFee($_fee_array);
                    if(!$res || !$res1 || !$res4)
                    {
                        throw new Exception('余额明细写入失败');
                    }
                }else{
                    //微信支付 退款
                    $res = $this->GetDBMaster()->query("INSERT INTO ".TABLE_REFUND." "
                        ." SET userid='".$item['userid']."',orderid='".$item['orderid']."',"
                        ." refund_money='".$item['group_total']."',refund_status=0,"
                        ." addtime='".$date."',type_id=9");
                    $_fee_array=array(
                        "fee_type"=>9,
                        "fee_money"=>$item['group_total'],
                        "title"=>"团购退款",
                        "beizhu"=>'微信退款',
                        "transaction_id"=>0,
                        "orderid"=>$item['orderid'],
                        "userid"=>$item['userid'],
                        "adminid"=>0,
                        "pay_type"=>1,
                        'store_id'=>$data['store_id']
                    );
                    $res4 = $this->AddCommFee($_fee_array);
                    if(!$res && !$res4)
                    {
                        throw new Exception('生成退款信息失败');
                    }
                }
                //更新状态
                $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." SET group_status=-1 "
                    ." WHERE id='".$data['id']."'");
                //发送失败通知
                if(!$res2)
                {
                    throw new Exception('更新状态失败');
                }
                $this->GetDBMaster()->SubmitTransaction();
                $this->SendGroupBuyFailNotice($arr);
            }
        }catch (Exception $e)
        {
            $this->GetDBMaster()->RollbackTransaction();
            $this->AddLogAlert('团购失败订单'.$data['group_id'],$e->getMessage());
            return $e->getMessage();
        }
    }


    function GetGroupList($group_id)
    {
        return $this->GetDBSlave1()->queryrows("SELECT OG.*,U.openid FROM ".TABLE_ORDER_GROUP." "
            ." AS OG LEFT JOIN ".TABLE_USER." AS U ON OG.userid=U.userid WHERE OG.group_id='".$group_id."' "
            ." AND OG.pay_status=1 AND OG.to_order=0");
    }

    function GetProduct($product_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$product_id."'");
    }



    /*--------------------------退款-微信-----------------------------------*/

    function GroupRefund()
    {
        require_once RPC_DIR.'/pay/weixin/wechat_refund.php';
        $refund = new WeChat_Refund('GroupBuyRefund','团购退款');
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_REFUND." WHERE "
            ." refund_order_type=0 AND type_id=9 AND refund_status=0 ORDER BY id ASC");
        if(!$data)
        {
            return;
        }
        $array = array(
            'out_trade_no'=>$data['orderid'],
            'total_fee'=>$data['refund_money'],
            'refund_fee'=>$data['refund_money']-$data['already_refund_money'],
            'op_user_id'=>$data['orderid']
        );
        $refund->init($array);
    }



    /*-------------------------发送消息----------------------------*/
    //成功消息
    function SendGroupBuySuccessNotice($array)
    {
        $title = '您参团的商品［'.$array['pro_name'].'］已组团成功请注意查收！';
        $wx = new wx('');
        $access_token = $wx->Get_access_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token['access_token'];
        for ($i=0;$i<count($array['touser']);$i++)
        {
            $data = array(
                'touser'=>$array['touser'][$i],
                'template_id'=>auto::TEMPLATE_SUCCESS,
                'url'=>WEBURL.'/?mod=weixin&v_mod=group&_index=_buy&group_id='.$array['group_id'],
                'data'=>array(
                    'first'=>array('value'=>$title,'color'=>'#173177'),
                    'keyword1'=>array('value'=>$array['money'][$i].'元','color'=>'#173177'),
                    'keyword2'=>array('value'=>$array['orderid'][$i],'color'=>'#173177'),
                    'remark'=>array('value'=>'预计1-3个工作日发货','color'=>'#173177'),
                )
            );

            $res = json_decode(doCurlPostRequest($url,json_encode($data,true)),true);
            if($res['errcode']>0)
            {
                $this->AddLogAlert('团购订单成功提醒','openid：'.$array['touser'][$i].'发送失败');
            }
        }
    }

    function SendGroupBuyFailNotice($array)
    {
        $title = '您好，您参加的拼团由于团已过期，拼团失败！';
        $wx = new wx('');
        $access_token = $wx->Get_access_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token['access_token'];
        for ($i=0;$i<count($array['touser']);$i++)
        {
            $data = array(
                'touser'=>$array['touser'][$i],
                'template_id'=>auto::TEMPLATE_FAIL,
                'url'=>'',
                'data'=>array(
                    'first'=>array('value'=>$title,'color'=>'#173177'),
                    'keyword1'=>array('value'=>$array['pro_name'].'元','color'=>'#173177'),
                    'keyword2'=>array('value'=>$array['money'][$i],'color'=>'#173177'),
                    'keyword3'=>array('value'=>$array['money'][$i],'color'=>'#173177'),
                    'remark'=>array('value'=>'您的退款已经提交平台审核，感谢您的参与！','color'=>'#173177'),
                )
            );
            $res = json_decode(doCurlPostRequest($url,json_encode($data,true)),true);
            if($res['errcode']>0)
            {
                $this->AddLogAlert('团购订单失败提醒','openid：'.$array['touser'][$i].'发送失败');
            }
        }
    }
}
$auto = new auto('');