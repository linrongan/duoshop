<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}


$create_data = $obj->getCreateDetails();
if(empty($create_data))
{
    redirect(NOFOUND.'&msg=该用户还没发起砍价');
}
if($create_data['userid']==SYS_USERID)
{
    redirect('?mod=weixin&v_mod=bargain&_index=_view&id='.$create_data['bargain_id']);
}
$data = $obj->GetBargainProductDetail($create_data['bargain_id']);
if(empty($data))
{
    redirect(NOFOUND.'&msg=已过期');
}
$createRanking = $obj->GetCreateRankingList();
$my_data = $createRanking['my'];
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
            if(isset($my_data[SYS_USERID]) &&
                !empty($my_data[SYS_USERID]))
            {
                ?>
                <!---砍出金额框---->
                <div class="xm-details-prize xm-details-priceBox">
                    <div class="xm-details-price">
                        <div class="weui-cells no-weui-link" style="margin-top:0;">
                            <div class="weui-cell" style="padding:0;">
                                <div class="weui-cell__bd">
                                    <div class="tc rf16 lh30" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC"><b class="rmr5"><?php echo $my_data[SYS_USERID]['minus_money'];?></b>元</div>
                                    <p class="tc rf14 lh30" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC">恭喜，一刀帮朋友砍出了</p>
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
        <p class="rmt15 rf12 tc" style="color:#fccc4e;">最高500个人参与，砍到最低价为止</p>
        <div class="xm-details-button rmt15">
            <?php
            if(isset($my_data[SYS_USERID]) &&
                !empty($my_data[SYS_USERID]))
            {
                ?>
                <a href="?mod=weixin&v_mod=bargain&_index=_list" class="rf15" >我也要玩</a>
                <?php
            }else
            {
                ?>
                <a href="javascript:;" class="rf15" id="determine">帮朋友砍一刀</a>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="xm-activity-tabs">
        <a href="javascript:;" class="xm-activity-flex rf14 xm-activity-active">帮他砍的人</a>
        <a href="javascript:;" class="xm-activity-flex rf14">活动说明</a>
    </div>

    <div class="xm-activity-panel">
        <div class="xm-activity-item">
            <div class="weui-cells no-weui-link" style="margin-top:0; background:none;">
                <?php
                if(!empty($createRanking['data']))
                {
                    foreach($createRanking['data'] as $item)
                    {
                        ?>
                        <div class="weui-cell" >
                            <div class="weui-cell__hd">
                                <img src="/template/source/bargain/images/default.png" data-src="<?php echo $item['headimgurl'];?>" style="width:3rem; height: 3rem; display: block; margin-right:.5rem;">
                            </div>
                            <div class="weui-cell__bd">
                                <h1 class="rf14" style="color:#fbc848;"><?php echo $item['nickname'];?></h1>
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
<script>
    $(function () {
        var full =  $(".fullexpand").attr("data-width");
        $(".fullexpand").css("width",full+"%")

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
            var id = '<?php echo $_GET['id'];?>' ;
            layer.open({
                content: '您确定要帮朋友砍一刀吗？'
                ,btn: ['给他一刀', '残忍拒绝']
                ,yes: function(index){
                    //lin
                    $.ajax({
                        cache:false,
                        type:"POST",
                        url:"/?mod=weixin&v_mod=bargain&_action=ActionBargainHelpFriend",
                        data:{'id':id},
                        dataType:"json",
                        success:function(result) {
                            if (result.code==0)
                            {
                                information.fadeOut(200);
                                $(".xm-details-productBox").remove();
                                $("#xm-details-box").html(' <div class="xm-details-prize xm-details-priceBox">'+
                                    '<div class="xm-details-price">'+
                                    '<div class="weui-cells no-weui-link" style="margin-top:0;">'+
                                    '<div class="weui-cell" style="padding:0;">'+
                                    '<div class="weui-cell__bd">'+
                                    '<div class="tc rf16 lh30" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC"><b class="rmr5">'+result.money+'</b>元</div>'+
                                    '<p class="tc rf14 lh30" style="color:#ee7b31; text-shadow: 1px 1px 2px #CCC">恭喜，一刀砍出了</p>'+
                                    '</div></div></div></div></div>');
                                $(".xm-details-button").html('<a href="?mod=weixin&v_mod=bargain&_index=_list" class="rf15" >我也要玩</a>');
                                //$("#showShare").css("display","block");
                                layer_msg(result.msg);
                            }else
                            {
                                layer_msg(result.msg);
                            }
                        },
                        error:function(result) {
                            alert("网络超时,请重试!");
                        }
                    });
                    layer.closeAll();
                }
            });

        })
        $("#showShare").on("click",function() {
            $(".win").show();
        })
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
</script>
</body>
</html>