<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/template/source/admin/static/h-ui.admin/css/alert.css"><!--弹出层样式-->
    <title>物流跟踪</title>
</head>
<body>
<div class="page-container">
    <div>
        <input type="number" class="input-text" value="<?php echo isset($_GET['logistics_number']) && !empty($_GET['logistics_number'])?$_GET['logistics_number']:''; ?>"
               style="width:250px" placeholder="请输入查询物流单号" id="logistics_number">
        <button type="submit" id="select" class="btn btn-success radius"><i class="Hui-iconfont"></i> 查询</button>
        <a class="btn btn-success radius" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont"></i></a>
    </div>
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">物流查询</div>
            <table class="table table-border table-bordered table-bg table-hover">
                <tbody id="tbody">

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
</body>
<script>
    //查询物流
    var logistics_number = $("#logistics_number").val();
    if(logistics_number.length>0 && !isNaN(logistics_number))
    {
        LoadLogistics(logistics_number);
    }else{
        <?php
            if(isset($_GET['select']))
            {
                ?>
        $("#tbody").empty();
        TabSelResult('查询结果','查询 失败 缺少关键参数');
        <?php
            }
        ?>
    }
    function TabSelResult(error_title,error_val)
    {
        $("#tbody").append('<tr> <td>'+error_title+'：</td> <td>'+error_val+'</td> </tr>');
    }

    $("#select").click(function ()
    {
        var logistics_number = $("#logistics_number").val();
        if(logistics_number.length>0 && !isNaN(logistics_number))
        {
            LoadLogistics(logistics_number);
        }else{
            $("#tbody").empty();
            TabSelResult('查询结果','查询 失败 缺少关键参数');
        }
    });

    function LoadLogistics(logistics_number)
    {
        var index = layer.load(2, {
            shade: [1,'#fff']//0.1透明度的白色背景
        });
        var url = '/?mod=admin&v_mod=admin_logistics&_index=_select&_action=Selectlogistics';
        $.ajax({
            type:'post',
            url:url,
            data:{logistics_number:logistics_number},
            success:function (res)
            {
                $("#tbody").empty();
                TabSelResult('查询结果',res.msg);
                if(res.status==0)
                {
                    var result = res.result;
                    if(result.issign==0)
                    {
                        var issign = '未签收';
                    }else{
                        var issign = '已签收';
                    }
                    if(result.deliverystatus==1)
                    {
                        var deliverystatus = '在途中';
                    }else if(result.deliverystatus==2)
                    {
                        var deliverystatus = '派件中';
                    }else if(result.deliverystatus==3)
                    {
                        var deliverystatus = '已签收';
                    }else if(result.deliverystatus==4)
                    {
                        var deliverystatus = '派送失败(拒签等)';
                    }
                    TabSelResult('物流单号',result.number);
                    TabSelResult('物流类型',result.type);
                    TabSelResult('签收状态',issign);
                    TabSelResult('物流状态',deliverystatus);
                    var list = '';
                    if(result.list.length>0)
                    {
                        var result_list = result.list;
                        var list_len = result_list.length-1;
                        for(var i=list_len;i>=0;i--)
                        {
                            list += '<tr> <td>'+result_list[i].time+'：</td> <td>'+result_list[i].status+'</td> </tr>';
                        }
                        $("#tbody").append(list);
                    }
                }
                layer.close(index);
            },
            error:function (err)
            {
                $("#tbody").empty();
                TabSelResult('查询结果','查询超时');
            },
            dataType:'json'
        });
    }
</script>
</html>