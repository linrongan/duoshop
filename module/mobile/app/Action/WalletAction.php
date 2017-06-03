<?php
class WalletAction extends wallet
{
    function __construct($data)
    {
        $this->data = $data;
    }

    /*
     * 余额充值流水
     * */
    function ActionRePay()
    {
        if(!regExp::is_ajax())
        {
            return array('code'=>1,'msg'=>'非法请求');
        }
        if(!isset($this->data['money']) || empty($this->data['money']))
        {
            return array('code'=>1,'msg'=>'充值金额不正确');
        }
        $reg = '/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/';
        if(!preg_match($reg,$this->data['money']))
        {
            return array('code'=>1,'msg'=>'金额格式非法');
        }
        if($this->data['money']>1000)
        {
            return array('code'=>1,'msg'=>'单次充值金额最大不超过1000');
        }
        $user = $this->GetUserInfo(SYS_USERID);
        $recharge_before_money = $user['user_money'];
        $recharge_after_money = $recharge_before_money+$this->data['money'];
        $orderid =$this->OrderMakeOrderId();
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_RECHARGE."(recharge_userid,"
            ."recharge_money,recharge_status,recharge_status_text,recharge_orderid,recharge_addtime,"
            ."recharge_before_money,recharge_after_money) VALUES('".SYS_USERID."',"
            ."'".$this->data['money']."',0,'待付款','".$orderid."','".date("Y-m-d H:i:s",time())."',"
            ."'".$recharge_before_money."','".$recharge_after_money."')");
        if(!$res)
        {
            return array('code'=>1,'msg'=>'充值订单生成失败');
        }
        require_once RPC_DIR.'/module/common/wechat_pay.php';
        $wechat_pay = new wechat_pay($this->data);
        $array=array(
            'pay_body'=>'余额微信充值',
            'out_trade_no'=>$orderid,
            'total_fee'=>$this->data['money'],
            'notify_url'=>WEBURL.'/pay/weixin/pay_recharge_result.php'
        );
        $data = $wechat_pay->WeChatPay($array);
        return array('code'=>0,'pay'=>json_decode($data,true),'orderid'=>$orderid,'no'=>$res,'time'=>time());
    }


    function ActionMoneyOut()
    {
        if(!regExp::checkNULL($this->data['out_money']))
        {
            return array('code'=>1,'msg'=>'请输入您需要提现的金额数量');
        }
        if($this->data['out_money']<10)
        {
            return array('code'=>1,'msg'=>'提现金额不能低于10元');
        }
        $reg = '/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/';
        if(!preg_match($reg,$this->data['out_money']))
        {
            return array('code'=>1,'msg'=>'请输入合法的金额数字');
        }
        $user_money = $this->GetUserProfit(SYS_USERID);
        if($this->data['out_money']>$user_money['money_total'])
        {
            return array('code'=>1,'msg'=>'余额不足');
        }
        if(!regExp::checkNULL($this->data['bank_id']))
        {
            return array('code'=>1,'msg'=>'请选择银行卡');
        }
        $bankInfo = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANK_CARD." WHERE "
            ." id='".$this->data['bank_id']."' AND userid='".SYS_USERID."'");
        if(!$bankInfo)
        {
            return array('code'=>1,'msg'=>'银行卡无效或不存在');
        }
        $this->GetDBMaster()->StartTransaction();
        //查询收益
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_PROFIT." SET profit_status=1 "
            ." WHERE userid='".SYS_USERID."'");
        $withdraw_sourse = '收益';
        $withdraw_status = 0;
        $withdraw_method = 0;
        //写入提现列表
        $res2 = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_WITHDRAW."(userid,"
            ."withdraw_money,withdraw_sourse,withdraw_apply_date,"
            ."withdraw_status,withdraw_method,withdraw_bank_name,withdraw_bank_number) "
            ."VALUES('".SYS_USERID."','".$this->data['out_money']."',"
            ."'".$withdraw_sourse."','".date("Y-m-d H:i:s",time())."',"
            ."'".$withdraw_status."','".$withdraw_method."',"
            ."'".$bankInfo['bank_card_name']."','".$bankInfo['bank_card_number']."')");
        //写入收益交易记录
        $_fee_array=array(
            "fee_type"=>10,
            "fee_money"=>$this->data['out_money'],
            "title"=>"收益提现",
            "beizhu"=>'',
            "transaction_id"=>0,
            "orderid"=>$res2,
            "userid"=>SYS_USERID,
            "adminid"=>0,
            "pay_type"=>0
        );
        $res3 = $this->AddCommFee($_fee_array);
        if($res1 && $res2 && $res3)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'操作成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'提示失败');
    }



    /*提现操作*/
    function ActionUserMoneyOut()
    {
        if(!regExp::is_ajax())
        {
            return array('code'=>1,'err'=>'fail');
        }
        $to_month = $this->GetToMonthMoneyOutNum();
        $conf_money_out_nums = $this->GetWebConf('month_withdrawals');
        if($to_month['count']>=$conf_money_out_nums)
        {
            return array('code'=>1,'msg'=>'本月可提现次数已用完');
        }
        $user = $this->GetUserInfo(SYS_USERID);
        if(!regExp::checkNULL($this->data['money']))
        {
            return array('code'=>1,'msg'=>'请输入退款金额');
        }
        $reg = '/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/';
        if(!preg_match($reg,$this->data['money']))
        {
            return array('code'=>1,'msg'=>'金额不合法');
        }
        if($this->data['money']>$user['user_money'])
        {
            return array('code'=>1,'msg'=>'可提现金额不足');
        }
        $bind_bank = '';
        if($this->data['money']>1000)
        {
            if(!regExp::checkNULL($this->data['bank_id']))
            {
                return array('code'=>1,'msg'=>'缺少银行卡参数');
            }
            $bank = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANK_CARD." "
                ." WHERE id='".$this->data['bank_id']."'");
            if(!$bank || $bank['userid']!=SYS_USERID)
            {
                return array('code'=>1,'msg'=>'没有此银行卡');
            }
            $bind_bank .= ",withdraw_bank_name='".$bank['bank_name']."',"
                ."withdraw_bank_number='".$bank['bank_card_number']."',"
                ."withdraw_bank_user_name='".$bank['bank_username']."',"
                ."withdraw_bank_user_card='".$bank['bank_user_card']."'";
        }
        $this->GetDBMaster()->StartTransaction();
        //存入记录
        $res1 = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_WITHDRAW." SET "
            ."userid='".SYS_USERID."',withdraw_money='".$this->data['money']."',"
            ."withdraw_sourse='余额',withdraw_apply_date='".date("Y-m-d H:i:s",time())."',"
            ."withdraw_status=0,withdraw_method='".($this->data['money']>1000?1:0)."',"
            ."withdraw_sourse_type=1,withdraw_partner_trade_no='".$this->GetRandOrder()."' "
            ."".$bind_bank."");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
            ." user_money=IF(user_money>='".$this->data['money']."',user_money-'".$this->data['money']."',user_money) "
            ." WHERE userid='".SYS_USERID."'");
        if($res1 && $res2)
        {
            $this->GetDBMaster()->SubmitTransaction();
            if($this->data['money']<=1000)
            {
                $this->ActionAutoBackMoney($res1);
            }
            return array('code'=>0,'msg'=>'提现申请成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'申请提现失败');
    }



    //自动退款
    function ActionAutoBackMoney($id)
    {
        //查询订单
        $data = $this->GetDBSlave1()->queryrow("SELECT W.*,U.openid FROM "
            ." ".TABLE_WITHDRAW." AS W INNER JOIN ".TABLE_USER." AS U "
            ." ON W.userid=U.userid WHERE W.id='".$id."'");
        if($data['withdraw_method']!=0 || $data['withdraw_sourse_type']!=1
            || $data['withdraw_status']!=0 || $data['withdraw_money']>1000 || empty($data['openid']))
        {
            exit;
        }
       /* $total = $this->GetDBSlave1()->queryrow("SELECT SUM(withdraw_money) AS total FROM "
            ." ".TABLE_WITHDRAW." WHERE userid='".SYS_USERID."' "
            ." AND withdraw_status=2 AND withdraw_method=0");*/
        require_once RPC_DIR.'/pay/weixin/wechat_transfers.php';
        $array = array(
            'partner_trade_no'=>$data['withdraw_partner_trade_no'],
            'openid'=>$data['openid'],
            'check_name'=>'NO_CHECK',
            'amount'=>$data['withdraw_money']*100,
            'desc'=>'提现',
            'spbill_create_ip'=>'120.76.206.17'
        );
        $trans = new transfers('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers',$array);
        $this->GetDBMaster()->StartTransaction();
        //back_method处理方式
        $res = $this->GetDBMaster("UPDATE ".TABLE_WITHDRAW." SET withdraw_status=2,handle_way=1,back_method=1 "
            ." WHERE id='".$data['id']."'");
        if($res)
        {
            $result = $trans->transfers('request_refund');
            if($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS')
            {
                $this->GetDBMaster()->SubmitTransaction();
            }else{
                $this->GetDBMaster()->RollbackTransaction();
                $this->AddLogAlert('企业付款',$array['withdraw_partner_trade_no'].'付款失败');
            }
        }
    }


    function GetRandOrder()
    {
        $refund_number = date('ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        return $refund_number;
    }
}