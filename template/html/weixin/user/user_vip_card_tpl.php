<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$vip=$obj->GetVipCard();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>会员卡</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?6666">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style>
        .weui-cells__title{padding:0 3%; color:#333333;}
        .no-weui-link::before,.no-weui-link::after,.no-weui-link>.weui-cell::before,.no-weui-link>.weui-cell::after{border:none !important;}
        .cart-list{padding:0 3%;}
        .cart-list .weui-cells,.cart-list .weui-cell{}
        .cart-list .weui-cells{background:none;}
        .cart-list .weui-cell{margin-bottom:.2rem; min-height:1.4rem; padding:.2rem 10%;}
        /*.cart-list .weui-cell:last-child{margin-bottom:0;}*/
        .cart-text,.cart-name{  text-shadow:1px 1px 2px #666;}
        .weui-cell__ewm{position:absolute; right:3%; top:.3rem;}
        .cart-number>span{display:block;  height:.7rem; line-height:.7rem; text-align:left; border-radius:5px; background:#04be02; color:white; padding:0 10px;}
        .weui-cell__money{width:90%; height:.6rem; line-height:.6rem; position:absolute; bottom:.2rem; left:10%; font-size:.36rem;}
        .weui-cell__money>span{}
        .delete_card{position: absolute;left: 0px;top:0;display: block;font-size: 1.2em;color: red;}
    </style>
</head>
<body style="background:#f1f1f5;">
<div class="weui-cells__title sz16r">
    会员卡
    <div class="clearfix"></div>
</div>
<div class="cart-list">
    <?php
    if (!empty($vip))
    {
        foreach($vip as $item)
        {?>
            <div class="weui-cells no-weui-link" style="border-radius:10px 10px 0 0" >
                <a href="javascript:;" class="weui-cell" style="background:#d64238; min-height:2.2rem; background:url(/template/source/images/cart-bg.jpg) no-repeat;margin-bottom: 0px; background-size:100% 100%; border-radius:10px 10px 0 0">
                    <div class="weui-cell__hd" style="position:absolute; top:.3rem; left:7%;">
                        <img src="<?php echo $item['headimgurl']; ?>" style="width:1rem; height:1rem; display:block;; border-radius:50%; margin-right:.2rem;"></div>
                    <div class="weui-cell__bd" style="left:1.8rem; position:absolute; top:.3rem; width:50%;">
                        <h1 class="cart-name sz14r fffColor"><?php echo WEBNAME; ?>会员卡</h1>
                        <p class="cart-text sz14r fffColor">姓名：<?php echo $item['username']; ?></p>
                        <p class="cart-text sz14r fffColor">赠送金额：<?php echo $item['gift_balance']; ?>元 </p>
                    </div>
                    <div class="weui-cell__ewm ShowQrcode" id="1">
                        <span class="glyphicon glyphicon-qrcode fffColor"></span>
                    </div>
                    <div class="weui-cell__money">
                            <span class="cart-text" style="color:#ffcb57">
                                <?php echo $item['card_no']; ?>
                            </span>
                    </div>
                </a>
                <div class="weui-form-preview__ft" style="background:white; border-radius:0 0 10px 10px;">
                    <a class="weui-form-preview__btn weui-form-preview__btn_default" href="">转赠金额</a>
                    <button onclick="window.location.href='/?mod=weixin&v_mod=business&_index=_shop'" type="submit" class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:">
                        商家专享
                    </button>
                </div>
            </div>


            <div class="page__bd">
                <div class="weui-loadmore weui-loadmore_line">
                    <span class="weui-loadmore__tips">会员卡提示</span>
                </div>
                <div class="weui-loadmore_line">
                    <span class="weui-loadmore__tips">
                        <br/>
                        会员卡每人限领一张
                        <br/>
                        会员卡分为普卡、银卡（赠送980元）、金卡（赠送2980元）、钻石卡（赠送9980元）<br/>
                        赠送金额：每次购物达到100元以上可使用赠送的金额抵扣10%的购物金额，赠送金额可以转赠给其他拥有会员卡的用户使用。
                        <br/>
                    </span>
                </div>
            </div>
        <?php
        }
    }
    else
    {?>
        <div class="weui-cells no-weui-link">
            <a href="/?mod=weixin&v_mod=user&_index=_vip_apply" class="weui-cell" style="border-radius:10px;border:1px solid #CCC; background:white;">
                <div class="weui-cell__bd">
                    <p class=" sz16r mtr02 txtc cl999">
                        <i class="glyphicon glyphicon-plus cl999"></i>
                        添加会员卡
                    </p>
                </div>
            </a>
        </div>
    <?php
    } ?>
</div>

<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/jquery.qrcode.js"></script>
<script type="text/javascript" src="/template/source/js/qrcode.js"></script>
<script type="text/javascript" src="/template/source/layer/layer.js"></script>
<script type="text/javascript" src="/template/source/js/comm.js"></script>
</body>
</html>