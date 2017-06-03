<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetBargainProductDetail();
if(empty($data))
{
    redirect(NOFOUND.'&msg=已过期');
}
$allRanking = $obj->GetBargainRankingList();
$ranking = $allRanking['data'];
$my = $allRanking['my'];
$myRanKing = $obj->GetMyRankingList();
//分享
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$weburl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$array=module('jsapi')->config($weburl);
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
    <title>砍一刀</title>
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/jquery-weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/webapp.css">
    <link type="text/css" rel="stylesheet" href="/template/source/bargain/css/guageEdit.css">
    <style>
        .information-mask{
            position: fixed;
            z-index: 1000;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
        }
        .information-dialog{
            position: fixed;
            z-index: 5000;
            width: 80%;
            max-width: 300px;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            background-color: #FFFFFF;
            text-align: center;
            border-radius: 3px;
            overflow: hidden;

        }
        /*.xm-details-productBox,.xm-details-priceBox{display:none;}*/
        .xm-details-productBox{display:block;}
        /*.xm-details-button>a{display:none;}*/
        #showIOSDialog1{display:block;}
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
        .xm-activity-panel{
            min-height: 100px;
        }


    </style>
</head>
<body class="mhome">



<div class="xm-conent">
    <div class="xm-details-box">
        <div class="xm-details-bg"><img src="/template/source/bargain/images/activie.jpg" class="db"></div>
        <div id="xm-details-box">
            <?php
            if(isset($my[$data['id']][SYS_USERID]) &&
                !empty($my[$data['id']][SYS_USERID]))
            {
                $now_total=($my[$data['id']][SYS_USERID]['minus_money']+$my[$data['id']][SYS_USERID]['help_money']);
                //剩余的价钱
                $surplus = $data['product_price']-$now_total; ?>
                <!---砍出金额框---->
                <div class="xm-details-prize xm-details-priceBox">
                    <div class="xm-details-price">
                        <div class="weui-cells no-weui-link" style="margin-top:0;">
                            <div class="weui-cell" style="padding:0;">
                                <div class="weui-cell__bd">
                                    <div class="tc rf16" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC"><b class="rmr5"><?php echo $my[$data['id']][SYS_USERID]['minus_money'];?></b>元</div>
                                    <p class="tc rf14" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC">恭喜，一刀砍出了</p>
                                    <p class="tc rf14" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC">距离底价还剩<?php echo $surplus-$data['min_price']>0?$surplus-$data['min_price']:0; ?>元</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }else
            {
                ?>
                <!---产品显示框---->
                <div class="xm-details-prize xm-details-productBox" >
                    <div class="xm-details-price">
                        <div class="weui-cells no-weui-link" style="margin-top:0;">
                            <div class="weui-cell" style="padding:0;">
                                <div class="weui-cell__hd">
                                    <img src="/template/source/bargain/images/default.png" data-src="<?php echo $data['product_img'];?>" style="width:3rem; height: 3rem; display:block; margin-right:.5rem;">
                                </div>
                                <div class="weui-cell__bd" style="width:50%;">
                                    <h1 class="omit rf14"><?php echo $data['product_name'];?></h1>
                                    <p class="rf12 cl_b9 omit rmt5"><?php echo $data['product_desc'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>


        <div class="xm-details-progress rmt15">
            <div class="xm-progress-icon">
                <span class="xm-progress-flex"></span>
                <span class="xm-progress-flex"></span>
                <span class="xm-progress-flex"></span>
                <span class="xm-progress-flex"></span>
                <span class="xm-progress-flex"></span>
                <span class="xm-progress-flex"></span>

            </div>
            <div class="xm-progress-strip">
                <div class="xm-progress-strip-active fullexpand" data-width="<?php echo $data['join_count'];?>"></div>
            </div>
            <div class="xm-progress-user">
                <span class="xm-progress-item rf12">0人</span>
                <span class="xm-progress-item rf12">25人</span>
                <span class="xm-progress-item rf12">50人</span>
                <span class="xm-progress-item rf12">75人</span>
                <span class="xm-progress-item rf12">100人</span>
                <span class="xm-progress-item rf12">500人</span>
            </div>
        </div>
        <?php

        ?>
        <p class="rmt15 rf12 tc" style="color:#fccc4e;">最高500个人参与，砍到最低价￥<?php echo $data['min_price']; ?>为止</p>
        <div class="xm-details-button rmt15">
            <?php

            if(isset($my[$data['id']][SYS_USERID]) &&
                !empty($my[$data['id']][SYS_USERID]))
            {
                if($my[$data['id']][SYS_USERID]['over_status'])
                {
                    ?>
                    <a href="javascript:;" class="rf15" id="showShare">您已成功参与过，可邀朋友参与</a>
                <?php
                }elseif($data['min_price']>=$surplus)
                {
                    ?>
                    <a href="/?mod=weixin&v_mod=product&_index=_view&id=<?php echo $data['product_id']; ?>" class="rf15">
                        砍价成功！￥<?php echo $data['min_price']; ?>马上拿走
                    </a>
                <?php
                }
                else
                {
                    ?>
                    <a href="javascript:;" data-id="<?php echo $my[$data['id']][SYS_USERID]['id']?>" class="rf15" id="showShare">找朋友继续砍</a>
                    <?php
                }
            }else
            {
                ?>
                <a href="javascript:;" class="rf15" id="determine">我要参与</a>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="xm-activity-tabs">
        <a href="javascript:;" class="xm-activity-flex rf14 xm-activity-active">排行榜</a>
        <a href="javascript:;" class="xm-activity-flex rf14">帮我砍的人</a>
        <a href="javascript:;" class="xm-activity-flex rf14">活动说明</a>
    </div>

    <div class="xm-activity-panel">
        <div class="xm-activity-item">
            <div class="weui-cells no-weui-link" style="margin-top:0; background:none;">
                <?php
                if(!empty($ranking))
                {
                    foreach($ranking as $item)
                    {
                        ?>
                        <div class="weui-cell" >
                            <div class="weui-cell__hd">
                                <img src="/template/source/bargain/images/default.png" data-src="<?php echo $item['headimgurl'];?>" style="width:3rem; height: 3rem; display: block; margin-right:.5rem;">
                            </div>
                            <div class="weui-cell__bd">
                                <h1 class="rf14" style="color:#fbc848;"><?php echo $item['nickname'];?></h1>
                            </div>
                            <div class="weui-cell__nd">
                                <p class="rf14 white rmr10 "><?php echo $item['help_count'];?>人帮砍</p>
                            </div>
                            <div class="weui-cell__ft">
                                <p class="rf14" style="color:#fbc848">-<?php echo $item['minus_money']+$item['help_money'];?>元</p>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>

        </div>

        <div class="xm-activity-item">
            <div class="weui-cells no-weui-link" style="margin-top:0; background:none;">
                <?php
                if(!empty($myRanKing))
                {
                    foreach($myRanKing as $item)
                    {
                        ?>
                        <div class="weui-cell" >
                            <div class="weui-cell__hd">
                                <img src="/template/source/bargain/images/default.png" data-src="<?php echo $item['headimgurl'];?>" style="width:3rem; height: 3rem; display: block; margin-right:.5rem;">
                            </div>
                            <div class="weui-cell__bd">
                                <h1 class="rf14" style="color:#fbc848;"><?php echo $item['nickname'];?></h1>
                                <!--                                    <p class="white rmt10 rf14">158****5020</p>-->
                            </div>
                            <div class="weui-cell__ft">
                                <p class="rf14" style="color:#fbc848">-<?php echo $item['minus_money'];?>元</p>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="xm-activity-item">
            <div class="xm-explain-box">
                <div class="xm-explain-title rf15">
                    <b>关于活动</b>
                </div>
                <div class="xm-explain-textarea rmt10 rf14 white lh20">
                    在“乡粑网”平台发起“找朋友，帮砍价”活动后，通过该活动所获得的金额将以优惠的形式放到用户账号，在用户支付商品时直接抵扣。
                </div>
            </div>
            <div class="xm-explain-box">
                <div class="xm-explain-title rf15">
                    <b>活动规则</b>
                </div>
                <div class="xm-explain-textarea rmt10 rf14 white lh20">
                    <p class="rmb5">1、砍价活动自用户点击“找好友帮我砍价”按钮开始计时，活动持续24小时</p>
                    <p class="rmb5">2、每个活动最多允许500个好友帮忙砍价</p>
                    <p class="rmb5">3、活动结束时，微信好友砍价的总金额即会以优惠的形式发放到用户账户中</p>
                    <p class="">4、砍价所获得的优惠不能重复使用</p>
                    <p class="">5、砍到底价才能付款购买</p>
                </div>
            </div>
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
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    $(function () {
        var full =  $(".fullexpand").attr("data-width");
        $(".fullexpand").css("width",full/10+"%")

        $(".xm-activity-tabs .xm-activity-flex").on("click",function(){
            $(".xm-activity-tabs .xm-activity-flex").removeClass("xm-activity-active");
            $(this).addClass("xm-activity-active");
            var _index = $(this).index();
            $(".xm-activity-panel .xm-activity-item").eq(_index).show().siblings().hide();
        })

        var information = $(".information");

        $("#showIOSDialog1").on("click",function(){
            information.fadeIn(200);
        })
        $("#cancel").on("click",function(){
            information.fadeOut(200);
        })
        $(".information-mask").on("click",function(){
            information.fadeOut(200);
        })

        $("#determine").on("click",function(){
            var id = '<?php echo $data['id'];?>' ;
            layer.open({
                content: '您确定要自砍一刀吗？'
                ,btn: ['来嘛，砍我啊！', '我怕，算了']
                ,yes: function(index){
                    //lin
                    $.ajax({
                        cache:false,
                        type:"POST",
                        url:"/?mod=weixin&v_mod=bargain&_action=ActionBargain",
                        data:{'id':id},
                        dataType:"json",
                        success:function(result) {
                            if (result.code==0)
                            {
                                /*information.fadeOut(200);
                                $(".xm-details-productBox").remove();
                                $("#xm-details-box").html(' <div class="xm-details-prize xm-details-priceBox">'+
                                    '<div class="xm-details-price">'+
                                    '<div class="weui-cells no-weui-link" style="margin-top:0;">'+
                                    '<div class="weui-cell" style="padding:0;">'+
                                    '<div class="weui-cell__bd">'+
                                    '<div class="tc rf16 lh30" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC"><b class="rmr5">'+result.money+'</b>元</div>'+
                                    '<p class="tc rf14 lh30" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC">恭喜，一刀砍出了</p>'+
                                    '</div></div></div></div></div>');
                                $(".xm-details-button").html('<a href="javascript:;" data-id="'+result.id+'" class="rf15" id="showShare">找朋友继续砍</a>');
                                //$("#showShare").css("display","block");*/

                                alert(result.msg);
                                window.location.reload();
                            }else
                            {
                                layer_msg(result.msg);
                            }
                        },
                        error:function(result) {
                            layer_msg("网络超时,请重试!");
                        }
                    });
                    layer.closeAll();
                }
            });

        });
        $("#showShare").on("click",function() {
            $(".win").show();
        });
        $(".win").on("click",function() {
            $(this).hide();
        })

    });
    function layer_msg(msg)
    {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }

    //分享
    var shareId = $('#showShare').attr('data-id');
    //alert(shareId);
    var tContent='<?php echo $data['product_desc'];?>';
    window.shareData ={
        "imgUrl": "<?php echo CDNURL.$data['product_img']; ?>",
        "sendFriendLink":"<?php echo $weburl.'?mod=weixin&v_mod=bargain&_index=_help&id='; ?>"+shareId,
        "tTitle": '帮忙砍一刀',
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