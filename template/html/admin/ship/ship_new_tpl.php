<?php
$data = $obj->GetOrderList();
//echo '<pre>';
//var_dump($data)
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>发货</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 物流管理
    <span class="c-gray en">&gt;</span> 发货 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <form action="" method="post">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" name="start_date" value="<?php echo isset($_REQUEST['start_date'])?$_REQUEST['start_date']:''; ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" name="end_date"  value="<?php echo isset($_REQUEST['end_date'])?$_REQUEST['end_date']:''; ?>" class="input-text Wdate" style="width:120px;">
            <input type="text" name="search"
                   value="<?php if(isset($_REQUEST['search'])){echo $_REQUEST['search'];} ?>" id=""
                   placeholder=" 订单号、用户昵称、收货人" style="width:250px" class="input-text">
            <button name="" id=""  class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜订单</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="select_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
        </span> <span class="r">共有数据：<?php echo count($data['data']);?> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="60">订单图片</th>
                <th width="180">订单号</th>
                <th width="180">用户信息</th>
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
                        <td><img width="50" src="<?php echo $item['order_img']; ?>" class="picture-thumb" alt=""></td>
                        <td><?php echo $item['orderid']; ?></td>
                        <td class="text-l">
                            <i class="Hui-iconfont">&#xe60d;</i><?php echo $item['ship_name']; ?><br>
                            <i class="Hui-iconfont">&#xe696;</i><?php echo $item['ship_phone']; ?><br>
                            <i class="Hui-iconfont">&#xe6c9;</i><?php echo $item['ship_province'].$item['ship_city'].$item['ship_area']; ?><br>
                            <i class="Hui-iconfont">&#xe6c9;</i><?php echo $item['ship_address']; ?>
                        </td>
                        <td><?php echo $item['pay_datetime']; ?></td>
                        <td class="td-status">
                            <span class="label badge-primary radius"><?php echo $Sys_Order_Status[$item['order_status']]; ?></span>
                        </td>
                        <td class="td-manage">
                            <a onclick="sel_logistics('<?php echo $item['logistics_number'] ?>')" class="btn btn-default radius">物流追踪</a>
                            <a style="text-decoration:none" class="ml-5" onClick="order_del(this,<?php echo $item['orderid']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
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

    //*-查看物流*/
    function search_logistics(title,url,w,h){
        layer_show(title,url,w,h);
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
                }
            });
        });
    }

    //查询物流
    function sel_logistics(number)
    {
        var index = layer.open({
            type: 2,
            title: '物流追踪',
            content: '/?mod=admin&v_mod=admin_logistics&_index=_select&logistics_number='+number
        });
        layer.full(index);
    }



    <?php
    if(!empty($data['param']) && empty($data['data']))
    {
    ?>
    layer.confirm('没有查出内容，是否初始化？',function(index)
    {
        location.href='?mod=admin&v_mod=ship&_index=_new';
    });
    <?php
    }
    ?>
</script>
</body>
</html>