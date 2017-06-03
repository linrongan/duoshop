<?php
$data = $obj->getBargainProduct();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>秒杀产品列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 砍价商品 <span class="c-gray en">&gt;</span> 砍价商品列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <form action="" method="post">
        <div class="text-l">
            <input type="text" class="input-text" style="width:250px" value="<?php if(isset($_REQUEST['product_name'])){echo $_REQUEST['product_name'];} ?>" placeholder="输入产品名/产品编号" id="" name="product_name">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="product_add('添加砍价商品','?mod=admin&v_mod=admin_bargain&_index=_product_list')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加砍价产品</a>
        </span> <span class="r">共有数据：<strong><?php echo $data['total']; ?></strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="40">商品编号</th>
                <th width="150">商品名称</th>
                <th width="100">商品图片</th>
                <th width="50">售价</th>
                <th width="50">最低砍价</th>
                <th width="50">排序</th>
                <th width="100">起止时间</th>
                <th width="50">参与人数</th>
                <th width="50">一刀范围</th>
                <th width="50">状态</th>
                <th width="50">编辑</th>
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
                            <?php echo $item['product_price']; ?>
                        </td>
                        <td class="center">
                            <?php echo $item['min_price']; ?>
                        </td>
                        <td class="center">
                            <?php echo $item['sort']; ?>
                        </td>
                        <td class="center">
                            <?php echo $item['start_time'].'<br>-<br>'.$item['end_time']; ?>
                        </td>
                        <td class="center">
                            <?php echo $item['join_count']; ?>
                        </td>
                        <td class="center">
                            0-<?php echo $item['float_price']; ?>
                        </td>
                        <td class="center">
                            <?php
                                if($item['start_time']<=date('Y-m-d H:i:s') && $item['end_time']>=date('Y-m-d H:i:s')){
                                    echo '<span class="label label-success radius">砍价中</span>';
                                }elseif($item['start_time']>date('Y-m-d H:i:s')){
                                    echo '<span class="label label-default radius">未开始</span>';
                                }elseif($item['end_time']<date('Y-m-d H:i:s')){
                                    echo '<span class="label label-danger radius">已结束</span>';
                                }
                            ?>
                        </td>
                        <td class="center">
                            <a style="text-decoration:none" class="ml-5"
                               onclick="bargain_user('【<?php echo $item['product_name']; ?>】的参与者','?mod=admin&v_mod=admin_bargain&_index=_user_list',<?php echo $item['id']; ?>)"
                               href="javascript:;" title="查看参与者"><i class="Hui-iconfont">&#xe62b;</i></a>
                            <a style="text-decoration:none" class="ml-5"
                               onClick="product_edit('编辑砍价【<?php echo $item['product_name']; ?>】','?mod=admin&v_mod=admin_bargain&_index=_product_edit',<?php echo $item['id']; ?>)"
                               href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
                            </a>
                            <a style="text-decoration:none" onClick="product_del(this,<?php echo $item['id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe60b;</i></a>
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
    if(!empty($data['canshu']) && empty($data['data']))
    {
    ?>
    layer.confirm('没有查出内容，是否初始化？',function(index)
    {
        location.href='?mod=admin&v_mod=admin_bargain&_index=product_add';
    });
    <?php
    }
    ?>

    function product_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url,
            end:function(){
                window.location.reload();
            }
        });
        layer.full(index);
    }
    //参与用户
    function bargain_user(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id,
            end:function(){
                window.location.reload();
            }
        });
        layer.full(index);
    }

    /*秒杀-编辑*/
    function product_edit(title,url,id){
        var index = layer.open({
            type: 2,
            area: '500px',
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }

    function product_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_bargain&_action=ActionDelBargainProduct',
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