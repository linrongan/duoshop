<?php
    if(isset($_GET['pc']))
    {
        include_once  RPC_DIR .TEMPLATEPATH.'/pc/pc_index/index_tpl.php';
    }else
    {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>乡粑网</title>
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/moban.css?6666qqq">
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/flickerplate.css">
    <style>
    	.flickerplate .dot-navigation{bottom:140px;}
    </style>
</head>
<body>
<!--头部-->
<?php include 'header_tpl.php';?>

<?php
$ad=$obj->GetCommAd('ASC',10,1);
if (!empty($ad))
{?>
<div class="banner">
    <div class="flicker-example" data-block-text="false">
        <ul>
            <?php
            foreach($ad as $item)
            {
            ?>
                <li data-background="<?php echo $item['picture_path']; ?>">
                   <a title="<?php echo $item['picture_title']; ?>" href="<?php echo $item['picture_url']; ?>" style="display:block;"></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>

<div class="content_wrapper">
	<div class="content" style="width:1200px; margin-left:-600px;">

        <?php $seven = $obj->GetCommAd('ASC',7,2);?>
        <div class="ix04" style="background-image:url('<?php echo $seven[0]['picture_path'];?>');background-size:100% 100%;">
            <h1 style="padding-top:24px;"><?php echo $seven[0]['picture_title'];?></h1>
            <p><?php echo $seven[0]['picture_text'];?></p>
        </div>
        <div class="ix05" style="background-image:url('<?php echo $seven[1]['picture_path'];?>');background-size:100% 100%;">
            <div class="mk" style="display: none;">
                <a href="<?php echo $seven[1]['picture_url'];?>" style="display: none;"></a>
            </div>
            <i style="display: none;"></i>
        </div>
        <div class="ix06" style="background-image:url('<?php echo $seven[2]['picture_path'];?>');background-size:100% 100%;">
            <h1 style="padding-top:24px;"><?php echo $seven[2]['picture_title'];?></h1>
            <p><?php echo $seven[2]['picture_text'];?></p>
        </div>
        <div class="ix07" style="background-image:url('<?php echo $seven[3]['picture_path'];?>');background-size:100% 100%;">
         	<div class="mk" style="display: none;">
                <a href="<?php echo $seven[3]['picture_url'];?>" style="display: none;"></a>
            </div>
        </div>
        <div class="ix01" style="background-image:url('<?php echo $seven[4]['picture_path'];?>'); background-size:100% 100%;">
            <div class="mk" style="display: none;">
                <a href="<?php echo $seven[4]['picture_url'];?>" style="display: none;"></a>
            </div>
            <i style="display: none;"></i>
        </div>
        <div class="ix02" style="background-image:url('<?php echo $seven[5]['picture_path'];?>');background-size:100% 100%;">
            <h1><?php echo $seven[5]['picture_title'];?></h1>
            <p><?php echo $seven[5]['picture_text'];?></p>
        </div>
        <div class="ix03" style="background-image:url('<?php echo $seven[6]['picture_path'];?>');background-size:100% 100%;">
            <div class="mk" style="display: none;">
                <a href="<?php echo $seven[6]['picture_url'];?>" style="display: none;"></a>
            </div>
            <i style="display: none;"></i>
        </div>


        
	</div>
</div>

<div class="">
    <div class="content">
        <div class="phone-warp">
            <?php $phone_block = $obj->GetSevenPicture(11);?>
            <div class="fl phone-block">
                <div class="phone-box">
                    <?php
                    $imgs = unserialize($phone_block['picture_path']);
                    for($i=0;$i<count($imgs);$i++){
                        ?>
                        <div class="phone-box-item db">
                            <img src="<?php echo $imgs[$i];?>" class="db">
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="fl phone-content">
                <h1 class="f20"><?php echo $phone_block['picture_title'];?></h1>
                <p class="mt20 lh22"><?php echo $phone_block['picture_text'];?></p>
                <div class="phone-more mt50"><a href="<?php echo $phone_block['picture_url'];?>" class="f16">了解更多</a></div>

                <div class="phone-page mt50">
                    <a href="javascript:;" class="active"></a>
                    <a href="javascript:;" class=""></a>
                    <a href="javascript:;" class=""></a>
                </div>

            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>



<div id="n4" class="floor_6 clear">
    <div class="content">
        <div class="title">
            <a href="">MORE</a>新闻动态
            <p class="cb">查看公司新闻资讯，行业最新动态</p>
        </div>
        <div class="news">
            <div class="fl lnews">
                <div class="newsTitle">
                    <span class="fl">行业资讯</span>
                    <a href="?mod=index&_index=_news" class="fr" style="color:#337ab7">更多&gt;&gt;</a>
                    <div class="cb"></div>
                </div>
                <ul class="newsUl">
                    <?php
                        $news1 = $obj->getHomeNews();
                        if(!empty($news1)){
                            foreach($news1 as $item){
                                ?>
                                <li>
                                    <a href="?mod=index&_index=_news_date&id=<?php echo $item['id'];?>">
                                        <p class="fl lnText"><span style="color:#F00"> ▪ </span>
                                            <?php echo $item['news_title'];?>
                                        </p>
                                        <span class="fr rntime">[<?php echo date('Y-m-d',$item['addtime']);?>]</span>
                                        <div class="cb"></div>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                    ?>
                    
                 </ul>
            </div>
            <div class="fr rnews">
                <div class="newsTitle">
                    <span class="fl">公司新闻</span>
                    <a href="?mod=index&_index=_news&category=1" class="fr" style="color:#337ab7">更多&gt;&gt;</a>
                    <div class="cb"></div>
                </div>

                <ul class="newsUl">
                    <?php
                    $news2 = $obj->getHomeNews(1);
                    if(!empty($news2)){
                        foreach($news2 as $item){
                            ?>
                            <li>
                                <a href="?mod=index&_index=_news_date&id=<?php echo $item['id'];?>">
                                    <p class="fl lnText"><span style="color:#F00"> ▪ </span>
                                        <?php echo $item['news_title'];?>
                                    </p>
                                    <span class="fr rntime">[<?php echo date('Y-m-d',$item['addtime']);?>]</span>
                                    <div class="cb"></div>
                                </a>
                            </li>
                        <?php
                        }
                    }
                    ?>
				</ul>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>



<div class="div_index_bottom">
	<div class="brand_wrapper">
        <div class="brand">
            <h3 class="brand_title"></h3>
            <?php
                $logo = $obj->GetCommAd('ASC',99,5);
                if(!empty($logo)){
                    foreach($logo as $item){
                        ?>
                        <img src="<?php echo $item['picture_path'];?>" alt="<?php echo $item['picture_title'];?>">
                        <?php
                    }
                }
            ?>
       </div>
	</div>
</div>



<?php include 'footer_tpl.php';?>

<script src="/template/source/pc/js/modernizr-custom-v2.7.1.min.js" type="text/javascript"></script>
<script src="/template/source/pc/js/jquery-finger-v0.1.0.min.js" type="text/javascript"></script>

<!--Include flickerplate-->
<script src="/template/source/pc/js/flickerplate.min.js" type="text/javascript"></script>
<!--Execute flickerplate-->

<script>


    $(function(){
		
		$('.flicker-example').flicker({
			//flick_animation:'jquery-slide',
			//theme:'dark',
		});
		$('.banner').css('display','block');
        $(".phone-page>a").hover(function(){
            $(this).addClass("active").siblings().removeClass("active");
            var _index = $(this).index()

            $(".phone-box .phone-box-item").eq(_index).show().siblings().hide();
        })

		$('.content_wrapper .content>div').hover(function(){
			$(this).children('.mk').show();
			$(this).children('.mk').children('a').css('display','block');
			$(this).children('i').show()	
		},function(){
			$(this).children('.mk').hide();
			$(this).children('.mk').children('a').css('display','none');
			$(this).children('i').hide()	
		})
        $(".header_nav a").eq(0).addClass("active").siblings().removeClass("active");

    })


</script>


</body>
</html>
    <?php
    }
?>