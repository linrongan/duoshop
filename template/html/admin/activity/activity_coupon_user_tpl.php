<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getCouponList();
$category=$obj->getCouponCategory();

//var_dump($data);exit;
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>优惠卷列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 营销管理
    <span class="c-gray en">&gt;</span> 优惠卷列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="codeView cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <div class="clearfix">
            <form method="post" action="">
                <input value="<?php echo isset($_REQUEST['coupon_name'])?trim($_REQUEST['coupon_name']):""; ?>"
                       type="text" placeholder="请输入优惠卷名字搜索" id="coupon_name" name="coupon_name"
                       class="input-text ac_input" style="width:200px">
                <span class="select-box" style="width:150px">
                    <select class="select" name="coupon_type">
                        <option value="">请选择优惠卷类型</option>
                        <?php
                        foreach($category as $c){
                            ?>
                            <option <?php echo isset($_REQUEST['coupon_type']) && $_REQUEST['coupon_type']==$c['id']?'selected':''; ?> value="<?php echo $c['id']; ?>">
                                <?php echo $c['type_name']; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </span>
                <span class="select-box" style="width:150px">
                    <select class="select" name="use_status">
                        <option value="">状态</option>
                        <option <?php echo isset($_REQUEST['use_status']) && $_REQUEST['use_status']==0?'selected':''; ?> value="0">
                            未使用
                        </option>
                        <option <?php echo isset($_REQUEST['use_status']) && $_REQUEST['use_status']==1?'selected':''; ?> value="1">
                            已使用
                        </option>
                    </select>
                </span>
                <button type="submit" class="btn btn-success" id="search_button">搜索</button>
                <a href="?mod=admin&v_mod=activity&_index=_coupon_user" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>
    <table class="table table-border table-bordered table-bg table-hover">
        <thead>
        <tr class="text-c">
            <th width="80">持有者</th>
            <th width="80">优惠卷类型</th>
            <th width="80">优惠卷名称</th>
            <th width="80">优惠金额</th>
            <th width="80">最小支付金额</th>
            <th width="120">使用状态</th>
            <th width="80">有效期</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['nickname']; ?></td>
                    <td>
                        <?php echo $item['type_name']; ?>
                    </td>
                    <td>
                        <?php echo $item['coupon_name']; ?>
                    </td>
                    <td>
                        <?php echo $item['coupon_money']; ?>
                    </td>
                    <td>
                        <?php echo $item['min_money']; ?>
                    </td>
                    <td>
                        <?php echo $item['use_status']==0?'未使用':'已使用'; ?>
                    </td>
                    <td>
                        <?php echo $item['start_time'].'<br>-<br>'.$item['expire_time']; ?>
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
    /*
     参数解释：
     title	标题
     url		请求的url
     id		需要操作的数据id
     w		弹出层宽度（缺省调默认值）
     h		弹出层高度（缺省调默认值）
     */
</script>
</body>
</html>