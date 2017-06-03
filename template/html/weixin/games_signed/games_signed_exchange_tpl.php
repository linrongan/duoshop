<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user=$obj->GetUserInfo(SYS_USERID);
$data=$obj->GetPointGiftDetail();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $data['gift_name'];?></title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
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
        img{
            max-width: 100%;
        }

    </style>
</head>
<body>

<div class="gift-banner">
    <img src="<?php echo $data['gift_img'];?>">
</div>
<div class="gift-main" style="padding:0 15px;">
    <div class="gift-main-hd">
        <p class="sz16r fl omit w70b txtl omit"><?php  echo $data['gift_name'];?></p>
        <b class="clO fr w30b txtr sz16r"><?php  echo $data['need_point'];?> 积分</b>
        <div class="clearfix"></div>
    </div>
</div>
<input type="hidden" value="<?php  echo $data['gift_id'];?>" id="gift_id" name="gift_id">
<div class="weui-cells" style="margin-top:0">
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
<div class="weui-cells weui-cells_radio">
    <?php
    require_once RPC_DIR.'/module/mobile/weixin/address.php';
    $address_obj = new address(array());
    $address = $address_obj->GetShipAddress();
    if($address) {
        for ($i=0; $i<count($address); $i++)
        {
            ?>
            <label class="weui-cell weui-check__label" for="x-<?php echo $i; ?>">
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
                <div class="weui-cell__ft">
                    <input type="radio" name="address_id" id="address_id" value="<?php echo $address[$i]['id']; ?>" class="weui-check" <?php echo $address[$i]['default_select'] ? 'checked' : ''; ?> id="x-<?php echo $i; ?>">
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
           href="/?mod=weixin&v_mod=address&_index=_new&callback=&callback=<?php echo urlencode('?mod=weixin&v_mod=games_signed&_index=_exchange&id='.$_GET['id']); ?>">
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
<div style="height:73px;"></div>
<div class="weui-tabbar">



    <?php
        if ($data['sales']/$data['stock']<1 && $data['need_point']<=$user['point_signed']){
    ?>
        <a href="javascript:;" id="purchase-btn" class="weui-tabbar__item purchase-btn mb10">
            <p class="weui-tabbar__label sz16r" style="line-height: 46px;">立即兑换</p>
        </a>
    <?php }
    else{?>
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

        $("#purchase-btn").click(function(){
            if($("input[name=address_id]").is(":checked"))
            {
                $(this).after('<input type="hidden" name="checkout" value="1">');
                AjaxSubmitCart();
            }else
            {
                layer_msg('请选中或添加购物地址');
                return false;
            }
        });



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

    function AjaxSubmitCart()
    {
        var id=$("#gift_id").val();
        var qty=$("#qty").val();
        var address_id=$("#address_id").val();
        layer.open({
            content: '您确定要兑换？'
            ,btn: ['确定', '取消']
            ,yes: function(index){

                $.ajax({
                    cache:false,
                    type:"POST",
                    url:"?mod=weixin&v_mod=games_signed&_index=_exchange&_action=ActionPointExchange",
                    data:{"id":id,"qty":qty,"address_id":address_id},
                    dataType:"json",
                    success:function(result)
                    {
                        layer.closeAll();
                        if (result.code==0)
                        {

                            layer.open({
                                content:result.msg,
                                btn: '关闭窗口'
                            });

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
        });

    }
    function layer_msg(msg)
    {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }
</script>
</body>
</html>