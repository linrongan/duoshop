<?php
$data = $obj->GetApplyDetail();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>编辑入驻信息</title>
</head>
<body>
<div class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionEditApply'; ?>" class="form form-horizontal" method="post" id="check-form">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">名字：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span style="height: 30px;line-height: 30px;"><?php echo $data['name'];?></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">用户：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span style="height: 30px;line-height: 30px;"><img width="50" src="<?php echo $data['headimgurl'];?>" alt=""/><?php echo $data['nickname'];?></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">电话号码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span style="height: 30px;line-height: 30px;"><?php echo $data['phone'];?></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span style="height: 30px;line-height: 30px;"><?php echo $data['address'];?></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span style="height: 30px;line-height: 30px;"><?php echo $data['miaoshu'];?></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>审核：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select valid select-box" size="1" name="status" id="status" aria-required="true" aria-invalid="false">
                    <option <?php echo $data['status']==1?'selected':'';?> value="1">不通过</option>
                    <option <?php echo $data['status']==2?'selected':'';?> value="2">通过</option>
                </select>
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
                picture_title:{
                    required:true,
                    minlength:2,
                    maxlength:32
                },
                picture_url:{
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