<?php
class CouponAction extends coupon
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //折扣卷申请
    function ActionApplyDiscount()
    {
        if(!regExp::checkNULL($this->data['share_key']))
        {
            die(json_encode(array('code'=>1,'msg'=>'参数错误')));
        }
        $data=$this->GetDBSlave1()->queryrow("SELECT C.*,S.gift_balance,S.store_name FROM ".TABLE_DISCOUNT_CONF." AS C "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id=S.store_id "
            ." WHERE share_key='".$this->data['share_key']."' ");
        if(empty($data))
        {
            die(json_encode(array('code'=>1,'msg'=>'优惠卷不存在')));
        }
        if($data['gift_balance']<$data['share_money'])
        {
            die(json_encode(array('code'=>1,'msg'=>'折扣卷一领取完，下次早点')));
        }
        $check = $this->CheckHasDiscount($data['store_id']);
        if(!empty($check))
        {
            die(json_encode(array('code'=>1,'msg'=>'你已经领取过一次了')));
        }
        $this->GetDBMaster()->StartTransaction();
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_STORE." "
            ." SET gift_balance = gift_balance-'".$data['share_money']."'"
            ." WHERE store_id='".$data['store_id']."'");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
            ." SET gift_balance = gift_balance+'".$data['share_money']."'"
            ." WHERE userid='".SYS_USERID."'");
        $log_id = $this->AddDiscountCouponLog(array(
            'store_id'=>$data['store_id'],
            'userid'=>SYS_USERID,'money'=>$data['share_money'],
            'orderid'=>$data['store_name'].'发放','order_type'=>2,
            'admin_id'=>0
            ));
        if($res1 && $res2 && $log_id)
        {
            $this->GetDBMaster()->SubmitTransaction();
            die(json_encode(array('code'=>0,'msg'=>'领取成功')));
        }else
        {
            $this->GetDBMaster()->RollbackTransaction();
        }
    }

    //金卡领取
    function ActionOnGoldenCard()
    {
        $user = $this->GetUserInfo(SYS_USERID);
        if($user['gift_balance_status']==1)
        {
            die(json_encode(array('code'=>1,'msg'=>'已经领取,尽情去购物吧！')));
        }
        $golden_card = $this->GetGoldenCardMoney();
        $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
            ." SET gift_balance = gift_balance+'".$golden_card."',"
            ." gift_balance_status = 1 "
            ." WHERE userid='".SYS_USERID."'");
        $this->AddDiscountCouponLog(array(
            'store_id'=>0,
            'userid'=>SYS_USERID,'money'=>$golden_card,
            'orderid'=>'初始金卡领取','order_type'=>4,
            'admin_id'=>0
        ));
        die(json_encode(array('code'=>0,'msg'=>'领取成功')));
    }
}