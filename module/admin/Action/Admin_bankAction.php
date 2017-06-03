<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_bankAction extends admin_bank
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //添加银行
    function ActionAddBank()
    {
        if( !regExp::checkNULL($this->data['bank_name']) ||
            !regExp::checkNULL($this->data['bank_initial']) ||
            !regExp::checkNULL($this->data['bank_english_name']) ||
            !regExp::checkNULL($this->data['bank_keyword']))
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_BANK." (bank_name,bank_initial"
            .",bank_english_name,bank_keyword,bank_addtime,bank_upd_date) VALUES('".$this->data['bank_name']."',"
            ."'".$this->data['bank_initial']."',"
            ."'".$this->data['bank_english_name']."',"
            ."'".$this->data['bank_keyword']."',"
            ."'".date('Y-m-d H:i:s')."',"
            ."'".date('Y-m-d H:i:s')."')"
        );
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑银行
    function ActionEditBank()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if( !regExp::checkNULL($this->data['bank_name']) ||
            !regExp::checkNULL($this->data['bank_initial']) ||
            !regExp::checkNULL($this->data['bank_english_name']) ||
            !regExp::checkNULL($this->data['bank_keyword']))
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $data = $this->GetBankDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'银行不存在或已删除');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_BANK." SET "
            ." bank_name='".$this->data['bank_name']."',"
            ." bank_initial='".$this->data['bank_initial']."',"
            ." bank_english_name='".$this->data['bank_english_name']."',"
            ." bank_keyword='".$this->data['bank_keyword']."',"
            ." bank_upd_date='".date('Y-m-d H:i:s')."'"
            ." WHERE id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除消息
    function ActionDelBank()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetBankDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'银行不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_BANK." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
}