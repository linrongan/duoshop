<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getAllNews();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>官网咨询</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 官网咨询
    <span class="c-gray en">&gt;</span> 新闻列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <span class="l">
            <a href="javascript:;" onclick="news_add('添加新闻','?mod=admin&v_mod=pc&_index=_news_new')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加新闻
            </a>
        </span>
        <span class="r">共有新闻：<strong><?php echo count($data['total']); ?></strong> 条</span>
    </div>
    <form action="" method="post" class="mb-20">
        <div> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" value="<?php if(isset($_REQUEST['title'])){echo $_REQUEST['title'];} ?>" style="width:250px" placeholder="输入标题" id="" name="title">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">新闻列表</th>
        </tr>
        <tr class="text-c">
            <th width="250">新闻名字</th>
            <th>新闻分类</th>
            <th>新闻概要</th>
            <th>发布时间</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['news_title'];?></td>
                    <td><?php echo $item['news_category']==0?'行业资讯':'公司新闻';?></td>
                    <td><?php echo utf_substr($item['news_desc'],20);?></td>
                    <td><?php echo date('Y-m-d',$item['addtime']);?></td>
                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="news_edit('编辑','?mod=admin&v_mod=pc&_index=_news_edit','<?php echo $item['id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="news_del(this,'<?php echo $item['id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
    function news_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*删除*/
    function news_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=pc&_index=_news_list&_action=ActionDelNews&id='+id,
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
    function news_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }




</script>
</body>
</html>