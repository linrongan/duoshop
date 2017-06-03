<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include_once(RPC_DIR."/pay/weixin/WxPayPubHelper/WxPayPubHelper.php");
Class refund extends common
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    /*
     *  执行退款操作
     *  methed: OrderRefund 普通订单 GroupOrderRefund团购,orderid商户订单,refund_fee退款费用，type_id退款类型
     */
    function ActionRefund($methed='OrderRefund',$orderid=0,$refund_fee=0,$type_id=0)
    {
        if (!is_numeric($refund_fee) || $refund_fee<=0)
        {
            return array("code"=>1,"msg"=>"退款金额不正确");
        }
        if (function_exists($methed))
        {
            return $methed($orderid,$refund_fee,$type_id);
        }
        return array("code"=>1,"msg"=>"非法退款操作");
    }

    //团购订单退款
    function GroupOrderRefund($orderid,$refund_fee,$type_id)
    {
        $return=$this->WeixinRefund($orderid,$refund_fee);
        //取出团购要退款的订单号
        $order=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GROUP_FAIL_BACK." "
            ." WHERE orderid='".$orderid."' AND type_id='".$type_id."' "
            ." AND back_status=".$type_id." ");
        if (empty($order))
        {
            return array("code"=>1,"msg"=>"找不到该订单或者已经退款过了");
        }
        if ($order['back_money']-$order['already_back_money']>$refund_fee)
        {
            return array("code"=>1,"msg"=>"退款金额已经超过可退款金额总数");
        }
        if (isset($return['code']) && $return['code']==0)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP_FAIL_BACK." "
                ." SET back_status=1,"
                ." already_back_money=already_back_money+".$refund_fee.","
                ." back_time='".date("Y-m-d H:i:s")."'"
                ." WHERE orderid='".$orderid."'");
        }
        return $return;
    }

    //团购退款申请
    private function WeixinRefund($orderid,$refund_fee)
    {
        //发送系统退款
        $config_array=array(
            "appid"=>APPID,
            "appsecret"=>APPSECRET,
            "mchid"=>MCHID,
            "mchkey"=>KEY,
            "curltimeout"=>10,
            "sslsert_path"=>RPC_DIR.'/pay/weixin/WxPayPubHelper/cacert/apiclient_cert.pem',
            "sslkey_path"=>RPC_DIR.'/pay/weixin/WxPayPubHelper/cacert/apiclient_key.pem');
        $out_refund_no=$this->OrderMakeOrderId();
        $refund = new Refund_pub($config_array);
        $refund->setParameter("out_trade_no","$orderid");//商户订单号
        $refund->setParameter("out_refund_no","$out_refund_no");//商户退款单号
        $refund->setParameter("total_fee",$refund_fee*100);//总金额
        $refund->setParameter("refund_fee",$refund_fee*100);//退款金额
        $refund->setParameter("op_user_id",$orderid);//操作员
        //调用结果
        try
        {
            $refundResult = $refund->getResult();
            if ($refundResult["return_code"] == "FAIL")
            {
                throw new Exception("通信出错：".json_encode($refundResult)."");
            }elseif ($refundResult['result_code']=='SUCCESS')
            {
                return array("code"=>1,"msg"=>"退款操作成功");
            }elseif($refundResult['result_code']=='FAIL')
            {
                throw new Exception("退款失败：".json_encode($refundResult)."");
            }
            else
            {
                throw new Exception("退款异常或超时：".json_encode($refundResult)."");
            }

        }catch (Exception $e)
        {
            $this->AddLogAlert('退款异常:',$e->getMessage());
        }
        return array("code"=>1,"msg"=>"退款失败");
    }
}
?>