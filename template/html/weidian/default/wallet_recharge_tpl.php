<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>充值</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css?6666">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css?6666">
    <link rel="stylesheet" href="/template/source/css/weui.min.css">
	<style>
        .web-cells:first-child{margin-top:0}
        /*.web-cells:first-child::before{border-top:none}*/
        .web-cell:first-child::before{border-top:none}
        .web-cell:before{left:0;}
        .select_money{background: #4cd964;}
	</style>
	<script src="/template/source/default/js/jquery_1.1.1.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
</head>
<body >
	<div class="mui-content">
        <div class="weui-cells__title cl999 sz14r">
            请选择或填写充值金额
        </div>
        <div class="weui-grids">
            <a rel="50" href="javascript:;"  class="weui-grid ">
                <p class="weui-grid__label">
                    50 元
                </p>
            </a>
            <a rel="100" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    100 元
                </p>
            </a>
            <a rel="150" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    150 元
                </p>
            </a>
            <a rel="300" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    300 元
                </p>
            </a>
            <a rel="500" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    500 元
                </p>
            </a>
            <a rel="1000" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    1000 元
                </p>
            </a>
        </div>
        <div class="web-wallet-body">
            <div class="web-cells mtr10">
                <div class="web-cell  ">
                    <div class="web-cell__hd">
                        <label class="web-label">金额</label>
                    </div>
                    <div class="web-cell__bd">
                        <input type="number" id="money" class="web-input" pattern="[0-9]*" placeholder="请输入充值金额"  >
                    </div>
                </div>
            </div>

            <div style="padding:0 10%;" class="tc mtr30">
                <a href="javascript:;" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-success fr16" id="sumbit" style="padding:8px 60px;width: 100%; line-height: 1.7 ">
                    充值
                </a>
            </div>
        </div>
	</div>
    <script src="/template/source/default/js/mui.min.js"></script>
    <script src="/tool/layer/layer_mobile/layer.js"></script>
    <script>
        //获取输入的金额
        function get_input_money()
        {
            var money = $("#money").val();
            if(money.length<=0)
            {
                mui.toast('请输入金额');
                return;
            }
            var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
            if(!reg.test(money))
            {
                mui.toast('请输入正确的金额');
                return;
            }
            if(money>1000)
            {
                $("#money").val(1000);
                mui.toast('单次充值最大金额不超过1000');
                return;
            }
            return money;
        }


        (function($,doc) {
            $.init();
            $.ready(function() {
                //这里执行表单提交
                var ajaxBtn = doc.getElementById('sumbit');
                sumbit.addEventListener('tap',function()
                {
                    $(this).button('loading');
                    var money = get_input_money();
                    if(!money)
                    {
                        $(this).button('reset');
                    }
                    //
                    recharge(money);
                },false)
            })
        })(mui,document);

        function recharge(money)
        {
            layer.open({
                type: 2
                ,content: '加载中'
            });
            var count_down = setTimeout(function ()
            {
                $.ajax({
                    type:"post",
                    url:"/?mod=weidian&v_mod=wallet&_index=_recharge&v_shop=<?php echo $_GET['v_shop']; ?>&_action=ActionRePay",
                    data:{money:money},
                    dataType:"json",
                    success:function (data)
                    {
                        layer.closeAll();
                        mui("#sumbit").button('reset');
                        if(data.code==0)
                        {
                            jsApiCall(data.pay);
                        }else{
                            mui.toast(data.msg);
                        }
                    },
                    error:function ()
                    {
                        layer.closeAll();
                        mui("#sumbit").button('reset');
                    }
                });
                clearInterval(count_down);
            },2000);
        }

        function jsApiCall(data)
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                data,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    if(res.err_msg == "get_brand_wcpay_request:ok" )
                    {
                        window.location.href='/?mod=weixin&v_mod=user&_index=_pay_success&orderid=';
                    }else{
                        alert(res.err_code+res.err_desc+res.err_msg);
                    }
                }
            );
        }

        function callpay(data)
        {
            if (typeof WeixinJSBridge == "undefined")
            {
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall(data);
            }
        }


        $(".weui-grids a").click(function ()
        {
            if($(this).hasClass('select_money'))
            {
                return;
            }
            $(this).addClass('select_money').siblings().removeClass('select_money');
            recharge($(this).attr('rel'));
        });

    </script>
</body>
</html>