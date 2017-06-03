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
    <title>设置实体店铺</title>
</head>
<body>
<article class="page-container">
    <h4>实体店铺信息</h4>
    <form action="?mod=admin&v_mod=admin_shop&_index=_physical&_action=SetPhysical&id=<?php echo $data['store_id']; ?>" method="post" class="form form-horizontal" id="form-submit">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>店铺名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['store_name'];?>" disabled>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>实体店状态：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="skin-minimal">
                    <div class="radio-box">
                        <input value="0" type="radio" id="radio-1" name="status" <?php echo $data['status']==0?'checked':''; ?>>
                        <label for="radio-1">未通过</label>
                    </div>
                    <div class="radio-box">
                        <input value="1" type="radio" id="radio-2" name="status" <?php echo $data['status']==1?'checked':''; ?>>
                        <label for="radio-2">申请中</label>
                    </div>
                    <div class="radio-box">
                        <input value="3" type="radio" id="radio-3" name="status" <?php echo $data['status']==3?'checked':''; ?>>
                        <label for="radio-3">已通过</label>
                    </div>
                </div>
               </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>最低配送：</label>
            <div class="formControls col-xs-4 col-sm-4">
                <input type="text" class="input-text" value="<?php echo $data['min_ship_fee'];?>" name="min_ship_fee" id="min_ship_fee">
            </div> 元
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>配送费用：</label>
            <div class="formControls col-xs-4 col-sm-4">
                <input type="text" class="input-text" value="<?php echo $data['ship_fee'];?>" name="ship_fee" id="ship_fee">
            </div>
            元
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>配送地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['address'];?>" name="address" id="address">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>定位设置：</label>
            <div class="formControls col-xs-2 col-sm-3">
                <input placeholder="经度(数字大放这里)" type="text" class="input-text" value="<?php echo $data['lng'];?>" name="lng" id="lng">
            </div>
            <div class="formControls col-xs-2 col-sm-3">
                <input placeholder="纬度(数字小放这里)" type="text" class="input-text" value="<?php echo $data['lat'];?>" name="lat" id="lat">
            </div>

            <div class="formControls col-xs-2 col-sm-3">
                <a target="_blank" href="http://lbs.qq.com/tool/getpoint/index.html" class="btn btn-primary size-MINI radius">如何获取坐标?</a>
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
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script src="/tool/upload/upload.js"></script>
<script type="text/javascript">
    $(function(){
        $("#form-submit").validate({
            rules:{
                lng:{
                    required:true
                },
                lat:{
                    required:true
                },
                address:{
                    required:true
                },
                min_ship_fee:{
                    required:true
                },
                ship_fee:{
                    required:true
                },
                status:{
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