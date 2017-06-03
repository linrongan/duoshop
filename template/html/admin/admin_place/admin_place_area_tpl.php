<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getArea();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>区域</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 区域管理
    <span class="c-gray en">&gt;</span> <?php echo $_GET['father']; ?>
    <span class="c-gray en">&gt;</span> <?php echo $data['city']['name']; ?>
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <form action="" method="post">
            <input type="text" class="input-text" value="<?php if(isset($_REQUEST['name'])){echo $_REQUEST['name'];} ?>" style="width:250px" placeholder="输入区域名" id="" name="name">
            <button type="submit" class="btn btn-success" id="search_button">搜索</button>
            <a href="?mod=admin&v_mod=admin_place&_index=_area&id=<?php echo $data['city']['autoid']; ?>&father=<?php echo $_GET['father']; ?>" class="btn btn-default">取消</a>
            <a href="javascript:;" onclick="add('添加区域','?mod=admin&v_mod=admin_place&_index=_area_new&father=<?php echo $data['city']['id']; ?>','','500')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加区域
            </a>
            <a href="javascript:;" onclick="javascript :history.back(-1);" class="btn btn-success-outline radius">返回上一页</a>
        </form>
    </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr><th colspan="4"><?php echo $_GET['father'].'->'.$data['city']['name']; ?></th></tr>
        <tr class="text-c">
            <th width="40">编号</th>
            <th>市ID</th>
            <th>名字</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['autoid'];?></td>
                    <td><?php echo $item['id'];?></td>
                    <td><?php echo $item['name'];?></td>

                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="edit('编辑','?mod=admin&v_mod=admin_place&_index=_area_edit','<?php echo $item['autoid'];?>','','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="del(this,'<?php echo $item['autoid'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
    /*增加*/
    function add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*删除*/
    function del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_place&_index=_area&_action=ActionDelArea&id='+id,
                data:{'id':id},
                dataType: 'json',
                success: function(res)
                {
                    if (res.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                    layer.msg(res.msg,{icon:1,time:1000});
                },
                error:function(res) {
                    console.log(res.msg);
                    alert('网络超时')
                }
            });
        });
    }


    //$("#txt_spCodes").val(spCodesTemp);
    /*编辑*/
    function edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }
</script>
</body>
</html>