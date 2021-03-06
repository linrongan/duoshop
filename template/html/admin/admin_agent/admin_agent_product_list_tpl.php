<?php


$data = $obj->GetProductList();
//var_dump($data);exit;
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" type="text/css" href="/template/source/admin/static/h-ui.admin/icheck/icheck.css" />
</head>
<body>
<div class="page-container">
    <form action="" method="post">
        <div class="text-l">
            <input type="text" class="input-text" style="width:250px" value="<?php if(isset($_REQUEST['product_name'])){echo $_REQUEST['product_name'];} ?>" placeholder="输入产品名/商户名搜索" id="" name="product_name">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont"></i></a>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="r">共有数据：<strong><?php echo $data['total']; ?></strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="40">ID</th>
                <th width="60">封面</th>
                <th width="80">名称</th>
                <th width="60">分类</th>
                <th width="40">单价</th>
                <th width="40">标价</th>
                <th width="40">店铺</th>
                <th width="40">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data['data'])
            {
                foreach($data['data'] as $item)
                {
                    ?>
                    <tr class="text-c va-m" onclick="product_add('添加到一件代发','?mod=admin&v_mod=admin_agent&_index=_product_add&id=<?php echo $item['product_id'];?>')">
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
                        <td>
                            <?php echo $item['store_name']; ?>
                        </td>
                        <td>
                            <i class="Hui-iconfont">&#xe600;</i>
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
        $page=new page_nav(array(
            "total"=>$data['total'],
            "page_size"=>$data['page_size'],
            "curpage"=>$data['curpage'],
            "extUrl"=>"",
            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['param']
        ));
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
        location.href='?mod=admin&v_mod=admin_active&_index=_product_add&id=<?php echo $_GET['id'];?>';
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





</script>
</body>
</html>