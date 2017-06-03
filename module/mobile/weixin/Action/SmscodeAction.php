<?php
include_once RPC_DIR.'/module/common/smscode_sent.php';
class SmscodeAction extends common
{
    function __construct($data)
    {
        $this->data = $data;
    }

    //绑定手机发送的验证码
    function ActionSentBindPhone()
    {
        $data=array("code"=>rand(100000,999999),"phone"=>$this->data['phone']);
        $sms=new smscode_sent(array());
        die(json_encode($sms->BindPhone($data)));
    }
}
