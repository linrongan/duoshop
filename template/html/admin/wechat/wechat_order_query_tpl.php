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
    <title>订单查询</title>
</head>
<body>
<div class="page-container">
    <div>
        <input type="text" class="input-text" value=""
               style="width:250px" placeholder="请输入交易订单" id="out_trade_no">
        <button type="submit" id="select" class="btn btn-success radius"><i class="Hui-iconfont"></i> 查询</button>
        <a class="btn btn-success radius" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont"></i></a>
    </div>
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">订单查询</div>
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
    function SelectWeChatOrder(out_trade_no)
    {
        var index = layer.load(2, {
            shade: [1,'#fff']//0.1透明度的白色背景
        });
        var url = '/?mod=admin&v_mod=wechat&_index=_select&_action=SelectWeChatTrans';
        $.ajax({
            type:'post',
            url:url,
            data:{out_trade_no:out_trade_no},
            success:function (res)
            {
                $("#tbody").empty();
                $.each(res,function (k,val)
                {
                    TabSelResult(k,val);
                });
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

    $("#select").click(function ()
    {
        var out_trade_no = $("#out_trade_no").val();
        if(out_trade_no.length<=0)
        {
            $("#tbody").empty();
            TabSelResult('查询结果','请输入交易单号');
            return false;
        }
        SelectWeChatOrder(out_trade_no);
    });

    function TabSelResult(error_title,error_val)
    {
        $("#tbody").append('<tr> <td>'+error_title+'：</td> <td>'+error_val+'</td> </tr>');
    }
</script>
</html>