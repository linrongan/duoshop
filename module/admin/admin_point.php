<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_point extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //获取积分礼品
    public function GetPointGiftList()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['name']) && !empty($this->data['name']))
        {
            $where .= " AND P.gift_name LIKE '%".$this->data['name']."%'";
            $canshu .= "&name=".$this->data['name'];
        }
        if(isset($this->data['category_id']) && !empty($this->data['category_id'])){
            $where .= " AND P.category_id='".$this->data['category_id']."'";
            $canshu .= "&category_id=".$this->data['category_id'];
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GIFT_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_GIFT_CATEGORY." AS C ON P.category_id=C.category_id "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,C.category_name FROM ".TABLE_GIFT_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_GIFT_CATEGORY." AS C ON P.category_id=C.category_id "
            ." WHERE 1 ".$where." ORDER BY id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");

        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu);
    }

    //商品分类
    public function GetProductCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_CATEGORY." ORDER BY ry_order ASC");
        return $data;
    }

    //礼品详情
    public function getGiftDetail()
    {

        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_PRODUCT."  "
            ." WHERE id='".$this->data['id']."'");
        return $data;
    }
    //获取积分礼品订单
    public function GetPointRecordList()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['name']) && !empty($this->data['name']))
        {
            $where .= " AND OD.gift_name LIKE '%".$this->data['name']."%'";
            $canshu .= "&name=".$this->data['name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GIFT_ORDER." AS D "
            ." LEFT JOIN ".TABLE_USER." AS U ON D.userid=U.userid "
            ." LEFT JOIN ".TABLE_GIFT_ORDER_DETAIL." AS OD ON D.orderid=OD.orderid "
            ." WHERE 1 ".$where." ");
        $data =$this->GetDBSlave1()->queryrows("SELECT D.*,U.nickname FROM ".TABLE_GIFT_ORDER." AS D "
            ." LEFT JOIN ".TABLE_USER." AS U ON D.userid=U.userid "
            ." LEFT JOIN ".TABLE_GIFT_ORDER_DETAIL." AS OD ON D.orderid=OD.orderid "
            ." WHERE 1 ".$where." "
            ." ORDER BY addtime DESC LIMIT  ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu);
    }
    //订单详情
    public function getRecordDetail()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_ORDER." "
            ." WHERE orderid='".$this->data['id']."'");
        return $data;
    }
    //获取某礼品订单详情
    public function GetGiftOrderDetail()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_ORDER_DETAIL." "
            ." WHERE orderid='".$this->data['id']."'");
        return $data;
    }
    //礼品分类
    public function GetPointCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_CATEGORY." ORDER BY ry_order ASC");
        return $data;
    }
    //获取分类的详情
    public function GetCategoryDetail()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_CATEGORY." "
            ." WHERE category_id='".$this->data['id']."'");
        return $data;
    }
    //物流列表
    public function GetLogisticsList()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_LOGISTICS." "
            ." ORDER BY logistics_letter ASC ");
        return $data;
    }
}