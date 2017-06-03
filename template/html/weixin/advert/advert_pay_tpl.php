<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(!isset($_GET['a_id']))
{
    redirect(NOFOUND.'&msg=参数错误');
}
$advert = $obj->GetAdvertDetails(intval($_REQUEST['a_id']));
$data = $advert['data'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <title>投放广告</title>
    <link rel="stylesheet" type="text/css" href="/template/source/css/font.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/weui.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/rest.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/main.css">
    <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    <style type="text/css">
        .left_arrow_new img{margin: 15px 0;}
        .left_arrow_new a,.left_arrow_new a:hover{color: #fff; font-size: 1.2em}
        .pay_select li{ margin-top: 10px; float: left;width: 30%;margin-left: 2%;height: 40px;border: 2px solid #bcbcbc; line-height: 40px;}
        .weui-form-preview{margin-bottom:20px;}
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
        .weui-cell{padding:.2rem 3%;}
        .select_money{border:#ff0000 }
        img{max-width: 100%;}
    </style>

    <script type="text/javascript">
        //调用微信JS api 支付
        var appId='';
        var timeStamp='';
        var nonceStr='';
        var package1='';
        var signType='';
        var paySign='';
        var orderid='';
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                {
                    "appId":appId,     //公众号名称，由商户传入
                    "timeStamp":timeStamp,         //时间戳，自1970年以来的秒数
                    "nonceStr":nonceStr, //随机串
                    "package":package1,     //统一订单号
                    "signType":signType,         //微信签名方式：
                    "paySign":paySign //支付签名
                },
                function(res){
                    if(res.err_msg=="get_brand_wcpay_request:ok" )
                    {
                        window.location.href='/?mod=weixin&v_mod=advert&_index=_result&orderid='+orderid;
                    }else
                    {

                    }
                }
            );
        }

        function payment()
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
<body style="background-color:#f6f6f6;font-size: 14px">
<div class="mtb04" style="padding:.2rem 3%; background:#FFF; border-top:1px solid #ededed; border-bottom:1px solid #ededed;">
    <p style="font-size: 16px;font-weight: bold">介绍</p>
    <p style="color: red;padding: 10px">
    1、投放位置：商户后台选择投放的区域和位置，支付成功后不允许更换和修改，如有疑问请联系客服人员帮忙处理。<br/>
    2、投放时间段：投放时间段根据当前排队投放的人数和出价高低（相同时间段内根据额外竞价费用）进行排序，在每期投放开始前，被选中投放的商户管理员（创建投放者），将收到提醒消息，请留意短信或微信信息<br/>
    3、投放时长：根据单价*购买的数量决定时长<br/>
    </p>
    <p style="font-size: 16px;font-weight: bold">图片</p>
    <p style="color: red;"><?php echo $data['picture_title'];?></p>
    <p style="padding: 10px"><img src="<?php echo $data['picture_img'];?>" alt=""/></p>
    <p style="font-size: 16px;font-weight: bold">图片链接</p>
    <p style="color: red;padding: 10px"><?php echo $data['picture_link'];?></p>
    <p style="font-size: 16px;font-weight: bold">投放区域</p>
    <p style="color: red;padding: 10px"><?php echo $data['name'];?></p>
    <p style="font-size: 16px;font-weight: bold">投放时段预测</p>
    <p style="color: red;padding: 10px">
        <?php
            if(empty($advert['shiduan']))
            {
               echo '当前空闲，可立即投放，先到先得哦';
            }else{
                echo '预计投放时间'.$advert['expire_time'].'之后';
            }
        ?>
    </p>
</div>
<div class="weui-cells__title cl999 sz14r">
    请选择投放时间（每小时￥<?php echo $data['price'];?>）
</div>
<div style="width: 100%;height: 5px"></div>
<div id="container" class="container">
    <div class="weui-grids">
        <div class="weui-grids">
            <a rel="<?php echo $data['price']*24;?>" href="javascript:;" class="weui-grid select_money">
                <p class="weui-grid__label">
                    1天
                </p>
            </a>
            <a rel="<?php echo $data['price']*24*2;?>" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    2天
                </p>
            </a>
            <a rel="<?php echo $data['price']*24*3;?>" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    3天
                </p>
            </a>
            <a rel="<?php echo $data['price']*24*4;?>" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    4天
                </p>
            </a>
            <a rel="<?php echo $data['price']*24*5;?>" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    5天
                </p>
            </a>
            <a rel="<?php echo $data['price']*24*7;?>" href="javascript:;" class="weui-grid">
                <p class="weui-grid__label">
                    7天
                </p>
            </a>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label sz14r">金额(￥)：</label>
            </div>
            <div class="weui-cell__bd">
                <input pattern="[0-9]*" readonly class="weui-input sz14r" id="money" name="money" value="" type="number" placeholder="请选择上述投放天数">
            </div>
        </div>
    </div>
    <div class="zd-weui-btn">
        <a href="javascript:;" id="chagreBtn" class="weui-btn weui-btn_primary sz14r">付款</a>
    </div>
</div>
<script type="text/javascript" src="/template/source/layer/layer.js"></script>
<script type="text/javascript" src="/template/source/js/comm.js"></script>
<script type="text/javascript" src="/template/source/layer/layer.js"></script>
</body>
<script>
    $(function()
    {
        $(".weui-grids a").click(function()
        {
            $(".weui-grids a").removeClass("select_money");
            $(this).addClass("select_money");
            var money=$(this).attr("rel");
            $("#money").val(money);
        })

        $("#chagreBtn").click(function()
        {
            var money=$("#money").val();
            var a_id ='<?php echo intval($_GET['a_id']);?>';
            if (ChkUtil_isNull(money))
            {
                layer.open({
                    content: '金额不正确',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
            var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
            if(!reg.test(money))
            {
                layer.open({
                    content: '金额不正确',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
            layer.open({
                type: 2
                ,content: '加载中'
            });
            $.ajax({
                cache:false,
                type:"POST",
                url:"/?mod=weixin&v_mod=pay&_action=ActionPayAdvert",
                data:{"money":money,"id":a_id},
                dataType:"json",
                success:function(result)
                {
                    layer.closeAll();
                    if (result.package!='prepay_id=')
                    {
                        appId=result.appId;
                        timeStamp=result.timeStamp;
                        nonceStr=result.nonceStr;
                        package1=result.package;
                        signType=result.signType;
                        paySign=result.paySign;
                        orderid=result.orderid;
                        payment();
                    }else
                    {
                        layer.open({
                            content: result.msg,
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                    }
                },
                error:function(result) {
                    alert("网络超时,请重试!");
                }
            });
        })
    })
</script>
</html>