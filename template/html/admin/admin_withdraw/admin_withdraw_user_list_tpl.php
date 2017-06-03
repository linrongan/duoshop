<?php
$data = $obj->GetUserMoneyOutList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>用户提现</title>
</head>
<body>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 财务中心
    <span class="c-gray en">&gt;</span> 用户提现

</nav>
<div class="page-container">
    <form action="" method="post" class="mb-20">
        <div> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <select name="withdraw_status" id="withdraw_status" class="select-box select" style="width: 150px;">
                <option value="">请选择状态</option>
                <option <?php echo isset($_REQUEST['withdraw_status']) && $_REQUEST['withdraw_status']=='0'?'selected':''; ?> value="0">已提交</option>
                <option <?php echo isset($_REQUEST['withdraw_status']) && $_REQUEST['withdraw_status']=='1'?'selected':''; ?> value="1">处理中</option>
                <option <?php echo isset($_REQUEST['withdraw_status']) && $_REQUEST['withdraw_status']=='2'?'selected':''; ?> value="2">已处理</option>
            </select>
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <a class="btn btn-success radius" href="javascript:location.replace(location.href);" title="刷新" >
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </div>
    </form>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover">
            <thead>
            <tr class="text-c">
                <th width="100">申请用户</th>
                <th width="80">提现金额</th>
                <th width="100">来源</th>
                <th width="100">提现方式</th>
                <th width="180">卡号信息</th>
                <th width="50">处理方式</th>
                <th width="60">状态</th>
                <th width="100">申请时间</th>
                <th width="60">编辑</th>
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
                        <td><img width="50" src="<?php echo $item['headimgurl']; ?>" alt=""/><br><?php echo $item['nickname']; ?></td>
                        <td><?php echo $item['withdraw_money']; ?></td>
                        <td><?php echo $item['withdraw_sourse']; ?></td>
                        <td><?php echo $item['withdraw_method']==0?'余额':'银行卡'; ?></td>
                        <td class="text-l">
                            银行：<?php echo $item['withdraw_bank_name']?$item['withdraw_bank_name']:'-'; ?><br>
                            卡号：<?php echo $item['withdraw_bank_number']?$item['withdraw_bank_number']:'-'; ?><br>
                            持卡人：<?php echo $item['withdraw_bank_user_name']?$item['withdraw_bank_user_name']:'-'; ?><br>
                            持卡人身份证：<?php echo $item['withdraw_bank_user_card']?$item['withdraw_bank_user_card']:'-'; ?>
                        </td>
                        <td>
                            <?php echo $item['handle_way']?'自动':'人工'; ?>
                        </td>
                        <td class="td-status">
                            <?php
                            if($item['withdraw_status']==0)
                            {
                                ?>
                                <span class="label label-default radius">申请中</span>
                                <?php
                            }elseif($item['withdraw_status']==1)
                            {
                                ?>
                                <span class="label label-default radius">处理中</span>
                                <?php
                            }else{
                                ?>
                                <span class="label label-success radius">已提现</span>
                                <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $item['withdraw_apply_date']; ?></td>
                        <td>
                            <a style="text-decoration:none"
                               onclick="open_details('查看','?mod=admin&v_mod=admin_withdraw&_index=_user_details&id=<?php echo $item['id']; ?>',640,600)"  href="javascript:;" title="查看">
                                <i class="Hui-iconfont">&#xe61d;</i>
                            </a>
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


    function send_money(obj,id,money)
    {
        layer.confirm('确定使用微信转账？ 金额'+money,function(index)
        {
            layer.prompt({title: '请确认金额 金额'+money, formType: 2}, function(text, index)
            {
                layer.close(index);
                layer.confirm('您输入的金额是'+text,function(index)
                {
                    layer.close(index);
                    layer.prompt({title: '请输入管理员密码', formType: 1}, function(pass, index){
                        layer.close(index);
                        var load_index = layer.load(1, {
                            shade: [0.1,'#fff'] //0.1透明度的白色背景
                        });
                        $.ajax({
                            type:'post',
                            url:'',
                            data:{id:id,money:money},
                            success:function (res)
                            {
                                layer.close(load_index);
                            },
                            error:function ()
                            {
                                layer.close(load_index);
                            },
                            dataType:'json'
                        });
                        layer.close(index);
                    });
                });
            });
        });
    }



    function open_details(title,url,w,h)
    {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
        //layer_show(title,url,w,h);
    }
</script>
</body>
</html>