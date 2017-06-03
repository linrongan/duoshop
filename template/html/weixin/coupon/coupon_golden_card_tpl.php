<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user = $obj->GetUserInfo(SYS_USERID);
$golden_card = $obj->GetGoldenCardMoney();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的金卡</title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/jquery-weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/rest.css?66666">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/webapp.css">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/weixin/css/cart.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/sec.kill.css?777777">
    <style>
        .vip-header{background:#f6f6f6; padding:1rem 1rem 0;}
        .vip-header-box{min-height:100px; border-radius:10px 10px 0 0; background:#f5cc02; padding:.75rem;}
        .vip-header-box .vip-box-text{line-height:1.5rem; }
        .vip-content{padding:.5rem;}
        .weui-cells-not::before,.weui-cells-not::after,.weui-cells-not .weui-cell::before,.weui-cells-not .weui-cell::after{border:none;}
        .vip-ling-btn{position:fixed; bottom:0; left:0; width:100%;}
        .vip-ling-box{height: 2.25rem; line-height: 2.25rem; text-align:center; background:#ff0000;}
        .vip-ling-box a{color:white;}
    </style>
</head>
<body style="background:white;">

<div class="vip-header">
    <div class="vip-header-box">
        <div class="vip-box-text white rf16">金卡金额</div>
        <div class="vip-box-text white rf16"><?php echo $user['gift_balance_status']==1?$user['gift_balance']:$golden_card;?></div>
    </div>
</div>
<div class="vip-content">
    <h1 class="rf15">金卡特权</h1>
    <div class="weui-cells weui-cells-not" style="margin-top:0;">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <img src="/template/source/default/images/shen.png" style="width:2rem; height:2rem; margin-right:.5rem; display:block;">
            </div>
            <div class="weui-cell__bd">
                <h1 class="rf14">下单立减</h1>
                <p class="rf13 cl_b9 mt5">下单自动抵扣现金</p>
                <p class="rf13 cl_b9">会员专享</p>
            </div>
        </div>
    </div>
    <h1 class="rf15">金 卡 说 明</h1>
    <p style="width:100%; height:1px; border-bottom:1px solid #ededed;" class="rmt10 rmb10"></p>
    <div class="vip-textreae" style="line-height:1rem;">
        <p class="rf12 cl_b9 rmt5">1、你可以使用金卡，在订单结算时系统会自动抵扣现金</p>
        <p class="rf12 cl_b9 rmt5">2、金卡不可用于团购、秒杀、砍价、积分兑换商品</p>
        <p class="rf12 cl_b9 rmt5">3、一个账号只能使用一张金卡，且不限制每次使用抵扣的金额，购买金额越大抵扣金额就越大</p>
        <p class="rf12 cl_b9 rmt5">4、若金卡超出有效期或使用金额用尽后，将自动失效</p>
        <p class="rf12 cl_b9 rmt5">5、活动最终解释权归乡粑网所有</p>

    </div>


</div>
<!--
<div onClick="window.location.href='/?mod=weixin&v_mod=user'" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;"></div>
-->
<div style="height:2.25rem;"></div>
<div id="golden_card_btn">
<?php
    if($user['gift_balance_status']==0)
    {
        ?>
        <div class="vip-ling-btn">
            <div class="vip-ling-box">
                <a href="javascript:;" class="rf16" onclick="onGoldenCard()" style="display: block">金卡领取</a>
            </div>
        </div>
        <?php
    }else
    {
        ?>
        <div class="vip-ling-btn">
            <div class="vip-ling-box">
                <a href="/?mod=weixin" class="rf16" style="display: block">前去购物</a>
            </div>
        </div>
        <?php
    }
?>
</div>


<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/template/source/weixin/js/fastclick.js"></script>
<script src="/template/source/weixin/js/jquery-weui.min.js"></script>
<script src="/template/source/weixin/js/city-picker.js"></script>
<script src="/template/source/weixin/js/guageEdit.js"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>

<script>
    function onGoldenCard()
    {
        $.ajax({
            cache:false,
            type:"POST",
            url:"/?mod=weixin&v_mod=coupon&_action=ActionOnGoldenCard",
            //data:{'id':id},
            dataType:"json",
            success:function(result) {
                if (result.code==0)
                {
                    $('#golden_card_btn').html('<div class="vip-ling-btn">'+
                        '<div class="vip-ling-box">'+
                        '<a href="/?mod=weixin" class="rf16">前去购物</a>'+
                        '</div>'+
                        '</div>');
                }
                layer_msg(result.msg);
            },
            error:function(result) {
                layer_msg("网络超时,请重试!");
            }
        });
    }
    function layer_msg(msg)
    {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }
</script>
</body>
</html>