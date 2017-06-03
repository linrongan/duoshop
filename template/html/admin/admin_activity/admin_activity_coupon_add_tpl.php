<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
//$category=$obj->getProductCategory();
$type = $obj->getCouponCategory();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" type="text/css" href="/template/source/admin/static/h-ui.admin/icheck/icheck.css" />
</head>
<body>
<div class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionAddCoupon';?>" class="form form-horizontal" method="post" id="check-form">

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 优惠券名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" name="coupon_name">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 优惠券金额(元)：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" name="coupon_money">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 最低消费(元)：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" name="min_money">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 券的类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select name="coupon_type" id="coupon_type" class="select">
                        <?php
                            if(!empty($type)){
                                foreach($type as $item){
                                ?>
                                    <option value="<?php echo $item['id'];?>"><?php echo $item['type_name'];?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </span>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 使用期限：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" onfocus="WdatePicker({minDate:'%y-%M-%d'})" id="datemin" name="start_time" value="" class="input-text Wdate" style="width:150px;">
                -
                <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}' })" id="datemax" name="expire_time" value="" class="input-text Wdate" style="width:150px;">
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 券的来源：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="source" id="" cols="30" rows="10">后台生成</textarea>
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
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<link rel="stylesheet" type="text/css" href="/template/source/admin/static/h-ui.admin/icheck/jquery.icheck.min.js" />

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




        $("#check-form").validate({
            rules:{
                coupon_name:{
                    required:true
                },
                coupon_money:{
                    required:true,
                    number:true,
                    min:0.01
                },
                min_money:{
                    required:true,
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
    window.parent.location.reload();
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    <?php
    }
    /*
     * <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"> 限制使用分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="skin-minimal">
                    <?php
                    if(!empty($category)){
                        foreach($category as $item){
                            ?>
                            <div class="check-box">
                                <input type="checkbox" name="category_id[]" value="<?php echo $item['category_id'];?>">
                                <label for="checkbox-1"><?php echo $item['category_name'];?></label>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
     */
    ?>
</script>
</body>
</html>