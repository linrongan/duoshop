<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getThisShop();
$template = $obj->getTemplateList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" type="text/css" href="/tool/upload/upload.css" />

    <title>添加用户</title>
</head>
<body>
<article class="page-container">
    <h4>编辑<?php echo $data['admin_name'];?>的店铺</h4>
    <form action="?mod=admin&v_mod=admin_shop&_index=_edit&_action=EditShop&id=<?php echo $data['admin_id']; ?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>店铺名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['store_name'];?>" placeholder="" id="store_name" name="store_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>店铺logo(100*100)：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="hidden" name="store_logo" value="<?php echo $data['store_logo']; ?>" id="store_logo">
                <div id="fields_image_show">
                    <?php
                    if($data['store_logo'])
                    {
                        ?>
                        <img onclick="img_romove(this)" width="50" src="<?php echo $data['store_logo']; ?>" alt="">
                    <?php
                    }
                    ?>
                </div>
                <div id="fields_image_upload" class="mt-10"></div>

            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>模板：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" id="template_id" name="template_id" size="1">
                    <?php foreach($template as $t):?>
                    <option value="">请选择模板</option>
                    <option value="<?php echo $t['template_id']?>" <?php if($data['template_id']==$t['template_id']){echo 'selected';} ?>>
                        <?php echo $t['template_name']?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" id="store_status" name="store_status" size="1">
                    <option value="0" <?php if($data['store_status']==0){echo 'selected';} ?>>未开通</option>
                    <option value="1" <?php if($data['store_status']==1){echo 'selected';} ?>>准备开通</option>
                    <option value="2"  <?php if($data['store_status']==2){echo 'selected';} ?>>开通中</option>
                    <option value="3"  <?php if($data['store_status']==3){echo 'selected';} ?>>正常</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">店铺销量：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['store_sold'];?>" placeholder="" id="store_sold" name="store_sold">
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
<script src="/tool/upload/upload.js"></script>
<script type="text/javascript">
    $(function(){
        $("#form-member-add").validate({
            rules:{
                store_name:{
                    required:true
                },
                template_id:{
                    required:true
                },
                store_status:{
                    required:true
                }
            }
        });
        //uplode
        $('#fields_image_upload').upload({
            auto: true,
            fileTypeExts: '*.jpg;*.png',
            multi: false,
            buttonText:'选择图片',
            fileSizeLimit: 2048,
            showUploadedPercent: true,//是否实时显示上传的百分比，如20%
            showUploadedSize: true,
            removeTimeout: 3,
            queueSizeLimit: 1,
            removeCompleted: true,
            uploader: '/tool/upload/upload.php',
            onUploadSuccess: function (file, res, response) {
                var result = $.parseJSON(res);
                if (result.code == 0) {
                    $("#store_logo").val(result.path);
                    $("#fields_image_show").empty();
                    $("#fields_image_show").append('<img src="' + result.path + '" width="100">');
                } else {
                    alert(result.msg);
                }
            }
        });


    });
    function img_romove(obj) {
        if(confirm('移除当前图片？'))
        {
            $("#store_logo").val('');
            $(obj).remove();
        }
    }
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