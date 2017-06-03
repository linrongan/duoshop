<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetRefundDetails();
if(!$data)
{
    redirect(NOFOUND.'&msg=数据已过期');
}
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
        .weui-label{width:4rem;}
        .weui-cell_select .weui-select{padding-left:0; height:auto; line-height:normal;}
        .prompt{font-weight:bold;}
        .prompt>i.fa{color:#5a7fc6;}
        .prompt_button>a{ display:inline-block; width:30%; height:35px; text-align:center; line-height:35px; border:1px solid #999999; margin:0 3px; padding:0 5px; background-image:-webkit-linear-gradient(to bottom, #fcfcfc, #f0f0f0); background-image:linear-gradient(to bottom,#fcfcfc, #f0f0f0); }
    </style>
</head>
<body>
<header>
    <div id="m_common_header"><header class="duo-header">
            <div class="duo-header-bar">
                <div id="m_common_header_goback" class="duo-header-icon-back J_ping"><span></span></div>
                <div class="duo-header-title">退款详情</div>
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

<?php
    if($data['refund_status']==0)
    {
        ?>
        <div class="weui-cells rmt10">
            <div class="weui-cell" style="padding:1rem 3%;">
                <div class="weui-cell__bd">
                    <div class="prompt rf15">
                        <i class="fa fa-exclamation-circle"></i> 等待商家处理退款申请
                    </div>
                    <div class="refund-rule rmt20">
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">如果商家同意：</span>申请将达成并退款至您的余额或银行卡</p>
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">如果商家拒绝：</span>联系商家撤销退款重新申请</p>
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">如果商家未及时处理：</span>请联系客服</p>
                    </div>
                    <div class="prompt_button rmt10 tc">
                        <?php
                            if(!$data['refund_upd_date'])
                            {
                               ?>
                                <a href="?mod=weixin&v_mod=order&_index=_refund_edit&id=<?php echo $data['id']; ?>" class="omit rf13 cl_b3">修改退款申请</a>
                                <?php
                            }
                        ?>
                        <a href="javascript:;" onclick="qx_refund(<?php echo $data['id'] ?>)" class="omit rf13 cl_b3">撤销售后申请</a>
                        <a href="javascript:;" onclick="lx_kefu(this,<?php echo (strtotime($data['apply_date'])+3600*24*3)>time()?1:0;?>)" class="omit rf13 cl_b3">申请客服介入</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }elseif($data['refund_status']==1)
    {
        ?>
        <div class="weui-cells rmt10">
            <div class="weui-cell" style="padding:1rem 3%;">
                <div class="weui-cell__bd">
                    <div class="prompt rf15">
                        <i class="weui-icon-cancel"></i> 退款关闭
                    </div>
                    <div class="refund-rule rmt20">
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">关闭原因：</span>由于您取消退款退款关闭</p>
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">关闭时间：</span><?php echo $data['refund_confirm_date']; ?></p>
                        <div class="prompt_button rmt10">
                            <a href="javascript:;" id="tip" onclick="reset_refund(this,<?php echo $_GET['goods_id']; ?>)" class="omit rf13 cl_b3">退款/售后</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }elseif($data['refund_status']==2)
    {
        ?>
        <div class="weui-cells rmt10">
            <div class="weui-cell" style="padding:1rem 3%;">
                <div class="weui-cell__bd">
                    <div class="prompt rf15">
                        <i class="weui-icon-warn weui-icon_msg"></i> 退款关闭
                    </div>
                    <div class="refund-rule rmt20">
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">关闭原因：</span>未能通过退款申请</p>
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">关闭时间：</span><?php echo $data['refund_confirm_date']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }elseif($data['refund_status']==3)
    {
        ?>
        <div class="weui-cells rmt10">
            <div class="weui-cell" style="padding:1rem 3%;">
                <div class="weui-cell__bd">
                    <div class="prompt rf15">
                        <i class="weui-icon-info weui-icon_msg"></i> 已通过退款申请
                    </div>
                    <div class="refund-rule rmt20">
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">状态：</span>已通过退款审核  请耐心等待</p>
                    </div>
                    <?php
                        if($data['refund_type_id']>1)
                        {
                            ?>
                            <div class="prompt_button rmt10 tc">
                                <a href="?mod=weixin&v_mod=order&_index=_refund_wuliu&id=<?php echo $data['id']; ?>" class="omit rf13 cl_b3">填写物流信息</a>
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>

        <?php
    }elseif($data['refund_status']==4)
    {
        //显示物流信息
        ?>
        <div class="weui-cells rmt10">
            <div class="weui-cell" style="padding:1rem 3%;">
                <div class="weui-cell__bd">
                    <div class="prompt rf15">
                        <i class="weui-icon-info weui-icon_msg"></i> 等待确认
                    </div>
                    <div class="refund-rule rmt20">
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">收到货后：</span>退款</p>
                    </div>
                    <div class="prompt_button rmt10">
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">物流公司：</span><?php echo $data['refund_logistics_name'] ?></p>
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">物流单号：</span><?php echo $data['refund_logistics_number'] ?></p>
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">填写时间：</span><?php echo $data['refund_logistics_addtime'] ?></p>
                    </div>
                    <div class="prompt_button rmt10 tc">
                        <a href="javascript:;" class="omit rf13 cl_b3">物流跟踪</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }elseif($data['refund_status']==5)
    {
        ?>
        <div class="weui-cells rmt10">
            <div class="weui-cell" style="padding:1rem 3%;">
                <div class="weui-cell__bd">
                    <div class="prompt rf15">
                        <i class="weui-icon-success weui-icon_msg"></i> 退款成功
                    </div>
                    <div class="refund-rule rmt20">
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">商家备注：</span>成功退款</p>
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">退款时间：</span><?php echo $data['refund_confirm_date']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }elseif($data['refund_status']==6)
    {
        ?>
        <div class="weui-cells rmt10">
            <div class="weui-cell" style="padding:1rem 3%;">
                <div class="weui-cell__bd">
                    <div class="prompt rf15">
                        <i class="weui-icon-warn weui-icon_msg"></i> 退款失败
                    </div>
                    <div class="refund-rule rmt20">
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">商家备注：</span>理由</p>
                        <p class="cl_b9 rf13 rmt5"><span class="cl_b3">退款时间：</span><?php echo $data['refund_confirm_date']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
?>

<div class="weui-cells rmt10">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">店铺名称</label></div>
        <div class="weui-cell__bd"><span class="rf14"><?php echo $data['store_name']; ?></span></div>
    </div>
</div>

<div class="weui-cells rmt10">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">退款类型</label></div>
        <div class="weui-cell__bd"><span class="rf14"><?php echo $data['refund_type_id']==1?'仅退款':'退货退款'; ?></span></div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">退款原因</label></div>
        <div class="weui-cell__bd"><span class="rf14"><?php echo $data['refund_cause']; ?></span></div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">退款金额</label></div>
        <div class="weui-cell__bd"><span class="rf14">￥<?php echo $data['refund_money']; ?></span></div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">售后编号</label></div>
        <div class="weui-cell__bd"><span class="rf14"><?php echo $data['refund_number']; ?></span></div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">申请时间</label></div>
        <div class="weui-cell__bd"><span class="rf14"><?php echo $data['apply_date']; ?></span></div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">售后说明</label></div>
        <div class="weui-cell__bd"><span class="rf14"><?php echo $data['refund_remark']; ?></span></div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">退款订单</label></div>
        <div class="weui-cell__bd"><span class="rf14"><?php echo $data['refund_orderid']; ?></span></div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label rf14 cl_b9">退款订单类型</label></div>
        <div class="weui-cell__bd"><span class="rf14"><?php echo $data['refund_order_type']?'团购订单':'普通订单'; ?></span></div>
    </div>
</div>

<div class="weui-cells weui-cells_form rmt10">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <div class="weui-uploader">
                <div class="weui-uploader__hd">
                    <p class="weui-uploader__title rf14">上传凭证</p>
                </div>
                <div class="weui-uploader__bd">
                    <ul class="weui-uploader__files" id="uploaderFiles">
                        <?php
                            if($data['refund_certificates_img'])
                            {
                                $refund_certificates_img = json_decode($data['refund_certificates_img']);
                                for($i=0;$i<count($refund_certificates_img);$i++)
                                {
                                    ?>
                                    <li class="weui-uploader__file"
                                        style="background-image:url(<?php echo $refund_certificates_img[$i]; ?>)"></li>
                                    <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/template/source/weixin/js/jquery_1.1.1.js"></script>
<script src="/template/source/weixin/js/swiper.min.js"></script>
<script src="/template/source/weixin/js/fastclick.js"></script>
<script src="/template/source/weixin/js/jquery-weui.min.js"></script>
<script src="/template/source/weixin/js/autosize.min.js"></script>
<script src="/template/source/weixin/js/guageEdit.js"></script>
<script src="/tool/layer/layer_mobile/layer.js"></script>
<script>
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



    //取消退款
    function qx_refund(id)
    {
        $.ajax({
            type:'post',
            url:'/?mod=weixin&v_mod=order&_action=ActionQXRefundApply',
            data:{id:id},
            success:function (res)
            {
                if(res.code==0)
                {
                    location.href='/?mod=weixin&v_mod=order&_index=_refund_details&goods_id=<?php echo $_GET['goods_id']; ?>';
                }else{
                    alert(res.msg);
                }
            },
            error:function ()
            {

            },
            dataType:'json'

        });
    }


    function reset_refund(obj,goods_id)
    {
        $.ajax({
            type:'post',
            url:'/?mod=weixin&v_mod=order&_index=_refund_details&_action=ActionResetRefund&goods_id='+goods_id,
            data:{goods_id:goods_id},
            success:function (res)
            {
                if(res.code==0)
                {
                    location.href='/?mod=weixin&v_mod=order&_index=_refund&goods_id='+goods_id;
                }else{
                    alert(res.msg);
                }
            },
            error:function()
            {

            },
            dataType:'json'
        });
    }


    function lx_kefu(obj,status)
    {
        if(status)
        {
            layer.open({
                content: '亲，商家需要一定的时间处理您的申请，若未协商一致，3天内商家未处理，您可以申请客服介入'
                ,btn: '我知道了'
            });
        }else{
            window.location.href='http://wpa.qq.com/msgrd?V=1&uin=1992386583&exe=qq&Site=qq&menu=yes';
        }
    }
</script>
</body>
</html>