<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user=$obj->GetUserInfo(SYS_USERID);
$data=$obj->GetPointProductDetail();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php  echo $data['gift_name'];?></title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/daili/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style>
        .cart-btn,.purchase-btn{text-align: center; }
        .cart-btn>p,.purchase-btn>p{color:white;}
        .cart-btn{background-color:#ff9600; border-right:none!important;}
        .purchase-btn{background-color:#ff4546}
        .weui-tabbar{padding:.2rem 3% 0; width:94%;}
        .weui-tabbar__item{padding-top:0; border-right:none;}
        .cart-btn, .purchase-btn{border-radius: 5px;}
        .nomai-btn{
            background-color: rgb(221, 221, 221);
            color: rgb(255, 255, 255);
            border-color: rgb(255, 255, 255);
        }
        .weui-badge {
            display: inline-block;
            padding: .15em .4em;
            min-width: 8px;
            border-radius: 18px;
            background-color: #ff6600;
            color: #FFFFFF;
            line-height: 1.2;
            text-align: center;
            font-size: 12px;
            vertical-align: middle;
        }
		.gift-banner>img{width:100%; height:auto; display:block;}
		.gift-main{background:white; padding-left:3%;}
		.gift-main-hd{padding:.2rem 3% .2rem 0; border-bottom:1px solid #ededed;}
		.gift-main-bd{padding:.2rem 3% .2rem 0;}
		.gift-notes{border-top:1px solid #ededed; padding:.1rem 3%; background:white; }

		.gift-main-bd img{max-width:100%; display:block;}
		.weui-tabbar {
			position: fixed;
			background: white;
			left: 0;
			bottom:0;
		}
		.numberBox>a{display: inline-block; width:.6rem; height:.4rem; border:1px solid #dedede; border-radius:3px; text-align: center; line-height: .4rem;}
.numberBox>input[type='number']{width:.6rem; height: .4rem; border:none; border:1px solid #dedede;  outline: none; text-align: center; display: inline-block; vertical-align: bottom; }


    </style>
</head>
<body>

<div class="gift-banner">
    <img src="<?php echo $data['source_img'];?>" style="width:100%; display:block;">
</div>

<div class="gift-main">
    <div class="gift-main-hd">
        <p class="sz16r fl omit w70b txtl omit"><?php  echo $data['gift_name'];?></p>
        <b class="clO fr w30b txtr sz16r"><?php  echo $data['gift_point'];?> 积分</b>
        <P>库存：<?php  echo $data['qty']-$data['sale'];?></P>
        <div class="clearfix"></div>
    </div>
    <div class="gift-main-bd">
        <?php  echo $data['content'];?>
    </div>
</div>
<input type="hidden" value="<?php  echo $data['id'];?>" id="product_id" name="product_id">
<div class="weui-cells" style="margin-top:.2rem">
    <div class="weui-cell" style=" border-top:1px solid #ededed;">
        <div class="weui-cell__hd"><label class="weui-label sz14r">兑换数量：</label></div>
        <div class="weui-cell__bd txtr">
            <div class="fr numberBox">
                <a href="javascript:;" class="glyphicon glyphicon-minus minus sz12r"></a>
                <input id="qty" name="qty" type="number" value="1" class="sz12r">
                <a href="javascript:;" class="glyphicon glyphicon-plus plus sz12r"></a>
            </div>
        </div>
    </div>
</div>

<div style="height:73px;"></div>
<div class="weui-tabbar">

    <a href="/?mod=weixin&v_mod=point&_index=_shopping" class="weui-tabbar__item" style="width:20%; -webkit-box-flex:inherit; -webkit-flex: inherit; flex: inherit; ">
            <span style="display: inline-block;position: relative;">
                <img src="/template/source/images/shoppingcar_small.png" alt="" class="weui-tabbar__icon" style="height:25px;">
                <span id="cart_qty" class="weui-badge" style="position: absolute;top: -5px;
    right: -5px;">
                    <?php
                    $cart=$obj->GetCartTotal();
                    echo empty($cart['count'])?0:$cart['count'];?> </span>
            </span>
        <p class="weui-tabbar__label sz14r blackColor">购物车</p>
    </a>

    <?php if ($data['qty'] && $data['gift_point']<=$user['user_point']){?>
        <a href="javascript:;" id="cart-btn" class="weui-tabbar__item cart-btn mr10 mb10">
            <p class="weui-tabbar__label sz16r" style="line-height: 46px;">加入购物车</p>
        </a>

        <a href="javascript:;" id="purchase-btn" class="weui-tabbar__item purchase-btn mb10">
            <p class="weui-tabbar__label sz16r" style="line-height: 46px;">立即兑换</p>
        </a>
    <?php }
    else{?>
        <a href="javascript:;" class="weui-tabbar__item cart-btn mr10 mb10  nomai-btn">
            <p class="weui-tabbar__label sz16r" style="line-height: 46px;">加入购物车</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item purchase-btn mb10 nomai-btn ">
            <p class="weui-tabbar__label sz16r" style="line-height: 46px;">立即兑换</p>
        </a>

    <?php
    } ?>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/comm.js"></script>
<script type="text/javascript" src="/template/source/layer/layer.js"></script>
<script>
    $(function(){

        $("#cart-btn").click(function(){
            AjaxSubmitCart(0);
        })

        $("#purchase-btn").click(function(){
            AjaxSubmitCart(1);
        })

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
        })

        $(".numberBox").on('blur','input[type="number"]',function(){
            if($(this).val() < 1){
                $(this).val(1);
            }
        })
    })

    function AjaxSubmitCart(type_id)
    {
        layer.open({
            type: 2,
            content: '请求中'
        });
        var id=$("#product_id").val();
        var qty=$("#qty").val();
        $.ajax({
            cache:false,
            type:"POST",
            url:"/?mod=weixin&v_mod=point&_index=_product_detail&_action=ActionSubmitCart",
            data:{"id":id,"qty":qty},
            dataType:"json",
            success:function(result)
            {
                layer.closeAll();
                if (result.code==0)
                {
                    $("#cart_qty").html(result.cart_qty);
                    if (type_id==0)
                    {
                        layer.open({
                            content:result.msg,
                            btn: '关闭窗口'
                        });
                    }else
                    {
                        window.location.href='/?mod=weixin&v_mod=point&_index=_checkout';
                    }
                }else
                {
                    layer.open({
                        content: result.msg,
                        skin: 'msg',
                        time: 2 //2秒后自动关闭
                    });
                }
            },
            error:function(result) {
                alert("网络超时,请重试!");
            }
        });
    }
</script>
</body>
</html>