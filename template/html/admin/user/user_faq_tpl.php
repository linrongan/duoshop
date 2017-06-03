<?php
$data = $obj->UserFeedbackMessage();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>咨询回复</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post">
    <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="反馈信息" id="" name="message">
        <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
    </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="select_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
        </span> <span class="r">共有数据：<strong><?php echo $data['total']; ?></strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">头像</th>
                <th width="100">昵称</th>
                <th width="40">联系方式</th>
                <th width="150">反馈内容</th>
                <th width="130">添加时间</th>
                <th width="70">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
                if($data['data'])
                {
                    foreach($data['data'] as $item)
                    {
                        ?>
                        <tr class="text-c">
                            <td><input type="checkbox" class="select_id" value="<?php echo $item['id']; ?>" name=""></td>
                            <td><img width="50" class="avatar size-L radius" src="<?php echo $item['headimgurl']; ?>"></td>
                            <td><?php echo $item['nickname']; ?></td>
                            <td><?php echo $item['contact']; ?></td>
                            <td><?php echo $item['message']; ?></td>
                            <td><?php echo $item['addtime']; ?></td>
                            <td class="td-status">
                                <?php
                                    if($item['back_status']==0)
                                    {
                                        ?>
                                        <span class="label label-danger radius">未回复</span>
                                        <?php
                                    }else{
                                        ?>
                                        <span class="label label-success radius">已回复</span>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="td-manage">
                                <span class="back_status">
                                <?php
                                if($item['back_status']==0)
                                {
                                    ?>
                                    <a style="text-decoration:none" onClick="back_status(this,<?php echo $item['id']; ?>)" href="javascript:;" title="标记为已回复"><i class="Hui-iconfont">&#xe647;</i></a>
                                <?php
                                }
                                ?>
                            </span>
                                <a title="删除" href="javascript:;" onclick="feedback_del(this,<?php echo $item['id']; ?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
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
            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['param']));
        echo $page->page_nav();
        ?>
    </div>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    <?php
    if(!empty($data['param']) && empty($data['data']))
    {
    ?>
    layer.confirm('没有查出内容，是否初始化？',function(index)
    {
        location.href='?mod=admin&v_mod=user&_index=_faq';
    });
    <?php
    }
    ?>

    /*删除*/
    function feedback_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=user&_action=ActionDelFeedback',
                dataType: 'json',
                data:{id:id},
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==0?6:5,time:1000});
                    if(data.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }

    /*标记为已回复*/
    function back_status(obj,id){
        layer.confirm('确认要标记这条记录为已回复吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=user&_action=ActionChangeFaqStatus",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已回复</span>');
                        $(obj).remove();
                    }
                    layer.msg(res.msg,{icon: res.code==0?6:5,time:1000});
                },
                error:function ()
                {
                    alert('error');
                }
            });
        });
    }


    function select_del()
    {
        if(!$('.select_id').is(":checked"))
        {
            layer.msg('请勾上删除的元素',{icon:5,time:1000});
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
                url: '?mod=admin&v_mod=user&_action=ActionMoreDelFeedback',
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