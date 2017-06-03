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
<div class="weui-cells__title rf14">我要资助</div>
<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14">姓名：</label></div>
        <div class="weui-cell__bd"><input type="text" id="name" class="weui-input rf14" placeholder="请输入姓名"></div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14">联系电话：</label></div>
        <div class="weui-cell__bd"><input type="tel" id="phone" class="weui-input rf14" placeholder="请输入联系电话"></div>
    </div>
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__hd"><label class="weui-label rf14">所在城市：</label></div>
        <div class="weui-cell__bd"><input type="text" readonly class="weui-input rf14" id="live_area" placeholder="请选择所在地区"></div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14">资助(金额)物品：</label></div>
        <div class="weui-cell__bd"><input type="text" id="need_goods" class="weui-input rf14" placeholder="请输入资助（金额）物品"></div>
    </div>
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__hd"><label class="weui-label rf14">本地房产：</label></div>
        <div class="weui-cell__bd"><input type="text" id="house" class="weui-input rf14" placeholder="请输入本地相关房产"></div>
    </div>
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__hd"><label class="weui-label rf14">职业：</label></div>
        <div class="weui-cell__bd"><input type="text" id="occupation" class="weui-input rf14" placeholder="请输入职业"></div>
    </div>
</div>
<!--
<div class="weui-cells__title rf14">温馨提示</div>
<p class="rf14 lh20" style="text-indent:2em;">温馨提示内容</p>-->
<div style="padding:1rem 10%">
    <a href="javascript:;" onclick="reg_input_data()" class="weui-btn weui-btn_primary rf16">下一步</a>
</div>

<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/template/source/weixin/js/fastclick.js"></script>
<script src="/template/source/weixin/js/jquery-weui.min.js"></script>
<script src="/template/source/weixin/js/city-picker.js"></script>
<script src="/template/source/weixin/js/guageEdit.js"></script>
<script src="/tool/layer/layer_mobile/layer.js"></script>
<script>

    $("#live_area").cityPicker({
        title: "请选择所在地区",
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


    function reg_input_data()
    {
        var filed = ['name','phone','live_area','need_goods','house','occupation'];
        var reg_status = 1;
        var data = {};
        for(var i=0;i<filed.length;i++)
        {
            var reg_filed = $("#"+filed[i]);
            if(reg_filed.val()=='')
            {
                reg_status = 0;
                layer_msg('请输入'+reg_filed.parents('.weui-cell').find('label').html().substring(0,reg_filed.parents('.weui-cell').find('label').html().length-1));
                break;
                return false;
            }
            data[filed[i]] = reg_filed.val();
        }
        if(reg_status)
        {
            $.ajax({
                type:'post',
                url:'/?mod=weixin&v_mod=seekhelp&_index=_back&_action=ActionAddHelp',
                data:data,
                success:function (res)
                {
                    layer_msg(res.msg);
                    if(res.code==0)
                    {
                        window.location.href='/?mod=weixin&v_mod=seekhelp&_index=_result';
                    }
                },
                error:function ()
                {
                    layer_msg('请求超时或者错误，请确实网络是否正常');
                },
                dataType:'json'
            });
        }
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
</body>
</html>