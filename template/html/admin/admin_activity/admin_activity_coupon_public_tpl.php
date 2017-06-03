<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getStoreCouponType();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>优惠卷类型管理</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    营销管理
    <span class="c-gray en">&gt;</span>
    优惠卷列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">分类</th>
                <th width="80">优惠券名称	</th>
                <th width="80">优惠金额</th>
                <th width="80">最低消费金额</th>
                <th width="120">有效期</th>
                <th width="80">状态</th>
                <th width="80">链接</th>
                <th width="40">首页显示</th>
                <th width="80">编辑</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data)
            {
                foreach($data as $item)
                {
                    ?>
                    <tr class="text-c">
                        <th><?php echo $item['type_name']; ?></th>
                        <td><?php echo $item['coupon_name']; ?></td>
                        <td><?php echo $item['coupon_money']; ?></td>
                        <td><?php echo $item['min_money']; ?></td>
                        <td><?php echo $item['start_time'].'<br>-<br>'.$item['end_time']; ?></td>
                        <td><?php echo $item['default_sent']==0?'<span class="label label-default radius">暂停发放</span>':'<span class="label label-success radius">正常</span>'; ?></td>
                        <td>
                            <a style="text-decoration:none" class="ml-5" onClick="coupon_qrcode('优惠卷链接','<?php echo $item['coupon_key']; ?>')" href="javascript:;" title="优惠卷链接"><i class="Hui-iconfont">&#xe6f1;</i></a>
                        </td>
                        <td class="td-manage">
                        <?php echo $item['is_show']?"不显示":"显示"; ?>
                        </td>
                        <td class="td-manage">
                            <?php if ($item['is_show']){?>
                                <a style="text-decoration:none" class="ml-5" href="?mod=admin&v_mod=admin_activity&_index=_coupon_public&_action=ShowHideHomeIndex&is_show=0&id=<?php echo $item['tid']; ?>" title="设置为显示在首页">
                                    设为显示
                                </a>
                            <?php }else
                            {?>
                                <a style="text-decoration:none" class="ml-5" href="?mod=admin&v_mod=admin_activity&_index=_coupon_public&_action=ShowHideHomeIndex&is_show=1&id=<?php echo $item['tid']; ?>"  title="设置为不显示在首页">
                                    设为不显示
                                </a>
                            <?php } ?>
                            &nbsp;
                            <a style="text-decoration:none" class="ml-5" onClick="coupon_del(this,<?php echo $item['tid']; ?>)" href="javascript:;" title="删除">
                                删除</a>
                        </td>
                    </tr>
                <?php
                }
            }
            ?>
            </tbody>
        </table>
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
        <div class="panel-header">领取优惠券的链接地址（可自行放到微信进行链接发放）</div>
        <div class="panel-body" id="link"></div>
    </div>

</div>


<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/qrcode/jquery.qrcode.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/qrcode/qrcode.js"></script>

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

    function coupon_qrcode(title,id){
        $('#qrcode_img').html('').qrcode({
            width:200,
            height:200,
            text	: '<?php echo WEBURL;?>/?mod=weixin&v_mod=coupon&_index=_apply&id='+id
        });
        $('#link').html('<?php echo WEBURL;?>/?mod=weixin&v_mod=coupon&_index=_apply&id='+id);
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

    /*图片-添加*/
    function coupon_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_activity&_action=ActionDelStoreCoupon',
                data:{'id':id},
                dataType: 'json',
                success: function(res)
                {
                    if (res.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                    layer.msg(res.msg,{icon:res.code==1?5:6,time:1000});
                },
                error:function(res) {
                    console.log(res.msg);
                    alert('网络超时')
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