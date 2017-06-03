<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_place extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //省
    public function getProvince()
    {
        $where=$canshu="";
        $page_size = 20;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['name']) && !empty($this->data['name']))
        {
            $where .= " AND name LIKE '%".$this->data['name']."%'";
            $canshu .='&name='.$this->data['name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PLACE_PROVINCE." "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_PLACE_PROVINCE." WHERE 1 "
            .$where." ORDER BY autoid ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //一条省信息
    public function getOneProvince()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT *  FROM ".TABLE_PLACE_PROVINCE." "
            ." WHERE autoid='".$this->data['id']."'");
        return $data;
    }
    //市
    public function getCity()
    {
        $province = $this->getOneProvince();
        if(!$province)
        {
            redirect(ADMIN_ERROR);
        }
        $where=$canshu="";
        $page_size = 20;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['name']) && !empty($this->data['name']))
        {
            $where .= " AND name LIKE '%".$this->data['name']."%'";
            $canshu .='&name='.$this->data['name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PLACE_CITY." "
            ." WHERE father='".$province['id']."' ".$where." ");
        $data=$this->GetDBSlave1()->queryrows("SELECT *  FROM ".TABLE_PLACE_CITY." WHERE father='".$province['id']."' "
            .$where." ORDER BY autoid ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu,
            "province"=>$province
        );
    }
    //一条市信息
    public function getOneCity()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT *  FROM ".TABLE_PLACE_CITY." "
            ." WHERE autoid='".$this->data['id']."'");
        return $data;
    }
    //区
    public function getArea()
    {
        $city = $this->getOneCity();
        if(!$city)
        {
            redirect(ADMIN_ERROR);
        }
        $where=$canshu="";
        $page_size = 20;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['name']) && !empty($this->data['name']))
        {
            $where .= " AND name LIKE '%".$this->data['name']."%'";
            $canshu .='&name='.$this->data['name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PLACE_AREA." "
            ." WHERE father='".$city['id']."' ".$where." ");
        $data=$this->GetDBSlave1()->queryrows("SELECT *  FROM ".TABLE_PLACE_AREA." WHERE father='".$city['id']."' "
            .$where." ORDER BY autoid ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu,
            "city"=>$city
        );
    }
    //一条区域信息
    public function getOneArea()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT *  FROM ".TABLE_PLACE_AREA." "
            ." WHERE autoid='".$this->data['id']."'");
        return $data;
    }
}