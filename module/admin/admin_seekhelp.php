<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_seekhelp extends comm
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //申请列表
    function GetSeekhelpList()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['name']) && !empty($this->data['name']))
        {
            $where .= " AND name LIKE '%".$this->data['name']."%'";
            $param .= "&name=".$this->data['name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_NEED_HELP." "
            ." WHERE 1 ".$where." ");
        $no_see_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS no_see FROM ".TABLE_NEED_HELP." "
            ." WHERE see_status=0");
        if($no_see_count['no_see']>0)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_NEED_HELP." SET "
                ." see_status=1");
        }
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_NEED_HELP." "
            ." WHERE 1 ".$where." "
            ." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'canshu'=>$param
        );
    }

}