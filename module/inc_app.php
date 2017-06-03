<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
define('SYS_USERID',171);
//开始进入授权
if (!defined('SYS_USERID'))
{
    die(json_encode(array("code"=>1,"msg"=>"用户未授权")));
}
include RPC_DIR .'/module/common/common.php';
//映射规则
if (is_file(RPC_DIR .'/module/mobile/app/'.$v_mod.'.php'))
{
    include RPC_DIR .'/module/mobile/app/'.$v_mod.'.php';
}
$_return=array();
if (isset($_GET['_action']) && $_GET['_action']<>"")
{
    $v_mod_action=ucfirst($v_mod).'Action';
    if(!class_exists($v_mod_action,false))
    {
        die(json_encode(array('code'=>1,'err'=>'drive no fund')));
    }
    if (is_file(RPC_DIR .'/module/mobile/app/Action/'.$v_mod_action.'.php'))
    {
        include RPC_DIR .'/module/mobile/app/Action/'.$v_mod_action.'.php';
        $obj_action=new $v_mod_action($_REQUEST);
        if(method_exists($obj_action,$_GET['_action']))
        {
            $_return=$obj_action->$_GET['_action']();
        }
    }
}else
{
    if(!class_exists($v_mod,false))
    {
        die(json_encode(array('code'=>1,'err'=>'drive no fund')));
    }
    $obj=new $v_mod($_REQUEST);
    if(isset($_GET['_return']) && method_exists($obj,$_GET['_return']))
    {
        $_return=$obj->$_GET['_return']();
    }
}
//设置返回类型,默认返回json
if($_return)
{
    $format = isset($_REQUEST['format']) && !empty($_REQUEST['format']) && is_string($_REQUEST['format']) ?strtolower(trim($_REQUEST['format'])):'json';
    if($format=='json')
    {
        die(json_encode($_return));
    }elseif($format=='xml')
    {
        return 'xml';
    }elseif($format=='obj')
    {
        return 'obj';
    }else{
        var_dump($_return);
    }
}
?>