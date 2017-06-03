<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
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
        .web-yp-product>ul>li{min-height:230px;}
        .web-yp-body{padding:.5rem 3% 0;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

<div class="mui-content">
    <div class="web-opder-nav">
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=follow&_index=_product&v_shop='.$v_shop.''; ?>" class="web-order-active fr14 cl_b3 tc">商品</a>
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=follow&_index=_shop&v_shop='.$v_shop.''; ?>" class="fr14 cl_b3 tc">店铺</a>
    </div>

    <div class="web-follow-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-error tc" style="display: block;">
            <img src="/template/source/default/images/no_follow_i.png">
            <p class="fr16 cl_b3 mt10">看到喜欢的就收藏吧</p>
        </div>
        <div class="web-yp-product  mtr10">
            <ul class="web-yp-list">
                <li class="web-yp-item">
                    <a href="javascript:">
                        <img data-lazyload="images/web_yp_1.jpg" src="/template/source/default/images/web_yp_1.jpg" class="web-yp-img lazy">
                        <div class="web-yp-body">
                            <h1 class="omit fr14 cl_b3">时尚休闲男用包包时尚休闲男用包包</h1>
                            <div class="fr14 mtr5">
                                <div class="fl red">
                                    ￥<span class="fr18">257</span>.00
                                </div>
                                <div class="fr cl_b9">
                                    <del>￥360.00</del>
                                </div>
                                <div class="cb"></div>
                            </div>
                        </div>
                    </a>
                    <div class="web_follow_pro_num">
                        <p class="fl fr12 cl_b9">2000人关注</p>
                        <a href="javascript:;" class="fr cl_b3 fr12 ">取消</a>
                        <div class="cb"></div>
                    </div>
                </li>
                <li class="web-yp-item">
                    <a href="javascript:">
                        <img data-lazyload="images/web_yp_2.jpg" src="/template/source/default/images/web_yp_2.jpg" class="web-yp-img lazy">
                        <div class="web-yp-body">
                            <h1 class="omit fr14 cl_b3">时尚休闲女装时尚休闲女装</h1>
                            <div class="fr14 mtr5">
                                <div class="fl red">
                                    ￥<span class="fr18">257</span>.00
                                </div>
                                <div class="fr cl_b9">
                                    <del>￥360.00</del>
                                </div>
                                <div class="cb"></div>
                            </div>
                        </div>
                    </a>
                    <div class="web_follow_pro_num">
                        <p class="fl fr12 cl_b9">2000人关注</p>
                        <a href="javascript:;" class="fr cl_b3 fr12 ">取消</a>
                        <div class="cb"></div>
                    </div>
                </li>
                <li class="web-yp-item">
                    <a href="javascript:">
                        <img data-lazyload="images/web_yp_3.jpg" src="/template/source/default/images/web_yp_3.jpg" class="web-yp-img lazy">
                        <div class="web-yp-body">
                            <h1 class="omit fr14 cl_b3">原木纯品清风抽纸原木纯品清风抽纸...</h1>
                            <div class="fr14 mtr5">
                                <div class="fl red">
                                    ￥<span class="fr18">257</span>.00
                                </div>
                                <div class="fr cl_b9">
                                    <del>￥360.00</del>
                                </div>
                                <div class="cb"></div>
                            </div>
                        </div>
                    </a>
                    <div class="web_follow_pro_num">
                        <p class="fl fr12 cl_b9">2000人关注</p>
                        <a href="javascript:;" class="fr cl_b3 fr12 ">取消</a>
                        <div class="cb"></div>
                    </div>
                </li>
                <li class="web-yp-item">
                    <a href="javascript:">
                        <img data-lazyload="images/web_yp_4.jpg" src="/template/source/default/images/web_yp_4.jpg" class="web-yp-img lazy">
                        <div class="web-yp-body">
                            <h1 class="omit fr14 cl_b3">精品夏日休闲女装精品夏日休闲女装</h1>
                            <div class="fr14 mtr5">
                                <div class="fl red">
                                    ￥<span class="fr18">257</span>.00
                                </div>
                                <div class="fr cl_b9">
                                    <del>￥360.00</del>
                                </div>
                                <div class="cb"></div>
                            </div>
                        </div>
                    </a>
                    <div class="web_follow_pro_num">
                        <p class="fl fr12 cl_b9">2000人关注</p>
                        <a href="javascript:;" class="fr cl_b3 fr12 ">取消</a>
                        <div class="cb"></div>
                    </div>
                </li>
            </ul>
            <div class="cb"></div>
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