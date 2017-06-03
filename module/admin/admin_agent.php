<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_agent extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    public function GetAgentProduct()
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
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT_AGENT." AS A "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON A.product_id = P.product_id "
            ." WHERE P.is_del=0 AND A.agent_status = 0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,P.product_name,P.product_img,P.product_fake_price,P.product_price"
            ." FROM ".TABLE_PRODUCT_AGENT." AS A "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON A.product_id = P.product_id "
            ." WHERE P.is_del=0 AND A.agent_status = 0 ".$where." "
            ." ORDER BY A.agent_sort ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    //商品列表
    public function GetProductList()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['product_name']) && !empty($this->data['product_name']))
        {
            $where .= " AND P.product_name LIKE '%".$this->data['product_name']."%' OR S.store_name LIKE '%".$this->data['product_name']."%' ";
            $param .= "&product_name=".$this->data['product_name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,S.store_name FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 ".$where." "
            ." ORDER BY P.product_id DESC LIMIT "
            ." ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }
    //代发详情
    public function GetAgentProductDetail()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_AGENT." AS A "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON A.product_id = P.product_id "
            ." WHERE P.is_del=0 AND A.id='".$this->data['id']."'");
        return $data;
    }
}