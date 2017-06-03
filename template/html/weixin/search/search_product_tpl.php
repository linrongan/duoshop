<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetAllProduct();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>产品</title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/weixin/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/rest.css">
    <link rel="stylesheet" href="/template/source/weixin/css/main.css">
    <style>
        .mui-search .mui-placeholder {
            font-size: 14px;
        }
        input[type=search]{background:#f4f4f9; font-size: 14px; margin-bottom: 0;}
        .mui-search:before{margin-top:-11px;}
        .loadding-body{position:fixed; width:50px; height:50px; text-align:center; line-height:65px; background:rgba(255,255,255,.4); border-radius:10px; z-index:999; left:50%; top:50%; margin-left:-25px; margin-top:-25px; }
        .web-yp-product>ul>li>a{position:relative;}
        .web-shop-name{position:absolute; left:0; top:0; width:100%; height:1.25rem; line-height:1.25rem; text-align:center; background:rgba(0,0,0,0.6); color:white;}
    </style>
    <script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
</head>
<body>
<div class="mui-content">
    <form action="" method="post">
        <div class="web-classify-seach">
            <a href="?mod=weixin&v_mod=category" class="web-classify-seach-cage tc cl_b9 fl">
                <i class="fa fa-navicon"></i>
                <p class="f12 cl_b3">分类</p>
            </a>
            <div class="web-classify-seach-text fl">
                <div class="mui-input-row mui-search fr14">
                    <input type="search" name="search" class="mui-input-clear" placeholder="请输入商品名称">
                </div>
            </div>
            <div class="cb"></div>
        </div>
    </form>
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
        <div class="web-cart-error tc" style="display: <?php echo $data['data']?'none':'block'; ?>">
            <img src="/template/source/default/images/no_order_i.png">
            <p class="fr16 cl_b3">抱歉！没有相关商品</p>
            <div class="mtr30 error-btn"><a href="?mod=weixin&v_mod=category">查看其他分类</a></div>
        </div>

        <div class="web-yp-product ">
            <ul class="web-yp-list">
                <?php
                if(!empty($data['data']))
                {
                    foreach($data['data'] as $item)
                    {
                        ?>
                        <li class="web-yp-item">
                            <a href="">
                                <p class="web-shop-name fr12"><?php echo $item['store_id']>0?$item['store_name']:'自营'; ?></p>
                                <img data-lazyload="<?php echo $item['product_img']; ?>" src="<?php echo $item['product_img']; ?>" class="web-yp-img lazy">
                                <div class="web-yp-body">
                                    <h1 class="omit fr14 cl_b3"><?php echo $item['product_name']; ?></h1>
                                    <div class="fr14 mtr5">
                                        <div class="fl red">
                                            ￥<span class="fr18"><?php echo $item['product_price']; ?></span>
                                        </div>
                                        <div class="fr cl_b9">
                                            <del>￥<?php echo $item['product_fake_price']; ?></del>
                                        </div>
                                        <div class="cb"></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <div class="cb"></div>
        </div>
    </div>
</div>
<div class="loadding-body" style="display: none">
    <span class="mui-spinner white"></span>
</div>
<script src="/template/source/weixin/js/mui.min.js"></script>
<script src="/template/source/weixin/js/mui.lazyload.js"></script>
<script src="/template/source/weixin/js/mui.lazyload.img.js"></script>
</body>
</html>