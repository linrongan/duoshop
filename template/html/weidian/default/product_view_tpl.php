<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetShowProduct();
$attr = $obj->GetProductAttr($data['product_id']);
$colle = $obj->GetProductColle($data['product_id']);
$store=$obj->GetStore($data['store_id'],1);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['product_name']; ?></title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/swiper.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .mui-slider-indicator .mui-indicator{background:rgba(0,0,0,0.5); box-shadow: none;}
        .web-view-btn{position:fixed; top: 0; left: 0; padding:.5rem 3%; width: 100%; z-index:999; }
        .web-view-btn>a{width:1.5rem; height: 1.5rem; background:rgba(0,0,0,0.5); border-radius: 50%; text-align: center; line-height: 1.5rem;}
		.swiper-pagination{ bottom:10px; text-align:center; width:100%;}
		.swiper-pagination-bullet-active{background:white; }
		.swiper-pagination-bullet{width:5px; height:5px; margin:0 2px;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
	<script src="/template/source/default/js/swiper.min.js"></script>

</head>
<body >

<div class="mui-content">
     <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
                if(!empty($data['product_flash']))
                {
                    $product_flash = json_decode($data['product_flash']);
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
    

    <div id="pro-message">
        <div class="nameorshare">
            <div class="l-name fr14"><?php echo $data['product_name']; ?></div>
        </div>
        <div class="price-line">
            <span class="orange">
                ￥<?php echo $data['product_price']; ?></span>
            <span class="cl_b9 fr12">
                价格 <del>￥<?php echo $data['product_fake_price']; ?></del></span>
        </div>
        <div class="dtif-p fr12">
            <span class="cl_b9 tl">快递：0.00</span>
            <span class="cl_b9 tc">销量：<?php echo $data['product_sold']; ?>
                <?php echo $data['product_unit']; ?>
            </span>
            <span class="cl_b9 tr">
                <?php echo $data['ship_city']; ?>
            </span>
        </div>
        <div class="extend-info">
            <div class="arrow">
                <b class="aw a-r"></b>
            </div>
            <div class="guarantee">
                <?php
                if ($data['ship_fee']==0){?>
                    <div class="guarantee-item fr12"><i class="img"></i><span class="text">全场包邮</span></div>
                <?php } ?>
                <?php
                if ($data['ship_methed']==2)
                {?>
                    <div class="guarantee-item fr12"><i class="img"></i><span class="text">支持货到付款</span></div>
                <?php
                } ?>
                <?php
                if ($data['seven_return']==1)
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

    <div class="shop-mess">
        <p class="shop-mess-name cl_b3"><?php echo $store['store_name']; ?></p>
        <div class="shop-mess-box">
            <div class="sales fl">
                <div class="sales-volume">
                    <p class="red fr14"><?php echo $store['store_sold']; ?></p>
                    <p class="cl_b9 mtr5 fr12">总销售额</p>
                </div>
                <a href="#" class="shopBtn cl_b3 fr14">
                    <i class="icon icon-star"></i>
                    收藏店铺
                </a>
            </div>
            <div class="sales fl">
                <div class="sales-volume" style="border-right:none;">
                    <p class="red fr14"><?php echo $store['store_product']; ?></p>
                    <p class="cl_b9 mtr5 fr12">全部商品</p>
                </div>
                <a href="<?php echo WEBURL.'/'.$v_shop; ?>" class="shopBtn cl_b3 fr14"><i class="icon icon-shops"></i>进入店铺</a>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>

<div class="dt-content mtr10">
    <nav class="dt-nav">
        <a href="javascript:;" class="sel fr14 cl_b3">图文详情</a>
        <a href="javascript:;" class="fr14 cl_b3">商品参数</a>
        <a href="javascript:;" class="fr14 cl_b3">商品推荐</a>
    </nav>
    <div class="dt-con">
        <div class="dt-con-item">
            <?php echo $data['product_text']; ?>
        </div>
        <div class="dt-con-item">
            <ul class="dtp-ul fr12">
                <li>
                    <label>厚薄</label>
                    <span class="omit">常规</span>
                </li>
            </ul>
        </div>
        <div class="dt-con-item">

            <div class="web-yp-product  mtr10">
                <ul class="web-yp-list">
                    <li class="web-yp-item">
                        <a href="javascript:">
                            <img data-lazyload="/template/source/default/images/web_yp_1.jpg" src="/template/source/default/images/web_yp_1.jpg" class="web-yp-img lazy">
                            <div class="web-yp-body">
                                <h1 class="omit fr14 cl_b3">时尚休闲男用包包时尚休闲男用包包</h1>
                                <div class="fr14 mtr5">
                                    <div class="fl red">
                                        ￥<span class="fr18">257</span>.00
                                    </div>
                                    <div class="fr cl_b9">
                                        <del>￥360.00</del>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="web-yp-item">
                        <a href="javascript:">
                            <img data-lazyload="/template/source/default/images/web_yp_2.jpg" src="/template/source/default/images/web_yp_2.jpg" class="web-yp-img lazy">
                            <div class="web-yp-body">
                                <h1 class="omit fr14 cl_b3">时尚休闲女装时尚休闲女装</h1>
                                <div class="fr14 mtr5">
                                    <div class="fl red">
                                        ￥<span class="fr18">257</span>.00
                                    </div>
                                    <div class="fr cl_b9">
                                        <del>￥360.00</del>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="web-yp-item">
                        <a href="javascript:">
                            <img data-lazyload="/template/source/default/images/web_yp_3.jpg" src="/template/source/default/images/web_yp_3.jpg" class="web-yp-img lazy">
                            <div class="web-yp-body">
                                <h1 class="omit fr14 cl_b3">原木纯品清风抽纸原木纯品清风抽纸...</h1>
                                <div class="fr14 mtr5">
                                    <div class="fl red">
                                        ￥<span class="fr18">257</span>.00
                                    </div>
                                    <div class="fr cl_b9">
                                        <del>￥360.00</del>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="web-yp-item">
                        <a href="javascript:">
                            <img data-lazyload="/template/source/default/images/web_yp_4.jpg" src="/template/source/default/images/web_yp_4.jpg" class="web-yp-img lazy">
                            <div class="web-yp-body">
                                <h1 class="omit fr14 cl_b3">精品夏日休闲女装精品夏日休闲女装</h1>
                                <div class="fr14 mtr5">
                                    <div class="fl red">
                                        ￥<span class="fr18">257</span>.00
                                    </div>
                                    <div class="fr cl_b9">
                                        <del>￥360.00</del>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>






    <div style="height:2.5rem; "></div>
    <div id="proFooter">
        <a href="http://wpa.qq.com/msgrd?V=1&uin=123456&exe=qq&Site=qq&menu=yes" class="cl_b9">
            <i class="icon icon-cs"></i>
            <span class="profooter-b-n fr12">客服</span>
        </a>
        <a href="javascript:;" onclick="shouchange(this,<?php echo $data['product_id']; ?>)" class="cl_b9">
            <i class="icon icon-star<?php echo $colle?1:2; ?>"></i>
            <span class="profooter-b-n fr12"><?php echo $colle?'已':''; ?>收藏</span>
        </a>
        <a href="/?mod=weixin&v_mod=cart" class="cl_b9">
            <i class="icon icon-shopb"></i>
            <span class="profooter-b-n fr12">购物车</span>
        </a>

        <a href="javascript:;" class="shopping-cart fr14">
            加入购物车
        </a>
        <a href="javascript:;" class="purchase fr14">
            立即购买
        </a>
        <div class="clearfix"></div>
    </div>


<!-----产品信息填写框---------->

<div id="Bgcon"></div>
<div id="product_fill_box">
    <div class="fill_box_head">
        <div class="fill_box_head_img"><img src="/template/source/default/images/TB1TLpSKpXXXXXVXpXXXXXXXXXX_!!0-item_pic.jpg" title="" alt=""></div>
        <div class="fill_box_head_mess">
            <p class="price"><span class="fr16">￥<?php echo $data['product_price']; ?></span></p>
            <p class="stock"><span class="fr12">库存:<?php echo $data['product_sold']; ?></span></p>
            <p class="size"><span class="fr12">请选择尺码</span></p>
        </div>
        <a href="javascript:;" id="close"><span class=" fa fa-close fr16 cl_b3"></span></a>
    </div>
    <div class="fill_box_content">
        <?php
        if($attr)
        {
            foreach($attr as $val)
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
                                <a href="javascript:;" attr_id="<?php echo $val['attr'][$i]['id'];  ?>" class="<?php if($i==0){echo 'select-active';} ?>"><?php echo $val['attr'][$i]['attr_temp_name']; ?></a>
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
      <!--  <div class="fill_box_item">
            <p class="fill_box_item_title fr14">颜色</p>
            <div class="fill_box_item_number">
                <a href="javascript:;" class="fr14 white">白色</a>
                <a href="javascript:;" class="fr14 white">黑色</a>
                <a href="javascript:;" class="fr14 white">绿色</a>
            </div>
        </div>-->
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
        <a href="javascript:;" class="left add-cart fr14">加入购物车</a>
        <a href="javascript:;" class="right add-cart fr14">立即购买</a>
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
        autoplayDisableOnInteraction : false,
    });
    $(function(){
        var gindex = $(".guarantee .guarantee-item").length;
        for(var i = 0; i < gindex ; i++){

            if(i > 2){
                $(".guarantee .guarantee-item").eq(i).hide();
            }

        }

        $(".extend-info").click(function(){
            $(this).children(".arrow").hide();
            $(this).children(".guarantee").children(".guarantee-item").show();
        });


        $(".dt-con .dt-con-item:first-child").show();
        $(".dt-nav a").click(function(){

            $(this).addClass("sel").siblings().removeClass("sel");;
            var _index = $(this).index();
            $(".dt-con .dt-con-item").eq(_index).show().siblings().hide();
        });


        $(".select-btn").click(function(){

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

        });
        $("#close").click(function(){

            $("#Bgcon").fadeOut();
            $("#product_fill_box").slideUp(300);

        })
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

    function shouchange(obj,id)
    {
        $.ajax({
            type:"get",
            url:"/?mod=weidian&v_mod=product&_index=_view&id="+id+"&v_shop=<?php echo $_GET['v_shop']; ?>&_action=ActionColleProduct",
            dataType:"json",
            success:function (data) 
            {
                mui.toast(data.msg);
                if(data.code==0)
                {
                    if(data.dz==1)
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
            error:function (data) {
                
            }
        });
    }



     $('.fill_box_item').each(function()
     {
         $(this).find('.fill_box_item_number').children().click(function(){
             if($(this).hasClass('select-active')){
                 return false;
             }else{
                 $(this).addClass('select-active').siblings().removeClass('select-active');
             }
         });
     });


     //获取选中的属性
     function CheckSel()
     {
         var is_attr = <?php echo $attr?1:0; ?>;
         if(is_attr==1)
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
                 mui.toast('请选择属性');
                 return false;
             }
             return attr;
         }
     }

    $(".add-cart").click(function ()
    {

        var attr_id = '';
        if('<?php echo count($attr)?1:0; ?>')
        {
            attr_id = CheckSel();
        }
        console.log(attr_id);
        var product_count = $("#product_count").val();
        if(product_count=='' || isNaN(product_count) || product_count<=0)
        {
            return false;
        }
        var data = {
            attr_id:attr_id,
            product_count:product_count
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
                    $("#product_count").val(1);
                    $("#Bgcon").hide();
                    $("#product_fill_box").hide();
                }
            },
            error:function () {
                alert('网络超时');
            }
        });
    });
</script>
</body>
</html>