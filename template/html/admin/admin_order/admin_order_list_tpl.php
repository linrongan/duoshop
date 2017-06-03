<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetOrderList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>交易订单列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 交易管理
    <span class="c-gray en">&gt;</span> 交易订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="codeView cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <div class="clearfix">
            <form method="post" action="">
                <input value="<?php echo isset($_REQUEST['orderid'])?trim($_REQUEST['orderid']):""; ?>"
                       type="text" placeholder="请输入订单号搜索" id="orderid" name="orderid"
                       class="input-text ac_input" style="width:200px">
                <input value="<?php echo isset($_REQUEST['store_name'])?trim($_REQUEST['store_name']):""; ?>"
                       type="text" placeholder="请输入店铺名称搜索" id="store_name" name="store_name"
                       class="input-text ac_input" style="width:200px">
                <span class="select-box" style="width:150px">
                    <select class="select" name="order_type">
                        <option value="">请选择订单类型</option>
                        <option value="0"  <?php echo isset($_REQUEST['order_type']) && $_REQUEST['order_type']=='0'?'selected':''; ?>>普通订单</option>
                        <option value="1" <?php echo isset($_REQUEST['order_type']) && $_REQUEST['order_type']=='1'?'selected':''; ?>>发起团购</option>
                        <option value="2" <?php echo isset($_REQUEST['order_type']) && $_REQUEST['order_type']=='2'?'selected':''; ?>>参与团购</option>
                    </select>
                </span>
                <span class="select-box" style="width:150px">
                    <select class="select" name="order_status">
                        <option value="">请选择订单状态</option>
                        <?php
                        foreach($Sys_Order_Status as $key=>$item){
                            ?>
                            <option <?php echo isset($_REQUEST['order_status']) && $_REQUEST['order_status']=="$key"?'selected':''; ?> value="<?php echo $key; ?>"><?php echo $item; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </span>
                <button type="submit" class="btn btn-success" id="search_button">查询</button>
                <a href="?mod=admin&v_mod=admin_order&_index=_list" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="select_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
    </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="10">交易订单列表</th>
        </tr>
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="40"><input name="" type="checkbox" value=""></th>
                <th width="100">订单号</th>
                <th width="100">店铺logo</th>
                <th width="150">店铺</th>
                <th width="150">收货人</th>
                <th width="50">优惠券</th>
                <th width="50">折扣券</th>
                <th width="50">运费</th>
                <th width="50">订单金额</th>
                <th width="50">产品金额</th>
                <th width="50">合计金额</th>
                <th width="120">订单时间</th>
                <th width="80">支付方式</th>
                <th width="80">订单类型</th>
                <th width="80">状态</th>
                <th width="100">操作</th>
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
                        <td><input name="" type="checkbox" value="<?php echo $item['orderid']; ?>" class="select_id"></td>
                        <td><?php echo $item['orderid']; ?></td>
                        <td>
                            <img class="round" width="50" src="<?php echo $item['store_logo']; ?>" alt="">
                        </td>
                        <td><?php echo $item['store_name']; ?></td>
                        <td class="text-l">
                            <i class="Hui-iconfont">&#xe60d;</i><?php echo $item['ship_name']; ?><br>
                            <i class="Hui-iconfont">&#xe696;</i><?php echo $item['ship_phone']; ?><br>
                            <i class="Hui-iconfont">&#xe6c9;</i><?php echo $item['ship_province'].$item['ship_city'].$item['ship_area']; ?><br>
                            <i class="Hui-iconfont">&#xe6c9;</i><?php echo $item['ship_address']; ?>
                        </td>
                        <td class="text-c"><?php echo $item['coupon_money']; ?></td>
                        <td class="text-c"><?php echo $item['gift_balance']; ?></td>
                        <td class="text-c"><?php echo $item['pro_fee']; ?></td>
                        <td class="text-c"><?php echo $item['pro_fee']; ?></td>
                        <td class="text-c"><?php echo $item['total_pro_money']; ?></td>
                        <td class="text-c"><?php echo $item['total_money']; ?></td>
                        <td><?php echo $item['addtime']; ?></td>
                        <td>
                            <i class="Hui-iconfont">
                                <?php
                                if($item['pay_method']=='wechat')
                                {
                                    echo '微信';
                                }else{
                                    echo '余额';
                                }
                                ?>
                            </i>
                        </td>
                        <td>
                            <i class="Hui-iconfont">
                            <?php
                                if($item['order_type']==1)
                                {
                                   echo '团购';
                                }else{
                                    echo '普通';
                                }
                            ?>
                            </i>
                        </td>
                        <td class="td-status">
                            <span class="label badge-primary radius">
                                <?php
                                    if($item['refund_status'])
                                    {
                                        if($item['refund_status']==1)
                                        {
                                            echo '申请退款中';
                                        }elseif($item['refund_status']==2)
                                        {
                                            echo '退款处理中';
                                        }elseif($item['refund_status']==3)
                                        {
                                            echo '已退款';
                                        }else{
                                            echo '退款关闭';
                                        }
                                    }else{
                                        echo $Sys_Order_Status[$item['order_status']];
                                    }
                                ?>
                            </span>
                        </td>
                        <td class="td-manage">
                            <a title="详情" href="?mod=admin&v_mod=admin_order&_index=_details&orderid=<?php echo $item['orderid'];?>"
                               class="ml-5 f-18" style="text-decoration:none"><i class="Hui-iconfont">&#xe623;</i>
                            </a>
                            <a title="删除" href="javascript:;"
                               onclick="order_del(this,'<?php echo $item['orderid']; ?>')"
                               class="ml-5 f-18" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6e2;</i>
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

    /*编辑*/



    /*删除*/
    function order_del(obj,orderid){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_order&_index=_list&_action=ActionDelOrder&id='+orderid,
                data:{'orderid':orderid},
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
    function select_del()
    {
        if(!$('.select_id').is(":checked"))
        {
            return false;
        }
        var select_id = [];
        var select_no = [];
        $(".select_id").each(function ()
        {
            if($(this).is(':checked'))
            {
                select_id.push($(this).val());
                select_no.push($(this).parents('tr').index());
            }
        });
        if(select_id.length<=0)
        {
            return false;
        }
        layer.confirm('确认要批量删除吗？',function(index)
        {
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_order&_action=ActionMoreDelOrder',
                data:{orderid:select_id},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==0?6:5,time:1000});
                    if(data.code==0)
                    {
                        for(var i=select_no.length;i>=0;i--)
                        {
                            $("#tbody").children().eq(select_no[i]).remove();
                        }
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }


</script>
</body>
</html>