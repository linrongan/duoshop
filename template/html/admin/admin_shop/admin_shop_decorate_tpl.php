<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetHomeData();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>店铺装修</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/tool/upload/upload.css">
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    商城管理
    <span class="c-gray en">&gt;</span>
    官方商城装修
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

<div id="tab-system" class="HuiTab">
    <div class="tabBar cl">
        <span>首页导航</span>
        <span>新闻通知</span>
    </div>
    <div class="tabCon">
        <!--      导航      -->
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
                    <a class="btn btn-primary radius" onclick="banner_add('添加菜单','?mod=admin&v_mod=admin_shop&_index=_decorate_add&type=99')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加菜单</a>

        </div>
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">图片</th>
                <th width="100">标题</th>
                <th width="100">链接</th>
                <th width="150">排序</th>
                <th width="150">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data['nav'])
            {
                foreach($data['nav'] as $item)
                {
                    ?>
                    <tr class="text-c">
                        <td><img src="<?php echo $item['nav_img']; ?>" width="50" class="picture-thumb" alt=""></td>
                        <td><?php echo $item['nav_name']; ?></td>
                        <td><?php echo $item['nav_link']; ?></td>
                        <td><?php echo $item['nav_sort']; ?></td>
                        <td><?php echo $item['nav_show']==0?'显示':'不显示'; ?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="banner_edit('菜单编辑','?mod=admin&v_mod=admin_shop&_index=_decorate_edit&type=99',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,99)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
                        </td>
                    </tr>
                <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class="tabCon">
        <!--      新闻      -->
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
                <a class="btn btn-primary radius" onclick="banner_add('添加新闻','?mod=admin&v_mod=admin_shop&_index=_decorate_notice_add')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加新闻</a>
        </div>
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="100">标题</th>
                <th width="100">链接</th>
                <th width="100">发布时间</th>
                <th width="150">排序</th>
                <th width="150">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            $notice = $obj->GetHomeNotice();
            if($notice)
            {
                foreach($notice as $item)
                {
                    ?>
                    <tr class="text-c">
                        <td><?php echo $item['notice_title']; ?></td>
                        <td><?php echo $item['notice_link']; ?></td>
                        <td><?php echo $item['notice_addtime']; ?></td>
                        <td><?php echo $item['notice_sort']; ?></td>
                        <td><?php echo $item['notice_show']==0?'显示':'不显示'; ?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="banner_edit('编辑','?mod=admin&v_mod=admin_shop&_index=_decorate_notice_edit',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,98)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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


</div>

<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/tool/upload/upload.js"></script>
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
    function banner_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    /*图片-添加*/
    function banner_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*图片-删除*/
    function banner_del(obj,id,type){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_shop&_action=ActionDelHomeData',
                data:{id:id,type:type},
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
    function img_show(img){
        var index = layer.open({
            type: 2,
            title: '右侧关闭',
            content: img
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