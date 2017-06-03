<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetQuestion();
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
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/webapp.css">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/weixin/css/cart.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/sec.kill.css?777777">
    <style>
        .duo-header-shortcut{display:none;}
        .weui-cells__title{padding:0 .25rem; color:#5c5c5c;}
        .weui-btn_primary{background:#0174e1;}
        .weui-label{width:6rem;}
        .weui-cells{margin-top:5px;}
        .weui-cells:first-child{margin-top:10px;}
        .weui-cell_access .weui-cell__ft:after{-webkit-transition:all .3s; transition:all .3s; border-color:#09F;}
        .weui-cell_access .weui-cell__ft.down:after{content:'' -webkit-transform: rotate(134deg); transform: rotate(134deg); }
        .problem_view{}
        .consultation{padding:.5rem; background:white; position:fixed; bottom:0; left:0; width:100%; box-sizing:border-box; text-align:center; border-top:1px solid #ededed;}
        .consultation>a{padding:5px 30px; text-align:center; border:1px solid #666; color:#333; display:inline-block; border-radius:3px; vertical-align:middle; margin:0 5px;}

    </style>
</head>
<body>
<header>
    <div id="m_common_header"><header class="duo-header">
            <div class="duo-header-bar">
                <div id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
                <div class="duo-header-title">常见问题</div>
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
<div class="problem" >
    <?php
        if($data)
        {
            foreach($data as $item)
            {
                ?>
                <div class="weui-cells">
                    <div class="weui-cell weui-cell_access problem_en <?php echo $item['is_show_answer']==0?'yes':''; ?>">
                        <div class="weui-cell__bd">
                            <p class="rf14" style="color:#09F">问：<?php echo $item['qusetion']; ?></p>
                        </div>
                        <div class="weui-cell__ft <?php echo $item['is_show_answer']==0?'down':'up';?>down"></div>
                    </div>
                    <div class="weui-cell problem_view" style="display: <?php echo $item['is_show_answer']==0?'block':'none'; ?>">
                        <div class="weui-cell__bd">
                            <p class="rf13 cl_b3">答：<?php echo $item['answer']; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    ?>
</div>
<p class="mt10 rf13 cl_b9" style="padding:0 3%;">温馨提示：如果没有您想要的问题，可进行反馈</p>
<div style="height:2.2rem;"></div>
<div class="consultation">
    <a href="?mod=weixin&v_mod=user&_index=_feedback">我要反馈</a>
    <a href="http://wpa.qq.com/msgrd?v=3&uin=1992386583&site=qq&menu=yes" target="_blank">联系客服</a>
</div>
<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/template/source/weixin/js/fastclick.js"></script>
<script src="/template/source/weixin/js/jquery-weui.min.js"></script>
<script src="/template/source/weixin/js/city-picker.js"></script>
<script src="/template/source/weixin/js/guageEdit.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>

<script>

    $(function(){
        $('.problem_en').on('click',function(){

            if($(this).hasClass('yes')){
                $(this).children('.weui-cell__ft').removeClass('down');
                $(this).next('.problem_view').slideUp(100);
                $(this).removeClass('yes');
            }else{
                $(this).children('.weui-cell__ft').addClass('down');
                $(this).next('.problem_view').slideDown(100);
                $(this).addClass('yes');
            }

        })

    })

</script>
</body>
</html>