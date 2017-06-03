<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetPointLog();
$user=$obj->GetUserInfo(SYS_USERID);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>积分记录</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/daili/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style>
        .vip-nav{background:#45b0f7; padding:.4rem;}
        .weui-cells:before {
            border-top: none;
        }
    </style>
</head>
<body>
<div class="vip-nav">
    <div class="vip-nav-item">
        <h1 class=" fffColor" style="font-size:.5rem">
            <?php echo $user['user_point']; ?>
        </h1>
        <p class="sz16r fffColor mtr02">剩余积分</p>
    </div>
    <div class="vip-nav-item">
        <h1 class=" fffColor" style="font-size:.5rem">
            <?php echo empty($data['get'])?0:$data['get']; ?>
        </h1>
        <p class="sz16r fffColor mtr02">累计积分</p>
    </div>
    <div class="vip-nav-item">
        <h1 class="sz16r fffColor" style="font-size:.5rem">
            <?php echo $data['fee']==''?0:$data['fee']; ?>
        </h1>
        <p class="sz16r fffColor mtr02">消费积分</p>
    </div>
</div>
<div class="weui-cells" style="margin-top:0">
    <a class="weui-cell weui-cell_access" href="/?mod=weixin&v_mod=point&_index=_shop">
        <div class="weui-cell__bd">
            <p>积分记录</p>
        </div>
        <div class="weui-cell__ft">
            积分兑换
        </div>
    </a>
</div>
<?php if (!empty($data['data'])){?>
    <div class="weui-cells" style="margin-top:0">

        <?php foreach($data['data'] as $item){?>
            <a class="weui-cell weui-cell_access" href="/?mod=weixin&v_mod=point&_index=_order_detail&orderid=<?php echo $item['orderid'];?>">
                <div class="weui-cell__bd">
                    <p class="sz14r ">
                        <?php if($item['type_id']==99){
                            echo '签到得积分';
                        }elseif($item['type_id']==7)
                        {
                            echo '兑换礼品';
                        }
                        ?>
                    </p>
<!--                    <p class="sz12r cl999 omit">余额：--><?php //echo $item['point_banlace']; ?><!--</p>-->
                    <p class="sz12r cl999 omit"><?php echo $item['addtime']; ?></p>
                </div>
                <div class="weui-cell__tf">
                    <span class="sz16r redColor"><?php echo $item['point']>0?'+'.$item['point']:$item['point']; ?> 积分</span>
                </div>
            </a>
        <?php } ?>
    </div>
<?php }else{?>
    <div class="search-empty-panel">
        <div class="content">
            <img src="/template/source/images/no_content.png">
            <div class="text">暂无积分记录</div>
        </div>
    </div>
<?php } ?>
<div class="return">
    <a href="javascript:;" class="glyphicon glyphicon-arrow-left fffColor sz14r" onclick="javascript :history.back(-1);"></a>
</div>
</body>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script>
</script>
</html>