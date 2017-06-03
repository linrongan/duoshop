<?php
class group_product extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //团购产品列表
    public function GetGroupProduct()
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

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GROUP_PRODUCT." AS G"
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id = P.product_id "
            ." WHERE group_status=0 ".$where." ");

        $data = $this->GetDBSlave1()->queryrows("SELECT G.*,P.product_name,P.product_img,P.product_fake_price,P.product_price"
            ." FROM ".TABLE_GROUP_PRODUCT." AS G"
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id=P.product_id "
            ." WHERE G.group_status=0 ".$where." ORDER BY G.group_sort ASC,G.product_id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");

        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);

    }


    //团购产品详情
    public function GetGroupProductDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GROUP_PRODUCT." "
            ." WHERE product_id='".$this->data['id']."' ");
        if(!$data)
        {
            redirect(ADMIN_ERROR);
        }
        return $data;
    }

    //产品详情
    function GetProductDetails()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT."  "
            ."  WHERE product_id='".$this->data['id']."'");
    }


    //获取需要添加的团购产品
    function getSelectProduct()
    {
        if(!isset($this->data['product_id']))
        {
            redirect(ADMIN_ERROR);
        }
        include "product.php";
        $product = new product($this->data);
        $data = $product->GetOneProduct($this->data['product_id']);
        if(!$data)
        {
            exit('产品不存在');
        }
        $group = $this->GetOneGroupProduct($this->data['product_id']);
        if($group)
        {
            exit('产品已添加');
        }
        return $data;
    }

    //获取一条团购产品
    function GetOneGroupProduct($product_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GROUP_PRODUCT." "
            ." WHERE product_id='".$product_id."'");
    }
}

