<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user = $obj->GetUserInfo(SYS_USERID);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css?7777asdasd">
    <style>
		.web-cell:before{border-top:none;}
		.web-cells:before{border-top:none;}
		.web-cells:after{border-bottom:none;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body>

<div class="mui-content">

    <div class="web-user-header">
        <div class="web-user-button tr">
            <a href="<?php echo WEBURL.'/?mod=weixin&v_mod=user&_index=_info&v_shop='.$v_shop.''; ?>" class="mr5 white fr18">
                <i class="fa fa-gear"></i>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weixin&v_mod=user&_index=_message&v_shop='.$v_shop.''; ?>" class="white fr18">
                <i class="fa fa-commenting-o"></i>
            </a>
        </div>
        <div class="web-user-mess">
            <div class="web-mess-img"><img src="<?php echo $user['headimgurl']; ?>" class="mrr10"> </div>
            <div class="web-mess-body">
                <p class="fr16 white"><?php echo $user['nickname']; ?></p>
                <div class="mtr5 web-label f12">
                    <span><i class="fa fa-vimeo"></i> VIP1</span>
                    <span><i class="fa fa-diamond"></i> 钻石</span> 
                </div>
            </div>
        </div>
    </div>

    <div class="web-content">
        <div class="web-cells" style="margin-top: 0;">
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=order&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access">
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的订单</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
        </div>
        <div class="web-opder-nav">
            <a href="/?mod=weidian&v_mod=order&v_shop=<?php echo $_GET['v_shop']; ?>&type=1" class="tc">
                <img src="/template/source/default/images/images/user_opder_1.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">待付款</p>
            </a>
            <a href="/?mod=weidian&v_mod=order&v_shop=<?php echo $_GET['v_shop']; ?>&type=2" class="tc">
                <img src="/template/source/default/images/images/user_opder_2.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">待发货</p>
            </a>
            <a href="/?mod=weidian&v_mod=order&v_shop=<?php echo $_GET['v_shop']; ?>&type=3" class="tc">
                <img src="/template/source/default/images/images/user_opder_3.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">待收货</p>
            </a>
            <a href="/?mod=weidian&v_mod=order&_index=_back&v_shop=<?php echo $_GET['v_shop']; ?>" class="tc">
                <img src="/template/source/default/images/images/user_opder_4.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">退货/售后</p>
            </a>
        </div>

        <div class="web-cells" >
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=follow&_index=_product&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_1.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的关注</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=discount&_index=_no&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_2.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">优惠券</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=wallet&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_3.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的钱包</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=address&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_4.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">收货地址</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
        </div>


        <div class="web-cells" >
            <a href="<?php echo WEBURL.'/?mod=weixin&v_mod=user&_index=_service&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_5.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">客服服务</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=activity&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_6.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">活动中心</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>

        </div>
    </div>
</div>
<!----底部导航---->
<?php include "footer_tpl.php"; ?>

<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script>
	$(function(){
		$('.web-footer>a').eq(3).addClass('web-activer').siblings().removeClass('web-activer');	
	})
</script>
</body>
</html>