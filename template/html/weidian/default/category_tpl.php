<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$info = $obj->GetCategory();
$data = $info['category'];
$show_category = $obj->GetStoreProCategory();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>产品分类</title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/weui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css?888assas">
    <style>
        .mui-row.mui-fullscreen>[class*="mui-col-"] {
            height: 100%;
        }
        .mui-col-xs-3,
        .mui-control-content {
            overflow-y: auto;
            height: 100%;
        }
        .mui-segmented-control .mui-control-item {
            line-height: 45px;
            width: 100%;
        }
        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
            color:#ff464e;
        }
        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item{background-color: #fff;}
        .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item, .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item.mui-active{border-bottom:1px solid #e8e8e8; border-right:1px solid #e8e8e8;}
        .mui-segmented-control{font-weight:normal;}
        .mui-search{ display:inline-block; vertical-align:bottom; margin-left:10px;     padding-top: 2px; width:87%;}
        .mui-input-row.mui-search .mui-icon-clear{top:3px !important;}
        .mui-search .mui-placeholder{top:3px; font-size:12px;}
        .web-header-message{display:inline-block; margin-left:10px;}
        .mui-content{padding-bottom:47px;}
        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active{border-right:none !important;}
        .weui-search-bar{padding:0; background:#f6f6f6;}
        .weui-search-bar:after, .weui-search-bar:before{border:none;}
        .web-seach-box{height:30px; overflow:hidden; margin-top:3px; background:#f6f6f6;}
        input[type=search]{border-radius:20px; font-size:12px; margin-bottom:0;}
        .mui-bar input[type=search]{margin:0; padding:0; line-height:normal;}

        .web-header-seach{background:white; height:44px;}
        .weui-search-bar__box .weui-icon-search{top:2px; }
        .mui-bar .mui-icon{padding-top:5px;}
        .weui-search-bar__label span{font-size:12px;}
        .weui-search-bar__box .weui-search-bar__input{font-size:12px;}
        .cage-product-list>li>a{
            text-align: center;
        }
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body class="mhome">
<header class="mui-bar mui-bar-nav">
    <form action="/?mod=weidian&v_mod=search&_action=search&v_shop=<?php echo $v_shop; ?>" method="post">
    <div class="web-header-seach">
        <a href="javascript:;" class=" mui-action-back mui-icon mui-icon-left-nav mui-pull-left red"></a>
            <div class="web-seach-box">
                <div class="weui-search-bar" id="searchBar">
                    <div class="weui-search-bar__box">
                        <i class="weui-icon-search"></i>
                        <input type="search" name="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required>
                        <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                    </div>
                    <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                        <i class="weui-icon-search"></i>
                        <span>搜索您想要的产品</span>
                    </label>
                </div>
            </div>
        <a href="javascript:;"  class="web-header-message fl tc cl_b3">
            <p><i class="fa fa-commenting-o cl_b3"></i></p>
            <p class="f12 cl_b3" style="line-height:15px;">消息</p>
        </a>
    </div>
    </form>
</header>


<div class="mui-content mui-row mui-fullscreen">
    <div class="mui-col-xs-3">
        <!--a mui-active-->
        <div class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-vertical">
            <a onclick="location.href='/?mod=weidian&v_shop=<?php echo $v_shop; ?>&v_mod=category&_index=_product'"
               class="mui-control-item fr12">全部产品</a>
        </div>
        <?php
        $default = 0;
        $id = 0;
        if(isset($_GET['category']) && !empty($_GET['category']))
        {
            $id = $_GET['category'];
        }
        if($data[0])
        {
            $i = 0;
            foreach($data[0] as $item)
            {
                if(in_array($item['category_id'],$show_category))
                {
                    if($i==0)
                    {
                        $id = $id==0 && !$id ?$item['category_id']:$id;
                    }
                    ?>
                    <div class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-vertical">
                        <a onclick="location.href='/?mod=weidian&v_shop=<?php echo $v_shop; ?>&v_mod=category&category=<?php echo $item['category_id']; ?>'"
                           class="mui-control-item fr12 <?php if($item['category_id']==$id){echo 'mui-active';} ?>"><?php echo $item['category_name']; ?></a>
                    </div>
                    <?php
                    $i++;
                }
            }
        }
        ?>
    </div>
    <div id="segmentedControlContents" class="mui-col-xs-9" >
        <div class="mui-control-content mui-active">
            <?php
            if(isset($info['info'][0][$id]))
            {
                ?>
                <div class="mtr10">
                    <img src="<?php echo $info['info'][0][$id]['category_img']; ?>" style="width:96%; display:block; margin-left:4%;">
                </div>
                <?php
            }
            ?>
            <?php
            if($data)
            {
                if(isset($data[$id]) && !empty($id))
                {
                    foreach($data[$id] as $item)
                    {
                        ?>
                        <h1 style="padding:0 4%; font-weight:bold;" class="fr12 mtr10 cl_b3 omit">
                            <?php echo $item['category_name']; ?>
                        </h1>
                        <?php
                        if(!empty($data[$item['category_id']]))
                        {
                            ?>
                            <div class="bgF mtr10" style="margin-left:4%; padding:10px 0;">
                                <ul class="cage-product-list">
                                    <?php
                                    foreach ($data[$item['category_id']] as $val)
                                    {
                                        ?>
                                        <li>
                                            <a href="/?mod=weidian&v_shop=<?php echo $v_shop; ?>&v_mod=category&_index=_product&category=<?php echo $val['category_id']; ?>">
                                                <img src="/template/source/images/default.png" data-src="<?php echo $val['category_img'];  ?>">
                                                <p class="omit fr12"><?php echo $val['category_name'];  ?></p>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <div class="cb"></div>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</div>
<!----底部导航---->
<?php include "footer_tpl.php"; ?>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/js/fastclick.js"></script>
<script src="/template/source/js/lazy-load-img.min.js"></script>

<script>
    var controls = document.getElementById("segmentedControls");
    var contents = document.getElementById("segmentedControlContents");
    $(function(){
        $('.web-footer>a').eq(1).addClass('web-activer').siblings().removeClass('web-activer');
        FastClick.attach(document.body);

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
        $searchInput.on('blur', function () {
            if(!this.value.length) cancelSearch();
        })
            .on('input', function(){
                if(this.value.length) {
                    $searchResult.show();
                } else {
                    $searchResult.hide();
                }
            });
        $searchClear.on('click', function(){
            hideSearchResult();
            $searchInput.focus();
        });
        $searchCancel.on('click', function(){
            cancelSearch();
            $searchInput.blur();
        });
    });

    (function () {
        var lazyLoadImg = new LazyLoadImg({
            el: document.querySelector('.mhome'),
            mode: 'default', //默认模式，将显示原图，diy模式，将自定义剪切，默认剪切居中部分
            time: 300, // 设置一个检测时间间隔
            complete: true, //页面内所有数据图片加载完成后，是否自己销毁程序，true默认销毁，false不销毁
            position: { // 只要其中一个位置符合条件，都会触发加载机制
                top: 0, // 元素距离顶部
                right: 0, // 元素距离右边
                bottom: 0, // 元素距离下面
                left: 0 // 元素距离左边
            },
            diy: { //设置图片剪切规则，diy模式时才有效果
                backgroundSize: 'cover',
                backgroundRepeat: 'no-repeat',
                backgroundPosition: 'center center'
            },
            before: function () { // 图片加载之前执行方法
            },
            success: function (el) { // 图片加载成功执行方法
                el.classList.add('success')
            },
            error: function (el) { // 图片加载失败执行方法
                el.src = '/template/source/images/error.png'
            }
        })
    })()
</script>
</body>