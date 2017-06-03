<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetGroupBuyDetail();
$group_buy_list = $obj->GetGroupBuyList($data['group_id']);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$weburl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$array=module('jsapi')->config($weburl);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>邀请好友来参团</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .can-renshu{padding:.2rem 3%; text-align: center;}
        .can-renshu .can-renshu-item{width:.8rem; height:.8rem; border:2px solid #FFF; border-radius:50%; background:#cccccc url(/template/source/images/my.jpg) center center no-repeat; background-size:80% 80%;  display: inline-block; margin: 0 .1rem; position:relative}
        .can-renshu .can-renshu-item>img{width:100%; height:100%; display:block; border-radius:50%;}
        .can-renshu .can-renshu-item>span{width:.3rem; height: .3rem; border:2px solid #fff; position:absolute; top: -.02rem; right: -.02rem; border-radius: 50%; color:#FFF; font-size:10px;}
        .can-renshu .can-renshu-item:nth-child(1)>span{background:red;}
        .can-renshu .can-renshu-item:nth-child(2)>span{background:orange;}
        .endTime{position: relative; margin-top: .4rem;}
        .endTime::before{content: ''; width:1rem; height: 1px; border-top:1px solid #dedede; position:absolute; top: 50%; left:3%;}
        .endTime::after{content: ''; width:1rem; height: 1px; border-top:1px solid #dedede; position:absolute; top: 50%; right:3%;}
        .endTime>span{display: inline-block; vertical-align: middle; background:#333; color:white; width:.4rem; height:.4rem; text-align: center; line-height: .4rem; border-radius:3px;}
        .can-main{position: relative;}
        .can-main::before{ content:'';width:.2rem; height:.2rem; position:absolute; left: 50%; margin-left: -.1rem; top: -.1rem; z-index: 99; background:#333;     transform: rotate(45deg);    -webkit-transform: rotate(45deg); -moz-transform: rotate(45deg);}
        .weui-cells:first-child{background:#333; margin-top: .4rem;}
        .weui-cells:first-child .weui-cell__bd p{color:white;}
        .weui-cells:first-child .weui-cell__ft{color:white;}
        .weui-cells:nth-child(2){background:#f4f8d4; }
        .members-foot{padding:.2rem 3%; background:rgba(0,0,0,.7); position:fixed; bottom:0; display:flex; display:-webkit-flex; display:-moz-flex; width:94%; left:0;}
        .members-foot>.ftgb{width:.7rem; height:.7rem;  border-radius:3px; margin-right: .2rem; display: block;  }
        .members-foot>.ftcantuan{display: block;  -webkit-box-flex: 1;  -webkit-flex: 1;  flex: 1; height:.7rem; background:red; border-radius:3px; text-align: center; line-height: .7rem; color:white;}
        .tuanzhang{
            width:.5rem; height:.5rem; margin-right: .2rem;display:block;border-radius:50%;
        }
        *{margin:0px;padding: 0px;}
        #shareit {-webkit-user-select: none;display: none;position: absolute;width: 100%;height: 100%;
            background: rgba(0,0,0,0.85);text-align: center;top: 0;left: 0;z-index: 105;
        }
        #shareit img { max-width: 100%;}
        .arrow {position: absolute; right: 10%;top: 5%;}
        #follow{width: 100%;height: 50px;line-height: 50px;text-align: center; text-decoration: none;font-size: 18px;color: white;float: left;margin-top: 400px;}
    </style>
    <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
</head>
<body>
<div id="gg-app" style="padding:0 0 0 0">
    <?php if ($data['group_present_nums']>0)
    {
        $share_title='我正在参加拼团【'.addslashes($data['product_name']).'】';
        $share_desc='【拼团仅剩'.$data['group_present_nums'].'个名额】一起拼团更优惠哦';
        ?>
        <?php
            if($data['group_status']==1)
            {
                ?>
                <div class="txtc" style="padding:.4rem 3% .2rem">
                    <h1 class="sz16r" style="color:#09BB07;"><i class="weui-icon-success mr5"></i>快来参团吧</h1>
                    <p class="sz14r mtr01">就差<?php echo $data['group_present_nums']; ?>人就开团了</p>
                </div>
                <?php
            }
        ?>
    <?php
    }else
    {
        $share_title='我以'.$data['group_price'].'元成功拼团【'.addslashes($data['product_name']).'】';
        $share_desc=addslashes($data['product_desc']);
        $weburl=WEBURL.'/?mod=weixin&v_mod=product&_index=_view&id='.$data['product_id'];
        ?>
        <div class="txtc" style="padding:.4rem 3% .2rem">
            <h1 class="sz16r" style="color:#09BB07;"><i class="weui-icon-success mr5"></i>开团成功</h1>
            <p class="sz14r mtr01">分享可获得更多奖励哦</p>
        </div>
    <?php
    }?>

    <div class="gg-shopping-container">
        <ul class="gg-shopping-warp">
            <li class="gg-shopping-item" data-active="true">
                <div class="fl gg-shopping-proImg" onclick="location.href='/?mod=weixin&v_mod=product&_index=_view&id=<?php echo $data['product_id']; ?>'">
                    <img src="<?php echo $data['product_img']; ?>">
                </div>
                <div class="fr gg-shopping-main">
                    <p class="omit sz14r"><?php echo $data['product_name']; ?></p>
                    <p class="tlie sz12r cl999"><?php echo $data['product_desc']; ?></p>
                    <div class="shopping-main-bottom ">
                        人数：<span class="cldb3652 sz14r "><?php echo $data['group_all_count']; ?></span>
                        团购价：<span class="cldb3652 sz14r ">￥<?php echo $data['group_price']; ?></span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </li>
        </ul>
    </div>

    <div class="can-renshu">
        <?php
            $join_id = array();
            $list ='';
            if($group_buy_list)
            {
                $i = 0;
                $arr = array('团','沙','凳');
                foreach($group_buy_list as $item)
                {
                    $level = '';
                    if($i<3)
                    {
                        $level = $arr[$i];
                    }else{
                        $level = '参';
                    }
                    $join_id[] = $item['userid'];
                    $list .= '<div class="weui-cells" >';
                    $list .= '       <div class="weui-cell">';
                    $list .= '           <div class="weui-cell__hd">';
                    $list .= '               <img src="'.$item['headimgurl'].'" style="width:.5rem; height:.5rem; margin-right: .2rem;  display:block; border-radius:50%;">';
                    $list .= '           </div>';
                    $list .= '           <div class="weui-cell__bd">';
                    $list .= '               <p class="sz14r">'.$level.$item['nickname'].'</p>';
                    $list .= '           </div>';
                    $list .= '           <div class="weui-cell__ft sz12r">'.$item['pay_date'].'时间参团</div>';
                    $list .= '       </div>';
                    $list .= '  </div>';
                    ?>
                    <div class="can-renshu-item">
                        <img title="<?php echo $item['nickname']; ?>" src="<?php echo $item['headimgurl']; ?>">
                        <span><?php echo $level; ?></span>
                    </div>
                    <?php
                    $i++;
                }
                for($j=$i;$j<$data['group_all_count'];$j++)
                {
                    $level = '';
                    if($j<3)
                    {
                        $level = $arr[$i];
                    }else{
                        $level = '拼';
                    }
                    ?>
                    <div class="can-renshu-item">
                        <img title="" src="">
                        <span><?php echo $level; ?></span>
                    </div>
                    <?php
                }
            }
        ?>
    </div>

    <?php
        $button = '';
        if($data['group_status']==-1 || ($data['end_time']<date("Y-m-d H:i:s") && $data['group_status']<2))
        {
            $button.='<a href="/?mod=weixin&v_mod=group&_index=_product" class="ftcantuan sz14r">看看其它团购</a>';
            ?>
            <p class="txtc sz14r">团购失败<br>
                未在规定时间内凑满参团人数，系统将在1-3个工作日原路退款
            </p>
            <?php
        }elseif($data['group_status']==2 || $data['group_present_nums']==0)
        {
            $button.='<a class="ftcantuan sz14r">已完成</a>';
            ?>
            <p class="txtc sz14r">拼团成功<br>
                仓库正在给您安排发货
            </p>
            <?php
        }else{
            if(SYS_USERID!=$data['userid'])
            {
                if(in_array(SYS_USERID,$join_id))
                {
                    $button.='<a class="ftcantuan sz14r">已参与拼团</a>';
                }else{
                    $button.='<a class="ftcantuan sz14r"  href="?mod=weixin&v_mod=checkout&_index=_group_join&gid='.$data['group_id'].'">一键拼团</a>';
                }
            }else{
                $button.='<a class="ftcantuan sz14r">进行中</a>';
            }
            ?>
            <p class="txtc sz14r">还差<b class="cldb3652 sz16r ml5 mr5"><?php echo $data['group_present_nums']; ?></b>人，赶快邀请好友来参团吧</p>
            <div class="endTime txtc">

                <!--剩余
                   <span>1</span>
                   天
                   <span>18</span>
                   :
                   <span>18</span>
                   :
                   <span>18</span>
                   结束-->
            </div>
            <script>
                function p (n){
                    return n < 10 ? '0'+ n : n;
                }
                var countDown = <?php echo strtotime($data['end_time'])-time() ?>;
                //倒计时函数
                function newTime(){
                    //定义当前时间
                    //定义结束时间
                    countDown--;
                    //获取天数 1天 = 24小时  1小时= 60分 1分 = 60秒
                    var oDay=Math.floor(countDown/(60*60*24));
                    //获取小时数
                    //特别留意 %24 这是因为需要剔除掉整的天数;
                    var oHours = Math.floor(countDown/(60*60)%24);
                    //获取分钟数
                    //同理剔除掉分钟数
                    var oMinutes = Math.floor(countDown/60%60);
                    //获取秒数
                    //因为就是秒数  所以取得余数即可
                    var oSeconds = Math.floor(countDown%60);
                    var nMS =  Math.floor(countDown / 100) % 10 ;
                    //下面就是插入到页面事先准备容器即可;
                    var html =  "剩余：<span>"+p(oDay)+"</span>:<span>"+ p(oHours)+"</span>:<span>"+p(oMinutes)+ "</span>:<span>"+p(oSeconds)+"</span> 结束";
                    //别忘记当时间为0的，要让其知道结束了;
                    if(countDown < 0){
                        $(".endTime").html("人数不足，参团失败");
                    }else{
                        $(".endTime").html(html);
                    }
                }
                setInterval(newTime,1000);
                newTime();
            </script>
            <?php
        }
    ?>
    <div class="can-main">
       <?php echo $list; ?>
    </div>
    <div style="height:1.4rem;"></div>
    <div class="members-foot">
        <a class="ftgb" id="fenxiang" style="background:#333 url(/template/source/images/icon-share-white.png) center center no-repeat; background-size:.4rem .4rem;"></a>
        <?php echo $button; ?>
    </div>
</div>
<div id="shareit">
    <img class="arrow" src="/template/source/images/share.png">
    <a href="#" id="follow">点击右上角按钮，分享给朋友</a>
</div>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/template/source/js/textarea.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    $("#fenxiang").click(function () {
        $("#shareit").show();
    });
    $("#shareit").click(function () {
        $("#shareit").hide();
    });
    var tTitle='<?php echo $share_title; ?>';
    var tContent='<?php echo $share_desc; ?>';
    window.shareData ={
        "imgUrl": "<?php echo CDNURL.$data['product_img']; ?>",
        "sendFriendLink":"<?php echo $weburl; ?>",
        "tTitle": tTitle,
        "tContent": tContent
    };
    wx.config({
        debug:  false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $array['appId']; ?>', // 必填，公众号的唯一标识
        timestamp:<?php echo $array['timestamp']; ?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $array['noncestr']; ?>', // 必填，生成签名的随机串
        signature:'<?php echo $array['signature']; ?>',// 必填，签名，见附录1
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
        ]
    });

    wx.ready(function (){
        wx.onMenuShareAppMessage({
            title: window.shareData.tTitle,
            desc: window.shareData.tContent,
            link: window.shareData.sendFriendLink,
            imgUrl: window.shareData.imgUrl,
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
            },
            cancel: function () {
            }
        });
        wx.onMenuShareTimeline({
            title: window.shareData.tTitle,
            link: window.shareData.sendFriendLink,
            imgUrl: window.shareData.imgUrl,
            success: function () {

            },
            cancel: function () {
            }
        });
    });
</script>
</body>
</html>