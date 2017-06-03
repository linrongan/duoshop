<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>会员卡申请</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?6666">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style>
        .weui-cells__title{padding:0 3%; color:#333333;}
        .no-weui-link::before,.no-weui-link::after,.no-weui-link>.weui-cell::before,.no-weui-link>.weui-cell::after{border:none !important;}
        .cart-list{padding:0 3%;}
        .cart-list .weui-cells,.cart-list .weui-cell{border-radius:5px;}
        .cart-list .weui-cells{background:none;}
        .cart-list .weui-cell{margin-bottom:.2rem; min-height:1.4rem; padding:.2rem 10%;}
        /*.cart-list .weui-cell:last-child{margin-bottom:0;}*/
        .cart-text,.cart-name{  text-shadow:1px 1px 2px #666;}
        .weui-cell__ewm{position:absolute; right:3%; top:.3rem;}
        .cart-number>span{display:inline-block; width:80px; height:30px; line-height:30px; padding:0 10px; border-radius:3px; background:#04be02; color:white;}
        .weui-cell__money{width:90%; height:.6rem; line-height:.6rem; position:absolute; bottom:.2rem; left:10%; font-size:.36rem;}
        .weui-cell__money>span{}
    </style>
</head>
<body style="background:#f1f1f5;">
<div class="weui-cells__title sz16r">
    申请会员卡操作
    <div class="clearfix"></div>
</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label sz14r">
                    <span class="fense">*</span>
                    手机号：
                </label>
            </div>
            <div class="weui-cell__bd">
                <input name="phone" id="phone" class="weui-input sz12r" type="number" pattern="[0-9]*" placeholder="请输入手机号">
            </div>
        </div>

        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label sz14r">  <span class="fense">*</span>&nbsp;验证码：</label>
            </div>
            <div class="weui-cell__bd">
                <input id="code" name="code" class="weui-input sz12r" type="tel" placeholder="请输入验证码">
            </div>
            <div class="weui-cell__ft">
                <button class="weui-vcode-btn sz14r" id="smscode_btn">获取验证码</button>
            </div>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label"> 公司名称</label></div>
        <div class="weui-cell__bd">
            <input id="company_name" name="company_name" class="weui-input" value="" type="text" placeholder="请输入真实姓名">
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">  <span class="fense">*</span>真实姓名</label></div>
        <div class="weui-cell__bd">
            <input id="username" name="username" class="weui-input" value="" type="text" placeholder="请输入真实姓名">
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">  <span class="fense">*</span>出生年月</label></div>
        <div class="weui-cell__bd">
            <input id="birthday" name="birthday" class="weui-input" value="" type="date" placeholder="请输入出生年月">
        </div>
    </div>
</div>

<div class="weui-btn-area">
    <a class="weui-btn weui-btn_primary" href="javascript:" id="SubmitBtn">确定申请</a>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/comm.js"></script>
<script type="text/javascript" src="/template/source/layer/layer.js"></script>
<script>
    $(function(){
        $("#SubmitBtn").click(function(){
            if (!checkPhone($("#phone").val()))
            {
                layer.open({
                    content: '请输入正确的手机号',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
            if (ChkUtil_isNull($("#code").val()))
            {
                layer.open({
                    content: '请输入手机验证码',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
            if (ChkUtil_isNull($("#username").val()))
            {
                layer.open({
                    content: '请输入真实姓名',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
            if (ChkUtil_isNull($("#birthday").val()))
            {
                layer.open({
                    content: '请输入出生年月',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
            layer.open({
                type: 2,
                content: '请求中'
            });

            var birthday=$("#birthday").val();
            var username=$("#username").val();
            var phone=$("#phone").val();
            var code=$("#code").val();
            var company_name=$("#company_name").val();
            $.ajax({
                cache:false,
                type:"POST",
                url:"/?mod=weixin&v_mod=user&_index=_vip_apply&_action=ActionApplyVipCard",
                data:{"username":username,"birthday":birthday,"phone":phone,"code":code,"company_name":company_name},
                dataType:"json",
                success:function(result)
                {
                    layer.closeAll();
                    if (result.code==0)
                    {
                        layer.open({
                            content:'恭喜您会员卡申请成功',
                            btn: '关闭窗口',
                            yes: function(index)
                            {
                                window.location.href='/?mod=weixin&v_mod=user&_index=_vip_card';
                                layer.close(index);
                            }
                        });
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

    var SECOND=0;
    var STOP_SECOND=0;
    $(function()
    {
        $("#smscode_btn").click(function()
        {
            if (checkPhone($("#phone").val())==false)
            {
                layer.open({
                    content: '请输入11位手机号码',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
            if (SECOND>0)
            {
                alert("重新发送还剩"+SECOND+"秒");
                return false;
            }

            $.ajax({
                type: "GET",
                url: "/?mod=weixin&v_mod=smscode&_action=ActionSentBindPhone&phone="+$("#phone").val(),
                dataType: "json",
                success: function(result)
                {
                    layer.open({
                        content: result.msg,
                        skin: 'msg',
                        time: 2 //2秒后自动关闭
                    });
                    if (result.code==0)
                    {
                        SECOND=60;
                        STOP_SECOND=setInterval('run_smscode()',1100);
                        return false;
                    }
                },
                error: function (xmlHttpRequest, error) {
                    alert("发送异常");
                }
            })
        })
    })

    function run_smscode()
    {
        if (SECOND>0)
        {
            SECOND--;
            $("#smscode_btn").text(""+SECOND+"秒");
        }
        else
        {
            clearInterval(STOP_SECOND);
            $("#smscode_btn").text("获取验证码");
        }
    }
</script>
</body>
</html>