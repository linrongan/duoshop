<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getAboutPage();

?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>官网咨询</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 官网管理
    <span class="c-gray en">&gt;</span> 关于我们
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <span class="l">
            <a href="javascript:;" onclick="page_add('添加页面','?mod=admin&v_mod=pc&_index=_about_page_new')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加页面
            </a>
        </span>
    </div>

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">页面列表</th>
        </tr>
        <tr class="text-c">
            <th>页面名称</th>
            <th>页面类型</th>
            <th>添加时间</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data)){
            foreach($data as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['page_title'];?></td>
                    <td><?php echo $item['type']==1?'关于我们页面':'其他';?></td>
                    <td><?php echo date('Y-m-d',$item['addtime']);?></td>
                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="page_edit('编辑','?mod=admin&v_mod=pc&_index=_about_page_edit','<?php echo $item['id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="page_del(this,'<?php echo $item['id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
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
    function page_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*编辑*/
    function page_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    /*删除*/
    function page_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=pc&_index=_about_page&_action=ActionDelAboutPage&id='+id,
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




</script>
</body>
</html>