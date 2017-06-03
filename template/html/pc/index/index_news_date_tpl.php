<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getNewsDetails(intval($_GET['id']));
$banner = $obj->getPageBanner(12);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>乡粑网</title>
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/moban.css?7777ss">
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
                    <li class="<?php echo $data['news_category']==0?'active':'';?>"><a href="?mod=index&_index=_news" class="db">行业资讯</a></li>
                    <li class="<?php echo $data['news_category']==1?'active':'';?>"><a href="?mod=index&_index=_news&category=1" class="db">公司新闻</a></li>
                </ul>
            </div>
            <div class="right-neirong fl">
                <!--关于我们-->
                <div class="right-neirong-title2 f20">
                	乡粑网<span class="sub_title">全心全意为农民服务</span>
                    
                    <div class="fr">
                    	<a href="javascript:;" class="cl_b9 f12">主页</a>
                        <span class="ml5 mr5 cl_b9">›</span>
                        <a href="javascript:;" class="cl_b9 f12"><?php echo $data['news_category']==0?'行业资讯':'公司新闻';?></a>
                        <span class="ml5 mr5 cl_b9">›</span>
                        <span class="cl_b3 f12"><?php echo $data['news_title'];?></span>
                    </div>
                    <div class="cb"></div>
                </div>
                
              	<div class="right-neirong-date">
                	<h2 class="article_title"><?php echo $data['news_title'];?></h2>
                	<div class="article_pubtime">发布时间：<?php echo date('Y年m月d日',$data['addtime']);?></div>
                    <div class="article_content">
                        <?php echo $data['news_content'];?>
                    </div>
                    
                    
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