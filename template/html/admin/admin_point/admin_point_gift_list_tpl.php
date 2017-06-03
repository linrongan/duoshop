<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetPointGiftList();
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
    积分礼品
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="codeView cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <div class="clearfix">
            <form method="post" action="">
                <input style="width: 150px;" class="input-text" type="text" value="" placeholder="输入礼品名字搜索" name="name">
                <button type="submit" class="btn btn-success" id="search_button">查询</button>
                <a href="/?mod=admin&v_mod=admin_point&_index=_gift_list" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>

    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="gift_add('添加礼品','?mod=admin&v_mod=admin_point&_index=_gift_add')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加积分礼品</a>
    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th  width="80">商品编号</th>
                <th  width="80">所属类别</th>
                <th  width="80">商品名称</th>
                <th  width="80">商品图片</th>
                <th  width="80">需要积分</th>
                <th  width="80">库存数量</th>
                <th  width="80">销售数量</th>
                <th  width="80">核销数量</th>
                <th  width="80">编辑</th>
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
                        <td><?php echo $item['id'] ?></td>
                        <td><?php echo $item['category_name']; ?></td>
                        <td><?php echo $item['gift_name']; ?></td>
                        <td><img width="50" src="<?php echo $item['gift_img']; ?>" alt=""></td>
                        <td><?php echo $item['gift_point'];?></td>
                        <td><?php echo $item['qty'];?> <?php echo $item['unit'];?></td>
                        <td >
                            <?php echo $item['sale'];?>
                        </td>
                        <td class="center">
                            <?php echo $item['hx_sale'];?>
                        </td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="gift_edit('礼品编辑','?mod=admin&v_mod=admin_point&_index=_gift_edit',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="gift_del(this,<?php echo $item['id']; ?>)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
                url: '?mod=admin&v_mod=admin_point&_action=ActionDelGift',
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