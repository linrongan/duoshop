<?php
error_reporting(0);
require_once RPC_DIR.'/pay/weixin/WxPayPubHelper/WxPayPubHelper.php';
class wechat_pay extends common
{
    function __construct($data)
    {
        $this->data = $data;
    }

    public function WeChatPay($array)
    {
        $jsApi = new JsApi_pub();
        $openid=$_SESSION['openid'];
        $timeStamp = time().rand(10000,99999);
        //生成唯一交易订单号
        $out_trade_no=$timeStamp;
        $unifiedOrder = new UnifiedOrder_pub();
        $unifiedOrder->setParameter("openid","$openid");
        $unifiedOrder->setParameter("body","支付订单");
        $unifiedOrder->setParameter("out_trade_no",$array['out_trade_no']);//商户订单号
        $unifiedOrder->setParameter("total_fee",$array['total_fee']*100);//总金额
        $unifiedOrder->setParameter("notify_url",$array['notify_url']);//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
        $prepay_id = $unifiedOrder->getPrepayId();
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = $jsApi->getParameters();
        return $jsApiParameters;
    }



    //充值回调
    public function rechargeCallBack()
    {
        $log='';
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
                $out_trade_no=$return['out_trade_no'];
                $money=$return['total_fee']/100;//支付金额
                $pay_order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_RECHARGE." WHERE "
                    ." recharge_orderid='".$out_trade_no."'");
                if($pay_order)
                {
                    if($pay_order['recharge_status']==0)
                    {
                        $this->GetDBMaster()->StartTransaction();
                        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET user_money=user_money+'".$pay_order['recharge_money']."' "
                            ." WHERE userid='".$pay_order['recharge_userid']."'");
                        $res2  = $this->GetDBMaster()->query("UPDATE ".TABLE_RECHARGE." SET recharge_status=2,"
                            ."recharge_status_text='充值成功',recharge_pay_date='".time()."',"
                            ."recharge_pay_result='".json_encode($return)."'");
                        if($res1 && $res2)
                        {
                            $log .= '单号'.$out_trade_no.'充值成功';
                            $this->GetDBMaster()->SubmitTransaction();
                        }
                        $log .= '单号'.$out_trade_no.'充值失败';
                        $this->GetDBMaster()->RollbackTransaction();
                    }else{
                        $log .= '单号'.$out_trade_no.'重复支付';
                    }
                }else{
                    $log .= '单号'.$out_trade_no.'没有找到';
                }
            }
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }
}