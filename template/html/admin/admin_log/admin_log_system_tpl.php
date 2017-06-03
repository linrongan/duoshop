<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getLogSystem();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>系统日志</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 日志管理
    <span class="c-gray en">&gt;</span> 系统日志
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
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
            <th scope="col" colspan="9">系统日志</th>
        </tr>
        <tr class="text-c">
            <th>标题</th>
            <th>内容</th>
            <th>时间</th>
            <th>状态</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['key_title'];?></td>
                    <td>
                        <span onmouseover="layer.tips('<?php echo $item['content']; ?>', this, {tips: [1, '#3595CC'],time: 4000});"><?php echo utf_substr($item['content'],20);?></span>
                    </td>
                    <td><?php echo $item['addtime'];?></td>
                    <td><?php echo $item['status']==1?'已通知':'未通知';?></td>
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
    <?php
        if(!empty($data['canshu']) && empty($data['canshu']))
        {
            ?>
    layer.confirm('没有查出内容，是否初始化？',function(index)
    {
        location.href='?mod=admin&v_mod=admin_log&_index=_list';
    });
    <?php
        }
    ?>
</script>
</body>
</html>