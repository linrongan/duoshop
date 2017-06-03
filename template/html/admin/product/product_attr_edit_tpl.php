<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$product=$obj->GetProductDetails();
$data = $obj->GetProductAttrDetails();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="?mod=admin&v_mod=product&_index=_attr_edit&_action=ActionEditProductAttr&id=<?php echo $_GET['id']; ?>&aid=<?php echo $_GET['aid']; ?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">属性：</label>
            <div class="formControls col-xs-8 col-sm-9" style="margin-top: 3px;">
                <?php echo $data['attr_type_name'].'---->'.$data['attr_temp_name']; ?>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">
            现售原价：</label>
            <div class="formControls col-xs-8 col-sm-9" style="margin-top: 3px;">
                <?php echo $product['product_price']; ?>元
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>价格：</label>
            <div class="formControls col-xs-4 col-sm-3">
                <input placeholder="请填写价格" id="attr_change_price" name="attr_change_price" type="number" class="input-text" value="<?php echo $data['attr_change_price']; ?>">
                元
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>库存数量：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input id="product_stock" name="product_stock" digits="true" type="number" class="input-text" value="<?php echo $data['product_stock'];?>">
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input name="product_attr_sort" digits="true" type="number" class="input-text" value="<?php echo $data['product_attr_sort'];?>">
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
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form-admin-add").validate({
            rules:{
                product_attr_sort:{
                    required:true
                },
                attr_change_price:{
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
    if('<?php echo $_return['code']; ?>'==0){
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