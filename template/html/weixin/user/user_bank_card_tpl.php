<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetBankCardList();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>银行卡管理</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/weixin/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/rest.css">
    <link rel="stylesheet" href="/template/source/weixin/css/main.css">
    <style>
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell:first-child::before{border-top:none}
        .web-cell:before{left:0;}
        .web-cart-error .error-btn>a{border-color:#999999; color:#999999;}


    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

<div class="mui-content">


    <?php
    if(empty($data))
    {
        ?>
        <div class="web-cart-error tc" style="display: block;">
            <img src="/template/source/default/images/no_walletBanrk_i.png">
            <p class="fr14 cl_b3 mt10">暂无绑定银行卡</p>
            <div class="mtr30 error-btn"><a href="?mod=weixin&v_mod=user&_index=_bank_card_new">＋ 添加银行卡</a></div>
        </div>
        <?php
    }
    ?>



    <div class="web-wallet-body">

        <div class="web-bank-warp">
            <ul>
                <?php
                if($data)
                {
                    foreach($data as $item)
                    {
                        ?>
                        <li class="web-bank-item"
                            onclick="location.href='?mod=weixin&v_mod=user&_index=_bank_card_edit&id=<?php echo $item['id']; ?>'">
                            <div class="web-bank-mess">
                                <h1 class="fr16"><?php echo $item['bank_name']; ?></h1>
                                <p class="fr14">持卡人：<?php echo $item['bank_username']; ?></p>
                                <div class="fr18 mtr10 tr"><?php echo $obj->GetCardTran($item['bank_card_number']); ?></div>
                            </div>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <?php
        if(count($data)<3)
        {
            ?>
            <div class="web-cells">
                <a href="?mod=weixin&v_mod=user&_index=_bank_card_new" class="web-cell web-cell_access">
                    <div class="web-cell__hd">
                        <img src="/template/source/default/images/plur.png" style="width:1.25rem; height: 1.25rem; display: block; margin-right:10px;">
                    </div>
                    <div class="web-cell__bd">
                        <span class="fr14">添加更多银行卡</span>
                    </div>
                    <div class="web-cell__ft"></div>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</div>


<div onClick="window.location.href='/?mod=weixin&v_mod=user'" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>


<script src="/template/source/weixin/js/mui.min.js"></script>

<script>

</script>
</body>
</html>