<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$banner = $obj->getPageBanner(13);
$data = $obj->getAboutPageDetail(10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>乡粑网</title>
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/pc/css/moban.css">
    <style>
    	.container_body img{max-width:100%;}
    </style>
</head>
<body>

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
        <div class="container_body" style="padding:50px;">
            <?php echo $data['page_content'];?>
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
        $(".header_nav a").eq(2).addClass("active").siblings().removeClass("active");
    })
</script>
</body>
</html>