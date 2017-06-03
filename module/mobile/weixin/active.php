<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class active extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    public function GetActiveData($pid)
    {
        $category = $this->GetActiveCategory();
        $product = $this->GetActiveProduct($pid);
        return array(
            'category'=>$category,
            'product'=>$product
        );
    }
    private function GetActiveCategory()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_BANNER."  "
            ." WHERE picture_show=0 "
            ." AND picture_type = 1 "
            ." ORDER BY picture_sort ASC");
    }
    private function GetActiveProduct($pid)
    {
        $product =  $this->GetDBSlave1()->queryrows("SELECT AP.*,P.product_name,P.product_img,P.product_price"
            .",C.c_name,C.c_img FROM ".TABLE_ACTIVE_PRODUCT." AS AP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON AP.product_id=P.product_id "
            ." LEFT JOIN ".TABLE_ACTIVE_CATEGORY." AS C ON AP.c_id=C.id "
            ." WHERE AP.status=0 AND P.is_del=0 AND C.c_parent_id= '".$pid."'"
            ." ORDER BY C.c_sort ASC,AP.sort ASC"
        );
        $arr = array();
        if(!empty($product))
        {
            foreach($product as $item)
            {
                $arr[$item['c_id']]['product'][$item['product_id']]=$item;
                $arr[$item['c_id']]['c_name']=$item['c_name'];
                $arr[$item['c_id']]['c_img']=$item['c_img'];

            }
        }
        return $arr;
    }
}