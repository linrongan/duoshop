<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetOrder(true);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>全部订单</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-opder-nav{padding:0; border-bottom:1px solid #e8e8e8;}
        .web-opder-nav>a{padding:.5rem 0;}
        .web-yp-title>span{color:#999999;}
        .web-yp-title>span::before{border-color:#999999}
        .web-yp-title>span::after{border-color:#999999;}
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell__title,.web-cell__text{padding:.5rem 3%;}
        .web-cell:before{border-top:none;}
        .web-cell__text{line-height: 1.5rem;}
        .no-fg-btn{background:#ff464e; color:white; padding:0 10px; height:1.5rem; line-height: 1.5rem;  border-radius: 3px;  }

    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body>
<div class="mui-content">
    <div class="web-opder-nav">
        <a href="?mod=weidian&v_mod=order&v_shop=<?php echo $_GET['v_shop']; ?>" class="<?php echo !isset($_GET['type'])?'web-order-active':''; ?> fr14 cl_b3 tc">全部订单</a>
        <a href="?mod=weidian&v_mod=order&v_shop=<?php echo $_GET['v_shop']; ?>&type=1" class="fr14 <?php echo isset($_GET['type']) && $_GET['type']==1?'web-order-active':'';?> cl_b3 tc">待付款</a>
        <a href="?mod=weidian&v_mod=order&v_shop=<?php echo $_GET['v_shop']; ?>&type=2" class="fr14 <?php echo isset($_GET['type']) && $_GET['type']==2?'web-order-active':'';?> cl_b3 tc">待发货</a>
        <a href="?mod=weidian&v_mod=order&v_shop=<?php echo $_GET['v_shop']; ?>&type=3" class="fr14 <?php echo isset($_GET['type']) && $_GET['type']==3?'web-order-active':'';?> cl_b3 tc">待收货</a>
    </div>
    <div class="web-cart-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-product">
            <?php
                if($data['code']==0)
                {
                    foreach($data['data'] as $item)
                    {
                        ?>
                        <div class="web-cells ">
                             <div class="web-cell__title fr14">
                                 订单号：<?php echo $item['orderid']; ?>
                             </div>
                           <!-- <div class="web-cell__title fr14">
                                <img src="/template/source/default/images/tianmao.jpg" class="mr10" style="width:1.2rem; height: 1.2rem; display: inline-block; vertical-align: bottom;">宇轩中西餐厅<i class="ml10 fa fa-chevron-right fr12"></i>
                            </div>-->
                            <?php
                                foreach($item['details'] as $val)
                                {
                                    ?>
                                    <div class="web-cell" style="background:#f8f8f8;">
                                        <div class="web-cell__hd">
                                            <a href="">
                                                <img src="<?php echo $val['product_img']; ?>" class="mr10" style="width: 4rem; height: 4rem; display: block; border-radius: 3px; ">
                                            </a>
                                        </div>
                                        <div class="web-cell__bd">
                                            <div class="fr14">
                                        <span class="fl mr10 omit" style="width:65%" >
                                            <a href="" class="cl_b3"><?php echo $val['product_name']; ?></a>
                                        </span>
                                                <span class="fr red">￥<?php echo $val['product_price']; ?></span>
                                                <div class="cb"></div>
                                            </div>
                                            <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                                                颜色：黑红 尺码：#41
                                            </div>
                                            <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                                                数量：<?php echo $val['product_count']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                            <div class="web-cell__text fr12">
                                共<span class="red"><?php echo $item['order_pro_count']; ?></span>件 合计：<span class="red">￥<?php echo $item['order_total']; ?></span>（含运费￥0.00）
                                <a href="javascript:;" class="fr no-fg-btn fr14 ">去付款</a>
                                <div class="cb"></div>
                            </div>
                        </div>
                        <?php
                    }
                }else{
                    ?>
                    <div class="web-cart-error tc" style="display: block;">
                        <img src="/template/source/default/images/no_order_i.png">
                        <p class="fr16 cl_b3">亲，暂无订单</p>
                        <div class="mtr30 error-btn"><a href="<?php echo WEBURL.'/'.$v_shop; ?>">随便逛逛</a></div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>




<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script>
  /*  layui.use('flow', function(){
        var $ = layui.jquery; //不用额外加载jQuery，flow模块本身是有依赖jQuery的，直接用即可。
        var flow = layui.flow;
        flow.load({
            elem: '.web-cart-product' //指定列表容器
            ,done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
                var lis = [];
                //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
            }
        });
    });*/
</script>
</body>
</html>