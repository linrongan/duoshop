<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>提现</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
     <link rel="stylesheet" href="/template/source/default/css/mui.min.css?6666">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css?6666">
	<style>
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell:first-child::before{border-top:none}
        .web-cell:before{left:0;}
        .mui-btn-null{color: #fff;  border: 1px solid #CCC;  background-color: #CCC;}
	</style>
	<script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

	<div class="mui-content">

        <div class="web-wallet-body">
            <div class="web-cells">
                <div style="padding:.5rem 3%;" class="fr14 cl_b3">提现金额</div>
                <div class="web-cell" style="border-bottom:1px solid #e8e8e8;">
                    <div class="web-cell__hd">
                        <label class="web-label fr18" style="min-width:2rem;">￥</label>
                    </div>
                    <div class="web-cell__bd">
                        <input type="number" class="web-input" pattern="[0-9]*" placeholder="请输入充值金额"  >
                    </div>
                </div>
                <p style="padding:.5rem 3%;" class="fr12 cl_b9">可用余额：0.00元</p>
            </div>

            <div style="padding:0 10%;" class="tc mtr30">
                <a href="javascript:;" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-success fr16" id="sumbit" style="padding:8px 60px;width: 100%; line-height: 1.7 ">
                    确认提现
                </a>
            </div>
        </div>

	</div>



	<script src="/template/source/default/js/mui.min.js"></script>
    <script>
        (function($,doc) {
            $.init();

            $.ready(function() {
                //这里执行表单提交
                var ajaxBtn = doc.getElementById('sumbit')
                sumbit.addEventListener('tap',function(){
                    $(this).button('loading');
                    setTimeout(function() {
                        $(this).button('reset');
                        //$.toast('信息修改成功');
                    }.bind(this), 2000);

                },false)
            })
        })(mui,document);
    </script>
</body>
</html>