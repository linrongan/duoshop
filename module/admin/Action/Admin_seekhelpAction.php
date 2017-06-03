<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_seekhelpAction extends admin_seekhelp
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    function ActionDelSeekhelp()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $help = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_NEED_HELP." "
            ." WHERE id = '".$this->data['id']."'");
        if(empty($help))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_NEED_HELP." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
}