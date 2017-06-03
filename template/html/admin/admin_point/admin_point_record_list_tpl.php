<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetPointRecordList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>积分礼品</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    积分管理
    <span class="c-gray en">&gt;</span>
    礼品兑换记录
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <div class="codeView cl pd-5 bg-1 bk-gray mt-20 mb-20">
        <div class="clearfix">
            <form method="post" action="">
                <input style="width: 150px;" class="input-text" type="text" value="" placeholder="输入礼品名字搜索" name="name">
                <button type="submit" class="btn btn-success" id="search_button">查询</button>
                <a href="/?mod=admin&v_mod=admin_point&_index=_record_list" class="btn btn-default">取消</a>
            </form>
        </div>
    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">订单号码</th>
                <th width="80">兑换用户</th>
                <th width="40">礼品数量</th>
                <th width="80">使用积分</th>
                <th width="100">下单时间</th>
                <th width="100">下单地址</th>
                <th width="80">收货人</th>
                <th width="80">联系电话</th>
                <th width="80">发货状态</th>
                <th width="80">编辑</th>
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
                        <td><?php echo $item['orderid'] ?></td>
                        <td><?php echo $item['nickname']; ?></td>
                        <td >
                            <?php echo $item['total_qty']; ?>
                        </td>
                        <td> <?php echo $item['total_point']; ?></td>
                        <td><?php echo $item['addtime'] ?></td>
                        <td><i class="Hui-iconfont"><?php echo $item['address'] ?></td>
                        <td><?php echo $item['username'] ?></td>
                        <td><?php echo $item['phone'] ?></td>
                        <td> <?php echo $item['ship_status']>3?'<span class="label label-success radius">已发货</span>':'<span class="label label-default radius">未发货</span>';?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="record_edit('礼品编辑','?mod=admin&v_mod=admin_point&_index=_record_edit',<?php echo $item['orderid']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
<!--                            <a style="text-decoration:none" class="ml-5" onClick="record_del(this,--><?php //echo $item['id']; ?><!--,1)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>-->
                            <?php
                                if($item['ship_status']>3)
                                {
                                    ?>
                                    <a onclick="sel_logistics('<?php echo $item['wuliu_no'] ?>')" class="btn btn-default radius">物流追踪</a>
                                    <?php
                                }
                            ?>
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
    });


    //
    function record_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id,
            end:function(){
                window.location.reload();
            }
        });
        layer.full(index);
    }

    /*-删除*/
    function record_del(obj,id,type){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=admin_point&_action=ActionDelRecord',
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

    //查询物流
    function sel_logistics(number)
    {
        var index = layer.open({
            type: 2,
            title: '物流追踪',
            content: '/?mod=admin&v_mod=admin_logistics&_index=_select&select&logistics_number='+number
        });
        layer.full(index);
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