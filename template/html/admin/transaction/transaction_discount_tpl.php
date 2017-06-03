<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetDiscountLog();
//echo '<pre>';
//var_dump($data['group']);exit;
$conf = $obj->GetStoreDiscountConf();
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
                    <div class="panel-header">余额</div>
                    <div class="panel-body"><?php echo $data['gift_balance'];?></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default panel-success">
                    <div class="panel-header">会员已领取</div>
                    <div class="panel-body"><?php echo isset($data['group'][2])?$data['group'][2]['sum_money']:'0.00';?></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default panel-danger">
                    <div class="panel-header">会员已使用</div>
                    <div class="panel-body"><?php echo isset($data['group'][3])?$data['group'][3]['sum_money']:'0.00';?></div>
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
            <a style="text-decoration:none" class="btn btn-success radius" onClick="type_add(this)" href="javascript:;"
               title="分享"><i class="Hui-iconfont"></i>设置金额(当前<?php echo $conf['share_money']?$conf['share_money']:'未设置';?>)</a>
            <?php
                if(!empty($conf))
                {
                    ?>
                    <a style="text-decoration:none" class="ml-5"
                       onclick="coupon_qrcode('分享二维码','<?php echo $conf['share_key'];?>')"
                       href="javascript:;" title="分享二维码"><i class="Hui-iconfont">&#xe6cb;</i> 分享</a>
                    <?php
                }
            ?>
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
<!--金额-->
<div class="page-container" id="add_from" style="display: none">
    <div class="row cl">
        <label class="form-label col-sm-4" style="margin-top: 3px;cursor: text;text-align: right;"><span class="c-red">*</span>金额：</label>
        <div class="formControls col-sm-8">
            <input id="money" name="money" type="number" class="input-text" value="<?php echo $conf['share_money']?$conf['share_money']:'';?>"/>
        </div>
    </div>
</div>

<div id="container" style="display: none;text-align: center">

    <div class="panel panel-default">
        <div class="panel-header">链接二维码，可截图或者自行生成（仅限微信内使用）</div>
        <div class="panel-body">
            <div id="qrcode_img"></div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-header">领取折扣券的链接地址（可自行放到微信进行链接发放）</div>
        <div class="panel-body" id="link"></div>
    </div>

</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/qrcode/jquery.qrcode.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/qrcode/qrcode.js"></script>

<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $(function(){

    });
    function type_add(obj){
        var index = layer.open({
            type: 1,
            title: '分享金额',
            closeBtn: 0,
            area: ['300px','300px'],
            //skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: $('#add_from').show()
            ,btn: ['确认', '取消']
            ,yes: function(index){
                var money = $('#money').val();
                if(money=='')
                {
                    layer.msg('请输入金额');
                    return false;
                }
                if(money > <?php echo $data['gift_balance'];?>)
                {
                    layer.msg('金额不能大于<?php echo $data['gift_balance'];?>');
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: '?mod=admin&v_mod=transaction&_action=ActionShareMoney',
                    data:{'money':money},
                    dataType: 'json',
                    success: function(res)
                    {
                        if (res.code==0)
                        {

                        }
                        layer.msg(res.msg,{icon:res.code==1?5:6,time:1000});
                    },
                    error:function(res) {
                        console.log(res.msg);
                        alert('网络超时')
                    }
                });
                //layer.closeAll();
            }
        });
    }
    function coupon_qrcode(title,id){
        $('#qrcode_img').html('').qrcode({
            width:200,
            height:200,
            text	: '<?php echo WEBURL;?>/?mod=weixin&v_mod=coupon&_index=_discount_apply&id='+id
        });
        $('#link').html('<?php echo WEBURL;?>/?mod=weixin&v_mod=coupon&_index=_discount_apply&id='+id);
        var index = layer.open({
            type: 1,
            title: title,
            closeBtn: 0,
            area: '500px',
            //skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: $('#container').show()
        });
        //layer.full(index);
    }
</script>
</body>
</html>