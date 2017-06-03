<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(!regExp::checkNULL($_GET['id']))
{
    redirect(NOFOUND.'&msg=error');
}
$data = $obj->GetRefundApplyInfo(intval($_GET['id']));
if(!$data)
{
    redirect(NOFOUND.'&msg=数据不存在');
}elseif($data['refund_is_valid'])
{
    redirect(NOFOUND.'&msg=已失效');
}elseif($data['refund_type_id']!=2 || $data['refund_status']!=3)
{
    redirect(NOFOUND.'&msg=数据已提交');
}
$logistics = $obj->GetLogistics();
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
                <div class="duo-header-title">物流信息</div>
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

<div class="weui-cells__title rf14">物流公司<span class="red rf14">*</span></div>
<div class="weui-cells">
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__bd">
            <select class="weui-select rf14" id="refund_logistics_id">
                <option value="">-请选择物流-</option>
                <?php
                    if($logistics)
                    {
                        foreach($logistics as $item)
                        {
                            ?>
                            <option value="<?php echo $item['logistics_id']; ?>"><?php echo $item['logistics_name']; ?></option>
                            <?php
                        }
                    }
                ?>
            </select>
        </div>
    </div>
</div>
<div class="weui-cells__title rf14">物流单号<span class="red rf14">*</span></div>
<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <input type="number" maxlength="26" id="refund_logistics_number" class="weui-input rf14" placeholder="请输入物流单号">
        </div>
        <div class="weui-cell__zd">
            <i class="fa fa-qrcode" id="scan" style="font-size:20px;"></i>
        </div>
    </div>
</div>
<!--
<div class="weui-cells__title rf14">退款说明<span class="cl_b9 rf14">（可不填）</span></div>
<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__bd">
        	<textarea class="weui-textarea rf14" rows="3" cols="40" placeholder="请输入退款说明"></textarea>
        </div>
    </div>
</div>
-->



<!--
<div class="weui-cells__title rf14">温馨提示</div>
<p class="rf14 lh20" style="text-indent:2em;">温馨提示内容</p>-->
<div style="padding:1rem 10%">
    <a href="javascript:;" onclick="confirm_sub(this)" class="weui-btn weui-btn_primary rf16" style="background:#dd2726;">确定</a>
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
            'scanQRCode'
        ]
    });

    wx.ready(function()
    {
        $("#scan").click(function ()
        {
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res)
                {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                    if(result.length>0 && !isNaN(result))
                    {
                        $("#refund_logistics_number").val(result);
                    }else{
                        layer_msg('没有结果或不是单号');
                    }
                },
                fail:function ()
                {
                    layer_msg('扫描失败，请手动输入');
                },
                cancel:function ()
                {
                    layer_msg('取消扫描');
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


    function confirm_sub(obj)
    {
        if($(obj).hasClass('disabled'))
        {
            return false;
        }
        var refund_logistics_id = $("#refund_logistics_id :selected").val();
        var refund_logistics_number = $("#refund_logistics_number").val();
        if(refund_logistics_id=='' || isNaN(refund_logistics_id))
        {
            layer_msg('请选择物流公司');
            return false;
        }
        if(refund_logistics_number.length<=0)
        {
            layer_msg('请输入物流单号');
            return false;
        }
        if(refund_logistics_number.length<8)
        {
            layer_msg('单号不能低于8位');
            return false;
        }
        $(obj).addClass('disabled');
        $.ajax({
            type:'post',
            url:'/?mod=weixin&v_mod=order&_index=_refund_wuliu&id=<?php echo $_GET['id']; ?>&_action=ActionRefundWuliu',
            data:{refund_logistics_id:refund_logistics_id,refund_logistics_number:refund_logistics_number},
            success:function (res)
            {
                if(res.code==0)
                {
                    location.href='/?mod=weixin&v_mod=order&_index=_refund_details&goods_id=<?php echo $data['goods_id']; ?>';
                }else{
                    $(obj).removeClass('disabled');
                }
            },
            error:function ()
            {
                layer_msg('操作失败');
                $(obj).removeClass('disabled');
            },
            dataType:'json'
        });
    }
</script>
</body>
</html>