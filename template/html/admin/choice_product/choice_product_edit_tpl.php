<?php
$data = $obj->GetChoiceProductDetails();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link href="/template/source/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/tool/upload/upload.css">
    <title></title>
</head>
<body>
<div class="page-container">
    <form action="?mod=admin&v_mod=choice_product&_index=_edit&id=<?php echo $_GET['id']; ?>&_action=ActionEditChoiceProduct" method="post" class="form form-horizontal" id="check_form">


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">排序：<br>（数字越小越前）</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="show_sort"  placeholder="" value="<?php echo $data['show_sort'];?>" class="input-text" style="width:90%">
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript">

$('.skin-minimal input').iCheck({
    checkboxClass: 'icheckbox-blue',
    radioClass: 'iradio-blue',
    increaseArea: '20%'
});

$("#check_form").validate({
    rules:{
        show_sort:{
            required:true,
            number:true
        }

    }
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
</body>
</html>