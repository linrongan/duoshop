<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getLogisticsDetails();

//echo '<pre>';
//print_r($data);

?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title></title>
</head>
<script type="text/javascript">
    <?php
     if($data['code']==1)
     {
     ?>
    alert('<?php echo $data['msg']; ?>');
    window.location.href=history.back(-1);
    <?php
    }
    ?>
</script>
<body>
<article class="page-container">
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3 text-r">你的快递单号为：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <?php echo $data['result']['number']?$data['result']['number']:''; ?>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3 text-r">运送公司为：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <?php echo $data['result']['type']?$data['result']['type']:''; ?>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3 text-r">状态：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <ul>
            <?php
                if($data['result']['list'])
                {
                    foreach($data['result']['list'] as $list)
                    { ?>
                        <li><?php echo $list['time'].'&nbsp;&nbsp;&nbsp;'.$list['status'];?></li>
            <?php   }
                }
            ?>
            </ul>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3 text-r"></label>
        <div class="formControls col-xs-8 col-sm-9">
            <a href="javascript:;" onclick="javascript :history.back(-1);" class="btn btn-success-outline radius mt-20">返回上一页</a>
        </div>
    </div>
</article>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>

<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>