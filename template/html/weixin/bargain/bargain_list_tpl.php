<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$product=$obj->GetBargainProductList();
$banner = $obj->getBargainBanner();
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
    <title>砍价</title>
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/jquery-weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/webapp.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/guageEdit.css">
    <style>
        .xm-product-slide{border-top:1px solid #822e3e; border-bottom:1px solid #822e3e; margin-bottom:.5rem; background:white;}
        .xm-product-slide:last-child{margin-bottom:0;}
        .xm-product-btn{padding: 2px 10px; border-radius: 30px; background:#d92c28;}

        .win_none {display:none}
        .win {position:fixed; z-index:99999; left:0; top:0; right:0; bottom:0; background:rgba(0,0,0,0.9); -webkit-animation:bg 0.3s ease-out both; -moz-animation:bg 0.3s ease-out both; animation:bg 0.3s ease-out both}
        .win .transparent_bg {position:fixed; z-index:11; left:0; right:0; top:0; bottom:0}
        @-webkit-keyframes bg {0% {background:rgba(0,0,0,0)} 100% {background:rgba(0,0,0,0.8)}}
        @keyframes bg {0% {background:rgba(0,0,0,0)} 100% {background:rgba(0,0,0,0.8)}}
        .win .layout_win {background:#FFF; position:absolute; left:0; bottom:0; right:0; z-index:12; transform:translateY(110%); -webkit-transform:translateY(110%); -webkit-animation:m_b 0.3s ease-out both; -moz-animation:m_b 0.3s ease-out both; animation:m_b 0.3s ease-out both}
        @-webkit-keyframes m_b {0% {transform:translateY(110%); -webkit-transform:translateY(110%)} 100% {transform:translateY(0); -webkit-transform:translateY(0)}}
        @keyframes m_b {0% {transform:translateY(110%); -webkit-transform:translateY(110%)} 100% {transform:translateY(0); -webkit-transform:translateY(0)}}
        /*遮罩end*/
        .tips {width:100%; height:100%; background-image:url(/template/source/bargain/images/txt_tips.png),url(/template/source/bargain/images/earth.png); background-repeat:no-repeat; background-position:center -60px,left bottom; background-size:100% auto,50% auto}
    </style>
</head>
<body class="mhome">
<div class="xm-conent" style="padding-bottom:2.5rem;">
    <!-- Swiper -->
    <div class="swiper-container" id="swiper-container-banner">
        <div class="swiper-wrapper">
            <?php
                if(!empty($banner))
                {
                    foreach($banner as $item)
                    {
                        ?>
                        <div class="swiper-slide">
                            <a href="<?php echo $item['picture_link'];?>">
                                <img src="<?php echo $item['picture_img'];?>" data-src="<?php echo $item['picture_img'];?>" style="width:100%; display:block;">
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
    <div class="browse">
        <div class="browse-box rf12">
            <i class="fa fa-eye rf14 rmr5" style="color:#ecf19c;"></i>
            参与人数：<?php echo $product['count']['count'];?>
        </div>
    </div>

    <div class="xm-activity-title tc rf15"><span>热门产品</span></div>
    <div class="xm-product-container">
        <div class="weui-cells no-weui-link" style="margin-top:0; background:none;" id="lode_list">
            <?php
                if(!empty($product['data']))
                {
                    foreach($product['data'] as $item)
                    {
                        ?>
                        <a href="/?mod=weixin&v_mod=bargain&_index=_view&id=<?php echo $item['id'];?>" class="weui-cell xm-product-slide">
                            <div class="weui-cell__hd">
                                <div class="xm-product-img rmr10">
                                    <img src="/template/source/bargain/images/default.png" data-src="<?php echo $item['product_img'];?>" class="db">
                                </div>
                            </div>
                            <div class="weui-cell__bd" style="width:50%;">
                                <div>
                                    <h1 class="rf14 rmb10 omit"><?php echo $item['product_name'];?></h1>
                                    <p class="rf12  red"><?php echo $item['join_count'];?>人参加</p>
                                    <p class="rf12 ">价格：￥<?php echo $item['product_price'];?></p>
                                    <p class="rf12 ">底价：￥<?php echo $item['min_price'];?></p>
                                </div>
                            </div>
                            <div class="weui-cell__ft"><span class="rf12 white xm-product-btn">马上砍</span></div>
                        </a>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</div>

<div class="xm-bottom-nav">
    <a href="javascript:;" class="rf14" id="showShare">分享好友</a>
    <a href="javascript:;" class="rf14 open-popup"  data-target="#raiders">帮砍攻略</a>
</div>

<div id="raiders" class="weui-popup__container ">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <div class="xm-activity-title tc rf15"><span>游戏攻略</span></div>
        <div style="padding:0 3%;">
            <div class="xm-explain-textarea white">
                <p class="lh20 rmt10 rf14">1、砍价活动自用户点击“找好友帮我砍价”按钮开始计时，活动持续24小时</p>
                <p class="lh20 rmt10 rf14">2、每个活动最多允许500个好友帮忙砍价</p>
                <p class="lh20 rmt10 rf14">3、活动结束时，微信好友砍价的总金额即会以优惠的形式发放到用户账户中</p>
                <p class="lh20 rmt10 rf14">4、砍价所获得的优惠不能重复使用</p>
                <p class="lh20 rmt10 rf14">5、砍到底价才能付款购买</p>

            </div>
        </div>


        <div style="padding:1rem 15%;">
            <a href="javascript:;" class="weui-btn raiders-btn  rf16 close-popup">关闭</a>
        </div>
    </div>
</div>



<div class="win win_none" style=""><div class="tips" style="position: absolute;top: 0px"></div></div>
<script src="/template/source/bargain/js/jquery-2.1.4.js"></script>
<script src="/template/source/bargain/js/jquery-weui.min.js"></script>
<script src="/template/source/bargain/js/lazy-load-img.min.js"></script>
<script src="/template/source/bargain/js/swiper.min.js"></script>
<script src="/template/source/bargain/js/fastclick.js"></script>
<script src="/template/source/bargain/js/guageEdit.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script>

    var swiper = new Swiper('#swiper-container-banner', {
        pagination: '#swiper-pagination-banner',
        paginationClickable: true,
        autoplay:3000,
        autoplayDisableOnInteraction : false
    });

    $(function(){

        $("#showShare").on("click",function() {
            $(".win").show();
        })
        $(".win").on("click",function() {
            $(this).hide();
        })




    })

    layui.use('flow', function(){
        var flow = layui.flow;
        flow.load({
            elem: '#lode_list' //指定列表容器
            ,done: function(page, next)
            {
                var lis = [];
                $.getJSON('<?php echo $_SERVER['REQUEST_URI']; ?>&page='+page, function(res)
                {
                    layui.each(res.data, function(index, item)
                    {
                        lis.push('<a href="/?mod=weixin&v_mod=bargain&_index=_view&id='+item.id+'" class="weui-cell xm-product-slide">"' +
                            '<div class="weui-cell__hd">' +
                            '<div class="xm-product-img rmr10">' +
                            '<img src="/template/source/bargain/images/default.png" data-src="'+item.product_img+'" class="db">' +
                            '</div>' +
                            '</div>' +
                            '<div class="weui-cell__bd" style="width:50%;">' +
                            '<div>'+
                            '<h1 class="rf14 rmb10 omit">'+item.product_name+'</h1>'+
                            '<p class="rf12  red">'+item.join_count+'人参加</p>'+
                            '<p class="rf12 ">价格：￥'+item.product_price+'</p>'+
                            '<p class="rf12 ">底价：￥'+item.min_price+'</p>'+
                            '</div>'+
                            '</div>'+
                            '<div class="weui-cell__ft"><span class="rf12 white xm-product-btn">马上砍</span></div>'+
                            '</a>');
                    });
                    next(lis.join(''), page < res.pages);
                });
            }
        });
    });

</script>
</body>
</html>