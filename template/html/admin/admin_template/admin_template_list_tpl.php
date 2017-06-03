<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$template=$obj->getAllTemplate();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>管理员列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 商铺管理
    <span class="c-gray en">&gt;</span> 模板列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <span class="l">
            <a href="javascript:;" onclick="template_add('添加模板','?mod=admin&v_mod=admin_template&_index=_new','','500')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加模板
            </a>
        </span>
        <span class="r">共有模板：<strong><?php echo count($template); ?></strong> 条</span>
    </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">模板列表</th>
        </tr>
        <tr class="text-c">
            <th width="40">模板ID</th>
            <th>模板名字</th>
            <th>模板文件</th>
            <th>模板价格</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($template)){
            foreach($template as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['template_id'];?></td>
                    <td><?php echo $item['template_name'];?></td>
                    <td><?php echo $item['template_file'];?></td>
                    <td><?php echo $item['price'];?></td>

                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="template_edit('模板编辑','?mod=admin&v_mod=admin_template&_index=_edit','<?php echo $item['template_id'];?>','','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="template_del(this,'<?php echo $item['template_id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    /*
     参数解释：
     title	标题
     url		请求的url
     id		需要操作的数据id
     w		弹出层宽度（缺省调默认值）
     h		弹出层高度（缺省调默认值）
     */
    /*增加*/
    function template_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*删除*/
    function template_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_template&_index=_list&_action=ActionDelTemplate&id='+id,
                data:{'id':id},
                dataType: 'json',
                success: function(res)
                {
                    if (res.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                    layer.msg(res.msg,{icon:1,time:1000});
                },
                error:function(res) {
                    console.log(res.msg);
                    alert('网络超时')
                }
            });
        });
    }


    //$("#txt_spCodes").val(spCodesTemp);
    /*编辑*/
    function template_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }




</script>
</body>
</html>