<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetProductList();
if(isset($_GET['select']))
{
    $data['canshu'].='&select';
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>商品列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商品管理
    <span class="c-gray en">&gt;</span> 商品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

    <div class="codeView cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <div class="clearfix">
            <form method="post" action="">
                <input value="<?php echo isset($_REQUEST['product_name'])?trim($_REQUEST['product_name']):""; ?>"
                       type="text" placeholder="请输入产品名称/店铺名称/产品编号进行搜索" id="product_name" name="product_name"
                       class="input-text ac_input" style="width:350px">
                <input value="<?php echo isset($_REQUEST['category_name'])?trim($_REQUEST['category_name']):""; ?>"
                       type="text" placeholder="请输入产品分类进行搜索" id="category_name" name="category_name"
                       class="input-text ac_input" style="width:200px">
                <button type="submit" class="btn btn-success" id="search_button">搜索</button>
                <a href="?mod=admin&v_mod=admin_product&_index=_list" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>

    <table class="table table-border table-bordered table-bg table-hover">
        <thead>
        <tr>
            <th scope="col" colspan="9">商品列表</th>
        </tr>
        <tr class="text-c">
            <th>商品编号</th>
            <th>产品分类</th>
            <th  width="100">商品名称</th>
            <th>所属店铺</th>
            <th>商品图片</th>
            <th>原价/售价</th>
            <th>排序</th>
            <th>状态</th>
            <th>编辑</th>

        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c" style="background:<?php if(in_array($item['product_id'],$array)){echo 'darkorange';} ?>">
                    <td><?php echo $item['product_id'] ?></td>
                    <td><?php echo $item['category_name']; ?></td>
                    <td>
                        <?php echo $item['product_name']; ?>
                    </td>
                    <td>
                        <?php echo $item['store_name']; ?>
                    </td>
                    <td>
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
                    <td>
                        <del><?php echo $item['product_fake_price']; ?></del>
                        <?php echo $item['product_price']; ?>
                    </td>
                    <td>
                        <?php echo $item['product_sort']; ?>
                    </td>
                    <td>
                        <?php echo $item['product_status']==0?'上架':'下架'; ?>
                    </td>

                    <td class="td-manage">
                        <!--     秒杀      -->
                        <span class="product_sekill">
                            <?php
                            if($item['seckill_status']==0)
                            {
                                ?>
                                <a style="text-decoration:none" onClick="product_cancel_seckill(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="取消秒杀"><i class="Hui-iconfont">&#xe690;</i></a>
                            <?php
                            }else{
                                ?>
                                <a style="text-decoration:none" onClick="product_seckill('加入秒杀【<?php echo $item['product_name']; ?>】','?mod=admin&v_mod=admin_sekill&_index=_new','<?php echo $item['product_id'];?>')" href="javascript:;" title="加入秒杀"><i class="Hui-iconfont">&#xe690;</i></a>
                            <?php
                            }
                            ?>
                        </span>
                        <!--     团购    -->

                        <span class="group_status">
                        <?php
                        if($item['group_status']==0)
                        {
                            ?>
                            <a style="text-decoration:none" onClick="product_cancel_tg(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="取消团购"><i class="Hui-iconfont">&#xe603;</i></a>
                        <?php
                        }else{
                            ?>
                            <a style="text-decoration:none" onClick="product_tg('加入团购【<?php echo $item['product_name']; ?>】','?mod=admin&v_mod=group_product&_index=_new','<?php echo $item['product_id'];?>')" href="javascript:;" title="加入团购"><i class="Hui-iconfont">&#xe6de;</i></a>
                        <?php
                        }
                        ?>
                            </span>
                        <!--     精选    -->
                        <span class="show_status">
                        <?php
                        if($item['show_status']==0)
                        {
                            ?>
                            <a style="text-decoration:none" onClick="product_cancel_tj(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="取消推荐"><i class="Hui-iconfont">&#xe66d;</i></a>
                        <?php
                        }else{
                            ?>
                            <a style="text-decoration:none" onClick="product_tj(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="精品推荐"><i class="Hui-iconfont">&#xe697;</i></a>
                        <?php
                        }
                        ?>
                            </span>
                        <a title="编辑" href="javascript:;"
                           onclick="product_edit('编辑','?mod=admin&v_mod=admin_product&_index=_edit','<?php echo $item['product_id'];?>')"
                           class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="属性" href="javascript:;"
                           onclick="product_attr('属性','?mod=admin&v_mod=admin_product&_index=_attr','<?php echo $item['product_id'];?>','','500')"
                           class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe64b;</i>
                        </a>
                        <a title="删除" href="javascript:;"
                           onclick="product_del(this,'<?php echo $item['product_id'];?>')"
                           class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6e2;</i>
                        </a>
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
    <?php
    if(isset($_GET['select']))
    {
        ?>
        <div class="panel-footer" style="padding-bottom:50px; ">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <a href="javascript:;" id="add-group" class="btn btn-primary">加入团购产品</a>
                    <a href="/?mod=admin&v_mod=group_product&_index=_list" class="btn btn-default">返回</a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
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


    /*编辑*/
    /*产品-编辑*/
    function product_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    //属性
    function product_attr(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }

    /*删除*/
    function product_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_product&_index=_list&_action=ActionDelProduct&id='+id,
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
    /*精品推荐*/
    function product_tj(obj,id){
        layer.confirm('确认要推荐吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=admin_product&_action=ActionChangeProductShowStatus",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".show_status").prepend('<a style="text-decoration:none" onClick="product_tj(this,'+id+')" href="javascript:;" title="取消推荐"><i class="Hui-iconfont">&#xe6de;</i></a>');
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
    /*取消精品推荐*/
    function product_cancel_tj(obj,id){
        layer.confirm('确认取消推荐吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=admin_product&_action=ActionChangeProductShowStatus",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".show_status").prepend('<a style="text-decoration:none" onClick="product_cancel_tj(this,'+id+')" href="javascript:;" title="精品推荐"><i class="Hui-iconfont">&#xe603;</i></a>');
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

    /*产品-团购*/
    function product_tg(title,url,id){
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
                        $(obj).parents("tr").find(".show_status").prepend('<a style="text-decoration:none" onClick="product_tg(\'加入团购\',\'?mod=admin&v_mod=group_product&_index=_new\','+id+')" href="javascript:;" title="加入团购"><i class="Hui-iconfont">&#xe6de;</i></a>');
                        $(obj).remove();
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

    $("#add-group").click(function ()
    {
        var product_id = $("input[type=radio]:checked").val();
        if(product_id.length<=0 || product_id<=0)
        {
            layer.msg('请选择产品');
            return;
        }
        location.href='/?mod=admin&v_mod=group_product&_index=_new&product_id='+product_id;
    });

    /*产品-秒杀*/
    function product_seckill(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    /*取消产品秒杀*/
    function product_cancel_seckill(obj,id){
        layer.confirm('确认要取消秒杀吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_sekill&_action=ActionCancelProductSeckill',
                data:{'id':id},
                dataType: 'json',
                success: function(res)
                {
                    if (res.code==0)
                    {
                        $(obj).parents("tr").find(".product_sekill").prepend('<a style="text-decoration:none" onClick="product_tg(\'加入秒杀\',\'?mod=admin&v_mod=admin_sekill&_index=_new\','+id+')" href="javascript:;" title="加入秒杀"><i class="Hui-iconfont">&#xe690;</i></a>');
                        $(obj).remove();
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