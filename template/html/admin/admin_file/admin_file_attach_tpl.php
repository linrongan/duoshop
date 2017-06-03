<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getAdminFile();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>上传文件</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 素材管理管理
    <span class="c-gray en">&gt;</span> 上传文件
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <form action="" method="post" class="mb-20">
        <div>
            <input type="text" class="input-text" value="<?php if(isset($_REQUEST['nickname'])){echo $_REQUEST['nickname'];} ?>" style="width:120px" placeholder="输入用户名搜索" name="nickname">
            <span class="select-box" style="width:120px">
                <select class="select" name="type_id">
                    <option value="">请选择类型</option>
                    <option value="1"  <?php echo isset($_REQUEST['type_id']) && $_REQUEST['type_id']=='1'?'selected':''; ?>>会员认证资料申请</option>
                    <option value="2" <?php echo isset($_REQUEST['type_id']) && $_REQUEST['type_id']=='2'?'selected':''; ?>>代理店铺logo</option>
                    <option value="3" <?php echo isset($_REQUEST['type_id']) && $_REQUEST['type_id']=='3'?'selected':''; ?>>店铺背景</option>
                </select>
            </span>
            <button type="submit" class="btn btn-success" id="search_button">搜索</button>
            <a href="?mod=admin&v_mod=admin_file&_index=_attach" class="btn btn-default">取消</a>
        </div>
    </form>

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">上传文件</th>
        </tr>
        <tr class="text-c">
            <th>类型</th>
            <th>用户名</th>
            <th>申请记录标识id</th>
            <th>文件</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td>
                        <?php
                            if($item['type_id']==1){
                                echo '会员认证资料申请';
                            }elseif($item['type_id']==2){
                                echo '代理店铺logo';
                            }else{
                                echo '店铺背景';
                            }
                        ?>
                    </td>
                    <td><?php echo $item['nickname'];?></td>
                    <td><?php echo $item['id'];?></td>
                    <td>
                        <?php if($item['file_src']){
                            ?>
                            <a href="<?php echo $item['file_src']?>" title="新窗口打开图片" target="_blank">
                                <img src="<?php echo $item['file_src']?>" width="50px"/>
                            </a>
                        <?php }
                            ?>
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