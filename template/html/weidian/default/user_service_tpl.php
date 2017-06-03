<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>客服服务</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-service-body{padding:.5rem 3%; background:white;}
        .web-textarea,.web-input{ border-radius: 0; border:1px solid #e8e8e8 !important; padding: .4rem .5rem !important;}
        .web-input{line-height:normal !important; height: 3em !important;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body >

<div class="mui-content">

    <div class="web-service-body">
        <div class="web-service-title fr16">意见和问题</div>
        <div class="web-service-content mtr5">
            <textarea class="web-textarea fr14" rows="5" id="message" placeholder="请描述您遇到的问题"></textarea>
        </div>
    </div>
    <div class="web-service-body">
        <div class="web-service-title fr16">联系电话</div>
        <div class="web-service-content mtr5">
            <input class="web-input fr14" type="number" id="contact" maxlength="11" pattern="[0-9]*" placeholder="请输入手机号">
        </div>
    </div>

    <div style="padding:0 10%;" class="tc mtr30">
        <a href="javascript:;" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-danger fr16 " id="sumbit" style="padding:8px 60px;width: 100%; line-height: 1.7 ">提交</a>
    </div>
	
</div>


<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script type="text/javascript">
    (function($, doc) {
        $.init();
        $.ready(function() {
            $(doc.body).on('tap', '#sumbit', function(e)
            {
                var message = document.getElementById("message").value;
                var contact = document.getElementById("contact").value;
                if(message=='')
                {
                    mui.alert('请输入您的意见');
                    return false;
                }
                if(message.length<5)
                {
                    mui.alert('至少输入5字或更多');
                    return false;
                }
                if(contact.length<=0)
                {
                    mui.alert('请输入您的联系方式');
                    return false;
                }
                var obj = $(this);
                obj.button('loading');
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=user&_index=_service&v_shop=<?php echo $_GET['v_shop']; ?>&_action=ActionNewFeedback",
                    data:{message:message,contact:contact},
                    dataType:"json",
                    success:function (data)
                    {
                        obj.button('reset');
                        mui.toast(data.msg);
                        if(data.code==0)
                        {
                            document.getElementById("message").value = '';
                            document.getElementById("contact").value = '';
                        }
                    },
                    error:function ()
                    {
                        obj.button('reset');
                    }
                });
            });

        })
    }(mui,document))
</script>
</body>
</html>