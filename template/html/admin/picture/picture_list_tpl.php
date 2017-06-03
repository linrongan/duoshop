<?php
    $data = $obj->GetBannerList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>图片列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 图片管理 <span class="c-gray en">&gt;</span> 图片列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="select_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" onclick="picture_add('添加图片','?mod=admin&v_mod=picture&_index=_add')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加图片</a>
            <a class="btn btn-primary radius" onclick="picture_show()" href="javascript:;"><i class="Hui-iconfont">&#xe613;</i> 预览</a>
        </span>
        <span class="r">共有数据：<strong>54</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="80">图片</th>
                <th width="100">标题</th>
                <th width="100">链接</th>
                <th width="150">排序</th>
                <th width="150">更新时间</th>
                <th width="60">显示状态</th>
                <th width="100">操作</th>
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
                            <td><input class="select_id" type="checkbox" value="<?php echo $item['id']; ?>"></td>
                            <td><img src="<?php echo $item['picture_path']; ?>" width="50" class="picture-thumb" alt=""></td>
                            <td><?php echo $item['picture_title']; ?></td>
                            <td><?php echo $item['picture_url']; ?></td>
                            <td><?php echo $item['picture_sort']; ?></td>
                            <td><?php echo $item['picture_last_u']; ?></td>
                            <td class="td-status">
                                <?php
                                    if($item['picture_show']==0)
                                    {
                                        ?>
                                        <span class="label label-success radius">已显示</span>
                                        <?php
                                    }else{
                                        ?>
                                        <span class="label label-danger radius">未显示</span>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="td-manage">
                                <?php
                                    if($item['picture_show']==0)
                                    {
                                    ?>
                                        <a style="text-decoration:none" onClick="picture_stop(this,<?php echo $item['id']; ?>)" href="javascript:;" title="不显示"><i class="Hui-iconfont">&#xe6de;</i></a>
                                        <?php
                                    }else{
                                        ?>
                                        <a style="text-decoration:none" onClick="picture_start(this,<?php echo $item['id']; ?>)" href="javascript:;" title="要显示"><i class="Hui-iconfont">&#xe603;</i></a>
                                        <?php
                                    }
                                ?>
                                <a style="text-decoration:none" class="ml-5" onClick="picture_edit('轮播图编辑','?mod=admin&v_mod=picture&_index=_edit',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="picture_del(this,<?php echo $item['id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
</div>

<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $('.table-sort').dataTable({
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "aoColumnDefs": [
            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
            {"orderable":false,"aTargets":[0,1,7]}// 制定列不参与排序
        ]
    });

    /*图片-添加*/
    function picture_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    function picture_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }

    /*图片-下架*/
    function picture_stop(obj,id){
        layer.confirm('确定不再显示？',function(index)
        {
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=picture&_action=ActionChangeShowStatus',
                data:{id:id},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==1?5:6,time:1000});
                    if(data.code==0)
                    {
                        $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_start(this,'+id+')" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未显示</span>');
                        $(obj).remove();
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*图片-发布*/
    function picture_start(obj,id)
    {
        layer.confirm('确定要显示？',function(index)
        {
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=picture&_action=ActionChangeShowStatus',
                data:{id:id},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==1?5:6,time:1000});
                    if(data.code==0)
                    {
                        $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_stop(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已显示</span>');
                        $(obj).remove();
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }


    /*图片-删除*/
    function picture_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=picture&_action=ActionDelBanner',
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
                },
            });
        });
    }


    function picture_show()
    {
        $.getJSON('?mod=admin&v_mod=picture&_action=GetBannerList&v='+new Date, function(json){
            layer.photos({
                photos: json //格式见API文档手册页
                ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
            });
        });
    }




    function select_del()
    {
        if(!$('.select_id').is(":checked"))
        {
            layer.msg('请在需要删除的列打钩',{icon:5,time:1000});
            return false;
        }
        var select_id = [];
        var select_no = [];
        $(".select_id").each(function ()
        {
            if($(this).is(':checked'))
            {
                select_id.push($(this).val());
                select_no.push($(this).parents('tr').index());
            }
        });
        if(select_id.length<=0)
        {
            return false;
        }
        layer.confirm('确认要批量删除吗？',function(index)
        {
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=picture&_action=ActionMoreDelBanner',
                data:{id:select_id},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==0?6:5,time:1000});
                    if(data.code==0)
                    {
                        for(var i=select_no.length;i>=0;i--)
                        {
                            $("#tbody").children().eq(select_no[i]).remove();
                        }
                        $('.select_id').attr('checked',false);
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }
</script>
</body>
</html>