<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getPageBannerDetails()
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" type="text/css" href="/tool/upload/upload.css" />
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="?mod=admin&v_mod=pc&_index=_page_banner_edit&_action=ActionEditPageBanner&id=<?php echo $_GET['id'];?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">页面名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <?php echo $data['picture_title'];?>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>banner图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div id="news_img_upload"></div>
                <input type="hidden" name="picture_path" value="<?php echo $data['picture_path'];?>"  id="news_img">
                <div id="news_img_show">
                    <?php
                    if(!empty($data['picture_path'])){
                        ?>
                        <img onclick="news_img_romove(this)" src="<?php echo $data['picture_path'];?>" width="100"/>
                    <?php
                    }
                    ?>
                </div>
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
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });



        $("#form-admin-add").validate({
            rules:{
                picture_path:{
                    required:true
                }
            }

        });

        $('#news_img_upload').upload({
            auto: true,
            fileTypeExts: '*.jpg;*.png',
            multi: false,
            buttonText:'选择图片',
            formData: {'format': 'small'},
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
                    $("#news_img").val(result.path);
                    $("#news_img_show").empty();
                    $("#news_img_show").append('<img onclick="news_img_romove(this)" src="' + result.path + '" width="100">');
                } else {
                    alert(result.msg);
                }
            }
        });
    });

    function news_img_romove(obj) {
        if(confirm('移除当前图片？'))
        {
            $("#news_img").val('');
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
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>