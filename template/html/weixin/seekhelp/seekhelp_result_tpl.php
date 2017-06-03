<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>申请提交处理</title>
    <link rel="stylesheet" type="text/css" href="/template/source/css/font.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/weui.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/rest.css?6666">
    <link rel="stylesheet" type="text/css" href="/template/source/css/main.css?7asdasd777">
</head>
<body>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">申请提交成功</h2>
            <p class="weui-msg__desc">
              您好，您的资料提交成功,请等待1-3个工作日进行审核，我们将会通过电话或者短信联系您，请保持您的电话通畅。
            </p>
        </div>
    </div>
    <div class="" style="padding:.4rem 10%;">
        <a onclick="CloseWin()" class="weui-btn weui-btn_default" href="javascript:void()">关闭窗口</a>
    </div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
   function CloseWin()
   {
       WeixinJSBridge.invoke('closeWindow',{},function(res){
       });
   }
</script>
</body>
</html>