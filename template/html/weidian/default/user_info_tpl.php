<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user = $obj->GetUserInfo(SYS_USERID);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>个人信息</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <link rel="stylesheet" href="/template/source/default/css/mui.picker.min.css" />
    <link rel="stylesheet"  href="/template/source/default/css/mui.picker.css" />
    <link rel="stylesheet"  href="/template/source/default/css/mui.poppicker.css" />
    <style>
        .web-info-img>img{width:2rem; height:2rem; border-radius: 50%;}
        .web-cell__ft{padding-right:20px;}
		.web-cell:before{border-top:none; left:0;}
		.web-cells:before{border-top:none;}
		.web-cells:after{border-bottom:none;}
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>
</head>
<body >

<div class="mui-content">
    <div class="web-cells" style="margin-top:0">
        <div class="web-cell web-cell_access" id="head">
            <div class="web-cell__hd">
                <label class="fr14 web-label">头像</label>
            </div>
            <div class="web-cell__bd tr">
                <a href="javascript:;" class="web-info-img">
                    <img src="<?php echo $user['headimgurl']; ?>">
                </a>
            </div>
            <div class="web-cell__ft"></div>
        </div>
        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">用户名</label>
            </div>
            <div class="web-cell__bd tr">
                <input type="text" class="web-input tr fr14" id="nickname" value="<?php echo $user['nickname'];?>" placeholder="请输入用户名">
            </div>
            <div class="web-cell__ft"></div>
        </div>
        <div class="web-cell ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">手机号码</label>
            </div>
            <div class="web-cell__bd tr">
                <input type="number" class="web-input tr fr14" maxlength="11" id="phone" value="<?php echo $user['phone'];?>" placeholder="请输入手机号码">
            </div>
            <div class="web-cell__ft"></div>
        </div>
        <!--<div class="web-cell web-cell_access ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">生日</label>
            </div>
            <div class="web-cell__bd tr">
                <input type="text" class="web-input tr fr14 select-time-btn"  data-options='{"type":"date","beginYear":1900,"endYear":2017}' value="2006-09-08" readonly placeholder="请选择生日">
            </div>
            <div class="web-cell__ft"></div>
        </div>-->
        <div class="web-cell web-cell_access ">
            <div class="web-cell__hd">
                <label class="fr14 web-label">性别</label>
            </div>
            <div class="web-cell__bd tr">
                <input type="text" id="sex" class="web-input tr fr14" value="<?php echo $user['sex']==1?'男':'女'; ?>" readonly placeholder="请选择性别">
            </div>
            <div class="web-cell__ft"></div>
        </div>
    </div>

    <div style="padding:0 10%;" class="tc mtr30">
        <a href="javascript:;" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-danger fr16" id="sumbit" style="padding:8px 60px;width: 100%; line-height: 1.7 ">修改</a>
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
                value: 'body',
                text: '男'
            }, {
                value: 'girl',
                text: '女'
            }]);
            var showUserPickerButton = doc.getElementById('sex');

            showUserPickerButton.addEventListener('tap', function (event) {
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
            var ajaxBtn = doc.getElementById('sumbit');
            ajaxBtn.addEventListener('tap',function()
            {
                var nickname = document.getElementById('nickname');
                var phone = document.getElementById('phone');
                var sex = document.getElementById('sex');
                if(nickname.value=='')
                {
                    mui.alert('请输入昵称');
                    return false;
                }
                if(phone.value=='')
                {
                    mui.alert('请输入手机');
                    return false;
                }
                if(sex.value=='')
                {
                    mui.alert('请选择性别');
                    return false;
                }
                var data = {
                    nickname:nickname.value,
                    phone:phone.value,
                    sex:sex.value
                };
                var obj = $(this);
                obj.button('loading');
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=user&_index=_info&v_shop=<?php echo $_GET['v_shop']; ?>&_action=ActionSetUserInfo",
                    data:data,
                    dataType:"json",
                    success:function (res)
                    {
                        obj.button('reset');
                        mui.toast(res.msg);
                    },
                    error:function ()
                    {
                        obj.button('reset');
                    }
                });
            },false)

        });


        var result = doc.getElementById('result'); /*$('#result')[0];*/
        var btns = doc.getElementsByClassName('select-time-btn')[0];  //$('.select-time-btn')[0];
        btns.addEventListener('tap', function() {
            var optionsJson = this.getAttribute('data-options') || '{}';
            var options = JSON.parse(optionsJson);
            var id = this.getAttribute('id');
            /*
             * 首次显示时实例化组件
             * 示例为了简洁，将 options 放在了按钮的 dom 上
             * 也可以直接通过代码声明 optinos 用于实例化 DtPicker
             */
            var picker = new $.DtPicker(options);
            picker.show(function(rs) {
                /*
                 * rs.value 拼合后的 value
                 * rs.text 拼合后的 text
                 * rs.y 年，可以通过 rs.y.vaue 和 rs.y.text 获取值和文本
                 * rs.m 月，用法同年
                 * rs.d 日，用法同年
                 * rs.h 时，用法同年
                 * rs.i 分（minutes 的第二个字母），用法同年
                 */
                btns.value =  rs.text;
                /*
                 * 返回 false 可以阻止选择框的关闭
                 * return false;
                 */
                /*
                 * 释放组件资源，释放后将将不能再操作组件
                 * 通常情况下，不需要示放组件，new DtPicker(options) 后，可以一直使用。
                 * 当前示例，因为内容较多，如不进行资原释放，在某些设备上会较慢。
                 * 所以每次用完便立即调用 dispose 进行释放，下次用时再创建新实例。
                 */
                picker.dispose();
            });
        }, false);
    })(mui,document);
	
	

	
	
</script>

</body>
</html>