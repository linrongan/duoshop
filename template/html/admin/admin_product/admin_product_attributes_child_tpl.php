<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetAttrValueList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>子属性</title>
</head>
<body>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20"> <span class="l">
            <a href="javascript:;" onclick="attr_child_add('添加','?mod=admin&v_mod=admin_product&_index=_attributes_child_add&id=<?php echo $_GET['id'];?>','','460')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加
    </a></span>
</div>

    <table class="table table-border table-bordered table-bg mt-20">
        <thead>
        <tr class="text-c">
            <th>类别名称</th>
            <th>型号</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($data)
        {
            foreach($data['data'] as $item)
            {
                ?>
                <tr class="text-c">
                    <td ><?php echo $item['attr_type_name']; ?></td>
                    <td ><?php echo $item['attr_name']; ?></td>
                    <td>
                        <a title="编辑" href="javascript:;"
                           onclick="attr_child_edit('编辑','?mod=admin&v_mod=admin_product&_index=_attributes_child_edit','<?php echo $item['attr_id'];?>','','450')" class="ml-5"
                           style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="删除" href="javascript:;"
                           onclick="attr_child_del(this,'<?php echo $item['attr_id']; ?>')"
                           class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6e2;</i>
                        </a>
                    </td>
                </tr>
            <?php
            }
        }
        ?>
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
     title  标题
     url        请求的url
     id     需要操作的数据id
     w      弹出层宽度（缺省调默认值）
     h      弹出层高度（缺省调默认值）
     */
    /*增加*/
    function attr_child_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*删除*/
    function attr_child_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_product&_index=_attributes_child&_action=ActionDelAttrValue&id='+id,
                data:{'id':id},
                dataType: 'json',
                success: function(res)
                {
                    if (res.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                    layer.msg(res.msg,{icon:1,time:1000});
                    window.location="?mod=admin&v_mod=admin_product&_index=_attributes_child&id="+<?php echo $_GET['id'];?>;
                },
                error:function(res) {
                    console.log(res.msg);
                    alert('网络超时！');
                }
            });
        });
    }
    function attr_child_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }





</script>
</body>
</html>