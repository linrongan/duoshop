<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetPointCategory();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>积分礼品</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    积分管理
    <span class="c-gray en">&gt;</span>
    礼品分类
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="gift_add('添加礼品','?mod=admin&v_mod=admin_point&_index=_category_add')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加礼品分类</a>
    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th>礼品类别</th>
                <th>图片</th>
                <th>排序</th>
                <th>编辑</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data)
            {
                foreach($data as $item)
                {
                    ?>
                    <tr class="text-c">
                        <td><?php echo $item['category_name']; ?></td>
                        <td><img src="<?php echo $item['category_img']; ?>" alt="" width="50"/></td>
                        <td><?php echo $item['ry_order']; ?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="gift_edit('礼品分类编辑','?mod=admin&v_mod=admin_point&_index=_category_edit',<?php echo $item['category_id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="gift_del(this,<?php echo $item['category_id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
                        </td>
                    </tr>
                <?php
                }
            }
            ?>
            </tbody>
        </table>
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
    });


    //
    function gift_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    /*-添加*/
    function gift_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*-删除*/
    function gift_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_point&_action=ActionDelCategory',
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