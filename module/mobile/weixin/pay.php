<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
error_reporting(0);
require_once RPC_DIR.'/pay/weixin/WxPayPubHelper/WxPayPubHelper.php';
class pay extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //获取投放广告支付请求参数
    function ActionPayAdvert()
    {
        if (!is_numeric($this->data['money']) || $this->data['money']<0.01)
        {
            die(json_encode(array("code"=>1,"msg"=>"最低金额不能低于10元","package"=>"prepay_id=")));
        }
        //判断订单的合法性
        $jsApi = new JsApi_pub();
        $openid=$_SESSION['openid'];
        $orderid=date("YmdHis").rand(1000,9999).'_'.$this->data['id'];
        //生成唯一交易订单号
        $unifiedOrder = new UnifiedOrder_pub();
        $unifiedOrder->setParameter("openid","$openid");
        $unifiedOrder->setParameter("body","投放广告");
        $unifiedOrder->setParameter("out_trade_no",$orderid);//商户订单号
        $unifiedOrder->setParameter("total_fee",$this->data['money']*100);//总金额
        $unifiedOrder->setParameter("notify_url",WEBURL."/pay/weixin/pay_advert_notify.php");//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
        $prepay_id = $unifiedOrder->getPrepayId();
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = json_decode($jsApi->getParameters(),true);
        $jsApiParameters['orderid']=$orderid;
        die(json_encode($jsApiParameters));
    }

    //广告投放回调
    public function advert_result()
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
            try{
                if ($notify->data["return_code"] == "FAIL")
                {
                    //通信出错
                    throw new Exception('交易号'.$return['out_trade_no'].'出现异常');
                }elseif($notify->data["result_code"] == "FAIL")
                {
                    throw new Exception('交易号'.$return['out_trade_no'].'业务错误');
                }else
                {
                    $out_trade_no = explode('_',$return['out_trade_no']);
                    $order=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_FEE." "
                        ." WHERE transaction_id='".$return['transaction_id']."' AND pay_type=1");
                    if (!empty($order))
                    {
                        throw new Exception('交易号：'.$return['out_trade_no'].'投放广告回调重复提醒');
                    }
                    $ad_order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ADVERT." "
                        ." WHERE id='".$out_trade_no[1]."' ");
                    if(empty($ad_order))
                    {
                        throw new Exception('交易号：'.$return['out_trade_no'].'投放广告不存在');
                    }
                    $ad_data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADVERT_REGION." "
                        ." WHERE id='".$ad_order['picture_type']."'");
                    $total_fee=$return['total_fee']/100;
                    $advert_day = intval($total_fee/$ad_data['price']);
                    if(empty($advert_day))
                    {
                        throw new Exception('交易号：'.$return['out_trade_no'].'投放广告获取小时数为0');
                    }
                    $user=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." "
                        ." WHERE openid='".$return['openid']."'");
                    $this->GetDBMaster()->StartTransaction();
                    //交易记录开始
                    $_fee_array=array("fee_type"=>4,
                        "fee_money"=>$total_fee,
                        "title"=>"广告投放支付",
                        "beizhu"=>json_encode($ad_data),
                        "transaction_id"=>$return['transaction_id'],
                        "orderid"=>$return['out_trade_no'],
                        "userid"=>$user['userid'],
                        "adminid"=>0,
                        "pay_type"=>1
                    );
                    $id=$this->AddCommFee($_fee_array);
                    if ($id)
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ADVERT." "
                            ." SET advert_day=advert_day+".$advert_day.",status=1"
                            ." WHERE id='".$out_trade_no[1]."'");
                        $this->GetDBMaster()->SubmitTransaction();
                        $returnXml = $notify->returnXml();
                        echo $returnXml;
                        exit;
                    }else
                    {
                        $this->GetDBMaster()->RollbackTransaction();
                    }
                }
            }
            catch (Exception $e)
            {
                $this->AddLogAlert('广告投放支付订单异常:',$e->getMessage());
            }
            exit;
        }
    }


    //创建团购支付回调
    function group_create_result()
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
                }else
                {
                    $order=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER_GROUP." "
                        ." WHERE orderid='".$return['out_trade_no']."'");
                    if(empty($order))
                    {
                        throw new Exception('交易号：'.$return['out_trade_no'].'异常创建团购信息不存在');
                    }
                    if ($order['pay_status']==1)
                    {
                        throw new Exception('交易号：'.$return['out_trade_no'].'异常创建团购已经支付过了');
                    }
                    $total_fee=$return['total_fee']/100;
                    $this->GetDBMaster()->StartTransaction();
                    $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GROUP." "
                        ." SET pay_status=1,pay_method='wechat',"
                        ." transaction_id='".$return['transaction_id']."',"
                        ." pay_date='".date("Y-m-d H:i:s")."',"
                        ." pay_money='".$total_fee."'"
                        ." WHERE orderid='".$return['out_trade_no']."'");

                    if ($order['group_buy_type']==1)
                    {
                        //开团处理
                        if (empty($order['group_valid_day']))
                        {
                            $order['group_valid_day']=1;
                        }
                        //获取团购商品信息
                        $product=$this->GetDBSlave1()->queryrow("SELECT group_valid_day FROM ".TABLE_GROUP_PRODUCT." "
                            ." WHERE product_id='".$order['product_id']."'");
                        $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." "
                            ." SET group_status=1,"
                            ." pay_method='wechat',"
                            ." transaction_id='".$return['transaction_id']."',"
                            ." pay_datetime='".date("Y-m-d H:i:s")."',"
                            ." pay_money='".$total_fee."',"
                            ." start_time='".date("Y-m-d H")."',"
                            ." group_present_nums=group_present_nums-1,"
                            ." sold_pro_nums=sold_pro_nums+".intval($order['product_count']).","
                            ." end_time='".date("Y-m-d H",strtotime("+".intval($product['group_valid_day'])." days"))."'"
                            ." WHERE group_id='".$order['group_id']."'");
                    }else
                    {
                        //参团处理
                        $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." "
                            ." SET group_present_nums=group_present_nums-1,"
                            ." sold_pro_nums=sold_pro_nums+".intval($order['product_count']).""
                            ." WHERE group_id='".$order['group_id']."'");

                        $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." "
                            ." SET group_status=1"
                            ." WHERE group_id='".$order['group_id']."' "
                            ." AND group_present_nums<=1");
                    }
                    $this->GetDBMaster()->SubmitTransaction();
                    $returnXml = $notify->returnXml();
                    echo $returnXml;
                    exit;
                }
            }
            catch (Exception $e)
            {
                $this->AddLogAlert('创建团购回调异常:',$e->getMessage());
            }
            $this->GetDBMaster()->SubmitTransaction();
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }
}