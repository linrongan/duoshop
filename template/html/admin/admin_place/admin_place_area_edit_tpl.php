<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getOneArea();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="?mod=admin&v_mod=admin_place&_index=_city_edit&_action=ActionEditArea&id=<?php echo $data['autoid'];?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>区域ID：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['id'];?>" placeholder="" name="area_id">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>区域名字：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['name'];?>" placeholder="" name="name">
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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
            rules:{
                area_id:{
                    required:true,
                    digits:true
                },
                name:{
                    required:true
                }
            }

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