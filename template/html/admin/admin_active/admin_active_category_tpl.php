<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetActiveCategory();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="category_add('添加子分类','?mod=admin&v_mod=admin_active&_index=_category_add','<?php echo $_GET['id'];?>')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加子分类</a>
    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">上级</th>
                <th width="80">类名</th>
                <th width="80">图片</th>
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
                        <td><?php echo $item['picture_title'];?></td>
                        <td><?php echo $item['c_name'];?></td>
                        <td><img width="100px" src="<?php echo $item['c_img'];?>" alt=""/></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="active_product('产品','?mod=admin&v_mod=admin_active&_index=_product',<?php echo $item['id']; ?>)" href="javascript:;" title="查看产品"><i class="Hui-iconfont">&#xe670;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="category_edit('逛商城广告图编辑','?mod=admin&v_mod=admin_active&_index=_category_edit',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="category_del(this,<?php echo $item['id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['canshu']));
        echo $page->page_nav();
        ?>
    </div>
</div>
<div id="qrcode_img" style="display: none;text-align: center"></div>


<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click","0");
    });


    //首页banner
    function category_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    /*分类-添加*/
    function category_add(title,url,pid){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&pid='+pid
        });
        layer.full(index);
    }

    /*分类-删除*/
    function category_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_active&_action=ActionDelActiveCategory',
                data:{id:id},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==1?5:6,time:1000});
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
    //产品页面
    function active_product(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }


    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    <?php
    }
    ?>
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>