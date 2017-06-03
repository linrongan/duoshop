<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getCouponCategory();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>优惠卷类型</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    营销管理
    <span class="c-gray en">&gt;</span>
    优惠卷类型
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">优惠卷类型</th>
                <th width="80">发送类型</th>
                <th width="80">编辑</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data)
            {
                foreach($data as $item)
                {
                    ?>
                    <tr class="text-c">

                        <td><?php echo $item['type_name']; ?></td>
                        <td><?php echo $item['sent_type']==0?'手动':'自动'; ?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" href="?mod=admin&v_mod=admin_activity&_index=_coupon_type_detail&id=<?php echo $item['id']; ?>" title="类型模板"><i class="Hui-iconfont">&#xe6df;</i> 管理优惠卷模板</a>
<!--                            <a style="text-decoration:none" class="ml-5" onClick="type_del(this,--><?php //echo $item['id']; ?><!--)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>-->
                        </td>
                    </tr>
                <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

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
        $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click","0");
    });
    //



    //首页banner
    function type_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    /*图片-添加*/
    function type_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-删除*/
    function type_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_activity&_action=ActionDelCouponType',
                data:{id:id},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==1?5:6,time:1000});
                    if(data.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }

    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    <?php
    }
    ?>
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>