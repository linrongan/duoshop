<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetUserWithdrawDetails();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/template/source/admin/static/h-ui.admin/css/alert.css"><!--弹出层样式-->
    <title>提现详情</title>
</head>
<body>
<div class="page-container">
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">提现详情</div>
            <table class="table table-border table-bordered table-bg table-hover">
                <tr>
                    <td>用户头像：</td>
                    <td>
                        <img class="round" width="60" src="<?php echo $data['headimgurl']; ?>" alt="">
                    </td>
                </tr>
                <tr>
                    <td>用户昵称：</td>
                    <td><?php echo $data['nickname']; ?></td>
                </tr>
                <tr>
                    <td>提现订单：</td>
                    <td><?php echo $data['withdraw_partner_trade_no']; ?></td>
                </tr>
                <tr>
                    <td>提现状态：</td>
                    <td>
                        <?php
                           if( $data['withdraw_status']==0)
                           {
                               echo '待处理';
                           }elseif($data['withdraw_status']==1)
                           {
                               echo '处理中';
                           }else{
                               echo '已提现';
                           }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>提现来源：</td>
                    <td><?php echo $data['withdraw_sourse']; ?></td>
                </tr>
                <tr>
                    <td>提现金额：</td>
                    <td><?php echo $data['withdraw_money']; ?></td>
                </tr>
                <tr>
                    <td>申请时间：</td>
                    <td><?php echo $data['withdraw_apply_date']; ?></td>
                </tr>
                <?php
                    if($data['withdraw_method']==1)
                    {
                        ?>
                        <tr>
                            <td>银行：</td>
                            <td><?php echo $data['withdraw_bank_name']; ?></td>
                        </tr>
                        <tr>
                            <td>卡号：</td>
                            <td><?php echo $data['withdraw_bank_number']; ?></td>
                        </tr>
                        <tr>
                            <td>持卡人：</td>
                            <td><?php echo $data['withdraw_bank_user_name']; ?></td>
                        </tr>
                        <tr>
                            <td>持卡人身份证：</td>
                            <td><?php echo $data['withdraw_bank_user_card']; ?></td>
                        </tr>
                        <?php
                    }
                ?>
                <tr>
                    <td>默认处理方式：</td>
                    <td><?php echo $data['withdraw_method']==0?'微信转账':'银行转账'; ?></td>
                </tr>
                <?php
                if($data['withdraw_status']>0)
                {
                    ?>
                    <tr>
                        <td>已选择处理方式：</td>
                        <td><?php echo $data['back_method']==1?'微信转账':'银行转账'; ?></td>
                    </tr>
                    <?php
                }
                if($data['withdraw_status']==2)
                {
                    ?>
                    <tr>
                        <td>处理时间：</td>
                        <td><?php echo $data['withdraw_confim_date']; ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td>操作：</td>
                    <td>
                        <?php
                        if($data['withdraw_status']==0)
                        {
                            ?>
                            <select class="select" style="width: 300px;" required
                                    id="back_method" aria-required="true">
                                <option value="">请选择处理方式</option>
                                <option value="1">微信转账</option>
                                <?php
                                if($data['withdraw_method']==1)
                                {
                                    ?>
                                    <option value="2">银行转账</option>
                                    <?php
                                }
                                ?>
                            </select><br><br>
                            <a onclick="confirm_back_method(<?php echo $data['id']; ?>)" class="btn btn-primary radius">确定</a>
                            <?php
                        }elseif($data['withdraw_status']==1)
                        {
                            if($data['back_method']==1)
                            {
                                ?>
                                <a onclick="wechat_back(<?php echo $data['id']; ?>)" class="btn btn-primary radius">微信转账</a>
                                <?php
                            }else{
                                ?>
                                <a onclick="bank_back(<?php echo $data['id']; ?>)" class="btn btn-primary radius">银行转账</a>
                                <?php
                            }
                        }else{
                            ?>
                            已完成
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!--弹出层-->
<div id="modal-demo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content radius">
            <div class="modal-header">
                <h3 class="modal-title">对话框标题</h3>
                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">确定</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
    </div>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
</body>
<script>
    var page_url = '/?mod=admin&v_mod=admin_withdraw&_index=_user_details&id=<?php echo $_GET['id']; ?>';
    function confirm_back_method(id)
    {
        var back_method = $("#back_method :selected").val();
        if(back_method=='')
        {
            layer.msg('请选择处理方式');
            return false;
        }
        var data  = {
            id :id,
            back_method:back_method
        };
        request('POST',page_url+'&_action=ActionConfirmBackWay',data,'back_method');
    }

    function wechat_back(id)
    {
        var data = {
            id:id
        };
        layer.confirm('确认开始转账？', {
            btn: ['确认','取消'] //按钮
        }, function(){
            request('POST',page_url+'&_action=ActionWeChatBack',data,'');
        });
    }

    function bank_back(id)
    {
        var data = {
            id:id
        };
        layer.confirm('已确认转账？', {
            btn: ['确认','取消'] //按钮
        }, function(){
            request('POST',page_url+'&_action=ActionBankBack',data,'');
            layer.msg('的确很重要', {icon: 1});
        });
    }


    var request_status = false; //0请求暂停中  1请求中
    function request(method,url,param,type){
        if(request_status)
        {
            layer.msg('请求中');
            return false;
        }
        request_status = true;
        $.ajax({
            type:method,
            url:url,
            data:param,
            success:function (res)
            {
                request_status = false;
                if(res.code==0)
                {
                    switch (type)
                    {
                        //默认刷新页面
                        default:
                            window.parent.location.reload();
                            location.href=page_url;
                            break;
                    }
                }else{
                    layer.msg(res.msg);
                }
            },
            error:function ()
            {
                layer.msg('请求错误');
                request_status = false;
            },
            dataType:'json'
        });
    }

</script>
</html>