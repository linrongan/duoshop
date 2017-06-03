<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$select_bank_link ='?mod=weixin&v_mod=user&_index=_bank_select&callback='.urlencode('/?mod=weixin&v_mod=user&_index=_bank_card_new');
if(isset($_GET['return']) && !empty($_GET['return']))
{
    $select_bank_link .= '&return='.urlencode($_GET['return']);
}
if(!isset($_GET['bank_id']) || empty($_GET['bank_id']))
{
    redirect($select_bank_link);
}
$bank = $obj->GetOneBank(intval($_GET['bank_id']));
if(empty($bank))
{
    redirect($select_bank_link);
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>添加银行卡</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/weixin/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/weixin/css/rest.css">
    <link rel="stylesheet" href="/template/source/weixin/css/main.css">
    <link rel="stylesheet" href="/template/source/weixin/css/mui.picker.min.css" />
    <link rel="stylesheet"  href="/template/source/weixin/css/mui.poppicker.css" />
    <style>
        .web-cells:before,.web-cells:after,.web-cell:before{border:none;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body >

<div class="mui-content">
    <div class="web-cells" style="margin-top:0">
        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">银行类型</label>
            </div>
            <div class="web-cell__bd tr">
                <a href="<?php echo $select_bank_link; ?>" class="fr fr14"><?php echo $bank['bank_name']; ?></a>
                <input type="hidden"  id="bank_id" value="<?php echo $bank['id']; ?>">
            </div>
            <div class="web-cell__ft"></div>
        </div>

        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">持卡人</label>
            </div>
            <div class="web-cell__bd tr">
                <input type="text" class="web-input tr fr14" id="bank_username" value="" placeholder="请输入持卡人">
            </div>
            <div class="web-cell__ft"></div>
        </div>

        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">银行卡号</label>
            </div>
            <div class="web-cell__bd tr">
                <input type="number" class="web-input tr fr14" id="bank_card_number" value="" placeholder="请输入银行卡号">
            </div>
            <div class="web-cell__ft"></div>
        </div>
        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">身份证号码</label>
            </div>
            <div class="web-cell__bd tr">
                <input type="number" class="web-input tr fr14" id="bank_user_card" value="" placeholder="请输入身份证号码">
            </div>
            <div class="web-cell__ft"></div>
        </div>
    </div>
    <div style="padding:0 10%;" class="tc mtr30">
        <a href="javascript:;" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-success fr16" id="sumbit" style="padding:8px 60px;width: 100%; line-height: 1.7 ">添加</a>
    </div>
</div>

<script src="/template/source/weixin/js/mui.min.js"></script>
<script src="/template/source/weixin/js/mui.picker.min.js"></script>
<script src="/template/source/weixin/js/mui.poppicker.js"></script>
<script>
    $(function ()
    {
        $("#sumbit").click(function ()
        {
            var bank_id = $('#bank_id').val();
            var bank_username = $('#bank_username').val();
            var bank_card_number = $('#bank_card_number').val();
            var bank_user_card =$('#bank_user_card').val();
            var that = $(this);
            mui(that).button('loading');
            if(bank_id=='')
            {
                mui.alert('选择银行');
                mui(that).button('reset');
                return false;
            }
            if(bank_username=='')
            {
                mui.alert('请输入持卡人');
                mui(that).button('reset');
                return false;
            }
            if(bank_card_number=='')
            {
                mui.alert('请输入银行卡号');
                mui(that).button('reset');
                return false;
            }
            if(bank_user_card=='')
            {
                mui.alert('请输入持卡人身份证号');
                mui(that).button('reset');
                return false;
            }
            var data = {
                bank_id:bank_id,
                bank_username:bank_username,
                bank_card_number:bank_card_number,
                bank_user_card:bank_user_card
            };
            $.ajax({
                type:"post",
                url:'<?php echo _URL_; ?>&_action=ActionNewBankCard',
                data:data,
                dataType:"json",
                success:function (res)
                {
                    mui(that).button('reset');
                    mui.toast(res.msg);
                    if(res.code==0)
                    {
                        <?php
                            if(isset($_GET['return']) && !empty($_GET['return']))
                            {
                                ?>
                        location.href='<?php echo $_GET['return']; ?>';
                        <?php
                            }else{
                                ?>
                        location.href='/?mod=weixin&v_mod=user&_index=_bank_card';
                        <?php
                    }
                        ?>
                    }else{
                        mui.toast('添加失败');
                    }
                },
                error:function ()
                {
                    mui(that).button('reset');
                    $.toast('网络超时');
                }
            });
        })
    });
</script>
</body>
</html>