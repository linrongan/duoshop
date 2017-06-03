<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
require_once RPC_DIR.'/module/mobile/weixin/user.php';
$user_Obj = new user($_REQUEST);
$BankCard = $user_Obj->GetBankCardList();
$user = $obj->GetUserInfo(SYS_USERID);
$money_out_num = $obj->GetToMonthMoneyOutNum();
$conf_money_out_nums = $obj->GetWebConf('month_withdrawals');
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>余额提现</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css?6666">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/weui.min.css">
    <!--
   <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/jquery-weui.min.css">-->
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css?6666">
    <style>
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell:first-child::before{border-top:none}
        .web-cell:before{left:0;}
        .weui-not_link:before,.weui-not_link:after,.weui-not_link .weui-cell:after{border:none;}
        .weui-not_link .weui-cell:before{left:0;}
        .mui-btn-null{color: #fff;  border: 1px solid #CCC;  background-color: #CCC;}
        .web-cell_select .web-cell__bd:after {
            content: " ";
            display: inline-block;
            height: 6px;
            width: 6px;
            border-width: 2px 2px 0 0;
            border-color: #C8C8CD;
            border-style: solid;
            -webkit-transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
            transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
            position: relative;
            top: -2px;
            position: absolute;
            top: 50%;
            right: 15px;
            margin-top: -4px;
        }
        .weui-picker-modal .picker-items{font-size:.8rem;}
        .weui-bank_checkbox{}
        .weui-bank_checkbox>.weui-cell{padding:.5rem 3%;}
        .weui-bank_checkbox>.weui-cell>.weui-cell__bd{padding:.5rem 5%; background:#f7f7f7; border-radius:5px;}
        .weui-cells_checkbox .weui-icon-checked:before{font-size:20px;}
        .mui-input-group .mui-input-row:after{left:0;}
        .mui-checkbox.mui-left input[type=checkbox], .mui-radio.mui-left input[type=radio]{left:3%; width:20px; height:18px; top: 50%;  margin-top: -9px;}
        .mui-checkbox input[type=checkbox]:before, .mui-radio input[type=radio]:before{font-size:20px;}
        .mui-input-group .mui-input-row{height:auto;}
        .mui-checkbox input[type=checkbox]:checked:before, .mui-radio input[type=radio]:checked:before{color:#4cd964;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body >
<div class="mui-content">
    <div class="web-wallet-body">
        <div class="web-cells">
            <div style="padding:.5rem 3%;" class="fr14 cl_b3">余额提现(本月可提现次数<?php echo $conf_money_out_nums-$money_out_num['count']; ?>)</div>
            <div class="web-cell" style="border-bottom:1px solid #e8e8e8;" >
                <div class="web-cell__hd">
                    <label class="web-label fr18" style="min-width:2rem;">￥</label>
                </div>
                <div class="web-cell__bd">
                    <input type="number" id="money" value="" max-out-count="<?php echo $conf_money_out_nums-$money_out_num['count'];?>"
                           max-money="<?php echo $user['user_money']; ?>" class="web-input" placeholder="最低提现金额10元起">
                </div>
                <div class=" fr">
                    <button type="button" id="all_get" class="mui-btn mui-btn-success mui-btn-outlined">全部提现</button>
                </div>
            </div>

            <div class="mui-card" style="margin:0; box-shadow:none;display: none" id="bank_div">
                <div class="mui-input-group" id="bank">
                    <?php
                    if($BankCard)
                    {
                        $Number = 0;
                        foreach($BankCard as $item)
                        {
                            ++ $Number;
                            ?>
                            <div class="mui-input-row mui-radio mui-left">
                                <label class="weui-cells weui-not_link" style="padding:.75rem 3% .5rem 40px; margin-top:0;">
                                    <div class="weui-cell" style=" background:#f4f4f4; border-radius:5px;">
                                        <div class="weui-cell__bd">
                                            <h1 class="fr16"><?php echo $item['bank_name']; ?></h1>
                                            <p class="fr14 mt5">持卡人：<?php echo $item['bank_username']; ?></p>
                                            <p class="tr fr14 mt10" style="color:#333;"><?php echo $user_Obj->GetCardTran($item['bank_card_number']) ?></p>
                                        </div>
                                    </div>
                                </label>
                                <input name="bank_id" value="<?php echo $item['id']; ?>" <?php if($Number==1){echo 'checked';} ?> type="radio">
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <p style="padding:.5rem 3%;" class="fr12 cl_b9">最大提现余额：<?php echo $user['user_money']; ?>元</p>
        </div>

        <div class="web-cells" style="display: none" id="add-bank">
            <a href="?mod=weixin&v_mod=user&_index=_bank_card_new&return=<?php echo urlencode('/?mod=weixin&v_mod=wallet&_index=_money_out'); ?>" class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <img src="/template/source/default/images/plur.png" style="width:1.25rem; height: 1.25rem; display: block; margin-right:10px;">
                </div>
                <div class="web-cell__bd">
                    <span class="fr14">添加更多银行卡</span>
                </div>
                <div class="web-cell__ft"></div>
            </a>
        </div>

        <div style="padding:0 10%;" class="tc mtr30">
            <a href="javascript:;" onclick="GetMoney(this)" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-success fr16" style="padding:8px 60px;width: 100%; line-height: 1.7 ">
                确认提现
            </a>
        </div>
    </div>
</div>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/js/jquery-weui.min.js"></script>
<script>
    var user_money = $("#money").attr("max-money");
    var can_out_count = $("#money").attr("max-out-count");
    function money_out(obj)
    {
        var that = $(obj);
        mui(that).button('loading');
        var out_money = $("#money").val();
        var bank_id = $('input:radio:checked').val();
        if(bank_id==undefined || isNaN(bank_id))
        {
            mui.alert('请选择或绑定银行卡');
            mui(that).button('reset');
            return false;
        }
        if(out_money>user_money)
        {
            mui.alert('提现金额不能超过现有金额');
            mui(that).button('reset');
            return false;
        }
        if(out_money<1)
        {
            mui.alert('提现金额不能低于1');
            mui(that).button('reset');
            return false;
        }
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'<?php echo _URL_; ?>&_action=ActionMoneyOut',
                dataType:'json',
                data:{out_money:out_money,bank_id:bank_id},
                success:function (data)
                {
                    mui(that).button('reset');
                    mui.toast(data.msg);
                    if(data.code==0)
                    {
                        location.href='/?mod=weixin&v_mod=wallet&_index=_profit';
                    }
                },
                error:function ()
                {
                    mui(that).button('reset');
                }
            });
            clearInterval(count_down);
        },1000);
    }


    function MoneyChange(money)
    {
        if(money>1000)
        {
            if($("#bank").children().length>0)
            {
                if($("#bank").children().length<3)
                {
                    $("#add-bank").show();
                }
                $("#bank_div").show();
            }else{
                $("#add-bank").show();
            }
        }else{
            $("#bank_div").hide();
            $("#add-bank").hide();
        }
    }

    $("#money").keyup(function ()
    {
        var reg_val = $(this).val().match(/\d+\.?\d{0,2}/);
        var val = '';
        if (reg_val != null)
        {
            val = reg_val[0];
        }
        if(val>user_money)
        {
            val = user_money;
        }
        MoneyChange(val);
        $(this).val(val);
    }).change(function ()
    {
        $(this).keyup();
    });

    $("#all_get").click(function ()
    {
        if($("#money").val()!=$("#money").attr("max-money"))
        {
            $("#money").val($("#money").attr("max-money"));
            MoneyChange($("#money").attr("max-money"));
        }
    });


    function GetMoney(obj)
    {
        var that = $(obj);
        mui(that).button('loading');
        var money = $("#money").val();
        var bank_id = null;
        var request = true;
        if(can_out_count<=0)
        {
            mui.alert('本月提现次数已用完');
            mui(that).button('reset');
            return false;
        }
        if(user_money<10)
        {
            mui(that).button('reset');
            mui.toast('可提现金额不足');
            return false;
        }
        if(money.length<=0)
        {
            mui(that).button('reset');
            mui.toast('请输入提现金额');
            return false;
        }
        if(money<10)
        {
            mui(that).button('reset');
            mui.toast('最低提现金额不能低于10元');
            return false;
        }
        if(money>1000)
        {
            if($("#bank").children().length<=0)
            {
                mui(that).button('reset');
                mui.toast('请添加银行卡');
                return false;
            }
            bank_id = $('input:radio[name="bank_id"]:checked').val();
            if(!bank_id || isNaN(bank_id))
            {
                mui(that).button('reset');
                mui.toast('请选择银行卡');
                return false;
            }
        }
        var count_down = setTimeout(function ()
        {
            $.ajax({
                type:'post',
                url:'<?php echo _URL_; ?>&_action=ActionUserMoneyOut',
                dataType:'json',
                data:{money:money,bank_id:bank_id},
                success:function (data)
                {
                    mui(that).button('reset');
                    mui.toast(data.msg);
                    if(data.code==0)
                    {
                        location.href='/?mod=weixin&v_mod=wallet';
                    }
                },
                error:function ()
                {
                    mui(that).button('reset');
                }
            });
            clearInterval(count_down);
        },1000);
    }
</script>
</body>
</html>