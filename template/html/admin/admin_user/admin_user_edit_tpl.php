<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetUserInfo(intval($_GET['id']));
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>编辑用户余额</title>

</head>
<body>
<div class="page-container">
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
        <div class="panel-header">编辑用户余额</div>
            <form action="<?php echo _URL_.'&_action=ActionEditUser';?>" class="form form-horizontal" method="post" id="check-form">
                <table class="table table-border table-bordered table-bg table-hover">
                    <tr>
                        <td>用户名：</td>
                        <td><?php echo $data['nickname']; ?></td>
                    </tr>
                    <tr>
                        <td >头像：</td>
                        <td><img width="50" src="<?php echo $data['headimgurl']; ?>" alt="<?php echo $data['nickname']; ?>"/></td>
                    </tr>
<!--                    <tr>-->
<!--                        <td>余额：</td>-->
<!--                        <td>￥ <input type="text" class="input-text" value="--><?php //echo $data['user_money']; ?><!--" id="user_money" name="user_money" style="width: 90%;"/></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>积分：</td>-->
<!--                        <td><input type="text" class="input-text" value="--><?php //echo $data['user_point']; ?><!--" id="user_point" name="user_point"/></td>-->
<!--                    </tr>-->
                    <tr>
                        <td>金卡余额：</td>
                        <td><?php echo $data['gift_balance']; ?></td>
                    </tr>
                    <tr>
                        <td>充值金卡：</td>
                        <td><input type="text" class="input-text" value="<?php echo $data['gift_balance']; ?>" id="gift_balance" name="gift_balance"/></td>
                    </tr>
                    <tr>
                        <td>专享会员？：</td>
                        <td>
                            <select name="vip_lv" id="vip_lv" class="select select-box">
                                <option <?php echo $data['vip_lv']==0?'selected':'';?> value="0">否</option>
                                <option <?php echo $data['vip_lv']==1?'selected':'';?> value="1">是</option>
                            </select>
                        </td>
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
                user_money:{
                    required:true,
                    number:true
                },
                user_point:{
                    required:true,
                    number:true
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