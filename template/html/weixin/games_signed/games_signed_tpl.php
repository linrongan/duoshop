<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user=$obj->GetUserInfo(SYS_USERID);
$signed=$obj->GetLianXuLog();
//昨天日期
$zt=date("j",strtotime("-1 day"));
$lianxi=!empty($signed[$zt]) && $user['lianxu_signed']?$user['lianxu_signed']:0;
$nowday=date("j");
//兑换礼品
$gift = $obj->getPointGift();
//var_dump($signed);exit;
$date = array();
$date['start_week'] = date('w', mktime(null,null,null,date('m'),1,date('Y')));
$date['days']= date('t',strtotime(date('Y-m')));
//var_dump($date['days']);exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo WEBNAME; ?></title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/jquery-weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/rest.css?66666">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/webapp.css?66666">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/weixin/css/cart.css?6666">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/sec.kill.css?777777">
 	<style>
    	.duo-header-shortcut{display:none;}
		.sign{padding:1rem 3% .5rem; background:white;}
		.sign-integral{ color:#e33a51; text-align:center;}
		.sign-integral>span{font-size:1.2rem;}
		.sign-button{ margin-top:.5rem;}
		.sign-button .already-btn,.sign-button .not-btn{ margin:auto; width:6rem; height:2.25rem; text-align:center; line-height:2.25rem; color:white; font-size:.9rem; display:none; }
		.sign-button .already-btn{background:#e33a51;  display:block;}
		.sign-button .not-btn{background:#9a9a9a; }
		.sign-time{line-height:1.5rem; border-bottom:1px solid #c87c77; margin-top:.5rem;}
		.sing-date-menu>.sing-date-menu-item,.sign-date-day>.sign-date-day-number{float:left; width:14.28571428571429%; text-align:center;}
		.sign-date-day>.sign-date-day-number{margin-top:1rem;}
		.sign-date-day>.sign-date-day-number>span{display:inline-block; width:20px; height:20px; text-align:center; line-height:20px;}
		.sign-date-day>.sign-date-day-number.active>span{  border-radius:50%;  background:#e38583; color:white;}
		.sign-date-day>.sign-date-day-number.overdue>span{   color:#999999;}
		.sing-product{background:white; padding-top:.5rem;}
		.sing-product-title{padding:0 3%; height:1.25rem; line-height:1.25rem; position:relative}
		.sing-product-title::before{content:''; width:3px; height:100%; background:#f1ae02; position:absolute; left:0; top:0;}
		.sing-product-list{padding:0 3%;}
		.sing-product-list>ul>li{float:left; width:33.333333333%; margin-bottom:.5rem; text-align:center; padding:0 1.5%;}
		.sing-product-list>ul>li>a{display:block;}
		.sing-product-img{width:80px; height:80px; border-radius:50%; border:1px solid #ededed; margin:auto; position:relative;}
		.sing-product-img>img{width:100%; height:100%; display:block; border-radius:50%;}
		.sing-product-img .sing-speed{width:80%; height:15px; line-height:15px; text-align:center; background:rgba(252,68,97,0.8); border-radius:15px; position:absolute; left:50%; margin-left:-40%; bottom:0px; color:white;  }
		.sing-product-img .sing-speed>span{-webkit-transform:scale(0.9); transform:scale(0.9); display:block; margin:auto;}
		.sing-product-integral>span{color:#fc4461;}
		.weui-dialog__btn_primary{color:#fc4461;}
		
		
    </style>
</head>
<body style="padding-bottom:0;">
<header>
    <div id="m_common_header"><header class="duo-header">
    <div class="duo-header-bar">

    <div onclick="location.href='/?mod=weixin&v_mod=point&_index=_shop'" id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
            <div class="duo-header-title">积分签到</div>
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
                <li class="J_ping" id="m_common_header_shortcut_p_cart">
                    <a href="/?mod=weixin&v_mod=cart" id="html5_cart">
                        <span class="shortcut-cart"></span>
                        <strong>购物车</strong>
                    </a>
                </li>
                <li id="m_common_header_shortcut_h_home">
                    <a class="J_ping" href="/?mod=weixin&v_mod=user&v_shop=<?php echo $v_shop; ?>">
                        <span class="shortcut-my-account"></span>
                        <strong>会员中心</strong>
                    </a>
                </li>
            </ul>
        </header>
    </div>
</header>



<div class="sign">
	<div class="sign-integral"><span class="mr5"><?php echo $user['user_point']; ?></span>分</div>
	<div class="sign-button">
        <?php
            if(empty($signed[$nowday]))
            {
                ?>
                <div class="already-btn">立即签到</div>
                <?php
            }else{
                ?>
                <div class="not-btn" style="display: block">明日签到<span>+<?php echo $obj->GetPoint($lianxi+1); ?></span></div>
                <?php
            }
        ?>
    </div>
	<div class="sign-container">
    	<div class="sign-time">
        	<span class="fl cl_b6">
            	<?php echo date('Y年m月d日');?>
            </span>
            <a href="javascript:;" class="fr cl_b9" id="sing-rule" onClick="showVis()">
            	签到规则
            </a>
            <div class="cb"></div>
        </div>
        <div class="sign-date rmt10">
        	<div class="sign-date-hd">
            	<div class="sing-date-menu">
                    <div class="sing-date-menu-item">日</div>
                    <div class="sing-date-menu-item">一</div>
                    <div class="sing-date-menu-item">二</div>
                    <div class="sing-date-menu-item">三</div>
                    <div class="sing-date-menu-item">四</div>
                    <div class="sing-date-menu-item">五</div>
                    <div class="sing-date-menu-item">六</div>
                </div>
                <div class="cb"></div>
            </div>
        	<div class="sign-date-bd">
            	<div class="sign-date-day">
                    <?php
                    for($b=0;$b<$date['start_week'];$b++)
                    {
                        ?>
                        <div class="sign-date-day-number"><span>&nbsp;&nbsp;&nbsp;</span></div>
                    <?php
                    }
                    for ($i=1;$i<=$date['days'];$i++)
                    {

                        if(!empty($signed[$i]))
                        {
                            ?>
                            <div class="sign-date-day-number active"><span><?php echo $i;?></span></div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <div class="sign-date-day-number"><span><?php echo $i;?></span></div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>


<div class="sing-product rmt10">
	<div class="sing-product-title">
    	<span class="fl text rf15">为您推荐</span>
        <a href="javascript:;" class="fr cl_b6 rf12">签到送积分，可兑换以下奖品哦 <i class="fa fa-angle-right"></i></a>
        <div class="cb"></div>
    </div>
    <div class="sing-product-list rmt10">
    	<ul>
            <?php
                if(!empty($gift)){
                    foreach($gift as $item){
                        ?>
                        <li class="sing-product-item">
                            <a href="?mod=weixin&v_mod=point&_index=_product_detail&id=<?php echo $item['id'];?>">
                                <div class="sing-product-img">
                                    <img src="<?php echo $item['qty']==0?'/template/source/weixin/images/sold.out.png':$item['gift_img'];?>">
                                    <div class="sing-speed rf12"><span>已兑<?php echo ceil($item['sale']/$item['qty']*100);?>%</span></div>
                                </div>
                                <div class="sing-product-name omit rf14 cl_b3"><?php echo $item['gift_name'];?></div>
                                <div class="sing-product-integral rf12 cl_b9"><span><?php echo $item['gift_point'];?></span>分</div>
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




<div class="js_dialog" id="rule_box" style="opacity: 0;">
    <div class="weui-mask" onClick="hideVis()"></div>
    <div class="weui-dialog">
    	<div class="weui-dialog__hd"><strong class="weui-dialog__title">签到规则</strong></div>
        <div class="weui-dialog__bd">
        	<p>1、活动对象：<?php echo WEBNAME; ?>全体会员均可参加签到送积分活动。</p>
            <p>2、每天连续签到可以依次获得5、10、15、20、20个积分。中途漏签，则从5个积分重新开始领取。</p>
            <p>3、签到积分累计可以兑换礼品或者参加其他本平台优惠活动。</p>
            <p>4、积分长期有效使用</p>
        </div>
        <div class="weui-dialog__ft">
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" onClick="hideVis()">知道了</a>
        </div>
    </div>
</div>


<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/template/source/weixin/js/fastclick.js"></script>
<script src="/template/source/weixin/js/jquery-weui.min.js"></script>
<script src="/template/source/weixin/js/city-picker.js"></script>
<script src="/template/source/weixin/js/guageEdit.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>

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
		})

		$(".already-btn").on("click",function(){

            var thisDay = '<?php echo date('j');?>';
            var paramData = "";
            $.ajax({
                cache:false,
                type:"POST",
                url:"/?mod=weixin&v_mod=games_signed&_action=ActionSigned",
                data:paramData,
                dataType:"json",
                success:function(result) {
                    if (result.code==0)
                    {
                        $(".sign-date-day .sign-date-day-number").each(function(index, element) {
                            if(parseInt($(element).children("span").html()) == thisDay){
                                $(element).addClass("active");
                            }
                        });
                        $('.already-btn').hide();
                        $(".sign-button").html('<div class="not-btn" style="display: block">明日签到<span>+<?php echo $obj->GetPoint($lianxi+1); ?></span></div>');
                        var point = parseInt($(".sign-integral").children("span").html());
                        var plus =  parseInt('<?php echo $obj->GetPoint($lianxi); ?>');
                        $(".sign-integral").children("span").html(point+plus);
                    }else
                    {
                        alert(result.msg);
                    }
                },
                error:function(result) {
                    alert("网络超时,请重试!");
                }
            });
		})
	})
	function showVis(){
		$("#rule_box").css('opacity','1');
		$("#rule_box").children(".weui-mask").removeClass("hideVis").addClass("showVis");
		$("#rule_box").children(".weui-dialog").removeClass("hideVis").addClass("showVis");
	}
	function hideVis(){
		$("#rule_box").css('opacity','0');
		$("#rule_box").children(".weui-mask").removeClass("showVis").addClass("hideVis");
		$("#rule_box").children(".weui-dialog").removeClass("showVis").addClass("hideVis");
	}

</script>
</body>
</html>