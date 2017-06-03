<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>广州百里服装店铺</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
	<link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
	<style>
        .web-opder-nav{padding:0; border-bottom:1px solid #e8e8e8; }
        .web-opder-nav>a{padding:.5rem 0;}
	</style>
	<script src="/template/source/default/js/jquery_1.1.1.js"></script>

</head>
<body>

	<div class="mui-content">
        <div class="shop-header" style="background:url(/template/source/default/images/shop/shop_head_bg.jpg) no-repeat">
            <div class="shop-header-mess">
                <div class="shop-header-body">

                    <div class="shop-header-body_pic">
                        <img src="/template/source/default/images/shop/shop_logo.jpg" class="blockimg">
                    </div>
                    <div class="shop-header-body_name fl">
                        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_date&v_shop='.$v_shop.''; ?>" class=" fr14 " style="display: block;" >
                            <p class="omit white" style="">小米官方旗航店<i class="ml5 fa fa-chevron-right"></i></p>
                        </a>
                    </div>

                    <div class="fr shop-header-body_n tc ">
                        <p class="white fr16"><i class="fa fa-star"></i></p>
                        <p class="white fr12">收藏</p>
                    </div>
                    <div class="fr shop-header-body_n tc ">
                        <p class="white fr16">581.5万</p>
                        <p class="white fr12">粉丝数</p>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
        </div>

        <div class="web-opder-nav">
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&v_shop='.$v_shop.''; ?>" class="tc">
                <i class="shop-nav-i"></i>
                <p class="fr14 cl_b9">店铺首页</p>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_product&v_shop='.$v_shop.''; ?>" class="tc shop-nav-active">
                <i class="shop-nav-i"></i>
                <p class="fr14 cl_b9">全部商品</p>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_news&v_shop='.$v_shop.''; ?>" class="tc">
                <i class="shop-nav-i"></i>
                <p class="fr14 cl_b9">新品上新</p>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_activity&v_shop='.$v_shop.''; ?>" class="tc">
                <i class="shop-nav-i"></i>
                <p class="fr14 cl_b9">店铺促销</p>
            </a>
        </div>

        <div class="shop-product-sort mtr10">
            <a href="javascript:;" class="tc cl_b3 shop-sort-active">
                <span class="fr14">综合</span>
            </a>
            <a href="javascript:;" class="tc cl_b3 ">
                <span class="fr14">销量</span>
            </a>
            <a href="javascript:;" class="tc cl_b3 ">
                <span class="fr14">新品</span>
            </a>
            <a href="javascript:;" class="tc cl_b3 ">
                <span class="fr14">价格</span>
                <div class="price-sort">
                    <!----价格标识样式 在P标签加class="red"--->
                    <p><i class="fa fa-caret-up"></i></p>
                    <p><i class="fa fa-caret-down"></i></p>
                </div>
            </a>
        </div>
        <div class="web-yp-product ">
            <ul class="web-yp-list">
                <li class="web-yp-item">
                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
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
                </li>
                <li class="web-yp-item">
                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
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
                </li>
                <li class="web-yp-item">
                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
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
                </li>
                <li class="web-yp-item">
                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
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
                </li>
            </ul>
            <div class="cb"></div>
        </div>
	</div>


    <!----底部导航---->
    <div>
        <div style="height: 50px;"></div>
        <div class="web-footer bgF">
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_classify&v_shop='.$v_shop.''; ?>" class="tc lh40 f14 ">
                <span>店铺分类</span>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_date&v_shop='.$v_shop.''; ?>" class="tc lh40 f14">
                <span><i class="fa fa-info-circle" style="margin-right:3px;"></i>店铺详情</span>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_contact&v_shop='.$v_shop.''; ?>" class="tc lh40 f14 ">
                <span><i class="fa fa-flickr" style="margin-right:3px;"></i>联系客服</span>
            </a>
        </div>
    </div>


	<script src="/template/source/default/js/mui.min.js"></script>
	<script src="/template/source/default/js/mui.lazyload.js"></script>
	<script src="/template/source/default/js/mui.lazyload.img.js"></script>
    <script>
        (function($) {
            $(document).imageLazyload({
                placeholder: 'images/60x60.jpg'
            });
        })(mui);


        $(window).scroll(function(){
            var winTop = $(this).scrollTop();
            var h1 = $(".apply-header").height()
            var h2 = $(".web-opder-nav").height()
            if(winTop > (h1 + h2)){
                $(".web-opder-nav").css({'position':'fixed','top':'0','left':'0'})
                $(".web-opder-nav .apply-nav-i").hide()
            }else{
                $(".web-opder-nav").css({'position':'initial','top':'0','left':'0'})
                $(".web-opder-nav .apply-nav-i").show()
            }
        })


    </script>
</body>
</html>