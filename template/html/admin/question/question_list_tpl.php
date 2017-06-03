<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetQuestionList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>常见问题</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 信息中心
    <span class="c-gray en">&gt;</span> 常见问题
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<div class="page-container">

    <div class="codeView cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <div class="clearfix">
            <form method="post" action="">
                <input value="<?php echo isset($_REQUEST['keyword'])?trim($_REQUEST['keyword']):""; ?>"
                       type="text" placeholder="请输入问题或答案搜索" id="keyword" name="keyword"
                       class="input-text ac_input" style="width:350px">
                <button type="submit" class="btn btn-success" id="search_button">搜索</button>
                <a href="?mod=admin&v_mod=admin_product&_index=_list" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a class="btn btn-primary radius"
            onclick="question_add('新增','?mod=admin&v_mod=question&_index=_add')"
               href="javascript:;">
                <i class="Hui-iconfont"></i>
                新增
            </a>
        </span>
    </div>
    <table class="table table-border table-bordered table-bg table-hover">
        <thead>
        <tr>
            <th scope="col" colspan="9">商品列表</th>
        </tr>
        <tr class="text-c">
            <th>问题</th>
            <th>答案</th>
            <th>默认显示答案</th>
            <th>显示</th>
            <th>排序</th>
            <th>添加时间</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data']))
        {
            foreach($data['data'] as $item)
            {
                ?>
                <tr class="text-c" style="background:<?php if(in_array($item['product_id'],$array)){echo 'darkorange';} ?>">
                    <td class="text-l"><?php echo $item['qusetion'] ?></td>
                    <td class="text-l" width="40%">
                        <p><?php echo $item['answer']; ?></p>
                    </td>
                    <td>
                        <?php echo $item['is_show_answer']?'否':'是'; ?>
                    </td>
                    <td>
                        <?php echo $item['is_show']==0?'显示':'不显示'; ?>
                    </td>
                    <td>
                        <?php echo $item['ry_order']; ?>
                    </td>
                    <td>
                        <?php echo $item['addtime']; ?>
                    </td>
                    <td class="td-manage">
                        <a title="编辑" href="javascript:;"
                           onclick="question_edit('编辑','?mod=admin&v_mod=question&_index=_edit','<?php echo $item['id'];?>')"
                           class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="删除" href="javascript:;"
                           onclick="question_del(this,<?php echo $item['id'];?>)"
                           class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6e2;</i>
                        </a>
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
        "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['param']));
    echo $page->page_nav();
    ?>
    <?php
    if(isset($_GET['select']))
    {
        ?>
        <div class="panel-footer" style="padding-bottom:50px; ">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <a href="javascript:;" id="add-group" class="btn btn-primary">加入团购产品</a>
                    <a href="/?mod=admin&v_mod=group_product&_index=_list" class="btn btn-default">返回</a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    function question_edit(title,url,id)
    {
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }


    function question_add(title,url)
    {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*删除*/
    function question_del(obj,id){
        layer.confirm('确认要删除吗？',function(index)
        {
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=question&_index=_list&_action=ActionDelQuestion&id='+id,
                data:{id:id},
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


</script>
</body>
</html>