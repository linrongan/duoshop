<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/tool/Aliyun/MNS/mqs.class.php';
Class smscode_sent extends common
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
        $this->data['mqsurl']='mns.cn-shenzhen.aliyuncs.com';
        $this->data['queueName']='sms.topic-cn-shenzhen';
    }

    //手机绑定验证
    function BindPhone($data)
    {
        if(empty($data['phone']))
        {
            die(json_encode(array("code"=>1,"msg"=>"手机号码未填写")));
        }
        $json=json_encode(array("Type"=>"singleContent","FreeSignName"=>SIGN_NAME,
            "TemplateCode"=>"SMS_62760133",
            "Receiver"=>$data['phone'],
            "SmsParams"=>json_encode(array("date"=>date("Y-m-d H:i:s"),"code"=>strval($data['code'])))));
        $return=$this->SentSmsCode($json);
        if ($return['code']==0)
        {
            $this->TjSmsCodeCount($data['code'],$data['phone'],1);
        }
        return $return;
    }

    private function SentSmsCode($json)
    {
        $msg=new Message(ACCESS_KEY_ID,ACCESS_KEY_SECRET,ALIYUN_ID,$this->data['mqsurl']);
        $MessageAttributes['DirectSMS']=$json;
        $return=$msg->SendMessage($this->data['queueName'],'content',$MessageAttributes);
        if ($return['state']=="ok")
        {

           return array("code"=>0,"msg"=>"短信发送成功");
        }else
        {
           return array("code"=>1,"msg"=>"短信发送失败");
        }
    }

    private function TjSmsCodeCount($code,$phone,$type_id=0)
    {
        $res =$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_LOG_SMSCODE." "
            ." (userid,phone,addtime,code,type_id)"
            ." VALUES('".SYS_USERID."','".$phone."','".date("Y-m-d H:i:s",strtotime("+8 hours"))."','".$code."','".$type_id."')");
    }
}
?>