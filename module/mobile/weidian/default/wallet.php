<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class wallet extends wx
{
    function __construct($data)
    {
        $this->data = $data;
    }


    //银行卡列表
    function GetBankCardList()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_BANK_CARD." WHERE "
            ." userid='".SYS_USERID."' ORDER BY save_date DESC");
    }

    function GetCardTran($str)
    {
        $len = strlen($str);
        $tran_len = $len-4;
        $fuhao = '';
        for($i=0;$i<$tran_len;$i++)
        {
            $fuhao .= '*';
        }
        return str_replace(substr($str,0,$tran_len),$fuhao,$str);
    }

    //银行卡详情
    function GetBankDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $bank = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANK_CARD." WHERE "
            ." id='".$this->data['id']."' AND userid='".SYS_USERID."'");
        if(!$bank)
        {
            redirect(NOFOUND.'&msg=无此卡');
        }
        return $bank;
    }


}