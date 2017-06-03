<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/module/common/common.php';
if (!isset($_SESSION['openid']))
{
    include RPC_DIR .'/module/mobile/auth/login_'.$_GET['_auth'].'.php';
}
exit;
?>