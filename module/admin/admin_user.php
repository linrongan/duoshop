<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_user extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //获取粉丝列表
    public function GetUserList()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        if(isset($this->data['username']) && !empty($this->data['username']))
        {
            $where .= " AND nickname LIKE '%".$this->data['username']."%'";
            $canshu .='&username='.$this->data['username'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_USER." AS U ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_USER." "
            ." WHERE 1  ".$where." ORDER BY userid DESC  "
            ." LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
}