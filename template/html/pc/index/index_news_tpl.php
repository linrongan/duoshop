<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

if(isset($_REQUEST['category'])){
    $category = intval($_REQUEST['category']);
}else{
    $category = 0;
}
$news = $obj->getNewsList();
$banner = $obj->getPageBanner(12);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>乡粑网</title>
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/moban.css?6666">
</head>
<body style="background:#ffffff;">
<!--头部-->
<?php include 'header_tpl.php';?>

<div class="banner">
    <div class="banner-side">
        <i style="background-image: url(<?php echo $banner['picture_path'];?>); background-size:100% 100%;"></i>
    </div>
</div>
<div style="height: 10px; background: white;"></div>
<div class="container">
    <div class="content">
        <div class="container_body" style="padding:50px 20px;">
            <div class="left-menu fl">
                <ul>
                    <li class="<?php if($category==0){ echo 'active';}?>"><a href="?mod=index&_index=_news" class="db">行业资讯</a></li>
                    <li  class="<?php if($category==1){ echo 'active';}?>"><a href="?mod=index&_index=_news&category=1" class="db">公司新闻</a></li>
                </ul>
            </div>
            <div class="right-neirong fl">
                <!--关于我们-->
                <div class="right-neirong-title2 f20">
                	乡粑网<span class="sub_title">全心全意为农民服务</span>
                    
                    <div class="fr">
                    	<i class=""></i><a href="javascript:;" class="cl_b9 f12">主页</a><span class="ml5 mr5 cl_b9">›</span><span class="cl_b3 f12"><?php echo $category==0?'行业资讯':'公司新闻';?></span>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="right-neirong-news">
                    <ul>
                        <?php
                            if(!empty($news['data'])){
                                foreach($news['data'] as $item){
                                    ?>
                                    <li>
                                        <a href="/?mod=index&_index=_news_date&id=<?php echo $item['id'];?>">
                                            <div class="fl news-img">
                                                <img src="<?php echo $item['news_img'];?>" width="200" height="100" style="vertical-align:middle;">
                                            </div>
                                            <div class="fr news-content">
                                                <h1 class="news-content-title f14"><?php echo $item['news_title'];?></h1>
                                                <p class="f12 mt5 cl_b9"><?php echo date('Y-m-d',$item['addtime']);?></p>
                                                <p class="description mt5 f12 cl_b9"><?php echo utf_substr($item['news_desc'],185);?><span class="cl_b3 ml5 red">查看详情>></span> </p>
                                            </div>
                                            <div class="cb"></div>
                                        </a>
                                    </li>
                                <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
              	<div class="right-neirong-page tc mt30">
                	<!--
                	<a href="javascript:;" >首页</a>
                	<a href="javascript:;">上一页</a>

                    <a href="javascript:;" class="active">1</a>
                    <a href="javascript:;">2</a>
                    <a href="javascript:;">3</a>
                    <a href="javascript:;">4</a>
                    <a href="javascript:;">下一页</a>
                    <a href="javascript:;">尾页</a>-->
                    <?php
                    include RPC_DIR .'/inc/page.php';
                    echo pageNav($news['total'],$news['page_size'],$news['curpage'],'','&mod=index&_index=_news&category='.$category);
                    ?>
                </div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>
<?php include 'footer_tpl.php';?>

<script>
    $(function(){
        $(".phone-page>a").hover(function(){
            $(this).addClass("active").siblings().removeClass("active");
            var _index = $(this).index()

            $(".phone-box .phone-box-item").eq(_index).show().siblings().hide();
        })
        $(".header_nav a").eq(1).addClass("active").siblings().removeClass("active");
    })
</script>

</body>
</html>