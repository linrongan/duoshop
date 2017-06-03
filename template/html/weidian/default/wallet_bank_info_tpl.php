<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>添加银行卡</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <link rel="stylesheet" href="/template/source/default/css/mui.picker.min.css" />
    <link rel="stylesheet"  href="/template/source/default/css/mui.poppicker.css" />
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
                    <label class="fr14 web-label">持卡人</label>
                </div>
                <div class="web-cell__bd tr">
                    <input type="text" class="web-input tr fr14" id="bank_card_uname" value="" placeholder="请输入持卡人">
                </div>
                <div class="web-cell__ft"></div>
            </div>

            <div class="web-cell ">
                <div class="web-cell__hd">
                    <label class="fr14 web-label">银行类型</label>
                </div>
                <div class="web-cell__bd tr">
                    <input type="text" class="web-input tr fr14" id="bank_card_name" value="" readonly  placeholder="请选择银行类型 >">
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
                    <input type="number" class="web-input tr fr14" id="card_uid" value="" placeholder="请输入身份证号码">
                </div>
                <div class="web-cell__ft"></div>
            </div>
        </div>
        <div style="padding:0 10%;" class="tc mtr30">
            <a href="javascript:;" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-success fr16" id="sumbit" style="padding:8px 60px;width: 100%; line-height: 1.7 ">添加</a>
        </div>
	</div>

	<script src="/template/source/default/js/mui.min.js"></script>
    <script src="/template/source/default/js/mui.picker.min.js"></script>
    <script src="/template/source/default/js/mui.poppicker.js"></script>
    <script>
        (function($,doc) {
            $.init();
            $.ready(function() {
                //普通示例
                var userPicker = new $.PopPicker();
                userPicker.setData([{
                    value: '1',
                    text: '广州农商银行'
                }, {
                    value: '2',
                    text: '中国银行'
                }, {
                    value: '3',
                    text: '中国建设银行'
                }, {
                    value: '4',
                    text: '中国平安银行'
                }, {
                    value: '5',
                    text: '广州农业银行'
                }]);
                var showBank = doc.getElementById('bank_card_name');
                showBank.addEventListener('tap', function (event) {
                    var that = this;
                    userPicker.show(function (items) {
                        var d = JSON.stringify(items[0].text);
                        d = d.replace(/\"/g, "");
                        that.value = d;
                        //返回 false 可以阻止选择框的关闭
                        //return false;
                    });
                }, false);

                //这里执行表单提交
                doc.getElementById('sumbit').addEventListener('tap',function ()
                {
                    var bank_card_uname = doc.getElementById('bank_card_uname').value;
                    var bank_card_name = doc.getElementById('bank_card_name').value;
                    var bank_card_number = doc.getElementById('bank_card_number').value;
                    var card_uid = doc.getElementById('card_uid').value;
                    var obj = $(this);
                    if(bank_card_uname=='')
                    {
                        $.alert('请输入持卡人');
                        return false;
                    }
                    if(bank_card_name=='')
                    {
                        $.alert('选择银行');
                        return false;
                    }
                    if(bank_card_number=='')
                    {
                        $.alert('请输入银行卡号');
                        return false;
                    }
                    if(card_uid=='')
                    {
                        $.alert('请输入持卡人身份证号');
                        return false;
                    }
                    var data = {
                        bank_card_uname:bank_card_uname,
                        bank_card_name:bank_card_name,
                        bank_card_number:bank_card_number,
                        card_uid:card_uid
                    };
                    obj.button('loading');
                    $.ajax({
                        type:"post",
                        url:'<?php echo _URL_; ?>&_action=ActionNewBankCard',
                        data:data,
                        dataType:"json",
                        success:function (res)
                        {
                            obj.button('reset');
                            $.toast(res.msg);
                            if(res.code==0)
                            {
                                history.back();
                            }
                        },
                        error:function ()
                        {
                            obj.button('reset');
                            $.toast('网络超时');
                        }
                    });
                    /*$(this).button('reset');*/
                });
            })

        })(mui,document);
    </script>
</body>
</html>