<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetShopWithdrawDetails();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/template/source/admin/static/h-ui.admin/css/alert.css"><!--弹出层样式-->
    <title>商家提现详情</title>
</head>
<body>
<div class="page-container">
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">提现详情</div>
            <table class="table table-border table-bordered table-bg table-hover">
                <tr>
                    <td>商家logo：</td>
                    <td>
                        <img class="round" width="50" src="<?php echo $data['store_logo']; ?>" alt="">
                    </td>
                </tr>
                <tr>
                    <td>商家名称：</td>
                    <td>
                        <?php echo $data['store_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>提现金额：</td>
                    <td>
                        <?php echo $data['money']; ?>
                    </td>
                </tr>
                <tr>
                    <td>真实姓名：</td>
                    <td>
                        <?php echo $data['username']; ?>
                    </td>
                </tr>
                <tr>
                    <td>手机：</td>
                    <td>
                        <?php echo $data['phone']; ?>
                    </td>
                </tr>
                <tr>
                    <td>银行名称：</td>
                    <td>
                        <?php echo $data['bank']; ?>
                    </td>
                </tr>
                <tr>
                    <td>银行卡号：</td>
                    <td>
                        <?php echo $data['bank_card']; ?>
                    </td>
                </tr>
                <tr>
                    <td>备注：</td>
                    <td>
                        <?php echo $data['remark']; ?>
                    </td>
                </tr>
                <tr>
                    <td>申请时间：</td>
                    <td>
                        <?php echo $data['addtime']; ?>
                    </td>
                </tr>
                <tr>
                    <td>状态：</td>
                    <td>
                        <?php
                            if($data['status']==0)
                            {
                                echo '未处理';
                            }elseif($data['status']==1)
                            {
                                echo '处理中';
                            }else{
                                echo '已完成';
                            }
                        ?>
                    </td>
                </tr>
                <?php
                    if($data['status']<2)
                    {
                        ?>
                        <tr>
                            <td>操作：</td>
                            <td>
                                <select class="select" style="width: 300px;" required
                                        id="status" name="status" aria-required="true">
                                    <option value="">请选择处理方式</option>
                                    <option value="1" <?php echo $data['status']==1?'selected':''; ?>><?php echo $data['status']==1?'--':''; ?>处理中</option>
                                    <option value="2" <?php echo $data['status']==2?'selected':''; ?>>已完成</option>
                                </select>
                                <br><br>
                                <a onclick="confirm_handle(<?php echo $data['id']; ?>)" class="btn btn-primary radius">确定</a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </div>
    </div>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
</body>
<script>
    function confirm_handle(id)
    {

    }
</script>
</html>