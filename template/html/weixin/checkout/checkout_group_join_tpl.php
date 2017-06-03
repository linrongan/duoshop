<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$info = $obj->GetGroupJoin();
if($info['code'])
{
    redirect(NOFOUND.'&msg='.$info['msg']);
}
$data = $info['data'];
$attr = module('product')->GetProductAttr($data['product_id']);
$address = module('address')->GetShipAddress();
$user = $obj->GetUserInfo(SYS_USERID);
$money_total = 0;
$goods_fee = 0;
if(isset($_GET['quantity']) && !empty($_GET['quantity']))
{
    if(!is_numeric($_GET['quantity']) || $_GET['quantity']!=intval($_GET['quantity']))
    {
        $quantity = 1;
    }else{
        $quantity = intval($_GET['quantity']);
    }
}else{
    $quantity = 1;
}
if($data['allow_buy_nums']>0)
{
    if($quantity>=$data['allow_buy_nums'])
    {
        $quantity = $data['allow_buy_nums'];
    }
}
$pro_total = $data['group_price']*$quantity;
if($data['free_fee'] || $pro_total>=$data['free_fee_money'])
{
   $goods_fee = 0;
}else
{
    $goods_fee=$data['ship_fee_money'];
}
$money_total=$pro_total+$goods_fee;
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>我要参团</title>
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
        .miao-title{width:40px; height:40px; border-radius:50%; text-align:center; line-height:40px; background:#06F; color:white; position:absolute; top:-10px ;right:-5px;}
        .layui-m-layer-msg .layui-m-layercont{color:white !important;}
        .fightNumber-title {
            line-height: 1.75rem;
            padding:0 3%;
            background:white;
        }
        .fightNUmber-time,.fightNUmber-time>span{color:#999;}

        .fightNumber-user-btn {

            height: 1.5rem;
            line-height: 1.4rem;
            text-align: center;
            color: #ff4546;
            border: 1px solid #ff4546;
            border-radius: 3px;
            display:inline-block;
            padding:0 10px;
            font-size:12px;
        }

        .seckil-price-wrap .seckill-btm-div{    margin: 1px 0 0 8px;}
        .seckil-time-wrap .seckill-time-div {
            margin-top: 1px;
        }

        .fill_box_btn a {
            width: 100%;
            height: 1rem;
            line-height: 1rem;
            text-align: center;
            color: #FFF;
            float: left;
        !important;
        }
    </style>
</head>
<body>
<div id="content" style="padding:0 0 .9rem 0">
    <form id="form" action="/?mod=weixin&v_mod=checkout&_index=_group_join&gid=<?php echo $_GET['gid']; ?>&_action=ActionJoinGroup" method="post">
        <div class="weui-cells__title cl999">填写订单</div>
        <div class="shop-group">
            <div class="shop-group-item">
                <div class="shop-title customize-shtit">
                    <div class="item">
                        <div class="check-wrapper">
                            <span class="cart-checkbox checked"></span>
                        </div>
                        <div class="shop-title-content">
                            <span class="shop-title-icon"><img src="<?php echo $data['store_logo']; ?>"></span>
                            <span class="shop-title-name"><?php echo $data['store_name']; ?></span>
                            <div class="shop-btn-com freeFreOpini" id="freeFreight">
                                <a class="cart-new-btn free-freight-btn" ><span class="right-boundary"></span>
                                    <span class="btn-msg-in"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="shp-cart-list">
                    <li>
                        <div class="items">
                            <div class="check-wrapper">
                                <span class="cart-checkbox checked"></span>
                            </div>
                            <div class="shp-cart-item-core shop-cart-display">
                                <a class="cart-product-cell-1">
                                    <img width="" class="cart-photo-thumb" alt="" src="<?php echo $data['product_img']; ?>" />
                                </a>
                                <div class="cart-product-cell-2">
                                    <div class="cart-product-name">
                                        <a>
                                            <span class="non-fresh-txt"><?php echo $data['product_name']; ?></span>
                                        </a>
                                    </div>
                                    <div class="cart-product-cell-3">
                                        <span class="shp-cart-item-price">
                                            ¥ <strong>
                                                <?php echo $data['group_price']; ?>
                                            </strong>
                                        </span>
                                        <div class="quantity-wrapper customize-qua">
                                            <a class="quantity-decrease minus"></a>
                                            <input  readonly type="number" size="4" value="<?php echo $quantity; ?>" name="quantity" class="quantity">
                                            <a class="quantity-increase plus"></a>
                                        </div>
                                    </div>
                                    <!-- price move to here end -->
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="select-btn" style="display:<?php echo $attr?'block':'none'; ?>;">
            <p class="select-pro-sel fr12">请选择商品规格</p>
            <div class="arrow" style="right:3%">
                <b class="aw a-r"></b>
            </div>
        </div>

        <div id="Bgcon"></div>
        <div id="product_fill_box">

            <div class="fill_box_head">
                <div class="fill_box_head_img"><img src="<?php echo $data['product_img']; ?>" title="" alt=""></div>
                <div class="fill_box_head_mess">
                    <p class="price"><span class="fr16">￥<?php echo $data['group_price']; ?></span></p>
                    <!--<p class="stock"><span class="fr12">库存:<?php /*echo $data['product']['product_sold']; */?></span></p>-->
                </div>
                <a href="javascript:;" id="close"><span class=" fa fa-close fr16 cl_b3"></span></a>
            </div>

            <div class="fill_box_content">
                <?php
                if($attr)
                {
                    foreach($attr as $val)
                    {
                        ?>
                        <div class="fill_box_item">
                            <p class="fill_box_item_title sz14r"><?php echo $val['attr_type']; ?></p>
                            <div class="fill_box_item_number">
                                <?php
                                if(!empty($val['attr']))
                                {
                                    for($i=0;$i<count($val['attr']);$i++)
                                    {
                                        ?>
                                        <a href="javascript:;" attr_id="<?php echo $val['attr'][$i]['id'];  ?>" class="<?php if($i==0){echo 'select-active';} ?>"><?php echo $val['attr'][$i]['attr_temp_name']; ?></a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="fill_box_btn">
                <a href="javascript:;" id="select-attr" class="left add-cart fr14">确定</a>
                <div class="clearfix"></div>
            </div>
        </div>


        <div class="weui-cells weui-cells_checkbox">
            <label class="weui-cell weui-check__label" for="s11">
                <div class="weui-cell__hd">
                    <input type="radio" class="weui-check" name="pay_method" value="wechat" id="s11" checked="checked">
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
            if($user['user_money']>=$money_total)
            {
                ?>
                <label class="weui-cell weui-check__label" for="s12">
                    <div class="weui-cell__hd">
                        <input type="radio" name="pay_method" value="user_money" class="weui-check" id="s12" >
                        <i class="weui-icon-checked"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p class="sz14r">余额支付</p>
                    </div>
                    <div class="weui-cell__ft sz12r"><?php echo $user['user_money']; ?></div>
                </label>
                <?php
            }
            ?>
        </div>


        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <i class="gg-icon gg-icon_weixin mr10"></i>
                </div>
                <div class="weui-cell__bd">
                    <p class="sz14r">运费</p>
                </div>
                <div class="weui-cell__ft sz12r">
                    <?php echo $goods_fee?'￥'.$goods_fee:'免邮费'; ?>
                </div>
            </div>
        </div>


        <div class="weui-cells weui-cells_radio">
            <?php
            if($address) {
                for ($i = 0; $i < count($address); $i++) {
                    ?>
                    <label class="weui-cell weui-check__label" for="x-<?php echo $i; ?>">
                        <div class="weui-cell__bd">
                            <p><?php echo $address[$i]['shop_name'] . '&nbsp;' . $address[$i]['shop_phone']; ?></p>
                            <p style="font-size: 13px;color: #888888;"><?php echo $address[$i]['address_location'] . $address[$i]['address_details']; ?></p>
                        </div>
                        <?php
                        if ($address[$i]['default_select']) {
                            ?>
                            <div class="weui-cell__ft">
                                <span class="moren sz12r">默认</span>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="weui-cell__ft">
                            <input type="radio" name="address_id" value="<?php echo $address[$i]['id']; ?>"
                                   class="weui-check" <?php echo $address[$i]['default_select'] ? 'checked' : ''; ?>
                                   id="x-<?php echo $i; ?>">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <?php
                }
            }
            ?>
            <?php
            if(count($address)<10)
            {
                ?>
                <a class="weui-cell weui-cell_access"
                   href="/?mod=weixin&v_mod=address&_index=_new&callback=&callback=<?php echo urlencode('/?mod=weixin&v_mod=checkout&_index=_group_join&gid='.$_GET['gid']); ?>">
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
                    <textarea class="weui-textarea sz12r" name="liuyan" id="liuyan" placeholder="有什么想跟我说的么~~" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="withdraw-ft">
            <div class="support_bar">
                <div class="support_bar_total">
                    <p class="sz14r">合计：<span class="redColor mr5"><?php echo $money_total; ?></span>元</p>
                </div>
                <div class="support_bar_btn sz16r"><a id="submit" href="javascript:;">提交订单</a></div>
            </div>
        </div>
        <div id="pro_attr_select_item">

        </div>
    </form>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script>
    var select_attr = {
        attr:[]
    };
    var buy_count = <?php echo $data['allow_buy_nums']; ?>;
    $(function(){
        $(".quantity-wrapper").on('click','.plus',function(event){
            var value = $(this).siblings("input[type='number']").val();
            if(buy_count>0)
            {
                if(value<buy_count)
                {
                    value++;
                }else{
                    layer_msg('允许最大数量'+buy_count);
                    return false;
                }
            }else{
                value++;
            }
            location.href = '/?mod=weixin&v_mod=checkout&_index=_group_join&' +
                'gid=<?php echo $_GET['gid'] ?>&quantity='+value;
            $(this).siblings("input[type='number']").val(parseInt(value));
            $(this).siblings(".minus").css("color","#5c5c5c");
            event.stopPropagation();
        });

        $("#select-attr").click(function ()
        {
            var data = get_select_goods_attr();
            if(data)
            {
                var msg_Text = '已选择';
                for(var i=0;i<data.attr_last_name.length;i++)
                {
                    msg_Text += data.attr_last_name[i]+'：'+data.attr_name[i]+'&nbsp;';
                }
                $(".select-pro-sel").html(msg_Text);
                select_attr.attr = data.attr;
            }
            $("#Bgcon").fadeOut();
            $("#product_fill_box").slideUp(300);
        });

        $(".quantity-wrapper").on('click','.minus',function(event){
            var value = $(this).siblings("input[type='number']").val();
            if(value>1){
                value--;
                $(this).siblings("input[type='number']").val(parseInt(value));
                location.href = '/?mod=weixin&v_mod=checkout&_index=_group_join&' +
                    'gid=<?php echo $_GET['gid'] ?>&quantity='+value;
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
        })
    });




    $(".select-btn").click(function()
    {
        $("#Bgcon").fadeIn();
        $("#product_fill_box").slideDown(300);
    });


    function layer_msg(msg)
    {
        //提示
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }

    $("#submit").click(function ()
    {
        if($("input[name=address_id]").length<=0)
        {
            layer_msg('请添加购物地址');
            return false;
        }
        if(select_attr.attr.length>0)
        {
            for(var i=0;i<select_attr.attr.length;i++)
            {
                $("#pro_attr_select_item").append('<input type="hidden" name="attr_id[]" value="'+select_attr.attr[i]+'">');
            }
        }else{
            var option_len = $('.fill_box_content').children().length;
            if(option_len>0)
            {
                layer_msg('请选择属性');
                return false;
            }
        }
        $("#form").submit();
    });




    $('.fill_box_item').each(function()
    {
        $(this).find('.fill_box_item_number').children().click(function(){
            if($(this).hasClass('select-active')){
                return false;
            }else{
                $(this).addClass('select-active').siblings().removeClass('select-active');
            }
        });
    });

    function get_select_goods_attr()
    {
        var option_len = $('.fill_box_content').children().length;
        if(option_len>0)
        {
            var attr = [];
            var attr_name = [];
            var attr_last_name = [];
            var sel = 0;
            var all_len = 0;    //减去  重复class
            $('.fill_box_item').each(function()
            {
                all_len ++;
                attr_last_name.push($(this).children().eq(0).html());
                $(this).find('.fill_box_item_number').children().each(function()
                {
                    if($(this).hasClass('select-active'))
                    {
                        attr.push($(this).attr('attr_id'));
                        attr_name.push($(this).html());
                        sel++;
                    }
                });
            });
            if(all_len !=sel)
            {
                layer_msg('请选择属性');
                return false;
            }
            var info = {
                attr:attr,
                attr_name:attr_name,
                attr_last_name:attr_last_name
            };
            return info;
        }
    }

    <?php
    if(isset($_return) && $_return['msg'])
    {
    ?>
    layer_msg('<?php echo $_return['msg']; ?>');
    <?php
    }
    ?>
</script>
</body>
</html>