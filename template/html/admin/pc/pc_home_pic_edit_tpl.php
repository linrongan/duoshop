<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getThisPicDetails();
if(empty($data)){
    readdir(NOFOUND);
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>添加图片</title>
    <link rel="stylesheet" href="/tool/upload/upload.css">
</head>
<body>
<div class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionEditHomePic'; ?>" class="form form-horizontal" method="post" id="check-form">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['picture_title'];?>" id="picture_title" name="picture_title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['picture_url'];?>" id="picture_url" name="picture_url">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 图片：</label>

            <?php
                if($data['ad_type']==3) {
                    ?>
                    <div class="formControls col-xs-8 col-sm-9">
                        <div id="phone_img_upload"></div>
                        <div id="img_items">
                            <?php
                            if(!empty($data['picture_path']))
                            {
                                $imgs = unserialize($data['picture_path']);
                                for($i=0;$i<count($imgs);$i++)
                                {
                                    ?>
                                    <input type="hidden" name="picture_path[]" value="<?php echo $imgs[$i]; ?>">
                                <?php
                                }
                            }else{
                                $imgs = null;
                            }
                            ?>
                        </div>
                        <div id="phone_img_show">
                            <?php
                            if($imgs)
                            {
                                for($i=0;$i<count($imgs);$i++)
                                {
                                    ?>
                                    <img onclick="phone_img_romove(this)" src="<?php echo $imgs[$i]; ?>" width="100" alt="">
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }else{
                ?>
                    <div class="formControls col-xs-8 col-sm-9">
                        <div class="uploader-thum-container">
                            <div id="picture_path_upload">
                                <input type="hidden" value="<?php echo $data['picture_path'];?>" name="picture_path" id="img">
                            </div>
                            <div id="picture_path_pic">
                                <img src="<?php echo $data['picture_path'];?>" width="100"/>
                            </div>
                        </div>
                    </div>
                <?php
                }
            ?>


        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图片文字说明：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="picture_text" maxlength="300" style="width:500px;height: 200px;"><?php echo $data['picture_text'];?></textarea>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 是否可见：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select" required="" name="picture_show" size="1" aria-required="true">
                    <option value="">请选择是否可见</option>
                    <option <?php echo $data['picture_show']==0?'selected':'';?> value="0">否</option>
                    <option <?php echo $data['picture_show']==1?'selected':'';?> value="1">是</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">排序值：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['picture_sort'];?>" id="picture_sort" name="picture_sort">
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

        $('#phone_img_upload').upload({
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
                    layer.msg(result.msg, {icon: 6});
                    $("#img_items").append('<input type="hidden" name="picture_path[]" value="'+result.path+'">');
                    var file_img = '<img width="100" onclick="phone_img_romove(this)" src="'+result.path+'">';
                    $("#phone_img_show").append(file_img);
                }
            }
        });




        $("#check-form").validate({
            rules:{
                img:{
                    picture_title:true
                },
                title:{
                    required:true
                }
            }
        });
    });
    function phone_img_romove(obj) {
        var this_index = $(obj).index();
        if(confirm('移除图片第'+parseInt(this_index+1)+'张'))
        {
            $("#img_items").children('input').eq(this_index).remove();
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