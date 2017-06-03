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
        .mui-search .mui-placeholder {
            font-size: 14px;
        }
        input[type=search]{background:#f4f4f9; font-size: 14px; margin-bottom: 0;}
        .mui-search:before{margin-top:-11px;}
	</style>
	<script src="/template/source/default/js/jquery_1.1.1.js"></script>

</head>
<body>
    <div class="mui-content">
        <div class="web-classify-seach">
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_classify&v_shop='.$v_shop.''; ?>" class="web-classify-seach-cage tc cl_b9 fl">
                <i class="fa fa-navicon"></i>
                <p class="f12 cl_b3">分类</p>
            </a>
            <div class="web-classify-seach-text fl">
                <div class="mui-input-row mui-search fr14">
                    <input type="search" class="mui-input-clear" placeholder="请输入商品名称">
                </div>
            </div>
            <div class="cb"></div>
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
                <span class="fr14">
                    价格
                </span>
                <div class="price-sort">
                    <!----价格标识样式 在P标签加class="red"--->
                    <p><i class="fa fa-caret-up"></i></p>
                    <p><i class="fa fa-caret-down"></i></p>
                </div>
            </a>
        </div>


        <div class="web-calssify-body">
            <!--没有购物产品提示 -->
            <div class="web-cart-error tc" style="">
                <img src="/template/source/default/images/no_order_i.png">
                <p class="fr16 cl_b3">抱歉！没有相关商品</p>
                <div class="mtr30 error-btn"><a href="<?php echo WEBURL.'/?mod=weidian&v_mod=apply&_index=_classify&v_shop='.$v_shop.''; ?>">查看店铺分类</a></div>
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
    </script>

</body>
</html>