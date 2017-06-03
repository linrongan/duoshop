<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetAgentData();
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
        .borderLeft0::before{left:0;}
    </style>
</head>
<body>
<div id="content" style="padding:0 0 .9rem 0">
    <form id="form" action="" method="post">
        <div class="weui-cells__title cl999">填写订单</div>
        <div class="shop-group">
            <div class="shop-group-item">
                <div class="shop-title customize-shtit">
                    <div class="item">
                        <div class="shop-title-content">
                            <span class="shop-title-icon"><img src="<?php echo $data['store_logo']; ?>"></span>
                            <span class="shop-title-name"><?php echo $data['store_name']; ?></span>
                        </div>
                    </div>
                </div>
                <ul class="shp-cart-list">
                    <li>
                        <div class="items">
                            <div class="shp-cart-item-core shop-cart-display">
                                <a class="cart-product-cell-1">
                                    <img width="" class="cart-photo-thumb" alt="" src="<?php echo $data['product_img']; ?>" />
                                </a>
                                <div class="cart-product-cell-2">
                                    <div class="cart-product-name">
                                        <a>
                                            <span class="non-fresh-txt" ><?php echo $data['product_name']; ?></span>
                                        </a>
                                    </div>
                                    <div class="cart-product-prop eles-flex">
                                        <i class="prop0" style="font-style:normal">
                                            <?php echo $data['attr_name']; ?>
                                        </i>
                                    </div>
                                    <div class="icon-list">
                                        <!-- 比加入时降价信息-->
                                    </div>
                                    <div class="cart-product-cell-3">
                                        <span class="shp-cart-item-price">
                                            ¥ <strong class="redColor">
                                                <?php echo $data['agent_price']; ?>
                                            </strong>
                                        </span>
                                        <div class="quantity-wrapper customize-qua">
                                            <a class="quantity-decrease"></a>
                                            <input type="number" size="4" value="<?php echo $data['product_count']; ?>" name="num" class="quantity">
                                            <a class="quantity-increase"></a>
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
        <div class="weui-cells weui-cells_checkbox">
            <label class="weui-cell weui-check__label" for="s11">
                <div class="weui-cell__hd">
                    <input checked type="radio" class="weui-check" name="pay_method" value="wechat" id="s11">
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
            if($data['user']['user_money']>=$data['pro_total'])
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
                    <div class="weui-cell__ft sz12r">￥<?php echo $data['user']['user_money']; ?></div>
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
                <div class="weui-cell__ft sz14r">
                    <strong class="redColor">￥ <?php echo $data['postage_total']; ?></strong>
                </div>
            </div>
        </div>

        <div class="weui-cells">
            <div class="weui-cell onMore" style="border-bottom:1px solid #ededed;">
                <div class="weui-cell__hd">
                    <img src="/template/source/default/images/shou.png" style="width:.5rem; height:.5rem; display:block; margin-right:5px;">
                </div>
                <div class="weui-cell__bd"><input type="text" class="weui-input sz14r" placeholder="收件人姓名" value=""></div>
                <div class="weui-cell__ft">
                    <i class="get"  id="getAddress"><img src="/template/source/default/images/yhadd.png" style="width:.4rem; height:.4rem; display:block;"></i>
                </div>
            </div>
            <div class="weui-list-box">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label sz12r" style="text-indent:4em;">电话：</label></div>
                    <div class="weui-cell__bd">
                        <input type="text" class="weui-input sz12r" placeholder="请输入电话">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label sz12r" style="text-indent:4em;" >地址：</label></div>
                    <div class="weui-cell__bd">
                        <input type="text" class="weui-input sz12r" placeholder="请输入地址">
                    </div>
                </div>
            </div>

            <div class="weui-cells weui-cells_checkbox">
                <label class="weui-cell weui-check__label" for="s11">
                    <div class="weui-cell__hd">
                        <input checked type="radio" class="weui-check" name="address_id" value="1" id="s11">
                        <i class="weui-icon-checked"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p class="sz14r">张三123321</p>
                        <p class="sz12r" style="color: #888888;">广东深把运气</p>
                    </div>
                </label>

                <label class="weui-cell weui-check__label" for="s12">
                    <div class="weui-cell__hd">
                        <input checked type="radio" class="weui-check" name="address_id" value="2" id="s12">
                        <i class="weui-icon-checked"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p class="sz14r">张三123321</p>
                        <p class="sz12r" style="color: #888888;">广东深把运气</p>
                    </div>
                </label>
            </div>



            <div class="weui-cell onMore borderLeft0" style="border-bottom:1px solid #ededed; margin-top:-1px;"  >
                <div class="weui-cell__hd">
                    <img src="/template/source/default/images/ji.png" style="width:.5rem; height:.5rem; display:block; margin-right:5px;">
                </div>
                <div class="weui-cell__bd"><input type="text" class="weui-input sz14r" placeholder="寄件人姓名" value="" ></div>
                <div class="weui-cell__ft">
                    <i class="get" id="sentAddress"><img src="/template/source/default/images/yhadd.png" style="width:.4rem; height:.4rem; display:block;"></i>
                </div>
            </div>
            <div class="weui-list-box">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label sz12r" style="text-indent:4em;">电话：</label></div>
                    <div class="weui-cell__bd">
                        <input type="text" class="weui-input sz12r" placeholder="请输入电话">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label sz12r" style="text-indent:4em;" >地址：</label></div>
                    <div class="weui-cell__bd">
                        <input type="text" class="weui-input sz12r" placeholder="请输入地址">
                    </div>
                </div>
            </div>
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
                        <span class=" mr5" style="font-weight: bold">
                        <label id="old_total_text" class="redColor sz16r">
                            <?php echo $data['pro_total']; ?>
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
    <?php if (isset($_return['msg'])){?>
    layer_msg('<?php echo $_return['msg']; ?>');
    <?php }
    ?>
    $(function(){
        $('.onMore .get').click(function()
        {
            var id=$(this).attr("id");
            if (id=='getAddress')
            {
                console.log($(this).parents('.onMore').next('.weui-list-box').toggle());
            }else if(id=='sentAddress')
            {
                console.log($(this).parents('.onMore').next('.weui-list-box').toggle());
            }
        })
    })
</script>
</body>
</html>