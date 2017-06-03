<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetHomeData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo WEBNAME; ?></title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/jquery-weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/rest.css?66666">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/main.css?99999aaa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/newmain.css?1010aaa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/ggPublic.css?1111111aa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/moban1.css?777777">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <style>
       .swiper-pagination{width:100%; bottom:5px;}
		.swiper-pagination-bullet{width:.25rem; height:.25rem; margin:0 .125rem; background:#000;}
		.swiper-pagination-bullet-active{background-color:#FFF;}
		.swiper-wrapper-news .swiper-slide{width:100%;  line-height:25px;}
		.swiper-wrapper-news .swiper-slide>a{display:block;}
		.web-header-seach{top:0;}
		.web-seach-box{margin:4px .5rem 0 0; width:85%;}
		.ry-search{width:100%; height:30px; border:none; border-radius:3px; font-size:12px; padding:0 5%;}
		.weui-icon-clear, .weui-icon-search{font-size:13px;}
		.weui-search-bar{background:white;}
		.weui-search-bar__label span{font-size:12px; margin-bottom:-7px;}
		.weui-search-bar__box .weui-search-bar__input{padding:5px 0 !important;}
		.weui-search-bar__label .weui-icon-search{margin-right:0; margin-bottom:-7px;}
		.weui-search-bar__box .weui-search-bar__input{font-size:12px;}
		.weui-search-bar__box .weui-icon-search{line-height:24px; top:2px;}
		.web-jx-title .text{ background: url(/template/source/ruoywyt/images/moban-qiang_title_01.jpg) left center no-repeat; background-size: auto 90%;}
		.web-jx-time{width:50%; left:35%;}
		.category-select{height:25px; line-height:25px; color:white; position:relative;}
		.category-warp{position:absolute; top:27px; left:0;  -webkit-transition:all .6s; transition:all .6s;}
		.category-up{position:absolute; left:20px; top:-15px; color:#333; font-size:16px;}
		.category-list{ width:90px; min-height:30px; background:rgba(0,0,0,0.6); border-radius:5px; text-align:left;}
		.category-list>li{height:30px; line-height:30px; border-bottom:1px solid white; color:white; font-size:12px; padding:0 5%;}
		.category-list>li:last-child{border-bottom:none;}
		.icon{width:15px; height:15px; display:inline-block; vertical-align:middle; margin-top:-2px; margin-right:10px;}
		.icon-baobei{background:url(/template/source/weixin/images/product.png) center center no-repeat; background-size:100%;}
		.icon-dianpu{background:url(/template/source/weixin/images/shop.png) center center no-repeat; background-size:100%;}
		.visHide{opacity:0; visibility:hidden;}
		.visShow{opacity:1; visibility:inherit;}
		.web-yp-product>ul>li{ margin-bottom:.25rem;}
		
    </style>
</head>
<body class="mhome">
<div class="content" >
	<div class="web-header-seach">
        <div class="web-seach-box">
            <form action="/?mod=weixin&v_mod=search&_action=Search"  method="post">
            	<input type="hidden" name="search_type" value="1">
            	<div class="fl category-select tc" style="width:25%;">
        			<span class="">宝贝</span><i class="fa fa-caret-down ml5"></i>
                    <div class="category-warp visHide">
                    	<div class="category-up"><i class="fa fa-caret-up"></i></div>
                    	<ul class="category-list">
                            <li class="category-list-item">
                                <i class="icon icon-baobei"></i><span>宝贝</span>
                            </li>
                            <li class="category-list-item">
                                <i class="icon icon-dianpu"></i><span>店铺</span>
                            </li>
                        </ul>
                    </div>
        		</div>
                <div class="weui-search-bar fl" id="searchBar" style="width:75%">
                    <div class="weui-search-bar__box">
                        <i class="weui-icon-search"></i>
                        <input type="search" name="search" value="<?php  echo isset($_REQUEST['search'])?$_REQUEST['search']:""?>" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required>
                        <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                    </div>
                    <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                        <i class="weui-icon-search"></i>
                        <span>搜索您想要的产品</span>
                    </label>
                </div>
            </form>
        </div>

        <a href="?mod=weixin&v_mod=notice" class="web-header-message tc white">
            <i class="fa fa-commenting-o"></i>
            <p class="f12 white">消息</p>
        </a>
    </div>
	 <!-- Swiper -->
    <div class="swiper-container" id="swiper-container-banner">
        <div class="swiper-wrapper">
            <?php
                if($data['banner'])
                {
                    foreach($data['banner'] as $val)
                    {
                        ?>
                        <div class="swiper-slide">
                            <a title="<?php echo $val['picture_title']; ?>" href="<?php echo $val['picture_link']; ?>">
                                <img src="/template/source/images/default.png" data-src="<?php echo $val['picture_img']; ?>" style="width:100%; height:7.5rem; display:block;">
                            </a>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination" id="swiper-pagination-banner"></div>
    </div>
    <div class="web-nav">
        <ul>
            <?php
                if(!empty($data['nav']))
                {
                    foreach($data['nav'] as $item)
                    {
                        ?>
                        <li>
                            <a href="<?php echo $item['nav_link']; ?>">
                                <img src="/template/source/images/default.png" data-src="<?php echo $item['nav_img']; ?>" class="lazy">
                                <p class="cl_b9 omit fr12"><?php echo $item['nav_name']; ?></p>
                            </a>
                        </li>
                        <?php
                    }
                }
            ?>
        </ul>
        <div class="cb"></div>
    </div>
	<div class="moban-news mtr10">
    	<div class="moban-news_title">
        	<i class="moban-news_text"></i>
        </div>
    	<div class="moban-news_icon">
        	<i class="moban-news_laba"></i>
        </div>
        <div class="moban-news_list">
        	<!-- Swiper -->
            <div class="swiper-container" id="swiper-container-news">
                <div class="swiper-wrapper swiper-wrapper-news">
                    <?php
                        if($data['notice'])
                        {
                            foreach($data['notice'] as $val)
                            {
                                ?>
                                <div class="swiper-slide  swiper-no-swiping">
                                    <a href="<?php echo $val['notice_link']; ?>" class="fr12 omit"><?php echo $val['notice_title']; ?></a>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($data['coupon'])){?>
	<div class="coupon-box mtr10">
    	<div class=" f14" style="line-height:23px; color:#fd535e"><img src="/template/source/weixin/images/couponq.png" style="display:inline-block; vertical-align:middle; margin-top:-5px; margin-right:5px; width:23px; height:23px;">领取优惠券</div>
        <div class="coupon-list mtr10">
             <!-- Swiper -->
            <div class="swiper-container" id="swiper-container-coupon">
                <div class="swiper-wrapper">
                    <?php
                    foreach($data['coupon'] as $item)
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
    <!--@秒杀-->
    <?php
        if($data['seckill'])
        {
            ?>
            <div class="web-jx-product mtr10 bgF">
                <div class="web-jx-title" onclick="location.href='/?mod=weixin&v_mod=seckill'">
                    <i class="text"></i>
                    <div class="web-jx-time fr12">
                    	
                    </div>
                </div>
                <div class="web-jx-slide tc">
                    <!-- Swiper -->
                    <div class="swiper-container" id="swiper-container-slide">
                        <div class="swiper-wrapper" id="sk-pro">
                            <?php
                                foreach($data['seckill']['data'] as $item)
                                {
                                    ?>
                                    <div class="swiper-slide  web-jx-item">
                                        <a href="?mod=weixin&v_mod=product&_index=_view&id=<?php echo $item['product_id']; ?>">
                                            <img src="<?php echo $item['product_img']; ?>" data-src="<?php echo $item['product_img']; ?>">
                                            <p class="red fr14">￥<span class="f14"><?php echo $item['seckill_price']; ?></span></p>
                                            <p class="fr12 cl_b9"><del>￥<?php echo $item['product_price']; ?></del></p>
                                        </a>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    ?>

    <div class="ping-product">
    	<ul>
            <?php
                if(!empty($data['group']))
                {
                    foreach($data['group'] as $item)
                    {
                        ?>
                        <li>
                            <a href="?mod=weixin&v_mod=product&_index=_view&id=<?php echo $item['product_id']; ?>">
                                <img src="/template/source/images/default.png" data-src="<?php echo $item['product_img']; ?>" style="width:100%; height:16rem; display:block;">
                                <p class="fr14 tlie cl_b3" style="padding:10px 10px 0;"><?php echo $item['product_name']; ?></p>
                                <div style="padding:10px;">
                                    <div class="fl"><b class="red fr16">￥<?php echo $item['group_price']; ?></b><span class="fr12 cl_b9 ml5">已团<?php echo $item['group_sold']; ?>件</span></div>
                                    <div class="fr ping-btn fr12">去开团 <i class="fa fa-chevron-right ml5"></i></div>
                                    <div class="cb"></div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                }
            ?>
        </ul>
    </div>

	<div class="floor-title">
    	<img src="/template/source/default/images/578de9fcNb59b6153.png!q70.jpg">
    </div>
	<div class="moban-product">

    	<div class="moban-product-two">
        	<ul>
                <?php $pic = $obj->GetHomeTopBanner(1,7);?>
                <?php
                    if(!empty($pic))
                    {
                       for($i=0;$i<4;$i++)
                       {
                           if(isset($pic[$i]))
                           {
                               ?>
                               <li>
                                   <a href="?mod=weixin&v_mod=active&id=<?php echo $pic[$i]['id'];?>">
                                       <i style="background-image:url(<?php echo $pic[$i]['picture_img'];?>); background-size:100% 100%;"></i>
                                   </a>
                               </li>
                                <?php
                           }
                       }
                    }
                ?>
            </ul>
        	<div class="cb"></div>
        </div>

        <div class="moban-product-three">
        	<ul>
                <?php
                if($i>=4)
                {
                    for($i=4;$i<7;$i++)
                    {
                        if(isset($pic[$i]))
                        {
                            ?>
                            <li>
                                <a href="?mod=weixin&v_mod=active&id=<?php echo $pic[$i]['id'];?>">
                                    <i style="background-image:url(<?php echo $pic[$i]['picture_img'];?>); background-size:100% 100%;"></i>
                                </a>
                            </li>
                        <?php
                        }
                    }
                    unset($i);
                }
                ?>
            </ul>
            <div class="cb"></div>
        </div>
    </div>

    <div class="web-yp-title mtr10 tc">
        <span class="fr14"><i class="mr5 web-icon web-icon-huo "></i>精选店铺</span>
    </div>
	<div class="floor-shop mtr10">
    	<ul>
            <?php
                if($data['choice_shop'])
                {
                    foreach($data['choice_shop'] as $item)
                    {
                        ?>
                        <li>
                            <a href="/<?php echo $item['store_url']; ?>">
                                <strong class="graphic-tit fr14"><?php echo $item['store_name']; ?></strong>
                                <div class="shop-img mt5">
                                    <img  class="opa1" src="<?php echo $item['store_logo']; ?>"
                                          data-src="<?php echo $item['store_logo']; ?>">
                                    <div class="cb"></div>
                                    <p class="shop-name"><?php echo empty($item['store_describe'])?$item['store_name']:$item['store_describe']; ?></p>
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

    <div class="web-yp-title mtr15 tc">
        <span class="fr14"><i class="mr5 web-icon web-icon-huo "></i>精品推荐</span>
    </div>
    <div class="web-yp-product  mtr10">
        <ul class="web-yp-list">
            <?php
                if($data['choice_pro']['data'])
                {
                    foreach($data['choice_pro']['data'] as $item)
                    {
                        ?>
                        <li class="web-yp-item">
                            <a href="/?mod=weixin&v_mod=product&_index=_view&id=<?php echo $item['product_id']; ?>">
                                <img  src="<?php echo $item['product_img']; ?>" data-src="<?php echo $item['product_img']; ?>" class="web-yp-img lazy" style="height:7.8rem;">
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

<!----底部导航---->
<?php include RPC_DIR.'/template/html/weixin/comm/footer_tpl.php';?>
<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script src="/template/source/js/fastclick.js"></script>
<script src="/template/source/js/lazy-load-img.min.js"></script>




<script>

	var swiper = new Swiper('#swiper-container-banner', {
		pagination: '#swiper-pagination-banner',
		paginationClickable: true,
		autoplay:3000,
		autoplayDisableOnInteraction : false
	});
	
	
	 var swiper2 = new Swiper('#swiper-container-news', {
        direction: 'vertical',
		/*autoHeight: true,*/
		height:25,
		autoplay:3000,
		autoplayDisableOnInteraction : false,
		loop:true,
		noSwiping : true
    });
	
	
	
	
    var swiper3 = new Swiper('#swiper-container-slide', {
		slidesPerView: 'auto',
        spaceBetween: 10,
        freeMode: true
    });
	
	var swiper4 = new Swiper('#swiper-container-coupon', {
		slidesPerView: 'auto',
		spaceBetween: 10,
		freeMode: true	
    });
    
	


  
	  window.onscroll = function () {
        var t = document.documentElement.scrollTop || document.body.scrollTop;
        var hs = document.documentElement.offsetHeight || document.body.offsetHeight;
        var h = document.getElementById('swiper-container-banner').clientHeight;
        var bg = document.getElementsByClassName('web-header-seach')[0];
        if(t > h){
            bg.style.background = '#ff464e'
        }
        else{
            bg.style.cssText = '';
        }
    };
	
	
    $(function(){
	
		$(".category-select").on("click",function(){
			if($(this).children(".category-warp").hasClass("visHide")){
				$(this).children(".category-warp").removeClass("visHide").addClass("visShow");
			}else{
				$(this).children(".category-warp").removeClass("visShow").addClass("visHide");
			}
		});
		$(".category-list .category-list-item").on("click",function(event){
			$(".category-select>span").html($(this).children("span").text());
			if($(this).children("span").text() == '宝贝'){
				$("input[name='search_type']").attr('value','1')
			}else{
				$("input[name='search_type']").attr('value','2')
			}
			
			$(".category-select .category-warp ").removeClass("visShow").addClass("visHide");
			 event.stopPropagation();
		});
        var $searchBar = $('#searchBar'),
            $searchResult = $('#searchResult'),
            $searchText = $('#searchText'),
            $searchInput = $('#searchInput'),
            $searchClear = $('#searchClear'),
            $searchCancel = $('#searchCancel');

        function hideSearchResult(){
            $searchResult.hide();
            $searchInput.val('');
        }
        function cancelSearch(){
            hideSearchResult();
            $searchBar.removeClass('weui-search-bar_focusing');
            $searchText.show();
        }

        $searchText.on('click', function(){
            $searchBar.addClass('weui-search-bar_focusing');
            $searchInput.focus();
        });
        $searchInput.on('blur', function () {
                if(!this.value.length) cancelSearch();
            })
            .on('input', function(){
                if(this.value.length) {
                    $searchResult.show();
                } else {
                    $searchResult.hide();
                }
            });
        $searchClear.on('click', function(){
            hideSearchResult();
            $searchInput.focus();
        });
        $searchCancel.on('click', function(){
            cancelSearch();
            $searchInput.blur();
        });
    });

    //商品分页
    layui.use('flow', function(){
        var flow = layui.flow;
        flow.load({
            elem: '.web-yp-list' //指定列表容器
            ,done: function(page, next)
            {
                var lis = [];
                $.getJSON('<?php echo $_SERVER['REQUEST_URI']; ?>&page='+page, function(res)
                {
                    layui.each(res.data, function(index, item)
                    {
                        lis.push('<li class="web-yp-item">' +
                            '<a href="/?mod=weixin&v_mod=product&_index=_view&id='+item.product_id+'">' +
                            '<img  src="'+item.product_img+'" data-src="'+item.product_img+'" class="web-yp-img lazy" style="height:7.8rem;">' +
                            '<div class="web-yp-body">' +
                            '<h1 class="omit fr14 cl_b3">'+item.product_name+'</h1>'+
                            '<div class="fr14 mtr5">'+
                            '<div class="fl red">' +
                            '￥<span>'+item.product_price+'</span>' +
                            '</div>' +
                            '<div class="fr cl_b9">' +
                            '<del>￥'+item.product_fake_price+'</del>' +
                            '</div>' +
                            '<div class="cb"></div>'+
                            '</div>'+
                            '</div>'+
                            '</a>'+
                            '</li>');
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