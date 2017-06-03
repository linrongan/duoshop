<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetActiveData(intval($_GET['id']));
//echo '<pre>';
//var_dump($data['product']);exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone = no"/>
    <title>商城主题</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?77777777777">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/newmain.css?7777777777">
    <style>
		.swiper-container{min-height:4rem;}
        .swiper-slide img{width:100%; height:4rem; display:block}
        .swiper-pagination{text-align: right}
        .swiper-pagination-bullet{background:#ad0e11; }
		.weui-search-bar{background:#f9f9f9;}
    </style>

    

    
    
</head>
<body style="background:#f9f9f9" class="mhome">


    <div class="news-nav">
        <?php
            if(!empty($data['category'])){
                foreach($data['category'] as $item){
                    ?>
                    <a href="?mod=weixin&v_mod=active&id=<?php echo $item['id'];?>"
                       class="<?php if(isset($_GET['id'])&&$_GET['id']==$item['id']){ echo 'news-active';}?>">
                        <?php echo $item['picture_title'];?></a>
                    <?php
                }
            }
        ?>
    </div>

	<div style="height:.82rem"></div>

    


    <?php
        if(!empty($data['product']))
        {
            foreach($data['product'] as $item)
            {
                ?>
                <div class="news-body mtr02">
                    <div class="news-body_title txtc">
                        <a href="javascript:;" class="sz14r"><?php echo $item['c_name'];?></a>
                    </div>
                    <div class="news-body_img">
                        <img class=" " src="/template/source/images/default.png" data-src="<?php echo $item['c_img'];?>">
                    </div>
                    <div class="news_product">
                        <ul>
                            <?php
                                if(!empty($item['product']))
                                {
                                    foreach($item['product'] as $val)
                                    {
                                        ?>
                                        <li>
                                            <a href="?mod=weixin&v_mod=product&_index=_view&id=<?php echo $val['product_id'];?>">
                                                <img class=" " src="/template/source/images/default.png" data-src="<?php echo $val['product_img'];?>" style="width:100%; height:1.2rem; display:block;">
                                                <p class="tlie sz12r"><?php echo $val['product_name'];?></p>
                                                <p class="redColor mtr01 sz12r">￥<?php echo $val['product_price'];?></p>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
            }
        }
    ?>

    <div id="returnTop"></div>
 	<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="/template/source/weixin/js/jquery-weui.min.js"></script>
	<script type="text/javascript" src="/template/source/weixin/js/fastclick.js"></script>
    <script type="text/javascript" src="/template/source/js/lazy-load-img.min.js"></script>
    <script type="text/javascript" src="/template/source/js/guageEdit.js"></script>
    <script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
    <script type="text/javascript" src="/template/source/js/returnTop.js"></script>
    
    
    <script>
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            autoplay:3000,
            autoplayDisableOnInteraction : false,
        });
			$(function()
            {
			$(".news-nav>a").each(function(index, element)
            {
               
				if($(element).hasClass('news-active')){
					if(index > 4){
						$(".news-nav").scrollLeft(120);
					}
				}
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
				$searchInput
					.on('blur', function () {
						if(!this.value.length) cancelSearch();
					})
					.on('input', function(){
						if(this.value.length) {
							$searchResult.show();
						} else {
							$searchResult.hide();
						}
					})
				;
				$searchClear.on('click', function(){
					hideSearchResult();
					$searchInput.focus();
				});
				$searchCancel.on('click', function(){
					cancelSearch();
					$searchInput.blur();
				});
			});
			
			/*
			$(window).scroll(function(){
				var scrTop = $(this).scrollTop();
				var hdNav = $(".news-nav").height();
				if(scrTop > hdNav){
					$(".news-nav").css('position','fixed')	
				}else{
					$(".news-nav").css('position','inherit')
				}
			})
	
		*/
		
		
		
    </script>
</body>
</html>