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
		.weui-label{width:4rem;}
		.weui-cell_select .weui-select{padding-left:0; height:auto; line-height:normal;}
		.prompt{font-weight:bold;}
		.prompt>i.fa{color:#5a7fc6;}
		.prompt_button>a{ display:inline-block; width:30%; height:35px; text-align:center; line-height:35px; border:1px solid #999999; margin:0 3px; padding:0 5px; background-image:-webkit-linear-gradient(to bottom, #fcfcfc, #f0f0f0); background-image:linear-gradient(to bottom,#fcfcfc, #f0f0f0); }
    </style>
</head>
<body>
<header>
    <div id="m_common_header"><header class="duo-header">
    <div class="duo-header-bar">
    <div id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
            <div class="duo-header-title">退款详情</div>
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


<div class="weui-cells rmt10">
	<div class="weui-cell" style="padding:1rem 3%;">
    	<div class="weui-cell__bd">
        	<div class="prompt rf15">
            	<i class="fa fa-exclamation-circle"></i> 等待商家处理退款申请
            </div>
            <div class="refund-rule rmt20">
            	<p class="cl_b9 rf13 rmt5"><span class="cl_b3">如果商家同意：</span>申请将达成并退款至您的余额或银行卡</p>
                <p class="cl_b9 rf13 rmt5"><span class="cl_b3">如果商家拒绝：</span>将需要您修改退款申请</p>
                <p class="cl_b9 rf13 rmt5"><span class="cl_b3">如果商家未处理：</span>超过<span class="red">02</span>天<span class="red">23</span>时则申请达成并为您退款</p>
            </div>
            
            <div class="prompt_button rmt10">
            	<a href="javascript:;" class="omit rf13 cl_b3">修改退款申请</a>
            	<a href="javascript:;" class="omit rf13 cl_b3">撤销售后申请</a>
                <a href="javascript:;" class="omit rf13 cl_b3">申请客服介入</a>
            </div>
            
        </div>
    </div>
</div>


<div class="weui-cells rmt10">
    <div class="weui-cell">
    	<div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">店铺名称</label></div>
        <div class="weui-cell__bd"><span class="rf14">乡粑网旗舰店</span></div>
    </div>
</div>

<div class="weui-cells rmt10">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">退款原因</label></div>
        <div class="weui-cell__bd"><span class="rf14">退运费</span></div>
    </div>
    <div class="weui-cell">
    	<div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">退款金额</label></div>
        <div class="weui-cell__bd"><span class="rf14">￥0.01</span></div>
    </div>

    <div class="weui-cell">
    	<div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">售后说明</label></div>
        <div class="weui-cell__bd"><span class="rf14">仅退款</span></div>
    </div>
</div>

<div class="weui-cells weui-cells_form rmt10">
  <div class="weui-cell">
    <div class="weui-cell__bd">
      <div class="weui-uploader">
        <div class="weui-uploader__hd">
          <p class="weui-uploader__title rf14">上传凭证<span class="cl_b9">（最多3张）</span></p>
          <div class="weui-uploader__info rf12">0/2</div>
        </div>
        <div class="weui-uploader__bd">
          <ul class="weui-uploader__files" id="uploaderFiles">
            <li class="weui-uploader__file" style="background-image:url(https://weui.io/images/pic_160.png)"></li>
          </ul>
          <div class="weui-uploader__input-box">
            <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple="">
          </div>
        </div>
      </div>
    </div>
  </div>
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