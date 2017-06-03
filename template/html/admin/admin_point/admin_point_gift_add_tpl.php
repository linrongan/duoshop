<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$category = $obj->GetProductCategory();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/tool/upload/upload.css">
</head>
<body>
<div class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionAddGift';?>" class="form form-horizontal" method="post" id="check-form">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 礼品名字：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" name="gift_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 图片(封面)(宽*高320*320)：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="picture_path_upload">
                        <input type="hidden" value="" name="source_img" id="img">
                    </div>
                    <div id="picture_path_pic">

                    </div>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 图片(封面)(宽*高640*320)：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="gift_img_upload"></div>
                    <input type="hidden" value="" name="gift_img" id="gift_img">
                    <div id="show_cover2"></div>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 所属类别：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select class="select" required name="category_id" id="category_id">
                        <?php
                        if($category)
                        {
                            foreach($category as $item){
                                ?>
                                <option value="<?php echo $item['category_id'];?>"><?php echo $item['category_name'];?></option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                </span>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 兑换积分：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" name="gift_point">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 库存：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" name="qty">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 货物单位：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" name="unit">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 默认排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="0" placeholder="" name="ry_order">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 图文：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="content" id="content" rows="10"></textarea>
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
<script charset="utf-8" src="/tool/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/tool/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/tool/upload/upload.js"></script>
<script type="text/javascript">
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name=content]', {
            allowFileManager : true
        });
    });
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
        $('#gift_img_upload').upload({
            auto:true,
            fileTypeExts:'*.jpg;*.png',
            multi:false,
            formData:{'format':'small'},
            fileSizeLimit:2048,
            showUploadedPercent:true,//是否实时显示上传的百分比，如20%
            showUploadedSize:true,
            removeTimeout:3,
            queueSizeLimit: 1,
            removeCompleted:true,
            uploader:'/tool/upload/upload.php',
            onUploadSuccess:function(file,res,response){
                var result = $.parseJSON(res);
                if(result.code==0)
                {
                    $("#gift_img").val(result.path);
                    $("#show_cover2").empty();
                    $("#show_cover2").append('<img src="'+result.path+'" width="100">');
                }else{
                    alert(result.msg);
                }
            }
        });

        $("#check-form").validate({
            rules:{
                img:{
                    required:true
                },
                gift_img:{
                    required:true
                },
                gift_name:{
                    required:true,
                    maxlength:16
                },
                unit:{
                    required:true
                },
                qty:{
                    required:true,
                    min:1,
                    number:true
                },
                need_point:{
                    required:true,
                    min:1,
                    number:true
                },
                ry_order:{
                    number:true
                }
            }
        });
    });

    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    if('<?php echo $_return['code']; ?>'==0){
        window.parent.location.reload();
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    <?php
    }
    ?>
</script>
</body>
</html>