<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetNoticeText();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>消息详情</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-message-body{padding:1rem 5%;}
        .web-message-tuwen>img{max-width:100%; display: block; margin: auto;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>

</head>
<body  style="background:white;" >

<div class="mui-content" style="background:white;">
    <div class="web-message-body">
        <h1 class="fr16"><?php $data['title']; ?></h1>
        <p class="fr14 mtr5 cl_b9"><?php $data['addtime']; ?></p>
        <div class="web-message-tuwen  fr14 mtr20">
            <?php echo $data['alert_text']; ?>
        </div>
    </div>
</div>


<div onClick="history.back()" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>


</body>
</html>