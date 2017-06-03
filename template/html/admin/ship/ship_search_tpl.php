<?php
//$data = $obj->GetOrderList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>物流查询</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 物流管理
    <span class="c-gray en">&gt;</span> 物流查询 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">


    <div class="mt-20">
        <form action="?mod=admin&v_mod=ship&_index=_new_logistics" method="post" class="form form-horizontal" id="check_form">
            <div class="row cl">
                <div class="col-sm-6">
                    <h4>请选择快递公司</h4>
<?php
$logistics=$obj->getLogisticsCompany();
//echo '<pre>';
//print_r($logistics);
?>                  <div class="row cl">

                    <?php foreach($logistics['result'] as $log){ ?>
                        <div class="col-sm-3"><a href="javascript:;" onclick="getLog('<?php echo $log['name'];?>','<?php echo $log['type'];?>')"><?php echo $log['name'];?></a></div>
                    <?php } ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4>要查询的运单号</h4>
                    <div id="value"></div>
                    <input type="hidden" class="input-text" id="com_type" name="com_type" value=""/>
                    <input type="text" class="input-text" name="number" value="" placeholder="请输入要查询的运单号"/>
                    <input class="btn btn-primary radius mt-20" type="submit" value="&nbsp;&nbsp;查询&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>
</div>

<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    function getLog(name,type){
        $('#com_type').val(type);
        $("#value").html(name);
    }
    $("#check_form").validate({
        rules:{
            number:{
                required:true
            }
        }
    });

    <?php
        if(isset($_return))
        {
        ?>
    alert('<?php echo $_return['msg']; ?>');
    <?php
    }
    ?>

</script>
</body>
</html>