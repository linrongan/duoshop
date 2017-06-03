<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->getCouponByCategory();
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
    优惠卷类型管理
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">

        <a href="javascript:;" onclick="javascript :history.back(-1);" class="btn btn-success-outline radius">返回</a>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">优惠券名称	</th>
                <th width="80">优惠金额</th>
                <th width="80">最低消费金额</th>
                <th width="80">状态</th>
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
                        <td><?php echo $item['coupon_name']; ?></td>
                        <td><?php echo $item['coupon_money']; ?></td>
                        <td><?php echo $item['min_money']; ?></td>
                        <td><?php echo $item['default_sent']==0?'<span class="label label-default radius">不发放</span>':'<span class="label label-success radius">发放</span>'; ?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="type_add(this,'<?php echo $item['coupon_name']; ?>','<?php echo $item['id']; ?>')" href="javascript:;"
                               title="认领操作">确定认领</a>
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

<div class="page-container" id="add_from" style="display: none">
    <div class="row cl">
        <label class="form-label col-xs-4 "><span class="c-red">*</span>优惠卷名称：</label>
        <div class="formControls col-xs-8 ">
            <input id="coupon_name" name="coupon_name" type="text" class="input-text" value=""/>
        </div>
    </div>
    <div class="row cl mt-20">
         <label class="form-label col-xs-4 "><span class="c-red">*</span>优惠卷起止时间：</label>
          <div class="formControls col-xs-8 ">
            <input type="text" onfocus="WdatePicker({minDate:'%y-%M-%d %H:%m:%s'})" id="datemin" name="start_time" value="" class="input-text Wdate" style="width:160px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate :'#F{$dp.$D(\'datemin\')}' })" id="datemax" name="end_time" value="" class="input-text Wdate" style="width:160px;">

          </div>
    </div>
</div>

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
        $("#check-form").validate({
            rules:{
                start_time:{
                    required:true
                },
                end_time:{
                    required:true
                },
                coupon_name:{
                    required:true
                }
            }
        });
    });


    /*图片-添加*/
    function type_add(obj,name,id){
        $('#coupon_name').val(name);
        var index = layer.open({
            type: 1,
            title: '认领优惠卷',
            closeBtn: 0,
            area: ['600px','300px'],
            //skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: $('#add_from').show()
            ,btn: ['确认', '取消']
            ,yes: function(index){
                var start_time = $('#datemin').val();
                var end_time = $('#datemax').val();
                var coupon_name = $('#coupon_name').val();
                $.ajax({
                    type: 'POST',
                    url: '?mod=admin&v_mod=activity&_action=ActionAddStoreCoupon',
                    data:{'id':id,'start_time':start_time,'end_time':end_time,'coupon_name':coupon_name},
                    dataType: 'json',
                    success: function(res)
                    {
                        if (res.code==0)
                        {
                            $(obj).parents("tr").remove();
                            layer.closeAll();
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

        /*layer.confirm('确认要添加吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=activity&_action=ActionAddStoreCoupon',
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
        });*/
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