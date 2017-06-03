<?php
class choice_product extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //精选产品列表
    public function GetChoiceProduct()
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
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT_CHOICE." AS G"
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id = P.product_id "
            ." WHERE show_status=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT G.*,P.product_name,P.product_img,P.product_fake_price,P.product_price"
            ." FROM ".TABLE_PRODUCT_CHOICE." AS G"
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id = P.product_id "
            ." WHERE G.show_status=0 ".$where."  ORDER BY G.show_sort ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }


    //精选产品详情
    public function GetChoiceProductDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT G.*,P.product_name FROM ".TABLE_PRODUCT_CHOICE." AS G"
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id = P.product_id "
            ." WHERE G.product_id='".$this->data['id']."'");
        if(!$data)
        {
            redirect(ADMIN_ERROR);
        }
        return $data;
    }


    //获取一条团购产品
    function GetOneChoiceProduct($product_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_CHOICE." "
            ." WHERE product_id='".$product_id."'");
    }
}

