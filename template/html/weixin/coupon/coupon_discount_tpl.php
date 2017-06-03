<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetDiscountCoupon();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>我的折扣券</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?666666">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .discountTab{top:.9rem}
        .return{position:fixed; left: 4%; bottom:.4rem;}
        .return>a{width:.6rem; height:.6rem; background:rgba(0,0,0,0.7); display: block; text-align: center; line-height: .6rem;}

    </style>
</head>
<body>
<div class="n-tabs">
	<a href="/?mod=weixin&v_mod=coupon&_index=_list" class="sz14r">优惠券</a>
	<a href="/?mod=weixin&v_mod=coupon&_index=_discount" class="sz14r n-active">折扣券</a>
</div>

<div style="height:1.2rem"></div>
<div class="discountcontainer">
    <div class="discountwarp">
        <?php
        if (!empty($data))
        {
         $discount=$obj->GetDiscountCouponPer()
            ?>
            <div class="discountwarp-item">
                <div class="fl disprice sz16r">
                    <b style="font-size: 0.6em">
                        折扣券
                    </b>
                    <p style="">
                        剩余金额￥ <?php echo $data['gift_balance']; ?>
                    </p>
                </div>
                <div class="fl distext">
                    <h1>
                        购物金额满100元使用本券可享受<?php echo (1-$discount)*10; ?>折优惠
                    </h1>
                </div>
                <div class="clearfix"></div>
            </div>
    </div>
</div>
<?php
}else
{?>
    <div class="search-empty-panel">
        <div class="content">
            <img src="/template/source/images/no_content.png">
            <div class="text">暂无可用折扣券</div>
        </div>
    </div>
<?php
} ?>
<div class="return">
    <a href="/?mod=weixin&v_mod=user" class="glyphicon glyphicon-arrow-left fffColor sz14r"></a>
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
        $("#closediv").click(function(){
            $("#iosDialog2").hide();
        })

    })
</script>
</body>
</html>