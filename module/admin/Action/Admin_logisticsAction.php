<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_logisticsAction extends admin_logistics
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //添加银行
    function ActionAddLogistics()
    {
        if( !regExp::checkNULL($this->data['logistics_name']) ||
            !regExp::checkNULL($this->data['logistics_type']) ||
            !regExp::checkNULL($this->data['logistics_letter']))
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_LOGISTICS." (logistics_name,logistics_type"
            .",logistics_letter,logistics_tel,logistics_number,logistics_sort) VALUES('".$this->data['logistics_name']."',"
            ."'".$this->data['logistics_type']."',"
            ."'".$this->data['logistics_letter']."',"
            ."'".$this->data['logistics_tel']."',"
            ."'".$this->data['logistics_number']."',"
            ."'".$this->data['logistics_sort']."')"
        );
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑银行
    function ActionEditLogistics()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if( !regExp::checkNULL($this->data['logistics_name']) ||
            !regExp::checkNULL($this->data['logistics_type']) ||
            !regExp::checkNULL($this->data['logistics_letter']))
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $data = $this->GetLogisticsDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'物流不存在或已删除');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_LOGISTICS." SET "
            ." logistics_name='".$this->data['logistics_name']."',"
            ." logistics_type='".$this->data['logistics_type']."',"
            ." logistics_letter='".$this->data['logistics_letter']."',"
            ." logistics_tel='".$this->data['logistics_tel']."',"
            ." logistics_number='".$this->data['logistics_number']."',"
            ." logistics_sort='".$this->data['logistics_sort']."'"
            ." WHERE logistics_id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除消息
    function ActionDelLogistics()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetLogisticsDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'物流不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_LOGISTICS." "
            ." WHERE logistics_id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
}