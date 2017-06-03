<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetShopTemplate();
$template = $obj->GetStoreTemplate();
$store_template = array();
$store_template_id = array();
$use_template_id = 0;
if($template)
{
    foreach($template as $item)
    {
        $store_template_id[] = $item['template_id'];
        if($item['template_use'])
        {
            $use_template_id = $item['template_id'];
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>品牌管理</title>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <style>
        .borcolor{background: #EEE8CD};
    </style>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span> 商城管理
    <span class="c-gray en">&gt;</span> 店铺模板
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="70">封面</th>
                <th width="70">模板</th>
                <th width="80">价格</th>
                <th width="120">描述</th>
                <th width="120">添加时间</th>
                <th width="100">状态</th>
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
                        <tr class="text-c  <?php echo !in_array($item['template_id'],$store_template_id)?'borcolor':''; ?>">
                            <td><img src="<?php echo $item['template_cover']; ?>" height="50" class="radius" alt=""></td>
                            <td><?php echo $item['template_name']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['template_describe']; ?></td>
                            <td><?php echo $item['template_addtime']; ?></td>
                            <td class="td-status">
                                <?php
                                $is_can_use = true;
                                    if(in_array($item['template_id'],$store_template_id))
                                    {
                                        if($item['template_id']!=$use_template_id)
                                        {
                                            ?>
                                            <span class="label label-success radius">未启用</span>
                                            <?php
                                        }else{
                                            ?>
                                            <span class="label label-success radius">使用中</span>
                                            <?php
                                        }
                                    }else{
                                        $is_can_use = false;
                                        ?>
                                        <span class="label label-warning radius">未授权</span>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="td-manage">
                                <?php
                                if($is_can_use==false)
                                {
                                    ?>
                                    <a style="text-decoration:none" class="ml-5" onClick="template_pay()" href="javascript:;" title="购买"><i class="Hui-iconfont">&#xe719;</i></a>
                                    <?php
                                }else{
                                    if($item['template_id']!=$use_template_id)
                                    {
                                        ?>
                                        <a style="text-decoration:none"   onclick="template_start(this,<?php echo $item['template_id']; ?>)" href="javascript:;" title="未使用"><i class="Hui-iconfont">&#xe688;</i></a>
                                        <?php
                                    }else{
                                        ?>
                                        <a style="text-decoration:none" class="use-ing" onClick="layer.msg('正在使用中...',{icon:6,time:1000})" href="javascript:;" title="使用中"><i class="Hui-iconfont">&#xe656;</i></a>
                                        <?php
                                    }
                                }
                                ?>
                                <a style="text-decoration:none" class="ml-5" onClick="template_show(<?php echo $item['template_id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe725;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
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
            "canshu"=>str_replace("/?","&",_URL_).$data['param']));
        echo $page->page_nav();
        ?>
    </div>
</div>

<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    function show_template()
    {

    }

    function template_start(obj,id)
    {
        layer.confirm('确定要启用？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=shop&_action=ActionChangeTemplate',
                data:{'id':id},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==1?5:6,time:1000});
                    if(data.code==0)
                    {
                        $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="use-ing" onClick="layer.msg(\'正在使用中...\',{icon:6,time:1000})" href="javascript:;" title="使用中"><i class="Hui-iconfont">&#xe656;</i></a>');
                        $(obj).remove();
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }


    function template_show(id)
    {
        $.getJSON('?mod=admin&v_mod=shop&_action=GetTemplatePhoto&id='+id+'v='+new Date, function(json){
            layer.photos({
                photos: json //格式见API文档手册页
                ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
            });
        });
    }


</script>
</body>
</html>