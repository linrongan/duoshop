
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>添加新闻通知</title>
</head>
<body>
<div class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionAddHomeNotice'; ?>" class="form form-horizontal" method="post" id="check-form">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" id="picture_title" name="picture_title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" id="picture_link" name="picture_link">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 是否可见：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select" required="" name="picture_show" size="1" aria-required="true">
                    <option value="">请选择是否可见</option>
                    <option value="0">是</option>
                    <option value="1">否</option>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">排序值：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="picture_sort" name="picture_sort">
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


        $("#check-form").validate({
            rules:{
                notice_title:{
                    required:true
                },
                picture_show:{
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
</body>
</html>