<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetLogisticsList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>所有物流</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 物流管理
    <span class="c-gray en">&gt;</span> 所有物流
</nav>
<div class="page-container">
    <form action="" method="post" class="mb-20">
        <div>
            <input type="text" class="input-text" style="width:200px"
                   value="<?php if(isset($_REQUEST['logistics_name'])){echo $_REQUEST['logistics_name'];} ?>"
                   placeholder="输入物流名称" id="" name="logistics_name">
            <input type="text" class="input-text" style="width:150px"
                   value="<?php if(isset($_REQUEST['logistics_name'])){echo $_REQUEST['logistics_letter'];} ?>"
                   placeholder="输入首字母" id="" name="logistics_letter">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <a class="btn btn-success radius" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
        </div>
    </form>

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <span class="l">
            <a href="javascript:;" onclick="logistics_add('添加物流','?mod=admin&v_mod=admin_logistics&_index=_add')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加物流
            </a>
        </span>
    </div>

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">物流列表</th>
        </tr>
        <tr class="text-c">
            <th width="30">首字母</th>
            <th width="80">物流名称</th>
            <th width="80">英文名称</th>
            <th width="40">物流电话</th>
            <th width="80">排序</th>
            <th width="80">编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['logistics_letter'];?></td>
                    <td><?php echo $item['logistics_name'];?></td>
                    <td><?php echo $item['logistics_type'];?></td>
                    <td><?php echo $item['logistics_tel'];?></td>
                    <td><?php echo $item['logistics_sort'];?></td>
                    <td>
                        <a title="编辑" href="javascript:;" onclick="logistics_edit('编辑','?mod=admin&v_mod=admin_logistics&_index=_edit','<?php echo $item['logistics_id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="logistics_del(this,'<?php echo $item['logistics_id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            <?php }
        } ?>
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
    <?php
        if(!empty($data['canshu']) && empty($data['canshu']))
        {
            ?>
    layer.confirm('没有查出内容，是否初始化？',function(index)
    {
        location.href='?mod=admin&v_mod=admin_bank&_index=_list';
    });
    <?php
        }
    ?>
    /*增加*/
    function logistics_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*删除*/
    function logistics_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_logistics&_action=ActionDelLogistics&id='+id,
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
    /*编辑*/
    function logistics_edit(title,url,id){
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