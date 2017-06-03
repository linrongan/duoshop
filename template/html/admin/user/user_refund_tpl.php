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
    <title>退款订单列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 交易管理
    <span class="c-gray en">&gt;</span> 退款订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
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
            <td width="80">店铺</td>
            <th width="80">用户</th>
            <th width="80">售后编号</th>
            <th width="80">订单号</th>
            <th width="80">产品图片</th>
            <th width="80">产品名字</th>
            <th width="80">退款理由</th>
            <th width="80">退款金额</th>
            <th width="80">退款状态</th>
            <th width="100">申请时间</th>
            <th width="100">支付方式</th>
            <th width="80">操作</th>
        </tr>
        </thead>
        <tbody id="tbody">
        <?php
        if($data['data'])
        {
            foreach($data['data'] as $item)
            {
                ?>
                <tr class="text-c" style="<?php if($item['refund_is_valid']){echo 'text-decoration:line-through';} ?>">
                    <td>
                        <img width="50" src="<?php echo $item['store_logo']; ?>" alt=""/><br>
                        <?php echo $item['store_name'];?>
                    </td>
                    <td>
                        <img width="50" src="<?php echo $item['headimgurl']; ?>" alt=""/><br>
                        <?php echo $item['nickname'];?>
                    </td>
                    <td><?php echo $item['refund_number'];?></td>
                    <td><?php echo $item['refund_number'];?></td>
                    <td><img width="50" src="<?php echo $item['refund_product_img'];?>" alt=""/></td>
                    <td><?php echo $item['refund_product_name'];?></td>
                    <td><?php echo $item['refund_cause'];?></td>
                    <td><?php echo $item['refund_money'];?></td>
                    <td><?php
                        if($item['refund_status']==0)
                        {
                            echo '未处理';
                        }elseif($item['refund_status']==1){
                            echo '自己取消';
                        }    elseif($item['refund_status']==2){
                            echo '管理员取消';
                        }elseif($item['refund_status']==3){
                            echo '通过申请';
                        }elseif($item['refund_status']==4){
                            echo '已提交物流信息等待处理';
                        }elseif($item['refund_status']==5){
                            echo '成功退款';
                        }elseif($item['refund_status']==6){
                            echo '拒绝退款';
                        }
                        ?></td>
                    <td><?php echo $item['apply_date'];?></td>
                    <td>
                        <?php if($item['refund_order_pay_method']=='user_money'){echo '余额支付';}else{echo '微信支付';} ?>
                    </td>
                    <td>
                        <a href="javascript:;" onclick="refund_details('查看详情','?mod=admin&v_mod=user&_index=_refund_details&id=<?php echo $item['id'];?>')" title="详情"  class="ml-5"
                           style="text-decoration:none"><i class="Hui-iconfont"></i>
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

    /*编辑*/

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