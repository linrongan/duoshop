<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GiftOrderDetail();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>礼品兑换提示</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/daili/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
</head>
<body>
<div class="weui-msg">
    <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
    <div class="weui-msg__text-area">
        <h2 class="weui-msg__title">订单成功</h2>
        <p class="weui-msg__desc">
            本次唯一凭证号：<?php echo $data['data']['orderid']; ?>
        </p>
    </div>
</div>
<div class="page preview js_show">
    <div class="page__bd">
        <div class="weui-form-preview">

            <div class="weui-form-preview__hd">
                <label class="weui-form-preview__label sz14r">消费积分数</label>
                <em class="weui-form-preview__value sz14r"> <?php echo $data['data']['total_point']; ?> 积分</em>
            </div>

            <div class="weui-form-preview__bd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label sz14r">兑换总数量</label>
                    <span class="weui-form-preview__value sz14r">
                        <?php echo $data['data']['total_qty']; ?>
                    </span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label sz14r">兑换时间</label>
                    <span class="weui-form-preview__value sz14r"><?php echo $data['data']['addtime']; ?></span>
                </div>
            </div>




            <div class="weui-form-preview__ft">
                <a class="weui-form-preview__btn weui-form-preview__btn_default sz16r" href="/?mod=weixin&v_mod=point&_index=_shop">返回积分商城</a>
                <a class="weui-form-preview__btn weui-form-preview__btn_primary sz16r" href="/?mod=weixin&v_mod=point&_index=_order">查看兑换订单</a>
            </div>




        </div>
    </div>
</div>
</body>
</html>