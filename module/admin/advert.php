<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class advert extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    public function GetAdvertRecord()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(A.addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(A.addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_ADVERT." AS A "
            ." LEFT JOIN ".TABLE_ADVERT_REGION."  AS R ON A.picture_type=R.id "
            ." WHERE  A.is_del=0 AND A.store_id='".$_SESSION['admin_store_id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,R.name FROM ".TABLE_O_ADVERT." AS A "
            ." LEFT JOIN ".TABLE_ADVERT_REGION." AS R ON A.picture_type=R.id  "
            ." WHERE  A.is_del=0 AND A.store_id='".$_SESSION['admin_store_id']."' ".$where." ORDER BY A.picture_type ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    public function getAdvertType()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ADVERT_REGION." "
            ." WHERE status=0 ORDER BY id ASC ");
    }
    public function getOneAdvert()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ADVERT." "
            ." WHERE  is_del=0 AND id = '".$this->data['id']."'");
    }
    public function getOneAdvertType($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADVERT_REGION." "
            ." WHERE id = '".$id."'");
    }
}