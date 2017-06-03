<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(!isset(SYS_USERID))
{
    redirect(NOFOUND.'&msg=请在微信打开');
}
$data = $obj->GetCouponTypeDetail();
if(empty($data))
{
    redirect(NOFOUND.'&msg=优惠卷不存在或已过期');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes"><!-- 是否启用 WebAPP 全屏模式 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black"> <!-- 状态条颜色 -->
    <meta name="format-detection" content="telephone=no">   <!-- 屏蔽数字自动识别为电话号码 -->
    <meta name="description" content="" /> <!-- 页面描述 -->
    <meta name="keywords" content=""/> <!-- 页面关键词 -->
    <title>领取优惠券-乡粑网</title>
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/jquery-weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/webapp.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/guageEdit.css">
     <link rel="stylesheet" href="/template/source/weixin/css/cart.css">
    <style>
		body{font-family: PingFangSC-Regular,Helvetica,"Droid Sans",Arial,sans-serif;}
		.duo-header-shortcut{display:none;}
		.mjd-container {
			height: 100%;
			width: 100%;
		}
		.alert-massege {
			height: 35px;
			background: #fffaf3;
			line-height: 35px;
			border-width: 0 0 1px 0;
			-webkit-border-image: url(/template/source/images/coupon-message-line-icon.png) 2 0 stretch;
		}
		.alert-massege p {
			font-size: 12px;
			text-align: center;
			color: #686868;
		}
		.mjd-coupon {
			padding: 10px 8px 0;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		.coupon-box {
			width: 100%;
			height: 100px;
			position: relative;
			margin-bottom: 10px;
			-webkit-box-radius: 2px;
			border-radius: 2px;
			display: -webkit-box;
			display: box;
		}
		.coupon-box:last-child{margin-bottom:0;}
		.coupon-value {
			width: 125px;
			padding: 0 9px;
			height: 100%;
			display: -webkit-box;
			display: box;
			-webkit-box-align: center;
			box-align: center;
			-webkit-box-pack: center;
			box-pack: center;
			color: #fff;
			background: url(/template/source/images/quan.png) 0 0 no-repeat;
			background-size: 6.24rem 20rem;
		}
		
		.coupon-dong .coupon-value {
			background-position: 0 0;
		}
		
		.coupon-value .value-content {
			margin: 0 auto;
			display: block;
			text-align: center;
			position: relative;
			max-width: 100%;
		}
		
		.coupon-value .money {
			margin-left: -0.55rem;
		}
		.coupon-value .money em {
			font-size: 0.9rem;
			padding-right: 4px;
			font-weight: bold;
		}
		.coupon-value .money strong {
			font-size: 2.2rem;
			line-height: 1em;
		}
		.coupon-value .rule {
			font-size: 0.6rem;
			line-height: 0.8rem;
			overflow: hidden;
			display: -webkit-box;
			-webkit-line-clamp: 1;
			-webkit-box-orient: vertical;
			display: box;
			line-clamp: 1;
			box-orient: vertical;
			margin-top: 5px;
		}
		
		.coupon-info {
			background-color: #fff;
			box-flex: 1;
			-webkit-box-flex: 1;
			-moz-box-flex: 1;
			-ms-box-flex: 1;
			-o-box-flex: 1;
			display: box;
			display: -webkit-box;
			display: -moz-box;
			display: -ms-box;
			display: -o-box;
			position: relative;
			padding: 7px 8px 7px 6px;
		}
		
		.coupon-info:before {
			content: '';
			height: 200%;
			width: 200%;
			position: absolute;
			left: 0;
			top: 0;
			border: 1px solid #eaeaec;
			border-left: none;
			border-radius: 0 6px 6px 0;
			-webkit-border-radius: 0 6px 6px 0;
			transform: scale(0.5);
			-webkit-transform: scale(0.5);
			-moz-transform: scale(0.5);
			-ms-transform: scale(0.5);
			-o-transform: scale(0.5);
			transform-origin: top left;
			-webkit-transform-origin: top left;
			-moz-transform-origin: top left;
			-ms-transform-origin: top left;
			-o-transform-origin: top left;
		}
		.coupon-box .use-rule {
			font-size: 0.6rem;
			color: #686868;
			line-height: 0.9rem;
			height: 2.7rem;
			overflow: hidden;
			display: -webkit-box;
			-webkit-line-clamp: 3;
			-webkit-box-orient: vertical;
			display: box;
			line-clamp: 3;
			box-orient: vertical;
		}
		.coupon-box .use-rule i {
			margin-right: 2px;
			display: inline-block;
			width: 1.8rem;
			height: 0.75rem;
			text-align: center;
			line-height: 0.75rem;
			font-size: 0.5rem;
			color: #fff;
			text-align: center;
			vertical-align: middle;
			-webkit-border-radius: 1px;
			border-radius: 1px;
		}
		.coupon-dong .use-rule i {
			background-color: #5f9bd5;
		}
		.coupon-info .use-time {
			position: absolute;
			left: 7px;
			bottom: 14px;
			line-height: 1rem;
			color: #a5a5a5;
			font-size: 0.5rem;
		}
		.new-pay-pw {
			padding: 0px 0px;
		}
		.receive-btn {
			overflow: hidden;
			margin-bottom: 10px;
			font-size: 0.8rem;
		}
		
		.receive-btn a {
			width: 100%;
			height: 1.9rem;
			line-height: 1.9rem;
			background: #ce2525;
			text-align: center;
			color: #fff;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			display: block;
			margin-top: 18px;
		}
		.receive-btn .btn-bot {
			background: #CCC;
		}
		
	</style>
</head>   
<body class="mhome" > 
    <header>
        <div id="m_common_header"><header class="duo-header">
        <div class="duo-header-bar">
        <div onclick="javascript:history.go(-1)" id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
                <div class="duo-header-title">领取优惠券</div>
                <div id="m_common_header_jdkey" class="duo-header-icon-shortcut J_ping"><span></span></div></div>
                <ul id="m_common_header_shortcut" class="duo-header-shortcut">
                    <li id="m_common_header_shortcut_m_index">
                    <a class="J_ping" href="/?mod=weixin">
                        <span class="shortcut-home"></span>
                        <strong>首页</strong></a>
                    </li>
                    <li class="J_ping" id="m_common_header_shortcut_category_search">
                        <a href="/?mod=weixin&v_mod=category">
                            <span class="shortcut-categories"></span>
                            <strong>分类搜索</strong>
                        </a>
                    </li>
                    <li class="J_ping current" id="m_common_header_shortcut_p_cart">
                        <a href="/?mod=weixin&v_mod=cart" id="html5_cart">
                            <span class="shortcut-cart"></span>
                            <strong>购物车</strong>
                        </a>
                    </li>
                    <li id="m_common_header_shortcut_h_home">
                        <a class="J_ping" href="/?mod=weixin&v_mod=user">
                            <span class="shortcut-my-account"></span>
                            <strong>会员中心</strong>
                        </a>
                    </li>
                </ul>
            </header>
        </div>
    </header>
    
    <div class="viewports2">
    	<div class="mjd-container">
        	<div class="alert-massege">
                <p>友情提示：此优惠劵十分抢手，可能存在抢不到的情况哟</p>
            </div>
            <div class="mjd-coupon">
            	<div class="mjd-coupon-con">
                    <div class="coupon-box coupon-dong">
                        <div class="coupon-value">
                            <div class="value-content">
                                <p class="money"><em>¥</em><strong><?php echo $data['coupon_money'];?></strong></p>
                                <p class="rule"><?php echo $data['min_money']?'满'.$data['min_money'].'可用':'无门槛';?></p>
                            </div>
                        </div>
                        <div class="coupon-info" style="word-wrap: break-word;">
                            <p class="use-rule"><i><?php echo $data['store_id']?'店铺卷':'通用卷';?></i>
                                <?php
                                    if($data['store_id']){
                                        if(!empty($data['category_name'])){
                                            echo "仅可购买[{$data['store_name']}]的{$data['category_name']}商品";
                                        }else{
                                            echo "限购[{$data['store_name']}]店铺商品";
                                        }
                                    }else{
                                        echo $data['coupon_name'];
                                    }
                                ?>
                            </p>
                            <p class="use-time"><?php echo $data['start_time'];?>-<?php echo $data['end_time'];?></p>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                <div id="form_data" class="form_data">
                    <div class="new-pay-pw">
                        <div class="receive-btn">

                            <?php
                                $coupon = $obj->getCouponByStoreTypeId($data['id']);
                                if($coupon)
                                {
                                    if($data['default_sent']==1)
                                    {
                                        ?>
                                        <a  href="javascript:void(0);" id="determine" class="btn-active">立即领取</a>
                                    <?php
                                    }else
                                    {
                                        ?>
                                        <a  href="javascript:void(0);" class="btn-bot">立即领取</a>
                                    <?php
                                    }
                                }else
                                {
                                    ?>
                                    <a  href="javascript:void(0);" class="btn-bot">已领取</a>
                                    <?php
                                }
                            ?>

                        </div>
                    </div>
        		</div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<script src="/template/source/point/js/jquery-2.1.4.js"></script>
<script src="/template/source/point/js/jquery-weui.min.js"></script>
<script src="/template/source/point/js/lazy-load-img.min.js"></script>
<script src="/template/source/point/js/swiper.min.js"></script>
<script src="/template/source/point/js/fastclick.js"></script>
<script src="/template/source/point/js/guageEdit.js?66"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script>
$(function(){
	var a = true;
	$('#m_common_header_jdkey').click(function(){
		if(a){
			$('#m_common_header_shortcut').css('display','table');
			a = false;
		}else{
			$('#m_common_header_shortcut').css('display','none');
			a = true;
		}
	});
    $("#determine").on("click",function(){
        var id = '<?php echo $data['id'];?>' ;
        $.ajax({
            cache:false,
            type:"POST",
            url:"/?mod=wap&v_mod=coupon&_action=ActionReceiveCoupon",
            data:{'id':id},
            dataType:"json",
            success:function(result) {
                alert(result.msg);
                if (result.code==0)
                {

                    window.location.reload();
                }
            },
            error:function(result) {
                alert("系统繁忙!");
            }
        });
    })
});

</script>
</body>
</html>