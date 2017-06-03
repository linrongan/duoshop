<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$quantum = $obj->GetToDayQuantum();
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
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/rest.css?66666">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/main.css?7s8ad8asd7asd">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/newmain.css?1010aaa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/ggPublic.css?8888aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/moban1.css?777777">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/template/source/weixin/css/cart.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/sec.kill.css?777777">
    <style>
        .duo-header-shortcut{display:none;}
		.tap-list{height:51px;}
    </style>
</head>
<body >
<header>
    <div id="m_common_header"><header class="duo-header">
            <div class="duo-header-bar">
                <div onclick="location.href='/?mod=weixin'" id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
                <div class="duo-header-title">商品秒杀</div>
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
                <li class="J_ping current" id="m_common_header_shortcut_p_cart">
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




<div class="new-skill-wrap">
    <div style="height: 51px; position: relative;">
        <header class="topfixed" id="topfixed" style="position: static;">
            <ul class="tap-list">
                <?php
                    $select_quantum = $now_select_text=array();
                    $day=date("Y-m-d H:i:s");
                    if($quantum)
                    {
                        foreach($quantum as $item)
                        {
                            $selected = false;
                            $now_select=false;
                            if($item['start_time']<=date("H:i:s",time()) && $item['end_time']>=date("H:i:s",time()))
                            {
                                $now_select=true;
                                $select_quantum = $item;
                                $selected = true;
                                $now_select_text[$item['quantum_id']]='秒杀中';
                            }
                            if (isset($_REQUEST['quantum']) && $_REQUEST['quantum']==$item['quantum_id'] && !$now_select)
                            {
                                $now_select=false;
                                $select_quantum = $item;
                                $selected = true;
                                $now_select_text[$item['quantum_id']]='等待秒杀';
                            }
                             ?>
                            <li onclick="window.location.href='/?mod=weixin&v_mod=seckill&quantum=<?php echo $item['quantum_id']; ?>'" class="<?php echo $selected?'cur':''; ?>"  style="width: 20%">
                                <p><?php echo $item['quantum']; ?></p>
                                <p>
                                    <?php echo $now_select?'秒杀中':'即将开场'; ?>
                                </p>
                            </li>
                            <?php
                        }
                    }

                    if (count($quantum)<6)
                    {
                        $last_day=$obj->GetLastQuantum();
                        if (!empty($last_day))
                        {
                            if (isset($_REQUEST['last_day']))
                            {
                                $select_quantum['quantum_id']=$last_day['quantum_id'];
                                $now_select_text[$last_day['quantum_id']]='即将登场';
                                $day=$last_day['start_day'];
                                $select_quantum['end_time']=$last_day['end_time'];
                                $selected=true;
                            }?>
                            <li onclick="window.location.href='/?mod=weixin&v_mod=seckill&quantum=<?php echo $last_day['quantum_id']; ?>&last_day'" class="<?php echo $selected?'cur':''; ?>"  style="width: 20%">
                                <p><?php echo date("m-d",strtotime($last_day['start_day'])); ?></p>
                                <p>
                                    秒杀提前看
                                </p>
                            </li>
                    <?php
                        }
                    }
                ?>
            </ul>
        </header>
    </div>
    <div class="errPic" style="display:none">
        <img src="/template/source/weixin/images/kill-rocket.png">
        <span class="errPic-content">秒杀商品正在路上</span>
    </div>
    <?php
        if($select_quantum)
        {
            $product = $obj->GetQuantumProduct($select_quantum['quantum_id'],$day);
            ?>
            <div class="seckill-body">
                <header class="list-head">
                    <div style="display: none;">
                        <span class="seckill-status" id="seckillTile">秒杀中</span>
                        <span class="seckill-round-no" id="seckillRoundNo"><?php echo $select_quantum['quantum']; ?></span>
                    </div>
                    <span class="buy-txt" id="seckillBuyTxt">秒杀中 先下单先得哦</span>
                    <span class="time">
                <span class="static-txt-end" id="staticTxtEnd">距结束</span>
                    <div id="seckill_time" class="timeText">
                        <span class="seckill-time">00</span>
                        <span class="time-separator">:</span>
                        <span class="seckill-time">00</span>
                        <span class="time-separator">:</span>
                        <span class="seckill-time">00</span>
                    </div>
                </span>
                </header>
                <script>
                    function n(count){
                        if(count > 9){
                            return count
                        }else{
                            return '0'+ count;
                        }
                    }
                    var eValue = document.getElementById('seckill_time');
                    var countDown = <?php echo strtotime($select_quantum['end_time'])-strtotime(date("H:i:s",time())); ?>;
                    var clean = setInterval(getRTime,1000);
                    getRTime();
                    function getRTime()
                    {
                        //var star_date = new Date();
                        countDown = countDown - 1;
                        var oDay =  Math.floor(countDown/(24*60*60));
                        //alert(oDay);
                        //获取小时数
                        //特别留意 %24 这是因为需要剔除掉整的天数;
                        var oHours = Math.floor(countDown/(60*60)%24);
                        //获取分钟数
                        //同理剔除掉分钟数
                        var oMinutes = Math.floor(countDown/60%60);
                        //获取秒数
                        //因为就是秒数  所以取得余数即可
                        var oSeconds = Math.floor(countDown%60);
                        var myMS=Math.floor(countDown/100) % 10;
                        if(countDown > 0){
                            eValue.innerHTML = '<span class="seckill-time">'+n(oHours)+'</span><span class="time-separator">:</span><span class="seckill-time">'+n(oMinutes)+'</span><span class="time-separator">:</span><span class="seckill-time">'+n(oSeconds)+'</span>';
                        }else{
                            eValue.innerHTML = '已结束';
                            clearInterval(clean);
                        }
                    }
                </script>
                <div class="skill-hot">
                    <ul class="good-list bdr-b seckilling">
                        <?php
                            if($product['data'])
                            {
                                foreach($product['data'] as $item)
                                {
                                    if ($now_select_text[$item['quantum_id']]=='秒杀中')
                                    {
                                        $speed = ceil($item['seckill_buy_stock']/$item['seckill_stock']*100);
                                    }else
                                    {
                                        $speed=0;
                                    }
                                    ?>
                                    <li class="bdr-bom">
                                        <a href="?mod=weixin&v_mod=product&_index=_view&id=<?php echo $item['product_id']; ?>">
                                            <div class="skill-pic">
                                                <div class="img">
                                                    <img src="<?php echo $item['product_img']; ?>" style="animation: fade 400ms 0s;">
                                                </div>
                                            </div>
                                            <p class="g-title"><?php echo $item['product_name']; ?></p>
                                            <p class="g-price"><i class="doller">￥</i><?php echo $item['seckill_price']; ?><span class="f-s-12"></span></p>
                                            <div class="skill-price">
                                                <p class="g-price-odd">
                                                    <del>￥<?php echo $item['product_price']; ?></del>
                                                </p>
                                                <!--11.23进度条部分zyl-->
                                                <div class="skill-lod">
                                                    <span class="sale-count" id="sale-count-b">已秒<em><?php echo $speed; ?>%</em></span>
                                                    <div id="progress-b" class="kill-progress">
                                                        <div class="skill-pro-bg">
                                                            <p class="skill-iteam-progress">
                                                            <span class="skill-pro-insetbg">
                                                                <span class="skill-iteam-pro" style="width: <?php echo $speed; ?>%;"></span>
                                                            </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--11.23进度条部分zyl结束-->
                                            </div>
                                                <span class="skill-count"><?php echo $now_select_text[$item['quantum_id']]; ?></span>
                                        </a>
                                        <div class="mask">
                                            <p><?php echo $item['seckill_stock']<=0?'秒杀完':$now_select_text[$item['quantum_id']]; ?></p>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
    ?>
</div>
<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script>
    $(function()
    {
        var a = true;
        $('#m_common_header_jdkey').click(function()
        {
            if(a){
                $('#m_common_header_shortcut').css('display','table');
                a = false;
            }else{
                $('#m_common_header_shortcut').css('display','none');
                a = true;
            }
        })
    });
</script>
</body>
</html>