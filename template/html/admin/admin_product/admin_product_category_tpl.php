<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetCategory();
$category = $data['category'];
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>分类列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 商品管理
    <span class="c-gray en">&gt;</span> 分类列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20"> <span class="l">
            <a href="javascript:;" onclick="category_add('添加分类','?mod=admin&v_mod=admin_product&_index=_category_new','','500')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加分类
            </a></span>
    </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">分类列表</th>
        </tr>
        <tr class="text-c">
            <th>分类名称</th>
            <th>分类图片</th>
            <th>排序</th>
            <th>是否显示</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(!empty($category[0])){
            foreach($category[0] as $item){
                ?>
                <tr class="text-c">
                    <td class="text-l bk-gray" width="200"><?php echo $item['category_name']; ?></td>
                    <td><img height="30" src="<?php echo $item['category_img']; ?>" alt=""></td>
                    <td><?php echo $item['category_sort']; ?></td>
                    <td ><?php echo $item['category_show']==0?'显示':'不显示'; ?></td>
                    <td class="td-manage">
                        <a title="添加特色分类" href="javascript:;"
                           onclick="category_spec('添加特色分类','/?mod=admin&v_mod=admin_product&_index=_category_spec','<?php echo $item['category_id'];?>')"
                           class="ml-5 maincolor" style="text-decoration:none"><i class="Hui-iconfont">&#xe681;</i>
                        </a>
                        <a title="编辑" href="javascript:;"
                           onclick="category_edit('分类编辑','?mod=admin&v_mod=admin_product&_index=_category_edit','<?php echo $item['category_id'];?>','','500')"
                           class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="删除" href="javascript:;"
                           onclick="category_del(this,'<?php echo $item['category_id'];?>')"
                           class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i>
                        </a>
                    </td>
                </tr>
                <?php
                if(!empty($category[$item['category_id']])){
                    foreach($category[$item['category_id']] as $value)
                    {
                        ?>
                        <tr class="text-c">
                            <td class="text-l" width="200">&nbsp;&nbsp;&nbsp;|_______<?php echo $value['category_name']; ?></td>
                            <td><img height="30" src="<?php echo $value['category_img']; ?>" alt=""></td>
                            <td><?php echo $value['category_sort']; ?></td>
                            <td><?php echo $value['category_show']==0?'显示':'不显示'; ?></td>
                            <td>
                                <a title="编辑" href="javascript:;"
                                   onclick="category_edit('分类编辑','?mod=admin&v_mod=admin_product&_index=_category_edit','<?php echo $value['category_id'];?>','','500')"
                                   class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i>
                                </a>
                                <a title="删除" href="javascript:;"
                                   onclick="category_del(this,'<?php echo $value['category_id'];?>')"
                                   class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i>
                                </a>
                            </td>
                        </tr>
                    <?php
                        if(!empty($category[$value['category_id']]))
                        {
                            foreach($category[$value['category_id']] as $val)
                            {
                                ?>
                                <tr class="text-c">
                                    <td class="text-l" width="200">&nbsp;&nbsp;&nbsp;|______________<?php echo $val['category_name']; ?></td>
                                    <td><img height="30" src="<?php echo $val['category_img']; ?>" alt=""></td>
                                    <td><?php echo $val['category_sort']; ?></td>
                                    <td><?php echo $val['category_show']==0?'显示':'不显示'; ?></td>
                                    <td>
                                        <a title="编辑" href="javascript:;"
                                           onclick="category_edit('分类编辑','?mod=admin&v_mod=admin_product&_index=_category_edit','<?php echo $val['category_id'];?>','','500')"
                                           class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i>
                                        </a>
                                        <a title="删除" href="javascript:;"
                                           onclick="category_del(this,'<?php echo $val['category_id'];?>')"
                                           class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
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
     title	标题
     url		请求的url
     id		需要操作的数据id
     w		弹出层宽度（缺省调默认值）
     h		弹出层高度（缺省调默认值）
     */
    /*增加*/
    function category_add(title,url,w,h){
        layer_show(title,url,w,h);
    }

    /*编辑*/
    function category_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }
    //属性
    function product_attr(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }

    /*删除*/
    function category_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_product&_index=_category&_action=ActionDelCategory&id='+id,
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
    //特色分类
    function category_spec(title,url,id){
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