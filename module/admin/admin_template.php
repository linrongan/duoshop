<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_template extends comm{
    //获取所以模板
    public function getAllTemplate()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_TEMPLATE." "
                ."ORDER BY template_id ASC");
        return $data;
    }
    //获取一条模板信息
    public function getThisTemplate()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * "
            ." FROM ".TABLE_COMM_TEMPLATE." "
            ." WHERE template_id='".$this->data['id']."'");
        return $data;
    }
    //模板销售记录
    public function getTemplateOrder()
    {
        $where=$canshu="";
        $page_size = 20;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(O.addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(O.addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['store_name']) && !empty($this->data['store_name']))
        {
            $where .= " AND S.store_name LIKE '%".$this->data['store_name']."%'";
            $canshu .='&store_name='.$this->data['store_name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_TEMPLATE_ORDER." AS O "
            ." LEFT JOIN ".TABLE_COMM_STORE."  AS S ON O.store_id=S.store_id "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT O.*,S.store_name FROM ".TABLE_TEMPLATE_ORDER." AS O "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON O.store_id=S.store_id WHERE 1 "
            .$where." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
}