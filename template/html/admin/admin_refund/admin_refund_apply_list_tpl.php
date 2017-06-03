<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetRefundApplyList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>退款申请</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    财务中心
    <span class="c-gray en">&gt;</span>
    退款申请
</nav>
<div class="page-container">
    <form action="" method="post" class="mb-20">
        <div> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <select name="refund_status" id="refund_status" class="select-box select" style="width: 150px;">
                <option value="">请选择退款状态</option>
                <option <?php echo isset($_REQUEST['refund_status']) && $_REQUEST['refund_status']=='0'?'selected':''; ?> value="0">未处理</option>
                <option <?php echo isset($_REQUEST['refund_status']) && $_REQUEST['refund_status']=='3'?'selected':''; ?> value="3">通过申请</option>
                <option <?php echo isset($_REQUEST['refund_status']) && $_REQUEST['refund_status']=='5'?'selected':''; ?> value="5">成功退款</option>
                <option <?php echo isset($_REQUEST['refund_status']) && $_REQUEST['refund_status']=='6'?'selected':''; ?> value="6">拒绝退款</option>
            </select>
            <input type="text" class="input-text" style="width:200px" value="<?php echo isset($_REQUEST['keyword'])?$_REQUEST['keyword']:'';?>"
                   placeholder="店铺、退款单号、交易单号" id="" name="keyword">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <a class="btn btn-success radius" href="javascript:location.replace(location.href);" title="刷新" >
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </div>
    </form>
    <div class="mt-20">
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
                                if($item['refund_status']==0){
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
                            <a href="javascript:;" onclick="refund_details('查看详情','?mod=admin&v_mod=admin_refund&_index=_apply_details&id=<?php echo $item['id'];?>')" title="详情"  class="ml-5"
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
</div>
<div id="qrcode_img" style="display: none;text-align: center"></div>


<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click","0");
    });

    //详情
    function refund_details(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    //编辑
    function banner_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }

    /*-删除*/
    function banner_del(obj,id,type){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_shop&_action=ActionDelHomeData',
                data:{id:id,type:type},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==1?5:6,time:1000});
                    if(data.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }

    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    <?php
    }
    ?>
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>