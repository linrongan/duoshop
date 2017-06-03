<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetBankDetails();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>银行卡详情</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/weixin/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/rest.css">
    <link rel="stylesheet" href="/template/source/weixin/css/main.css">
    <link rel="stylesheet" href="/template/source/weixin/css/mui.picker.min.css" />
    <link rel="stylesheet"  href="/template/source/weixin/css/mui.poppicker.css" />
    <style>
        .web-cells:before,.web-cells:after,.web-cell:before{border:none;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body >
<div class="mui-content">
    <div class="web-cells" style="margin-top:0">

        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">持卡人</label>
            </div>
            <div class="web-cell__bd tr">
                <?php echo $data['bank_username']; ?>
            </div>
            <div class="web-cell__ft"></div>
        </div>

        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">银行类型</label>
            </div>
            <div class="web-cell__bd tr">
                <?php echo $data['bank_name']; ?>
            </div>
            <div class="web-cell__ft"></div>
        </div>

        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">银行卡号</label>
            </div>
            <div class="web-cell__bd tr">
                <?php echo $data['bank_card_number']; ?>
            </div>
            <div class="web-cell__ft"></div>
        </div>
        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">身份证号码</label>
            </div>
            <div class="web-cell__bd tr">
                <?php echo $data['bank_user_card']; ?>
            </div>
            <div class="web-cell__ft"></div>
        </div>
    </div>
    <div style="padding:0 10%;" class="tc mtr30">
        <a href="javascript:;" data-loading-icon="mui-spinner mui-spinner-custom"
           class="mui-btn mui-btn-success fr16" id="sumbit" style="padding:8px 60px;width: 100%; line-height: 1.7 ">解绑</a>
    </div>
</div>

<script src="/template/source/weixin/js/mui.min.js"></script>
<script src="/template/source/weixin/js/mui.picker.min.js"></script>
<script src="/template/source/weixin/js/mui.poppicker.js"></script>
</body>
<script>
    $(function () {
       $("#sumbit").click(function ()
       {
           var obj = $(this);
           mui.confirm('确定要解除绑定？','系统提示',function (res)
           {
               if(res.index)
               {
                   $.ajax({
                       type:"get",
                       url:'<?php echo _URL_; ?>&_action=ActionCpanelBank',
                       dataType:"json",
                       success:function (data)
                       {
                           mui(obj).button('reset');
                           mui.toast(data.msg);
                           if(data.code==0)
                           {
                               location.href='/?mod=weixin&v_mod=user&_index=_bank_card';
                           }
                       },
                       error:function () {
                           mui(obj).button('reset');
                           mui.toast('网络超时');
                       }
                   });
               }
           });
       })
    });
</script>
</html>