<?php
class WalletAction extends wallet
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionNewBankCard()
    {
        if(!regExp::checkNULL($this->data['bank_card_uname']))
        {
            return array('code'=>1,'msg'=>'请输入持卡人');
        }
        if(!regExp::checkNULL($this->data['bank_card_name']))
        {
            return array('code'=>1,'msg'=>'请选择银行');
        }
        if(!regExp::checkNULL($this->data['bank_card_number']))
        {
            return array('code'=>1,'msg'=>'请输入卡号');
        }
        if(!regExp::checkNULL($this->data['card_uid']))
        {
            return array('code'=>1,'msg'=>'请输入身份证号');
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_BANK_CARD." WHERE "
            ." userid='".SYS_USERID."'");
        if($count['count']>=3)
        {
            return array('code'=>1,'msg'=>'您绑定的银行卡已达上限');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_BANK_CARD."(userid,bank_card_uname,bank_card_name,"
            ."bank_card_number,card_uid,addtime,save_date) VALUES('".SYS_USERID."','".$this->data['bank_card_uname']."',"
            ."'".$this->data['bank_card_name']."','".$this->data['bank_card_number']."','".$this->data['card_uid']."',"
            ."'".date("Y-m-d H:i:s",time())."','".time()."')");
        if($res)
        {
            return array('code'=>0,'msg'=>'绑定成功');
        }
        return array('code'=>1,'msg'=>'绑定失败');
    }



    //取消绑定
    function ActionCpanelBank()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $bank = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANK_CARD." WHERE "
            ." id='".$this->data['id']."' AND userid='".SYS_USERID."'");
        if(empty($bank))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_BANK_CARD." WHERE "
            ." id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'解绑成功');
        }
        return array('code'=>1,'msg'=>'解绑失败');
    }


    function ActionRePay()
    {
        if(!regExp::is_ajax())
        {
            return array('code'=>1,'msg'=>'非法请求');
        }
        if(!isset($this->data['money']) || empty($this->data['money']))
        {
            return array('code'=>1,'msg'=>'金额参数错误');
        }
        $user = $this->GetUserInfo(SYS_USERID);
        $recharge_before_money = $user['user_money'];
        $recharge_after_money = $recharge_before_money+$this->data['money'];
        $get_orderid = regExp::get_Orderid();
        $orderid = '400'.$get_orderid;
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_RECHARGE."(recharge_userid,"
            ."recharge_money,recharge_status,recharge_status_text,recharge_orderid,recharge_addtime,"
            ."recharge_before_money,recharge_after_money) VALUES('".SYS_USERID."',"
            ."'".$this->data['money']."',0,'待付款','".$orderid."','".date("Y-m-d H:i:s",time())."',"
            ."'".$recharge_before_money."','".$recharge_after_money."')");
        if(!$res)
        {
            return array('code'=>1,'msg'=>'充值订单生成失败');
        }
        include RPC_DIR.'/module/mobile/weidian/default/wechat_pay.php';
        $wechat_pay = new wechat_pay($this->data);
        $array = array(
            'out_trade_no'=>$orderid,
            'total_fee'=>$this->data['money'],
            'notify_url'=>WEBURL.'/pay/weixin/recharge_callback.php'
        );
        $data = $wechat_pay->WeChatPay($array);
        return array('code'=>0,'pay'=>$data,'orderid'=>$orderid,'no'=>$res,'time'=>time());
    }




}