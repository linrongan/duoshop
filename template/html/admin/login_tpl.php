<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE HTML>
<html>
<head>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
<link href="/template/source/admin/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<title>后台管理系统</title>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="loginWraper">
  <div id="loginform" class="loginBox">
      <div class="row cl">
        <label class="form-label col-xs-3 text-r"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input id="username" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3 text-r"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input id="password" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" type="text" placeholder="验证码" id="code" value="" style="width:150px;">
          <img src="/tool/authcode.php" id="code-img"> <a onclick="GetRandCode()" href="javascript:;">看不清，换一张</a> </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input type="submit" onclick="Login(this)" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
  </div>
</div>
<div class="footer">Copyright  by 若宇网络科技</div>
<script type="text/javascript" src="/template/source/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/template/source/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/tool/layer/layer/layer.js"></script>
<script>
function GetRandCode()
{
    var src = $("#code-img").attr('src');
    $("#code-img").attr('src',src+ '?nowtime=' + new Date().getTime());
}

function Login(obj)
{
   var username = $("#username").val();
   var password = $("#password").val();
   var code = $("#code").val();
   if(username.length<=0)
   {
       alert('请输入账号');
       $("#username").focus();
       return false;
   }
    if(password.length<=0)
    {
        alert('请输入密码');
        $("#password").focus();
        return false;
    }
    if(code.length<=0)
    {
        alert('请输入验证码');
        $("#code").focus();
        return false;
    }
    $(obj).attr('disabled',true);
    var data = {
        username:username,
        password:password,
        code:code
    };
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
   $.ajax({
       type:"post",
       url:"/?mod=admin&action=ajaxLogin",
       data:data,
       success:function (res)
       {
           layer.close(index);
           if(res.code==0)
           {
               window.location.href='/?mod=admin'
           }else{
               GetRandCode();
               layer.msg(res.msg, {icon: 5});
           }
           $(obj).attr('disabled',false);
       },
       error:function ()
       {
           layer.close(index);
           $(obj).attr('disabled',false);
           alert('网络超时');
       },
       dataType:"json"
   });
}
</script>
</body>
</html>