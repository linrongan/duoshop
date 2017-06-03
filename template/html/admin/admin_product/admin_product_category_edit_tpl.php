<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');

}
$type = $obj->GetCategory();
$category = $type['category'];
$data = $obj->GetCategoryDetail();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/tool/upload/upload.css">
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="?mod=admin&v_mod=admin_product&_index=_category_edit&_action=ActionEditCategory&id=<?php echo $_GET['id']; ?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">分类图片：<br/><span class="c-999">一级(450*230)<br/>其他(80*80)</span></label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="hidden" name="category_img" value="<?php  echo $data['data']['category_img']; ?>" id="category_img">
                <div id="category_img_show">
                    <img src="<?php echo $data['data']['category_img']; ?>" width="100" alt="">
                </div>
                <div id="category_img_upload" class="mt-10"></div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span> 商品分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" size="1" name="category_id" id="category_id">
                    <option value="0">一级分类</option>
                    <?php
                    if(!empty($category[0]))
                    {
                        foreach($category[0] as $item)
                        {
                            ?>
                            <option <?php if($data['data']['category_parent_id']==$item['category_id']){echo 'selected';} ?> value="<?php echo $item['category_id']; ?>"><?php echo $item['category_name']; ?></option>
                            <?php
                            $str = '';
                            $str .= '|____';
                            while (!empty($category[$item['category_id']]))
                            {
                                foreach($category[$item['category_id']] as $item)
                                {
                                    ?>
                                    <option <?php if($data['data']['category_parent_id']==$item['category_id']){echo 'selected';} ?> value="<?php echo $item['category_id']; ?>"><?php echo $str; ?><?php echo $item['category_name']; ?></option>
                                    <?php
                                }
                                $str.='____';
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span> 分类名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input name="category_name" id="category_name" type="text" class="input-text" value="<?php echo $data['data']['category_name']; ?>"/>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span> 排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input name="ry_order" value="<?php echo $data['data']['category_sort'] ?>" id="ry_order" type="text" class="input-text"/>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span> 是否首页显示：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select valid select-box" size="1" name="show_status" id="show_status">
                    <option value="0" <?php echo $data['data']['category_show']==0?'selected':''; ?>>是</option>
                    <option value="1" <?php echo $data['data']['category_show']==1?'selected':''; ?>>否</option>
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
                category_id:{
                    required:true
                },
                category_name:{
                    required:true
                },
                show_status:{
                    required:true
                },
                ry_order:{
                    required:true
                }
            }

        });
        $('#category_img_upload').upload({
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
                    $("#category_img").val(result.path);
                    $("#category_img_show").empty();
                    $("#category_img_show").append('<img src="' + result.path + '" width="100">');
                } else {
                    alert(result.msg);
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
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>