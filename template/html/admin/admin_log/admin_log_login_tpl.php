<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getAdminLogin();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>管理员登录记录</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 日志管理
    <span class="c-gray en">&gt;</span> 管理员登录记录
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <form action="" method="post" class="mb-20">
        <div> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" value="<?php if(isset($_REQUEST['admin_id'])){echo $_REQUEST['admin_id'];} ?>" style="width:120px" placeholder="管理员id" name="admin_id">
            <span class="select-box" style="width:120px">
                <select class="select" name="login_status">
                    <option value="">请选择登录状态</option>
                    <option value="0"  <?php echo isset($_REQUEST['login_status']) && $_REQUEST['login_status']=='0'?'selected':''; ?>>登录成功</option>
                    <option value="1" <?php echo isset($_REQUEST['login_status']) && $_REQUEST['login_status']=='1'?'selected':''; ?>>登录失败</option>
                </select>
            </span>
            <button type="submit" class="btn btn-success" id="search_button">搜索</button>
            <a href="?mod=admin&v_mod=admin_log&_index=_login" class="btn btn-default">取消</a>
        </div>
    </form>

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">管理员登录记录</th>
        </tr>
        <tr class="text-c">
            <th>编号</th>
            <th>管理员ID</th>
            <th>登录时间</th>
            <th>登录IP</th>
            <th>登录状态</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['id'];?></td>
                    <td><?php echo $item['admin_id'];?></td>
                    <td><?php echo $item['login_date'];?></td>
                    <td><?php echo $item['login_ip'];?></td>
                    <td><?php echo $item['login_status']==0?'登录成功':'登录失败';?></td>
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

</script>
</body>
</html>