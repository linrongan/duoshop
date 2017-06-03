<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetProductAttr();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>管理员列表</title>
</head>
<body>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20"> <span class="l">
            <a href="javascript:;" onclick="attr_add('添加属性','?mod=admin&v_mod=product&_index=_attr_new&id=<?php echo $_GET['id'];?>')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加属性
            </a></span>
    </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr class="text-c">
            <th>产品图片</th>
            <th>产品名称</th>
            <th>描述</th>
            <th>价格</th>
        </tr>
        </thead>
        <tbody>
        <tr class="text-c">
            <td><img width="50" src="<?php echo $data['product']['product_img']; ?>" alt=""></td>
            <td><?php echo $data['product']['product_name']; ?></td>
            <td><?php echo $data['product']['product_desc']; ?></td>
            <td><?php echo $data['product']['product_price']; ?></td>
        </tr>
        </tbody>
    </table>
    <table class="table table-border table-bordered table-bg mt-20">
        <thead>
        <tr class="text-c">
            <th>属性名称</th>
            <th>属性内容</th>
            <th>价格</th>
            <th>库存数量</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($data['attr'])
        {
            foreach($data['attr'] as $item)
            {
                ?>
                <tr class="text-c">
                    <td><?php echo $item['attr_type_name']; ?></td>
                    <td><?php echo $item['attr_temp_name']; ?></td>
                    <td>￥<?php echo $item['attr_change_price']; ?></td>
                    <td><?php echo $item['product_stock']; ?><?php echo $data['product']['product_unit']; ?></td>
                    <td>
                        <a title="编辑" href="javascript:;" onclick="attr_edit('属性编辑','?mod=admin&v_mod=product&_index=_attr_edit','<?php echo $_GET['id'];?>','<?php echo $item['id']; ?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont"></i>
                        </a>
                        <a title="删除" href="javascript:;"
                           onclick="attr_del(this,'<?php echo $_GET['id']; ?>','<?php echo $item['id']; ?>')"
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
    function attr_add(title,url){
        layer.open({
            type: 2,
            area: ['800px','450px'],
            fix: false, //不固定
            title: title,
            content: url
        });
    }
    /*属性-编辑*/
    function attr_edit(title,url,pid,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+pid+'&aid='+id,
            end:function(){
                window.location.reload();
            }
        });
        layer.full(index);
    }
    /*删除*/
    function attr_del(obj,pid,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=product&_index=_attr&_action=ActionDelProductAttr&product='+pid+'&id='+id,
                data:{'id':id,'product':pid},
                dataType: 'json',
                success: function(res)
                {
                    if (res.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                    layer.msg(res.msg,{icon: res.code==0?6:5,time:1000});
                    window.location.reload();
                },
                error:function(res) {
                    console.log(res.msg);
                }
            });
        });
    }






</script>
</body>
</html>