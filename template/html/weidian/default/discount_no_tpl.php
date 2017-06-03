<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>我的优惠券</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>

        .web-opder-nav{padding:0; border-bottom:1px solid #e8e8e8;}
        .web-opder-nav>a{padding:.5rem 0;}
        .web_discount_warp{padding:.5rem 3% 0;}
        .web_discount_item>ul>li{min-height:70px; position: relative; background:#fdf0bb; margin-bottom:10px;}
        .web_discount_item>ul>li>a{display: block;}
        .web_discount_price{position:absolute; left:-3px; top: 0; width: 105px; height: 70px; background:url(/template/source/default/images/yes_discount_bg.png) no-repeat; background-size:100% 100%; text-align: center; line-height: 70px; font-weight: bold;}
        .web_discount_price>span{font-size:45px; }
        .web-discount_mess{

            padding-left:120px;
            padding-top:10px;

        }
        .web-discount_mess>h1{font-size:24px; font-weight:bold;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

<div class="mui-content">
    <div class="web-opder-nav">
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=discount&_index=_no&v_shop='.$v_shop.''; ?>" class="web-order-active fr14 cl_b3 tc">未使用</a>
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=discount&_index=_yes&v_shop='.$v_shop.''; ?>" class="fr14 cl_b3 tc">已过期</a>
    </div>

    <div class="web-discount-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-error tc" style="display: block;">
            <img src="/template/source/default/images/no_discount_i.png">
            <p class="fr16 cl_b3 mt10">没有优惠券</p>
        </div>
      	<div class="web_discount_warp">
            <div class="web_discount_item">
                <ul>
                    <li>
                        <a href="javascript:;">
                            <div class="web_discount_price white fr18 omit ">
                                ￥<span data-syprice="10">10</span>
                            </div>
                            <div class="web-discount_mess">
                                <h1 class="cl_b3">满<span class="red" data-maxprice="100">100</span>使用</h1>
                                <p class="cl_b9 mt5 f16">使用时间：8.13-8.25</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <div class="web_discount_price white fr18 omit ">
                                ￥<span data-syprice="40" >40</span>
                            </div>
                            <div class="web-discount_mess">
                                <h1 class="cl_b3">满<span class="red" data-maxprice="499">499</span>使用</h1>
                                <p class="cl_b9 mt5 f16">使用时间：8.13-8.25</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <div class="web_discount_price white fr18 omit ">
                                ￥<span data-syprice="60">60</span>
                            </div>
                            <div class="web-discount_mess">
                                <h1 class="cl_b3">满<span class="red" data-maxprice="899">899</span>使用</h1>
                                <p class="cl_b9 mt5 f16">使用时间：8.13-8.25</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <div class="web_discount_price white fr18 omit ">
                                ￥<span data-syprice="1000">1000</span>
                            </div>
                            <div class="web-discount_mess">
                                <h1 class="cl_b3">满<span class="red" data-maxprice="29999">29999</span>使用</h1>
                                <p class="cl_b9 mt5 f16">使用时间：8.13-8.25</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>  

    </div>


</div>


<script src="/template/source/default/js/mui.min.js"></script>
<script type="text/javascript">


</script>
</body>
</html>