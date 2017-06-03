<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetGroupOrder();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>我的团</title>
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
        .no-fg-btn{background:#ff464e; color:white; padding:5px 8px; height:1.5rem; line-height: 1.5rem;  border-radius: 3px;  }
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body>
<div class="mui-content">
    <div class="web-opder-nav">
        <a href="/?mod=weixin&v_mod=group&_index=_order"
           class="<?php echo !isset($_GET['type'])?'web-order-active':''; ?> fr14 cl_b3 tc">全部</a>
        <a href="/?mod=weixin&v_mod=group&_index=_order&type=1"
           class="<?php echo isset($_GET['type']) && $_GET['type']==1?'web-order-active':''; ?> fr14 cl_b3 tc">待成团</a>
        <a href="/?mod=weixin&v_mod=group&_index=_order&type=2"
           class="<?php echo isset($_GET['type']) && $_GET['type']==2?'web-order-active':''; ?> fr14 cl_b3 tc">已成团</a>
        <a href="/?mod=weixin&v_mod=group&_index=_order&type=3"
           class="<?php echo isset($_GET['type']) && $_GET['type']==3?'web-order-active':''; ?> fr14 cl_b3 tc">拼团失败</a>
    </div>
    <div class="web-cart-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-product" id="load">
            <?php
                if($data['data'])
                {
                    foreach($data['data'] as $item)
                    {
                        ?>
                        <div class="web-cells">
                            <!--<div class="web-cell__title fr14">
                                <img src="http://www.xiangbaw.com/upload/larger/c07b2eb484525f7726993fe5baedda4689713.jpg"
                                     class="mr10" style="width:1.2rem; height: 1.2rem; display: inline-block; vertical-align: bottom;">测试<i class="ml10 fa fa-chevron-right fr12"></i>
                                <p class="fr fr14">状态</p>
                            </div>-->
                            <div class="web-cell" style="background:#f8f8f8;">
                                <div class="web-cell__hd"
                                     onclick="location.href='/?mod=weixin&v_mod=group&_index=_buy&group_id=<?php echo $item['group_id']; ?>'">
                                    <img src="<?php echo $item['product_img']; ?>" class="mr10" style="width: 4rem; height: 4rem; display: block; border-radius: 3px; ">
                                </div>
                                <div class="web-cell__bd" style="width:60%;">
                                    <div class="fr14">
                                        <span class="fl mr10 omit" style="width:65%" >
                                            <?php echo $item['pro_name']; ?>
                                        </span>
                                        <span class="fr red">￥<?php echo $item['group_price']; ?></span>
                                        <div class="cb"></div>
                                    </div>
                                    <?php
                                        if($item['atrr_name'])
                                        {
                                            ?>
                                            <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                                                <?php echo $item['atrr_name']; ?>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                                        <div class="fl">数量：<?php echo $item['product_count']; ?></div>
                                        <div class="fr"><span class="red"><?php echo $item['group_all_count']; ?></span>人团</div>
                                        <div class="cb"></div>
                                    </div>
                                    <div class="fr12">
                                    	<a href="/?mod=weixin&v_mod=group&_index=_order_details&id=<?php echo $item['gid']; ?>" class=" order-click no-fg-btn fr12 mr10 ">查看订单</a>
                                <a href="/?mod=weixin&v_mod=group&_index=_buy&group_id=<?php echo $item['group_id']; ?>" class="order-click no-fg-btn fr12 mr10">查看团购</a>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                        <?php
                    }
                }else{
                    ?>
                    <div class="web-cart-error tc" style="display: block;">
                        <img src="/template/source/default/images/no_order_i.png">
                        <p class="fr16 cl_b3">亲，暂无订单</p>
                        <div class="mtr30 error-btn"><a href="?mod=weixin">随便逛逛</a></div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>


<div onClick="window.location.href='/?mod=weixin&v_mod=user'" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>


<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script>
    $(".web-cart-product").on('click','.order-click',function ()
    {
        var attr = $(this).attr('cl');
        var orderid = $(this).attr('oid');
        if(orderid =='' || attr==''){return;}
        switch (attr)
        {
            case 'pay':
                location.href='?mod=weixin&v_mod=checkout&_index=_pay&orderid='+orderid;
                break;
            case 'sh':
                shounhuo(orderid);
                break;
        }
    });

    var pages = <?php echo $data['pages']; ?>;
    if(pages>1)
    {
        layui.use('flow', function()
        {
            var flow = layui.flow;
            flow.load({
                elem: '#load'
                ,done: function(page, next)
                {
                    var lis = [];
                    $.getJSON('/?mod=weixin&v_mod=group&_index=_order&page='+page, function(res)
                    {
                        //假设你的列表返回在data集合中
                        layui.each(res.data, function(index, item)
                        {
                            lis.push(' <div class="web-cells">'
                            +'    <!--<div class="web-cell__title fr14">'
                            +'<img src="http://www.xiangbaw.com/upload/larger/c07b2eb484525f7726993fe5baedda4689713.jpg"'
                            +'class="mr10" style="width:1.2rem; height: 1.2rem; display: inline-block; vertical-align: bottom;">测试<i class="ml10 fa fa-chevron-right fr12"></i>'
                            +'<p class="fr fr14">状态</p>'
                            +'</div>-->'
                            +'<div class="web-cell" style="background:#f8f8f8;">'
                            +'<div class="web-cell__hd"'
                            +'onclick="location.href=\'/?mod=weixin&v_mod=group&_index=_buy&group_id='+item.group_id+'\'">'
                            +'    <img src="'+item.product_img+'" class="mr10" style="width: 4rem; height: 4rem; display: block; border-radius: 3px; ">'
                            +'</div>'
                            +'<div class="web-cell__bd" style="width:60%;">'
                            +'<div class="fr14">'
                            +'<span class="fl mr10 omit" style="width:65%" >'
                            +item.pro_name
                            +'</span>'
                            +'<span class="fr red">￥'+item.group_price+'</span>'
                            +'<div class="cb"></div>'
                            +'</div>'
                            +'<div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">'+item.atrr_name+'</div>'
                            +'<div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">'
                            +'<div class="fl">数量：'+item.product_count+'</div>'
                            +'<div class="fr"><span class="red">'+item.group_all_count+'</span>人团</div>'
                            +'<div class="cb"></div>'
                            +'</div>'
                            +'<div class="fr12">'
                            +'<a href="/?mod=weixin&v_mod=group&_index=_order_details&id='+item.gid+'" class=" order-click no-fg-btn fr12 mr10 ">查看订单</a>'
                            +'<a href="/?mod=weixin&v_mod=group&_index=_buy&group_id='+item.group_id+'" class="order-click no-fg-btn fr12 mr10">查看团购</a>'
                            +'</div>'
                            +'</div>'
                            +'</div>'
                            +'</div>');
                        });
                        next(lis.join(''), page < res.pages);
                    });
                }
            });
        });
    }
</script>
</body>
</html>