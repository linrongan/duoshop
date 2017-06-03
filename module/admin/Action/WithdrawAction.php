<?php
class WithdrawAction extends withdraw
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    function ActionChangeWithdrawStatus()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $withdraw = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_WITHDRAW." "
            ." WHERE id='".$this->data['id']."' ");
        if(empty($withdraw))
        {
            return array('code'=>1,'msg'=>'无此申请');
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_WITHDRAW." SET withdraw_status=2 "
            ." WHERE id='".$this->data['id']."'");
        if($row)
        {
            return array('code'=>0,'msg'=>'已标记为已处理状态');
        }
        return array('code'=>1,'msg'=>'操作失败');
    }
}