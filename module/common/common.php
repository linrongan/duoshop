<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/conf/database_table.php';
include RPC_DIR .'/conf/dbclass.php';
Class common {
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

    //获取数据库从库可读1，微信用
    protected function GetDBSlave1()
    {
        $db = dbtemplate::getInstance('mysql:host=rm-wz9decsr1538g09bo.mysql.rds.aliyuncs.com;port=3306;dbname=duoshop;charset=utf8mb4',
            'array_user',
            'u33Tds763KOIH');
        return $db;
    }

    public function GetUserInfo($userid)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." WHERE "
            ." userid='".$userid."'");
    }

    //取出附件
    public function GetAttachList($type_id=0,$id=0)
    {
        $res = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTACH."  "
            ." WHERE type_id='".$type_id."' "
            ." AND id='".$id."'");
        return $res;
    }

    //公众日记表操作记录
    protected function AddLogAlert($KEY,$VALUE)
    {
        $adminid=$userid=0;
        if (isset($_SESSION['admin_id']))
        {
            $adminid=$_SESSION['admin_id'];
        }
        if(defined('SYS_USERID'))
        {
            $userid=SYS_USERID;
        }
        $this->GetDBMaster()->query("INSERT INTO ".TABLE_LOG_ALERTED." (key_title,content,addtime,status,adminid,userid)"
            ."VALUES('".$KEY."','".$VALUE."','".date("Y-m-d H:i:s")."',0,'".$adminid."','".$userid."')");
    }

    //费用日记记录
    protected function AddCommFee($array=array())
    {
        $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COMM_FEE." "
            ." (fee_type,fee_money,title,addtime,beizhu,transaction_id,orderid,userid,adminid,pay_type,store_id)"
            ." VALUES('".$array['fee_type']."','".$array['fee_money']."',"
            ."'".$array['title']."','".date("Y-m-d H:i:s")."','".$array['beizhu']."',"
            ."'".$array['transaction_id']."','".$array['orderid']."','".$array['userid']."',"
            ."'".$array['adminid']."','".$array['pay_type']."','".$array['store_id']."')");
        return $id;
    }

    //生成公共订单号
    protected function OrderMakeOrderId()
    {
        /* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    //获取公共配置信息
    protected function GetCommonConf($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CONF." WHERE "
            ." id='".$id."'");
    }

    /*
     * 折扣卷日记记录
     *  store_id,userid,money,orderid,order_type,admin_id
     * */
    protected function AddDiscountCouponLog($array=array())
    {
        $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_DISCOUNT_COUPON." "
            ." (store_id,userid,money,orderid,order_type,admin_id,addtime)"
            ." VALUES('".$array['store_id']."','".$array['userid']."',"
            ."'".$array['money']."','".$array['orderid']."',"
            ."'".$array['order_type']."','".$array['admin_id']."',"
            ."'".date("Y-m-d H:i:s")."')");
        return $id;
    }
}
?>