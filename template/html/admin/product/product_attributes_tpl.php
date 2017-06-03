<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetAttributesList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>商品管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页 <span class="c-gray en">&gt;</span> 商品管理 <span class="c-gray en">&gt;</span>
    商品属性 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20"> <span class="l">
            <a href="javascript:;" onclick="attributes_add('添加属性','?mod=admin&v_mod=product&_index=_attributes_new','','500')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加属性
            </a></span>
    </div>

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr class="text-c">
            <th>属性类型</th>
            <th>排序</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($data['data'])
        {
            foreach($data['data'] as $item)
            {
                ?>
                <tr class="text-c">
                    <td class="<?php echo $item['store_id']==0?'c-primary':'c-blue';?>"><?php echo $item['attr_type_name']; ?></td>
                    <td ><?php echo $item['attr_sort']; ?></td>
                    <td>
                        <?php
                            if($item['store_id']!=0)
                            {
                                ?>
                                <a title="子属性" href="javascript:;"
                                   onclick="add_child('子属性','?mod=admin&v_mod=product&_index=_attributes_child','<?php echo $item['attr_type_id'];?>')" class="ml-5"
                                   style="text-decoration:none"><i class="Hui-iconfont">&#xe600;</i>
                                </a>
                                <a title="编辑" href="javascript:;"
                                   onclick="attributes_edit('属性编辑','?mod=admin&v_mod=product&_index=_attributes_edit','<?php echo $item['attr_type_id'];?>','','500')" class="ml-5"
                                   style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i>
                                </a>
                                <a title="删除" href="javascript:;"
                                   onclick="attributes_del(this,'<?php echo $item['attr_type_id']; ?>')"
                                   class="ml-5" style="text-decoration:none">
                                    <i class="Hui-iconfont">&#xe6e2;</i>
                                </a>
                                <?php
                            }else
                            {
                                echo '-';
                            }
                        ?>
                    </td>
                </tr>
            <?php
            }
        }
        ?>
        </tbody>
    </table>
    <?php
    include RPC_DIR ."/inc/page_nav.php";
    $page=new page_nav(array("total"=>$data['total'],
        "page_size"=>$data['page_size'],
        "curpage"=>$data['curpage'],
        "extUrl"=>"",
        "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['canshu']));
    echo $page->page_nav();
    ?>
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
    function attributes_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*删除*/
    function attributes_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=product&_action=ActionDelAttrType&id='+id,
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
                }
            });
        });
    }

    /*编辑*/
    function attributes_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }
    function add_child(title,url,id,w,h){
        //layer_show(title,url+'&id='+id,w,h);
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }



</script>
</body>
</html>