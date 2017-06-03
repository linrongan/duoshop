<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/tool/Aliyun/MNS/mqs.class.php';
Class mail_sent extends common
{
    function __construct($data,$db)
    {
        $this->data=daddslashes($data);
    }

    //发送邮件操作
    function CommonMailSentAction($config=array(),$ParamString='')
    {
        $mqsurl='mns.cn-shenzhen.aliyuncs.com';
        $queueName='sms.topic-cn-shenzhen';
        $msg=new Message(ACCESS_KEY_ID,ACCESS_KEY_SECRET,ALIYUN_ID,$mqsurl);
        $MessageAttributes['DirectMail']=$ParamString;
        $return=$msg->SendMessage($queueName,'content',$MessageAttributes);
        if ($return['state']=="ok")
        {
            return array("code"=>0,"msg"=>"邮件发送成功");
        }else
        {
            return array("code"=>1,"msg"=>"邮件发送失败");
        }
    }
}
?>