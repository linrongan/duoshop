<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetHomeData();
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
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/webapp.css">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/weixin/css/cart.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/sec.kill.css?777777">
 	<style>
    	.duo-header-shortcut{display:none;}
		.weui-cells__title{padding:0 .25rem; color:#5c5c5c;}
		.weui-btn_primary{background:#0174e1;}
		.weui-label{width:6rem;}
    </style>
</head>
<body>
<header>
    <div id="m_common_header"><header class="duo-header">
    <div class="duo-header-bar">
    <div id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
            <div class="duo-header-title">资助申请</div>
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

<div class="weui-cells__title rf14">申请信息</div>
<div class="weui-cells">
	<div class="weui-cell">
    	<div class="weui-cell__hd"><label class="weui-label rf14">姓名：</label></div>
        <div class="weui-cell__bd"><input type="text" class="weui-input rf14" placeholder="请输入姓名"></div>
    </div>
    <div class="weui-cell">
    	<div class="weui-cell__hd"><label class="weui-label rf14">联系电话：</label></div>
        <div class="weui-cell__bd"><input type="tel" class="weui-input rf14" placeholder="请输入联系电话"></div>
    </div>
	<div class="weui-cell">
    	<div class="weui-cell__hd"><label class="weui-label rf14">所在城市：</label></div>
        <div class="weui-cell__bd"><input type="text" class="weui-input rf14" id="address" placeholder="请输入所在城市"></div>
    </div>
    <div class="weui-cell">
    	<div class="weui-cell__hd"><label class="weui-label rf14">资助(金额)物品：</label></div>
        <div class="weui-cell__bd"><input type="text"  class="weui-input rf14" placeholder="请输入资助（金额）物品"></div>
    </div>
    <div class="weui-cell">
    	<div class="weui-cell__hd"><label class="weui-label rf14">本地房产：</label></div>
        <div class="weui-cell__bd"><input type="text" class="weui-input rf14" id="select1" placeholder="请输入本地房产"></div>
    </div>
    <div class="weui-cell weui-cell_select">
    	<div class="weui-cell__hd"><label class="weui-label rf14">职业：</label></div>
        <div class="weui-cell__bd"><input type="text" readonly class="weui-input rf14" id="select2" placeholder="请选择职业"></div>
    </div>
</div>
<!--
<div class="weui-cells__title rf14">温馨提示</div>
<p class="rf14 lh20" style="text-indent:2em;">温馨提示内容</p>-->
<div style="padding:1rem 10%">

	<a href="javascript:;" class="weui-btn weui-btn_primary rf16">下一步</a>

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



	$("#select2").picker({
        title: "请选择职业",
        cols: [
          {
            textAlign: 'center',
            values: ['总裁CEO','总经理','副总经理','总监','员工']
          }
        ]
	
      });
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
	
	})
	
</script>
</body>
</html>