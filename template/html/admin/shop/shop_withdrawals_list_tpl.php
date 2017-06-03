<?php
$data = $obj->GetShopOutMoneyList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>店铺申请</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页 <span class="c-gray en">&gt;</span>
    财务中心 <span class="c-gray en">&gt;</span>
    商家提现
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<div class="page-container">
    <form action="" method="post" class="mb-20">
        <div> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
        <a class="btn btn-primary radius" onclick="withdrawals_out('商家提现','/?mod=admin&v_mod=shop&_index=_withdrawals')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 提现</a>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover">
            <thead>
            <tr class="text-c">
                <th width="100">店铺</th>
                <th width="80">金额</th>
                <th width="80">姓名</th>
                <th width="100">联系方式</th>
                <th width="100">银行</th>
                <th width="150">卡号</th>
                <th width="150">申请时间</th>
                <th width="60">状态</th>
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
                        <td><img width="50" src="<?php echo $item['store_logo']; ?>" alt=""/>
                            <br>
                            <?php echo $item['store_name']; ?>]
                        </td>
                        <td><?php echo $item['money']; ?></td>
                        <td><?php echo $item['username']; ?></td>
                        <td><?php echo $item['phone']; ?></td>
                        <td><?php echo $item['bank']; ?></td>
                        <td><?php echo $item['bank_card']; ?></td>
                        <td><?php echo $item['addtime']; ?></td>
                        <td class="td-status">
                            <?php
                                if($item['status']==0)
                                {
                                    echo '<span class="label label-default radius">未处理</span>';
                                }elseif($item['status']==1)
                                {
                                    echo '<span class="label label-danger radius">处理中</span>';
                                }else{
                                    echo '<span class="label label-success radius">已完成</span>';
                                }
                            ?>
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
            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['param']));
        echo $page->page_nav();
        ?>
    </div>
</div>

<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $('.table-sort').dataTable({
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "aoColumnDefs": [
            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
            {"orderable":false,"aTargets":[0,1,7]}// 制定列不参与排序
        ]
    });

    function withdrawals_out(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
</script>
</body>
</html>