<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="?mod=admin&v_mod=pc&_index=_about_page_new&_action=ActionNewAboutPage" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>页面名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="page_title" name="page_title">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span> 页面类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select" size="1" name="type" id="type">
                    <option value="">请选择类型</option>
                    <option value="0">其他页面</option>
                    <option value="1">关于我们页面</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="page_content" style="width:500px;height: 500px;"></textarea>
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
<script charset="utf-8" src="/tool/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/tool/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name=page_content]', {
                allowFileManager : true
            });
        });

        $("#form-admin-add").validate({
            rules:{
                page_title:{
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