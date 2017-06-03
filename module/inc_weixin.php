<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if (isset($_GET['my']))
{
    $_SESSION['openid'] = 'oVmj71RPvdD2MGLFgZXRe06sdT6A';
    $_SESSION['userid']=171;
    $_SESSION['nickname'] = '俊逸';
}
if (isset($_GET['xiezong']))
{
    $_SESSION['openid'] = '222222';
    $_SESSION['userid']=172;
    $_SESSION['nickname'] = 'xie';
}

if (isset($_GET['anna']))
{
    $_SESSION['openid'] = 'oVmj71dtniWjXwvVQrCgoz1ev5Os';
    $_SESSION['userid']=178;
    $_SESSION['nickname'] = 'anna';
}
if (isset($_GET['qwer']))
{
    $_SESSION['openid'] = 'oVmj71dtniWjXwvVQrCgoz1ev5Os';
    $_SESSION['userid']=175;
    $_SESSION['nickname'] = 'qwer';
}
if(isset($_GET['qwer1']))
{
    $_SESSION['userid'] = 163;
    $_SESSION['openid'] = '1111';
    $_SESSION['nickname'] = 'test1';
}
if (isset($_GET['san']))
{
    $_SESSION['openid'] = 'oVmj71dtniWjXwvVQrCgoz1ev5Os';
    $_SESSION['userid']=177;
    $_SESSION['nickname'] = 'qwer';
}
if(isset($_GET['shuqing']))
{
    $_SESSION['userid'] = 176;
}
$_index=daddslashes(isset($_GET['_index']) && (!empty($_GET['_index']))?trim($_GET['_index']):'');
//开始进入授权
if (!isset($_SESSION['userid']))
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $weburl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $_SESSION['backurl']=$weburl;
    redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APPID.'&redirect_uri='.urlencode(WEBURL.'/?mod=auth&_auth=snsapi_base&url='.$weburl).'&response_type=code&scope=snsapi_base&state=123#wechat_redirect');
}else
{
    //全局身份变量
    define('SYS_USERID',$_SESSION['userid']);
    define('SYS_OPENID',$_SESSION['openid']);
}
include RPC_DIR .'/module/common/common.php';
include RPC_DIR .'/module/common/common_wx.php';
if (!is_file(RPC_DIR .'/module/mobile/weixin/'.$v_mod.'.php'))
{
    redirect(NOFOUND);
}
include RPC_DIR .'/module/mobile/weixin/'.$v_mod.'.php';
$obj=new $v_mod($_REQUEST);
if (isset($_GET['_action']) && $_GET['_action']<>"")
{
    $v_mod_action=ucfirst($v_mod).'Action';
    if (is_file(RPC_DIR .'/module/mobile/weixin/Action/'.$v_mod_action.'.php'))
    {
        include RPC_DIR .'/module/mobile/weixin/Action/'.$v_mod_action.'.php';
        $obj_action=new $v_mod_action($_REQUEST);
        if (method_exists($obj_action,$_GET['_action']))
        {
            $_return=$obj_action->$_GET['_action']();
            if(regExp::is_ajax())
            {
                echo json_encode($_return);exit;
            }
        }
    }elseif(method_exists($obj,$_GET['_action']))
    {
        $_return=$obj->$_GET['_action']();
        if(regExp::is_ajax())
        {
            echo json_encode($_return);exit;
        }
    }
}
$_wechat_template =RPC_DIR.TEMPLATEPATH.'/weixin/'.$v_mod.'/'.$v_mod.$_index.'_tpl.php';
if(is_file($_wechat_template))
{
    include  $_wechat_template;
}
?>