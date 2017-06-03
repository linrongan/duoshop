<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$checkout = $obj->GetCheckOutCartData();
$data = $checkout['cart']['cart'];
$goods_postage = $checkout['cart']['goods_postage'];
if(empty($data))
{
    redirect('?mod=weixin&v_mod=order&type=1');
}
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
        .kan-title{width:40px; height:30px; border-radius:50%; text-align:center; line-height:15px; background:#f23030; color:white; position:absolute; top:0 ;right:-5px; padding:5px 0; -webkit-transform:scale(0.7);transform:scale(0.7) ; font-size:12px; }
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
    </style>
</head>
<body>
<div id="content" style="padding:0 0 .9rem 0">
<form id="form" action="/?mod=weixin&v_mod=checkout&_action=ActionAddOrder&time=<?php echo time(); ?>" method="post">
    <div class="weui-cells__title cl999">填写订单</div>
    <div class="shop-group">
        <?php
        $pro_fee = 0;
        $total_money = 0;
        $all_money = 0;
        $select = 0;
        $all_count = 0;
        $pro_count = 0;
        $order_postage_total = 0;
        if($data)
        {
            $sec_pro_items = array();
            foreach($data as $key=>$item)
            {
                $total_money += $goods_postage[$key]['shop_total'];
                $pro_total = 0; //产品邮费
                $shop_money = 0;
                $pro_z_total = 0;   //不包邮的邮费
                ?>
                <div class="shop-group-item">
                    <div class="shop-title customize-shtit">
                        <div class="item">
                            <div class="check-wrapper" onclick="ChangeShopSelStatus(this,<?php echo $key; ?>,<?php echo $item['all_selected']; ?>)">
                                <span class="cart-checkbox  <?php echo $item['all_selected']?'checked':''; ?>"></span>
                            </div>
                            <div class="shop-title-content">
                                <span class="shop-title-icon"><img src="<?php echo $item['store_logo']; ?>"></span>
                                <span class="shop-title-name"><?php echo $item['store_name']; ?></span>
                                <?php
                                if($goods_postage[$key]['postage_total']>0)
                                {
                                    echo '<span class="shop-title-name" style="float: right;">运费￥'
                                        .$goods_postage[$key]['postage_total'].'</span>';
                                    $order_postage_total += $goods_postage[$key]['postage_total'];
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <ul class="shp-cart-list">
                        <?php
                        foreach($item['cart_list'] as $val)
                        {
                            $shop_total = 0;
                            $s = 0;
                            $all_count ++;
                            if(array_key_exists($val['product_id'],$sec_pro_items))
                            {
                                $val['product_price'] = $sec_pro_items[$val['product_id']]['seckill_price'];
                            }
                            $price = $val['product_count']*$val['product_price'];
                            $all_money += $price;
                            if($val['select_status'])
                            {
                                $s++;
                                $shop_total += $price;
                                $pro_count += $val['product_count'];
                            }
                            ?>
                            <li>
                                <div class="items">
                                    <div class="check-wrapper" onclick="ChangeProSelStatus(this,<?php echo $val['id']; ?>)">
                                        <span class="cart-checkbox <?php echo $val['select_status']?'checked':''; ?>"></span>
                                    </div>
                                    <div class="shp-cart-item-core shop-cart-display">
                                        <a class="cart-product-cell-1">
                                            <img width="" class="cart-photo-thumb" alt="" src="<?php echo $val['product_img']; ?>" />


                                            <?php
                                            if (!empty($val['bargain_create_id']))
                                            {?>
                                                <span class="kan-title">
                                                            砍价
                                                             <del><?php echo $val['old_price']; ?></del>
                                                        </span>
                                            <?php

                                            }
                                            elseif(!empty($val['seckill_price']))
                                            {
                                                ?>
                                                <span class="miao-title">
                                                            秒杀
                                                             <del><?php echo $val['old_price']; ?></del>
                                                        </span>
                                            <?php
                                            }
                                            ?>
                                        </a>
                                        <div class="cart-product-cell-2">
                                            <div class="cart-product-name">
                                                <a>
                                                    <span class="non-fresh-txt" ><?php echo $val['product_name']; ?></span>
                                                </a>
                                            </div>
                                            <div class="cart-product-prop eles-flex">
                                                <i class="prop0" style="font-style:normal">
                                                    <?php echo $val['attr_name']; ?>
                                                </i>
                                            </div>
                                            <div class="icon-list">
                                                <!-- 比加入时降价信息-->
                                            </div>
                                            <div class="cart-product-cell-3">
                                                    <span class="shp-cart-item-price">
                                                         <?php
                                                         if(!empty($val['seckill_price']))
                                                         {
                                                             ?>
                                                             ¥ <strong>
                                                             <?php echo $val['seckill_price']; ?>
                                                         </strong>
                                                         <?php
                                                         }else{
                                                             ?>
                                                             ¥ <strong>
                                                                 <?php echo $val['product_price']; ?>
                                                             </strong>
                                                         <?php
                                                         }
                                                         ?>
                                                    </span>
                                                    <div class="quantity-wrapper customize-qua" cid="<?php echo $val['id']; ?>">
                                                    <a class="quantity-decrease <?php echo $val['product_count']==1?'disabled':''; ?>"></a>
                                                    <input type="number" size="4" value="<?php echo $val['product_count']; ?>" name="num" class="quantity">
                                                    <a class="quantity-increase"></a>
                                                </div>
                                            </div>
                                            <!-- price move to here end -->
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                            $select+= $s;
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="weui-cells weui-cells_checkbox">
        <label class="weui-cell weui-check__label" for="s11">
            <div class="weui-cell__hd">
                <input type="radio" class="weui-check" name="pay_method" value="wechat" id="s11" <?php  echo !isset($_GET['pay']) || $_GET['pay']!='user_money'?'checked':'';?>>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p class="sz14r">微信支付</p>
            </div>
            <div class="weui-cell__ft">
                <i class="gg-icon gg-icon_weixin mr10"></i>
            </div>
        </label>
        <?php
            if($checkout['user']['user_money']>=$total_money)
            {
                ?>
                <label class="weui-cell weui-check__label" for="s12">
                    <div class="weui-cell__hd">
                        <input type="radio" name="pay_method" value="user_money" <?php echo isset($_GET['pay']) && $_GET['pay'] == 'user_money'?'checked':''; ?> class="weui-check" id="s12" >
                        <i class="weui-icon-checked"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p class="sz14r">余额支付</p>
                    </div>
                    <div class="weui-cell__ft sz12r"><?php echo $checkout['user']['user_money']; ?></div>
                </label>
                <?php
            }
        ?>
    </div>

    
    <div class="weui-cells weui-cells_checkbox">
        <label class="weui-cell weui-check__label weui-cell_access" for="s13">
            <div class="weui-cell__hd">
                <input value="coupon" type="radio" class="weui-check" name="discount_method" id="s13" checked="checked">
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd sz14r">
                 <p>优惠券 <span class="discount_label sz12r"><?php echo count($checkout['coupon']['valid_coupon']); ?>张可选</span></p>
            </div>
            <div class="weui-cell__ft sz12r">
                <?php
                if ($checkout['coupon']['use_coupon']['use_coupon_count']>0)
                {?>
                    已使用<?php echo $checkout['coupon']['use_coupon']['use_coupon_count']; ?> 张，优惠<?php echo $checkout['coupon']['use_coupon']['use_coupon_money']; ?>元
                <?php
                }else{?>
                    未使用
                <?php } ?>
            </div>
        </label>
         <?php if ($checkout['user']['gift_balance']>0)
        {
            $discount_per=$obj->GetDiscountCouponPer();
            ?>
        <label class="weui-cell weui-check__label" for="s14">
            <div class="weui-cell__hd">
                <input type="radio" value="discount"  class="weui-check" name="discount_method" id="s14">
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd sz14r">
               <p> 折扣券<span class="discount_label sz12r"><?php echo ((1-$discount_per)*10); ?>折</span></p>
            </div>
            <div class="weui-cell__ft sz12r">
            	  剩余￥<?php echo $checkout['user']['gift_balance']; ?>
                    可抵扣
                    <?php
                    if ($total_money>=100)
                    {
                        $card_money=intval($total_money*$discount_per);
                        $gift_balance=$checkout['user']['gift_balance']>=$card_money?$card_money:$checkout['user']['gift_balance'];
                        ?>
                        <input type="hidden" name="gift_balance" id="gift_balance" value="<?php echo $gift_balance;?>">
                        ￥<?php echo $gift_balance;?>
                    <?php
                    }else
                    {?>
                        <input type="hidden" name="gift_balance" id="gift_balance" value="0">
                        <?php
                        echo '￥0';
                    }
                    ?>
            </div>
        </label>
        <?php
    } ?>
    </div>
    <?php if ($checkout['user']['vip_lv']>0)
    {?>
	<div class="weui-cells__tips">备注：折扣券和优惠券只能选择一种，不允许叠加使用</div>
	  <?php
    } ?>

    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <i class="gg-icon gg-icon_weixin mr10"></i>
            </div>
            <div class="weui-cell__bd">
                <p class="sz14r">运费</p>
            </div>
            <div class="weui-cell__ft sz12r">
                <strong>￥ <?php echo $order_postage_total; ?></strong>
            </div>
        </div>
    </div>

     <div class="weui-cells weui-cells_radio">
     <?php
         if($checkout['address']) {
             for ($i=0; $i<count($checkout['address']); $i++)
             {
                 ?>
                 <label class="weui-cell weui-check__label" for="x-<?php echo $i; ?>">
                     <div class="weui-cell__bd">
                         <p class="sz14r"><?php echo $checkout['address'][$i]['shop_name'] . '&nbsp;' . $checkout['address'][$i]['shop_phone']; ?></p>
                         <p class="sz12r" style="color: #888888;"><?php echo $checkout['address'][$i]['address_location'] . $checkout['address'][$i]['address_details']; ?></p>
                     </div>
                     <?php
                     if ($checkout['address'][$i]['default_select'])
                     {
                         ?>
                         <div class="weui-cell__ft">
                             <span class="moren sz12r">默认</span>
                         </div>
                         <?php
                     }
                     ?>
                     <div class="weui-cell__ft">
                         <input type="radio" name="address_id" <?php
                         if(isset($_GET['area']) && $_GET['area']==$checkout['address'][$i]['id']){echo 'checked';}elseif($checkout['address'][$i]['default_select']){echo 'checked';} ?> value="<?php echo $checkout['address'][$i]['id']; ?>" class="weui-check"  id="x-<?php echo $i; ?>">
                         <span class="weui-icon-checked"></span>
                     </div>
                 </label>
                 <?php
             }
         }
     ?>
         <?php
            if(count($checkout['address'])<10)
            {
                ?>
                <a class="weui-cell weui-cell_access"
                   href="/?mod=weixin&v_mod=address&_index=_new&callback=&callback=<?php echo urlencode('/?mod=weixin&v_mod=checkout'); ?>">
                    <div class="weui-cell__hd">
                        <img src="/template/source/images/icon-address.png" style="width:.5rem;margin-right:10px;display:block">
                    </div>
                    <div class="weui-cell__bd">
                        <p class="sz14r">添加新地址</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <?php
            }
         ?>
     </div>
    <div class="weui-cells" style="margin-top:.2rem;">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea class="weui-textarea sz14r" name="liuyan" id="liuyan" placeholder="有什么想跟我说的么~~" rows="3"></textarea>
            </div>
        </div>
    </div>
    <div class="withdraw-ft">
        <div class="support_bar">
            <div class="support_bar_total">
                <p class="sz14r">合计：
                    <span class="redColor mr5" style="font-weight: bold">
                        <input type="hidden" id="old_total" name="old_total" value="<?php echo ($total_money-$checkout['coupon']['use_coupon']['use_coupon_money'])+$order_postage_total; ?>">
                        <label id="old_total_text">
                            <?php echo ($total_money-$checkout['coupon']['use_coupon']['use_coupon_money'])+$order_postage_total; ?>
                        </label>
                    </span>元</p>
            </div>
            <div class="support_bar_btn sz16r">
            	<!--submit-->
                <a style="font-weight: bold" id="submit" href="javascript:;">提交订单</a>
            </div>
        </div>
    </div>
</form>
</div>

<div class="js_dialog" id="iosDialog1" style="opacity: 1; display: none;">
    <div class="weui-mask" onClick="hidePrice()" ></div>
    <div class="weui-dialog">
        <div class="weui-dialog__hd" style="padding:.8em 1.6em; border-bottom:1px solid #0bb20c;"><strong class="weui-dialog__title">请输入支付密码</strong></div>
        <div class="weui-dialog__bd" style=" padding:1.6em .8em; height:40px;">
        	<div style="width:100%; height:100%; display:block; border:1px solid #ededed; box-sizing:border-box;">
        		<input type="password" class="weui-input" id="payment" maxlength="6" pattern="[0-9]*" style="height:100%; line-height:40px; padding:0 5%; width:90%; font-size:16px; line-height:normal;">
            </div>
        </div>
        <div class="weui-dialog__ft">
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default" onClick="hidePrice()">取消</a>
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" onclick="check_pass()">确认</a>
        </div>
    </div>
</div>



<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script>
	var $iosDialog1 = $('#iosDialog1');
	function hidePrice(){
		$iosDialog1.fadeOut(200);
		$('#payment').val('');
	}
	function showPrice(){
		$iosDialog1.fadeIn(200);
		$('#payment').focus();
	}
    $(function(){

        $(".numberBox").on('click','.plus',function(event){
            var value = $(this).siblings("input[type='number']").val();
            value++;
            $(this).siblings("input[type='number']").val(parseInt(value));
            $(this).siblings(".minus").css("color","#5c5c5c");
            event.stopPropagation();
        });
        $(".numberBox").on('click','.minus',function(event){
            var value = $(this).siblings("input[type='number']").val();
            if(value>1){
                value--;
                $(this).siblings("input[type='number']").val(parseInt(value));
                if(value == 1){
                    $(this).css("color","#CCC");
                }else{
                    $(this).css("color","#5c5c5c");
                }
            }
            event.stopPropagation();
        });

        $(".numberBox").on('click',"input[type='number']",function(event){
            event.stopPropagation();
        });

        $(".numberBox").on('blur','input[type="number"]',function(){
            if($(this).val() < 1){
                $(this).val(1);
            }
        });

        $("#open_coupon").click(function ()
        {
            if($(this).attr('valid_coupon')>0)
            {
                var url = '?mod=weixin&v_mod=checkout&_index=_coupon_select';
                var select_pay_method = $("input[name='pay_method']:checked").val();
                var select_address_id = $("input[name='address_id']:checked").val();
                if(select_pay_method!=undefined && select_pay_method.length>0)
                {
                    url += '&pay='+select_pay_method;
                }
                if(select_address_id!=undefined && !isNaN(select_address_id) && select_address_id.length>0)
                {
                    url += '&area='+select_address_id;
                }
                location.href=url;
            }
        })
    });



    function ChangeShopSelStatus(obj,store_id,status)
    {
        var that = $(obj);
        if(that.hasClass('lock'))
        {
            layer.closeAll();
            return false;
        }
        that.addClass('lock');
        layer.open({
            type: 2
            ,content: '加载中'
        });
        if(store_id<0 || isNaN(store_id))
        {
            layer.closeAll();
            layer_msg('参数错误');
            that.removeClass('lock');
            return false;
        }
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'/?mod=weixin&v_mod=cart&_action=ActionChangeShopSelStatus',
                data:{status:status,store_id:store_id},
                dataType:'json',
                success:function (data)
                {
                    layer.closeAll();
                    if(data.code)
                    {
                        layer_msg(data.msg)
                    }else{
                        location.href='?mod=weixin&v_mod=checkout&d='+new Date().getTime();
                    }
                    that.removeClass('lock');
                },
                error:function ()
                {
                    layer.closeAll();
                    that.removeClass('lock');
                }
            });
            clearInterval(count_down);
        },500);
    }



    function ChangeProSelStatus(obj,cart_id)
    {
        var that = $(obj);
        if(that.hasClass('lock'))
        {
            layer.closeAll();
            return false;
        }
        that.addClass('lock');
        layer.open({
            type: 2
            ,content: '加载中'
        });
        if(cart_id<=0 || isNaN(cart_id))
        {
            layer.closeAll();
            layer_msg('参数错误');
            that.removeClass('lock');
            return false;
        }
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'/?mod=weixin&v_mod=cart&_action=ActionChangeProSelStatus',
                data:{cart_id:cart_id},
                dataType:'json',
                success:function (data)
                {
                    layer.closeAll();
                    if(data.code)
                    {
                        layer_msg(data.msg)
                    }else{
                        location.href='?mod=weixin&v_mod=checkout&d='+new Date().getTime();
                    }
                    that.removeClass('lock');
                },
                error:function ()
                {
                    layer.closeAll();
                    that.removeClass('lock');
                }
            });
            clearInterval(count_down);
        },500);
    }
    function layer_msg(msg)
    {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }


    $(".quantity-decrease").click(function ()
    {
        var quantity = $(this).next().val();
        var that = $(this);
        if(quantity==1 || $(this).hasClass('disabled'))
        {
            return false;
        }
        if(that.hasClass('lock'))
        {
            layer.closeAll();
            return false;
        }
        that.addClass('lock');
        layer.open({
            type: 2
            ,content: '加载中'
        });
        var cart_id = $(this).parent().attr('cid');
        if(cart_id<=0 || isNaN(cart_id))
        {
            that.removeClass('lock');
            return false;
        }
        parseInt(quantity--);
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'/?mod=weixin&v_mod=cart&_action=ActionEditCartProCount',
                data:{quantity:quantity,cart_id:cart_id},
                dataType:'json',
                success:function (data)
                {
                    that.removeClass('lock');
                    layer.closeAll();
                    if(data.code)
                    {
                        layer_msg(data.msg)
                    }else{
                        location.href='?mod=weixin&v_mod=checkout&d='+new Date().getTime();
                    }
                },
                error:function ()
                {
                    layer.closeAll();
                    that.removeClass('lock');
                }
            });
            clearInterval(count_down);
        },300);
    });

    $(".quantity-increase").click(function ()
    {
        var that = $(this);
        var quantity = that.prev().val();
        if(that.hasClass('lock'))
        {
            layer.closeAll();
            return false;
        }
        that.addClass('lock');
        layer.open({
            type: 2
            ,content: '加载中'
        });
        var cart_id = $(this).parent().attr('cid');
        if(cart_id<=0 || isNaN(cart_id))
        {
            that.removeClass('lock');
            return false;
        }
        parseInt(quantity++);
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'/?mod=weixin&v_mod=cart&_action=ActionEditCartProCount',
                data:{quantity:quantity,cart_id:cart_id},
                dataType:'json',
                success:function (data)
                {
                    that.removeClass('lock');
                    layer.closeAll();
                    if(data.code)
                    {
                        layer_msg(data.msg)
                    }else{
                        location.href='?mod=weixin&v_mod=checkout&d='+new Date().getTime();
                    }
                },
                error:function ()
                {
                    layer.closeAll();
                    that.removeClass('lock');
                }
            });
            clearInterval(count_down);
        },300);
    });

    $(".quantity").change(function ()
    {
        var that = $(this);
        var quantity = $(this).val();
        layer.open({
            type: 2
            ,content: '加载中'
        });
        if(that.hasClass('lock'))
        {
            layer.closeAll();
            return false;
        }
        if(quantity<=0 || isNaN(quantity))
        {
            layer.closeAll();
            that.val(1);
            layer_msg('数量错误');
            return false;
        }
        that.addClass('lock');
        var cart_id = $(this).parent().attr('cid');
        if(cart_id<=0 || isNaN(cart_id))
        {
            that.removeClass('lock');
            return false;
        }
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'/?mod=weixin&v_mod=cart&_action=ActionEditCartProCount',
                data:{quantity:quantity,cart_id:cart_id},
                dataType:'json',
                success:function (data)
                {
                    that.removeClass('lock');
                    layer.closeAll();
                    if(data.code)
                    {
                        layer_msg(data.msg)
                    }else{
                        location.href='?mod=weixin&v_mod=checkout&d='+new Date().getTime();
                    }
                },
                error:function ()
                {
                    layer.closeAll();
                    that.removeClass('lock');
                }
            });
            clearInterval(count_down);
        },300);
    });


    $(".quantity").change(function ()
    {
        var that = $(this);
        var quantity = $(this).val();
        layer.open({
            type: 2
            ,content: '加载中'
        });
        if(that.hasClass('lock'))
        {
            layer.closeAll();
            return false;
        }
        if(quantity<=0 || isNaN(quantity))
        {
            layer.closeAll();
            that.val(1);
            layer_msg('数量错误');
            return false;
        }
        that.addClass('lock');
        var cart_id = $(this).parent().attr('cid');
        if(cart_id<=0 || isNaN(cart_id))
        {
            that.removeClass('lock');
            return false;
        }
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'/?mod=weixin&v_mod=cart&_action=ActionEditCartProCount',
                data:{quantity:quantity,cart_id:cart_id},
                dataType:'json',
                success:function (data)
                {
                    that.removeClass('lock');
                    layer.closeAll();
                    if(data.code)
                    {
                        layer_msg(data.msg)
                    }else{
                        location.href='?mod=weixin&v_mod=checkout&d='+new Date().getTime();
                    }
                },
                error:function ()
                {
                    layer.closeAll();
                    that.removeClass('lock');
                }
            });
            clearInterval(count_down);
        },300);
    });


    function cart_del(obj,id,text)
    {
        var that = $(obj);
        if(id<=0 || isNaN(id))
        {
            layer_msg('error');
            return false;
        }
        if(that.hasClass('lock'))
        {
            return false;
        }
        layer.open({
            content: '确定要移除'+text+'?'
            ,btn: ['删除', '取消']
            ,skin: 'footer'
            ,yes: function(index)
            {
                layer.open({
                    type: 2
                    ,content: '加载中'
                });
                that.addClass('lock');
                var count_down = setTimeout(function ()
                {
                    $.ajax({
                        type:'post',
                        url:'/?mod=weixin&v_mod=cart&_action=ActionDelCart',
                        data:{cart_id:id},
                        dataType:'json',
                        success:function (data)
                        {
                            that.removeClass('lock');
                            layer.closeAll();
                            if(data.code)
                            {
                                layer_msg(data.msg)
                            }else{
                                location.href='?mod=weixin&v_mod=checkout&d='+new Date().getTime();
                            }
                        },
                        error:function ()
                        {
                            layer.closeAll();
                            that.removeClass('lock');
                        }
                    });
                    clearInterval(count_down);
                },300);
            }
        });
    }
    //验证支付密码
    function check_pass()
    {
        var password = $('#payment').val();
        if(password=='')
        {
            layer_msg('请输入支付密码');
            return false;
        }
        $.ajax({
            cache:false,
            type:"POST",
            url:"/?mod=weixin&v_mod=checkout&_action=ActionCheckPass",
            data:{'password':password},
            dataType:"json",
            success:function(result) {
                if (result.code==0)
                {
                    if($("input[name=address_id]").is(":checked"))
                    {
                        $('#submit').after('<input type="hidden" name="checkout" value="1">');
                        $("#form").submit();
                    }else if($("input[name=address_id]").length==1)
                    {
                        $("input[name=address_id]:eq(0)").attr("checked",'checked');
                        $('#submit').after('<input type="hidden" name="checkout" value="1">');
                        $("#form").submit();
                    }else
                    {
                        layer_msg('请选中或添加购物地址');
                        return false;
                    }
                }else
                {
                    layer_msg(result.msg);
                }
            },
            error:function(result) {
                layer_msg("网络超时,请重试!");
            }
        });
    }
    //提交订单
    $(function()
    {
        $("#submit").click(function ()
        {
            var select_pay_method = $("input[name='pay_method']:checked").val();
            var pay_password = '<?php echo $checkout['user']['pay_password']?'1':'';?>';
            if(select_pay_method=='user_money' && pay_password!='')
            {
                $iosDialog1.fadeIn(200);
                $('#payment').focus();
                return false;
            }
            if($("input[name=address_id]").is(":checked"))
            {
                $(this).after('<input type="hidden" name="checkout" value="1">');
                $("#form").submit();
            }else if($("input[name=address_id]").length==1)
            {
                $("input[name=address_id]:eq(0)").attr("checked",'checked');
                $(this).after('<input type="hidden" name="checkout" value="1">');
                $("#form").submit();
            }else
            {
                layer_msg('请选中或添加购物地址');
                return false;
            }
        });

        //选择优惠方式减免金额
        $("input[name=discount_method]").click(function()
        {
            var old_total=$("#old_total").val();
            if ($(this).val()=='discount')
            {
                var gift_balance=$("#gift_balance").val();
                $("#old_total_text").html(parseFloat(old_total)-parseFloat(gift_balance))
            }else
            {
                $("#old_total_text").html(old_total)
            }
        })

        <?php if (isset($_return['msg'])){?>
            layer_msg('<?php echo $_return['msg']; ?>');
        <?php }  ?>
    })
</script>
</body>
</html>