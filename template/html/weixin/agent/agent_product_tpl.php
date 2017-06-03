<?php
/*代发产品*/
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}



$data = $obj->GetAgentProduct();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>一件代发</title>
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
        .apply-sort-active{color: #ff574a;}
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
    <form action="/?mod=weixin&v_mod=agent&_index=_product<?php echo (isset($_GET['category'])?'&category='.$_GET['category']:'').$data['canshu'].$data['sort_canshu']; ?>" method="post">
        <div class="web-classify-seach">
            <a href="?mod=weixin&v_mod=category&back=<?php echo urlencode('/?mod=weixin&v_mod=agent&_index=_product'.$data['canshu'].$data['sort_canshu']); ?>" class="web-classify-seach-cage tc cl_b9 fl">
                <i class="fa fa-navicon"></i>
                <p class="f12 cl_b3">分类</p>
            </a>
            <div class="web-classify-seach-text fl">
                <div class="mui-input-row mui-search fr14">
                    <input type="search" name="search" value="<?php echo isset($_REQUEST['search'])?$_REQUEST['search']:''; ?>" class="mui-input-clear" placeholder="请输入商品名称">
                </div>
            </div>
            <div class="cb"></div>
        </div>
    </form>
    <div class="shop-product-sort mtr10 apply-product-sort">
        <a href="javascript:;" class="tc cl_b3 <?php echo $data['sort']=='zh'?'apply-sort-active':''; ?>">
            <span class="fr14">综合</span>
        </a>
        <a href="javascript:;" class="tc cl_b3 <?php echo $data['sort']=='xl'?'apply-sort-active':''; ?>">
            <span class="fr14">销量</span>
        </a>
        <a href="javascript:;" class="tc cl_b3 <?php echo $data['sort']=='xp'?'apply-sort-active':''; ?>">
            <span class="fr14">新品</span>
        </a>
        <a href="javascript:;" class="tc cl_b3 <?php echo $data['sort']=='jg-a' || $data['sort']=='jg-d'?'apply-sort-active':''; ?>">
                <span class="fr14">
                    价格
                </span>
            <div class="price-sort">
                <!----价格标识样式 在P标签加class="red"--->
                <p class="<?php echo $data['sort']=='jg-a'?'red':''; ?>"><i class="fa fa-caret-up"></i></p>
                <p class="<?php echo $data['sort']=='jg-d'?'red':''; ?>"><i class="fa fa-caret-down"></i></p>
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
                            <a href="?mod=weixin&v_mod=agent&_index=_product_view&id=<?php echo $item['product_id']; ?>">
                                <p class="web-shop-name fr12"><?php echo $item['store_name']; ?></p>
                                <img data-lazyload="<?php echo $item['product_img']; ?>" src="<?php echo $item['product_img']; ?>" class="web-yp-img lazy">
                                <div class="web-yp-body">
                                    <h1 class="omit fr14 cl_b3"><?php echo $item['product_name']; ?></h1>
                                    <div class="fr14 mtr5">
                                        <div class="fl red">
                                            ￥<span class="fr18"><?php echo $item['agent_price']; ?></span>
                                        </div>
                                        <div class="fr cl_b9">
                                            <del>￥<?php echo $item['product_price']; ?></del>
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
<script src="/tool/layer/layui/layui/layui.js"></script>
<script>
    var filter = {
        zh:<?php echo $data['sort']=='zh'?1:0; ?>,
        xl:<?php echo $data['sort']=='xl'?1:0; ?>,
        xp:<?php echo $data['sort']=='xp'?1:0; ?>,
        jga:<?php echo $data['sort']=='jg-a'?1:0; ?>,
        jgd:<?php echo $data['sort']=='jg-d'?1:0; ?>
    };
    $(".apply-product-sort>a").click(function ()
    {
        var index = $(this).index();
        switch (index )
        {
            case 0:
                filter.zh = 1;
                filter.xl = 0;
                filter.xp = 0;
                filter.jga = 0;
                filter.jgd = 0;
                break;
            case 1:
                filter.zh = 0;
                filter.xl = 1;
                filter.xp = 0;
                filter.jga = 0;
                filter.jgd = 0;
                break;
            case 2:
                filter.zh = 0;
                filter.xl = 0;
                filter.xp = 1;
                filter.jga = 0;
                filter.jgd = 0;
                break;
            case 3:
                filter.zh = 0;
                filter.xl = 0;
                filter.xp = 0;
                filter.jgd = 0;
                if(filter.jga==0)
                {
                    filter.jga = 1;
                }else{
                    if(filter.jga==1)
                    {
                        filter.jgd = 1;
                        filter.jga = 0;
                    }
                }
                break;
        }
        var canshu = '';
        canshu += '&sort='+(filter.zh?'zh':'')+(filter.xl?'xl':'')+(filter.xp?'xp':'')+(filter.jga?'jg-a':'')+(filter.jgd?'jg-d':'');
        if(canshu)
        {
            location.href='/?mod=weixin&v_mod=agent&_index=_product<?php echo $data['canshu'];?>'+canshu;
        }
    });

    layui.use('flow', function(){
        var flow = layui.flow;
        flow.load({
            elem: '.web-yp-list' //指定列表容器
            ,done: function(page, next)
            {
                var lis = [];
                $.getJSON('<?php echo $_SERVER['REQUEST_URI']; ?>&page='+page, function(res)
                {
                    layui.each(res.data, function(index, item)
                    {
                        lis.push('<li class="web-yp-item">'
                            +'   <a href="?mod=weixin&v_mod=agent&_index=_product_view&id='+item.product_id+'">'
                            + '<p class="web-shop-name fr12">'+item.store_name+'</p>'
                            + '<img data-lazyload="'+item.product_img+'" src="'+item.product_img+'" class="web-yp-img lazy">'
                            + '<div class="web-yp-body">'
                            + '<h1 class="omit fr14 cl_b3">'+item.product_name+'</h1>'
                            + '<div class="fr14 mtr5">'
                            + '<div class="fl red">'
                            + '￥<span class="fr18">'+item.xp+'</span>'
                            + '</div>'
                            + '<div class="fr cl_b9">'
                            + '<del>￥'+item.product_price+'</del>'
                            + '</div>'
                            + '<div class="cb"></div>'
                            + '</div>'
                            + '</div>'
                            + '</a>'
                            + '</li>');
                    });
                    next(lis.join(''), page < res.pages);
                });
            }
        });
    });
</script>
</body>
</html>