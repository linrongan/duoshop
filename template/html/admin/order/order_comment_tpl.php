<?php
    $data = $obj->GetOrderComment();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>评论列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 交易管理 <span class="c-gray en">&gt;</span> 评价列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" name="start_date" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" name="end_date" class="input-text Wdate" style="width:120px;">
            <input type="text" name="search" id="" placeholder=" 订单号、产品名、用户" style="width:250px" class="input-text">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜评论</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
        </span> <span class="r">共有数据：<strong><?php echo $data['total']; ?></strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="80">产品图片</th>
                <th width="100">产品名</th>
                <th width="100">用户头像</th>
                <th width="150">用户名</th>
                <th width="150">评论内容</th>
                <th width="60">评论类型</th>
                <th width="60">评论时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if($data['data'])
                {
                    foreach($data['data'] as $item)
                    {
                        ?>
                        <tr class="text-c">
                            <td><input name="" type="checkbox" value=""></td>
                            <td><img src="<?php echo $item['product_img']; ?>" width="50" class="picture-thumb" alt=""></td>
                            <td><?php echo $item['product_name']; ?></td>
                            <td><img src="<?php echo $item['headimgurl']; ?>" width="50" class="avatar size-L radius" alt=""></td>
                            <td><?php echo $item['nickname']; ?></td>
                            <td class="text-l"><?php echo $item['comment']; ?></td>
                            <td class="td-status">
                                <span class="label label-success radius"><?php if($item['comment_level']==0){echo '好评';}elseif($item['comment_level']==1){echo '中评';}else{echo '差评';} ?></span>
                            </td>
                            <td><?php echo $item['comment_date']; ?></td>
                            <td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" onClick="comment_del(this,<?php echo $item['id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
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
    /*评论-删除*/
    function comment_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=order&_action=ActionDelComment',
                dataType: 'json',
                data:{id:id},
                success: function(data)
                {
                    if(data.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                    layer.msg(data.msg,{icon:data.code==0?6:5,time:1000});
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