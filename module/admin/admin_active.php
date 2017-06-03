<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_active extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    public function GetActiveList()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_BANNER." "
            ." WHERE picture_type=1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_BANNER." "
            ." WHERE picture_type=1 ".$where." ORDER BY picture_sort ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");

        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    public function GetActiveCategory()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ACTIVE_CATEGORY." AS C "
            ." LEFT JOIN ".TABLE_O_BANNER." AS B ON C.c_parent_id=B.id "
            ." WHERE C.c_parent_id= '".$this->data['id']."' AND B.picture_type=1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,B.picture_title FROM ".TABLE_ACTIVE_CATEGORY." AS C "
            ." LEFT JOIN ".TABLE_O_BANNER." AS B ON C.c_parent_id=B.id "
            ." WHERE C.c_parent_id= '".$this->data['id']."' AND B.picture_type=1 ".$where
            ." ORDER BY C.c_sort ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    public function getActiveCategoryDetail()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ACTIVE_CATEGORY." "
            ." WHERE id= '".$this->data['id']."' ");
        return $data;
    }
    //主题产品
    public function GetActiveProduct()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ACTIVE_PRODUCT." AS AP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON AP.product_id=P.product_id "
            ." LEFT JOIN ".TABLE_ACTIVE_CATEGORY." AS C ON AP.c_id=C.id "
            ." WHERE AP.status=0 AND P.is_del=0 AND AP.c_id= '".$this->data['id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT AP.*,P.product_name,P.product_img,P.product_price"
            .",C.c_name FROM ".TABLE_ACTIVE_PRODUCT." AS AP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON AP.product_id=P.product_id "
            ." LEFT JOIN ".TABLE_ACTIVE_CATEGORY." AS C ON AP.c_id=C.id "
            ." WHERE AP.status=0 AND P.is_del=0 AND AP.c_id= '".$this->data['id']."' ".$where
            ." ORDER BY AP.sort ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        $category = $this->getActiveCategoryDetail();
        return array(
            "data"=>$data,
            "category"=>$category,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //添加主题产品页面
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
            $where .= " AND P.product_name LIKE '%".$this->data['product_name']."%'";
            $param .= "&product_name=".$this->data['product_name'];
        }
        if(isset($this->data['store_name']) && !empty($this->data['store_name']))
        {
            $where .= " AND S.store_name LIKE '%".$this->data['store_name']."%' ";
            $param .= "&store_name=".$this->data['store_name'];
        }
        $active_product = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ACTIVE_PRODUCT." "
            ." WHERE c_id= '".$this->data['id']."' ");
        $product_id='0,';
        for($i=0;$i<count($active_product);$i++)
        {
            $product_id .= $active_product[$i]['product_id'].',';
        }
        $product_id = rtrim($product_id,',');
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_ACTIVE_PRODUCT." AS C ON P.product_id=C.product_id "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 AND P.product_id not in (".$product_id.") ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,IFNULL(C.status,1) AS status,"
            ."S.store_name FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_ACTIVE_PRODUCT." AS C ON P.product_id=C.product_id "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 AND P.product_id not in (".$product_id.") ".$where." "
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
    public function getActiveProductDetail()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ACTIVE_PRODUCT." "
            ." WHERE product_id= '".$this->data['id']."' ");
        return $data;
    }
}