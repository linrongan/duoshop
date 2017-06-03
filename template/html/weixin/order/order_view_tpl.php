<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(!isset($_GET['view']))
{
    $data = $obj->GetOrderDetails();
    $order = $data['data'];
    $goods = $data['goods'];
    $user = $obj->GetUserInfo(SYS_USERID);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone = no"/>
        <title><?php echo WEBNAME; ?></title>
         <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">

        <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?66666aaaa">
        <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
        <script src="/template/source/js/jquery-1.10.1.min.js"></script>
        <style>
            .weui-cell{padding:.14rem 3%;}
            .weui-cells::before,.weui-cells::after,.weui-cells .weui-cell::before{border:none;}
            .weui-cell:before{left:0;}
            .wuliu-btn{display:inline-block; padding:3px 8px; border:1px solid #333; border-radius:3px; color:#333;}
			.porduct_jshao{width:100%;}
            .porduct_hd{background:white; border-bottom:none; padding:.1rem 3%;}
            .porduct_jshao:last-child{border-bottom:none;}
            .noborder .weui-cell{padding:0 3%; line-height:.5rem;}
			.no-fg-btn{background:#ff464e; color:white; padding:5px 8px; height:.5rem; line-height: .5rem;  border-radius: 3px;  }
			.mui-table-view-radio .mui-table-view-cell .mui-navigate-right:after{color:#09bb07; right:30px;}
			.mui-table-view-radio .mui-table-view-cell>a:not(.mui-btn){margin-right: -90px;}
        </style>
    </head>
    <body>
    <?php
    if($order['order_status']>3)
    {
        if(!empty($order['logistics_number']))
        {
            ?>
            <div class="weui-cells mtr01">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <span class="sz14r">物流公司：</span>
                    </div>
                    <div class="weui-cell__bd">
                        <span class="sz14r"><?php echo $order['logistics_name']; ?></span>
                    </div>
                    <div class="weui-cell__ft">
                        <a href="javascript:;" onclick="location.href='?mod=weixin&v_mod=order&_index=_wuliu&id=<?php echo $_GET['id']; ?>'" class="wuliu-btn sz12r">物流详情</a>
                    </div>
                </div>
            </div>
            <?php
        }else{
            ?><p>暂无物流信息</p><?php
        }
    }
    ?>


    <div class="mtr02" >
        <div class="porduct_hd" style="height:.8rem;" >
            <img src="<?php echo $order['store_logo']; ?>"  alt="" style="height:100%; display:inline-block; vertical-align:middle; margin-top:-5px;">
            <span class="sz14r"><?php echo $order['store_name'];?></span>
        </div>
        <?php
        for($i=0;$i<sizeof($goods);$i++)
        {
            ?>
            <div class="porduct_jshao">
                <div class="fl l_porpic" onclick="location.href='/?mod=weixin&v_mod=product&_index=_view&id=<?php echo $goods[$i]['product_id']; ?>'">
                    <img src="<?php echo $goods[$i]['product_img']; ?>">
                </div>
                <div class="fl r_porname">
                    <p class="porduct_name tlie sz14r"><?php echo $goods[$i]['product_name']; ?></p>
                    <div class="mtr01 sz12r">
                    	<div>
                            <div class="fl">
                                价格：<span class="redColor">￥<?php echo $goods[$i]['product_price']; ?></span>
                            </div>
                            <?php
                            //支付状态
                            if($order['order_status']>=3 && $order['order_type']==0)
                            {
                                if($goods[$i]['goods_refund']==0)
                                {
                                    ?>
                                    <div class="fr" style="width:auto; height:auto;">
                                        <a href="?mod=weixin&v_mod=order&_index=_refund&goods_id=<?php echo $goods[$i]['id']; ?>"
                                           class=" order-click no-fg-btn fr12 mr10"><?php echo $order['order_status']==3?'退款':'售后'; ?></a>
                                    </div>
                                    <?php
                                }elseif($goods[$i]['goods_refund']==1){
                                    ?>
                                    <div class="fr" style="width:auto; height:auto;">
                                        <a href="?mod=weixin&v_mod=order&_index=_refund_details&goods_id=<?php echo $goods[$i]['id']; ?>" class=" order-click no-fg-btn fr12 mr10 ">申请退款中</a>
                                    </div>
                                    <?php
                                }elseif($goods[$i]['goods_refund']==2)
                                {
                                    ?>
                                    <div class="fr" style="width:auto; height:auto;">
                                        <a href="/?mod=weixin&v_mod=order&_index=_refund_details&goods_id=<?php echo $goods[$i]['id']; ?>"
                                           class=" order-click no-fg-btn fr12 mr10">已通过申请</a>
                                    </div>
                                    <?php
                                }elseif($goods[$i]['goods_refund']==3)
                                {
                                    ?>
                                    <div class="fr" style="width:auto; height:auto;">
                                        <a href="/?mod=weixin&v_mod=order&_index=_refund_details&goods_id=<?php echo $goods[$i]['id']; ?>"
                                           class=" order-click no-fg-btn fr12 mr10">已退款</a>
                                    </div>
                                    <?php
                                }elseif($goods[$i]['goods_refund']==5){
                                    ?>
                                    <div class="fr" style="width:auto; height:auto;">
                                        <a href="/?mod=weixin&v_mod=order&_index=_refund_details&goods_id=<?php echo $goods[$i]['id']; ?>"
                                           class=" order-click no-fg-btn fr12 mr10">退款关闭</a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="Npricenum sz14r redColor">×<?php echo $goods[$i]['product_count']; ?></div>
            </div>
            <?php
        }
        ?>
    </div>






    <div class="weui-cells" style="margin-top:0;">
        <div class="weui-cell" style=" border-bottom:1px solid #e8e8e8;">
            <div class="weui-cell__hd">
                <span class="redColor sz14r">状态：</span>
            </div>
            <div class="weui-cell__bd">
                <span class="redColor sz14r" id="order-status"><?php echo $Sys_Order_Status[$order['order_status']]; ?></span>
            </div>
            <div class="weui-cell__ft">
                <?php
                if($order['order_status']==1)
                {
                    if(strtotime($order['addtime'])+86460>time())
                    {
                        ?>
                        <a href="?mod=weixin&v_mod=checkout&_index=_shop_pay&orderid=<?php echo $order['orderid']; ?>&shop_id=<?php echo $order['shop_id']; ?>" id="pay_order" class="wuliu-btn sz12r">去付款</a>
                    <?php
                    }else
                    {
                        ?>
                        <a href="javascript:;" onclick="QxShopOrder(this,<?php echo $order['id']; ?>)" class="wuliu-btn sz12r">取消</a>
                    <?php
                    }
                }elseif($order['order_status']==4)
                {
                    ?>
                    <a href="javascript:;" onclick="confirm_get_goods(<?php echo $order['id']; ?>)" class="wuliu-btn sz12r">确认收货</a>
                <?php
                }
                //暂不评论
                ?>
            </div>
        </div>
        <?php
        if($order['order_status']==1)
        {
            ?>
            <div class="weui-cell" style=" border-bottom:1px solid #e8e8e8;">
                <div class="weui-cell__hd">
                    <span class="redColor sz14r">剩余支付时间：</span>
                </div>
                <div class="weui-cell__bd">
                    <span class="redColor sz14r"></span>
                </div>
                <div class="weui-cell__ft sz12r" id="over_time"></div>
            </div>
        <?php
        }
        ?>
        <script>
            function p (n)
            {
                var a = n || '';
                return a < 10 ? '0'+ a : a;
            }
            function d(n)
            {
                if(n > 0){
                    return n +'天';
                }else{
                    return ''
                }
            }
            var countDown = <?php echo strtotime($order['addtime'])+86460-time()?strtotime($order['addtime'])+86460-time():0; ?>;
            function newTime()
            {
                var startTime = new Date();
                countDown = countDown - 1;
                //算出中间差并且已毫秒数返回; 除以1000将毫秒数转化成秒数方便运算；
                //var countDown = (endTime.getTime() - startTime.getTime()) / 1000;
                //获取天数 1天 = 24小时  1小时= 60分 1分 = 60秒
                var oDay = Math.floor(countDown/(24*60*60));
                //获取小时数
                //特别留意 %24 这是因为需要剔除掉整的天数;
                var oHours = Math.floor(countDown/(60*60)%24);
                //获取分钟数
                //同理剔除掉分钟数
                var oMinutes = Math.floor(countDown/60%60);
                //获取秒数
                //因为就是秒数  所以取得余数即可
                var oSeconds = Math.floor(countDown%60);
                var myMS=Math.floor(countDown/100) % 10;
                //下面就是插入到页面事先准备容器即可;
                var html = d(oDay) +""+ p(oHours) +"小时"+ p(oMinutes) +"分"+ p(oSeconds) +"秒";
                //别忘记当时间为0的，要让其知道结束了;
                if(countDown < 0){
                    $("#over_time").html("支付逾期");
                }else{
                    $("#over_time").html(html);
                }
            }
            setInterval(newTime,1000);
            newTime();
        </script>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r">订单编号：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r"><?php echo $order['orderid']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">订单时间：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r"><?php echo $order['addtime']; ?></span>
            </div>
        </div>
    </div>


    <div class="weui-cells noborder" style="margin-top:0;">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r">运费：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r">￥<?php echo $order['pro_fee']; ?></span>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">商品总价：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r">￥<?php echo $order['total_pro_money']; ?></span>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">优惠券抵扣：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r">￥<?php echo $order['coupon_money']; ?></span>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">订单金额：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r">￥<?php echo $order['total_money']; ?></span>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">需支付：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r">￥<?php echo $order['total_money']; ?></span>
            </div>
        </div>



        <?php if ($order['order_status']>=3){?>

        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">支付方式：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r"><?php echo $order['pay_method']=='user_money'?'余额支付':'微信支付'; ?></span>
            </div>
        </div>

            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <span class="sz14r ">付款时间：</span>
                </div>
                <div class="weui-cell__bd"></div>
                <div class="weui-cell__ft">
                    <span class="sz14r"><?php echo $order['pay_datetime']; ?></span>
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <span class="sz14r ">已支付：</span>
                </div>
                <div class="weui-cell__bd"></div>
                <div class="weui-cell__ft">
                    <span class="sz14r">￥<?php echo $order['pay_money']; ?></span>
                </div>
            </div>


        <?php } ?>
    </div>


    <div class="weui-cells">
        <div class="weui-cell" style=" border-bottom:1px solid #e8e8e8;">
            <div class="weui-cell__hd">
                <span class="sz14r cl999">收货信息：</span>
            </div>
            <div class="weui-cell__bd" id="address_box">
                <span class="sz14r cl999">
                    <?php echo $order['ship_name']; ?> <?php echo $order['ship_phone']; ?>
                </span>
                <br/>
                <span class="sz14r cl999"><?php echo $order['ship_province'],$order['ship_city'],$order['ship_area'],$order['ship_address']; ?></span>
            </div>
        </div>
    </div>
    
 

    <?php
        if($order['order_status']==1)
        {
            $address = $obj->GetAddress();
            ?>

            <div class="mui-address">
                <ul class="mui-table-view mui-table-view-radio">
                    <?php
                        if(!empty($address))
                        {
                            for($i=0; $i<count($address); $i++)
                            {
                                ?>
                                <li class="mui-table-view-cell  <?php
                                if(isset($_GET['area']) && $_GET['area']==$address[$i]['id']){echo 'mui-selected';}elseif($address[$i]['default_select']){echo 'mui-selected';} ?>"
                                    data-value="<?php echo$address[$i]['id']; ?>">
                                    <a class="mui-navigate-right">
                                        <div class="weui-cells" style="margin-top:0;">
                                            <div class="weui-cell" style="padding:0;">
                                                <div class="weui-cell__bd">
                                                    <p><?php echo $address[$i]['shop_name'] . '&nbsp;' . $address[$i]['shop_phone']; ?></p>
                                                    <p style="font-size: 13px;color: #888888;"><?php echo $address[$i]['address_location'] . $address[$i]['address_details']; ?></p>
                                                </div>
                                                <?php
                                                if ($address[$i]['default_select'])
                                                {
                                                    ?>
                                                    <div class="weui-cell__ft">
                                                        <span class="moren sz12r">默认</span>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                    ?>
                </ul>
                <div class="weui-cells" style="margin-top:0;">
                	<a class="weui-cell weui-cell_access"
                       href="/?mod=weixin&v_mod=address&_index=_new&callback=&callback=<?php echo urlencode('/?mod=weixin&v_mod=order&_index=_view&id='.$_GET['id']); ?>">
                        <div class="weui-cell__hd">
                            <img src="/template/source/images/icon-address.png" style="width:.5rem;margin-right:10px;display:block">
                        </div>
                        <div class="weui-cell__bd">
                            <p class="sz14r">添加新地址</p>
                        </div>
                        <div class="weui-cell__ft"></div>
                    </a>
                     <a class="weui-cell" href="javascript:;" onclick="change_address(<?php echo $order['id']; ?>)" style="border-top:1px solid #ededed;">
                        <div class="weui-cell__bd">
                            <div class="weui-btn weui-btn_primary">修改地址</div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        }
    ?>

	



    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">备注：</span>
            </div>
            <div class="weui-cell__bd">
                <p class="sz14r"><?php echo $order['liuyan']; ?></p>
            </div>
            <div class="weui-cell__ft">

            </div>
        </div>
    </div>
<br/><br/>
    <div onClick="history.back()" style="width:0.6rem; height:0.6rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:0.4rem 0.4rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>
    </body>
 
    <script src="/template/source/default/js/mui.min.js"></script>
    <script src="/template/source/default/js/mui.lazyload.js"></script>
    <script src="/template/source/default/js/mui.lazyload.img.js"></script>
   
    <script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
    <script>
        var select_address_id = $('.mui-selected').attr('data-value');
        var info = document.getElementById("info");
        document.querySelector('.mui-table-view.mui-table-view-radio').addEventListener('selected',function(e){
            //console.log(e);
            select_address_id = e.detail.el.dataset.value;
            //alert(id);

        });


        function layer_msg(msg) {
            layer.open({
                content: msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });
        }

        // 修改收货地址
        function change_address(id)
        {
            //var select_address_id = $("input[name='address_id']:checked").val();
            mui.confirm('确认要修改收货地址吗？',function (index)
            {
                if(index.index)
                {
                    $.ajax({
                        type:"post",
                        url:"/?mod=weixin&v_mod=order&_action=ActionChangeAddress",
                        data:{select_address_id:select_address_id,id:id},
                        dataType:"json",
                        success:function (res)
                        {
                            alert(res.msg);
                            if(res.code==0)
                            {
                                $('#address_box').html('<span class="sz14r cl999">'
                                    + res.ship_name+res.ship_phone
                                    + '</span><br/>'
                                    + '<span class="sz14r cl999">'
                                    + res.ship_province+res.ship_city+res.ship_area+res.ship_address
                                    +'</span>');
                                //window.location.reload();
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
                                location.href='/?mod=weixin&v_mod=order';
                            }
                        }
                    });
                }
            });
        }

        function confirm_get_goods(id)
        {
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
    </script>
    </html>
    <?php
}else{
    $details = $obj->GetOrderItems($order['orderid']);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone = no"/>
        <title><?php echo WEBNAME; ?></title>
        <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
        <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?66666aaaa">
        <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
        <script src="/template/source/js/jquery-1.10.1.min.js"></script>
        <style>
            .weui-cell{padding:.14rem 3%;}
            .weui-cells::before,.weui-cells::after,.weui-cells .weui-cell::before{border:none;}
            .weui-cell:before{left:0;}
            .wuliu-btn{display:inline-block; padding:3px 8px; border:1px solid #333; border-radius:3px; color:#333;}
            .porduct_hd{background:white; border-bottom:none; padding:.1rem 3%;}
            .porduct_jshao:last-child{border-bottom:none;}
            .noborder .weui-cell{padding:0 3%; line-height:.5rem;}
        </style>
    </head>
    <body>

    <div class="weui-cells" style="margin-top:0;">
        <div class="weui-cell" style=" border-bottom:1px solid #e8e8e8;">
            <div class="weui-cell__hd">
                <span class="redColor sz14r">状态：</span>
            </div>
            <div class="weui-cell__bd">
                <span class="redColor sz14r"><?php echo $Sys_Order_Status[$data['order_status']]; ?></span>
            </div>
        </div>
    </div>

    <div class="mtr02" >
        <div class="porduct_hd">
            <span class="sz14r"><?php echo $data['order_ship_name']; ?></span>
        </div>
        <?php
        for($i=0;$i<count($details);$i++)
        {
            ?>
            <div class="porduct_jshao">
                <div class="fl l_porpic" onclick="location.href='/?mod=weixin&v_mod=product&_index=_details&id=<?php echo $details[$i]['product_id']; ?>'">
                    <img src="<?php echo $details[$i]['product_img']; ?>">
                </div>
                <div class="fl r_porname">
                    <p class="porduct_name tlie sz14r"><?php echo $details[$i]['product_name']; ?></p>
                    <div class="mtr01 sz12r">
                        价格：<span class="redColor">￥<?php echo $details[$i]['product_price']; ?></span>
                    </div>
                    <div class="sz12r"></div>
                </div>
                <div class="clearfix"></div>
                <div class="Npricenum sz14r redColor">×<?php echo $details[$i]['product_count']; ?></div>
            </div>
            <?php
        }
        ?>
    </div>


    <div class="weui-cells noborder" style="margin-top:0;">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r">运费：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r">￥<?php echo $data['order_ship_fee']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">订单金额：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r">￥<?php echo $data['order_total']; ?></span>
            </div>
        </div>
        <?php
        if($data['pay_money']!=$data['order_total'] && $data['order_status']>=3)
        {
            ?>
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <span class="sz14r ">优惠券抵扣：</span>
                </div>
                <div class="weui-cell__bd"></div>
                <div class="weui-cell__ft">
                    <span class="sz14r">￥<?php echo $data['order_total']-$data['pay_money']; ?></span>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">实付款：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r">￥<?php echo $data['pay_money']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">支付方式：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r"><?php echo $data['pay_way']==2?'余额支付':'微信支付'; ?></span>
            </div>
        </div>
    </div>


    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">备注：</span>
            </div>
            <div class="weui-cell__bd">
                <p class="sz14r"><?php echo $data['liuyan']; ?></p>
            </div>
            <div class="weui-cell__ft">

            </div>
        </div>
    </div>


    <div class="weui-cells noborder">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r">订单编号：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r"><?php echo $data['orderid']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">订单时间：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r"><?php echo $data['order_addtime']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <span class="sz14r ">付款时间：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
                <span class="sz14r"><?php echo $data['pay_datetime']; ?></span>
            </div>
        </div>
    </div>
    	<div onClick="history.back()" style="width:0.6rem; height:0.6rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:0.4rem 0.4rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>
    </body>
    </html>
    <?php
}
?>

