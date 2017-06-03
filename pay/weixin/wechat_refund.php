<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include_once(RPC_DIR."/pay/weixin/WxPayPubHelper/WxPayPubHelper.php");
Class WeChat_Refund extends common
{
     private $refund_fun;   //退款方法
     private $refund_title; //标题
     private $refund_params = array();  //参数
     private $refund_error = null;  //错误原因

    /**
     * WeChat_Refund constructor.
     * @param $refund_fun
     * @param $refund_title
     * @param $refund_params
     */
     function __construct($refund_fun,$refund_title)
     {
         $this->refund_fun = $refund_fun;
         $this->refund_title = $refund_title;
     }


     /*
      * 调用退款方法
      * */
     public function init($refund_params)
     {
         $this->refund_params = $refund_params;
         $function = $this->refund_fun;
         return $this->$function();
     }

    /**
     * @return array    //返回退款结果
     */
    private function WeChatRefund()
    {
        //发送系统退款
        $config_array = array(
            "appid"=>APPID,
            "appsecret"=>APPSECRET,
            "mchid"=>MCHID,
            "mchkey"=>KEY,
            "curltimeout"=>10,
            "sslsert_path"=>RPC_DIR.'/pay/weixin/WxPayPubHelper/cacert/apiclient_cert.pem',
            "sslkey_path"=>RPC_DIR.'/pay/weixin/WxPayPubHelper/cacert/apiclient_key.pem'
        );
        $refund = new Refund_pub($config_array);
        $refund->setParameter("out_trade_no",$this->refund_params['out_trade_no']);//商户订单号
        $refund->setParameter("out_refund_no",$this->OrderMakeOrderId());//商户退款单号
        $refund->setParameter("total_fee",$this->refund_params['total_fee']*100);//总金额
        $refund->setParameter("refund_fee",$this->refund_params['refund_fee']*100);//退款金额
        $refund->setParameter("op_user_id",$this->refund_params['op_user_id']);//操作员
        //调用结果
        try
        {
            $refundResult = $refund->SentRefund();
            if($refundResult)
            {
                if($refundResult['return_code']=='SUCCESS')
                {
                   return array('code'=>0,'msg'=>'退款成功','refund_return'=>$refundResult);
                }else
                {
                    throw new Exception('请求失败：'.json_encode($refundResult));
                }
            }else{
                throw new Exception('退款发送无返回参数：'.json_encode($refundResult));
            }
        }catch (Exception $e)
        {
            $this->refund_error = $e->getMessage();
            return array('code'=>1,'msg'=>'退款失败');
        }
    }


    //团购退款
    private function GroupBuyRefund()
    {
        //查询退款订单
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_REFUND." WHERE "
            ." orderid='".$this->refund_params['out_trade_no']."' AND refund_status=0 "
            ." AND refund_order_type=0 AND type_id=9");//back_status(1|0)部分退款 未退款
        if(empty($data))
        {
            $this->refund_error = '退款订单不存在';
            return array('code'=>1,'msg'=>'退款订单不存在');
        }elseif($data['already_refund_money']+$this->refund_params['total_fee'] > $data['refund_money'] && $data['back_status']=1)
        {
            return array('code'=>1,'msg'=>'可退金额不足');
        }
        //开始退款
        $result = $this->WeChatRefund();
        $already_refund_money = $data['already_refund_money'];
        if($result['code']==0)  //退款成功
        {
            $refund_status = 2;
            $already_refund_money = $already_refund_money+$this->refund_params['total_fee'];
        }else{
            $refund_status = -1;
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND." SET refund_status=".$refund_status.","
            ." already_refund_money='".$already_refund_money."' "
            ." WHERE orderid='".$this->refund_params['out_trade_no']."'");
        //如果退款成功
        if(!$row)
        {
            if($refund_status>0)
            {
                $this->refund_error = '退款成功：更新状态时失败';
            }
        }
    }


    //订单退款
    private function OrderRefund()
    {
        return $this->WeChatRefund();
    }


    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        if($this->refund_error)
        {
            $this->AddLogAlert($this->refund_title.'：',json_encode($this->refund_error));
        }
    }
}
?>