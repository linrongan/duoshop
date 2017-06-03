<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetAdvertData();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>广告区域</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/tool/upload/upload.css">
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    竞价广告
    <span class="c-gray en">&gt;</span>
    广告区域
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

<div id="tab-system" class="HuiTab">
<div class="tabBar cl">
    <span>首页Banner</span>
    <span>首页精选店铺</span>
    <span>精选专栏banner</span>
    <span>首页逛商城广告图</span>
    <span>砍价页面banner</span>
</div>
<div class="tabCon">
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="banner_add('添加首页Banner','?mod=admin&v_mod=admin_shop&_index=_decorate_add&type=0')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加图片</a>
    </div>
    <table class="table table-border table-bordered table-bg table-hover table-sort">
        <thead>
        <tr class="text-c">
            <th width="80">图片</th>
            <th width="100">标题</th>
            <th width="100">链接</th>
            <th width="100">投放日期</th>
            <th width="150">显示位置</th>
            <th width="150">排序</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody id="tbody">
        <?php
        if(isset($data['banner'][0]) && !empty($data['banner'][0]))
        {
            $i=0;
            foreach($data['banner'][0] as $item)
            {
                $i++;
                ?>
                <tr class="text-c">
                    <td><img onclick="img_show('<?php echo $item['picture_img']; ?>')" src="<?php echo $item['picture_img']; ?>" width="50" class="picture-thumb" alt=""></td>
                    <td><?php echo $item['picture_title']; ?></td>
                    <td><?php echo $item['picture_link']; ?></td>
                    <td><?php echo $item['start_time'];; ?>
                        <br/>
                        <?php echo $item['expire_time'];; ?>
                    </td>
                    <td>第<?php echo $i; ?>张</td>
                    <td><?php echo $item['picture_sort']; ?></td>
                    <td>
                        <a style="text-decoration:none" class="ml-5" onClick="banner_edit('轮播图编辑','?mod=admin&v_mod=admin_shop&_index=_decorate_edit&type=0',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,0)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
    <!--      首页精选店铺      -->
    <table class="table table-border table-bordered table-bg table-hover table-sort">
        <thead>
        <tr class="text-c">
            <th width="100">店铺名称</th>
            <th width="100">店长</th>
            <th width="100">店铺logo	</th>
            <th width="150">店铺链接</th>
            <th width="100">显示位置</th>
        </tr>
        </thead>
        <tbody id="tbody">
        <?php
        if($data['shop'])
        {
            $i=0;
            foreach($data['shop'] as $item)
            {
                $i++;
                ?>
                <tr class="text-c">
                    <td><?php echo $item['store_name'];?></td>
                    <td><?php echo $item['admin_name']; ?></td>
                    <td><?php
                        if($item['store_logo']){
                            echo "<img width='50' src ='".$item['store_logo']."'/>";
                        }
                        ?></td>
                    <td><?php echo $item['store_url'];?></td>
                    <td>第<?php echo $i;?>个</td>
                </tr>
            <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
<div class="tabCon">
    <!--      精选店铺专栏banner      -->
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="banner_add('添加精选专栏banner','?mod=admin&v_mod=admin_shop&_index=_decorate_add&type=3')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加图片</a>
    </div>
    <table class="table table-border table-bordered table-bg table-hover table-sort">
        <thead>
        <tr class="text-c">
            <th width="80">图片</th>
            <th width="100">标题</th>
            <th width="100">链接</th>
            <th width="100">投放日期</th>
            <th width="150">显示位置</th>
            <th width="150">排序</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody id="tbody">
        <?php
        if($data['banner'][3])
        {
            $i=0;
            foreach($data['banner'][3] as $item)
            {
                $i++;
                ?>
                <tr class="text-c">
                    <td><img onclick="img_show('<?php echo $item['picture_img']; ?>')" src="<?php echo $item['picture_img']; ?>" width="50" class="picture-thumb" alt=""></td>
                    <td><?php echo $item['picture_title']; ?></td>
                    <td><?php echo $item['picture_link']; ?></td>
                    <td><?php echo $item['start_time'];; ?>
                        <br/>
                        <?php echo $item['expire_time'];; ?>
                    </td>
                    <td>第<?php echo $i; ?>张</td>
                    <td><?php echo $item['picture_sort']; ?></td>
                    <td>
                        <a style="text-decoration:none" class="ml-5" onClick="banner_edit('精选店铺专栏banner编辑','?mod=admin&v_mod=admin_shop&_index=_decorate_edit&type=3',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,3)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
    <!--      首页逛商城广告图      -->
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="banner_add('添加精选店铺专栏banner','?mod=admin&v_mod=admin_shop&_index=_decorate_add&type=1')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加图片</a>
    </div>
    <table class="table table-border table-bordered table-bg table-hover table-sort">
        <thead>
        <tr class="text-c">
            <th width="80">图片</th>
            <th width="100">标题</th>
            <th width="100">链接</th>
            <th width="100">投放日期</th>
            <th width="150">显示位置</th>
            <th width="150">排序</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody id="tbody">
        <?php
        if($data['banner'][1])
        {
            $i=0;
            foreach($data['banner'][1] as $item)
            {
                $i++;
                ?>
                <tr class="text-c">
                    <td><img onclick="img_show('<?php echo $item['picture_img']; ?>')" src="<?php echo $item['picture_img']; ?>" width="50" class="picture-thumb" alt=""></td>
                    <td><?php echo $item['picture_title']; ?></td>
                    <td><?php echo $item['picture_link']; ?></td>
                    <td><?php echo $item['start_time'];; ?>
                        <br/>
                        <?php echo $item['expire_time'];; ?>
                    </td>
                    <td>第<?php echo $i; ?>张</td>
                    <td><?php echo $item['picture_sort']; ?></td>
                    <td>
                        <a style="text-decoration:none" class="ml-5" onClick="banner_edit('逛商城广告图编辑','?mod=admin&v_mod=admin_shop&_index=_decorate_edit&type=1',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,1)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
    <!--      砍价页面广告图      -->
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="banner_add('添加砍价页面banner','?mod=admin&v_mod=admin_shop&_index=_decorate_add&type=4')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加图片</a>
    </div>
    <table class="table table-border table-bordered table-bg table-hover table-sort">
        <thead>
        <tr class="text-c">
            <th width="80">图片</th>
            <th width="100">标题</th>
            <th width="100">链接</th>
            <th width="100">投放日期</th>
            <th width="150">显示位置</th>
            <th width="150">排序</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody id="tbody">
        <?php
        if(!empty($data['banner'][4]))
        {
            $i=0;
            foreach($data['banner'][4] as $item)
            {
                $i++;
                ?>
                <tr class="text-c">
                    <td><img onclick="img_show('<?php echo $item['picture_img']; ?>')" src="<?php echo $item['picture_img']; ?>" width="50" class="picture-thumb" alt=""></td>
                    <td><?php echo $item['picture_title']; ?></td>
                    <td><?php echo $item['picture_link']; ?></td>
                    <td><?php echo $item['start_time'];; ?>
                        <br/>
                        <?php echo $item['expire_time'];; ?>
                    </td>
                    <td>第<?php echo $i; ?>张</td>
                    <td><?php echo $item['picture_sort']; ?></td>
                    <td>
                        <a style="text-decoration:none" class="ml-5" onClick="banner_edit('逛商城广告图编辑','?mod=admin&v_mod=admin_shop&_index=_decorate_edit&type=4',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,4)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
        //layer.full(index);
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