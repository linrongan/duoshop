<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getThisShop();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>充值折扣卷余额</title>

</head>
<body>
<div class="page-container">
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">充值店铺折扣卷余额</div>
            <form action="<?php echo _URL_.'&_action=ActionRechargeShopBalance';?>" class="form form-horizontal" method="post" id="check-form">
                <table class="table table-border table-bordered table-bg table-hover">
                    <tr>
                        <td>店铺名：</td>
                        <td><?php echo $data['store_name']; ?></td>
                    </tr>
                    <tr>
                        <td >logo：</td>
                        <td><img width="50" src="<?php echo $data['store_logo']; ?>" alt="<?php echo $data['store_name']; ?>"/></td>
                    </tr>
                    <tr>
                        <td>店主：</td>
                        <td><?php echo $data['admin_name']; ?></td>
                    </tr>
                    <tr>
                        <td>折扣卷金额：</td>
                        <td>￥ <?php echo $data['gift_balance']; ?></td>
                    </tr>
                    <tr>
                        <td>充值金额：</td>
                        <td>+ <input type="text" class="input-text" value="0" id="gift_balance" name="gift_balance" style="width: 90%;"/></td>
                    </tr>
                    <tr>
                        <td>操作：</td>
                        <td><input class="btn btn-primary radius" type="submit" value="提交"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
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


        $("#check-form").validate({
            rules:{
                gift_balance:{
                    required:true,
                    number:true,
                    min:0.01
                }
            }
        });
    });

    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    if('<?php echo $_return['code']?>'==0)
    {
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