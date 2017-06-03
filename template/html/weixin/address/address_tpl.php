<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetShipAddress();
$address_count = $obj->GetWebConf('user_address_count');
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>我的地址</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-cells:first-child{margin-top:0;}
        .web-cells::before{border-top:none;}
        .web-cell:first-child::before{border-top:none;}
        .web-cell:before{left:0;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body >

<div class="mui-content">

    <div class="web-cart-error tc" style="display: <?php  echo $data?'none':'block'; ?>;">
        <img src="/template/source/default/images/no_address_i.png">
        <p class="fr16 cl_b3">亲，暂时没有地址</p>
        <div class="mtr30 error-btn"><a href="/?mod=weixin&v_mod=address&_index=_new&callback=<?php echo urlencode(_URL_); ?>">添加地址</a></div>
    </div>


    <div class="web-address-content">
        <?php
        if(!empty($data))
        {
            $i = 0;
            foreach($data as $item)
            {
                ?>
                <div class="web-cells">
                    <div class="web-cell">
                        <div class="web-cell__bd">
                            <p class="fr14 cl_b3"><?php echo $item['shop_name']; ?> <?php echo $item['shop_phone']; ?></p>
                            <p class="fr12 cl_b9 mtr5"><?php echo $item['address_location'].$item['address_details']; ?></p>
                        </div>
                    </div>
                    <div class="web-cell">
                        <div class="web-cell__ht">
                            <input type="radio" <?php if($item['default_select']==1){echo 'checked';} ?>  data-sel="<?php echo $item['default_select']==1?1:0; ?>" value="<?php echo $item['id']; ?>" class="web-radio closeInput mr5 select-default" id="x<?php echo $i; ?>" name="radio" >
                            <label for="x<?php echo $i; ?>" class="fr14" >默认地址</label>
                        </div>
                        <div class="web-cell__bd tr">
                            <a href="/?mod=weixin&v_mod=address&_index=_edit&id=<?php echo $item['id']; ?>&callback=<?php echo urlencode(_URL_); ?>" class="ml20 fr14 cl_b9"><i class="fa fa-edit mr5"></i>编辑</a>
                            <a href="javascript:;" onclick="del_address(this,<?php echo $item['id']; ?>)" class="ml20 fr14 cl_b9"><i class="fa fa-trash-o mr5"></i>删除</a>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            }
        }
        ?>
    </div>

    <div class="web-cart-error tc" id="more-add" style="display:<?php echo !$data || count($data)==$address_count?'none':'block'; ?>;">
        <p class="fr16 cl_b3">亲，最多可设置<?php echo $address_count; ?>个收货地址</p>
        <div class="mtr30 error-btn"><a href="?mod=weixin&v_mod=address&_index=_new&callback=<?php echo urlencode(_URL_); ?>">添加地址</a></div>
    </div>
</div>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
</body>
<script>
    function del_address(obj,id)
    {
        mui.confirm('确定要删除吗？','系统提示',function (res)
        {
            if(res.index)
            {
                $.ajax({
                    type:"post",
                    url:"<?php echo _URL_; ?>&_action=ActionDelAddress",
                    data:{id:id},
                    dataType:"json",
                    success:function (data)
                    {
                        mui.toast(data.msg);
                        if(data.code==0)
                        {
                            $(obj).parent().parent().parent().remove();
                            $("#more-add").show();
                            if($(".web-address-content").children().length<=0)
                            {
                                $(".web-cart-error").show();
                                $("#more-add").hide();
                            }
                        }
                    },
                    error:function ()
                    {

                    }
                });
            }
        });
    }


    $(".select-default").click(function ()
    {
        var that = $(this);
        var is_default = $(this).attr('data-sel');
        if(is_default==1)
        {
            return false;
        }
        var id = $(this).val();
        mui.confirm('确定要设为默认收货地址？','系统提示',function (res)
        {
            if(res.index)
            {
                $.ajax({
                    type:"post",
                    url:"<?php echo _URL_; ?>&_action=ActionSetDefault",
                    data:{id:id},
                    dataType:"json",
                    success:function (data)
                    {
                        mui.toast(data.msg);
                        if(data.code==0)
                        {
                            $(".select-default").attr('data-sel',0);
                            that.attr('data-sel',1);
                        }
                    },
                    error:function ()
                    {
                        mui.toast('请稍后再试');
                    }
                });
            }
        });
    })
</script>
</html>