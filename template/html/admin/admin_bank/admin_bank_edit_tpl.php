<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetBankDetail();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title></title>
</head>
<body>
<article class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionEditBank';?>" method="post" class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>银行名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['bank_name'];?>" maxlength="20" name="bank_name">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>首字母：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="bank_initial" id="bank_initial" class="select select-box">
                    <option value="">请选择银行首字母</option>
                    <?php
                    for($i=65;$i<91;$i++)
                    {
                        ?>
                        <option <?php echo $data['bank_initial']==strtoupper(chr($i))?'selected':''?>
                            value="<?php echo strtoupper(chr($i)); ?>"><?php echo strtoupper(chr($i)); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>搜索关键字：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['bank_keyword'];?>" maxlength="10" name="bank_keyword">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" value="<?php echo $data['bank_sort'];?>" name="bank_sort">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">英文名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['bank_english_name'];?>" placeholder="" name="bank_english_name">
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
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });


        $("#form-admin-add").validate({
            rules:{
                bank_name:{
                    required:true
                },
                bank_initial:{
                    required:true
                },
                bank_keyword:{
                    required:true
                },
                bank_english_name:{
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