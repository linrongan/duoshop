<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getRecordDetail();
$detail=$obj->GetGiftOrderDetail();
$logistics = $obj->GetLogisticsList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<div class="page-container">
    <div class="row cl">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-header">收货人信息</div>
                <div class="panel-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">收货人：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['username']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">联系电话：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['phone']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">详细地址：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['address']; ?>
                        </div>
                    </div>

                    <div id="wuliu" >
                        <div class="row cl mt-10">
                            <label class="form-label col-xs-4 col-sm-3">物流公司：</label>
                            <div class="formControls col-xs-8 col-sm-6">
<!--                                <input type="text" class="input-text" maxlength="30" value="--><?php //echo $data['wuliu_com']; ?><!--" placeholder="" id="wuliu_com">-->
                                <select name="wuliu_com" id="wuliu_com" class="select select-box">
                                    <option value="">请选择物流公司</option>
                                    <?php
                                    foreach($logistics as $item)
                                    {
                                        ?>
                                        <option <?php echo$data['wuliu_com']==$item['logistics_name']?'selected':''; ?>
                                            value="<?php echo $item['logistics_name'];?>"><?php echo $item['logistics_letter'].'——'.$item['logistics_name'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row cl mt-10">
                            <label class="form-label col-xs-4 col-sm-3">货运单号：</label>
                            <div class="formControls col-xs-8 col-sm-6">
                                <input type="text" class="input-text" maxlength="32" value="<?php echo $data['wuliu_no']; ?>" placeholder="" id="wuliu_no">
                            </div>
                        </div>
                        <div class="row cl mt-10">
                            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                                <input class="btn btn-primary radius" onclick="save_logistics(this,<?php echo $data['orderid']; ?>);" type="submit" value="&nbsp;&nbsp;确定&nbsp;&nbsp;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-header">订单信息</div>
                <div class="panel-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">订单号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['orderid']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">下单时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['addtime']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">使用积分：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['total_point']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">订单备注：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['liuyan']?$data['liuyan']:'无'; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">订单状态：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['ship_status']>3?'<span class="label label-success radius">已发货</span>':'<span class="label label-default radius">未发货</span>';?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">订单产品</div>
            <div class="panel-body">
                <table class="table table-border table-bordered">
                    <thead>
                    <tr class="text-c">
                        <th>产品图</th>
                        <th>产品名称</th>
                        <th>需要积分</th>
                        <th>数量</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($detail)){
                        foreach($detail as $item){
                            ?>
                            <tr class="text-c">
                                <td>
                                    <img width="50"  src="<?php echo $item['gift_img']; ?>" alt="">
                                </td>
                                <td>
                                    <?php echo $item['gift_name']; ?>
                                </td>
                                <td>
                                    <?php echo $item['gift_point']; ?>
                                </td>
                                <td>
                                    <?php echo $item['qty']; ?>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
            <div class="clearfix mb30"></div>
        </div>
    </div>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    function article_save()
    {
        alert("刷新父级的时候会自动关闭弹层。");
        window.parent.location.reload();
    }

    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });


    });
    function save_logistics(obj,orderid)
    {
        if($(obj).parent().parent().css('display')=='block')
        {
            //var wuliu_com = $("#wuliu_com").val();
            var wuliu_com = $("#wuliu_com option:selected").val();

            var wuliu_no = $("#wuliu_no").val();
            if(wuliu_com=='')
            {
                $("#wuliu_com").focus();
                layer.msg('请输入物流公司',{icon:5,time:1000});
                return false;
            }
            if(wuliu_no=='')
            {
                $("#wuliu_no").focus();
                layer.msg('请输入物流编号',{icon:5,time:1000});
                return false;
            }
            layer.confirm('确定物流信息无误？',function(index)
            {
                $.ajax({
                    type:'post',
                    url:'?mod=admin&v_mod=admin_point&_action=ActionEditGiftOrder',
                    dataType: 'json',
                    data:{orderid:orderid,wuliu_com:wuliu_com,wuliu_no:wuliu_no},
                    success:function (data)
                    {
                        layer.msg(data.msg,{icon:data.code==0?6:5,time:1000});
                        if(data.code==0)
                        {
                            window.location.reload();
                            layer.close(index);
                        }
                    },
                    error:function (data)
                    {
                        console.log(data);
                    }
                });
            });
        }
    }
    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    if('<?php echo $_return['code']; ?>'==0){
        window.parent.location.reload();
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    <?php
    }
    ?>
</script>
</body>
</html>