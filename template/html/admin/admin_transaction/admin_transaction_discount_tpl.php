<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetDiscountLog();
//echo '<pre>';
//var_dump($data['group']);exit;
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>折扣卷明细</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 财务中心
    <span class="c-gray en">&gt;</span> 折扣卷明细
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="cl mb-20">
        <div class="row cl">
            <div class="col-sm-4">
                <div class="panel panel-default panel-default">
                    <div class="panel-header">充值</div>
                    <div class="panel-body"><?php echo isset($data['group'][1])?$data['group'][1]['sum_money']:'0.00';?></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default panel-danger">
                    <div class="panel-header">会员已使用</div>
                    <div class="panel-body"><?php echo isset($data['group'][3])?$data['group'][3]['sum_money']:'0.00';?></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default panel-success">
                    <div class="panel-header">会员已领取</div>
                    <div class="panel-body"><?php echo isset($data['group'][2])?$data['group'][2]['sum_money']:'0.00';?></div>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="post" class="mb-20">
        <div> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <span class="select-box" style="width:120px">
                <select class="select" name="order_type">
                    <option value="">类型</option>
                    <option value="1"  <?php echo isset($_REQUEST['order_type']) && $_REQUEST['order_type']=='1'?'selected':''; ?>>充值</option>
                    <option value="2" <?php echo isset($_REQUEST['order_type']) && $_REQUEST['order_type']=='2'?'selected':''; ?>>用户领取</option>
                    <option value="3" <?php echo isset($_REQUEST['order_type']) && $_REQUEST['order_type']=='3'?'selected':''; ?>>用户使用</option>
                </select>
            </span>
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <a href="javascript:location.replace(location.href);" class="btn btn-default radius"><i class="Hui-iconfont">&#xe66c;</i> 重置</a>
        </div>
    </form>

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="8">交易流水</th>
        </tr>
        <tr class="text-c">
            <th width="40">编号</th>
            <th width="100">时间</th>
            <th width="100">店铺</th>
            <th width="100">交易类型</th>
            <th width="100">用户</th>
            <th width="100">金额</th>
            <th width="100">备注</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['id'];?></td>
                    <td><?php echo $item['addtime'];?></td>
                    <td><?php echo $item['store_name'];?></td>
                    <td><?php
                         if($item['order_type']==1)
                         {
                             echo '充值';
                         }elseif($item['order_type']==2)
                         {
                             echo '用户领取';
                         }elseif($item['order_type']==2)
                         {
                             echo '用户使用';
                         }else{
                             echo '默认';
                         }
                        ?></td>
                    <td>
                        <img width="50" src=" <?php echo $item['headimgurl'];?>" alt=""/><br/>
                        <?php echo $item['nickname'];?>
                    </td>
                    <td><?php echo $item['money'];?></td>
                    <td><?php echo $item['orderid'];?></td>
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