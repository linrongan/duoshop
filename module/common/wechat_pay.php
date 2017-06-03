<?php
error_reporting(0);
require_once RPC_DIR.'/pay/weixin/WxPayPubHelper/WxPayPubHelper.php';
class wechat_pay extends common
{
    //公用微信支付通用
    public function WeChatPay($array)
    {
        $jsApi = new JsApi_pub();
        $openid=$_SESSION['openid'];
        $unifiedOrder = new UnifiedOrder_pub();
        $unifiedOrder->setParameter("openid","$openid");
        $unifiedOrder->setParameter("body",isset($array['pay_body'])?$array['pay_body']:"订单支付");
        $unifiedOrder->setParameter("out_trade_no",$array['out_trade_no']);//商户订单号
        $unifiedOrder->setParameter("total_fee",$array['total_fee']*100);//总金额
        $unifiedOrder->setParameter("notify_url",$array['notify_url']);//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
        $prepay_id = $unifiedOrder->getPrepayId();
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = $jsApi->getParameters();
        return $jsApiParameters;
    }

    //产品直接购买回调
    function PayProductCallBack()
    {
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL") {
                //通信出错
                $log='交易号'.$return['out_trade_no'].'出现异常';
            }elseif($notify->data["result_code"] == "FAIL"){
                $log='交易号'.$return['out_trade_no'].'业务错误';
            }else{
                $money=$return['total_fee']/100;//支付金额
                $pay_order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER."  "
                    ." WHERE orderid='".$return['out_trade_no']."'");
                try{
                    if(empty($pay_order))
                    {
                        throw new Exception('没有找到订单');
                    }elseif($pay_order['order_status']>=3)
                    {
                        throw new Exception('订单状态已支付');
                    }elseif($pay_order['pay_method']!='wechat')
                    {
                        throw new Exception('非微信支付订单');
                    }else
                    {
                        $this->GetDBMaster()->StartTransaction();
                        //标记订单为支付状态
                        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER." "
                            ." SET allow_pay=1,pay_money='".$money."',order_status=3,"
                            ." pay_addtime='".date("Y-m-d H:i:s")."',is_all_pay=1 "
                            ." WHERE orderid='".$return['out_trade_no']."'");
                        //更新商家订单状态
                        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP."  "
                            ." SET order_status=3,pay_datetime='".date("Y-m-d H:i:s",time())."',"
                            ." pay_money=total_money,is_pay_shop=2"
                            ." WHERE orderid='".$return['out_trade_no']."'");

                        //更新进交易表内
                        $this->AddDiscountCouponLog(array("store_id"=>0,
                            "userid"=>$pay_order['userid'],
                            "money"=>$pay_order['gift_balance'],
                            "orderid"=>$return['out_trade_no'],
                            "order_type"=>3,
                            "admin_id"=>0));

                        //交易记录开始
                        $_fee_array=array(
                            "fee_type"=>2,
                            "fee_money"=>$money,
                            "title"=>"普通商品支付",
                            "beizhu"=>json_encode($pay_order),
                            "transaction_id"=>$return['transaction_id'],
                            "orderid"=>$return['out_trade_no'],
                            "userid"=>$pay_order['userid'],
                            "adminid"=>0,
                            "pay_type"=>1
                        );
                        $id=$this->AddCommFee($_fee_array);
                        if ($id)
                        {
                            $this->GetDBMaster()->SubmitTransaction();
                            $this->UpdateOrderProductSold($return['out_trade_no']);
                        }
                        else
                        {
                            $this->GetDBMaster()->RollbackTransaction();
                        }
                    }
                }catch (Exception $e)
                {
                    $this->AddLogAlert('普通商品支付订单异常:',$e->getMessage());
                }
            }
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }

    //支付成功更新商品的销量和实际库存
    private function UpdateOrderProductSold($orderid=0)
    {
        $goods = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_ORDER_GOODS."  "
            ." WHERE orderid='".$orderid."'");
        if (!empty($goods))
        {
            $this->GetDBMaster()->SubmitTransaction();
            foreach($goods as $item)
            {
                $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT."  "
                    ." SET product_sold=product_sold=+".$item['product_count'].""
                    ." WHERE product_id='".$item['product_id']."'");
                if (empty($item['product_attr_id']))
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." "
                        ." SET product_stock=product_stock-".$item['product_count'].""
                        ." WHERE product_id='".$item['product_id']."'");
                }else
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR." "
                        ." SET product_sold=product_sold=+".$item['product_count'].","
                        ." product_stock=product_stock-".$item['product_count'].""
                        ." WHERE product_id='".$item['product_id']."' AND IN (".$item['product_attr_id'].")");
                }
            }
            $this->GetDBMaster()->SubmitTransaction();
        }
    }


    /**
     * 余额充值
     */
    public function RechargeCallBack()
    {
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL")
            {
                throw new Exception('交易失败'.$return['out_trade_no']);
            }else{
                $money=$return['total_fee']/100;//支付金额
                $pay_order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_RECHARGE."  "
                    ." WHERE recharge_orderid='".$return['out_trade_no']."'");
                try{
                    if(empty($pay_order))
                    {
                        throw new Exception('没有找到订单号'.$return['out_trade_no']);
                    }elseif($pay_order['recharge_status']>0)
                    {
                        throw new Exception('该充值订单号已经充值过了'.$return['out_trade_no']);
                    }
                    $this->GetDBMaster()->StartTransaction();
                    //更新余额
                    $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
                        ." user_money=user_money+'".$pay_order['recharge_money']."' "
                        ." WHERE userid='".$pay_order['recharge_userid']."' ");
                    $this->GetDBMaster()->query("UPDATE ".TABLE_RECHARGE." "
                        ." SET recharge_status=1,pay_methed='wechat',"
                        ." recharge_status_text='充值成功',"
                        ." recharge_addtime='".date("Y-m-d H:i:s")."',"
                        ." pay_money='".$money."',"
                        ." transaction_id='".$return['transaction_id']."' "
                        ." WHERE recharge_orderid='".$return['out_trade_no']."'");

                    //生成余额消费明细
                    $this->GetDBMaster()->query("INSERT INTO ".TABLE_BALANCE_DETAILS." ".
                        " SET trans_terrace_orderid='".$return['out_trade_no']."',"
                        ." trans_title='余额充值',trans_type=1,"
                        ." trans_money='".$money."',trans_wx_orderid='".$return['transaction_id']."',"
                        ." trans_userid='".$pay_order['recharge_userid']."',"
                        ." trans_addtime='".date("Y-m-d H:i:s",time())."'");
                    //交易记录开始
                    $_fee_array=array(
                        "fee_type"=>1,
                        "fee_money"=>$money,
                        "title"=>"余额微信充值",
                        "beizhu"=>json_encode($pay_order),
                        "transaction_id"=>$return['transaction_id'],
                        "orderid"=>$return['out_trade_no'],
                        "userid"=>$pay_order['userid'],
                        "adminid"=>0,
                        "pay_type"=>1
                    );
                    $id=$this->AddCommFee($_fee_array);
                    if ($id)
                    {
                        $this->GetDBMaster()->SubmitTransaction();
                    }
                    else
                    {
                        $this->GetDBMaster()->RollbackTransaction();
                    }
                }catch (Exception $e)
                {
                    $this->AddLogAlert('充值单号'.$return['out_trade_no'].'：',$e->getMessage());
                }
            }
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;
        exit;
    }

    /**
     * 按订单的商家结算
     */
    function PayShopOrderCallBack()
    {
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            $this->GetDBMaster()->StartTransaction();
            try{
                if ($notify->data["return_code"] == "FAIL")
                {
                    //通信出错
                    throw new Exception('交易号'.$return['out_trade_no'].'出现异常');
                }elseif($notify->data["result_code"] == "FAIL")
                {
                    throw new Exception('交易号'.$return['out_trade_no'].'业务错误');
                }else{
                    $out_trade_no=$return['out_trade_no'];
                    $money=$return['total_fee']/100;//支付金额
                    $pay_order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_RECHARGE." WHERE "
                        ." recharge_orderid='".$out_trade_no."'");
                    $out_trade_no = explode('_',$out_trade_no);
                    $orderid = $out_trade_no[0];
                    $insert_id = $out_trade_no[1];
                    $shop_order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER_SHOP." WHERE "
                        ." orderid='".$orderid."' AND id='".$insert_id."'");
                    if(empty($shop_order))
                    {
                        throw new Exception('交易号'.$return['out_trade_no'].'不存在');
                    }elseif($shop_order['order_status']>=3)
                    {
                        throw new Exception('交易号'.$return['out_trade_no'].'已经支付过了');
                    }
                    //更改订单状态
                    $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET order_status=3,"
                        ."is_pay_shop=1  "
                        ."WHERE id='".$shop_order['id']."'");
                    $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER." SET "
                        ." is_all_pay=2 WHERE orderid='".$orderid."'");
                    $pro_list = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER_GOODS." WHERE "
                        ." order_id='".$orderid."' AND shop_id='".$shop_order['shop_id']."'");
                    if(empty($pro_list))
                    {
                        throw new Exception('交易号'.$return['out_trade_no'].'没有找到产品明细');
                    }
                    //增加销量
                    foreach($pro_list as $item)
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
                            ." product_sold=product_sold+'".$item['product_count']."' "
                            ." WHERE product_id='".$item['product_id']."'");
                    }
                    if(!$res1)
                    {
                        throw new Exception('交易号'.$return['out_trade_no'].'更新状态失败');
                    }
                    $this->GetDBMaster()->SubmitTransaction();
                    $returnXml = $notify->returnXml();
                    echo $returnXml;
                    exit;
                }
            }catch (Exception $e)
            {
                $this->AddLogAlert('支付订单:',$e->getMessage());
                $this->GetDBMaster()->RollbackTransaction();
            }
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;
        exit;
    }


    /**
     * 团购微信支付或开团
     */
    function StartGroupBuyCallBack()
    {
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            try{
                if ($notify->data["return_code"] == "FAIL")
                {
                    //通信出错
                    throw new Exception('交易号'.$return['out_trade_no'].'出现异常');
                }elseif($notify->data["result_code"] == "FAIL")
                {
                    throw new Exception('交易号'.$return['out_trade_no'].'业务错误');
                }else{
                    $out_trade_no=$return['out_trade_no'];
                    $money=$return['total_fee']/100;//支付金额
                    //查询团购
                    $group_order = $this->GetDBSlave1()->queryrow("SELECT GO.pay_status,GO.group_id,GO.userid AS go_userid,"
                        ." G.group_valid_days,G.userid AS g_userid,G.group_status FROM "
                        ." ".TABLE_ORDER_GROUP." AS GO INNER JOIN ".TABLE_GROUP." AS G ON GO.group_id=G.group_id "
                        ." WHERE GO.orderid='".$out_trade_no."'");
                    if(!$group_order)
                    {
                        throw new Exception('交易号'.$return['out_trade_no'].'不存在');
                    }elseif($group_order['pay_status']==0)
                    {
                        $this->GetDBMaster()->StartTransaction();
                        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GROUP." SET "
                            ." pay_status=1,pay_method='wechat',"
                            ." pay_date='".date("Y-m-d H:i:s",time())."',"
                            ." pay_money='".$money."',transaction_id='".$return['transaction_id']."' "
                            ." WHERE orderid='".$out_trade_no."'");
                        if($group_order['go_userid']==$group_order['g_userid'])
                        {
                            if($group_order['group_status']>0)
                            {
                                throw new Exception('交易号'.$return['out_trade_no'].'重复开团');
                            }
                            $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." SET "
                                ." group_status=IF(group_all_count=1,2,1),"
                                ." group_present_nums=IF(group_present_nums>1,group_present_nums-1,0),"
                                ." start_time='".date("Y-m-d H:i:s")."',"
                                ." end_time='".date("Y-m-d H:i:s",strtotime("+".$group_order['group_valid_days']." days"))."',"
                                ." pay_money='".$money."',pay_datetime='".date("Y-m-d H:i:s",time())."' "
                                ." WHERE group_id='".$group_order['group_id']."'");
                        }else{
                            //拼团
                            $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." SET "
                                ." group_status=IF(group_present_nums=1,2,group_status),"
                                ." group_present_nums=IF(group_present_nums>1,group_present_nums-1,0) "
                                ." WHERE group_id='".$group_order['group_id']."'");
                        }
                        $_fee_array=array(
                            "fee_type"=>2,
                            "fee_money"=>$money,
                            "title"=>"拼团",
                            "beizhu"=>'微信支付',
                            "transaction_id"=>0,
                            "orderid"=>$out_trade_no,
                            "userid"=>$group_order['go_userid'],
                            "adminid"=>0,
                            "pay_type"=>1,
                            "store_id"=>$group_order['store_id']
                        );
                        $this->AddCommFee($_fee_array);
                        if($res1 && $res2)
                        {
                            $this->GetDBMaster()->SubmitTransaction();
                            $returnXml = $notify->returnXml();
                            echo $returnXml;
                            exit;
                        }else{
                            throw new Exception('交易号'.$return['out_trade_no'].'支付失败');
                        }
                    }else{
                        throw new Exception('交易号'.$return['out_trade_no'].'已经支付过了');
                    }
                }
            }catch (Exception $e)
            {
                $this->AddLogAlert('团购订单:',$e->getMessage());
                $this->GetDBMaster()->RollbackTransaction();
            }
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;
        exit;
    }


}