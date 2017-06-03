<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user = $obj->GetUserInfo(SYS_USERID);
$order_count = $obj->GetOrderStatusCount();
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
    <link rel="stylesheet" href="/template/source/weixin/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/rest.css">
    <link rel="stylesheet" href="/template/source/weixin/css/main.css?7777asdasd">
    <style>
        .web-cell:before{border-top:none;}
        .web-cells:before{border-top:none;}
        .web-cells:after{border-bottom:none;}
		.web-access{
			content: " ";
			display: inline-block;
			height: 10px;
			width: 10px;
			border-width: 2px 2px 0 0;
			border-color: white;
			border-style: solid;
			-webkit-transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
			transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
			position: relative;
			top: -2px;
			position: absolute;
			top: 50%;
			margin-top: -8px;
			right: 10px;	
		}
		.y_value>span{ width:15px; height:15px; text-align:center; line-height:15px; border-radius:50%; background:#ff0000; position:absolute; top:-4px; left:50%; font-size:12px; color:white;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body>

<div class="mui-content">

    <div class="web-user-header">
        <div class="web-user-button tr">
        	<!--
            <a href="?mod=weixin&v_mod=user&_index=_info" class="mr5 white fr18">
                <i class="fa fa-gear"></i>
            </a>
            -->
            <a href="/?mod=weixin&v_mod=notice" class="white fr18">
                <i class="fa fa-commenting-o"></i>
            </a>
        </div>
        <div class="web-user-mess" onClick="window.location.href='?mod=weixin&v_mod=user&_index=_info'">
            <div class="web-mess-img"><img src="<?php echo $user['headimgurl']; ?>" class="mrr10"> </div>
            <div class="web-mess-body">
                <p class="fr16 white"><?php echo $user['nickname']; ?></p>
                <div class="mtr5 web-label f12">
                    <?php
                        if($user['vip_lv'])
                        {
                            echo '<span><i class="fa fa-vimeo"></i> VIP'.$user['vip_lv'].'</span>';
                        }
                    ?>
                   <!-- <span><i class="fa fa-diamond"></i> 钻石</span>-->
                </div>
            </div>
           <div class="web-access"></div>
        </div>
    </div>

    <div class="web-content">
        <div class="web-cells" style="margin-top: 0;">
            <a href="?mod=weixin&v_mod=order" class="web-cell web-cell_access">
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的订单</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
        </div>
        <div class="web-opder-nav">
            <a href="/?mod=weixin&v_mod=order&type=1" class="tc y_value">
                <?php
                if($order_count['not_pay'])
                {
                    echo '<span>'.$order_count['not_pay'].'</span>';
                }
                ?>
                <img src="/template/source/default/images/images/user_opder_1.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">待付款</p>
            </a>
            <a href="/?mod=weixin&v_mod=group&_index=_order&type=1" class="tc y_value">
                <?php
                    if($order_count['group_total'])
                    {
                        echo '<span>'.$order_count['group_total'].'</span>';
                    }
                ?>
                <img src="/template/source/weixin/images/images/pin_wait.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">待成团</p>
            </a>
            <a href="/?mod=weixin&v_mod=order&type=3" class="tc y_value">
                <?php
                if($order_count['seed_goods'])
                {
                    echo '<span>'.$order_count['seed_goods'].'</span>';
                }
                ?>
                <img src="/template/source/default/images/images/user_opder_2.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">待发货</p>
            </a>
            <a href="/?mod=weixin&v_mod=order&type=4" class="tc y_value">
                <?php
                if($order_count['get_goods'])
                {
                    echo '<span>'.$order_count['get_goods'].'</span>';
                }
                ?>
                <img src="/template/source/default/images/images/user_opder_3.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">待收货</p>
            </a>

            <a href="?mod=weixin&v_mod=order&_index=_service" class="tc y_value">
                <?php
                if($order_count['service'])
                {
                    echo '<span>'.$order_count['service'].'</span>';
                }
                ?>
                <img src="/template/source/default/images/images/user_opder_4.png" style="height:1rem; width:auto; ">
                <p class="fr14 cl_b3">退货/售后</p>
            </a>
        </div>

        <div class="web-cells" >
            <a href="?mod=weixin&v_mod=follow&_index=_product" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_1.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的收藏</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>

            <a href="/?mod=weixin&v_mod=coupon&_index=_list" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_2.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">优惠券</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>

			<a href="?mod=weixin&v_mod=coupon&_index=_golden_card" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/kapian.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的金卡</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
            
            <a href="?mod=weixin&v_mod=group&_index=_order" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/weixin/images/images/pin_ok.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的拼团</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>

            <a href="?mod=weixin&v_mod=wallet" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_3.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的钱包</p>
                </div>
                <div class="web-cell__ft"><?php echo $user['user_money']; ?>&nbsp;&nbsp;&nbsp;</div>
            </a>
            <a href="/?mod=weixin&v_mod=point&_index=_shop" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/weixin/images/images/user_point.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">我的积分</p>
                </div>
                <div class="web-cell__ft"><?php echo $user['user_point']; ?> &nbsp;&nbsp;&nbsp;</div>
            </a>
            <a href="?mod=weixin&v_mod=address" class="web-cell web-cell_access">
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
            <a href="?mod=weixin&v_mod=user&_index=_question" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_5.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">客服服务</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>
           <!-- <a href="?mod" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/web_icon/user_i_6.png" style="width: .9rem; height: .9rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <p class="fr16 cl_b3">活动中心</p>
                </div>
                <div class="web-cell__ft"></div>
            </a>-->

        </div>
    </div>
</div>
<!----底部导航---->
<?php include RPC_DIR.'/template/html/weixin/comm/footer_tpl.php';?>
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