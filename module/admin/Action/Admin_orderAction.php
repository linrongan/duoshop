<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class Admin_orderAction extends admin_order
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //管理员删除订单
    public function ActionDelOrder()
    {
        if(!regExp::checkNULL($this->data['orderid'])){
            return array('code'=>1,'msg'=>'参数错误');
        }
        //是否存在该订单
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER." WHERE "
            ." orderid = '".$this->data['orderid']."'");
        if(!$data)
        {
            return array('code'=>1,'msg'=>'订单不存在');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER." SET "
            ." is_del=1 WHERE orderid='".$this->data['orderid']."'");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET "
            ." is_del=1 WHERE orderid='".$this->data['orderid']."'");
        if($res && $res2)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }
    //批量删除订单
    function ActionMoreDelOrder()
    {
        if(!regExp::checkNULL($this->data['orderid']) || !is_array($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $select_id = array_filter($this->data['orderid']);
        $count = count($select_id);
        $where = '';
        for ($i=0;$i<$count;$i++)
        {
            $where .= $select_id[$i].',';
        }
        $where = rtrim($where,',');
        $check_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_ORDER." WHERE "
            ." orderid IN (".$where.")");
        if($check_count['total']<$count)
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER." SET is_del=1 WHERE "
            ." orderid IN(".$where.")");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET is_del=1 "
            ." WHERE orderid IN(".$where.") ");
        if($res && $res2)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'删除成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'删除失败');
    }

}