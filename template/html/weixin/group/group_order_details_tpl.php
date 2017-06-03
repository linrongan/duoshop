<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetGroupOrderDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone = no"/>
    <title><?php echo WEBNAME; ?></title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?66666aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <script src="/template/source/js/jquery-1.10.1.min.js"></script>
    <style>
        .weui-cell{padding:.14rem 3%;}
        .weui-cells::before,.weui-cells::after,.weui-cells .weui-cell::before{border:none;}
        .weui-cell:before{left:0;}
        .wuliu-btn{display:inline-block; padding:3px 8px; border:1px solid #333; border-radius:3px; color:#333;}
        .porduct_hd{background:white; border-bottom:none; padding:.1rem 3%;}
        .porduct_jshao:last-child{border-bottom:none;}
        .noborder .weui-cell{padding:0 3%; line-height:.5rem;}
		.gradient .weui-cell{min-height:2rem; background-image:-webkit-linear-gradient(to right, #ff8e01, #fe5200); background-image:linear-gradient(to right,#ff8e01, #fe5200);}
		.gradient .weui-cell::after{content:''; width:2rem; height:1.3rem; background:url(/template/source/images/shouhuo.png) center center no-repeat; background-size:100% 100%; position:absolute; top:50%; margin-top:-.66rem; right:10%;}
    </style>
</head>
<body>

<div class="weui-cells gradient" style="margin-top:0;">
	<div class="weui-cell">
    	<div class="weui-cell__bd sz16r" style="color:white;">
            <?php
                switch ($data['group_status'])
                {
                    case -1:
                        $str = '未成团 拼团失败';
                        break;
                    case 1:
                        $str = '拼团中';
                        break;
                    case 2:
                        $str = '拼团成功 已生成订单';
                        break;
                }
                echo $str;
            ?>
        </div>
    </div>
</div>

<div class="weui-cells" style="margin-top:0;">
    <div class="weui-cell" style=" border-bottom:1px solid #e8e8e8;">
        <div class="weui-cell__hd">
            <span class="sz14r cl999">收货人：</span>
        </div>
        <div class="weui-cell__bd">
            <span class="sz14r cl999"><?php echo $data['shop_name']; ?></span>
        </div>
        <div class="weui-cell__ft">
            <span class="sz14r cl999"><?php echo $data['shop_phone']; ?></span>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r cl999">收货地址：</span>
        </div>
        <div class="weui-cell__bd">
            <span class="sz14r cl999"><?php echo $data['shop_province'],$data['shop_city'],$data['shop_area'],$data['shop_address']; ?></span>
        </div>
    </div>
</div>

<div class="mtr02" >
    <div class="porduct_hd" style="height:.8rem;" >
        <img src="<?php echo $data['store_logo']; ?>"  alt="" style="height:100%; display:inline-block; vertical-align:middle; margin-top:-5px;">
        <span class="sz14r"><?php echo $data['store_name']; ?></span>
    </div>
    <div class="porduct_jshao">
        <div class="fl l_porpic" onclick="location.href=''">
            <img src="<?php echo $data['product_img']; ?>">
        </div>
        <div class="fl r_porname">
            <p class="porduct_name tlie sz14r"><?php echo $data['pro_name']; ?></p>
            <div class="mtr01 sz12r">
                价格：<span class="redColor">￥<?php echo $data['group_price']; ?></span>
            </div>
            <div class="sz12r"></div>
        </div>
        <div class="clearfix"></div>
        <div class="Npricenum sz14r redColor">×<?php echo $data['product_count']; ?></div>
    </div>
</div>
<div class="weui-cells noborder" style="margin-top:0;">
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r">运费：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r">￥<?php echo $data['ship_fee']; ?></span>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r ">订单金额：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r">￥<?php echo $data['group_total']; ?></span>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r ">实付款：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r">￥<?php echo $data['pay_money']; ?></span>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r ">支付方式：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r"><?php echo $data['pay_method']=='user_money'?'余额支付':'微信支付'; ?></span>
        </div>
    </div>
</div>
<!--<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r ">备注：</span>
        </div>
        <div class="weui-cell__bd">
            <p class="sz14r"></p>
        </div>
        <div class="weui-cell__ft">
        </div>
    </div>
</div>-->
<div class="weui-cells noborder">
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r">订单编号：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r"><?php echo $data['orderid']; ?></span>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r ">订单时间：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r"><?php echo $data['addtime']; ?></span>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r ">付款时间：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r"><?php echo $data['pay_date']; ?></span>
        </div>
    </div>
</div>
<div onClick="history.back()" style="width:0.6rem; height:0.6rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:0.4rem 0.4rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>
</body>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script>
        function layer_msg(msg) {
            layer.open({
                content: msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
        }
</script>
</html>
