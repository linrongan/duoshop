<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$product = $obj->GetProduct();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_template[$v_shop]['store_name']; ?></title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
     <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/default/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/default/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/default/css/rest.css">
    
    <link type="text/css" rel="stylesheet" href="/template/source/ruoywyt/css/newmain.css?1010aaa">
    <link type="text/css" rel="stylesheet" href="/template/source/default/css/main.css?1010100aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/ruoywyt/css/ggPublic.css?8888aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/ruoywyt/css/moban1.css?6666aaa">
    
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <style>
       .swiper-pagination{width:100%; bottom:5px;}
		.swiper-pagination-bullet{width:.25rem; height:.25rem; margin:0 .125rem; background:#000;}
		.swiper-pagination-bullet-active{background-color:#FFF;}
		.swiper-wrapper-news .swiper-slide{width:100%;  line-height:25px;}
		.swiper-wrapper-news .swiper-slide>a{display:block;}
		input[type=search]{background:rgba(255,255,255,.8);  margin-bottom:0px; font-size:12px;}
		.mui-search .mui-placeholder{font-size:12px;}
		.mui-search:before{margin-top:-12px;}
    </style>
   
    <!--<script src="js/jquery.lazyload.js"></script>
    <script type="text/javascript">
        $(function(){
            $("img.lazy").lazyload({
                placeholder : "images/60x60.jpg",
                effect      : "fadeIn",
                threshold : 0
            });
        });
    </script>-->
</head>
<body >
<div class="content" style="padding-top:2.1rem;">

	<div class="news-nav">
        <a href="javascript:;" class="fr12 news-active">首页</a>
        <a href="javascript:;" class="fr12">数码家电</a>
        <a href="javascript:;" class="fr12">服饰美妆</a>
        <a href="javascript:;" class="fr12">居家生活</a>
        <a href="javascript:;" class="fr12">美食厨房</a>
    </div>
	<div class="web-header-seach">
        <a href="javascript:;" class="web-header-logo">
    
        </a>
        <div class="web-seach-box">
        	<form>
                <div class="mui-input-row mui-search ">
                    <input type="search" class="mui-input-clear" placeholder="请输入商品名称">
                </div>
            </form>
        </div>
        <a href="http://duoshop.ruoyw.com/?mod=weidian&amp;v_mod=user&amp;_index=_message&amp;v_shop=ruoyw" class="web-header-message tc white">
            <i class="fa fa-commenting-o"></i>
            <p class="f12 white">消息</p>
        </a>
    </div>

	 <!-- Swiper -->
    <div class="swiper-container" id="swiper-container-banner">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="javascript:;"><img src="http://duoshop.ruoyw.com/template/source/default/images/3.jpg" style="width:100%; height:7.5rem; display:block;"></a></div>
           <div class="swiper-slide"><a href="javascript:;"><img src="http://duoshop.ruoyw.com/template/source/default/images/2.jpg" style="width:100%; height:7.5rem; display:block;"></a></div>
           <div class="swiper-slide"><a href="javascript:;"><img src="http://duoshop.ruoyw.com/template/source/default/images/1.jpg" style="width:100%; height:7.5rem; display:block;"></a></div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination" id="swiper-pagination-banner"></div>
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
                    <div class="swiper-slide"><a href="javascript:;" class="fr12 omit">若宇商城招商啦!!!</a></div>
                    <div class="swiper-slide"><a href="javascript:;" class="fr12 omit">若宇商城招商啦!!!1</a></div>
                    <div class="swiper-slide"><a href="javascript:;" class="fr12 omit">若宇商城招商啦!!!2</a></div>
                </div>
            </div>
        </div>
    </div>

<?php
$menu=$obj->GetCommAd($v_shop,'DESC',10,1,$_template[$v_shop]['template']);
if (!empty($ad))
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




<!--
<?php
$pic=$obj->GetCommAd($v_shop,'DESC',3,2,$_template[$v_shop]['template']);
if (!empty($ad))
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

-->
    
    
    <div class="web-jx-product mtr10 bgF">
        <div class="web-jx-title">
            <i class="text"></i>
            <div class="web-jx-time fr12">
    
            </div>
        </div>
        <div class="web-jx-slide">
            <ul>
                <li class="web-jx-item tc">
                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
                        <img src="/template/source/default/images/jx_img_1.png">
                        <p class="red fr14">￥<span class="f14">249</span>.00</p>
                        <p class="fr12 cl_b9"><del>￥399.00</del></p>
                    </a>
                </li>
                <li class="web-jx-item tc">
                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
                        <img src="/template/source/default/images/jx_img_2.png">
                        <p class="red fr14">￥<span class="f14">249</span>.00</p>
                        <p class="fr12 cl_b9"><del>￥399.00</del></p>
                    </a>
                </li>
                <li class="web-jx-item tc">
                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
                        <img src="/template/source/default/images/jx_img_1.png">
                        <p class="red fr14">￥<span class="f14">249</span>.00</p>
                        <p class="fr12 cl_b9"><del>￥399.00</del></p>
                    </a>
                </li>
                <li class="web-jx-item tc">
                    <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
                        <img src="/template/source/default/images/jx_img_1.png">
                        <p class="red fr14">￥<span class="f14">249</span>.00</p>
                        <p class="fr12 cl_b9"><del>￥399.00</del></p>
                    </a>
                </li>
            </ul>
        </div>
    
    </div>


	<div class="moban-product mtr10">
    	<div class="moban-product-two">
        	<ul>
            	<li>
                	<a href="javascript:;">
                    	<i style="background-image:url(/template/source/ruoywyt/images/moban-product-img1.png); background-size:100% 100%;"></i>
                    </a>
                </li>
                <li>
                	<a href="javascript:;">
                    	<i style="background-image:url(/template/source/ruoywyt/images/moban-product-img2.png); background-size:100% 100%;"></i>
                    </a>
                </li>
                <li>
                	<a href="javascript:;">
                    	<i style="background-image:url(/template/source/ruoywyt/images/moban-product-img3.png); background-size:100% 100%;"></i>
                    </a>
                </li>
                <li>
                	<a href="javascript:;">
                    	<i style="background-image:url(/template/source/ruoywyt/images/moban-product-img4.png); background-size:100% 100%;"></i>
                    </a>
                </li>
            </ul>
        	<div class="cb"></div>
        </div>
        <div class="moban-product-three">
        	<ul>
            	<li>
                	<a href="javascript:;">
                    	<i style="background-image:url(/template/source/ruoywyt/images/moban-product-img5.png); background-size:100% 100%;"></i>
                    </a>
                </li>
                <li>
                	<a href="javascript:;">
                    	<i style="background-image:url(/template/source/ruoywyt/images/moban-product-img6.png); background-size:100% 100%;"></i>
                    </a>
                </li>
                <li>
                	<a href="javascript:;">
                    	<i style="background-image:url(/template/source/ruoywyt/images/moban-product-img7.png); background-size:100% 100%;"></i>
                    </a>
                </li>
            </ul>
            <div class="cb"></div>
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
                            <a href="<?php echo '/?mod=weidian&v_mod=product&_index=_view&id='.$item['product_id'].'&v_shop='.$v_shop.''; ?>">
                                <img data-lazyload="<?php echo $item['product_img']; ?>" src="<?php echo $item['product_img']; ?>" class="web-yp-img lazy">
                                <div class="web-yp-body">
                                    <h1 class="omit fr14 cl_b3"><?php echo $item['product_name']; ?></h1>
                                    <div class="fr14 mtr5">
                                        <div class="fl red">
                                            ￥<span class="fr18"><?php echo $item['product_price']; ?></span>.00
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
<?php include "footer_tpl.php"; ?>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/jquery_1.1.1.js"></script>
<script src="/template/source/default/js/swiper.min.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>

<script>
	 
	 var swiper = new Swiper('#swiper-container-banner', {
		pagination: '#swiper-pagination-banner',
		paginationClickable: true,
		autoplay:3000,
		autoplayDisableOnInteraction : false,
	});
	 var swiper2 = new Swiper('#swiper-container-news', {
        direction: 'vertical',
		/*autoHeight: true,*/
		height:25,
		autoplay:3000,
		autoplayDisableOnInteraction : false,
		loop:true
    });
    function n(count){
        if(count > 9){
            return count
        }else{
            return '0'+ count;
        }
    }
    var eValue = document.getElementsByClassName('web-jx-time')[0];
	var countDown = 'php时间戳。'
    function getRTime(){
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
			eValue.innerHTML = '<span>'+n(oHours)+'</span>:<span>'+n(oMinutes)+'</span>:<span>'+n(oSeconds)+'</span>';
		}else{
			eValue.innerHTML = '此产品已结束'
		}

    }

    setInterval(getRTime,1000);
    getRTime();

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
                $.getJSON('/ruoyw?page='+page, function(res){
                    //假设你的列表返回在data集合中
                    layui.each(res.data, function(index, item)
                    {
                        lis.push('<li class="web-yp-item">');
                        lis.push('<a href="/?mod=weidian&v_mod=product&_index=_view&id='+item.product_id+'&v_shop=<?php echo $_GET['v_shop']; ?>">');
                        lis.push('<img data-lazyload="'+item.product_img+'" src="'+item.product_img+'" class="web-yp-img lazy">');
                        lis.push('<div class="web-yp-body">');
                        lis.push('<h1 class="omit fr14 cl_b3">'+item.product_name+'</h1>');
                        lis.push('<div class="fr14 mtr5">');
                        lis.push('<div class="fl red">');
                        lis.push('￥<span class="fr18">'+item.product_price+'</span>');
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



</body>
</html>