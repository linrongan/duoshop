<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetRefundApplyDetails();
if(empty($data))
{
    exit('not found');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/template/source/admin/static/h-ui.admin/css/alert.css"><!--弹出层样式-->
    <title>退款申请详情</title>
    <style>
        .show_pic{
            height: auto;
            width:auto;
        }
    </style>
</head>
<body>
<div class="page-container">
<div class="codeView cl pd-5 mt-20">
<div class="panel panel-default">
<div class="panel-header">退款申请详情</div>
<table class="table table-border table-bordered table-bg table-hover">
<tr>
    <td>退款申请状态：</td>
    <td><?php echo $data['refund_is_valid']?'已过期':'处理中'; ?></td>
</tr>
<tr>
    <td>退款理由：</td>
    <td><?php echo $data['refund_cause']; ?></td>
</tr>
<tr>
    <td>退款金额：</td>
    <td><?php echo $data['refund_money']; ?></td>
</tr>
<tr>
    <td>退款说明：</td>
    <td><?php echo $data['refund_remark']; ?></td>
</tr>
<tr>
    <td>退款订单：</td>
    <td><?php echo $data['refund_orderid']; ?></td>
</tr>
<tr>
    <td>状态：</td>
    <td>
        <?php
        switch ($data['refund_status'])
        {
            case -1:
                echo '管理员重置退款';
                break;
            case 0:
                echo '申请退款中';
                break;
            case 1:
                echo '用户撤销退款';
                break;
            case 2:
                echo '管理撤销退款';
                break;
            case 3:
                echo '已通过退款申请';
                break;
            case 4:
                echo '已填写物流信息';
                break;
            case 5:
                echo '退款成功';
                break;
            case 6:
                echo '拒绝退款';
                break;
        }
        ?>
    </td>
</tr>
<tr>
    <td>确认退款时间：</td>
    <td>
        <?php echo $data['refund_confirm_date']; ?>
    </td>
</tr>
<?php
if($data['refund_status']>1)
{
    ?>
    <tr>
        <td>上一次处理人：</td>
        <td>
            <?php echo $data['refund_operator_name']; ?>
        </td>
    </tr>
<?php
}
?>
<tr>
    <td>退款订单类型：</td>
    <td>
        <?php echo $data['refund_order_type']==0?'普通订单':'团购订单'; ?>
    </td>
</tr>
<tr>
    <td >产品金额：</td>
    <td>
        <?php echo $data['refund_goods_money']; ?>
    </td>
</tr>
<tr>
    <td>产品数量：</td>
    <td>
        <?php echo $data['refund_goods_count']; ?>
    </td>
</tr>
<tr>
    <td >订单用户：</td>
    <td>
        <img width="50" src="<?php echo $data['headimgurl']; ?>" alt=""/><br>
        <?php echo $data['nickname']; ?>
    </td>
</tr>
<?php
if($data['refund_type_id']==2 && $data['refund_status']==4)
{
    ?>
    <tr>
        <td >物流公司：</td>
        <td>
            <?php echo '【'.$data['refund_logistics_name'].'】'; ?>&nbsp;&nbsp;&nbsp;
            <a onclick="sel_logistics('<?php echo $data['refund_logistics_number']; ?>')" class="btn btn-default radius">物流追踪</a>
        </td>
    </tr>
    <tr>
        <td >物流单号：</td>
        <td>
            <?php echo $data['refund_logistics_number']; ?>
        </td>
    </tr>
<?php
}
?>

<tr>
    <td >退款凭证：</td>
    <td>
        <?php
        if(!$data['refund_certificates_img'])
        {
            echo '未上传任何凭证';
        }else{
            $refund_certificates_img = json_decode($data['refund_certificates_img']);
            for($i=0;$i<count($refund_certificates_img);$i++)
            {
                ?>
                <img onclick="show_pic('<?php echo $refund_certificates_img[$i]; ?>');" width="50" src="<?php echo $refund_certificates_img[$i];?>" alt=""/>
            <?php
            }
        }
        ?>
    </td>
</tr>
<tr>
    <td>产品图：</td>
    <td><img width="50" src="<?php echo $data['refund_product_img']; ?>" alt=""/></td>
</tr>
<tr>
    <td>产品名：</td>
    <td><?php echo $data['refund_product_name']; ?></td>
</tr>
<tr>
    <td>产品属性：</td>
    <td>
        <?php
        if($data['refund_product_attr'])
        {
            echo $data['refund_product_attr'];
        }else{
            echo '-';
        }
        ?>
    </td>
</tr>
<tr>
    <td >支付方式：</td>
    <td >
        <?php echo $data['refund_order_pay_method']=='user_money'?'余额支付':'微信支付'; ?>
    </td>
</tr>
<tr>
    <td>退款的商家：</td>
    <td><?php echo $data['store_name']; ?></td>
</tr>

<?php
if($data['refund_is_valid']==0)
{
    ?>
    <tr>
    <?php
    if($data['refund_status']==0)
    {
        ?>
        <td>申请退款：</td>
        <td>
            <select class="select select-box" style="width: 300px;" required
                    id="refund_status" aria-required="true">
                <option value="">请选择处理结果</option>
                <option value="3">通过申请</option>
            </select>
            <br>
            <br>
            <a onclick="reg_apply(this,<?php echo $data['id']; ?>)" class="btn btn-primary radius">确定</a>
            <a onclick="cpanel_order(this,<?php echo $data['id']; ?>);" class="btn btn-primary radius">重置退款</a>
        </td>
        </tr>
    <?php
    }elseif($data['refund_status']==2 || $data['refund_status']==6)
    {
        ?>
        <td>撤销申请：(撤销后可重新退款)</td>
        <td>
            <a onclick="cpanel_order(this,<?php echo $data['id']; ?>);" class="btn btn-primary radius">重置退款</a>
        </td>
    <?php
    }elseif($data['refund_status']==3 || $data['refund_status']==4)
    {
        ?>
        <td>退款确认：</td>
        <td>
            <a onclick="start_refund(this,<?php echo $data['id']; ?>)" class="btn btn-primary radius">订单退款</a>
            <a onclick="cpanel_order(this,<?php echo $data['id']; ?>);" class="btn btn-default radius">重置退款</a>
        </td>
    <?php
    }
    ?>
    <!-- <a class="btn btn-primary radius">退款-->
<?php
}
?>
</table>
</div>
</div>
</div>

<!--弹出层-->
<div id="modal-demo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content radius">
            <div class="modal-header">
                <h3 class="modal-title">对话框标题</h3>
                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">确定</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
    </div>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    var page_url = '?mod=admin&v_mod=user&_index=_refund_details&id=<?php echo $_GET['id']; ?>';

    //加载大图
    function show_pic(src)
    {
        layer.open({
            type: 1,
            skin: 'show_pic', //样式类名
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            content: '<img style="width: auto;height: auto" src="'+src+'"/>'
        });
    }


    function reg_apply(obj,id)
    {
        var refund_status = $("#refund_status :selected").val();
        var refund_status_text = $("#refund_status :selected").html();
        if(refund_status=='' || isNaN(refund_status))
        {
            layer.msg('请选择处理结果');
            return false;
        }
        layer.confirm('已选择'+refund_status_text+' 是否确认？', {
            btn: ['确认','取消'] //按钮
        }, function(index)
        {
            var data = {
                id:id,
                refund_status:refund_status
            };
            layer.close(index);
            request('post','?mod=admin&v_mod=user&_index=_refund_details&id='+id+'&_action=ActionRegApply',data,'reg_apply');
        });
    }

    var request_status = false; //0请求暂停中  1请求中
    function request(method,url,param,type)
    {
        if(request_status)
        {
            layer.msg('请求中');
            return false;
        }
        request_status = true;
        $.ajax({
            type:method,
            url:url,
            data:param,
            success:function (res)
            {
                if(res.code==0)
                {
                    switch (type)
                    {
                        case 'reg_apply':
                            location.href=page_url;
                            break;
                        case 'start_refund':
                            $("#modal-demo").modal("show");
                            $(".modal-body").eq(0).html(res.msg);
                            break;
                        case 'cpanel':
                            location.href=page_url;
                            break;
                    }
                }else{
                    layer.msg(res.msg);
                    request_status = false;
                }
            },
            error:function ()
            {
                layer.msg('请求错误');
                request_status = false;
            },
            dataType:'json'
        });
    }


    function start_refund(obj,id)
    {
        var data = {};
        layer.confirm('您已确定退款？(tip未退款仍然可以撤销)', {
            btn: ['重要','取消'] //按钮
        }, function(index){
            layer.close(index);
            request('post','?mod=admin&v_mod=user&_index=_refund_details&id='+id+'&_action=ActionStartRefund',data,'start_refund');
        });
    }

    $(".modal-footer").eq(0).click(function ()
    {
        location.href=page_url;
    });
    $(".modal-footer").eq(1).click(function ()
    {
        location.href=page_url;
    });


    //查询物流
    function sel_logistics(number)
    {
        var index = layer.open({
            type: 2,
            title: '物流追踪',
            content: '/?mod=admin&v_mod=admin_logistics&_index=_select&logistics_number='+number
        });
        layer.full(index);
    }

    //撤销退款
    function cpanel_order(obj,id)
    {
        var data = {};
        layer.confirm('确定要重置退款？(tip重置后可重新申请)', {
            btn: ['重要','取消'] //按钮
        }, function(index){
            layer.close(index);
            request('post','?mod=admin&v_mod=user' +
                '&_index=_refund_details&id='+id+'&_action=ActionCpanelRefund',data,'cpanel');
        });
    }
</script>
</body>
</html>