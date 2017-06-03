<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$cart=$obj->GetCart(1);
if (empty($cart['data']))
{
   redirect('/?mod=weixin&v_mod=point&_index=_shopping');
}
$total=$obj->GetCartTotal(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>结算中心</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/daili/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .weui-cell__bd>p{line-height: .4rem;}
        .weui-cells__title{padding-left:3%;}
        .numberBox>input[type='number']{ vertical-align: baseline;}
    </style>
</head>
<body>
<form method="post" action="/?mod=weixin&v_mod=point&_index=_checkout&_action=ActionSubmitGift" id="SubmitForm">
<div id="content" style="padding:0 0 .9rem 0">
    <div class="weui-cells__title cl999">温馨提示：请尽快提交订单，礼品随时被抢完</div>
    <div class="weui-cells weui-cells_radio">
        <?php
        foreach($cart['data'] as $item)
        {
        ?>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <img src="<?php echo $item['gift_img']; ?>" style="width: 1rem; display: block; margin-right:.2rem;"></div>
            <div class="weui-cell__bd ">
                <p class="omit sz14r">
                    <?php echo $item['gift_name']; ?>
                </p>
                <p class="sz12r"><span class="mr5 clO"><?php echo $item['gift_point']; ?></span>
                    积分 x <?php echo $item['cart_qty']; ?>
                </p>
            </div>
            <div class="weui-cell__ft sz14r">
                <?php echo $item['gift_point']*$item['cart_qty']; ?> 积分
            </div>
        </div>
       <?php } ?>
    </div>


    <?php $address = $obj->GetAddress();?>
    <div class="weui-cells weui-cells_radio">
        <?php
        if($address) {
            for ($i=0; $i<count($address); $i++)
            {
                ?>
                <label class="weui-cell weui-check__label" for="x-<?php echo $i; ?>">
                    <div class="weui-cell__bd">
                        <p class="sz14r"><?php echo$address[$i]['shop_name'] . '&nbsp;' . $address[$i]['shop_phone']; ?></p>
                        <p class="sz12r" style="color: #888888;"><?php echo $address[$i]['address_location'] . $address[$i]['address_details']; ?></p>
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
                        <input type="radio" name="address_id" <?php
                        if(isset($_GET['area']) && $_GET['area']==$address[$i]['id']){echo 'checked';}elseif($address[$i]['default_select']){echo 'checked';} ?>
                               value="<?php echo$address[$i]['id']; ?>" class="weui-check"  id="x-<?php echo $i; ?>">
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
               href="/?mod=weixin&v_mod=address&_index=_new&callback=&callback=<?php echo urlencode('/?mod=weixin&v_mod=point&_index=_checkout'); ?>">
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
                <textarea maxlength="250" name="liuyan" class="weui-textarea sz14r" placeholder="有什么想跟我说的么~~" rows="3"></textarea>
            </div>
        </div>
    </div>

    <div class="withdraw-ft">
        <div class="support_bar">
            <div class="support_bar_total">
                <p class="sz14r">合计：<span class="clO mr5"><?php echo $total['total']; ?></span>积分</p>
            </div>
            <div class="support_bar_btn sz16r"><a id="SubmitBtn" href="javascript:;">提交订单</a></div>
        </div>
    </div>
</div>
</form>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/comm.js"></script>
<script>
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
        })

        $(".numberBox").on('blur','input[type="number"]',function(){
            if($(this).val() < 1){
                $(this).val(1);
            }
        })

        $("#SubmitBtn").click(function()
        {
            if($("input[name=address_id]").is(":checked"))
            {

                $("#SubmitForm").submit();
            }
        })
    })
</script>
</body>
</html>