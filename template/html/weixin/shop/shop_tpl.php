<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if (!isset($_REQUEST['lat']) || !isset($_REQUEST['lng']))
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $weburl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $array=module('jsapi')->config($weburl);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo WEBNAME; ?></title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script type="text/javascript">
        wx.config({
            debug:  false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '<?php echo $array['appId']; ?>', // 必填，公众号的唯一标识
            timestamp:<?php echo $array['timestamp']; ?>, // 必填，生成签名的时间戳
            nonceStr: '<?php echo $array['noncestr']; ?>', // 必填，生成签名的随机串
            signature:'<?php echo $array['signature']; ?>',// 必填，签名，见附录1
            jsApiList:[
                'getLocation'
            ]  // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });


        wx.ready(function () {
            wx.getLocation({
                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function(res)
                {
                    //alert(res.latitude+'|'+res.longitude);
                    //return false;
                    window.location.href='/?mod=weixin&v_mod=shop&lat='+res.latitude+'&lng='+res.longitude;
                },
                fail: function (res)
                {
                    window.location.href='/?mod=weixin&v_mod=shop&lng&lat';
                }
            });
        });
    </script>
</head>
<body style="padding-bottom:0;">
<div id="loadingToast" style="opacity: 1;">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
        <i class="weui-loading weui-icon_toast"></i>
        <p class="weui-toast__content">定位中...</p>
    </div>
</div>

	<script>
    	window.onload = function(){
			console.log("js获取当前域名:"+window.location.host+"或者"+document.domain+"<br>");
			console.log("js获取当前:"+window.location.href+"<br>");
			console.log("js获取上(前)一页:"+document.referrer);	
		}
    </script>


</body>


</html>
<?php }
else
{
    $data=$obj->GetPhysicalList();
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
        <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/swiper.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/weui.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/jquery-weui.min.css">
        <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/rest.css?66666">
        <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/webapp.css?66666">
        <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">

        <link rel="stylesheet" href="/template/source/weixin/css/cart.css?6666">
        <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/sec.kill.css?777777">
        <style>
            .shop-query{ background:white;}
            .tuij-title{padding:.4rem 3%;}
            .grade{height:15px; line-height:15px;}
            .grade-item{width:12px; height:12px; display:inline-block; vertical-align:middle; margin-top:-3px;}
            .grade-2{background:url(/template/source/images/nadu-active.png) no-repeat; background-size:100% 100%;}
            .grade-1{background:url(/template/source/images/ban-active.png) no-repeat; background-size:100% 100%;}
            .grade-0{background:url(/template/source/images/nandu.png) no-repeat; background-size:100% 100%;}
            .cost>span,.frdistance>span{padding-right:5px; border-right:1px solid #ededed; margin-right:5px;}
            .cost>span:last-child,.frdistance>span:last-child{border-right:none; margin-right:0;}
            .duo-header-shortcut{display:none;}
            .weui-cell:before{left:0;}
            .shop-product-sort{ background:white; display:-webkit-flex; display:flex; padding:.5rem 0; width:100%; z-index:999}
            .shop-product-sort>a
            {
                -webkit-box-flex: 1;
                -webkit-flex: 1;
                flex: 1;
                position:relative;
            }
            .shop-product-sort>.shop-sort-active>span{color:#ff574a;}
            .price-sort{font-size:12px; position:absolute; right: .5rem; top: -.06rem; width:10px;}
            .price-sort>p{height:8px;}
            /*.shop-img{}*/
        </style>
    </head>
    <body style="padding-bottom:0;">
    <header>
        <div id="m_common_header"><header class="duo-header">
                <div class="duo-header-bar">
                    <div onclick="window.location.href='/?mod=weixin'" id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
                    <div class="duo-header-title">附近店铺</div>
                    <div id="m_common_header_jdkey" class="duo-header-icon-shortcut J_ping"><span></span></div></div>
                <ul id="m_common_header_shortcut" class="duo-header-shortcut">
                    <li id="m_common_header_shortcut_m_index">
                        <a class="J_ping" href="/?mod=weixin">
                            <span class="shortcut-home"></span>
                            <strong>首页</strong></a>
                    </li>
                    <li class="J_ping" id="m_common_header_shortcut_category_search">
                        <a href="/?mod=weixin&v_mod=category">
                            <span class="shortcut-categories"></span>
                            <strong>分类搜索</strong>
                        </a>
                    </li>
                    <li class="J_ping" id="m_common_header_shortcut_p_cart">
                        <a href="/?mod=weixin&v_mod=cart" id="html5_cart">
                            <span class="shortcut-cart"></span>
                            <strong>购物车</strong>
                        </a>
                    </li>
                    <li id="m_common_header_shortcut_h_home">
                        <a class="J_ping" href="/?mod=weixin&v_mod=user&v_shop=<?php echo $v_shop; ?>">
                            <span class="shortcut-my-account"></span>
                            <strong>会员中心</strong>
                        </a>
                    </li>
                </ul>
            </header>
        </div>
    </header>

    <div class="shop-product-sort rmt5">
        <a href="/?mod=weixin&v_mod=shop&lat=<?php echo $_REQUEST['lat']; ?>&lng=<?php echo $_REQUEST['lng']; ?>&sort=2" class="tc cl_b3 <?php if (isset($_REQUEST['sort'])  && $_REQUEST['sort']==2){echo 'shop-sort-active';} ?>">
            <span class="rf13">综合</span>
        </a>
        <a href="/?mod=weixin&v_mod=shop&lat=<?php echo $_REQUEST['lat']; ?>&lng=<?php echo $_REQUEST['lng']; ?>&sort=3" class="tc cl_b3 <?php if (isset($_REQUEST['sort'])  && $_REQUEST['sort']==3){echo 'shop-sort-active';} ?>">
            <span class="rf13">销量</span>
        </a>
        <a href="/?mod=weixin&v_mod=shop&lat=<?php echo $_REQUEST['lat']; ?>&lng=<?php echo $_REQUEST['lng']; ?>&sort=4" class="tc cl_b3 <?php if (isset($_REQUEST['sort'])  && $_REQUEST['sort']==4){echo 'shop-sort-active';} ?>">
            <span class="rf13">热度</span>
        </a>
        <a href="/?mod=weixin&v_mod=shop&lat=<?php echo $_REQUEST['lat']; ?>&lng=<?php echo $_REQUEST['lng']; ?>" class="tc cl_b3 <?php if ((isset($_REQUEST['sort']) && $_REQUEST['sort']==1) || $_REQUEST['sort']==0){echo 'shop-sort-active';} ?>">
        <span class="rf13">
            距离
        </span>
            <!----价格标识样式 在P标签加class="red"--->
            <!--
            <div class="price-sort">

                <p <?php if (empty($_REQUEST['sort'])){echo ' class="red"';} ?>><i class="fa fa-caret-up "></i></p>
                <p <?php if (isset($_REQUEST['sort'])  && $_REQUEST['sort']==1){echo ' class="red"';} ?>><i class="fa fa-caret-down "></i></p>
            </div>
             -->
        </a>
    </div>
    <?php
    if (!empty($data['data'])){?>
        <div class="shop-query rmt10">
            <div class="tuij-title rf15">商家推荐</div>
            <div class="weui-cells" style="margin-top:0; " id="item_lode">
                <?php foreach($data['data'] as $item){?>
                    <a href="/<?php echo $item['store_url']; ?>" class="weui-cell" style="position:relative;">
                        <div class="weui-cell__hd" style="position:absolute; left:3%; top:.5rem;">
                            <div class="shop-img">
                                <img src="<?php echo $item['store_logo']; ?>" style="width:60px; height:60px; border-radius:5px; display:block; margin-right:10px;">
                            </div>
                        </div>
                        <div class="weui-cell__bd" style="padding-left:70px;">
                            <div class="rf14 cl_b3">
                                <b class="fl omit" style="width:70%;"><?php echo $item['store_name']; ?></b>
                                <span class="fr rf12 cl_b9"><?php echo $obj->getDistance($item['lat'], $item['lng'], $_REQUEST['lat'], $_REQUEST['lng']); ?></span>
                                <div class="cb"></div>
                            </div>
                            <div class="grade rf12 cl_b9 rmt5">
                                <?php
                                for($i=1;$i<=$item['store_level']/2;$i++)
                                {?>
                                    <span class="grade-item grade-2"></span>
                                <?php
                                }
                                echo $item['store_level']%2>0?'<span class="grade-item grade-1"></span>':'';
                                ?>
                                <b style="color:#f8aa12; margin-right:5px;"><?php echo $item['store_level']/2; ?></b>
                                销量 <?php echo $item['store_sold']; ?> 单
                            </div>
                            <div class="rf12 rmt5 cl_b9 cost">
                                <span>￥<?php echo $item['min_ship_fee']; ?>起送</span>
                                <span>配送费￥<?php echo $item['ship_fee']; ?></span>
                            </div>
                            <div class="rf12 cl_b9 rmt5">
                                地址：<?php echo $item['address']; ?>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
    <script src="/template/source/weixin/js/swiper.min.js"></script>
    <script src="/template/source/weixin/js/jquery-weui.min.js"></script>
    <script src="/template/source/weixin/js/mui.min.js"></script>
    <script src="/template/source/weixin/js/mui.lazyload.js"></script>
    <script src="/template/source/weixin/js/mui.lazyload.img.js"></script>
    <script type="text/javascript" src="/tool/layer/layui/layui/layui.js"></script>
    <script type="text/javascript" src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
	
    <script>
	
        $(function(){
			
			
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
        layui.use('flow', function(){
            var flow = layui.flow;
            flow.load({
                elem: '#item_lode' //指定列表容器
                ,done: function(page, next)
                {
                    var lis = [];
                    $.getJSON('<?php echo $_SERVER['REQUEST_URI']; ?>&page='+page, function(res)
                    {
                        lis.push(res.data);
                        next(lis.join(''), page < res.pages);
                    });
                }
            });
        });
    </script>
    </body>
    </html>
<?php }
?>

