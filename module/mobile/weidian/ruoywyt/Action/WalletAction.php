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



}