<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetExpireCouponList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>我的优惠券</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .discountTab{top:.9rem}
        .return{position:fixed; left: 4%; bottom:.4rem;}
        .return>a{width:.6rem; height:.6rem; background:rgba(0,0,0,0.7); display: block; text-align: center; line-height: .6rem;}

    </style>
</head>
<body>
<div class="n-tabs">
	<a href="javascript:;" class="sz14r n-active">优惠券</a>
	<a href="/?mod=weixin&v_mod=coupon&_index=_discount" class="sz14r">折扣券</a>
</div>
<div class="discountTab">
    <a href="/?mod=weixin&v_mod=coupon&_index=_list" class="sz14r cl999">未使用</a>
    <a href="/?mod=weixin&v_mod=coupon&_index=_used" class="sz14r cl999">已使用</a>
    <a href="javascript:;" class="on_active sz14r cl999">已过期</a>
</div>

<div style="height:2rem"></div>
<div class="discountcontainer">
    <div class="discountwarp">
        <?php
        if (!empty($data['data']))
        {
        foreach($data['data'] as $item)
        {?>
            <div class="discountwarp-item enddiscount">
                <div class="fl disprice sz16r">
                    ￥<b><?php echo $item['coupon_money']; ?></b>
                </div>
                <div class="fl distext">
                    <h1>
                        <?php echo $item['coupon_name']; ?>
                    </h1>
                    <p>
                        最低消费<?php echo $item['min_money']; ?>元
                    </p>
                    <p>
                        <?php
                        $start=date("m月d日",strtotime($item['start_time']));
                        $expire=date("m月d日",strtotime($item['expire_time']));
                        echo $start;
                        echo $start==$expire?'当天':' - '.$expire;
                        ?>
                        有效
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php }
else
{?>
    <div class="search-empty-panel">
        <div class="content">
            <img src="/template/source/images/no_content.png">
            <div class="text">暂无优惠券</div>
        </div>
    </div>
<?php
} ?>


<div class="return">
    <a href="/?mod=weixin&v_mod=user" class="glyphicon glyphicon-arrow-left fffColor sz14r" ></a>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script>
    $(function(){

        $(".discountTab>a").click(function(){

            $(this).addClass("on_active").siblings().removeClass("on_active");
            var _index = $(this).index();
            $(".discountcontainer .discountwarp").eq(_index).show().siblings().hide();
        })
    })
</script>
</body>
</html>