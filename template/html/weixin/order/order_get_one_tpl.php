<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetRecurOrder();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>订单结算</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link rel="stylesheet" href="/template/source/weixin/css/cart.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .weui-cell__bd>p{line-height: .4rem;}
        .weui-cells__title{padding-left:3%;}
        .numberBox>input[type='number']{ vertical-align: baseline;}
        .miao-title{width:40px; height:30px; border-radius:50%; text-align:center; line-height:15px; background:#06F; color:white; position:absolute; top:0 ;right:-5px; padding:5px 0; -webkit-transform:scale(0.7);transform:scale(0.7) ; font-size:12px; }
        .layui-m-layer-msg .layui-m-layercont{color:white !important;}
        .shop-group-item .shop-title{background:#FFA6A6; padding-right:3%;}
        .shop-title-name{color:white;}
        .shp-cart-list li{border-bottom:1px solid #ededed;}
        .shp-cart-list li:first-child{border-bottom:none;}
        .shop-cart-display.shp-cart-item-core{margin:0; padding:5px 0;}
        .shop-cart-display .cart-product-cell-1{top:5px;}
        .shop-cart-display .cart-product-name{position:relative;}
        .shop-cart-display.shp-cart-item-core{margin:0; padding:5px 0;} 
        .discount_label{height:.36rem; line-height:.36rem; padding:0 5px; background:#f33030; color:white; display:inline-block; vertical-align:bottom;     margin-bottom: 1px; }
		.reminder{padding:5px 3%; background:#FC9; color:white;}
		.cart-checkbox{-webkit-appearance: none; outline:none;  }
		.cart-checkbox:checked{ width:20px; height:20px; border-radius:50%; background: url(/template/source/weixin/images/shopping.cart.spirits.icns2.png?t=0327) -24px 0 no-repeat ; background-size: 50px 200px; outline:none;}
		.shop-title .item{padding-left:3%;}
    </style>
</head>
<body>
<!--<?php echo !$allow_buy?'disabled':''; ?>-->
<div id="content" style="padding:0 0 .9rem 0">
    <form action="/?mod=weixin&v_mod=order&_index=_get_one&id=<?php echo $_GET['id'] ?>&_action=ActionCopyOrderToCart" method="post" id="form">
        <div class="weui-cells__title cl999">确认产品</div>
        <div class="shop-group">
            <div class="shop-group-item">
                <div class="shop-title customize-shtit">
                    <div class="item">
                        <div class="shop-title-content">
                            <span class="shop-title-icon"><img src="<?php echo $data['data']['store_logo']; ?>"></span>
                            <span class="shop-title-name"><?php echo $data['data']['store_name']; ?></span>
                        </div>
                    </div>
                </div>
                <ul class="shp-cart-list">
                    <?php
                    if($data['product'])
                    {
                        $allow_buy_count = 0;
                        foreach($data['product'] as $item)
                        {
                            $allow_buy = true;
                            ?>
                            <li>
                                <?php
                                if(null==$item['pro_id'])
                                {
                                    ?>
                                    <div class="reminder">
                                        系统提示：产品已下架
                                    </div>
                                    <?php
                                    $allow_buy = false;
                                }elseif($item['product_attr_id'])
                                {
                                    if($item['attr_count']!=substr_count($item['product_attr_id'],',')+1)
                                    {
                                        ?>
                                        <div class="reminder">
                                            系统提示：部分属性已下架
                                        </div>
                                        <?php
                                        $allow_buy = false;
                                    }
                                }
                                ?>
                                <div class="items">
                                    <div class="check-wrapper">
                                        <input type="checkbox" <?php if($allow_buy){echo 'checked';}else{echo 'disabled';} ?> name="product_id[]" value="<?php echo $item['pro_id']; ?>"   class="cart-checkbox"/>
                                    </div>
                                    <input type="hidden" name="attr_id[<?php echo $item['pro_id']; ?>]" value="<?php echo $item['product_attr_id']; ?>">
                                    <div class="shp-cart-item-core shop-cart-display">
                                        <a class="cart-product-cell-1">
                                            <img width="" class="cart-photo-thumb" alt="" src="<?php echo $item['product_img']; ?>" />
                                            <?php
                                            if($item['ms_id'])
                                            {
                                                ?>
                                                <span class="miao-title">
                                                    秒杀
                                                        <del><?php echo $item['seckill_price']; ?></del>
                                                        </span>
                                                <?php
                                            }
                                            ?>
                                        </a>
                                        <div class="cart-product-cell-2">
                                            <div class="cart-product-name">
                                                <a>
                                                    <?php
                                                    if(null==$item['pro_id'])
                                                    {
                                                        ?>
                                                        <del><span class="non-fresh-txt"><?php echo $item['product_name']; ?></span></del>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="non-fresh-txt"><?php echo $item['product_name']; ?></span>
                                                        <?php
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="cart-product-prop eles-flex">
                                                <i class="prop0" style="font-style:normal">
                                                    <?php echo $item['product_attr_name']; ?>
                                                </i>
                                            </div>
                                            <div class="icon-list">
                                                <!-- 比加入时降价信息-->
                                            </div>
                                            <div class="cart-product-cell-3">
                                                    <span class="shp-cart-item-price">
                                                        ¥ <strong>
                                                            <?php echo $item['product_price']; ?>
                                                        </strong>
                                                    </span>
                                                <div class="quantity-wrapper customize-qua">
                                                    <a class="quantity-decrease"></a>
                                                    <input type="number" readonly size="4" max-count="<?php echo $item['max_buy']; ?>" min-count="<?php echo $item['min_buy']; ?>"
                                                           value="<?php if($item['max_buy']>0 && $item['product_count']>$item['max_buy']){echo $item['max_buy'];}
                                                           elseif($item['min_buy']>0 && $item['product_count']<$item['min_buy']){echo $item['min_buy'];}else{echo $item['product_count'];} ?>"
                                                           name="quantity[<?php echo $item['pro_id']; ?>]" class="quantity">
                                                    <a class="quantity-increase"></a>
                                                </div>
                                            </div>
                                            <!-- price move to here end -->
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                            if($allow_buy)
                            {
                                ++$allow_buy_count;
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </form>
    <div style="padding:1rem 10%">
        <a href="javascript:;" onclick="copy_order(this,<?php echo $allow_buy_count; ?>)" class="weui-btn weui-btn_primary rf16" style="background:#dd2726;">下一步</a>
    </div>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
</body>
<script>
    $(function ()
    {
        $(".quantity-decrease").click(function ()
        {
            var max_count = $(this).next().attr('max-count');
            var min_count = $(this).next().attr('min-count');
            var this_val = $(this).next().val();
            if(max_count>0 && this_val>max_count)
            {
                $(this).next().val(max_count);
            }else if(min_count>0 && this_val<min_count)
            {
                $(this).next().val(min_count);
            }else{
                this_val++;
                $(this).next().val(this_val);
            }
        });

        $(".quantity-increase").click(function ()
        {
            var max_count = $(this).prev().attr('max-count');
            var min_count = $(this).prev().attr('min-count');
            var this_val = $(this).prev().val();
            if(max_count>0 && this_val>max_count)
            {
                $(this).prev().val(max_count);
            }else if(min_count>0 && this_val<min_count)
            {
                $(this).prev().val(min_count);
            }else{
                this_val++;
                $(this).prev().val(this_val);
            }
        });
    });


    function layer_msg(msg)
    {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }


    function copy_order(obj,count)
    {
        if(count<=0)
        {
            layer_msg('无法提交');
            return false;
        }
        if($(obj).hasClass('disabled'))
        {
            return;
        }
        $(obj).addClass('disabled');
        $("#form").submit();
    }
</script>
</html>