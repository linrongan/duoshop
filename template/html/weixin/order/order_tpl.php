<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetOrderlist();
$user = $obj->GetUserInfo(SYS_USERID);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>全部订单</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-opder-nav{padding:0; border-bottom:1px solid #e8e8e8;}
        .web-opder-nav>a{padding:.5rem 0;}
        .web-yp-title>span{color:#999999;}
        .web-yp-title>span::before{border-color:#999999}
        .web-yp-title>span::after{border-color:#999999;}
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell__title,.web-cell__text{padding:.5rem 3%;}
        .web-cell:before{border-top:none;}
        .web-cell__text{line-height: 1.5rem;}
        .no-fg-btn{background:#ff464e; color:white; padding:1px 10px; height:1.25rem; line-height: 1.25rem;  border-radius: 3px; display:inline-block; }
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body>
<div class="mui-content">
    <div class="web-opder-nav">
        <a href="/?mod=weixin&v_mod=order"
           class="<?php echo !isset($_GET['type'])?'web-order-active':''; ?> fr14 cl_b3 tc">全部订单</a>
        <a href="/?mod=weixin&v_mod=order&type=1"
           class="<?php echo isset($_GET['type']) && $_GET['type']==1?'web-order-active':''; ?> fr14 cl_b3 tc">待付款</a>
        <a href="/?mod=weixin&v_mod=order&type=3"
           class="<?php echo isset($_GET['type']) && $_GET['type']==3?'web-order-active':''; ?> fr14 cl_b3 tc">待发货</a>
        <a href="/?mod=weixin&v_mod=order&type=4"
           class="<?php echo isset($_GET['type']) && $_GET['type']==4?'web-order-active':''; ?> fr14 cl_b3 tc">待收货</a>
        <a href="/?mod=weixin&v_mod=order&type=6"
           class="<?php echo isset($_GET['type']) && $_GET['type']==6?'web-order-active':''; ?> fr14 cl_b3 tc">待评论</a>

    </div>
    <div class="web-cart-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-product">
            <?php
                if(!empty($data['data']))
                {
                    foreach($data['data'] as $item)
                    {
                     ?>
                        <div class="web-cells">
                            <!--<div class="web-cell__title fr14">
                                订单号：2012
                                <p class="fr fr14">
                                    未付款
                                </p>
                            </div>-->
                            <div class="web-cell__title fr14" onclick="location.href='<?php echo $item['store_url']; ?>'">
                                <img src="<?php echo $item['store_logo']; ?>" class="mr10" style="width:1.2rem; height: 1.2rem; display: inline-block; vertical-align: bottom;"><?php echo $item['store_name']; ?><i class="ml10 fa fa-chevron-right fr12"></i>
                                <p class="fr fr14"><?php echo $Sys_Order_Status[$item['order_status']]; ?></p>
                            </div>
                            <?php
                                if(!empty($data['details'][$item['orderid']][$item['shop_id']]))
                                {
                                    foreach($data['details'][$item['orderid']][$item['shop_id']] as $value)
                                    {
                                        ?>
                                        <div class="web-cell" style="background:#f8f8f8;" onclick="location.href='?mod=weixin&v_mod=order&_index=_view&id=<?php echo $item['id']; ?>'">
                                            <div class="web-cell__hd">
                                                <img src="<?php echo $value['product_img']; ?>" class="mr10" style="width: 4rem; height: 4rem; display: block; border-radius: 3px; ">
                                            </div>
                                            <div class="web-cell__bd" style="width:60%;">
                                                <div class="fr14">
                                                    <span class="fl mr10 omit" style="width:65%" >
                                                        <?php
                                                            if($item['order_type'])
                                                            {
                                                                ?>
                                                                <img src="/template/source/images/tem.png" style="width:20px; height:20px; display:inline-block; margin-right:5px; vertical-align:middle; margin-top:-3px;" >
                                                                <?php
                                                            }
                                                        ?>
                                                        <?php echo $value['product_name']; ?>
                                                    </span>
                                                    <span class="fr red">￥<?php echo $value['product_price']; ?></span>
                                                    <div class="cb"></div>
                                                </div>
                                                <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                                                    <?php echo $value['product_attr_name']; ?>
                                                </div>
                                                <div class="mtr5">
                                                    <div class=" fr12 cl_b9 fl" style="min-height: 1.25rem; line-height: 1.25rem; ">
                                                        数量：<?php echo $value['product_count']; ?>
                                                    </div>
                                                    <div class="fr">
                                                    <?php
                                                    if($item['order_status']>=3 && $item['order_type']==0)
                                                    {
                                                        if($value['goods_refund']==1)
                                                        {
                                                            ?>
                                                            <a href="javascript:;" class="order-click no-fg-btn fr12 mr10">申请退款中</a>
                                                            <?php
                                                        }elseif($value['goods_refund']==2)
                                                        {
                                                            ?>
                                                            <a href="javascript:;" class="order-click no-fg-btn fr12 mr10">退款确认中</a>
                                                            <?php
                                                        }elseif($value['goods_refund']==2)
                                                        {
                                                            ?>
                                                            <a href="javascript:;" class="order-click no-fg-btn fr12 mr10">退款确认中</a>
                                                            <?php
                                                        }elseif($value['goods_refund']==3)
                                                        {
                                                            ?>
                                                            <a href="javascript:;" class="order-click no-fg-btn fr12 mr10">已退款</a>
                                                            <?php
                                                        }elseif($value['goods_refund']==5)
                                                        {
                                                            ?>
                                                            <a href="javascript:;" class="order-click no-fg-btn fr12 mr10">关闭退款</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </div>
                                                    <div class="cb"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                            <div class="web-cell__text fr12">
                                共<span class="red"><?php echo $item['pro_count']; ?></span>件
                                合计：<span class="red">￥<?php echo $item['total_money']; ?></span>
                                 <?php if ($item['pro_fee']>0){?>
                                （含运费￥<?php echo $item['pro_fee']; ?>）
                                 <?php } ?>
                                <?php
                                    if($item['order_status']<3)
                                    {
                                        if((strtotime($item['addtime'])+60*60*24<time()))
                                        {
                                            ?>
                                            <a href="javascript:;" onclick="QxShopOrder(this,<?php echo $item['id']; ?>)"  class="fr order-click no-fg-btn fr14 qx-shop-order">取消</a>
                                            <?php
                                        }else{
                                            ?>
                                            <a href="?mod=weixin&v_mod=checkout&_index=_shop_pay&orderid=<?php echo $item['orderid']; ?>&shop_id=<?php echo $item['shop_id']; ?>"   class="fr order-click no-fg-btn fr14 ">付款</a>
                                            <?php
                                        }
                                    }elseif($item['order_status']==4)
                                    {
                                        ?>
                                        <a href="javascript:;" onclick="confirm_get_goods(<?php echo $item['id']; ?>)"  class="fr order-click no-fg-btn fr14 ">确认收货</a>
                                        <?php
                                    }elseif($item['order_status']==6)
                                    {
                                        ?>
                                        <a href="?mod=weixin&v_mod=order&_index=_get_one&id=<?php echo $item['id']; ?>" class="fr order-click no-fg-btn fr14 ">再来一单</a>
                                        <?php
                                    }
                                ?>
                                <div class="cb"></div>
                            </div>
                        </div>
                        <?php
                    }
                }else{
                    ?>
                    <div class="web-cart-error tc" style="display: block;">
                        <img src="/template/source/default/images/no_order_i.png">
                        <p class="fr16 cl_b3">亲，暂无订单</p>
                        <div class="mtr30 error-btn"><a href="?mod=weixin">随便逛逛</a></div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
<!--密码验证-->
<div class="js_dialog" id="iosDialog1" style="opacity: 1; display: none;">
    <div class="weui-mask" onClick="hidePrice()" ></div>
    <div class="weui-dialog">
        <div class="weui-dialog__hd" style="padding:.8em 1.6em; border-bottom:1px solid #0bb20c;"><strong class="weui-dialog__title">请输入支付密码</strong></div>
        <div class="weui-dialog__bd" style=" padding:1.6em .8em; ">
            <div style="width:100%; height:40px; display:block; box-sizing:border-box;">
                <input type="hidden" id="orderid" name="orderid" value=""/>
                <input type="password" class="weui-input" id="payment" maxlength="6" pattern="[0-9]*" style="height:100%; line-height:40px; padding:0 5%; width:100%; font-size:16px; line-height:normal; color:#333;">
            </div>
        </div>
        <div class="weui-dialog__ft">
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default" onClick="hidePrice()">取消</a>
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" onclick="check_pass()">确认</a>
        </div>
    </div>
</div>

<div onClick="window.location.href='/?mod=weixin&v_mod=user'" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;"></div>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
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

    $(".web-cart-product").on('click','.order-click',function ()
    {
        var attr = $(this).attr('cl');
        var orderid = $(this).attr('oid');
        if(orderid =='' || attr==''){return;}
        switch (attr)
        {
            case 'pay':
                location.href='?mod=weixin&v_mod=checkout&_index=_pay&orderid='+orderid;
                break;
            case 'sh':
                shounhuo(orderid);
                break;
        }
    });
    //收货
    function shounhuo(orderid)
    {
        mui.confirm('是否确认已收货？',function (index)
        {
            if(index.index)
            {
                $.ajax({
                    cache:false,
                    type:"post",
                    url:"/?mod=weixin&v_mod=order&_action=ActionConfirmGetPro",
                    data:{orderid:orderid},
                    dataType:"json",
                    success:function (res)
                    {
                        mui.toast(res.msg);
                        if(res.code==0)
                        {
                            location.href='/?mod=weixin&v_mod=order&type=6&orderid='+orderid;
                        }
                    }
                });
            }
        });
    }




    function QxShopOrder(obj,id)
    {
        var that = $(obj);
        mui.confirm('取消已失效订单？',function (index)
        {
            if(index.index)
            {
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=order&_action=ActionQxShopOrder",
                    data:{id:id},
                    dataType:"json",
                    success:function (res)
                    {
                        mui.toast(res.msg);
                        if(res.code==0)
                        {
                            that.parents('.web-cells').remove();
                        }
                    }
                });
            }
        });
    }

    //验证支付密码
    function check_pass()
    {
        var password = $('#payment').val();
        var id = $('#orderid').val();
        if(password=='')
        {
            mui.toast('请输入支付密码');
            return false;
        }
        $.ajax({
            type:"post",
            url:"/?mod=weixin&v_mod=order&_action=ActionConfirmGetPro",
            data:{id:id,password:password},
            dataType:"json",
            success:function (res)
            {
                mui.toast(res.msg);
                if(res.code==0)
                {
                    location.href='/?mod=weixin&v_mod=order&type=6';
                }
            }
        });
    }

//收货
    function confirm_get_goods(id)
    {
        var pay_password = '<?php echo $user['pay_password']?'1':'';?>';
        if( pay_password!='')
        {
            $('#orderid').val(id);
            $iosDialog1.fadeIn(200);
            $('#payment').focus();
            return;
        }
        mui.confirm('确认签收？',function (index)
        {
            if(index.index)
            {
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=order&_action=ActionConfirmGetPro",
                    data:{id:id},
                    dataType:"json",
                    success:function (res)
                    {
                        mui.toast(res.msg);
                        if(res.code==0)
                        {
                            location.href='/?mod=weixin&v_mod=order&type=6';
                        }
                    }
                });
            }
        });
    }


    layui.use('flow', function()
    {
        var flow = layui.flow;
        flow.load({
            elem: '.web-cart-product'
            ,done: function(page, next)
            {
                var lis = [];
                $.getJSON('<?php echo _URL_; ?>&page='+page, function(res)
                {
                    lis.push(res.data);
                    next(lis.join(''), page < res.pages);
                });
            }
        });
    });
</script>
</body>
</html>