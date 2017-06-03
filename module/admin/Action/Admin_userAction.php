<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_userAction extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //设置黑名单
    function ActionBlackList()
    {
        if ($this->data['type']=='set')
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                ." SET status=1"
                ." WHERE userid='".$this->data['userid']."'");
            return array("code"=>0,"msg"=>"黑名单设置操作成功");
        }elseif($this->data['type']=='cancel')
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                ." SET status=0"
                ." WHERE userid='".$this->data['userid']."'");
            return array("code"=>0,"msg"=>"黑名单取消操作成功");
        }

    }
    //编辑用户积分和余额
    function ActionEditUser()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetUserInfo($this->data['id']);
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'用户不存在');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
            ." SET gift_balance='".$this->data['gift_balance']."',"
            //." user_point = '".$this->data['user_point']."',"
            //." user_money='".$this->data['user_money']."',"
            ." vip_lv = '".$this->data['vip_lv']."' "
            ." WHERE userid='".$this->data['id']."'");
        if($this->data['user_money']!=$data['user_money'] || $this->data['user_point']!=$data['user_point'])
        {
            //插入日志
            $data = array(
                'store_id'=>$this->data['id'],
                'userid'=>$this->data['id'],'money'=>$this->data['gift_balance'],
                'orderid'=>'充值给用户','order_type'=>1,
                'admin_id'=>$_SESSION['admin_id']
            );
            $this->AddDiscountCouponLog($data);
        }
        return array("code"=>0,"msg"=>"编辑成功");
    }
}
