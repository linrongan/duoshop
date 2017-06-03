<?php
//店铺折扣卷余额充值页面
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getAllShop();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>商铺列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 营销管理
    <span class="c-gray en">&gt;</span> 商铺列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

    <form action="" method="post" class="mb-20">
        <div>
            <input type="text" class="input-text" value="<?php if(isset($_REQUEST['title'])){echo $_REQUEST['title'];} ?>"
                   style="width:250px" placeholder="输入店铺名称搜索" id="" name="title">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">店铺列表</th>
        </tr>
        <tr class="text-c">
            <th width="100">店铺名称</th>
            <th width="100">店长</th>
            <th width="100">店铺logo</th>
            <th width="100">折扣卷余额</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['store_name'];?></td>
                    <td><?php echo $item['admin_name'];?></td>
                    <td>
                        <?php
                        if($item['store_logo']){
                            echo "<img width='50' src ='".$item['store_logo']."'/>";
                        }
                        ?>
                    </td>
                    <td><?php echo $item['gift_balance'];?></td>
                    <td class="td-manage">
                        <a class="btn btn-success radius"
                           onclick="shop_edit('充值折扣金额','?mod=admin&v_mod=admin_shop&_index=_balance_edit','<?php echo $item['store_id'];?>','','500')"
                           href="javascript:;" title="充值"><i class="Hui-iconfont"></i>充值</a>
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

    //$("#txt_spCodes").val(spCodesTemp);
    /*编辑*/
    function shop_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }


</script>
</body>
</html>