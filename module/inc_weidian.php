<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if (isset($_GET['test']))
{
    $_SESSION['openid'] = 'o3nClwqzSChJzQgk49Mq3BSmUOj4';
    $_SESSION['userid']=157;
    $_SESSION['nickname'] = '若宇网络 俊逸';
    $_SESSION['level'] = 0;
}
$_index=daddslashes(isset($_GET['_index']) && (!empty($_GET['_index']))?trim($_GET['_index']):'');
//开始进入授权
if(!isset($_SESSION['userid']))
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
//对应使用主题模板
$xml_shop = RPC_DIR.'/shop/'.$v_shop.'.xml';
if(!file_exists($xml_shop))
{
    redirect(NOFOUND.'&msg=找不到该店铺');
}
$_xml_array = simplexml_load_file($xml_shop);
$_store_id = $_xml_array->store_id;
$_url = $_xml_array->url;
$_select_template = $_xml_array->template;
$_store_name = $_xml_array->store_name;
$_store_logo = $_xml_array->logo;

if (!is_file(RPC_DIR .'/module/mobile/weidian/'.$_select_template.'/'.$v_mod.'.php'))
{
    redirect(NOFOUND);
}
include RPC_DIR .'/module/mobile/weidian/'.$_select_template.'/'.$v_mod.'.php';
$obj=new $v_mod($_REQUEST,$_store_id);
if (isset($_GET['_action']) && $_GET['_action']<>"")
{
    $v_mod_action=ucfirst($v_mod).'Action';
    if (is_file(RPC_DIR .'/module/mobile/weidian/'.$_select_template.'/Action/'.$v_mod_action.'.php'))
    {
        include RPC_DIR .'/module/mobile/weidian/'.$_select_template.'/Action/'.$v_mod_action.'.php';
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
if (is_file(RPC_DIR .TEMPLATEPATH.'/weidian/'.$_select_template.'/'.$v_mod.$_index.'_tpl.php'))
{
    include  RPC_DIR .TEMPLATEPATH.'/weidian/'.$_select_template.'/'.$v_mod.$_index.'_tpl.php';
}
?>