<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$cart=$obj->GetCart();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>购物车</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/daili/css/ggPublic.css?7777777sadas">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style>
        .search-empty-panel{height:5rem;}
        .search-empty-panel .content >img{width:100px; height:100px;}
        .search-empty-panel .content{width:200px; margin-left: -100px;}
        .shopping-btn{display:inline-block; padding:.1rem .4rem; background:#ff6600; color:white; border-radius:3px;}
		.remove{position:absolute; right:3%; top:50%; margin-top:-12px; font-size:16px;}
    </style>
</head>
<body>
<div id="gg-app" style="padding:0 0 1rem 0">
    <div class="gg-shopping-container">
        <ul class="gg-shopping-warp">
            <?php
            $qty=0;
            if (!empty($cart['data']))
            {
                foreach($cart['data'] as $item)
                {
                    $qty+=$item['cart_qty'];
                    ?>
                <li class="gg-shopping-item" data-active="true">
                <div class="fl gg-shopping-checkbox">
                    <input name="select_status" type="checkbox" value="<?php echo $item['gift_id']; ?>" <?php echo $item['select_status']?"":'checked="true"'; ?>>
                </div>
                <div class="fl gg-shopping-proImg">
                    <img src="<?php echo $item['gift_img']; ?>">
                </div>
                <div class="fr gg-shopping-main">
                    <p class="omit sz14r"><?php echo $item['gift_name']; ?></p>
                    <p class="tlie sz12r cl999">
                        <?php echo $item['gift_desc']; ?>
                    </p>
                    <div class="remove" onclick="remove_cart(this,<?php echo $item['gift_id']; ?>)">×</div>
                    <div class="shopping-main-bottom">
                        <span class="fl cldb3652 sz14r"> <?php echo $item['gift_point']; ?> 积分</span>
                        <div class="fr numberBox">
                            <a rel="<?php echo $item['gift_id']; ?>" href="javascript:;" class="glyphicon glyphicon-minus minus"></a>
                            <input name="cart_qty" class="cart_qty"  type="number"  value="<?php echo $item['cart_qty']; ?>">
                            <a rel="<?php echo $item['gift_id']; ?>" href="javascript:;" class="glyphicon glyphicon-plus plus"></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </li><?php
                }
            }else
            {?>
                <!---没有提示-->
                <li style="background:#f0f0f0">
                    <div class="search-empty-panel">
                        <div class="content" >
                            <img src="/template/source/images/no_shopping.png">
                            <div class="text">购物车还没有要兑换的礼品~</div>
                            <div class="txtc mtr02"><a href="/?mod=weixin&v_mod=point&_index=_shop" class="shopping-btn">立即去兑换</a></div>
                        </div>
                    </div>
                </li>
            <?php }
            ?>
        </ul>
    </div>

    <?php
    if (!empty($cart['data']))
    {
        $cart=$obj->GetCartTotal(1);
    ?>
    <div class="gg-shopping-bottom">
        <div class="fl whole-btn" data-checked="true">
            <input type="checkbox" <?php if ($qty==$cart['count']){?> checked="checked" <?php } ?>>
            <span class="sz14r blackColor">全选</span>
        </div>
        <div class="fr settlement">
            <a href="/?mod=weixin&v_mod=point&_index=_checkout" class="sz16r">兑换(<span id="total_count" style="color: #fff"><?php echo empty($cart['count'])?0:$cart['count']; ?></span>)</a>
        </div>
        <div class="fr totalprice mr10 sz14r">
            合计：<span id="total_point"><?php echo empty($cart['total'])?0:$cart['total']; ?></span> 积分
        </div>
        <div class="clearfix"></div>
    </div>
    <?php }
    ?>
</div>

<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/layer/layer.js"></script>
<script type="text/javascript">
    $(function(){
        $(".gg-shopping-warp").on('click','.gg-shopping-item',function(){
            var gift_id=$(this).children(".gg-shopping-checkbox").children("input[name='select_status']").val();
            if($(this).attr("data-active") == 'true')
            {
                AjaxSelectStatus(3,gift_id);
                $(this).attr("data-active","false");
                $(this).children(".gg-shopping-checkbox").children("input[type='checkbox']").removeAttr("checked");
                $(".whole-btn").attr("data-checked","false");
                $(".whole-btn").children("input[type='checkbox']").removeAttr("checked");
                $(".whole-btn").children("span").css("color","#999")
            }else{
                $(this).attr("data-active","true");
                $(this).children(".gg-shopping-checkbox").children("input[type='checkbox']").prop("checked","checked");
                if($(".gg-shopping-checkbox input[type='checkbox']").length == $(".gg-shopping-checkbox input[type='checkbox']:checked").length){
                    AjaxSelectStatus(2,gift_id);
                    $(".whole-btn").attr("data-checked","true");
                    $(".whole-btn").children("input[type='checkbox']").prop("checked","checked");
                    $(".whole-btn").children("span").css("color","#000")
                }
            }
        });

        $(".numberBox").on('click','.plus',function(event){
            var gift_id=$(this).attr("rel");
            var value = $(this).siblings("input[type='number']").val();
            value++;
            $(this).siblings("input[type='number']").val(parseInt(value));
            AjaxUpdateCartQty(1,gift_id,value);
            $(this).siblings(".minus").css("color","#5c5c5c");
            event.stopPropagation();
        });
        $(".numberBox").on('click','.minus',function(event){
            var gift_id=$(this).attr("rel");
            var value = $(this).siblings("input[type='number']").val();
            if(value>1){
                value--;
                $(this).siblings("input[type='number']").val(parseInt(value));
                AjaxUpdateCartQty(0,gift_id,value);
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

        $(".whole-btn").click(function(){
            if($(this).attr("data-checked") == 'false'){
                AjaxSelectStatus(1,0);
                $(this).children("input[type='checkbox']").prop("checked","checked");
                $(this).children("span").css("color","#000");
                $(".gg-shopping-warp .gg-shopping-item").each(function(index,element){
                    $(element).attr("data-active","true");
                    $(element).children(".gg-shopping-checkbox").children("input[type='checkbox']").removeAttr("checked").prop("checked","checked");
                });
                $(this).attr("data-checked","true");
            }else{
                AjaxSelectStatus(0,0);
                $(this).children("input[type='checkbox']").removeAttr("checked");
                $(this).children("span").css("color","#999999");
                $(".gg-shopping-warp .gg-shopping-item").each(function(index,element){
                    $(element).attr("data-active","false");
                    $(element).children(".gg-shopping-checkbox").children("input[type='checkbox']").removeAttr("checked")
                });
                $(this).attr("data-checked","false");
            }
        })
    });


    //type_id 0减数量1加，gift_id为单个礼物的id
    function AjaxUpdateCartQty(type_id,gift_id,qty)
    {
        layer.open({
            type: 2,
            content: '请求中'
        });
        $.ajax({
            cache:false,
            type:"POST",
            url:"/?mod=weixin&v_mod=point&_index=_shopping&_action=ActionUpdateCartQty",
            data:{"type_id":type_id,"id":gift_id,"qty":qty},
            dataType:"json",
            success:function(result)
            {
                layer.closeAll();
                if (result.code==0)
                {
                    $("#total_count").html(result.count);
                    $("#total_point").html(result.point);
                }else
                {
                    layer(result.msg);
                }
            },
            error:function(result) {
                layer("网络超时,请重试!");
            }
        });
    }

    //type_id 0 全部未选择1为全部选择2为单个选择3为单个不选中，gift_id为单个礼物的id
    function AjaxSelectStatus(type_id,gift_id)
    {
        layer.open({
            type: 2,
            content: '请求中'
        });
        $.ajax({
            cache:false,
            type:"POST",
            url:"/?mod=weixin&v_mod=point&_index=_shopping&_action=ActionSelectStatus",
            data:{"type_id":type_id,"gift_id":gift_id},
            dataType:"json",
            success:function(result)
            {
                layer.closeAll();
                if (result.code==0)
                {
                      $("#total_count").html(result.count);
                      $("#total_point").html(result.point);
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


    /*更新数量 - input*/
    $('.cart_qty').change(function ()
    {
       var type_id = 1;
       var count = $(this).val();
       var id = $(this).prev().attr("rel");
       if(isNaN(count))
       {
           layer_msg('数量错误');
           return false;
       }
       if(count<=0)
       {
           layer_msg('数量必须大于0');
           return false;
       }
        layer.open({
            type: 2,
            content: '请求中'
        });
        $.ajax({
            cache:false,
            type:"POST",
            url:"/?mod=weixin&v_mod=point&_index=_shopping&_action=ActionUpdateCartQty",
            data:{"type_id":type_id,"id":id,"qty":count},
            dataType:"json",
            success:function(result)
            {
                layer.closeAll();
                if (result.code==0)
                {
                    $("#total_count").html(result.count);
                    $("#total_point").html(result.point);
                }else
                {
                    layer_msg(result.msg);
                }
            },
            error:function(result)
            {
                layer_msg("网络超时,请重试!");
            }
        });
    });




    function remove_cart(obj,id)
    {
        if(isNaN(id))
        {
            return;
        }
        layer.open({
            type: 2,
            content: '请求中'
        });
        var that = $(obj);
        $.ajax({
            type:'post',
            url:'/?mod=weixin&v_mod=point&_index=_shopping&_action=ActionDelPointCart',
            data:{id:id},
            success:function (result)
            {
                layer.closeAll();
                if (result.code==0)
                {
                    that.parents('.gg-shopping-item').remove();
                    $("#total_count").html(result.count);
                    $("#total_point").html(result.point);
                    if($(".gg-shopping-warp").children().length==0)
                    {
                        $(".gg-shopping-warp").append(' <li style="background:#f0f0f0">'
                            +' <div class="search-empty-panel">'
                            +'<div class="content" >'
                            +'<img src="/template/source/images/no_shopping.png">'
                            +'<div class="text">购物车还没有要兑换的礼品~</div>'
                            +'<div class="txtc mtr02"><a href="/?mod=weixin&v_mod=point&_index=_shop" class="shopping-btn">立即去兑换</a></div>'
                            +'</div>'
                            +'</div>'
                            +'</li>');
                    }
                }else
                {
                    layer_msg(result.msg);
                }
            },
            error:function ()
            {
                layer.closeAll();
            },
            dataType:'json'
        });
    }




    function layer_msg(msg)
    {
        layer.open({
            content:msg,
            skin: 'msg',
            time: 2 //2秒后自动关闭
        });
    }
</script>
</body>
</html>