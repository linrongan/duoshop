<?php
$data = $obj->GetGroupProduct();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>团购产品列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 团购产品管理 <span class="c-gray en">&gt;</span> 团购产品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" value="<?php if(isset($_REQUEST['product_name'])){echo $_REQUEST['product_name'];} ?>" placeholder="输入产品名/产品编号" id="" name="product_name">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="location.href='?mod=admin&v_mod=admin_product&_index=_list'" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加团购产品</a>
        </span> <span class="r">共有数据：<strong><?php echo $data['total']; ?></strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="50">商品编号</th>
                <th  width="150">商品名称</th>
                <th  width="100">商品图片</th>
                <th  width="50">原价</th>
                <th  width="50">售价</th>
                <th  width="50">团购价</th>
                <th  width="50">状态</th>
                <th  width="30">排序</th>
                <th  width="50">编辑</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($data['data'])){
                foreach($data['data'] as $item){
                    ?>
                    <tr class="text-c">
                        <td class="center">
                            <?php echo $item['product_id'] ?>
                        </td>
                        <td class="center">
                            <?php echo $item['product_name']; ?><br>
                        </td>
                        <td class="center">
                            <?php
                            if($item['product_img']){
                                ?>
                                <img width="50" src="<?php echo $item['product_img']; ?>" alt="">
                            <?php
                            }else
                            {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td class="center">
                            <?php echo $item['product_fake_price']; ?>
                        </td>

                        <td class="center">
                            <?php echo $item['product_price']; ?>
                        </td>
                        <td class="center">
                            <?php echo $item['group_price']; ?>
                        </td>

                        <td class="center">
                            <?php echo $item['group_status']==0?'团购中':'已结束'; ?>
                        </td>

                        <td class="center">
                            <?php echo $item['group_sort']; ?>
                        </td>

                        <td class="center">
                            <a style="text-decoration:none" class="ml-5"
                               onClick="product_edit('编辑团购信息','?mod=admin&v_mod=group_product&_index=_edit',<?php echo $item['product_id']; ?>)"
                               href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
                            </a>
                            <a style="text-decoration:none" onClick="product_cancel_tg(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="删除团购"><i class="Hui-iconfont">&#xe60b;</i></a>
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
        location.href='?mod=admin&v_mod=product&_index=_list';
    });
    <?php
    }
    ?>


    /*产品-编辑*/
    function product_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }

    /*取消团购*/
    function product_cancel_tg(obj,id){
        layer.confirm('确认要取消团购吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=group_product&_action=ActionCancelGroupProduct',
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