<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$checkout = $obj->GetCheckOutCartData();
if(empty($checkout['cart']['cart']) || empty($checkout['coupon']['valid_coupon']))
{
    redirect('/?mod=weixin&v_mod=checkout');
}
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
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?666666">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .discountTab{top:0}
        .return{position:fixed; left: 4%; bottom:.4rem;}
        .return>a{width:.6rem; height:.6rem; background:rgba(0,0,0,0.7); display: block; text-align: center; line-height: .6rem;}
		.weui-not-link::before,.weui-not-link::after,.weui-not-link .weui-cell::before,.weui-not-link .weui-cell::after{border:none;}
		.discountwarp .discountwarp-item{width:100%; box-sizing:border-box; padding-left:2.6rem; padding-right:.2rem; height:1.8rem;}
		.discountwarp-item .disprice{height:100%; background-size:100% 100%;}
		.discountwarp-item .distext{height:1.4rem;}
		.weui-cells_checkbox .weui-check:checked+.weui-icon-checked:before{color:white;}
		.weui-cells_checkbox .weui-icon-checked:before{font-size:16px;}
		.discountwarp-item .distext>h1{font-size: .26rem;}
    </style>
</head>
<body>
<div class="discountTab">
    <a href="/?mod=weixin&v_mod=checkout&_index=_coupon_select" class="sz14r cl999 <?php echo isset($_REQUEST['status'])?"":"on_active"; ?>">可使用优惠券(<?php echo count($checkout['coupon']['valid_coupon']); ?>)</a>
    <a href="/?mod=weixin&v_mod=checkout&_index=_coupon_select&status=1" class="sz14r cl999 <?php echo isset($_REQUEST['status'])?"on_active":""; ?>">不可用优惠券</a>
</div>
<div style="height:1.2rem"></div>
<?php
if (isset($_REQUEST['status']))
{
    if (!empty($checkout['coupon']['invalid']))
    {
    foreach($checkout['coupon']['invalid'] as $item)
    {
    ?>
    <div class="discountcontainer">
        <div class="discountwarp">
            <div class="discountwarp-item enddiscount">
                <div class="fl disprice sz16r">
                    ￥<b><?php echo $item['coupon_money']; ?></b>
                </div>
                <div class="fl distext">
                    <h1>
                        <?php echo $item['coupon_name']; ?></h1>
                    <p>
                        最低消费<?php echo $item['min_money']; ?>元
                    </p>
                    <p>
                        <?php echo $item['start_time']; ?>至
                        <?php echo $item['expire_time']; ?>                有效
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php }
    ?>
<?php
}else
{?>
    <div class="search-empty-panel">
        <div class="content">
            <img src="/template/source/images/no_content.png">
            <div class="text">暂无优惠券</div>
        </div>
    </div>
<?php }?>
<div class="return">
    <a href="/?mod=weixin&v_mod=checkout" class="glyphicon glyphicon-arrow-left fffColor sz14r" onclick="javascript :history.back(-1);"></a>
</div>
<?php
}
else
{
    if (!empty($checkout['coupon']['valid_coupon'])){?>
    <form id="SubmitForm" method="post" action="<?php echo _URL_; ?>&_action=ActionSelectCoupon">
        <div class="discountcontainer">
            <div class="discountwarp">
                <div class="weui-cells weui-not-link weui-cells_checkbox" style="margin-top:0; background:none; overflow:visible;">
                    <?php
                    $i=0;
                    foreach($checkout['coupon']['valid_coupon'] as $k=>$item)
                    {
                        $i++;
                        ?>
                        <label class="weui-cell weui-check__label" for="coupon_<?php echo $k; ?>_<?php echo $i; ?>" style=" padding:0;">
                            <div class="weui-cell__hd" style="position:absolute; left:2%; z-index:999999;">
                                <input <?php if (isset($checkout['use_coupon']['data'][$k]['coupon_id']) && $checkout['use_coupon']['data'][$k]['coupon_id']==$item['id']){echo 'checked="checked"';} ?> type="radio" value="<?php echo $item['id']; ?>" class="weui-check" name="coupon_<?php echo $item['store_id']; ?>" id="coupon_<?php echo $k; ?>_<?php echo $i; ?>">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <div class="discountwarp-item" id="C2017051820621">
                                    <div class="fl disprice sz16r">
                                        ￥<b><?php echo $item['coupon_money']; ?></b>
                                        <p style="">满<?php echo $item['min_money']; ?>可用</p>
                                    </div>
                                    <div class="fl distext">
                                        <h1 class="omit"><?php echo $item['coupon_name']; ?></h1>
                                        <p class="mt5" style="font-size:12px;">
                                            <?php
                                            echo $item['store_id']?"仅可购买".$item['store_name']."店内商品":"平台通用";
                                            ?>
                                        </p>
                                        <p class="sz12r mt5">
                                            <?php echo $item['start_time']; ?>至
                                            <?php echo $item['expire_time']; ?>
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </label>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </form>
    <br/>
    <div class="page__bd page__bd_spacing">
        <a id="SubmitBtn" href="javascript:void(0)" class="weui-btn weui-btn_warn">确认提交</a>
    </div>
    <br/>
<?php
}else
{?>
    <div class="search-empty-panel">
        <div class="content">
            <img src="/template/source/images/no_content.png">
            <div class="text">暂无优惠券</div>
        </div>
    </div>
<?php }
}?>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
    $(function(){
        $("#SubmitBtn").click(function()
        {
            $("#SubmitForm").submit();
        })
        /*
         $("input:radio").click(function()
         {
         var id=$(this).attr('id');
         if ($("#"+id).is(':checked'))
         {
         alert('111');
         $("#"+id).attr("checked",false);
         }
         })*/
    })
</script>
</body>
</html>