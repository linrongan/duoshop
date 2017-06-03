<?php
$data = $obj->GetApplyList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>店铺申请</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 入驻申请 <span class="c-gray en">&gt;</span> 申请列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post" class="mb-20">
        <div> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
        <a class="btn btn-primary radius" onclick="store_add('添加店铺','?mod=admin&v_mod=apply&_index=_add')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加店铺</a>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover">
            <thead>
            <tr class="text-c">
                <th width="100">申请用户</th>
                <th width="80">店铺名称</th>
                <th width="80">真实姓名</th>
                <th width="100">联系电话</th>
                <th width="100">地址</th>
                <th width="150">描述</th>
                <th width="150">申请时间</th>
                <th width="60">状态</th>
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
                        <td><img width="50" src="<?php echo $item['headimgurl']; ?>" alt=""/><br><?php echo $item['nickname']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['phone']; ?></td>
                        <td><?php echo $item['address']; ?></td>
                        <td><?php echo utf_substr($item['miaoshu'],30); ?></td>
                        <td><?php echo $item['addtime']; ?></td>
                        <td class="td-status">
                            <?php
                            if($item['status']==0)
                            {
                                ?>
                                <span class="label label-default radius">未审核</span>
                                <?php
                            }elseif($item['status']==1){
                                ?>
                                <span class="label label-danger radius">不通过</span>
                                <?php
                            }else{
                                ?>
                                <span class="label label-success radius">审核通过</span>
                                <?php
                            }
                            ?>
                        </td>
                        <td class="td-manage">
                            <?php
                                if($item['status']!=2 && $item['shop_status']==0)
                                {
                                    ?>
                                    <a style="text-decoration:none" class="ml-5" onClick="apply_confirm(<?php echo $item['id']; ?>)" href="javascript:;" title="审核"><i class="Hui-iconfont">&#xe6df;</i></a>
                                    <?php
                                }else{
                                   ?>
                                    <span class="label label-success radius">运营中</span>
                                    <?php
                                }
                            ?>
<!--                            <a style="text-decoration:none" class="ml-5" onClick="apply_edit('入驻申请编辑','?mod=admin&v_mod=apply&_index=_edit',<?php /*echo $item['id']; */?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
-->                            <a style="text-decoration:none" class="ml-5" onClick="apply_del(this,<?php echo $item['id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
                            </a>
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
    function store_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*function apply_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }*/


    /*-删除*/
    function apply_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=apply&_action=ActionDelApply',
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
                }
            });
        });
    }







    function apply_confirm(id)
    {
        //审核询问
        layer.confirm('审核状态？', {
            btn: ['通过','不通过'] //按钮
        }, function()
        {
            $.ajax({
                type:'post',
                url:'/?mod=admin&v_mod=apply&_index=_list&_action=ActionConfirmApply',
                data:{id:id},
                dataType:'json',
                success:function (res)
                {
                    if(res.code==0)
                    {
                        location.href='/?mod=admin&v_mod=apply&_index=_list'
                    }else{
                        layer.msg(res.msg);
                    }
                },
                error:function ()
                {
                    
                }
            });
        }, function()
        {
            layer.prompt({title: '请输入不通过反馈原因', formType: 2}, function(text, index){
                //layer.close(index);
                //layer.msg(text);
                $.ajax({
                    type:'post',
                    url:'/?mod=admin&v_mod=apply&_index=_list&_action=ActionEditApply',
                    data:{id:id,text:text},
                    dataType:'json',
                    success:function (res)
                    {
                        if(res.code==0)
                        {
                            location.href='/?mod=admin&v_mod=apply&_index=_list'
                        }else{
                            layer.msg(res.msg);
                        }
                    },
                    error:function ()
                    {

                    }
                });
            });
        });
    }
</script>
</body>
</html>