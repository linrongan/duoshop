<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(trim($_GET['orderid'])==0)
{
    redirect('/?mod=weixin&v_mod=point&_index=_record');
}
$user=$obj->GetUserInfo(SYS_USERID);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>礼品订单</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/daili/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
		.vip-nav .vip-nav-item {
			line-height: .88rem;
		}
    </style>
</head>
<body>
<?php $data=$obj->GiftOrderDetailList();
if (!empty($data['data'])){
?>
<div class="gg-shopping-container">
    <?php
    foreach($data['data'] as $item){?>

    <ul class="gg-shopping-warp">
        <li class="gg-shopping-item <?php echo $item['hx_status']?"cannothx":""; ?>" id="<?php echo $item['hx_code']; ?>">
            <div class="fl gg-shopping-proImg">
                <img src="<?php echo $item['gift_img']; ?>">
            </div>
            <div class="fr gg-shopping-main">
                <p class="tlie sz14r cl999">订单号：<?php echo $item['orderid']; ?></p>
                <p class="omit sz14r"><?php echo $item['gift_name']; ?></p>
                <p class="tlie sz12r cl999">单价：<?php echo $item['gift_point']; ?>积分</p>
                <p class="tlie sz12r cl999">数量：<?php echo $item['qty']; ?></p>
                <?php
                    if($item['ship_status']>3)
                    {
                        ?>
                        <p class="tlie sz12r cl999" style="color:red;">已发货</p>
                        <?php
                    }else
                    {
                        ?>
                        <p class="tlie sz12r cl999" style="color: green;">未发货</p>
                        <?php
                    }
                ?>
            </div>
            <div class="clearfix"></div>
        </li>
        <?php }
        }else
        {?>
            <div class="search-empty-panel">
                <div class="content">
                    <img src="/template/source/images/no_content.png">
                    <div class="text">暂无兑换记录</div>
                </div>
            </div>
        <?php
        } ?>
    </ul>
</div>
<div class="return">
    <a href="javascript:;" class="glyphicon glyphicon-arrow-left fffColor sz14r" onclick="javascript :history.back(-1);"></a>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
</body>
</html>