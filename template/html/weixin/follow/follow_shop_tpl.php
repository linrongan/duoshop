<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetFollowShop();
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
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body class="mhome" >

<div class="mui-content">
    <div class="web-opder-nav">
        <a href="?mod=weixin&v_mod=follow&_index=_product" class="fr14 cl_b3 tc">商品</a>
        <a href="?mod=weixin&v_mod=follow&_index=_shop" class="web-order-active fr14 cl_b3 tc">店铺</a>
    </div>

    <div class="web-follow-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-error tc" style="display: <?php echo $data['data']?'none':'block'; ?>;">
            <img src="/template/source/default/images/no_follow_i.png">
            <p class="fr16 cl_b3 mt10">看到喜欢的就关注吧</p>
        </div>
        <div class="web-follow-warp">
            <?php
                if($data['data'])
                {
                    foreach($data['data'] as $item)
                    {
                        ?>
                        <div class="web-cells">
                            <div class="web-cell">
                                <div class="web-cell__hd">
                                    <a href="javascript:;">
                                        <img src="/template/source/images/default.png" data-src="<?php echo $item['store_logo']; ?>" style="height:3rem; width:4rem; display: block; margin-right: 10px; ">
                                    </a>
                                </div>
                                <div class="web-cell__bd">
                                    <p class="fr14 "><a href="/<?php echo $item['store_url']; ?>" class="cl_b3"><?php echo $item['store_name']; ?></a></p>
                                    <p  class="fr12 cl_b9 mt5"><?php echo $item['follow_count']; ?>人关注</p>
                                </div>
                                <div class="web-cell__ft">
                                    <a href="javascript:;" fid="<?php echo $item['id']; ?>" class="cl_b3 del-follow fr14"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</div>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/js/fastclick.js"></script>
<script src="/template/source/js/lazy-load-img.min.js"></script>
<script src="/template/source/js/guageEdit.js"></script>
<script src="/tool/layer/layer_mobile/layer.js"></script>
<script>



    $(".web-follow-warp").on('click','.del-follow',function ()
    {
        var id = $(this).attr('fid');
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
                    url:'/?mod=weixin&v_mod=follow&_action=ActionDelFollowShop',
                    data:{id:id},
                    dataType:'json',
                    success:function (data)
                    {
                        mui.toast(data.msg);
                        if(data.code==0)
                        {
                            that.parents(".web-cells").remove();
                        }
                        if($(".web-follow-warp").children().length<=0)
                        {
                            $(".web-cart-error").show();
                        }
                        layer.closeAll();
                        that.removeClass('disabled');
                    },
                    error:function ()
                    {
                        layer.closeAll();
                        that.removeClass('disabled');
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