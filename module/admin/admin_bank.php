<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_bank extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //银行列表
    public function GetBankList()
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
            $where .= " AND LEFT(bank_addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(bank_addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['bank_name']) && !empty($this->data['bank_name']))
        {
            $where .= " AND bank_name like '%".$this->data['bank_name']."%'";
            $canshu .='&bank_name='.$this->data['bank_name'];
        }
        if(isset($this->data['bank_initial']) && !empty($this->data['bank_initial']))
        {
            $where .= " AND bank_initial = '".strtoupper(trim($this->data['bank_initial']))."'";
            $canshu .='&bank_initial='.$this->data['bank_initial'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_BANK." "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_BANK." "
            ." WHERE 1 ".$where." "
            ." ORDER BY bank_initial ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //银行详情
    function GetBankDetail()
    {
        return $this->GetBankById($this->data['id']);
    }
    //f
    private function GetBankById($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANK." "
        ." WHERE id ='".$id."'");
    }
}