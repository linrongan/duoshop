<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getNoticeRole();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>系统日志</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 信息中心
    <span class="c-gray en">&gt;</span> 消息分类
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">


    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <span class="l">
            <a href="javascript:;" onclick="notice_add('添加通知消息分类','?mod=admin&v_mod=admin_notice&_index=_role_add')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加通知消息分类
            </a>
        </span>
    </div>

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">消息分类</th>
        </tr>
        <tr class="text-c">
            <th width="80">名称</th>
            <th width="80">图标</th>
            <th width="80">排序</th>
            <th width="80">类型</th>
            <th width="80">状态</th>
            <th width="80">提示角色</th>
            <th width="80">编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data)){
            foreach($data as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['name'];?></td>
                    <td><img width="50" src="<?php echo $item['icon'];?>" alt=""/></td>
                    <td><?php echo $item['ry_sort'];?></td>
                    <td><?php echo $item['alert_type']==0?'图文':'消息';?></td>
                    <td><?php echo $item['alert_type']==0?'<span class="label label-success radius">正常</span>':'<span class="label label-danger radius">暂停使用</span>';?></td>
                    <td>
                        <?php
                            if($item['role_id']==1){
                                echo '管理员';
                            }elseif($item['role_id']==2){
                                echo '普通商户';
                            }elseif($item['role_id']==3){
                                echo '普通会员';
                            }else{
                                echo '所以人';
                            }
                        ?>
                    </td>
                    <td>
                        <a title="编辑" href="javascript:;" onclick="notice_edit('编辑','?mod=admin&v_mod=admin_notice&_index=_role_edit','<?php echo $item['alert_role_id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="notice_del(this,'<?php echo $item['alert_role_id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
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

    /*增加*/
    function notice_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*删除*/
    function notice_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_notice&_action=ActionDelNoticeRole&id='+id,
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
    function notice_edit(title,url,id){
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