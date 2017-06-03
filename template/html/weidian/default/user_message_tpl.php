<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>我的消息</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-cells:first-child{margin-top:0;}
        .web-cells::before{border-top:none;}
        .web-cell:first-child::before{border-top:none;}
        .web-cell:before{left:0;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>

</head>
<body >

<div class="mui-content">

    <!--没有购物产品提示 -->
    <div class="web-cart-error tc" style="display: block;">
        <img src="/template/source/default/images/no_order_i.png">
        <p class="fr16 cl_b3">亲，暂无没有您的信息</p>
    </div>


    <div class="web-cells" style="margin-top: 0;">
        <a href="javascript:;" class="web-cell">
            <div class="web-cell__hd web-message-title mr10">
                <img src="/template/source/default/images/tuisongM.png" style="width:3rem; height: 3rem; display:block; ">
                <span>1</span>
            </div>
            <div class="web-cell__bd">
                <div>
                    <span class="fl fr14 cl_b3 omit" style="width: 70%">宇若活动</span>
                    <span class="fr fr12 cl_b9">昨天</span>
                    <div class="cb"></div>
                </div>
                <div class="mtr10 fr12 cl_b9 ">点击查看</div>
            </div>
        </a>
        <a href="javascript:;" class="web-cell">
            <div class="web-cell__hd web-message-title mr10">
                <img src="/template/source/default/images/tuisongM.png" style="width:3rem; height: 3rem; display:block; ">
                <span>1</span>
            </div>
            <div class="web-cell__bd">
                <div>
                    <span class="fl fr14 cl_b3 omit" style="width: 70%">恋世夫人旗航点</span>
                    <span class="fr fr12 cl_b9">10.00</span>
                    <div class="cb"></div>
                </div>
                <div class="mtr10 fr12 cl_b9 ">点击查看</div>
            </div>
        </a>
        <a href="javascript:;" class="web-cell">
            <div class="web-cell__hd web-message-title mr10">
                <img src="/template/source/default/images/tuisongM2.png" style="width:3rem; height: 3rem; display:block; ">
                <span style="display:none;">1</span>
            </div>
            <div class="web-cell__bd">
                <div>
                    <span class="fl fr14 cl_b3 omit" style="width: 70%">我的资产</span>
                    <span class="fr fr12 cl_b9">昨天</span>
                    <div class="cb"></div>
                </div>
                <div class="mtr10 fr12 cl_b9 ">您昨天累计收到7张优惠卡</div>
            </div>
        </a>
    </div>
</div>


<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>


</body>
</html>