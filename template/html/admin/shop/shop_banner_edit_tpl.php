<?php
$data = $obj->GetOneShopCommAD($_GET['type']);
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>编辑轮播图</title>
    <link rel="stylesheet" href="/tool/upload/upload.css">
</head>
<body>
<div class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionEditShopBanner'; ?>" class="form form-horizontal" method="post" id="check-form">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 图片标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['title']; ?>" placeholder="" id="title" name="title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图片链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['page_url']; ?>" placeholder="" id="page_url" name="page_url">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">排序值：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['ry_order']; ?>" placeholder="" id="ry_order" name="ry_order">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 缩略图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="picture_path_upload">
                        <input type="hidden" value="<?php echo $data['img']; ?>" name="img" id="img">
                    </div>
                    <div id="picture_path_pic">
                        <?php
                        if(!empty($data['img']))
                        {
                            ?>
                            <img src="<?php echo $data['img']; ?>" width="140" height="140" class="thumbnail"/>
                        <?php
                        }
                        ?>
                    </div>
                </div>
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
<script type="text/javascript" src="/tool/upload/upload.js"></script>
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

        $('#picture_path_upload').upload({
            auto:true,  //自动上传
            fileTypeExts:'*.jpg;*.png;*.exe',   //允许文件后缀
            multi:true, //多文件上传
            fileSizeLimit:2048, //文件最大
            showUploadedPercent:true,//是否实时显示上传的百分比
            showUploadedSize:true,  //显示上传文件的大小
            removeTimeout:1000,  //超时时间
            uploader:'/tool/upload/upload.php',  //服务器地址
            onUploadSuccess:function(file,res,response){
                var result = $.parseJSON(res);
                layer.msg(result.msg, {icon:result.code==0?6:5,time:1000});
                if(result.code==0)
                {
                    $("#img").val(result.path);
                    $("#picture_path_pic").empty();
                    $("#picture_path_pic").append('<img src="'+result.path+'" width="140" height="140" class="thumbnail"/>')
                }
            }
        });


        $("#check-form").validate({
            rules:{
                img:{
                    required:true
                },
                title:{
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