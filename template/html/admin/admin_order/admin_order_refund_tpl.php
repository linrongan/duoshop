<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetRefundOrderList();
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
                       class="input-text ac_input" style="width:150px">
                <input value="<?php echo isset($_REQUEST['store_name'])?trim($_REQUEST['store_name']):""; ?>"
                       type="text" placeholder="请输入店铺名称搜索" id="store_name" name="store_name"
                       class="input-text ac_input" style="width:150px">
                <input value="<?php echo isset($_REQUEST['nickname'])?trim($_REQUEST['nickname']):""; ?>"
                       type="text" placeholder="请输入用户昵称搜索" id="nickname" name="nickname"
                       class="input-text ac_input" style="width:150px">
                <span class="select-box" style="width:150px">
                    <select class="select" name="goods_refund">
                        <option value="">请选择退款状态</option>
                        <option value="1"  <?php echo isset($_REQUEST['goods_refund']) && $_REQUEST['goods_refund']=='1'?'selected':''; ?>>发起退款</option>
                        <option value="2" <?php echo isset($_REQUEST['goods_refund']) && $_REQUEST['goods_refund']=='2'?'selected':''; ?>>已接受退款</option>
                        <option value="3" <?php echo isset($_REQUEST['goods_refund']) && $_REQUEST['goods_refund']=='3'?'selected':''; ?>>完成退款</option>
                        <option value="5" <?php echo isset($_REQUEST['goods_refund']) && $_REQUEST['goods_refund']=='5'?'selected':''; ?>>关闭退款</option>
                    </select>
                </span>
                <button type="submit" class="btn btn-success" id="search_button">查询</button>
                <a href="?mod=admin&v_mod=admin_order&_index=_refund" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>

    <table class="table table-border table-bordered table-bg table-hover table-sort">
        <thead>
        <tr class="text-c">
            <th width="100">订单号</th>
            <th width="180">用户</th>
            <th width="150">店铺</th>
            <th width="100">总金额</th>
            <th width="150">退款理由</th>
            <th width="120">退款申请时间</th>
            <th width="150">退款状态</th>
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
                    <td><?php echo $item['orderid']; ?></td>
                    <td >
                        <img width="50 " src="<?php echo $item['headimgurl']; ?>" alt=""/><br>
                       <?php echo $item['nickname']; ?>
                    </td>
                    <td><?php echo $item['store_name']; ?></td>
                    <td class="text-c"><?php echo $item['product_sum_price']; ?></td>
                    <td><?php echo $item['refund_cause'];?></td>
                    <td><?php echo $item['apply_date']; ?></td>
                    <td class="td-status">

                            <?php
                                if($item['goods_refund']==1){
                                    echo '<span class="label badge-default radius">发起退款</span>';
                                }elseif($item['goods_refund']==2){
                                    echo '<span class="label badge-primary radius">已接受退款</span>';
                                }elseif($item['goods_refund']==3){
                                    echo '<span class="label badge-success radius">完成退款</span>';
                                }elseif($item['goods_refund']==5){
                                    echo '<span class="label badge-default radius">关闭退款</span>';
                                }
                            ?>

                    </td>
                    <td class="td-manage">
                        <a style="text-decoration:none" class="ml-5" onClick="refund_details('查看详情','?mod=admin&v_mod=admin_refund&_index=_apply_details&id=<?php echo $item['apply_id'];?>')" href="javascript:;" title="详情"><i class="Hui-iconfont">&#xe627;</i></a>
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
    function order_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_order&_action=ActionDelRefundOrder&id='+id,
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
    //详情
    function refund_details(title,url){
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