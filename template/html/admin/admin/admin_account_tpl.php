<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$admin=$obj->AdminList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>管理员列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 管理员管理
    <span class="c-gray en">&gt;</span> 管理员列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20"> <span class="l">
            <a href="javascript:;" onclick="admin_add('添加管理员','/?mod=admin&_index=_account_new','','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span>
        <span class="r">共有数据：<strong><?php echo count($admin); ?></strong> 条</span>
    </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">管理员列表</th>
        </tr>
        <tr class="text-c">
            <th width="40">ID</th>
            <th width="150">姓名</th>
            <th width="150">账号</th>
            <th>角色</th>
            <th width="130">最后登录时间</th>
            <th width="100">状态</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($admin)){
            foreach($admin as $item){
        ?>
        <tr class="text-c">
            <td><?php echo $item['admin_id'];?></td>
            <td><?php echo $item['admin_name'];?></td>
            <td><?php echo $item['admin_account'];?></td>
            <td><?php echo $item['role_name'];?></td>
            <td><?php echo $item['admin_last_login'];?></td>
            <td class="td-status">

                    <?php
                        if($item['admin_status']==0){
                            echo "<span class='label label-success radius'>正常 </span>";
                        }else{
                            echo '<span class="label label-default radius">已锁定</span>';
                        }
                    ?>

            </td>
            <td class="td-manage">
                <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','/?mod=admin&_index=_account_edit','<?php echo $item['admin_id'];?>','','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                <a title="删除" href="javascript:;" onclick="admin_del(this,'<?php echo $item['admin_id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
    /*管理员-增加*/
    function admin_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-删除*/
    function admin_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/?mod=admin&_action=ActionDelAdmin&id='+id,
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
    /*管理员-批量删除*/


    /*管理员-编辑*/
    function admin_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }




</script>
</body>
</html>