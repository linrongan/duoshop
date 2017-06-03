<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetSeekhelpList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>资助申请</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    资助申请
    <span class="c-gray en">&gt;</span>
    申请记录
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="codeView cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <div class="clearfix">
            <form method="post" action="/?mod=admin&v_mod=admin_advert&_index=_list">
                <input style="width: 150px;" class="input-text" type="text" value="" placeholder="输入姓名搜索" name="name"/>
                <button type="submit" class="btn btn-success" id="search_button">查询</button>
                <a href="/?mod=admin&v_mod=admin_seekhelp&_index=_list" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">姓名</th>
                <th width="80">联系电话</th>
                <th width="100">所在城市</th>
                <th width="100">申请金额/物品</th>
                <th width="150">本地房产</th>
                <th width="100">职业</th>
                <th width="100">申请时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data['data'])
            {
                $date=date("Y-m-d H:i:s");
                foreach($data['data'] as $item)
                {
                    ?>
                    <tr class="text-c">
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['phone']; ?></td>
                        <td><?php echo $item['live_area']; ?></td>
                        <td><?php echo $item['need_goods']; ?></td>
                        <td><?php echo $item['house']; ?></td>
                        <td><?php echo $item['occupation']; ?></td>
                        <td><?php echo $item['addtime']; ?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="seekhelp_del(this,<?php echo $item['id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
    });

    /*图片-删除*/
    function seekhelp_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_seekhelp&_action=ActionDelSeekhelp',
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