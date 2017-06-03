<?php
$data = $obj->GetOneSekillProduct($_GET['id']);
$quantum = $obj->getSekillQuantum();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link href="/template/source/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/tool/upload/upload.css">
    <title>添加到秒杀</title>
</head>
<body>
<div class="page-container">
    <form action="<?php echo _URL_.'&_action=ActionNewSekillProduct'; ?>" method="post" class="form form-horizontal" id="check_form">

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>秒杀库存：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['seckill_stock'];?>" placeholder=""  name="seckill_stock">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">已秒杀数量：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['seckill_buy_stock'];?>" placeholder=""  name="seckill_buy_stock">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单人最大购买数量<br>（0不限制）：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="seckill_one_count" placeholder="" value="<?php echo $data['seckill_one_count'];?>" class="input-text">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>秒杀价：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="seckill_price"  placeholder="" value="<?php echo $data['seckill_price'];?>" class="input-text" style="width:90%">
                元</div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="seckill_sort"  placeholder="" value="<?php echo $data['seckill_sort'];?>" class="input-text" style="width:90%">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>秒杀开始时间：</label>
            <div class="formControls col-xs-8 col-sm-9">

                <input type="text" onfocus="WdatePicker()" id="datemax" name="start_day" value="<?php echo $data['start_day'];?>" class="input-text Wdate" style="width:120px;">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>秒杀场次：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="quantum_id" id="quantum_id" class="select select-box">
                    <option value="">请选择秒杀场次</option>
                    <?php
                    if(!empty($quantum)){
                        foreach($quantum as $item){
                            ?>
                            <option <?php echo $data['quantum_id']==$item['quantum_id']?'selected':'';?> value="<?php echo $item['quantum_id'];?>"><?php echo $item['quantum'];?>【<?php echo $item['start_time'].'-'.$item['end_time'];?>】</option>
                        <?php
                        }
                    }
                    ?>
                </select>
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
<script type="text/javascript" src="/template/source/admin/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript">

    $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });

    $("#check_form").validate({
        rules:{
            seckill_stock:{
                required:true,
                number:true
            },
            seckill_buy_stock:{
                required:true,
                number:true
            },
            seckill_one_count:{
                required:true,
                min:0,
                number:true
            },
            seckill_sort:{
                required:true,
                number:true
            },
            quantum_id:{
                required:true,
                number:true
            },
            seckill_price:{
                required:true,
                min:0.01,
                number:true
            }
        }
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