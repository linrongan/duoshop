<?php
class TransactionAction extends transaction
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionShareMoney()
    {
        if(!regExp::checkNULL($this->data['money']))
        {
            return array('code'=>1,'msg'=>'请输入分享金额');
        }
        $store = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." "
            ." WHERE store_id = '".$_SESSION['admin_store_id']."'");
        if($this->data['money']>$store['gift_balance'])
        {
            return array('code'=>1,'msg'=>'分享金额不能大于'.$store['gift_balance']);
        }
        $conf = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_DISCOUNT_CONF." "
            ." WHERE store_id = '".$_SESSION['admin_store_id']."'");
        if(empty($conf))
        {
            $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_DISCOUNT_CONF." "
                ."(store_id,share_money,share_key) "
                ." VALUES('".$_SESSION['admin_store_id']."','".$this->data['money']."','".md5(time().$_SESSION['admin_store_id'])."')");
            return array('code'=>0,'msg'=>'设置成功');
        }else{
            $this->GetDBMaster()->query("UPDATE ".TABLE_DISCOUNT_CONF." "
                ." SET share_money='".$this->data['money']."'"
                ." WHERE store_id='".$_SESSION['admin_store_id']."'");
            return array('code'=>0,'msg'=>'重设成功');
        }
    }
}