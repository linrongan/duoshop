<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$role = $obj->getNoticeRole();
$data = $obj->getNoticeDetail();
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
    <form action="<?php echo _URL_.'&_action=ActionEditNotice';?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['title'];?>" maxlength="50" name="title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>消息分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" required name="alert_role_id" size="1">

                    <option value="">请选择消息分类</option>
                    <?php
                    if(!empty($role))
                    {
                        foreach($role as $item)
                        {
                            ?>
                            <option <?php echo $data['alert_role_id']==$item['alert_role_id']?'selected':'';?>
                                value="<?php echo $item['alert_role_id'];?>"><?php echo $item['name'];?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>缩略图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div id="news_img_upload"></div>
                <input type="hidden" name="img" value="<?php echo $data['img'];?>"  id="news_img">
                <div id="news_img_show">
                    <img width="50" onclick="news_img_remove(this)" src="<?php echo $data['img'];?>" alt=""/>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="abstract"  maxlength="300"  rows="10" class="textarea radius"><?php echo $data['abstract'];?></textarea>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>打开方式：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" required name="open_way" size="1">
                    <option <?php echo $data['open_way']==0?'selected':'';?> value="0">图文</option>
                    <option <?php echo $data['open_way']==1?'selected':'';?> value="1">外链</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">图文：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="alert_text" rows="10" class="textarea radius"><?php echo $data['alert_text'];?></textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">外链：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['alert_link'];?>" placeholder="" id="alert_link" name="alert_link">
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
<script src="/tool/upload/upload.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name=alert_text]', {
                allowFileManager : true
            });
        });

        $("#form-admin-add").validate({
            rules:{
                title:{
                    required:true
                },
                alert_role_id:{
                    required:true,
                    number:true
                },
                open_way:{
                    required:true,
                    number:true
                },
                abstract:{
                    required:true
                },
                img:{
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
                    $("#news_img_show").append('<img onclick="news_img_remove(this)" src="' + result.path + '" width="100">');
                } else {
                    alert(result.msg);
                }
            }
        });
    });

    function news_img_remove(obj) {
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
    if('<?php echo $_return['code'];?>'==0)
    {
        window.parent.location.reload();
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    <?php
    }
    ?>
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>