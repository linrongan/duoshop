<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class advert extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //投放记录
    function GetPayMoneyLog()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_FEE."  "
            ." WHERE orderid='".$this->data['orderid']."' "
            ." AND userid='".SYS_USERID."'");
        return array('code'=>0,'data'=>$data);
    }

    //获取投放记录
    function GetAdvertDetails($id)
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT A.*,R.name,R.price FROM ".TABLE_O_ADVERT." A "
            ." LEFT JOIN ".TABLE_ADVERT_REGION." AS R ON A.picture_type = R.id "
            ." WHERE A.id = '".$id."'");
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=此记录不存在');
        }

        $shiduan=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ADVERT." "
            ." WHERE picture_type='".$data['picture_type']."' "
            ." AND expire_time>'".date("Y-m-d H:i:s")."'"
            ." ORDER BY expire_time DESC LIMIT 0,1");
        return array('data'=>$data,'shiduan'=>$shiduan);
    }
}