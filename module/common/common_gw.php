<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
//官方网站
include RPC_DIR .'/conf/database_table.php';
include RPC_DIR .'/conf/database_table_gw.php';
include RPC_DIR .'/conf/dbclass.php';
Class common_gw {
    protected  $conn='';
    protected  $db='';
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //获取数据库主库可写
    protected function GetDBMaster()
    {
        $db = dbtemplate::getInstance('mysql:host=rm-wz9decsr1538g09bo.mysql.rds.aliyuncs.com;port=3306;dbname=duoshop;charset=utf8mb4',
            'array_user',
            'u33Tds763KOIH');
        return $db;
    }

    //获取数据库从库可读2,官网用
    protected function GetDBSlave2()
    {
        $db = dbtemplate::getInstance('mysql:host=rm-wz9decsr1538g09bo.mysql.rds.aliyuncs.com;port=3306;dbname=duoshop;charset=utf8mb4',
            'array_user',
            'u33Tds763KOIH');
        return $db;
    }

    //公众日记表操作记录
    protected function AddLogAlert($KEY,$VALUE)
    {
        $this->GetDBMaster()->query("INSERT INTO ".TABLE_LOG_ALERTED." (key_title,content,addtime,status)"
            ."VALUES('".$KEY."','".$VALUE."','".date("Y-m-d H:i:s")."',0)");
    }
}
?>