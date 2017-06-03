<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$role = $obj->GetNoticeRoleMsg();
$read = $obj->GetNoticeLookStatus();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>我的消息</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-cells:first-child{margin-top:0;}
        .web-cells::before{border-top:none;}
        .web-cell:first-child::before{border-top:none;}
        .web-cell:before{left:0;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>

</head>
<body >

<div class="mui-content">
    <div class="web-cells" style="margin-top: 0;">
        <?php
            if(!empty($role))
            {
                for ($i=0;$i<count($role);$i++)
                {
                    ?>
                    <a href="?mod=weixin&v_mod=notice&_index=_list&role_id=<?php echo $role[$i]['alert_role_id']; ?>" class="web-cell">
                        <div class="web-cell__hd web-message-title mr10">
                            <img src="<?php echo $role[$i]['icon']; ?>" style="width:3rem; height: 3rem; display:block; ">
                            <?php
                                if($read && array_key_exists($role[$i]['alert_role_id'],$read))
                                {
                                    if($read[$role[$i]['alert_role_id']])
                                    {
                                        ?>
                                        <span>new</span>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <span>new</span>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="web-cell__bd">
                            <div>
                                <span class="fl fr14 cl_b3 omit" style="width: 70%"><?php echo $role[$i]['name']; ?></span>
                                <span class="fr fr12 cl_b9"><?php echo $role[$i]['alert_date']; ?></span>
                                <div class="cb"></div>
                            </div>
                            <div class="mtr10 fr12 cl_b9 ">点击查看</div>
                        </div>
                    </a>
                    <?php
                }
            }else
            {
                ?>
                <!--没有消息提示 -->
                <div class="web-cart-error tc">
                    <img src="/template/source/default/images/no_order_i.png">
                    <p class="fr16 cl_b3">亲，暂无没有您的信息</p>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<div onClick="window.location.href='/?mod=weixin&v_mod=user'" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>

<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>


</body>
</html>