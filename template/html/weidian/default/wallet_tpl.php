<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user = $obj->GetUserInfo(SYS_USERID);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>我的钱包</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
		
       .web-cells:before,.web-cells:after,.web-cell:before{border:none;}
		
		
        .web-wallet-hd{padding:2rem 3%; background:#26a8ff;}
        .web-wallet-title{ color:#bce1f9}
        .web-wallet-title>a{color:#bce1f9; position: relative;}
        .web-wallet-title>a::after{
            content: " ";
            display: inline-block;
            height: 6px;
            width: 6px;
            border-width: 2px 2px 0 0;
            border-color: #bce1f9;
            border-style: solid;
            -webkit-transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
            transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
            position: relative;
            top: -2px;
            position: absolute;
            top: 50%;
            margin-top: -4px;
            right: 3%;
        }
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

<div class="mui-content">


    <div class="web-wallet-hd">
        <div class="web-wallet-title fr16">
            余额账户（元）
            <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=wallet&_index=_fine&v_shop='.$v_shop.''; ?>" class="fr pr15">
                余额明细
            </a>
            <div class="cb"></div>
        </div>

        <p class="mt30 white" style="font-size:56px"><?php echo $user['user_money']; ?></p>

    </div>




    <div class="web-cells" >
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=wallet&_index=_recharge&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access" style="border-bottom:1px solid #e8e8e8;">
            <div class="web-cell__hd">
                <img src="/template/source/default/images/web_icon/web_wallet_1.png" style="width: 1.25rem; height: 1.25rem; display: block; margin-right:10px;">
            </div>
            <div class="web-cell__bd">
                <p class="fr16 cl_b3">充值</p>
            </div>
            <div class="web-cell__ft"></div>
        </a>
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=wallet&_index=_drawals&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access">
            <div class="web-cell__hd">
                <img src="/template/source/default/images/web_icon/web_wallet_2.png" style="width: 1.25rem; height: 1.25rem; display: block; margin-right:10px;">
            </div>
            <div class="web-cell__bd">
                <p class="fr16 cl_b3">提现</p>
            </div>
            <div class="web-cell__ft"></div>
        </a>


    </div>

    <div class="web-cells" >
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=wallet&_index=_bank&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access" style="border-bottom:1px solid #e8e8e8;">
            <div class="web-cell__hd">
                <img src="/template/source/default/images/web_icon/web_wallet_3.png" style="width: 1.25rem; height: 1.25rem; display: block; margin-right:10px;">
            </div>
            <div class="web-cell__bd">
                <p class="fr16 cl_b3">银行卡管理</p>
            </div>
            <div class="web-cell__ft"></div>
        </a>
        <a href="javascript:;" class="web-cell web-cell_access">
            <div class="web-cell__hd">
                <img src="/template/source/default/images/web_icon/web_wallet_4.png" style="width: 1.25rem; height: 1.25rem; display: block; margin-right:10px;">
            </div>
            <div class="web-cell__bd">
                <p class="fr16 cl_b3">积分</p>
            </div>
            <div class="web-cell__ft">
                <span class="fr12 mr10">53积分</span>
            </div>
        </a>

    </div>

</div>




<script src="/template/source/default/js/mui.min.js"></script>
<script>

</script>
</body>
</html>