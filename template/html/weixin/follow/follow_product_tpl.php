<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetCollectProduct();
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
<div class="mui-content mhome">
    <div class="web-opder-nav">
        <a href="?mod=weixin&v_mod=follow&_index=_product" class="web-order-active fr14 cl_b3 tc">商品</a>
        <a href="?mod=weixin&v_mod=follow&_index=_shop" class="fr14 cl_b3 tc">店铺</a>
    </div>

    <div class="web-follow-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-error tc" style="display: <?php echo !$data['data']?'block':'none'; ?>;">
            <img src="/template/source/default/images/no_follow_i.png">
            <p class="fr16 cl_b3 mt10">看到喜欢的就收藏吧</p>
        </div>
        <div class="web-yp-product  mtr10">
            <ul class="web-yp-list">
                <?php
                    if($data['data'])
                    {
                        foreach($data['data'] as $val)
                        {
                            ?>
                            <li class="web-yp-item">
                                <a href="/?mod=weixin&v_mod=product&_index=_view&id=<?php echo $val['product_id']; ?>">
                                    <img src="/template/source/images/default.png" data-src="<?php echo $val['product_img']; ?>" class="web-yp-img lazy">
                                    <div class="web-yp-body">
                                        <h1 class="omit fr14 cl_b3"><?php echo $val['product_name']; ?></h1>
                                        <div class="fr14 mtr5">
                                            <div class="fl red">
                                                ￥<span class="fr18"><?php echo $val['product_price']; ?></span>
                                            </div>
                                            <div class="fr cl_b9">
                                                <del><?php echo $val['product_fake_price']; ?></del>
                                            </div>
                                            <div class="cb"></div>
                                        </div>
                                    </div>
                                </a>
                                <div class="web_follow_pro_num">
                                    <p class="fl fr12 cl_b9"><?php echo $val['collect_count']; ?>人收藏</p>
                                    <a href="javascript:;" cid="<?php echo $val['id']; ?>" class="fr del-colle cl_b3 fr12 ">取消</a>
                                    <div class="cb"></div>
                                </div>
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




<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/js/fastclick.js"></script>
<script src="/template/source/js/lazy-load-img.min.js"></script>
<script src="/template/source/js/guageEdit.js"></script>
<script src="/tool/layer/layer_mobile/layer.js"></script>
<script>
   

    $(".web-yp-list").on('click','.del-colle',function ()
    {
        var id = $(this).attr('cid');
        if(id<=0 || isNaN(id)){return;}
        var that = $(this);
        if(that.hasClass('disabled'))
        {
            return;
        }
        mui.confirm('确定要取消收藏吗',function (index)
        {
            if(index.index)
            {
                layer.open({type: 2});
                that.addClass('disabled');
                $.ajax({
                    type:'post',
                    url:'/?mod=weixin&v_mod=follow&_action=ActionDelCollectProduct',
                    data:{id:id},
                    dataType:'json',
                    success:function (data)
                    {
                        mui.toast(data.msg);
                        if(data.code==0)
                        {
                            that.parents("li").remove();
                        }
                        if($(".web-yp-list").children().length<=0)
                        {
                            $(".web-cart-error").show();
                        }
                        layer.closeAll();
                        $(this).removeClass('disabled');
                    },
                    error:function ()
                    {
                        layer.closeAll();
                        $(this).removeClass('disabled');
                    }
                });
            }else{
                console.log('取消操作');
            }
        });
    });
</script>
</body>
</html>