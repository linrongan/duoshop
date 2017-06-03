<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetOrderPayByShop();
if($data['code'])
{
    redirect(NOFOUND.'&msg='.$data['msg']);
}
$order = $data['data'];
$orderid = $order['orderid'].'_'.$order['id'];
$pay_way = array('wechat','user_money');
$user = $obj->GetUserInfo(SYS_USERID);
$select_pay = isset($_GET['pay_way']) && !empty($_GET['pay_way']) && in_array($_GET['pay_way'],$pay_way) ?$_GET['pay_way'] : '';
if(!$select_pay)
{
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <title>选择支付方式</title>
        <link rel="stylesheet" type="text/css" href="/template/source/css/font.min.css">
        <link rel="stylesheet" type="text/css" href="/template/source/css/weui.min.css">
        <link rel="stylesheet" type="text/css" href="/template/source/css/rest.css">
        <link rel="stylesheet" type="text/css" href="/template/source/css/main.css">
        <style type="text/css">
            .left_arrow_new img{margin: 15px 0;}
            .left_arrow_new a,.left_arrow_new a:hover{color: #fff; font-size: 1.2em}
            .pay_select li{ margin-top: 10px; float: left;width: 30%;margin-left: 2%;height: 40px;border: 2px solid #bcbcbc; line-height: 40px;}
            .weui-form-preview{position:absolute; width:100%; height:100%; left:0; bottom:0; background:white;}
            .weui-form-preview__bd{position:relative;}
            .weui-form-preview__bd::after{content: " ";
                position: absolute;
                left: 0;
                bottom: 0;
                right: 0;
                height: 1px;
                border-bottom: 1px solid #D9D9D9;
                color: #D9D9D9;
                -webkit-transform-origin: 0 100%;
                transform-origin: 0 100%;
                -webkit-transform: scaleY(0.5);
                transform: scaleY(0.5);
                left: 0;
            }
            .zd-weui-btn {
                padding: .4rem 10%;
            }
            .weui-label{width:90px;}
            .weui-select,.weui-textarea,.weui-input{font-family:'微软雅黑'}
            .weui-cells{margin-top:0;}
            .weui-btn+.weui-btn{margin-top:1rem;}
            .weui-form-preview__hd:after{left:0}
            .weui-form-preview__ft{margin:20px auto 0; background:#0BB20C; width:90%;}
            .weui-form-preview__btn_primary{color:#FFF; font-family:"微软雅黑";}

            .weui-form-preview:after{border-bottom:none;}
            .weui-form-preview__hd{text-align:center;}
            .weui-form-preview__zdlabel{font-family:"微软雅黑";}
            .weui-form-preview__zdvalue{font-weight:bold; font-size:28px; font-family:"微软雅黑";}
            .weui-form-preview__label,.weui-form-preview__value{font-family:"微软雅黑";}
            .weui-form-preview__value{color:#000;}
            .integral-title{border:none;}
        </style>
        <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    </head>
    <body  style="background-color:#f6f6f6;">
    <div id="container" class="container">
        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="javascript:;">
                <div class="weui-cell__hd">
                    <img src="<?php echo $data['data']['store_logo']; ?>" alt="" style="width:20px;margin-right:5px;display:block">
                </div>
                <div class="weui-cell__bd">
                    <p>店铺</p>
                </div>
                <div class="weui-cell__ft"><?php echo $data['data']['store_name']; ?></div>
            </a>
            <a class="weui-cell weui-cell_access" href="javascript:;">
                <div class="weui-cell__bd">
                    <p>订单</p>
                </div>
                <div class="weui-cell__ft"><?php echo $data['data']['orderid']; ?></div>
            </a>
            <a class="weui-cell weui-cell_access" href="javascript:;">
                <div class="weui-cell__hd">
                </div>
                <div class="weui-cell__bd">
                    <p>订单金额</p>
                </div>
                <div class="weui-cell__ft">￥<?php echo $data['data']['total_money']; ?></div>
            </a>
        </div>
        <div class="weui-cells__title">支付方式</div>
        <div class="weui-cells weui-cells_checkbox">
            <label class="weui-cell weui-check__label" for="s11">
                <div class="weui-cell__hd">
                    <input type="radio" class="weui-check" checked value="wechat" name="pay_way" id="s11">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p>微信支付</p>
                </div>
            </label>
            <label class="weui-cell weui-check__label" for="s12">
                <div class="weui-cell__hd">
                    <input type="radio" value="user_money" <?php if($user['user_money']<$data['data']['total_money']){echo 'disabled';} ?>  name="pay_way" class="weui-check" id="s12">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p>余额支付</p>
                </div>
                <div class="weui-cell__ft">
                    <p><?php
                        if($user['user_money']<$data['data']['total_money']){
                            echo '余额不足';
                        }else{
                            echo '￥'.$user['user_money'];
                        } ?>
                    </p>
                </div>
            </label>
        </div>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:"  id="sub">下一步</a>
        </div>
    </div>
    </body>
    <script>
        $("#sub").click(function ()
        {
            var pay_way = $("input:radio[name='pay_way']:checked").val();
            location.href='<?php echo _URL_; ?>&pay_way='+pay_way;
        })
    </script>
    </html>
<?php
}elseif($select_pay=='wechat')
{
include RPC_DIR.'/module/common/wechat_pay.php';
$wechat_pay = new wechat_pay($_REQUEST);
$array = array(
    'out_trade_no'=>$orderid,
    'total_fee'=>$order['total_money'],
    'notify_url'=>WEBURL.'/pay/weixin/pay_one_shop_pro_result.php'
);
$pay_data = $wechat_pay->WeChatPay($array);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <title>订单支付</title>
    <link rel="stylesheet" type="text/css" href="/template/source/css/font.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/weui.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/rest.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/main.css">
    <style type="text/css">
        .left_arrow_new img{margin: 15px 0;}
        .left_arrow_new a,.left_arrow_new a:hover{color: #fff; font-size: 1.2em}
        .pay_select li{ margin-top: 10px; float: left;width: 30%;margin-left: 2%;height: 40px;border: 2px solid #bcbcbc; line-height: 40px;}
        .weui-form-preview{position:absolute; width:100%; height:100%; left:0; bottom:0; background:white;}
        .weui-form-preview__bd{position:relative;}
        .weui-form-preview__bd::after{content: " ";
            position: absolute;
            left: 0;
            bottom: 0;
            right: 0;
            height: 1px;
            border-bottom: 1px solid #D9D9D9;
            color: #D9D9D9;
            -webkit-transform-origin: 0 100%;
            transform-origin: 0 100%;
            -webkit-transform: scaleY(0.5);
            transform: scaleY(0.5);
            left: 0;
        }
        .zd-weui-btn {
            padding: .4rem 10%;
        }
        .weui-label{width:90px;}
        .weui-select,.weui-textarea,.weui-input{font-family:'微软雅黑'}
        .weui-cells{margin-top:0;}
        .weui-btn+.weui-btn{margin-top:1rem;}
        .weui-form-preview__hd:after{left:0}
        .weui-form-preview__ft{margin:20px auto 0; background:#0BB20C; width:90%;}
        .weui-form-preview__btn_primary{color:#FFF; font-family:"微软雅黑";}

        .weui-form-preview:after{border-bottom:none;}
        .weui-form-preview__hd{text-align:center;}
        .weui-form-preview__zdlabel{font-family:"微软雅黑";}
        .weui-form-preview__zdvalue{font-weight:bold; font-size:28px; font-family:"微软雅黑";}
        .weui-form-preview__label,.weui-form-preview__value{font-family:"微软雅黑";}
        .weui-form-preview__value{color:#000;}
        .integral-title{border:none;}
    </style>
    <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
    <script type="text/javascript">
        var link = '?mod=weixin&v_mod=checkout&_index=_pay_result&orderid=<?php echo $_GET['orderid']; ?>&shop_id=<?php echo $_GET['shop_id']; ?>';
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $pay_data; ?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    if(res.err_msg == "get_brand_wcpay_request:ok" )
                    {
                        window.location.href=link;
                    }
                    else
                    {
                        /*alert(res.err_code+res.err_desc+res.err_msg);*/
                    }
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
</head>
<body  style="background-color:#f6f6f6;">
<div id="container" class="container">
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__zdlabel">支付订单金额</div>
            <div class="weui-form-preview__zdvalue">
                ￥ <?php echo $order['total_money']; ?>
            </div>
        </div>
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">订单号码</label>
                <span class="weui-form-preview__value"><?php echo $orderid; ?></span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">支付方式</label>
                <span class="weui-form-preview__value">微信支付</span>
            </div>
        </div>
        <div class="weui-form-preview__ft">
            <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:" onclick="callpay()">立即支付</a>
        </div>
    </div>
</div>
</body>
</html>
<?php
}elseif($select_pay=='user_money')
{
    if($user['user_money']<$data['data']['total_money'])
    {
        exit('余额不足');
    }
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <title>订单支付</title>
        <link rel="stylesheet" type="text/css" href="/template/source/css/font.min.css">
        <link rel="stylesheet" type="text/css" href="/template/source/css/weui.min.css">
        <link rel="stylesheet" type="text/css" href="/template/source/css/rest.css">
        <link rel="stylesheet" type="text/css" href="/template/source/css/main.css">
        <style type="text/css">
            .left_arrow_new img{margin: 15px 0;}
            .left_arrow_new a,.left_arrow_new a:hover{color: #fff; font-size: 1.2em}
            .pay_select li{ margin-top: 10px; float: left;width: 30%;margin-left: 2%;height: 40px;border: 2px solid #bcbcbc; line-height: 40px;}
            .weui-form-preview{position:absolute; width:100%; height:100%; left:0; bottom:0; background:white;}
            .weui-form-preview__bd{position:relative;}
            .weui-form-preview__bd::after{content: " ";
                position: absolute;
                left: 0;
                bottom: 0;
                right: 0;
                height: 1px;
                border-bottom: 1px solid #D9D9D9;
                color: #D9D9D9;
                -webkit-transform-origin: 0 100%;
                transform-origin: 0 100%;
                -webkit-transform: scaleY(0.5);
                transform: scaleY(0.5);
                left: 0;
            }
            .zd-weui-btn {
                padding: .4rem 10%;
            }
            .weui-label{width:90px;}
            .weui-select,.weui-textarea,.weui-input{font-family:'微软雅黑'}
            .weui-cells{margin-top:0;}
            .weui-btn+.weui-btn{margin-top:1rem;}
            .weui-form-preview__hd:after{left:0}
            .weui-form-preview__ft{margin:20px auto 0; background:#0BB20C; width:90%;}
            .weui-form-preview__btn_primary{color:#FFF; font-family:"微软雅黑";}

            .weui-form-preview:after{border-bottom:none;}
            .weui-form-preview__hd{text-align:center;}
            .weui-form-preview__zdlabel{font-family:"微软雅黑";}
            .weui-form-preview__zdvalue{font-weight:bold; font-size:28px; font-family:"微软雅黑";}
            .weui-form-preview__label,.weui-form-preview__value{font-family:"微软雅黑";}
            .weui-form-preview__value{color:#000;}
            .integral-title{border:none;}
        </style>
        <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    </head>
    <body  style="background-color:#f6f6f6;">
    <div id="container" class="container">
        <div class="weui-form-preview">
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__zdlabel">支付订单金额</div>
                <div class="weui-form-preview__zdvalue">
                    ￥ <?php echo $order['total_money']; ?>
                </div>
            </div>
            <div class="weui-form-preview__bd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">订单号码</label>
                    <span class="weui-form-preview__value"><?php echo $orderid; ?></span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">支付方式</label>
                    <span class="weui-form-preview__value">余额支付</span>
                </div>
            </div>
            <div class="weui-form-preview__ft">
                <a class="weui-form-preview__btn weui-form-preview__btn_primary" id="money_pay" href="javascript:">立即支付</a>
            </div>
        </div>
    </div>
    <div class="js_dialog" id="iosDialog1" style="opacity: 1; display: none;">
        <div class="weui-mask" onClick="hidePrice()" ></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd" style="padding:.8em 1.6em; border-bottom:1px solid #0bb20c;"><strong class="weui-dialog__title">请输入支付密码</strong></div>
            <div class="weui-dialog__bd" style=" padding:1.6em .8em; height:40px;">
                <div style="width:100%; height:100%; display:block; border:1px solid #ededed; box-sizing:border-box;">
                    <input type="password" class="weui-input" id="payment" maxlength="6" pattern="[0-9]*" style="height:100%; line-height:40px; padding:0 5%; width:90%; font-size:16px; line-height:normal;">
                </div>
            </div>
            <div class="weui-dialog__ft">
                <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default" onClick="hidePrice()">取消</a>
                <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" onclick="check_pass()">确认</a>
            </div>
        </div>
    </div>
    </body>
    <script src="/tool/layer/layer_mobile/layer.js"></script>
    <script>
        //支付密码窗口
        var $iosDialog1 = $('#iosDialog1');
        function hidePrice(){
            $iosDialog1.fadeOut(200);
            $('#payment').val('');
        }
        function showPrice(){
            $iosDialog1.fadeIn(200);
            $('#payment').focus();
        }

        var link = '?mod=weixin&v_mod=checkout&_index=_pay_result&orderid=<?php echo $_GET['orderid']; ?>&shop_id=<?php echo $_GET['shop_id']; ?>';
        //无需密码提交
        $("#money_pay").click(function ()
        {
            var pay_password = '<?php echo $user['pay_password']?'1':'';?>';
            if(pay_password!='')
            {
                $iosDialog1.fadeIn(200);
                $('#payment').focus();
                return false;
            }
            var that = $(this);
            if(that.hasClass('disabled'))
            {
                return false;
            }
            that.addClass('disabled');
            $.ajax({
                type:'get',
                url:'<?php echo _URL_; ?>&_action=ActionUserMoneyPay',
                success:function (res)
                {
                    layer_msg(res.msg);
                    if(res.code==0)
                    {
                        location.href=link;
                    }else{
                        that.removeClass('disabled');
                    }
                },
                error:function ()
                {
                    layer_msg('提交失败');
                    that.removeClass('disabled');
                },
                dataType:'json'
            });
        });

        //密码提交订单
        function check_pass()
        {
            var password = $('#payment').val();
            if(password=='')
            {
                layer_msg('请输入支付密码');
                return false;
            }
            var that = $("#money_pay");
            if(that.hasClass('disabled'))
            {
                return false;
            }
            that.addClass('disabled');
            $.ajax({
                type:'get',
                data:{'password':password},
                url:'<?php echo _URL_; ?>&_action=ActionUserMoneyPay',
                success:function (res)
                {
                    layer_msg(res.msg);
                    if(res.code==0)
                    {
                        location.href=link;
                    }else{
                        that.removeClass('disabled');
                    }
                },
                error:function ()
                {
                    layer_msg('提交失败');
                    that.removeClass('disabled');
                },
                dataType:'json'
            });
        }

        function layer_msg(msg)
        {
            layer.open({
                content: msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
        }
    </script>
    </html>
    <?php
}else{
    exit('404');
}