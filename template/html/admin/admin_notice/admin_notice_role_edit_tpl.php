<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getNoticeRoleDetail();
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
    <form action="<?php echo _URL_.'&_action=ActionEditNoticeRole';?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['name'];?>" maxlength="50" name="name">
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图标：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div id="news_img_upload"></div>
                <input type="hidden" name="icon" value="<?php echo $data['icon'];?>"  id="news_img">
                <div id="news_img_show">
                    <img width="100" onclick="news_img_remove(this)" src="<?php echo $data['icon'];?>" alt=""/>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" value="<?php echo $data['ry_sort'];?>" name="ry_sort" class="input-text"/>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" required name="alert_type" size="1">
                    <option <?php echo $data['alert_type']==0?'selected':'';?> value="0">图文</option>
                    <option <?php echo $data['alert_type']==1?'selected':'';?> value="1">消息</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" required name="open_status" size="1">
                    <option <?php echo $data['alert_type']==0?'selected':'';?> value="0">正常使用</option>
                    <option <?php echo $data['alert_type']==1?'selected':'';?> value="1">暂停使用</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>提示角色：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" required name="role_id" size="1">
                    <option <?php echo $data['role_id']==0?'selected':'';?> value="0">所有人</option>
                    <option <?php echo $data['role_id']==1?'selected':'';?> value="1">管理员</option>
                    <option <?php echo $data['role_id']==2?'selected':'';?> value="2">普通商户</option>
                    <option <?php echo $data['role_id']==3?'selected':'';?> value="3">普通会员</option>
                </select>
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
                name:{
                    required:true
                },
                ry_sort:{
                    required:false,
                    number:true
                },
                alert_type:{
                    required:true,
                    number:true
                },
                open_status:{
                    required:true,
                    number:true
                },
                icon:{
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