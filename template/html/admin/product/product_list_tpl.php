<?php
$data = $obj->GetProductList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" type="text/css" href="/template/source/admin/static/h-ui.admin/icheck/icheck.css" />
    <title>产品列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post">

        <div class="radio-box skin-minimal" style="float: left;line-height: 32px;">
            <div class="check-box">
                <input <?php if(isset($_REQUEST['is_home'])&&$_REQUEST['is_home']==1){echo 'checked';} ?> type="checkbox" id="checkbox-1" name="is_home" value="1">
                <label for="checkbox-1">首页商品</label>
            </div>
        </div>
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px"
                   value="<?php if(isset($_REQUEST['product_name'])){echo $_REQUEST['product_name'];} ?>"
                   placeholder="输入产品名" id="" name="product_name">
            <input value="<?php echo isset($_REQUEST['category_name'])?trim($_REQUEST['category_name']):""; ?>"
                   type="text" placeholder="分类名称" id="category_name" name="category_name"
                   class="input-text ac_input" style="width:150px">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="select_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a href="javascript:;" onclick="product_add('添加产品','?mod=admin&v_mod=product&_index=_new')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加产品</a>
        </span> <span class="r">共有数据：<strong><?php echo $data['total']; ?></strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="40">ID</th>
                <th width="60">封面</th>
                <th width="80">名称</th>
                <th width="60">分类</th>
                <th width="40">单价</th>
                <th width="40">标价</th>
                <th width="40">销量</th>
                <th width="40">库存</th>
                <th width="40">属性</th>
                <td width="30">状态</td>
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
                    <tr class="text-c va-m">
                        <td><input class="select_id" type="checkbox" value="<?php echo $item['product_id']; ?>"></td>
                        <td><?php echo $item['product_id']; ?></td>
                        <td><img width="60" class="product-thumb" src="<?php echo $item['product_img']; ?>"></td>
                        <td>
                            <?php
                                if(isset($_REQUEST['product_name']) && !empty($_REQUEST['product_name']))
                                {
                                    echo str_replace($_REQUEST['product_name'],'<span style="color: red;">'.$_REQUEST['product_name'].'</span>',$item['product_name']);
                                }else{
                                    echo $item['product_name'];
                                }
                            ?>
                        </td>
                        <td><?php echo $item['category_name']; ?></td>
                        <td>￥<?php echo $item['product_price']; ?></td>
                        <td>￥<?php echo $item['product_fake_price']; ?></td>
                        <td><?php echo $item['product_sold']; ?></td>
                        <td><?php echo $item['product_stock']; ?></td>
                        <td>
                            <span>无</span>
                        </td>
                        <td class="td-status">
                            <?php if($item['product_status']==0){
                                ?>
                                <span class="label label-success radius">已上架</span>
                                <?php
                            }else{
                                ?>
                                <span class="label label-defaunt radius">已下架</span>
                                <?php
                            } ?>
                        </td>
                        <td class="td-manage">
                            <?php
                            if($item['product_status']==0)
                            {
                                ?>
                                <a style="text-decoration:none" onClick="product_stop(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>
                                <?php
                            }else{
                                ?>
                                <a style="text-decoration:none" onClick="product_start(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>
                                <?php
                            }
                            ?>

                             <span class="is_home">
                                <?php
                                if($item['is_home']==0)
                                {
                                    ?>
                                    <a style="text-decoration:none" onClick="product_home(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="推荐到首页"><i class="Hui-iconfont">&#xe6e1;</i></a>
                                <?php
                                }else{
                                    ?>
                                    <a style="text-decoration:none" onClick="product_cancel_home(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="取消首页推荐"><i class="Hui-iconfont">&#xe631;</i></a>
                                <?php
                                }
                                ?>
                            </span>
                            <span class="product_choice">
                                <?php
                                if($item['choice_status']==0)
                                {
                                    ?>
                                    <a style="text-decoration:none" onClick="product_cancel_choice(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="取消精选"><i class="Hui-iconfont">&#xe630;</i></a>
                                <?php
                                }else{
                                    ?>
                                    <a style="text-decoration:none" onClick="product_choice(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="精选推荐"><i class="Hui-iconfont">&#xe69e;</i></a>
                                <?php
                                }
                                ?>
                            </span>
                            <a style="text-decoration:none" class="ml-5" onClick="product_edit('产品编辑','?mod=admin&v_mod=product&_index=_edit',<?php echo $item['product_id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="product_add_attr('添加属性页面','?mod=admin&v_mod=product&_index=_attr',<?php echo $item['product_id']; ?>)" href="javascript:;" title="添加属性"><i class="Hui-iconfont">&#xe600;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="product_del(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
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
<link rel="stylesheet" type="text/css" href="/template/source/admin/static/h-ui.admin/icheck/jquery.icheck.min.js" />
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
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        })
    });
    //*产品-添加*/
    function product_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }


    /*产品-查看*/
    function product_show(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*产品-下架*/
    function product_stop(obj,id){
        layer.confirm('确认要下架吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=product&_action=ActionChangeproductStatus",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_start(this,'+id+')" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
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

    /*产品-发布*/
    function product_start(obj,id){
        layer.confirm('确认要发布吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=product&_action=ActionChangeproductStatus",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_stop(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
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



    /*产品-编辑*/
    function product_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }

    /*产品-删除*/
    function product_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=product&_action=ActionDelProduct',
                data:{id:id},
                dataType: 'json',
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
                url: '?mod=admin&v_mod=product&_action=ActionMoreDelProduct',
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

    /*首页-优选*/
    function product_home(obj,id){
        layer.confirm('确认要推荐到首页吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=product&_action=ActionChangeIsHome",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".is_home").prepend('<a style="text-decoration:none" onClick="product_cancel_home(this,'+id+')" href="javascript:;" title="取消首页推荐"><i class="Hui-iconfont">&#xe6e1;</i></a>');
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
    /*取消首页推荐*/
    function product_cancel_home(obj,id){
        layer.confirm('确认要取消首页推荐吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=product&_action=ActionChangeIsHome",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".is_home").prepend('<a style="text-decoration:none" onClick="product_home(this,'+id+')" href="javascript:;" title="推荐到首页"><i class="Hui-iconfont">&#xe6e1;</i></a>');
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
    /*产品-精选*/
    function product_choice(obj,id){
        var title = '产品精选精选';
        var url = '?mod=admin&v_mod=product&_index=_choice&id='+id;
        layer_show(title,url,'500','300');
    }
    /*取消精选推荐*/
    function product_cancel_choice(obj,id){
        layer.confirm('确认要取消精选推荐吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=product&_action=ActionCancelProductChoice",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".product_choice").prepend('<a style="text-decoration:none" onClick="product_choice(this,'+id+')" href="javascript:;" title="精选推荐"><i class="Hui-iconfont">&#xe69e;</i></a>');
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
//添加属性
    function product_add_attr(title,url,id){
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