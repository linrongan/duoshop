<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>我的关注</title>
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
        .web-opder-nav{padding:0; border-bottom:1px solid #e8e8e8;}
        .web-opder-nav>a{padding:.5rem 0;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

<div class="mui-content">
    <div class="web-opder-nav">
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=follow&_index=_product&v_shop='.$v_shop.''; ?>" class="fr14 cl_b3 tc">商品</a>
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=follow&_index=_shop&v_shop='.$v_shop.''; ?>" class="web-order-active fr14 cl_b3 tc">店铺</a>
    </div>

    <div class="web-follow-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-error tc" style="display: block;">
            <img src="/template/source/default/images/no_follow_i.png">
            <p class="fr16 cl_b3 mt10">看到喜欢的就收藏吧</p>
        </div>
        <div class="web-follow-warp">
            <div class="web-cells">
                <div class="web-cell">
                    <div class="web-cell__hd">
                        <a href="javascript:;">
                            <img data-lazyload="images/web_follow_i1.png" src="/template/source/default/images/web_follow_i1.png" style="height:2rem; width:4rem; display: block; margin-right: 10px; ">
                        </a>
                    </div>
                    <div class="web-cell__bd">
                        <p class="fr14 "><a href="javascript:;" class="cl_b3">君泉生活电器专场</a></p>
                        <p  class="fr12 cl_b9 mt5">25.0万人关注</p>
                    </div>
                    <div class="web-cell__ft">
                        <a href="javascript:;" class="cl_b3 fr14"><i class="fa fa-close"></i></a>
                    </div>
                </div>
            </div>
            <div class="web-cells">
                <div class="web-cell">
                    <div class="web-cell__hd">
                        <a href="javascript:;">
                            <img data-lazyload="images/web_follow_i2.png" src="/template/source/default/images/web_follow_i2.png" style="height:2rem; width:4rem; display: block; margin-right: 10px; ">
                        </a>
                    </div>
                    <div class="web-cell__bd">
                        <p class="fr14 "><a href="javascript:;" class="cl_b3">九阳厨房电器旗航店</a></p>
                        <p  class="fr12 cl_b9 mt5">25.0万人关注</p>
                    </div>
                    <div class="web-cell__ft">
                        <a href="javascript:;" class="cl_b3 fr14"><i class="fa fa-close"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>




<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script>
    (function($) {
        $(document).imageLazyload({
            placeholder: '/template/source/default/images/60x60.jpg'
        });
    })(mui);
</script>
</body>
</html>