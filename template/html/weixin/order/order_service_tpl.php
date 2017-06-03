<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetServiceOrder();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>退款/售后</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
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
        .no-fg-btn{background:#ff464e; color:white; padding:0 10px; height:1.5rem; line-height: 1.5rem;  border-radius: 3px;  }
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body>
<div class="mui-content">
    <div class="web-cart-body">
        <!--没有购物产品提示 -->
        <div class="web-cart-product">
            <?php
                $service_status = array(1=>'申请退款中',2=>'退款中',3=>'退款完成',5=>'关闭退款');
                if($data['data'])
                {
                    foreach($data['data'] as $shop)
                    {
                        ?>
                        <div class="web-cells">
                            <!--<div class="web-cell__title fr14">
                                       订单号：2012
                                       <p class="fr fr14">
                                           未付款
                                       </p>
                                   </div>-->
                            <div class="web-cell__title fr14" onclick="location.href=''">
                                <img src="<?php echo $shop['store_logo']; ?>" class="mr10" style="width:1.2rem; height: 1.2rem; display: inline-block; vertical-align: bottom;">
                                <?php echo $shop['store_name']; ?>
                                <i class="ml10 fa fa-chevron-right fr12"></i>
                                <p class="fr fr14"></p>
                            </div>
                            <?php
                                foreach($data['details'][$shop['orderid']][$shop['shop_id']] as $pro)
                                {
                                    ?>
                                    <div class="web-cell pro-nums" style="background:#f8f8f8;"">
                                        <div class="web-cell__hd" onclick="location.href='?mod=weixin&v_mod=product&_index=_view&id=<?php echo $pro['product_id']; ?>'">
                                            <img src="<?php echo $pro['product_img']; ?>" class="mr10" style="width: 4rem; height: 4rem; display: block; border-radius: 3px; ">
                                        </div>
                                        <div class="web-cell__bd" style="width:60%;">
                                            <div class="fr14">
                                        <span class="fl mr10 omit" style="width:65%" >
                                            <?php echo $pro['product_name']; ?>
                                        </span>
                                                <span class="fr red">
                                            ￥<?php echo $pro['product_price']; ?>
                                        </span>
                                                <div class="cb"></div>
                                            </div>
                                            <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                                                <?php echo $pro['product_attr_name']; ?>
                                            </div>
                                            <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                                                数量：<?php echo $pro['product_count']; ?>
                                            </div>
                                            <div class="fr">
                                                <a href="/?mod=weixin&v_mod=order&_index=_refund_details&goods_id=<?php echo $pro['id']; ?>"><?php echo $service_status[$pro['goods_refund']]; ?></a>
                                                <?php
                                                    if($pro['goods_refund']==3)
                                                    {
                                                        ?>
                                                        <a href="javascript:;" onclick="qx_order(this,<?php echo $pro['id'];?>)">取消订单</a>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <?php
                    }
                }else{
                    ?>
                    <div class="web-cart-error tc" style="display: block;">
                        <img src="/template/source/default/images/no_order_i.png">
                        <p class="fr16 cl_b3">亲，暂无售后订单 再接再厉</p>
                        <div class="mtr30 error-btn"><a href="?mod=weixin">随便逛逛</a></div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
<div onClick="window.location.href='/?mod=weixin&v_mod=user'" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script>
    function qx_order(obj,id)
    {
        var that = $(obj);
        mui.confirm('确定要取消此产品？',function (index)
        {
            if(index.index==1)
            {
                $.ajax({
                    type:'post',
                    url:'/?mod=weixin&v_mod=order&_index=_service&_action=ActionCancelServiceOrder',
                    data:{id:id},
                    success:function (res)
                    {
                        if(res.code==0)
                        {
                            location.href='/?mod=weixin&v_mod=order&_index=_service';
                        }else{
                            mui.toast(res.msg);
                        }
                    },
                    error:function ()
                    {
                        mui.toast('error');
                    },
                    dataType:'json'
                });
            }
        });
    }
</script>
</body>
</html>