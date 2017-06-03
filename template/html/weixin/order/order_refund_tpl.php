<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetRefundOrderGoods();
if($data['code'])
{
    redirect(NOFOUND.'&msg='.$data['msg']);
}elseif($data['data']['goods_refund'])
{
    redirect(NOFOUND.'&msg=退款申请已提交');
}elseif($data['data']['order_status']>=6 && strtotime($data['data']['goods_confirm']) + strtotime("+1 week")>time())
{
    redirect(NOFOUND.'&msg=已超过售后有效期  无法提供售后服务');
}
$refund_option_type = $obj->GetRefundType();
include  RPC_DIR.'/module/mobile/weixin/jsapi.php';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$weburl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$wxshare=new jsapi(array());
$array=$wxshare->config($weburl);
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
        .weui-cell_select .weui-select{padding-left:0; height:auto; line-height:normal;}
    </style>
</head>
<body>
<header>
    <div id="m_common_header"><header class="duo-header">
            <div class="duo-header-bar">
                <div id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
                <div class="duo-header-title">申请退款</div>
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
                    <a class="J_ping" href="">
                        <span class="shortcut-my-account"></span>
                        <strong>会员中心</strong>
                    </a>
                </li>
            </ul>
        </header>
    </div>
</header>

<div class="weui-cells__title rf14">退款类型<span class="red rf14">*</span></div>
<div class="weui-cells">
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__bd">
            <select class="weui-select rf14" id="refund_type_id" name="refund_type_id">
                <option value="">请选择退款类型</option>
                <?php
                    if($refund_option_type)
                    {
                        foreach($refund_option_type as $val)
                        {
                            ?>
                            <!--未发货状态-->
                            <option <?php if($data['data']['order_status']==3 && $val['type_id']>1){echo 'disabled';} ?> value="<?php echo $val['type_id']; ?>"><?php echo $val['title']; ?></option>
                            <?php
                        }
                    }
                ?>
            </select>
        </div>
    </div>
</div>

<div class="weui-cells__title rf14">退款理由<span class="red rf14">*</span></div>
<div class="weui-cells">
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__bd">
            <select class="weui-select rf14" disabled id="refund_cause" name="refund_cause">
                <option value="">退款原因</option>
            </select>
        </div>
    </div>
</div>

<div class="weui-cells__title rf14">退款金额<span class="red rf14">*</span>
    最多可退<?php echo $data['data']['actual_refund']; ?>
    <?php
        if($data['data']['average_coupon'] || ($data['data']['average_pro_fee'] && $data['data']['order_status']>3))
        {
            ?>
            (含<?php if($data['data']['average_coupon']){echo '优惠券-'.$data['data']['average_coupon'];}
            if($data['data']['average_pro_fee'] && $data['data']['order_status']>3){echo '运费-'.$data['data']['average_pro_fee'];}?>)
            <?php
        }
    ?></div>
<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <input type="number" id="refund_money"  rel="<?php echo $data['data']['actual_refund']; ?>" onkeyup="validate(this,<?php echo $data['data']['actual_refund']; ?>)" class="weui-input rf14" placeholder="请输入退款金额">
        </div>
    </div>
</div>

<div class="weui-cells__title rf14">退款说明<span class="cl_b9 rf14">（可不填）</span></div>
<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <textarea class="weui-textarea rf14" id="refund_remark" rows="3" cols="40" placeholder="请输入退款说明"></textarea>
        </div>
    </div>
</div>

<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <div class="weui-uploader">
                <div class="weui-uploader__hd">
                    <p class="weui-uploader__title rf14">上传凭证<span class="cl_b9">（最多3张）</span></p>
                    <div class="weui-uploader__info rf12">0/3</div>
                </div>
                <div class="weui-uploader__bd">
                    <ul class="weui-uploader__files" id="uploaderFiles"></ul>
                    <div class="weui-uploader__input-box"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="weui-gallery" style="display: none">
    <span class="weui-gallery__img"></span>
    <div class="weui-gallery__opr">
        <a href="javascript:" class="weui-gallery__del">
            <i class="weui-icon-delete weui-icon_gallery-delete"></i>
        </a>
    </div>
</div>

<!--
<div class="weui-cells__title rf14">温馨提示</div>
<p class="rf14 lh20" style="text-indent:2em;">温馨提示内容</p>-->
<div style="padding:1rem 10%">
    <a href="javascript:;" onclick="refund(this)" class="weui-btn weui-btn_primary rf16" style="background:#dd2726;">下一步</a>
</div>
<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/template/source/weixin/js/fastclick.js"></script>
<script src="/template/source/weixin/js/jquery-weui.min.js"></script>
<script src="/template/source/weixin/js/autosize.min.js"></script>
<script src="/template/source/weixin/js/guageEdit.js"></script>
<script src="/tool/layer/layer_mobile/layer.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug:  false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $array['appId']; ?>', // 必填，公众号的唯一标识
        timestamp:<?php echo $array['timestamp']; ?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $array['noncestr']; ?>', // 必填，生成签名的随机串
        signature:'<?php echo $array['signature']; ?>',// 必填，签名，见附录1
        jsApiList: [
            'chooseImage',
            'previewImage',
            'uploadImage'
        ]
    });
    var upload_count = 3;
    var upload_file = [];
    wx.ready(function()
    {
        $(".weui-uploader__input-box").click(function ()
        {
            var images = {
                localIds:[],
                serverId:[]
            };
            var that = $(this);
            wx.chooseImage({
                count:upload_count, // 默认9
                sizeType: ['original'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album'], // 可以指定来源是相册还是相机，默认二者都有
                success: function(res)
                {
                    images.localIds = res.localIds;
                    var i = 0;
                    var length = images.localIds.length;
                    function upload()
                    {
                        wx.uploadImage({
                            localId:images.localIds[i],
                            success: function(res)
                            {
                                $("#uploaderFiles").append('<li data-src="'+images.localIds[i]+'"  class="weui-uploader__file" number="'+res.serverId+'" style="background-image:url('+images.localIds[i]+')"></li>');
                                upload_count--;
                                i++;
                                if(upload_count==0)
                                {
                                    that.hide();
                                }
                                upload_file.push(res.serverId);
                                $(".weui-uploader__info").html(parseInt(3-upload_count)+'/3');
                                images.serverId.push(res.serverId);
                                if(i<length)
                                {
                                    upload();
                                }
                            }
                        });
                    }
                    upload();
                }
            });
        });
    });


    function layer_msg(msg)
    {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }

    function refund(obj)
    {
        var refund_type_id = $("#refund_type_id :selected").val();
        var refund_cause = $("#refund_cause :selected").val();
        var refund_money = $("#refund_money").val();
        var refund_remark = $("#refund_remark").val();
        var refund_certificates_img = upload_file;
        if(refund_type_id=='' || isNaN(refund_type_id))
        {
            layer_msg('请选择退款类型');
            return false;
        }
        if(refund_cause=='' || isNaN(refund_cause) || refund_cause<=0)
        {
            layer_msg('请选择退款原因');
            return false;
        }
        if(refund_money.length<=0 || isNaN(refund_money))
        {
            layer_msg('请输入退款金额');
            return false;
        }
        $.ajax({
            type:'post',
            url:'/?mod=weixin&v_mod=order&_index=_refund&goods_id=<?php echo $_GET['goods_id'] ?>&_action=ActionAddRefundApply',
            data:{
                refund_type_id:refund_type_id,
                refund_cause:refund_cause,
                refund_money:refund_money,
                refund_remark:refund_remark,
                refund_certificates_img:refund_certificates_img
            },
            success:function (res)
            {
                if(res.code==0)
                {
                    location.href='?mod=weixin&v_mod=order&_index=_refund_details&goods_id=<?php echo $_GET['goods_id']; ?>';
                }else{
                    layer_msg(res.msg);
                }
            },
            error:function ()
            {

            },
            dataType:'json'
        });
    }

    $("#refund_type_id").change(function ()
    {
        if($(this).val()!='')
        {
            if($(this).val()==1)
            {
                $("#refund_money").val($("#refund_money").attr('rel'));
                $("#refund_money").attr("readonly",true);
            }else{
                //如果之前有输入金额
                $("#refund_money").val('');
                $("#refund_money").attr("readonly",false);
            }
            $.getJSON('/?mod=weixin&v_mod=order&_action=GetRefundCauseOpt&refund_type_id='+$(this).val(),function (res)
            {
                var option = '<option value="">请选择理由</option>';
                if(res.length>0)
                {
                    for(var i=0;i<res.length;i++)
                    {
                        option+= '<option value="'+res[i].id+'">'+res[i].refund_title+'</option>';
                    }
                    $("#refund_cause").attr('disabled',false);
                }else{
                    $("#refund_cause").attr('disabled',true);
                }
                $("#refund_cause").empty();
                $("#refund_cause").append(option);
            })
        }
    });
    $("#uploaderFiles").on('click','.weui-uploader__file',function ()
    {
        var data_src = $(this).attr('data-src');
        var number = $(this).attr('number');
        $(".weui-gallery__img").css('background-image','url('+data_src+')');
        $(".weui-gallery__del").attr("number",number);
        $(".weui-gallery").show();
    });
    autosize(document.querySelectorAll('textarea'));
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
    });

    $(".weui-gallery__img").click(function ()
    {
        $(".weui-gallery").hide();
    });

    $(".weui-gallery__del").click(function ()
    {
       var number = $(this).attr('number');
       var no = 0;
        for(var i=0;i<upload_file.length;i++)
        {
            if(upload_file[i]==number)
            {
                no = i;
            }
        }
        upload_file.splice(no,1);
        $("#uploaderFiles").children().eq(no).remove();
        $(".weui-gallery").hide();
        upload_count++;
        $(".weui-uploader__info").html(parseInt(3-upload_count)+'/3');
        $('.weui-uploader__input-box').show();
    });


    function validate(obj,money)
    {
        if($(obj).val()>money)
        {
            $(obj).val(money);
        }
    }
</script>
</body>
</html>