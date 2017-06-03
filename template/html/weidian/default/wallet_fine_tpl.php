<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>余额明细</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell:first-child::before{border-top:none}
        .web-cell:before{left:0;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

<div class="mui-content">


    <!--没有购物产品提示 -->
    <div class="web-cart-error tc" style="display: block;">
        <img src="/template/source/default/images/no_wallet_i.png">
        <p class="fr16 cl_b3 mt10">暂无明细</p>
    </div>

    <div class="web-wallet-body">
        <div class="web-cells">
            <div class="web-cell">
                <div class="web-cell__bd">
                    <p class="cl_b3 fr14">在线支付</p>
                    <p class="cl_b9 fr12 mtr5">余额：597.59</p>
                </div>
                <div class="web-cell__ft">
                    <p class="cl_b3 fr16 " style="font-weight: bold" >-7.00</p>
                    <p class="fr12 mtr5 cl_b9">2017-02-02</p>
                </div>
            </div>
            <div class="web-cell">
                <div class="web-cell__bd">
                    <p class="cl_b3 fr14">交易退款</p>
                    <p class="cl_b9 fr12 mtr5">余额：597.59</p>
                </div>
                <div class="web-cell__ft">
                    <p class="cl_b3 fr16 " style="font-weight: bold" >-7.00</p>
                    <p class="fr12 mtr5 cl_b9">2017-02-02</p>
                </div>
            </div>
        </div>
    </div>

</div>




<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script>

</script>
</body>
</html>