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
        <?php
            if(!empty($user['pay_password']))
            {
                ?>
                <div class="web-cell ">
                    <div class="web-cell__hd">
                        <label class="fr14 web-label">原支付密码</label>
                    </div>
                    <div class="web-cell__bd tr">
                        <input type="password" class="web-input tr fr14" maxlength="6" id="password1" value="" placeholder="请输入原密码">
                    </div>
                    <div class="web-cell__ft"></div>
                </div>
                <div class="web-cell ">
                    <div class="web-cell__hd">
                        <label class="fr14 web-label">新支付密码</label>
                    </div>
                    <div class="web-cell__bd tr">
                        <input type="password" class="web-input tr fr14" maxlength="6" id="password2" value="" placeholder="请输入新密码">
                    </div>
                    <div class="web-cell__ft"></div>
                </div>
                <?php
            }else
            {
                ?>
                <div class="web-cell ">
                    <div class="web-cell__hd">
                        <label class="fr14 web-label">设置支付密码</label>
                    </div>
                    <div class="web-cell__bd tr">
                        <input type="password" class="web-input tr fr14" maxlength="6" id="password1" value="" placeholder="请输入支付密码">
                    </div>
                    <div class="web-cell__ft"></div>
                </div>
                <div class="web-cell ">
                    <div class="web-cell__hd">
                        <label class="fr14 web-label">确认支付密码</label>
                    </div>
                    <div class="web-cell__bd tr">
                        <input type="password" class="web-input tr fr14" maxlength="6" id="password2" value="" placeholder="确认支付密码">
                    </div>
                    <div class="web-cell__ft"></div>
                </div>
                <?php
            }
        ?>
    </div>
    <div style="padding:0 10%;" class="tc mtr30">
        <a href="javascript:;" onclick="updinfo(this)" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-danger fr16" style="padding:8px 60px;width: 100%; line-height: 1.7 ">修改</a>
    </div>
</div>

<div onClick="window.location.href='/?mod=weixin&v_mod=user'" style="width:1.5rem; height:1.5rem; background:rgba(0,0,0,0.6) url(/template/source/images/return2.png) center center no-repeat; background-size:1rem 1rem; position:fixed; left:10px; bottom:30px; z-index:9999;">
</div>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.picker.min.js"></script>
<script src="/template/source/default/js/mui.poppicker.js"></script>
<script>
    function updinfo(obj)
    {
        var that = $(obj);
        var nickname = $('#nickname').val();
        var phone = $('#phone').val();
        var sex = $('#sex').val();
        var password1 = $('#password1').val();
        var password2 = $('#password2').val();
        if(nickname.length<=0)
        {
            mui.alert('请输入昵称');
            return false;
        }
        if(phone.length<=0)
        {
            mui.alert('请输入手机');
            return false;
        }else if(phone.length!=11)
        {
            mui.alert('手机号码位数不足');
            return false;
        }
        if(sex.length<=0)
        {
            mui.alert('请选择性别');
            return false;
        }
        if(password2!='' && password2.length!=6)
        {
            mui.alert('请输入6位支付密码');
            return false;
        }
        var data = {
            nickname:nickname,
            phone:phone,
            sex:sex,
            password1:password1,
            password2:password2
        };
        mui(that).button('loading');
        $.ajax({
            type:"post",
            url:"<?php echo _URL_; ?>&_action=ActionSetUserInfo",
            data:data,
            dataType:"json",
            success:function (res)
            {
                mui(that).button('reset');
                mui.toast(res.msg);
            },
            error:function ()
            {
                mui(that).button('reset');
            }
        });
    }

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
			
		   
        });
 /*
		 var result = doc.getElementById('result');$('#result')[0];
		var btns = doc.getElementsByClassName('select-time-btn')[0];  //$('.select-time-btn')[0];
		btns.addEventListener('tap', function() {
			var optionsJson = this.getAttribute('data-options') || '{}';
			var options = JSON.parse(optionsJson);
			var id = this.getAttribute('id');
			var picker = new $.DtPicker(options);
			picker.show(function(rs)
			{
				btns.value =  rs.text;
				picker.dispose();
			});
		}, false);
	
			*/



  
    })(mui,document);
</script>
</body>
</html>