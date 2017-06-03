<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user = $obj->GetUserInfo(SYS_USERID);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes"><!-- 是否启用 WebAPP 全屏模式 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black"> <!-- 状态条颜色 -->
    <meta name="format-detection" content="telephone=no">   <!-- 屏蔽数字自动识别为电话号码 -->
    <meta name="description" content="" /> <!-- 页面描述 -->
    <meta name="keywords" content=""/> <!-- 页面关键词 -->
    <title>我的积分</title>
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/jquery-weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/webapp.css">
    <link type="text/css" rel="stylesheet" href="/template/source/point/css/guageEdit.css">
    <style>
        #swiper-container-gral{padding:5px 0;}
        #swiper-container-gral .swiper-slide>a{ position:relative; padding:0 2%;}
        #swiper-container-gral .swiper-slide>a::after{
            content: " ";
            position: absolute;
            bottom: 0;
            right: 0;
            width:1px;
            height: 100%;
            border-right: 1px solid #e5e5e5;
            color: #e5e5e5;
            -webkit-transform-origin: 0 100%;
            transform-origin: 0 100%;
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
            z-index: 2;
        }
        #xm-gral-list>.weui-cell{ padding:1rem 5%; }
        #xm-gral-list>.weui-cell::before{left:0; border-top:2px dotted #d9d9d9;}
        #menu_box {
            position: fixed;
            right: 0px;
            bottom: 0px;
            z-index: 2002;
            width: 60px;
            height: 60px;
            margin-right: 5%;
            margin-bottom: .4rem;
        }
        .menu-v-list {
            position: fixed;
            right: 0px;
            width: 60px;
            height: 60px;
            margin-right: 5%;
            margin-bottom: .4rem;
            background: url(/template/source/daili/images/shoppingcar.png) no-repeat;
            background-size: 100%;
            /* background-position: 3px; */
        }

        .number-text {
            width: 20px;
            height: 20px;
            font-size: 0.8em;
            font-weight: bold;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            -ms-border-radius: 50px;
            -o-border-radius: 50px;
            background: #ff6600;
            color: #fff;
            text-align: center;
            position: absolute;
            right: -4px;
        }
        .weui-navbar+.weui-tab__panel{padding-top:40px;}
    </style>
</head>
<body class="mhome" >
<div class="xm-header">
    <div class="xm-header-gral">
        <div class="xm-header-gral-pic">
            <img src="<?php echo $user['headimgurl']; ?>"></div>
        <p class="rf15 white tc mt5"><?php echo $user['nickname']; ?></p>
        <div class="xm-header-gral-number white rf14">我的积分
            <b class="white rf15"><?php echo $user['user_point']; ?></b>
        </div>
    </div>
</div>

<div class="weui-tab" style="margin-top:25px;">
    <div class="weui-navbar">
        <div class="weui-navbar__item weui-bar__item_on">
            积分商城
        </div>
        <div class="weui-navbar__item" onclick="window.location.href='/?mod=weixin&v_mod=games_signed'">
            每日签到
        </div>
        <div class="weui-navbar__item" onclick="window.location.href='/?mod=weixin&v_mod=point&_index=_record'">
            积分记录
        </div>
    </div>
    <div class="weui-tab__panel">

    </div>
</div>






<div class="xm-content"><!--
    <div class="xm-gral-hot rmt10">
        <div class="xm-gral-title rf15"><span><i class="hot">
                    <img src="/template/source/images/hot.jpg"></i>产品分类</span>
        </div>
        <div class="xm-gral-section">

            <div class="swiper-container" id="swiper-container-gral">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" style="width:33.33%">
                        <a href="/?mod=weixin&v_mod=point&_index=_shop" class="db">
                            <div class="xm-gral-slide-img">
                                <img src="/template/source/point/images/default.jpg" data-src="/template/source/point/images/default.jpg">
                            </div>
                            <h1 class="xm-gral-slide-title rf14">全部产品</h1>
                        </a>
                    </div>
                    <?php
                    $category = $obj->GetPointCategory();
                    if(!empty($category))
                    {
                        foreach($category as $val)
                        {
                            ?>
                            <div class="swiper-slide"  style="width:33.33%">
                                <a href="/?mod=weixin&v_mod=point&_index=_shop&category=<?php echo $val['category_id']; ?>#showAllproduct" class="db">
                                    <div class="xm-gral-slide-img">
                                        <img src="<?php echo $val['category_img']; ?>" data-src="<?php echo $val['category_img']; ?>">
                                    </div>
                                    <h1 class="xm-gral-slide-title rf14"><?php echo $val['category_name']; ?></h1>
                                </a>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>-->

    <?php
    $pro = $obj->GetPointProductList();
    ?>
    <div class="xm-gral-hot rmt10" id="showAllproduct">
        <div class="xm-gral-title rf15"><span><i class="hot">
            <img src="/template/source/images/hot.jpg"></i>
                兑换商品
                <?php //echo $pro['title']; ?>
            </span>
        </div>
        <div class="xm-gral-section">
            <div class="weui-cells" style="margin-top:-1px;" id="xm-gral-list">
                <?php
                if($pro['data'])
                {
                    foreach($pro['data'] as $item)
                    {
                        ?>
                        <a class="weui-cell" href="/?mod=weixin&v_mod=point&_index=_product_detail&id=<?php echo $item['id']; ?>">
                            <div class="weui-cell__hd">
                                <div class="xm-gral-list-img">
                                    <img src="<?php echo $item['gift_img']; ?>" data-src="<?php echo $item['gift_img']; ?>">
                                </div>
                            </div>
                            <div class="weui-cell__bd">
                                <div class="fixed-width">
                                    <h1 class="rf16 omit"><?php echo $item['gift_name']; ?></h1>
                                    <p class="rf14 cl_b9 rmt5 omit">库存：<?php echo $item['qty']-$item['sale']; ?> <?php echo $item['unit']; ?></p>
                                    <div class="rf12 red rmt20"><span class="rf17"><?php echo $item['gift_point']; ?></span>积分</div>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script src="/template/source/point/js/jquery-2.1.4.js"></script>
<script src="/template/source/point/js/jquery-weui.min.js"></script>
<script src="/template/source/point/js/lazy-load-img.min.js"></script>
<script src="/template/source/point/js/swiper.min.js"></script>
<script src="/template/source/point/js/fastclick.js"></script>
<script src="/template/source/point/js/guageEdit.js?66"></script>
<script>

    var swiper = new Swiper('#swiper-container-gral', {
        slidesPerView: 3,
        spaceBetween: 0
    });
</script>
</body>
</html>
