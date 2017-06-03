<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetSystemConf();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>系统配置</title>
</head>
<body>
<div class="page-container">
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">系统配置</div>
            <form action="?mod=admin&v_mod=system&_index=_conf&_action=ActionSetConf" method="post">
                <table class="table table-border table-bordered table-bg table-hover">
                    <?php
                    if($data)
                    {
                        foreach ($data as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $val['conf_desc']; ?>：</td>
                                <td>
                                    <?php
                                        switch ($val['conf_type'])
                                        {
                                            case 1:
                                                ?>
                                                <select class="select valid" required name="<?php echo $val['conf_key']; ?>" id="category_id" aria-required="true" aria-invalid="false">
                                                    <option value="">请选择</option>
                                                    <option value="1">yes</option>
                                                    <option value="0">no</option>
                                                </select>
                                                <?php
                                                break;
                                            case 2:
                                                ?>
                                                <input type="number" class="input-text" required value="<?php echo $val['conf_number']; ?>" placeholder="" name="<?php echo $val['conf_key']; ?>">
                                                <?php
                                                break;
                                            case 3:
                                                ?>
                                                <textarea name="<?php echo $val['conf_key']; ?>" cols="" rows="" required class="textarea" placeholder="" onkeyup="$.Huitextarealength(this,255)"><?php echo $val['conf_text']; ?></textarea>
                                                <?php
                                                break;
                                            case 4:
                                                ?>
                                                <input type="number" class="input-text" required value="<?php echo $val['conf_money']; ?>" placeholder="" name="<?php echo $val['conf_key']; ?>">
                                                <?php
                                                break;
                                            case 5:
                                                ?>
                                                <input type="file" class="input-text" placeholder="" name="<?php echo $val['conf_key']; ?>">
                                                <?php
                                                break;
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td>操作：</td>
                        <td>
                            <input class="btn btn-primary radius" name="submit" type="submit" value="保存">
                        </td>
                    </tr>
                    <?php
                    ?>
                </table>
            </form>
        </div>
    </div>
</div>
<!--弹出层-->
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script>
    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    <?php
    }
    ?>
</script>
</body>
</html>