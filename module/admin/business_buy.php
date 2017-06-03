<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class business_buy extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    function GetBusinessBuyProduct($business_buy=1)
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['product_name']) && !empty($this->data['product_name']))
        {
            $where .= " AND product_name LIKE '%".$this->data['product_name']."%'";
            $where .= " OR P.product_id = '".$this->data['product_name']."'";
            $canshu .= "&product_name=".$this->data['product_name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 AND P.business_buy = '".$business_buy."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,S.store_name FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 AND P.business_buy = '".$business_buy."' ".$where." "
            ." ORDER BY P.product_id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
}