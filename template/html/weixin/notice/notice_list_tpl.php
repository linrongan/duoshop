<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetNoticeList();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>通知消息</title>
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
		.tips-list{padding:.5rem 4%;}
		.web-cells{border-radius:5px;}
		.web-cells::after,.web-cells::before,.web-cell:before{border:none;}
		.tips-time>span{display:inline-block; padding:1px 5px; color:white; background:rgba(0,0,0,0.4); border-radius:3px; font-size:12px;}
		.web-name{padding:.5rem 3% 0; font-size:15px; color:#333333;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>

</head>
<body >

<div class="mui-content">

    <!--没有购物产品提示 -->
    <div class="web-cart-error tc" style="display: <?php echo $data?'none':'block'; ?>;">
        <img src="/template/source/default/images/no_order_i.png">
        <p class="fr16 cl_b3">亲，暂无没有您的信息</p>
    </div>
	
    <div class="tips-list">
        <?php
            if($data)
            {
                foreach($data as $val)
                {
                    ?>
                    <div class="tips-item mb10">
                        <a href="<?php if($val['open_way']==1){echo $val['alert_link'];}elseif($val['open_way']==0){echo '?mod=weixin&v_mod=notice&_index=_details&id='.$val['alert_id'];} ?>">
                            <div class="tips-time tc"><span><?php echo $val['alert_date']; ?></span></div>
                            <div class="web-cells">
                                <div class="web-name"><?php echo $val['title']; ?></div>
                                <div class="web-cell">
                                    <div class="web-cell__hd"><img src="<?php echo $val['img']; ?>" style="width:60px; height:60px; display:block; margin-right:10px;"></div>
                                    <div class="web-cell__bd">
                                        <p class="f14" style="color:#555555;">
                                            <?php echo $val['abstract']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }
        ?>


    </div>
</div>

<div onClick="history.back()" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>


<script src="/template/source/default/js/mui.min.js"></script>



</body>
</html>