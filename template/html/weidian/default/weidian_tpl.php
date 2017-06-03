<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$product = $obj->GetProduct();
$choice = $obj->GetChoiceProduct();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_store_name; ?></title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
     <link rel="stylesheet" href="/template/source/default/css/swiper.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css?99999999">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <style>
		.web-header-seach{background:white; border-bottom:1px solid #ededed;}
		.web-header-seach>a{color:#333;}
		.web-seach-box{background:#f6f6f6;}
        .mui-slider-indicator .mui-indicator{background:rgba(0,0,0,0.5); box-shadow: none;}
        .mui-table-view.mui-grid-view .mui-table-view-cell{}
        /*.mui-table-view-cell>a:not(.mui-btn){display:-webkit-box; -webkit-box-align: center; -webkit-box-pack: center;}*/
        .mui-table-view.mui-grid-view .mui-table-view-cell .mui-media-object{height:4.5rem; width:auto; }
        .mui-search .mui-placeholder{font-size: 12px; height:30px; line-height:30px;}
        input[type=search]{background:none; font-size: 12px;}
		body{-webkit-overflow-scrolling:auto;}
		.mui-search .mui-placeholder .mui-icon{font-size:16px;}
		.mui-search.mui-active:before{font-size:16px; margin-top:-9px; }
		.mui-input-row.mui-search .mui-icon-clear{top:5px;}
		input[type=search]{height:30px; margin-bottom:0;}
		.coupon-box{padding: .4rem 3%; background:white;  }
        .coupon-list .swiper-slide{width:40%;}
        .coupon-quan{display:block; width:100%; height:60px; background:#fd535e; display:block; border-radius:5px; padding:5px 10px; position:relative;}
        .coupon-quan::before{content:''; width:8px; height:8px; background:white; border-radius:50%; position:absolute; left:-4px; top:50%; margin-top:-4px;}

        .coupon-quan::after{content:''; width:8px; height:8px; background:white; border-radius:50%; position:absolute; right:-4px; top:50%; margin-top:-4px;}

        .coupon-quan .coupon-btn{color:white; padding:0px 5px; border:1px solid white; border-radius:3px; position:absolute; right:10px; top:50%; margin-top:-8px;}
            .web-jx-title{    padding: .4rem 3% 0; border-bottom:none;}
            .web-jx-title::after{    margin-top: -.2rem;}

    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body id="pullrefresh" class="mhome" >
<div class="mui-content">
<div id="slider" class="mui-slider" >
    <div class="mui-slider-group mui-slider-loop">
        <?php
        $ad=$obj->GetCommAd('DESC',3,0);
        if (!empty($ad))
        {
           $last_ad=count($ad)-1;
        ?>
        <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
        <div class="mui-slider-item mui-slider-item-duplicate">
            <a title="<?php echo $ad[0]['title']; ?>" href="<?php echo $ad[0]['page_url']; ?>">
                <img src="<?php echo $ad[0]['img']; ?>">
            </a>
        </div>
        <?php
            foreach($ad as $item){?>
        <!-- 第一张 -->
        <div class="mui-slider-item">
            <a title="<?php echo $item['title']; ?>" href="<?php echo $item['page_url']; ?>">
                <img src="<?php echo $item['img']; ?>">
            </a>
        </div>
            <?php } ?>
        <?php 
        ?>
        <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
        <div class="mui-slider-item mui-slider-item-duplicate">
            <a title="<?php echo $ad[$last_ad]['title']; ?>" href="<?php echo $ad[$last_ad]['page_url']; ?>">
                <img src="<?php echo $ad[$last_ad]['img']; ?>">
            </a>
        </div>
        <?php } ?>
    </div>
    <!--
    <div class="mui-slider-indicator">
        <div class="mui-indicator mui-active"></div>
        <div class="mui-indicator"></div>
        <div class="mui-indicator"></div>
    </div>
    -->
</div>


<?php
$menu=$obj->GetCommAd('DESC',10,1);
if (!empty($menu))
{
?>
<div class="web-nav">
    <ul>
<?php foreach($menu as $item){?>
        <li>
            <a href="<?php echo $item['page_url']; ?>">
                <img src="<?php echo $item['img']; ?>" class="lazy" />
                <p class="cl_b9 omit fr12"><?php echo $item['title']; ?></p>
            </a>
        </li>
<?php } ?>
    </ul>
    <div class="cb"></div>
</div>
<?php } ?>


<?php
$pic=$obj->GetCommAd('DESC',3,2);
if (!empty($pic))
{
?>
    <div class="web-good-product bgF mtr10">
        <div class="web-good-left">
            <a href="<?php echo !empty($pic[0]['page_url'])?$pic[0]['page_url']:""; ?>">
                <img class="blockimg lazy" src="<?php echo !empty($pic[0]['img'])?$pic[0]['img']:"/template/source/default/images/pro_img_1.png"; ?>" >
            </a>
        </div>
        <div class="web-good-right">
            <div class="web-right_item">
                <a href="<?php echo !empty($pic[1]['page_url'])?$pic[1]['page_url']:""; ?>">
                    <img class="blockimg lazy" src="<?php echo !empty($pic[1]['img'])?$pic[1]['img']:"/template/source/default/images/pro_img_2.png"; ?>" >
                </a>
            </div>
            <div class="web-right_item">
                <a href="<?php echo !empty($pic[2]['page_url'])?$pic[2]['page_url']:""; ?>">
                    <img class="blockimg lazy" src="<?php echo !empty($pic[2]['img'])?$pic[2]['img']:"/template/source/default/images/pro_img_3.png"; ?>" >
                </a>
            </div>
        </div>
    </div>
<?php
} ?>





<?php
$coupon=$obj->GetStoreCoupon();
if (!empty($coupon)){?>
    <div class="coupon-box mtr10">
        <div class=" f14" style="line-height:23px; color:#fd535e"><img src="/template/source/weixin/images/couponq.png" style="display:inline-block; vertical-align:middle; margin-top:-5px; margin-right:5px; width:23px; height:23px;">领取优惠券</div>
        <div class="coupon-list mtr10">
            <!-- Swiper -->
            <div class="swiper-container" id="swiper-container-coupon">
                <div class="swiper-wrapper">
                    <?php
                    foreach($coupon as $item)
                    {?>
                        <div class="swiper-slide">
                            <a href="/?mod=weixin&v_mod=coupon&_index=_apply&id=<?php echo $item['coupon_key']; ?>" class="coupon-quan">
                                <div class="" >
                                    <h1 class="f14 fb white">￥<?php echo $item['coupon_money']; ?></h1>
                                    <p class="f12 white">满<?php echo $item['min_money']; ?>立减</p>
                                    <p class="f12 white"><?php echo date("Y.m.d",strtotime($item['end_time'])); ?>过期</p>
                                </div>
                                <div class="coupon-btn f12">领取</div>
                            </a>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



<div class="web-jx-product mtr10 bgF">
    <div class="web-jx-title">
        <p class="text fr14"><img src="/template/source/images/jingxuan.png" style="display:inline-block; vertical-align:middle; margin-top:-5px; margin-right:5px; width:23px; height:23px;">商家精选</p>
    </div>
    <div class="web-jx-slide">
		 <!-- Swiper -->
        <div class="swiper-container" id="jx-product">
            <div class="swiper-wrapper">
             <?php
                if($choice)
                {
                    foreach($choice as $val)
                    {
                        ?>
                            <div class="swiper-slide web-jx-item tc" >
                                <a href="<?php echo '/?mod=weixin&v_mod=product&_index=_view&id='.$val['product_id'].'&v_shop='.$v_shop.''; ?>">
                                    <img  src="/template/source/images/default.png" data-src="<?php echo $val['product_img']; ?>">
                                    <p class="red fr12">￥<span class="fr14"><?php echo $val['product_price']; ?></span></p>
                                    <p class="fr12 cl_b9"><del>￥<?php echo $val['product_fake_price']; ?></del></p>
                                </a>
                            </div>
                        <?php
                    }
                }
            ?>
            </div>
        </div>
	</div>
</div>


<div class="web-yp-title mtr15 tc">
    <span class="fr14"><i class="mr5 web-icon web-icon-huo "></i>商品优选</span>
</div>

<div class="web-yp-product  mtr10">
    <ul class="web-yp-list">
        <?php
            if($product['data'])
            {
                foreach($product['data'] as $item)
                {
                    ?>
                    <li class="web-yp-item">
                        <a href="<?php echo '/?mod=weixin&v_mod=product&_index=_view&id='.$item['product_id'].'&v_shop='.$v_shop.''; ?>">
                            <img  src="/template/source/images/default.png" data-src="<?php echo $item['product_img']; ?>" class="web-yp-img lazy">
                            <div class="web-yp-body">
                                <h1 class="omit fr14 cl_b3"><?php echo $item['product_name']; ?></h1>
                                <div class="fr14 mtr5">
                                    <div class="fl red">
                                        ￥<span><?php echo $item['product_price']; ?></span>
                                    </div>
                                    <div class="fr cl_b9">
                                        <del>￥<?php echo $item['product_fake_price']; ?></del>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php
                }
            }
        ?>
    </ul>
    <div class="cb"></div>
</div>
</div>

<!--头部搜索框-->
<form method="post" action="/?mod=weidian&v_mod=search&_action=Search&v_shop=<?php echo $v_shop; ?>">
<div class="web-header-seach">
    <a href="javascript:;"  style="background:url(<?php echo $_xml_array->logo; ?>) center center no-repeat; background-size: 28px 28px;">
 
    </a>
        <div class="web-seach-box">
            <div class="mui-input-row mui-search fr14">
                <input type="search" name="search" required class="mui-input-clear" placeholder="请输入商品名称">
            </div>
        </div>

    <a href="/?mod=weixin&v_mod=notice" class="web-header-message tc white">
        <i class="fa fa-commenting-o"></i>
        <p class="f12 cl_b3">消息</p>
    </a>
</div>
</form>
<!----底部导航---->
<?php include "footer_tpl.php"; ?>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/swiper.min.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script src="/template/source/js/fastclick.js"></script>
<script src="/template/source/js/lazy-load-img.min.js"></script>
<script>


	  var swiper = new Swiper('#jx-product', {
      
			slidesPerView: 'auto',
			spaceBetween: 10,
			freeMode: true
		});

		var swiper4 = new Swiper('#swiper-container-coupon', {
			slidesPerView: 'auto',
			spaceBetween: 10,
			freeMode: true	
		});
		






    mui("#slider").slider({
        interval: 3000
    });


 



	/*
    window.onscroll = function () {
        var t = document.documentElement.scrollTop || document.body.scrollTop;
        var hs = document.documentElement.offsetHeight || document.body.offsetHeight;
        var h = document.getElementById('slider').clientHeight;
        var bg = document.getElementsByClassName('web-header-seach')[0];
        if(t > h){
            bg.style.background = '#ff464e'
        }
        else{
            bg.style.cssText = '';
        }
    };
*/

    layui.use('flow', function()
    {
        var flow = layui.flow;
        var pages = <?php echo $product['pages']; ?>;
        if(pages<=0){return false;}
        flow.load({
            elem: '.web-yp-list' //指定列表容器
            ,done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
                var lis = [];
                //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
                $.getJSON('/<?php echo $v_shop; ?>?page='+page, function(res){
                    //假设你的列表返回在data集合中
                    layui.each(res.data, function(index, item)
                    {
                        lis.push('<li class="web-yp-item">');
                        lis.push('<a href="/?mod=weixin&v_mod=product&_index=_view&id='+item.product_id+'&v_shop=<?php echo $_GET['v_shop']; ?>">');
                        lis.push('<img  src="/template/source/images/default.png" data-src="'+item.product_img+'" class="web-yp-img lazy">');
                        lis.push('<div class="web-yp-body">');
                        lis.push('<h1 class="omit fr14 cl_b3">'+item.product_name+'</h1>');
                        lis.push('<div class="fr14 mtr5">');
                        lis.push('<div class="fl red">');
                        lis.push('￥<spans>'+item.product_price+'</span>');
                        lis.push('</div>');
                        lis.push('<div class="fr cl_b9">');
                        lis.push('<del>￥'+item.product_fake_price+'</del>');
                        lis.push('</div>');
                        lis.push('<div class="cb"></div>');
                        lis.push('</div>');
                        lis.push('</div>');
                        lis.push('</a>');
                        lis.push('</li>');
                    });
                    next(lis.join(''), page < res.pages);
                });
            }
        });
    });
</script>
<script src="/template/source/js/guageEdit.js"></script>
</body>
</html>