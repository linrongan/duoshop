<?php
class Admin_withdrawAction extends admin_withdraw
{
    function __construct($data)
    {
        $this->data = $data;
    }

    //标记银行成功转账
    function ActionBankBack()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetOneUserWithdraw($this->data['id']);
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'无此申请');
        }elseif($data['withdraw_status']!=1)
        {
            return array('code'=>1,'msg'=>'请先选择处理方式');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_WITHDRAW." SET withdraw_status=2, "
            ."withdraw_confim_date='".date("Y-m-d H:i:s",time())."' WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'操作成功');
        }
        return array('code'=>1,'msg'=>'操作失败');
    }


    function ActionConfirmBackWay()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'error');
        }
        $data = $this->GetOneUserWithdraw($this->data['id']);
        if(!$data)
        {
            return array('code'=>1,'msg'=>'数据不存在');
        }elseif($data['withdraw_status']!=0)
        {
            return array('code'=>1,'msg'=>'状态错误');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_WITHDRAW." SET withdraw_status=1,"
            ."back_method='".$this->data['back_method']."' WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'操作成功');
        }
        return array('code'=>1,'msg'=>'操作失败');
    }



    //微信转账
    function ActionWeChatBack()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetOneUserWithdraw($this->data['id']);
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'无此申请');
        }elseif($data['withdraw_status']!=1)
        {
            return array('code'=>1,'msg'=>'请先选择处理方式');
        }elseif($data['back_method']!=1)
        {
            return array('code'=>1,'msg'=>'未选择微信转账');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_WITHDRAW." SET withdraw_status=2, "
            ."withdraw_confim_date='".date("Y-m-d H:i:s",time())."' WHERE id='".$this->data['id']."'");
        if($res)
        {
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
            $result = $trans->transfers('request_refund');
            if($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS')
            {
                $this->GetDBMaster()->SubmitTransaction();
                return array('code'=>0,'msg'=>'转账成功');
            }else{
                $this->GetDBMaster()->RollbackTransaction();
                $this->AddLogAlert('企业付款',$data['withdraw_partner_trade_no'].'付款失败');
                return array('code'=>1,'msg'=>$result['err_code'].$result['err_code_des']);
            }
        }
    }

}


