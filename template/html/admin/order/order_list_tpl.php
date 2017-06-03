<?php
$data = $obj->GetOrderList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>订单列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 交易管理 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post">
        <div class="text-l"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" name="start_date" value="<?php echo isset($_REQUEST['start_date'])?$_REQUEST['start_date']:''; ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" name="end_date"  value="<?php echo isset($_REQUEST['end_date'])?$_REQUEST['end_date']:''; ?>" class="input-text Wdate" style="width:120px;">
            <input type="text" name="search" value="<?php if(isset($_REQUEST['search'])){echo $_REQUEST['search'];} ?>" id="" placeholder=" 订单号、用户昵称、收货人、订单金额" style="width:300px" class="input-text">
            <span class="select-box"  style="width:120px;">
                <select class="select" name="order_status">
                    <option value="">全部状态</option>
                    <?php
                    $option = '';
                        foreach($Sys_Order_Status as $key=>$v)
                        {
                            $option .= '<option value="'.$key.'">'.$v.'</option>';
                            ?>
                            <option <?php echo isset($_REQUEST['order_status']) && $_REQUEST['order_status']==$key?'selected':''; ?> value="<?php echo $key; ?>"><?php echo $v; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </span>
            <button name="" id=""  class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜订单</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="select_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" onclick="select_status()" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 更改状态</a>
        </span> <span class="r">共有数据：<?php echo count($data['data']);?> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="120">订单号</th>
                <th width="200">收货人明细</th>
                <th width="80">订单金额</th>
                <th width="120">订单时间</th>
                <th width="100">状态</th>
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
                            <td><input name="" type="checkbox" value="<?php echo $item['orderid']; ?>" class="select_id"></td>
                            <td><?php echo $item['orderid'].'_'.$item['id']; ?></td>
                            <td class="text-l">
                                <i class="Hui-iconfont">&#xe60d;</i><?php echo $item['ship_name']; ?><br>
                                <i class="Hui-iconfont">&#xe696;</i><?php echo $item['ship_phone']; ?><br>
                                <i class="Hui-iconfont">&#xe6c9;</i><?php echo $item['ship_province'].$item['ship_city'].$item['ship_area']; ?><br>
                                <i class="Hui-iconfont">&#xe6c9;</i><?php echo $item['ship_address']; ?>
                            </td>
                            <td class="text-c"><?php echo $item['total_money']; ?></td>
                            <td><?php echo $item['addtime']; ?></td>
                            <td class="td-status">
                                <span class="label badge-primary radius"><?php echo $Sys_Order_Status[$item['order_status']]; ?></span>
                            </td>
                            <td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" onClick="order_edit('订单编辑','?mod=admin&v_mod=order&_index=_edit',<?php echo $item['orderid']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe627;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="order_del(this,<?php echo $item['orderid']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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

    /*图片-查看*/
    function order_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&orderid='+id
        });
        layer.full(index);
    }


    /*-删除*/
    function order_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=order&_action=ActionDelOrder',
                data:{'orderid':id},
                dataType: 'json',
                success: function(data)
                {
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    function select_del()
    {
        if(!$('.select_id').is(":checked"))
        {
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
                url: '?mod=admin&v_mod=order&_action=ActionMoreDelOrder',
                data:{orderid:select_id},
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


    function select_status()
    {
        if(!$('.select_id').is(":checked"))
        {
            return false;
        }
        var open = '';
        open+= '<div class="row cl">';
        open+=' <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>订单状态：</label>';
        open+='<div class="formControls col-xs-6 col-sm-6"> <span class="select-box">';
        open+='<select name="articlecolumn" class="select">';
        open+='<option value="">请选择更改的状态</option>';
        open+='<?php echo $option; ?>';
        open+='</select>';
        open+='</span> ';
        open+='<button onclick="save_order(this)" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 更改</button>';
        open+='</div></div>';
        layer.open({
            type: 1,
            shadeClose: true,
            skin: 'layui-layer-rim', //加上边框
            area: ['500px', '360px'], //宽高
            content:open
        });
    }

    function save_order(obj)
    {
        var order_status = $(obj).prev().children().val();
        if(order_status=='')
        {
            layer.msg('请选择订单状态',{icon:5,time:1000});
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
        layer.confirm('确定更改选中订单的状态？',function(index)
        {
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=order&_action=ActionMoreChangeOrderStatus',
                data:{orderid:select_id,order_status:order_status},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==0?6:5,time:1000});
                    if(data.code==0)
                    {
                        for(var i=0;i<select_no.length;i++)
                        {
                            $("#tbody").children().eq(i).find('.td-status').empty();
                            $("#tbody").children().eq(i).find('.td-status').append('<span class="label badge-primary radius">'+data.status+'</span>');
                        }
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }


    <?php
    if(!empty($data['param']) && empty($data['data']))
    {
    ?>
    layer.confirm('没有查出内容，是否初始化？',function(index)
    {
        location.href='?mod=admin&v_mod=user&_index=_list';
    });
    <?php
    }
    ?>
</script>
</body>
</html>