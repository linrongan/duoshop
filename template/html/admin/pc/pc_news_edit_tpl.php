<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getNewsDetails()
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
    <form action="?mod=admin&v_mod=pc&_index=_news_edit&_action=ActionEditNews&id=<?php echo $_GET['id'];?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新闻名字：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['news_title'];?>" placeholder="" id="news_title" name="news_title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新闻分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select" required name="news_category" size="1">
                    <option value="">请选择分类</option>
                    <option <?php echo $data['news_category']==0?'selected':'';?> value="0">行业资讯</option>
                    <option <?php echo $data['news_category']==1?'selected':'';?> value="1">公司新闻</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新闻图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div id="news_img_upload"></div>
                <input type="hidden" name="news_img" value="<?php echo $data['news_img'];?>"  id="news_img">
                <div id="news_img_show">
                    <?php
                        if(!empty($data['news_img'])){
                            ?>
                            <img onclick="news_img_romove(this)" src="<?php echo $data['news_img'];?>" width="100"/>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="news_desc"  maxlength="300"  style="width:500px;height: 200px;">
                    <?php echo $data['news_desc'];?>
                </textarea>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="news_content"  maxlength="50"  style="width:500px;height: 200px;">
                    <?php echo $data['news_content'];?>
                </textarea>
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
            editor = K.create('textarea[name=news_content]', {
                allowFileManager : true
            });
        });

        $("#form-admin-add").validate({
            rules:{
                news_title:{
                    required:true
                },
                news_category:{
                    required:true
                },
                news_content:{
                    required:true
                },
                news_img:{
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