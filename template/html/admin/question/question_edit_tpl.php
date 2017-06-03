<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetEditQuestion();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="<?php echo _URL_; ?>&_action=ActionEditQuestion"
          method="post" class="form form-horizontal" id="form">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>问题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="qusetion" required cols="" rows="" class="textarea" placeholder=""
                          onkeyup="$.Huitextarealength(this,150)"><?php echo $data['qusetion']; ?></textarea>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>答案：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="answer" cols="" required rows="" class="textarea" placeholder=""
                          onkeyup="$.Huitextarealength(this,255)"><?php echo $data['answer']; ?></textarea>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>显示：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select valid"  required name="is_show" id="is_show" aria-required="true" aria-invalid="false">
                    <option value="">请选择</option>
                    <option value="1" <?php echo $data['is_show']==1?'selected':''; ?>>不显示</option>
                    <option value="0" <?php echo $data['is_show']==0?'selected':''; ?>>显示</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>显示答案(默认)：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select valid" required name="is_show_answer" id="is_show_answer" aria-required="true" aria-invalid="false">
                    <option value="">请选择</option>
                    <option value="1" <?php echo $data['is_show_answer']==1?'selected':''; ?>>不显示</option>
                    <option value="0" <?php echo $data['is_show_answer']==0?'selected':''; ?>>显示</option>
                </select>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" value="<?php echo $data['ry_order']; ?>" maxlength="11" placeholder="" name="ry_order">
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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

        $("#form").validate();
    });
    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    window.parent.location.reload();
    var index = parent.layer.getFrameIndex(window.name);
    if(index==undefined || index=='')
    {
        location.reload();
    }
    parent.layer.close(index);
    <?php
    }
    ?>
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>