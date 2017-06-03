<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');

}
$type = $obj->GetCategory();
$category = $type['category'];
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
    <form action="?mod=admin&v_mod=admin_product&_index=_new&_action=ActionNewProduct" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" name="product_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" name="product_desc">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>商品分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select" size="1" name="category_id" id="category_id">
                    <option value="">请选择分类</option>
                    <?php
                    if($category[0]){
                        foreach($category[0] as $item){
                            ?>
                            <option <?php if($data['category_id']==$item['category_id']){echo 'selected';} ?> value="<?php echo $item['category_id']; ?>"><?php echo $item['category_name']; ?></option>
                            <?php
                            if(!empty($category[$item['category_id']])){
                                foreach($category[$item['category_id']] as $value){
                                    ?>
                                    <option <?php if($data['category_id']==$value['category_id']){echo 'selected';} ?> value="<?php echo $value['category_id']; ?>">
                                        |__<?php echo $value['category_name']; ?>
                                    </option>
                                <?php
                                }
                            }
                            ?>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图片(封面)(宽*高100*150)：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div id="product_img_upload"></div>
                <input type="hidden" name="product_img" value=""  id="product_img">
                <div id="product_img_show">
                    <?php
                    if(!empty($data['product_img']))
                    {
                        ?>
                        <img onclick="product_img_romove(this)" src="<?php echo $data['product_img']; ?>" width="100" alt="">
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>标价：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" name="product_fake_price">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>售价：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" name="product_price">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input  name="product_sort" type="number" class="input-text" value="" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select" required name="product_status" size="1">
                    <option value="">请选择状态</option>
                    <option value="0" <?php echo $data['product_status']==0?'selected':''; ?>>上架</option>
                    <option value="1" <?php echo $data['product_status']==1?'selected':''; ?>>下架</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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
                product_name:{
                    required:true
                },
                category_id:{
                    required:true
                },
                product_price:{
                    required:true
                },
                product_fake_price:{
                    required:true
                },
                product_status:{
                    required:true
                }
            }

        });
    });
    $(function(){

        $('#product_img_upload').upload({
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
                    $("#product_img").val(result.path);
                    $("#product_img_show").empty();
                    $("#product_img_show").append('<img src="' + result.path + '" width="100">');
                } else {
                    alert(result.msg);
                }
            }
        });


//
    });

    function product_img_romove(obj) {
        if(confirm('移除当前图片？'))
        {
            $("#product_img").val('');
            $(obj).remove();
        }
    }

    function product_details_img_romove(obj) {
        var this_index = $(obj).index();
        if(confirm('移除产品详情图第'+parseInt(this_index+1)+'张'))
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
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>