<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetProductViewData();
if($data['product']['product_status'])
{
    redirect('?mod=weixin&v_mod=product&_index=_out_view&id='.$_GET['id']);
}
include  RPC_DIR.'/module/mobile/weixin/jsapi.php';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$weburl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$wxshare=new jsapi(array());
$array=$wxshare->config($weburl);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['product']['product_name']; ?></title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/swiper.min.css">
    <link rel="stylesheet" href="/template/source/default/css/weui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css?888888888">
    <style>
        .mui-slider-indicator .mui-indicator{background:rgba(0,0,0,0.5); box-shadow: none;}
        .web-view-btn{position:fixed; top: 0; left: 0; padding:.5rem 3%; width: 100%; z-index:999; }
        .web-view-btn>a{width:1.5rem; height: 1.5rem; background:rgba(0,0,0,0.5); border-radius: 50%; text-align: center; line-height: 1.5rem;}
        .swiper-pagination{ bottom:10px; text-align:center; width:100%;}
        .swiper-pagination-bullet-active{background:white; }
        .swiper-pagination-bullet{width:5px; height:5px; margin:0 2px;}
		
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
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
    <script src="/template/source/default/js/swiper.min.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        var tTitle='<?php echo $data['product']['product_name']; ?>';
        var tContent='<?php echo $data['product']['product_desc']; ?>';
        window.shareData = {
            "imgUrl": "<?php echo WEBURL.$data['product']['product_img']; ?>",
            "sendFriendLink":"<?php echo WEBURL.'/?mod=weixin&v_mod=product&_index=_view&id='.$_GET['id'].'&share='.SYS_USERID; ?>",
            "tTitle": tTitle,
            "tContent": tContent
        };
        wx.config({
            debug:  false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '<?php echo $array['appId']; ?>', // 必填，公众号的唯一标识
            timestamp:<?php echo $array['timestamp']; ?>, // 必填，生成签名的时间戳
            nonceStr: '<?php echo $array['noncestr']; ?>', // 必填，生成签名的随机串
            signature:'<?php echo $array['signature']; ?>',// 必填，签名，见附录1
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]
        });

        wx.ready(function (){
            wx.onMenuShareAppMessage({
                title: window.shareData.tTitle,
                desc: window.shareData.tContent,
                link: window.shareData.sendFriendLink,
                imgUrl: window.shareData.imgUrl,
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function ()
                {

                },
                cancel: function ()
                {

                }
            });
            wx.onMenuShareTimeline({
                title: window.shareData.tTitle,
                link: window.shareData.sendFriendLink,
                imgUrl: window.shareData.imgUrl,
                success: function ()
                {

                },
                cancel: function ()
                {

                }
            });
        });
    </script>
</head>
<body >

<div class="mui-content">
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            if(!empty($data['product']['product_flash']))
            {
                $product_flash = json_decode($data['product']['product_flash']);
                for($i=0;$i<count($product_flash);$i++)
                {
                    ?>
                    <div class="swiper-slide">
                        <a href="javascript:;"><img src="<?php echo $product_flash[$i]; ?>" style="width:100%; height:auto; display:block;"></a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <div class="web-view-btn">
            <a href="javascript:;" class="mui-action-back white fl" style="background-image: url(/template/source/default/images/prev.png); background-size:contain"></a>
            <a href="/?mod=weixin&v_mod=cart" class="white fr" style="background-image: url(/template/source/default/images/cart.png); background-size:contain"></a>
            <div class="cb"></div>
        </div>
    </div>
    <?php
    if(!empty($data['quantum']))
    {
        ?>
        <div class="seckill-floor">
            <div class="seckil-price-wrap">
                <div class="seckill-price">
                    ¥ <span class="seckill-big-price"><?php echo $data['seckill_pro']['seckill_price']; ?></span>
                </div>
                <div class="seckill-btm-div">
                <span class="skf-icon-pos">
                    <i class="label-icon-div white-border have-icon-div">
                        <i class="label-icon seckill-floor-icon"></i>
                        <span class="label-text white-text"><?php echo $data['product']['store_name'];?>秒杀</span>
                    </i>
                </span>
                    <span class="skf-jdPrice">¥<?php echo $data['product']['product_price']; ?></span>
                </div>
            </div>
            <div class="seckil-time-wrap">
                <span class="seckil-time-title">距结束还剩:</span>
                <div class="seckill-time-div" id="seckill_time">
                    <span class="seckill-time-num">00</span>
                    <span class="seckill-time-colon">:</span>
                    <span class="seckill-time-num">00</span>
                    <span class="seckill-time-colon">:</span>
                    <span class="seckill-time-num">00</span>
                </div>
            </div>
        </div>
        <script>
            function n(count){
                if(count > 9){
                    return count
                }else{
                    return '0'+ count;
                }
            }
            var eValue = document.getElementById('seckill_time');
            var countDown = <?php echo strtotime($data['quantum']['end_time'])-strtotime(date("H:i:s",time())); ?>;
            var clean = setInterval(getRTime,1000);
            getRTime();
            function getRTime()
            {
                //var star_date = new Date();
                countDown = countDown - 1;
                var oDay =  Math.floor(countDown/(24*60*60));
                //alert(oDay);
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
                if(countDown > 0){
                    eValue.innerHTML = '<span class="seckill-time-num">'+n(oHours)+'</span>'
                        +'<span class="seckill-time-colon">:</span>'
                        + '<span class="seckill-time-num">'+n(oMinutes)+'</span>'
                        + '<span class="seckill-time-colon">:</span>'
                        + '<span class="seckill-time-num">'+n(oSeconds)+'</span>';
                }else{
                    eValue.innerHTML = '已结束';
                    $(".price-line").show();
                    clearInterval(clean);
                }
            }
        </script>
        <?php
    }
    if(!empty($data['is_group']))
    {
        ?>
        <div class="seckill-floor" style="margin-top: 0.2rem"
             onclick="location.href='?mod=weixin&v_mod=checkout&_index=_add_group&id=<?php echo $_GET['id'];?>'">
            <div class="seckil-price-wrap">
                <div class="seckill-price">
                    ¥ <span class="seckill-big-price"><?php echo $data['is_group']['group_price']; ?></span>
                </div>
                <div class="seckill-btm-div">
                <span class="skf-icon-pos">
                    <i class="label-icon-div white-border have-icon-div">
                        <i class="label-icon seckill-floor-icon"></i>
                        <span class="label-text white-text">已团<?php echo $data['is_group']['group_sold']; ?><?php echo $data['product']['product_unit']; ?>   <?php echo $data['is_group']['people_nums']; ?>人团进行中</span>
                    </i>
                </span>
                    <span class="skf-jdPrice">¥ <?php echo $data['product']['product_price']; ?></span>
                </div>
            </div>
            <div class="seckil-time-wrap">
              <span class="seckil-time-title" style="line-height:36px; font-size:16px;">一键拼团</span>
            </div>
        </div>
        <?php
    }
    ?>
    
    <div id="pro-message">
        <div class="nameorshare">
            <div class="l-name fr14"><?php echo $data['product']['product_name']; ?></div>
        </div>
        <div class="price-line" style="display:<?php echo $data['quantum']?'none':'block'; ?>">
            <span class="orange">
                ￥<label class="product_price"><?php echo $data['product']['product_price']; ?></label></span>
                  <span class="cl_b9 fr12">
                价格 <del>￥<?php echo $data['product']['product_fake_price']; ?></del></span>
         </div>

        <div class="dtif-p fr12">
            <span class="cl_b9 tl">快递：
                ￥<?php
                    if($data['product']['free_fee'])
                    {
                        echo $data['product']['product_price']>=$data['product']['free_fee_money']?'免运费':$data['product']['ship_fee_money'];
                    }else{
                        echo $data['product']['product_ship_fee']?$data['product']['ship_fee']:$data['product']['ship_fee_money'];
                    }
                ?>
            </span>
            <span class="cl_b9 tc">销量：<?php echo $data['product']['product_sold']; ?>
                <?php echo $data['product']['product_unit']; ?>
            </span>
            <span class="cl_b9 tr">
                库存：
                <label class="product_stock"><?php echo $data['product']['product_stock']; ?></label>
                <?php echo $data['product']['product_unit']; ?>
            </span>
        </div>


        <div class="extend-info">
            <div class="guarantee">
                <?php
                if ($data['product']['free_fee']==1 && $data['product']['free_fee_money']==0)
                {?>
                    <div class="guarantee-item fr12"><i class="img"></i><span class="text">全场包邮</span></div>
                <?php
                } ?>
                <?php
                if ($data['product']['ship_methed']==2)
                {?>
                    <div class="guarantee-item fr12"><i class="img"></i><span class="text">支持货到付款</span></div>
                    <?php
                } ?>
                <?php
                if ($data['product']['seven_return']==1)
                {?>
                    <div class="guarantee-item fr12"><i class="img"></i><span class="text">7天无条件退款</span></div>
                    <?php
                } ?>
                <div class="cb"></div>
            </div>
        </div>

    </div>

    <div class="select-btn">
        <p class="select-pro-sel fr12">请选择商品规格</p>
        <div class="arrow" style="right:3%">
            <b class="aw a-r"></b>
        </div>
    </div>
        <?php
            if($data['group_list'])
            {
                ?>
                <p class="fightNumber-title mt10">以下小伙伴已经开启了拼团，快来助攻</p>
                <div class="weui-cells figNumber-warp" style="margin-top:0;">
                <?php
                foreach($data['group_list'] as $item)
                {
                    ?>
                    <div class="weui-cell">
                        <div class="weui-cell__hd">
                            <img src="<?php echo $item['headimgurl']; ?>" style="width:45px; height:45px; border-radius:50%; display:block; margin-right:5px;">
                        </div>
                        <div class="weui-cell__bd">
                            <p class="" style="color:#333333;"><?php echo $item['nickname']; ?></p>
                            <div class="f12 mt5">
                                <p class="fl" style="color:#999; font-size:12px;">还差<?php echo $item['group_present_nums']; ?>人，</p>
                                <div class="fightNUmber-time fl" data-time="<?php echo strtotime($item['end_time'])-time(); ?>">
                                    剩余
                                    <span>00:</span>
                                    <span>00:</span>
                                    <span>00</span>
                                    <span style="color:#ff9600">.0</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="weui-cell__ft">
                            <div class="fightNumber-user-btn" onclick="location.href='/?mod=weixin&v_mod=group&_index=_buy&group_id=<?php echo $item['group_id']; ?>'">
                                去参团
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
        </div>
            <?php
            }
        ?>


    <div class="shop-mess mt10">
        <p class="shop-mess-name cl_b3"></p>
        <div class="shop-mess-box">
            <div class="sales fl">
                <div class="sales-volume">
                    <p class="red fr14 follow_count"><?php echo $data['product']['follow_count']; ?></p>
                    <p class="cl_b9 mtr5 fr12">关注</p>
                </div>
                <a href="javascript:;" data-status="1" onclick="follow_shop(this,<?php echo $data['product']['store_id']; ?>)" class="shopBtn cl_b3 fr14">
                    <?php
                        if($data['follow_shop'])
                        {
                            ?>
                            <i class="icon icon-star"></i>
                            取消关注
                            <?php
                        }else{
                            ?>
                            <i class="icon icon-star"></i>
                            关注店铺
                            <?php
                        }
                    ?>
                </a>
            </div>
            <div class="sales fl">
                <div class="sales-volume" style="border-right:none;">
                    <p class="red fr14">
                        <?php echo $data['product']['store_product']; ?>
                    </p>
                    <p class="cl_b9 mtr5 fr12">全部商品</p>
                </div>
                <a href="/<?php echo $data['product']['store_url']; ?>" class="shopBtn cl_b3 fr14"><i class="icon icon-shops"></i>进入店铺</a>
            </div>
            <div class="cb"></div>
        </div>
    </div>
    <div class="dt-content mtr10">
        <nav class="dt-nav" style="border-bottom:1px solid #ededed;">
            <a href="javascript:;" class="sel fr14 cl_b3">图文详情</a>
            <a href="javascript:;" class="fr14 cl_b3">商品参数</a>
        </nav>
        <div class="dt-con" style="margin-top:0;">
            <div class="dt-con-item">
                <?php echo $data['product']['product_text']; ?>
            </div>
            <div class="dt-con-item">
                <?php echo $data['product']['product_param']; ?>
            </div>
        </div>
    </div>
</div>

<div style="height:2.5rem; "></div>
<div id="proFooter">
    <?php
    if (!empty($data['product']['store_qq']))
    {
        ?>
        <a onclick="window.location.href='http://wpa.qq.com/msgrd?v=3&uin=<?php echo $data['product']['store_qq']; ?>&site=qq&menu=yes'" href="javascript:void(0)" class="cl_b9">
            <i class="icon icon-cs"></i>
            <span class="profooter-b-n fr12">客服</span>
        </a>
    <?php
    }else
    {?>
        <a onclick="window.location.href='/?mod=weixin&v_mod=user&_index=_feedback&store_id=<?php echo $data['product']['store_id']; ?>&site=qq&menu=yes'" href="javascript:void(0)" class="cl_b9">
            <i class="icon icon-cs"></i>
            <span class="profooter-b-n fr12">客服</span>
        </a>
    <?php
    }
    ?>

    <a href="javascript:;" onclick="colle(this,<?php echo $_GET['id']; ?>)" class="cl_b9">
        <i class="icon icon-star<?php echo $data['colle']?1:2; ?>"></i>
        <span class="profooter-b-n fr12"><?php echo $data['colle']?'已':''; ?>收藏</span>
    </a>
    <a href="/?mod=weixin&v_mod=cart" class="cl_b9">
        <i class="icon icon-shopb"></i>
        <span class="profooter-b-n fr12">购物车</span>
    </a>
    <a href="javascript:;" cl="cart" class="shopping-cart fr14">
        加入购物车
    </a>
    <a href="javascript:;" cl="cart-checkout" class="shopping-cart purchase fr14">
        立即购买
    </a>
    <div class="clearfix"></div>
</div>

<!-----产品信息填写框---------->
<div id="Bgcon"></div>
<div id="product_fill_box">
    <div class="fill_box_head">
        <div class="fill_box_head_img"><img src="<?php echo $data['product']['product_img']; ?>" title="" alt=""></div>
        <div class="fill_box_head_mess">
            <p class="price">
                <span class="fr16">￥<label class="product_price">
                    <?php if(!empty($data['quantum']))
                    {
                        echo $data['seckill_pro']['seckill_price'];
                    }
                    else
                    {
                        echo $data['product']['product_price'];
                    }
                    ?></label>
                </span>
            </p>
            <p class="stock"><span class="fr12">库存:<label class="product_stock"><?php echo $data['product']['product_stock']; ?></label><?php echo $data['product']['product_unit']; ?></span></p>
        </div>
        <a href="javascript:;" id="close"><span class=" fa fa-close fr16 cl_b3"></span></a>
    </div>
    <div class="fill_box_content">
        <div id="attr_box">
        <?php
        if($data['attr'])
        {
            foreach($data['attr'] as $val)
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
                                <a href="javascript:;" attr_price="<?php echo $val['attr'][$i]['attr_change_price'];  ?>" attr_stock="<?php echo $val['attr'][$i]['product_stock'];  ?>" attr_id="<?php echo $val['attr'][$i]['id'];  ?>"><?php echo $val['attr'][$i]['attr_temp_name']; ?></a>
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
        <div class="fill_box_item">
            <div class="fill_box_item_quantity">
                <p class="fill_box_item_title fl fr14" style="width:50%">数量</p>
                <div class="fr numbody">
                    <a href="javascript:;" class="numbody-btn numbody-reduce  fr14 ">
                        <i class="fa fa-minus"></i>
                    </a>
                    <input type="number" id="product_count" class="numbody-text fr12" onfocus="$(this).val('')" onblur="if($(this).val()==''){$(this).val(1)}" value="1">
                    <a href="javascript:;" class="numbody-btn numbody-plus  fr14 ">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

    </div>




    <div class="fill_box_btn">
        <a style="width: 100%;font-weight: bold" href="javascript:;" id="submit" class="left add-cart fr16">确定</a>
        <div class="clearfix"></div>
    </div>
</div>

<!------产品信息填写框--------->
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script>

    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay:3000,
        autoplayDisableOnInteraction : false
    });
    $(function(){
        var gindex = $(".guarantee .guarantee-item").length;
        for(var i = 0; i < gindex ; i++){
            if(i > 2)
            {
                $(".guarantee .guarantee-item").eq(i).hide();
            }
        }
        $(".extend-info").click(function(){
            $(this).children(".arrow").hide();
            $(this).children(".guarantee").children(".guarantee-item").show();
        });

        $(".dt-con .dt-con-item:first-child").show();
        $(".dt-nav a").click(function()
        {
            $(this).addClass("sel").siblings().removeClass("sel");
            var _index = $(this).index();
            $(".dt-con .dt-con-item").eq(_index).show().siblings().hide();
        });


        $(".select-btn").click(function(){
            $("#submit").attr('cl','cart');
            $("#Bgcon").fadeIn();
            $("#product_fill_box").slideDown(300);
        });


        $(".purchase").click(function(){

            $("#Bgcon").fadeIn();
            $("#product_fill_box").slideDown(300);

        });

        $(".shopping-cart").click(function(){
            $("#Bgcon").fadeIn();
            $("#product_fill_box").slideDown(300);
            $("#submit").attr('cl',$(this).attr('cl'));
        });
        $("#close").click(function(){

            $("#Bgcon").fadeOut();
            $("#product_fill_box").slideUp(300);
        });
        $("#Bgcon").click(function(){
            $(this).fadeOut();
            $("#product_fill_box").slideUp(300);
        });

        var sibVal =  $(this).find('.numbody-text').val();
        //加数
        $(".numbody").on('click','.numbody-plus',function(){
            $(this).siblings('.numbody-text').val(parseInt(++sibVal));
            if(sibVal > 1){
                $(this).siblings('.numbody-reduce').css('color','#ff464e')
            }else{
                $(this).siblings('.numbody-reduce').css('color','#999999')
            }
        });

        //减数
        $(".numbody").on('click','.numbody-reduce',function(){
            if(sibVal > 1){
                $(this).siblings('.numbody-text').val(parseInt(--sibVal));
                if(sibVal == 1){
                    $(this).css('color','#999999')
                }
            }else{
                $(this).siblings('.numbody-text').val(1)
            }
        });
    });

    function colle(obj,id)
    {
        $.ajax({
            type:"get",
            url:"/?mod=weixin&v_mod=product&_index=_view&id="+id+"&_action=ActionProductColle",
            dataType:"json",
            success:function (data)
            {
                mui.toast(data.msg);
                if(data.code==0)
                {
                    if(data.status==1)
                    {
                        $(obj).children().eq(0).removeClass('icon-star2');
                        $(obj).children().eq(0).addClass('icon-star1');
                        $(obj).children().eq(1).html('已收藏');
                    }else{
                        $(obj).children().eq(0).removeClass('icon-star1');
                        $(obj).children().eq(0).addClass('icon-star2');
                        $(obj).children().eq(1).html('收藏');
                    }
                }
            },
            error:function ()
            {
            }
        });
    }

    $('.fill_box_item').each(function()
    {
        $(this).find('.fill_box_item_number').children().click(function()
        {
            if($(this).hasClass('select-active'))
            {
                return false;
            }else
            {
                UpdateAttrData($(this).attr('attr_id'));
                $(this).addClass('select-active').siblings().removeClass('select-active');
            }
        });
    });

    //获取属性并更新库存和价格
    function UpdateAttrData(id)
    {
        $.ajax({
            type:"post",
            url:"<?php echo _URL_; ?>&_action=ActionGetNewAttrData",
            data:{"id":id},
            dataType:"json",
            async:false,
            success:function(res)
            {
                if(res.code==0)
                {
                    $(".product_stock").html(res.stock);
                    $(".product_price").html(res.price);
                }else
                {
                    mui.toast(res.msg);
                }
            },
            error:function () {
                alert('网络超时');
            }
        });
    }


    //获取选中的属性
    function CheckSel()
    {
        var attr = $('#attr_box').children().length;
        if(attr>0)
        {
            var attr = [];
            var sel = 0;
            var all_len = 0;    //减去  重复class
            $('.fill_box_item').each(function()
            {
                all_len++;
                $(this).find('.fill_box_item_number').children().each(function()
                {
                    if($(this).hasClass('select-active'))
                    {
                        attr.push($(this).attr('attr_id'));
                        sel++;
                    }
                });
            });
            if(all_len-1 !=sel)
            {
                return false;
            }
            return attr;
        }else
        {

        }
    }
    function p (n){
        return n < 10 ? '0'+ n : n;
    }

    $(".figNumber-warp .weui-cell").each(function(index,element)
    {
        var countDown = parseInt($(element).find(".fightNUmber-time").attr("data-time")) ;
        var ms = 10;
        function newTime(){
            //var star_date = new Date();
            ms--;
            if(ms==0)
            {
                countDown = countDown - 1;
                ms = 10;
            }
            var oDay =  Math.floor(countDown/(24*60*60));
            //alert(oDay);
            //获取小时数
            //特别留意 %24 这是因为需要剔除掉整的天数;
            var oHours = Math.floor(countDown/(60*60)%24);
            //获取分钟数
            //同理剔除掉分钟数
            var oMinutes = Math.floor(countDown/60%60);
            //获取秒数
            //因为就是秒数  所以取得余数即可
            var oSeconds = Math.floor(countDown%60);
            var myMS=Math.floor (countDown % 10);
            var html ="剩余 "+"<span>" + p(oHours) + ":</span>" + "<span>" + p(oMinutes) + ":</span>" +"<span>" + p(oSeconds)+"</span> <span style=\"color:#ff9600\">."+(ms)+"</span>";
            /*
             var html = myMS; */
            //别忘记当时间为0的，要让其知道结束了;
            if(countDown < 0){
                $(element).find(".fightNUmber-time").html("因人数不够，拼团失败");
            }else{
                $(element).find(".fightNUmber-time").html(html);
                $(element).find(".fightNUmber-time").attr("data-time")
            }
        }
        setInterval(newTime,100);
        newTime();
    });

    function add_cart(method)
    {
        var attr_id = '';
        if($('#attr_box').children().length>0)
        {
            attr_id = CheckSel();
            if (attr_id==false)
            {
                mui.toast('请选择商品的属性');
                return false;
            }
        }
        var product_count = $("#product_count").val();

        var min_buy = '<?php echo $data['product']['min_buy'];?>';
        var max_buy = '<?php echo $data['product']['max_buy'];?>';

        if(product_count=='' || isNaN(product_count) || product_count<=0)
        {
            mui.toast('请选择正确的数量');
            return false;
        }
        if(min_buy!=0 && product_count<min_buy)
        {
            mui.toast('最少采购'+min_buy+'个');
            return false;
        }
        if(max_buy!=0 && product_count>max_buy)
        {
            mui.toast('限购'+min_buy+'个');
            return false;
        }
        var data = {
            attr_id:attr_id,
            product_count:product_count,
            method:method
        };
        $.ajax({
            type:"post",
            url:"<?php echo _URL_; ?>&_action=ActionAddCart",
            data:data,
            dataType:"json",
            async:false,
            success:function (res) {
                mui.toast(res.msg);
                if(res.code==0)
                {
                    if(method=='cart')
                    {
                        $("#product_count").val(1);
                        $("#Bgcon").hide();
                        $("#product_fill_box").hide();
                    }else{
                        location.href='?mod=weixin&v_mod=checkout';
                    }
                }
            },
            error:function () {
                alert('网络超时');
            }
        });
    }


    $("#submit").click(function ()
    {
        var cl = $(this).attr('cl');
        var product_count = $("#product_count").val();

        switch (cl)
        {
            case 'cart':
            case 'cart-checkout':
                add_cart(cl);
                break;
            case 'create_group':
                location.href='?mod=weixin&v_mod=checkout&_index=_add_group';
                break;
            default:
                console.log('err');
                break;
        }
    });




    function follow_shop(obj,store_id)
    {
        var that = $(obj);
        if(!store_id || store_id<=0 || isNaN(store_id)){return;}
        if(that.hasClass('disabled')){return;}
        that.addClass('disabled');
        $.ajax({
            type:'post',
            url:'/?mod=weixin&v_mod=follow&_action=ActionFollowShop',
            data:{store_id:store_id},
            dataType:'json',
            success:function (data)
            {
                that.removeClass('disabled');
                if(data.code==0)
                {
                    if(data.type==1)
                    {
                        mui.toast('关注成功');
                        $(".follow_count").html(parseInt($(".follow_count").html())+1);
                        that.empty();
                        that.append('<i class="icon icon-star"></i>取消关注');
                    }else{
                        mui.toast('取消关注成功');
                        $(".follow_count").html(parseInt($(".follow_count").html())-1);
                        that.empty();
                        that.append('<i class="icon icon-star"></i>关注店铺');
                    }
                }else{
                    mui.toast(data.msg);
                }
            },
            error:function ()
            {
                that.removeClass('disabled');
            }
        });
    }

</script>
</body>
</html>
