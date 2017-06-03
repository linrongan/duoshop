<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetStoreList();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>精选</title>
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
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/ggPublic.css?8888aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/moban1.css?777777">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/weixin/css/cart.css">
    <style>
        .weui-navbar{position:relative; top:0; left:0; background:white; }
        /*.weui-navbar + .weui-banner {
            padding-top: 2.25rem;
            padding-bottom: 0;
        }*/
        .weui-navbar__item{height:2.25rem; line-height:1.25rem; padding:.5rem 0; color:#4a4a4a;}
        .weui-navbar__item.weui-bar__item_on{background:none; color:#ff464e;}
        .comment-cart{width:1.25rem; height:1.25rem; background: #ff464e url(/template/source/weixin/images/goCart.png) center center no-repeat; border-radius: 2px; background-size:100%; display:block; margin-top:-.2rem;}
        .weui-cell:before{left:0;}
        .shop-logo{width:2.5rem; height:1.5rem;border:1px solid #ededed; border-radius:2px;  display:-webkit-box; -webkit-box-align:center; -webkit-box-pack:center;}
        .shop-logo>img{max-width:100%; max-height:100%; display:block;}
        .go-shop{padding:2px 5px; border:1px solid #ff464e; color:#ff464e; border-radius: 2px; }
        .weui-img{    display: -webkit-box; display: -webkit-flex;  display: flex; padding:0 .25rem .25rem}
        .weui-img-flex{    display: block;-webkit-box-flex: 1;-webkit-flex: 1; flex: 1; line-height:5rem; position:relative;}
		.weui-img-flex a{display:block;}
        .weui-img-flex img{width:5.25rem; height:5.25rem; display:inline-block; text-align:center; vertical-align:middle;}
        .weui-panel .weui-panel__item{display:none; }
        .weui-panel .weui-panel__item:first-child{display:block;}
        .weui-panel__item .weui-cells:first-child{margin-top:0px;}
        .weui-cells{display:block;}
        .duo-header-shortcut {
            display: none;
        }
		.shop-name{position:absolute; bottom:0; left:0; width:5.25rem; height:1.25rem; line-height:1.25rem; color:white; padding:0 2%; text-align:center; background:rgba(255,204,204,0.6);}
		
    </style>
</head>
<body class="mhome" style="padding-bottom:0;">
<header>
    <div id="m_common_header">
        <header class="duo-header">
            <div class="duo-header-bar">
                <div onclick="javascript:history.go(-1)" id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
                <div class="duo-header-title">店铺搜索</div>
                <div id="m_common_header_jdkey" class="duo-header-icon-shortcut J_ping"><span></span></div></div>
            <ul id="m_common_header_shortcut" class="duo-header-shortcut">
                <li id="m_common_header_shortcut_m_index">
                    <a class="J_ping current" href="/?mod=weixin">
                        <span class="shortcut-home"></span>
                        <strong>首页</strong></a>
                </li>
                <li class="J_ping" id="m_common_header_shortcut_category_search">
                    <a href="/?mod=weixin&amp;v_mod=category">
                        <span class="shortcut-categories"></span>
                        <strong>分类搜索</strong>
                    </a>
                </li>
                <li class="J_ping" id="m_common_header_shortcut_p_cart">
                    <a href="/?mod=weixin&amp;v_mod=cart" id="html5_cart">
                        <span class="shortcut-cart"></span>
                        <strong>购物车</strong>
                    </a>
                </li>
                <li id="m_common_header_shortcut_h_home">
                    <a class="J_ping" href="/?mod=weixin&amp;v_mod=user">
                        <span class="shortcut-my-account"></span>
                        <strong>会员中心</strong>
                    </a>
                </li>
            </ul>
        </header>
    </div>
</header>
<div class="weui-panel" style=" background:none; margin-top:0;">

    <div class="weui-panel__item">   
		<!--搜索产品-->


		<!--搜索店铺-->
        
        
        <!-----循环------->
        <?php
            if($data)
            {
                $show_pro_count = 5;    //最多显示5条
                foreach($data as $val)
                {
                    ?>
                    <div class="weui-cells">
                     
                        <div class="weui-cell">
                            <div class="weui-cell__hd">
                                <div class="shop-logo mrr10">
                                    <img src="<?php echo $val['store_logo']; ?>">
                                </div>
                            </div>
                            <div class="weui-cell__bd">
                                <h1 class="fr14 cl_b3">
                                    <?php echo $val['store_name']; ?>
                                </h1>
                                <p class="fr12 cl_b9">
                                    <?php echo $val['store_describe']; ?>
                                    <?php echo $val['follow_count'].'人关注'; ?>
                                </p>
                            </div>
                            <div class="weui-cell__ft" onclick="location.href='/<?php echo $val['store_url'];?>'">
                                <span class="go-shop fr12 mlr10">进店看看</span>
                            </div>
                        </div>
                        <div class="weui-img">
                            <?php
                                if($val['shop_pro'])
                                {
                                   $arr = explode('&&',$val['shop_pro']);
                                   $pro_count = count($arr)>=$show_pro_count?$show_pro_count:count($arr);
                                   for($i=0;$i<$pro_count;$i++)
                                   {
                                       $arr_data = explode('&',$arr[$i])
                                       ?>
                                       <div class="weui-img-flex">
                                       		<a href="?mod=weixin&v_mod=product&_index=_view&id=<?php echo $arr_data[0]; ?>">
                                               <img src="/template/source/images/default.png" data-src="<?php echo $arr_data[2]; ?>">
                                               <p class="shop-name"><?php echo $arr_data[1]; ?></p>
                                            </a>
                                       </div>
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
        <!-----结束循环------->
       
    </div>
</div>





<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script src="/template/source/js/fastclick.js"></script>
<script src="/template/source/js/lazy-load-img.min.js"></script>
<script src="/template/source/js/guageEdit.js"></script>
<script>
    var swiper = new Swiper('#swiper-container-banner', {
        pagination: '#swiper-pagination-banner',
        paginationClickable: true,
        autoplay:3000,
        autoplayDisableOnInteraction : false
    });
    $(function(){
		/*
        $(".weui-navbar .weui-navbar__item").on("click",function(){
            $(this).addClass("weui-bar__item_on").siblings().removeClass("weui-bar__item_on");
            var _index = $(this).index();
            $(".weui-panel .weui-panel__item").eq(_index).show().siblings().hide();

        })*/

        var a = true;
        $('#m_common_header_jdkey').click(function(){
            if(a){
                $('#m_common_header_shortcut').css('display','table');
                a = false;
            }else{
                $('#m_common_header_shortcut').css('display','none');
                a = true;
            }
        })
    })


</script>
</html>