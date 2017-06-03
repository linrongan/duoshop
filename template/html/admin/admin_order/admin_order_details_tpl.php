<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetOrderItem();

?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>交易订单详情</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 交易管理
    <span class="c-gray en">&gt;</span> 交易订单详情
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="row cl">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-header">收货人信息</div>
                <div class="panel-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">收货人：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['order_ship_name'];?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">联系电话：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['order_ship_phone'];?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">详细地址：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['order_ship_sheng']; ?>
                            <?php echo $data['order']['order_ship_shi']; ?>
                            <?php echo $data['order']['order_ship_qu']; ?>
                            <?php echo $data['order']['order_ship_address']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">物流公司：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['logistics_name']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">货运单号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['logistics_number']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-header">订单信息</div>
                <div class="panel-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">订单号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['orderid']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">店铺：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['store_name']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">下单时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['addtime']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">订单金额：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            ￥ <?php echo $data['order']['total_money']; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">订单备注：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $data['order']['liuyan']?$data['order']['liuyan']:'无'; ?>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <label class="form-label col-xs-4 col-sm-3">订单状态：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php echo $Sys_Order_Status[$data['order']['order_status']]; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">订单列表</div>
            <div class="panel-body">
                <table class="table table-border table-bordered">
                    <thead>
                    <tr class="text-c">
                        <th width="10">产品图</th>
                        <th width="20">产品名称</th>
                        <th width="10">产品属性</th>
                        <th width="10">单价*数量</th>
                        <th width="10">店铺</th>
                        <th width="10">合计</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($data['details'])){
                        foreach($data['details'] as $item){
                            ?>
                            <tr class="text-c">
                                <td>
                                    <img width="50"  src="<?php echo $item['product_img']; ?>" alt="">
                                </td>
                                <td>
                                    <?php echo $item['product_name']; ?>
                                </td>
                                <td>
                                    <?php echo $item['product_attr_name']?$item['product_attr_name']:'无'; ?>
                                </td>
                                <td>
                                    <?php echo $item['product_price'].'x'.$item['product_count']; ?>
                                </td>
                                <td>
                                    <?php echo $item['store_name']; ?>
                                </td>
                                <td>
                                    <?php echo $item['product_sum_price']; ?>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
            <div class="clearfix mb30"></div>
        </div>
    </div>
    <a href="javascript:;" onclick="javascript :history.back(-1);" class="btn btn-success-outline radius mt-20">返回上一页</a>
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