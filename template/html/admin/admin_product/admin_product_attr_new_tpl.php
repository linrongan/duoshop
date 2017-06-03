<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(!isset($_GET['product']))
{
    redirect(ADMIN_ERROR);

}
$select_attr_array = array();
$select_attr = $obj->GetProductAttrList($_GET['product']);
if($select_attr)
{
    foreach($select_attr as $arr)
    {
        $select_attr_array[] = $arr['attr_temp_id'];
    }
}
$attr = $obj->GetProductAttrValue();
$attr_array  = array();
if($attr)
{
    foreach($attr as $value)
    {
        $attr_array[$value['attr_type_id']]['attr_id'] = $value['attr_id'];
        $attr_array[$value['attr_type_id']]['attr_type_name'] = $value['attr_type_name'];
        $attr_array[$value['attr_type_id']]['val'][$value['attr_id']] = $value['attr_name'];
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="?mod=admin&v_mod=admin_product&_index=_attr_new&_action=ActionNewProductAttr&product=<?php echo $_GET['product']; ?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>属性：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select" size="1" name="attr_temp_id">
                    <option value="">请选择属性</option>
                    <?php
                    if($attr_array)
                    {
                        foreach($attr_array as $item)
                        {
                            ?>
                            <optgroup label="<?php echo $item['attr_type_name']; ?>">
                                <?php
                                if($item['val'] && count($item['val'])>0)
                                {
                                    foreach($item['val'] as $k=> $v)
                                    {
                                        ?>
                                        <option <?php if(in_array($k,$select_attr_array)){echo 'disabled';} ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </optgroup>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input name="product_attr_sort" digits="true" type="number" class="input-text" value="0">
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
                attr_temp_id:{
                    required:true
                },
                product_attr_sort:{
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
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>