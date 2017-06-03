<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');

}
$data = $obj->GetCategory();
$category = $data['category'];
//$spec = explode(",",$data['category'][$_GET['id']]);
//echo '<pre>';
//var_dump($category);exit;
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionAddSpecCategory';?>" method="post" class="form form-horizontal" id="form-admin-add">
        <legend>添加特色子类（不要超出3个）</legend>
        <?php
            if(isset($category[$_GET['id']]) && !empty($category[$_GET['id']]))
            {
                foreach($category[$_GET['id']] as $item)
                {
                    ?>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"> <?php echo $item['category_name'];?>：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <div class="skin-minimal row cl" style="margin-top: 0">
                                <?php
                                    if(isset($category[$item['category_id']]) && !empty($category[$item['category_id']]))
                                    {
                                        foreach($category[$item['category_id']] as $item)
                                        {
                                            ?>
                                            <div class="check-box col-xs-2">
                                                <input name="category_id[]" type="checkbox" <?php //if(in_array($item['category_id'],$spec)){ echo 'checked';}?>
                                                       id="checkbox-<?php echo $item['category_id'];?>"
                                                       value="<?php echo $item['category_id'];?>">
                                                <label for="checkbox-<?php echo $item['category_id'];?>"><?php echo $item['category_name'];?></label>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form-admin-add").validate({

        });
    });

    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    window.parent.location.reload();
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    <?php
    }
    ?>
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>