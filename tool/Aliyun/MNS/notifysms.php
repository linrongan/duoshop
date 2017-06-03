<?php
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
include '../../../config_wx.php';
include RPC_DIR .'/conf/conf.php';
include RPC_DIR .'/conf/config.php';
include RPC_DIR .'/module/common/common.php';
include RPC_DIR .'/module/common/notify.php';
$notify=new notify(array());
$notify->GetSmsNotify();




exit;
include RPC_DIR .'/tool/Aliyun/MNS/mqs.class.php';
$Accessid='LTAIMmscBH5gbBjq';
$AccessKey='zPUKNwgFhVaBPOt2bLx6mS7Na0V6IG';
$queueownerid='1111772830918194';
$mqsurl='mns.cn-shenzhen.aliyuncs.com';
$mqs=new Message($Accessid,$AccessKey,$queueownerid,$mqsurl);
$queueName='sms.topic-cn-shenzhen';
if(!isset($_GET['do'])) $_GET['do'] = 'get';

if($_GET['do']=='get'){
    $message=$mqs->ReceiveMessage($queueName,10);		//接收消息列队里的消息
    if($message['state']=='ok'){
        echo $message['msg']['MessageBody'];
        $mqs->DeleteMessage($queueName,$message['msg']['ReceiptHandle']);		//删除刚刚接收的消息
        exit();
    }
}elseif($_GET['do']=='pus')
{
    $MessageAttributes['DirectSMS']=json_encode(array("Type"=>"singleContent","FreeSignName"=>"测试专用","TemplateCode"=>"手机绑定验证码","Receiver"=>"18665716953","SmsParams"=>json_encode(array("date"=>"1","code"=>"123456"))));
    $mqs->SendMessage($queueName,'content',$MessageAttributes);
    //发送消息
}
?>