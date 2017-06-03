<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>订单详情</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-opder-nav{padding:0; border-bottom:1px solid #e8e8e8;}
        .web-opder-nav>a{padding:.5rem 0;}
        .web-yp-title>span{color:#999999;}
        .web-yp-title>span::before{border-color:#999999}
        .web-yp-title>span::after{border-color:#999999;}
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell__title,.web-cell__text{padding:.5rem 3%;}
        .web-cell:before{border-top:none;}
        .web-cell__text{line-height: 1.5rem;}
        .no-fg-btn{background:#ff464e; color:white; padding:0 10px; height:1.5rem; line-height: 1.5rem;  border-radius: 3px; display:inline-block;  }
        .web-date-bottom{position:fixed; bottom:0; left: 0; background:white; padding:.5rem 3%; width:100%; border-top:1px solid #e8e8e8;}
		.web-logistics>.web-cell:first-child p{color:#ff464e;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

<div class="mui-content">

	
    <div class="web-cells" style=" background:#ff7e00 url(/template/source/default/images/taobaobg_02.png) right center no-repeat; background-size:150px 100px;">
        <div class="web-cell" style=" height:120px; line-height:120px;">
            <div class="web-cell__bd tl">
                 <span class="fr18 white" style="padding-left:50px;">待付款</span>
            </div>
        </div>
    </div>
    
    
    <div class="web-cells" style="margin-top:0;">
        <div class="web-cell">
            <div class="web-cell__hd">
                <img src="/template/source/default/images/web_address_icon.png" style="width:.75rem; margin-right:10px;">
            </div>
            <div class="web-cell__bd">
                <div>
                    <span class="fl cl_b3 fr14">收货人： 张三</span>
                    <span class="fr cl_b3 fr14">15816112191</span>
                    <div class="cb"></div>
                </div>
                <p class="fr12 cl_b9 mtr5 ">收货地址：广东省广州市天河区龙洞凤凰街渔兴路18号</p>
            </div>
        </div>
        <div class="web-cell" style="border-top:1px solid #e8e8e8;">
            <div class="web-cell__hd">
                <img src="/template/source/default/images/web_message_icon.png" style="width:.75rem; margin-right:10px;">
            </div>
            <div class="web-cell__bd">
                <div>
                    <span class="cl_b3 fr14">买家留言</span>
                </div>
                <p class="fr12 cl_b9 mtr5 ">不要发错货~~</p>
            </div>
        </div>
    </div>
    <div class="web-cells__title mtr10 fr14 cl_b9" style="padding:0 3%;">物流管理</div>
    <div class="web-cells web-logistics" style="margin-top:.25rem">
    	<div class="web-cell" style="">
            <div class="web-cell__hd mr10">
                <p class="fr12">2016.10.08</p>
                <p class="fr18">11:50</p>
            </div>
            <div class="web-cell__bd">
               <p class="fr14">您的订单待配送</p>
            </div>
        </div>
        <div class="web-cell" style="">
            <div class="web-cell__hd mr10">
                <p class="fr12">2016.09.08</p>
                <p class="fr18">11:50</p>
            </div>
            <div class="web-cell__bd">
               <p class="fr14">您的订单开始处理</p>
            </div>
        </div>
    </div>
    
    
    
	
    <!---待付款---->
    <div class="web-cells">
         <div class="web-cell__title fr14">
            <img src="/template/source/default/images/tianmao.jpg" class="mr10" style="width:1.2rem; height: 1.2rem; display: inline-block; vertical-align: bottom;">宇轩中西餐厅<i class="ml10 fa fa-chevron-right fr12"></i>
         </div>
        <div class="web-cell" style="background:#f8f8f8;">
            <div class="web-cell__hd">

                <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
                    <img src="/template/source/default/images/web_yp_1.jpg" class="mr10" style="width: 4rem; height: 4rem; display: block; border-radius: 3px; ">
                </a>

            </div>
            <div class="web-cell__bd">
                <div class="fr14">
                                <span class="fl mr10 omit" style="width:65%" >
                                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>" class="cl_b3">特色黑椒牛排</a>
                                </span>
                    <span class="fr red">￥50.00</span>
                    <div class="cb"></div>
                </div>
                <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                    颜色：黑红 尺码：#41
                </div>
                <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                    数量：2
                </div>
            </div>
        </div>
        <div class="web-cell__text fr12 tr">
            共<span class="red">2</span>件 合计：<span class="red">￥100.00</span>（含运费￥0.00）
            <!--<a href="javascript:;" class="fr no-fg-btn fr14 ">去付款</a>-->
            <div class="cb"></div>
        </div>
    </div>
    <!-------->

    


    <div class="web-cells">
        <div class="web-cell">

            <div class="web-cell__bd">
                <h1 class="fr14">订单信息</h1>
                <div class="mtr10 fr12" style="line-height: 20px;">
                    <p>订单编号：123456489</p>
                    <p>微信支付：661616</p>
                    <p>创建时间：2016-02-02 19:05:56</p>
                    <p>付款时间：2016-02-02 19:05:56</p>
                </div>
            </div>
        </div>
    </div>


    <div style="height:2.5rem;"></div>
    <div class="web-date-bottom tc">
        <a href="javascript:;" class="no-fg-btn fr14 ml10">确认收货</a>
    </div>

</div>




<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script>

</script>
</body>
</html>