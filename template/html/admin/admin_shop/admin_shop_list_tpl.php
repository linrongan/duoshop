<?php
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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商铺管理
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
            <th>店铺名称</th>
            <th>店长</th>
            <th>店铺logo</th>
            <th>模板</th>
            <th>状态</th>
            <th>店铺链接</th>
            <th>操作</th>
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
                    <td><?php echo $item['template_name'];?></td>
                    <td>
                        <?php
                            if($item['store_status']==0){
                                echo "未开通";
                            }elseif($item['store_status']==1){
                                echo "准备开通";
                            }elseif($item['store_status']==2){
                                echo "开通中";
                            }else{
                                echo "已开通";
                            }
                        ?>
                    </td>
                    <td width="130"><?php echo $item['store_url'];?></td>
                    <td class="td-manage">
                        <span class="shop_choice">
                            <?php
                            if($item['show_status']==0)
                            {
                                ?>
                                <a style="text-decoration:none" onClick="shop_cancel_choice(this,<?php echo $item['store_id']; ?>)" href="javascript:;" title="精选店铺推荐"><i class="Hui-iconfont">&#xe631;</i></a>
                            <?php
                            }else{
                                ?>
                                <a style="text-decoration:none" onClick="shop_choice(this,<?php echo $item['store_id']; ?>)" href="javascript:;" title="精选店铺推荐"><i class="Hui-iconfont">&#xe6e1;</i></a>
                            <?php
                            }
                            ?>
                        </span>
                        <a title="设置实体店" href="javascript:;" onclick="shop_edit('实体店设置','?mod=admin&v_mod=admin_shop&_index=_physical','<?php echo $item['store_id'];?>','','500')" class="ml-5" style="text-decoration:none;<?php echo ($item['physical']>0)?"color:blue":"" ?>"><i class="Hui-iconfont">&#xe66a;</i></a>
                        <a title="编辑" href="javascript:;" onclick="shop_edit('店铺编辑','?mod=admin&v_mod=admin_shop&_index=_edit','<?php echo $item['store_id'];?>','','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
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


    /*店铺-精选*/
    function shop_choice(obj,id){
        var title = '店铺精选';
        var url = '?mod=admin&v_mod=admin_shop&_index=_choice&id='+id;
        layer_show(title,url);
    }
    /*取消精选推荐*/
    function shop_cancel_choice(obj,id){
        layer.confirm('确认要取消精选推荐吗？',function(index)
        {
            $.ajax({
                type:"post",
                url:"?mod=admin&v_mod=admin_shop&_action=ActionCancelChoice",
                data:{id:id},
                dataType:"json",
                success:function (res)
                {
                    if(res.code==0)
                    {
                        $(obj).parents("tr").find(".shop_choice").prepend('<a style="text-decoration:none" onClick="shop_choice(this,'+id+')" href="javascript:;" title="精选推荐"><i class="Hui-iconfont">&#xe6e1;</i></a>');
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
</script>
</body>
</html>