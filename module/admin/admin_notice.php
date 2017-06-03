<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_notice extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //消息列表
    public function getNoticeList()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ALERT_LIST." AS A "
            ." LEFT JOIN ".TABLE_ALERT_ROLE." AS R ON A.alert_role_id=R.alert_role_id "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,R.name FROM ".TABLE_ALERT_LIST." AS A "
            ." LEFT JOIN ".TABLE_ALERT_ROLE." AS R ON A.alert_role_id=R.alert_role_id "
            ." WHERE 1 ".$where." "
            ." ORDER BY A.alert_id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //消息分类
    public function getNoticeRole()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ALERT_ROLE." ");
    }
    //消息详情
    public function getNoticeDetail()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ALERT_LIST." "
            ." WHERE alert_id ='".$this->data['id']."'");
        return $data;
    }
    //分类详情
    public function getNoticeRoleDetail()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ALERT_ROLE." "
            ." WHERE alert_role_id ='".$this->data['id']."'");
    }

}