<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
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
	  .gg-icon{ vertical-align: text-top;}
        .vip-nav .vip-nav-item{line-height:.88rem;}
        .weui-grids{background:white;}
        .weui-grid{width:50%; padding:12px 4%;}
        .weui-grid__icon{ height: 95px; width: auto; text-align: center;}
        .weui-grid__icon img{height:100%; width: auto; display: inline-block;}
        .weui-grid__label{text-align: left;}
    </style>
</head>
<body>
<div class="vip-nav">
    <div class="vip-nav-item" onclick="window.location.href='/?mod=weixin&v_mod=point&_index=_exchange'">
        <div class="cl999 sz16r"><i class="gg-icon ggicon_info"></i>
            <b class="sz16r clO mr5"><?php echo $user['user_point']; ?></b>积分
        </div>
    </div>
    <div class="vip-nav-item" onclick="window.location.href='/?mod=weixin&v_mod=point&_index=_order'">
        <div class="blackColor sz16r"><i class="gg-icon ggicon_gift"></i>礼品订单</div>
    </div>
</div>
<?php $data=$obj->GiftOrderList();
if (!empty($data['data'])){
?>
<div class="gg-shopping-container">
    <?php
    foreach($data['data'] as $item){?>
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">使用积分</label>
                <em class="weui-form-preview__value"><?php echo $item['total_point']; ?></em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">礼品数量</label>
                <span class="weui-form-preview__value">
                    <?php echo $item['total_qty']; ?>
                </span>
            </div>

            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">兑换时间</label>
                <span class="weui-form-preview__value">
                    <?php echo $item['addtime']; ?>
                </span>
            </div>

            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">留言</label>
                <span class="weui-form-preview__value">
                     <?php echo $item['liuyan']; ?>
                </span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">货运地址</label>
                <span class="weui-form-preview__value">
                     <?php echo $item['username']; ?> <?php echo $item['phone']; ?>
                     <?php echo $item['address']; ?>
                </span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">货运状态</label>
                <span class="weui-form-preview__value">
                     <?php echo $item['ship_status']==3?"已发货".$item['wuliu_com'].',货运号:'.$item['wuliu_no']:"未发货"; ?>
                </span>
            </div>
        </div>
        <div class="weui-form-preview__ft">
            <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="/?mod=weixin&v_mod=point&_index=_order_detail&orderid=<?php echo $item['orderid']; ?>">查看礼品详情</a>
        </div>
    </div>
    <?php }} ?>
</div>
<div class="return">
    <a href="/?mod=weixin&v_mod=point&_index=_shop" class="glyphicon glyphicon-arrow-left fffColor sz14r"></a>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/jquery.qrcode.js"></script>
<script type="text/javascript" src="/template/source/js/qrcode.js"></script>
<script type="text/javascript" src="/template/source/layer/layer.js"></script>
<script type="text/javascript">
    $(function()
    {
        $(".gg-shopping-item").click(function()
        {
            if (!$(this).hasClass('cannothx'))
            {
                $('#qrcode_img').empty();
                var code=$(this).attr('id');
                $('#qrcode_img').qrcode({
                    // render	: "table",
                    width:200,
                    height:200,
                    text	: code
                });
                $("#iosDialog2").show();
            }else
            {
                layer.open({
                    content: '该礼品已经核销过了',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
        })

        $("#closediv").click(function(){
            $("#iosDialog2").hide();
        })
    })
</script>
</body>
</html>