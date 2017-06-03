<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(!isset($_GET['id']))
{
    redirect(NOFOUND);
}
$data = $obj->GetActiveProduct();
//echo '<pre>';
//var_dump($data);
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="product_add('添加主题产品','?mod=admin&v_mod=admin_active&_index=_product_add','<?php echo $_GET['id'];?>')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加主题产品</a>
    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr>
                <th scope="col" colspan="4"><?php echo $data['category']['c_name'];?></th>
            </tr>
            <tr class="text-c">
                <th width="50">产品名字</th>
                <th width="80">产品图片</th>
                <th width="80">产品售价</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if(!empty($data['data']))
            {
                foreach($data['data'] as $item)
                {
                    ?>
                    <tr class="text-c">
                        <td><?php echo $item['product_name'];?></td>
                        <td><img width="50px" src="<?php echo $item['product_img'];?>" alt=""/></td>
                        <td><?php echo $item['product_price'];?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="product_edit('主题产品编辑','?mod=admin&v_mod=admin_active&_index=_product_edit',<?php echo $item['product_id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="product_del(this,<?php echo $item['product_id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].'&id='.$_GET['id'].$data['canshu']));
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
    function product_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    /*分类-添加*/
    function product_add(title,url,id){
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

    /*分类-删除*/
    function product_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_active&_action=ActionDelActiveProduct',
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