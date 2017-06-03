<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_sekill extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //秒杀商品列表
    public function getProductSekillList()
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
        if(isset($this->data['quantum_id']) && !empty($this->data['quantum_id']))
        {
            $where .= " AND S.quantum_id = '".$this->data['quantum_id']."'";
            $canshu .= "&quantum_id=".$this->data['quantum_id'];
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_SEKILL_PRODUCT." AS S "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON S.product_id = P.product_id "
            ." LEFT JOIN ".TABLE_SEKILL_QUANTUM." AS Q ON S.quantum_id = Q.quantum_id "
            ." WHERE P.is_del=0 AND S.seckill_status=0  ".$where."");
        $data = $this->GetDBSlave1()->queryrows("SELECT S.*,P.product_unit,P.product_name,P.product_img,P.product_fake_price,P.product_price,"
            ."Q.* FROM ".TABLE_SEKILL_PRODUCT." AS S "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON S.product_id = P.product_id "
            ." LEFT JOIN ".TABLE_SEKILL_QUANTUM." AS Q ON S.quantum_id = Q.quantum_id "
            ." WHERE P.is_del=0 AND  S.seckill_status=0 ".$where." "
            ." ORDER BY start_day DESC,S.quantum_id DESC,S.seckill_sort ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);

    }
    //秒杀场次
    public function getSekillQuantum()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_SEKILL_QUANTUM." "
            ."  ORDER BY quantum ASC ");
        return $data;
    }
    //秒杀详情
    public function GetOneSekillProduct($product_id)
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT S.* FROM ".TABLE_SEKILL_PRODUCT." AS S "
            ." WHERE S.product_id = '".$product_id."'");
        return $data;
    }

    //产品详情
    function GetProductDetails()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT."  "
            ."  WHERE product_id='".$this->data['id']."'");
    }
}