<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_file extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //获取上传文件
    public function getAdminFile()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['nickname']) && !empty($this->data['nickname']))
        {
            $where .= " AND U.nickname LIKE '%".$this->data['nickname']."%'";
            $canshu .='&nickname='.$this->data['nickname'];
        }
        if(isset($this->data['type_id']) && is_numeric($this->data['type_id'])){
            $where .= " AND A.type_id='".$this->data['type_id']."'";
            $canshu = "&type_id=".$this->data['type_id'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ATTACH." "
            ." AS A LEFT JOIN ".TABLE_USER." AS U ON A.userid=U.userid WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,U.nickname FROM ".TABLE_ATTACH." "
            ." AS A LEFT JOIN ".TABLE_USER." AS U ON A.userid=U.userid WHERE 1 "
            .$where." LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
}