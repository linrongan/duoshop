<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$info = $obj->GetCartList(false);
$data = $info['cart'];
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>购物车</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/template/source/weixin/css/rest.css">
    <link rel="stylesheet" href="/template/source/weixin/css/cart.css">
    <style>
        .web-yp-title>span{color:#999999;}
        .web-yp-title>span::before{border-color:#999999}
        .web-yp-title>span::after{border-color:#999999;}
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell__title{padding:.5rem 3%;}
        .web-cell:before{border-top:none;}
		 .no-fg-btn{background:#ff464e; color:white; padding:0 10px; height:2rem; line-height:2rem; min-width:80px; text-align:center;   }
        .web-date-bottom{position:fixed; bottom:0; left: 0; background:white;  width:100%; border-top:1px solid #e8e8e8; padding-left:3%; }
		.duo-header-shortcut{display:none;}
		.miao-title{width:40px; height:30px; border-radius:50%; text-align:center; line-height:15px; background:#06F; color:white; position:absolute; top:0 ;right:-5px; padding:5px 0; -webkit-transform:scale(0.7);transform:scale(0.7) ; font-size:12px; }
        .kan-title{width:40px; height:30px; border-radius:50%; text-align:center; line-height:15px; background:#f23030; color:white; position:absolute; top:0 ;right:-5px; padding:5px 0; -webkit-transform:scale(0.7);transform:scale(0.7) ; font-size:12px; }
        .shop-group-item .shop-title{background:#FCC; padding-right:3%;}
		.shop-title-name{color:white;}
		.shp-cart-list li{border-bottom:1px solid #ededed;}
		.shp-cart-list li:last-child{border-bottom:none;}
		.shop-cart-display .cart-product-name{position:relative;}
		.cart-new-btn{position:absolute; right:-20px; top:10px;}
		.shop-cart-display.shp-cart-item-core{margin:0; padding:5px 0;}
		.shop-cart-display .cart-product-cell-1{top:50%; margin-top:-40px;}
    </style>
    <script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
</head>
<body>
<a name="top"></a>
<header>
    <div id="m_common_header"><header class="duo-header">
    <div class="duo-header-bar">
    <div onclick="javascript:history.go(-1)" id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
            <div class="duo-header-title">购物车</div>
            <div id="m_common_header_jdkey" class="duo-header-icon-shortcut J_ping"><span></span></div></div>
            <ul id="m_common_header_shortcut" class="duo-header-shortcut">
                <li id="m_common_header_shortcut_m_index">
                <a class="J_ping" href="/?mod=weixin">
                    <span class="shortcut-home"></span>
                    <strong>首页</strong></a>
                </li>
                <li class="J_ping" id="m_common_header_shortcut_category_search">
                    <a href="/?mod=weixin&v_mod=category">
                        <span class="shortcut-categories"></span>
                        <strong>分类搜索</strong>
                    </a>
                </li>
                <li class="J_ping current" id="m_common_header_shortcut_p_cart">
                    <a href="/?mod=weixin&v_mod=cart" id="html5_cart">
                        <span class="shortcut-cart"></span>
                        <strong>购物车</strong>
                    </a>
                </li>
                <li id="m_common_header_shortcut_h_home">
                    <a class="J_ping" href="/?mod=weixin&v_mod=user">
                        <span class="shortcut-my-account"></span>
                        <strong>会员中心</strong>
                    </a>
                </li>
            </ul>
        </header>
    </div>
</header>
<div id="notEmptyCart" style="display:block" >

<div class="shop-group">
    <?php
        $total_money = 0;
        $all_money = 0;
        $select = 0;
        $all_count = 0;
        $pro_count = 0;
        $order_postage_total = 0;
        if($data)
        {
            foreach($data as $key=>$item)
            {
                $total_money += $info['goods_postage'][$key]['shop_total'];
                ?>
                <div class="shop-group-item">
                    <div class="shop-title customize-shtit">
                        <div class="item">
                            <div class="check-wrapper" onclick="ChangeShopSelStatus(this,<?php echo $key; ?>,<?php echo $item['all_selected']; ?>)">
                                <span class="cart-checkbox  <?php echo $item['all_selected']?'checked':''; ?>"></span>
                            </div>
                            <div class="shop-title-content" onclick="location.href='/<?php echo $item['store_url']; ?>'">
                                <span class="shop-title-icon"><img src="<?php echo $item['store_logo']; ?>"></span>
                                <span class="shop-title-name"><?php echo $item['store_name']; ?></span>
                                <?php
                                    if($info['goods_postage'][$key]['postage_total']>0)
                                    {
                                        if($item['free_fee_money']-$info['goods_postage'][$key]['shop_total']>0)
                                        {
                                            echo '<span class="shop-title-name" style="float: right;">还差￥'.($item['free_fee_money']-$info['goods_postage'][$key]['shop_total']).'免运费</span>';
                                        }else
                                        {
                                            echo '<span class="shop-title-name" style="float: right;">免运费</span>';
                                        }
                                        $order_postage_total += $info['goods_postage'][$key]['postage_total'];
                                    }else
                                    {
                                        echo '<span class="shop-title-name" style="float: right;">免运费</span>';
                                    }
                                ?>
								<!--
                                <div class="shop-btn-com freeFreOpini" id="freeFreight">
                                    <a class="cart-new-btn free-freight-btn" ><span class="right-boundary"></span>
                                        <span class="btn-msg-in"></span>
                                    </a>
                                </div>
                               -->
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                    </div>
                    <ul class="shp-cart-list">
                        <?php
                            foreach($item['cart_list'] as $val)
                            {
                                $shop_total = 0;
                                $s = 0;
                                $all_count++;
                                if($val['select_status'])
                                {
                                    $s++;
                                    $pro_count += $val['product_count'];
                                }
                                ?>
                                <li>
                                    <div class="items">
                                        <div class="check-wrapper" onclick="ChangeProSelStatus(this,<?php echo $val['id']; ?>)">
                                            <span class="cart-checkbox <?php echo $val['select_status']?'checked':''; ?>"></span>
                                        </div>
                                        <div class="shp-cart-item-core shop-cart-display" >
                                            <a class="cart-product-cell-1" href="/?mod=weixin&v_mod=product&_index=_view&id=<?php echo $val['product_id']; ?>">
                                                <div style="position:relative;">
                                                    <img width="" class="cart-photo-thumb" alt="" src="<?php echo $val['product_img']; ?>" />
                                                    <?php
                                                    if (!empty($val['bargain_create_id']))
                                                    {?>
                                                        <span class="kan-title">
                                                        砍价<del><?php echo $val['old_price']; ?></del>
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
                                                </div>
                                            </a>
                                            <div class="cart-product-cell-2">
                                                <div class="cart-product-name">
                                                    <a href="/?mod=weixin&v_mod=product&_index=_view&id=<?php echo $val['product_id']; ?>" >
                                                        <span class="non-fresh-txt" ><?php echo $val['product_name']; ?></span>
                                                    </a>
                                                     <div onclick="cart_del(this,<?php echo $val['id']; ?>,'<?php echo $val['product_name'].'×'.$val['product_count']; ?>')" class="cart-new-btn del-prod-btn">
                                                           <span class="btn-msg-in" style="font-size:18px">×</span>
                                                     </div>
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
                                                <!-- price move to here end 
                                                <div class="option-btns">                 
                                                    <div class="shop-btn-com" style="text-align:right; margin-top:6px;">
                                                       
                                                    </div>
                                                </div>-->
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
</div>
<div id="emptyCart" style="display:<?php echo !$data?'block':'none'; ?>" >
    <div class="shp-cart-empty" onclick="location.href='?mod=weixin&v_mod=product'"  style="display:<?php echo !$data?'block':'none'; ?>">
        <em class="cart-empty-icn"></em>
        <span class="empty-msg">购物车空空如也,赶紧逛逛吧~</span>
    </div>
</div>
<?php
$all_sel_status = 2;
if($all_count>0)
{
    if($select==$all_count)
    {
        $all_sel_status = 1;
    }
}else
{
    $all_sel_status=0;
}
?>
<?php if ($all_count>0){?>
<div id="payment_p"  style="display:block" >
    <div id="paymentp"></div>
    <div class="payment-total-bar payment-total-bar-new box-flex-f" id="payment">
        <div class="shp-chk shp-chk-new box-flex-c" onclick="ChangeAllSelStatus(this,<?php echo $all_sel_status; ?>)">
            <span class="cart-checkbox <?php if($all_sel_status==1){echo 'checked';}?>"  id="checkIcon-1"></span>
            <span class="cart-checkbox-text">全选</span>
        </div>
        <div class="shp-cart-info shp-cart-info-new box-flex-c" style="padding-top: 8px">
            <strong id="shpCartTotal" data-fsizeinit="14" class="shp-cart-total">
                合计: <span class="bottom-bar-price" id="cart_realPrice">
                ¥ <?php echo $total_money; ?>
            </span>
            </strong>
            <!--<span id="saleOffNew" data-fsizeinit="10" class="sale-off sale-off-new  bottom-total-price">-->
        </div>
        <a class="btn-right-block btn-right-block-new  box-flex-c" data-count="<?php echo $pro_count; ?>" id="checkout">
            去结算 <span id="checkedNum">(<?php echo $pro_count; ?>)</span></a>
    </div>
</div>
<?php } ?>
<div id="mask" style="visibility: hidden">
    <div id="mask-wraper">
        <div id="mask-con">
        </div>
    </div>
</div>
<script src="/tool/layer/layer_mobile/layer.js"></script>
<script>
	$(function()
    {
		var a = true;
		$('#m_common_header_jdkey').click(function(){
			if(a){
				$('#m_common_header_shortcut').css('display','table');
				a = false;
			}else{
				$('#m_common_header_shortcut').css('display','none');
				a = true;
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
                        location.href='?mod=weixin&v_mod=cart&d='+new Date().getTime();
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
                        location.href='?mod=weixin&v_mod=cart&d='+new Date().getTime();
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

    function ChangeAllSelStatus(obj,status)
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
        if(status==0)
        {
            layer_msg('没有产品');
            return false;
        }
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'/?mod=weixin&v_mod=cart&_action=ActionChangeALLSelStatus',
                data:{status:status},
                dataType:'json',
                success:function (data)
                {
                    that.removeClass('lock');
                    layer.closeAll();
                    if(data.code)
                    {
                        layer_msg(data.msg)
                    }else{
                        location.href='?mod=weixin&v_mod=cart&d='+new Date().getTime();
                    }
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
                        location.href='?mod=weixin&v_mod=cart&d='+new Date().getTime();
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
                        location.href='?mod=weixin&v_mod=cart&d='+new Date().getTime();
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
                        location.href='?mod=weixin&v_mod=cart&d='+new Date().getTime();
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
                        location.href='?mod=weixin&v_mod=cart&d='+new Date().getTime();
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
                                location.href='?mod=weixin&v_mod=cart&d='+new Date().getTime();
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

    $("#checkout").click(function () {
        if($(this).attr('data-count')<=0)
        {
            layer_msg('暂无结算产品');
            return false;
        }
        location.href='?mod=weixin&v_mod=checkout';
    });
</script>
</body>
</html>
