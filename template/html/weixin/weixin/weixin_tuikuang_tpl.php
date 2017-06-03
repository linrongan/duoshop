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
		.weui-cell_select .weui-select{padding-left:0; height:auto; line-height:normal;}
    </style>
</head>
<body>
<header>
    <div id="m_common_header"><header class="duo-header">
    <div class="duo-header-bar">
    <div id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
            <div class="duo-header-title">申请退款</div>
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

<div class="weui-cells__title rf14">退款原因<span class="red rf14">*</span></div>
<div class="weui-cells">
	<div class="weui-cell weui-cell_select">
        <div class="weui-cell__bd">
        	<select class="weui-select rf14" name="select1">
                <option selected="" value="1">退款原因</option>
                <option value="2">7天无理由退款</option>
                <option value="3">退运费</option>
                <option value="4">商品瑕疵</option>
                <option value="5">质量问题</option>
                <option value="6">颜色/尺寸/参数不符</option>
                <option value="7">少件/漏发</option>
                <option value="8">收到商品时有划痕或破损</option>
                <option value="9">假冒品牌</option>
            </select>
        </div>
    </div>
</div>    
<div class="weui-cells__title rf14">退款金额<span class="red rf14">*</span></div>
<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__bd"><input type="text" class="weui-input rf14" placeholder="请输入退款金额"></div>
    </div>
</div>
<div class="weui-cells__title rf14">退款说明<span class="cl_b9 rf14">（可不填）</span></div>
<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__bd">
        	<textarea class="weui-textarea rf14" rows="3" cols="40" placeholder="请输入退款说明"></textarea>
        </div>
    </div>
</div>

<div class="weui-cells weui-cells_form">
  <div class="weui-cell">
    <div class="weui-cell__bd">
      <div class="weui-uploader">
        <div class="weui-uploader__hd">
          <p class="weui-uploader__title rf14">上传凭证<span class="cl_b9">（最多3张）</span></p>
          <div class="weui-uploader__info rf12">0/2</div>
        </div>
        <div class="weui-uploader__bd">
          <ul class="weui-uploader__files" id="uploaderFiles">
            <li class="weui-uploader__file" style="background-image:url(/template/source/images/pic_160.png)"></li>
          </ul>
          <div class="weui-uploader__input-box">
            <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<!--
<div class="weui-cells__title rf14">温馨提示</div>
<p class="rf14 lh20" style="text-indent:2em;">温馨提示内容</p>-->
<div style="padding:1rem 10%">

	<a href="javascript:;" class="weui-btn weui-btn_primary rf16" style="background:#dd2726;">下一步</a>

</div>

<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/template/source/weixin/js/fastclick.js"></script>
<script src="/template/source/weixin/js/jquery-weui.min.js"></script>
<script src="/template/source/weixin/js/autosize.min.js"></script>
<script src="/template/source/weixin/js/guageEdit.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>

<script>

	autosize(document.querySelectorAll('textarea'));
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