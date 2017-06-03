<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetProductList(1);
//var_dump($data);
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
                       type="text" placeholder="请输入产品名称搜索" id="product_name" name="product_name"
                       class="input-text ac_input" style="width:300px">
                <input value="<?php echo isset($_REQUEST['store_name'])?trim($_REQUEST['store_name']):""; ?>"
                       type="text" placeholder="请输入店铺名称搜索" id="store_name" name="store_name"
                       class="input-text ac_input" style="width:200px">
                <button type="submit" class="btn btn-success" id="search_button">搜索</button>
                <a href="?mod=admin&v_mod=admin_product&_index=_list" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>

    <table class="table table-border table-bordered table-bg table-hover">
        <thead>
        <tr>
            <th scope="col" colspan="9">下架商品列表</th>
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
    function product_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
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
                }
            });
        });
    }


</script>
</body>
</html>