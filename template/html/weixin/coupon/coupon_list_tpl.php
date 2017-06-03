<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetValidCouponList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>我的优惠券</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?7777aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .discountTab{top:.9rem}
        .return{position:fixed; left: 4%; bottom:.4rem;}
        .return>a{width:.6rem; height:.6rem; background:rgba(0,0,0,0.7); display: block; text-align: center; line-height: .6rem;}
		
    </style>
</head>
<body>


<div class="n-tabs">
	<a href="javascript:;" class="sz14r n-active">优惠券</a>
	<a href="/?mod=weixin&v_mod=coupon&_index=_discount" class="sz14r">折扣券</a>
</div>
<div class="discountTab">
    <a href="javascript:;" class="on_active sz14r cl999">未使用</a>
    <a href="/?mod=weixin&v_mod=coupon&_index=_used" class="sz14r cl999">已使用</a>
    <a href="/?mod=weixin&v_mod=coupon&_index=_expire" class="sz14r cl999">已过期</a>
</div> 



<div style="height:2rem"></div>
<div class="discountcontainer">
    <div class="discountwarp">
        <?php
        if (!empty($data['data']))
        {
        foreach($data['data'] as $item)
        {?>
        <div class="discountwarp-item" id="<?php echo $item['coupon_code']; ?>">
            <div class="fl disprice sz16r">
                ￥<b><?php echo $item['coupon_money']; ?></b>
                 <p style=""><?php echo $item['min_money']?'满'.$item['min_money'].'可用':'无门槛';?></p>
            </div>
            <div class="fl distext">
                <h1>
                    <?php echo $item['coupon_name']; ?>
                </h1>
                <p class="omit sz12r"><?php
                    if($item['store_id']){
                        if(!empty($item['category_name'])){
                            echo "仅可购买[{$item['store_name']}]的{$item['category_name']}商品";
                        }else{
                            echo "限购[{$item['store_name']}]店铺商品";
                        }
                    }else{
                        echo "店铺通用";
                    }
                    ?></p>
                <p>
                    <?php echo $item['start_time'];?>-<?php echo $item['expire_time'];?>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<?php }
else
{?>
    <div class="search-empty-panel">
        <div class="content">
            <img src="/template/source/images/no_content.png">
            <div class="text">暂无优惠券</div>
        </div>
    </div>
<?php
} ?>
<div class="return">
    <a href="/?mod=weixin&v_mod=user" class="glyphicon glyphicon-arrow-left fffColor sz14r" ></a>
</div>


<div id="dialogs">
    <div class="js_dialog" id="iosDialog2" style="opacity: 1;display: none">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__bd">
                <div id="qrcode_img"></div>
            </div>
            <div class="weui-dialog__ft">
                <a id="closediv" href="/?mod=weixin&v_mod=coupon&_index=_list" class="weui-dialog__btn weui-dialog__btn_primary">关闭窗口</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/qrcode/jquery.qrcode.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/qrcode/qrcode.js"></script>
<script>
    $(function(){
        $(".discountTab>a").click(function()
        {
            $(this).addClass("on_active").siblings().removeClass("on_active");
            var _index = $(this).index();
            $(".discountcontainer .discountwarp").eq(_index).show().siblings().hide();
        })



        /*$(".discountwarp-item").click(function()
        {
            if (!$(this).hasClass('cannothx'))
            {
                $('#qrcode_img').empty();
                var code=$(this).attr('id');
                $('#qrcode_img').qrcode({
                    // render	: "table",
                    width:200,
                    height:200,
                    text	: code
                });
                $("#iosDialog2").show();
            }else
            {
                layer.open({
                    content: '该礼品已经核销过了',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
        })*/

        $("#closediv").click(function(){
            $("#iosDialog2").hide();
        })

    })
</script>
</body>
</html>