<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getUserTransactionList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>交易流水</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 财务中心
    <span class="c-gray en">&gt;</span> 交易流水
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="cl mb-20">
        <div class="row cl">
            <div class="col-sm-6">
                <div class="panel panel-default panel-success">
                    <div class="panel-header">总收益￥</div>
                    <div class="panel-body"><?php echo $data['profit']['sum']?$data['profit']['sum']:'0.00';?></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default panel-danger">
                    <div class="panel-header">总支出￥</div>
                    <div class="panel-body"><?php echo $data['pay']['sum']?$data['pay']['sum']:'0.00';?></div>
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
                <select class="select" name="balance_type">
                    <option value="">盈亏类型</option>
                    <option value="2"  <?php echo isset($_REQUEST['balance_type']) && $_REQUEST['balance_type']=='2'?'selected':''; ?>>支出</option>
                    <option value="3" <?php echo isset($_REQUEST['balance_type']) && $_REQUEST['balance_type']=='3'?'selected':''; ?>>收益</option>
                </select>
            </span>
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <a href="?mod=admin&v_mod=admin_transaction&_index=_list" class="btn btn-default radius"><i class="Hui-iconfont">&#xe66c;</i> 重置</a>
        </div>
    </form>

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" class="text-c">交易流水</th>
            <th scope="col" colspan="8">
                笔数：<?php echo $data['total']; ?>笔&nbsp;
                金额：<?php echo $data['money']; ?>元
            </th>
        </tr>
        <tr class="text-c">
            <th>编号</th>
            <th>费用种类</th>
            <th>盈亏类型</th>
            <th>盈亏金额</th>
            <th>费用明细标题</th>
            <th>时间</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['data'])){
            foreach($data['data'] as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['id'];?></td>
                    <td>
                        <?php echo $item['type_name'];?>
                    </td>
                    <td><?php echo $item['merchat_balance_type']==2?'支出':'收益';?></td>
                    <td><?php echo $item['fee_money'];?></td>
                    <td><?php echo $item['title'];?></td>
                    <td><?php echo $item['addtime'];?></td>
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