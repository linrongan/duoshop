<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetOrderDetails();
$logistics = $obj->GetLogisticsList();
//echo '<pre>';
//var_dump($logistics);exit;
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
                            <?php echo $data['order']['order_ship_qu']; ?><br>
                            <?php echo $data['order']['order_ship_address']; ?>
                        </div>
                    </div>
                    <?php
                        //有退款产品
                        if($data['order']['refund_status']==1)
                        {
                            ?>
                            <div class="row cl mt-10">
                                <div class="col-xs-8 col-sm-8">
                                    <span class="c-red">* 该订单有退款产品</span>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    <?php
                        if($data['order']['order_status']>2){
                            ?>
                            <div id="wuliu" >
                                <div class="row cl mt-10">
                                    <label class="form-label col-xs-4 col-sm-3">物流公司：</label>
                                    <div class="formControls col-xs-8 col-sm-6">
                                        <select name="logistics_name" id="logistics_name" class="select select-box">
                                            <option value="">请选择物流公司</option>
                                            <?php
                                                foreach($logistics as $item)
                                                {
                                                    ?>
                                                    <option <?php echo $data['order']['logistics_name']==$item['logistics_name']?'selected':''; ?>
                                                        value="<?php echo $item['logistics_name'];?>"><?php echo $item['logistics_letter'].'——'.$item['logistics_name'];?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row cl mt-10">
                                    <label class="form-label col-xs-4 col-sm-3">货运单号：</label>
                                    <div class="formControls col-xs-8 col-sm-6">
                                        <input type="text" class="input-text" maxlength="32" value="<?php echo $data['order']['logistics_number']; ?>" placeholder="" id="logistics_number">
                                    </div>
                                </div>
                                <div class="row cl mt-10">
                                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                                        <input class="btn btn-primary radius" onclick="save_logistics(this,<?php echo $data['order']['orderid']; ?>);" type="submit" value="&nbsp;&nbsp;确定&nbsp;&nbsp;">
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    ?>

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
                        <label class="form-label col-xs-4 col-sm-3">支付方式：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <?php
                                if($data['order']['pay_method']==0){
                                    echo '微信支付';
                                }elseif($data['order']['pay_method']==1){
                                    echo '余额支付';
                                }
                            ?>
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
                            <span class="select-box" style="width: 200px">
                                <select class="select" size="1" id="order_status">
                                    <?php
                                        foreach ($Sys_Order_Status as $k=>$v)
                                        {
                                            ?>
                                            <option <?php if($k<$data['order']['order_status']){echo 'disabled';} echo $data['order']['order_status']==$k?'selected':''; ?> value="<?php echo $k; ?>"><?php echo $v; ?><?php echo $data['order']['order_status']==$k?'--当前':''; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="row cl mt-10">
                        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                            <input class="btn btn-primary radius" onclick="ChangeOrderStatus(<?php echo $_GET['orderid']; ?>)" type="submit" value="&nbsp;&nbsp;确定&nbsp;&nbsp;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">订单产品</div>
            <div class="panel-body">
                <table class="table table-border table-bordered">
                    <thead>
                    <tr class="text-c">
                        <th>产品图</th>
                        <th>产品名称</th>
                        <th>产品属性</th>
                        <th>单价*数量</th>
                        <th>合计</th>
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
                                    <?php echo $item['product_attr_name']?$item['product_attr_name']:'默认'; ?>
                                </td>
                                <td>
                                    <?php echo $item['product_price'].'x'.$item['product_count']; ?>
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
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
</body>
<script>
   var old_order_status = $("#order_status option:selected").val();
    function ChangeOrderStatus(orderid)
    {
        var order_status = $("#order_status option:selected").val();
        if(order_status==old_order_status)
        {
            alert('订单状态未发生改变');
            return false;
        }
        var order_status_text = $("#order_status option:selected").html();
        layer.confirm('确定更改订单状态为'+order_status_text+'?',function(index)
        {
            $.ajax({
                type:'post',
                url:'?mod=admin&v_mod=order&_action=ActionChangeOrderStatus',
                dataType: 'json',
                data:{orderid:orderid,order_status:order_status},
                success:function (data)
                {
                    layer.msg(data.msg,{icon:data.code==0?6:5,time:1000});
                    if(data.code==0)
                    {
                        if(order_status>=3 && old_order_status<3)
                        {
                            $("#wuliu").show();
                        }else{
                            $("#wuliu").hide();
                        }
                        layer.close(index);
                    }
                },
                error:function (data)
                {
                    console.log(data);
                }
            });
        });
    }

    function save_logistics(obj,orderid)
    {
        if($(obj).parent().parent().css('display')=='block')
        {
            var logistics_name = $("#logistics_name").val();
            var logistics_number = $("#logistics_number").val();
            if(logistics_name=='')
            {
                $("#logistics_name").focus();
                layer.msg('请输入物流公司',{icon:5,time:1000});
                return false;
            }
            if(logistics_number=='')
            {
                $("#logistics_number").focus();
                layer.msg('请输入物流编号',{icon:5,time:1000});
                return false;
            }
            layer.confirm('确定物流信息无误？',function(index)
            {
                $.ajax({
                    type:'post',
                    url:'?mod=admin&v_mod=order&_action=ActionChangeLogistics',
                    dataType: 'json',
                    data:{orderid:orderid,logistics_number:logistics_number,logistics_name:logistics_name},
                    success:function (data)
                    {
                        layer.msg(data.msg,{icon:data.code==0?6:5,time:1000});
                        if(data.code==0)
                        {
                            layer.close(index);
                        }
                    },
                    error:function (data)
                    {
                        console.log(data);
                    }
                });
            });
        }
    }
</script>
</html>