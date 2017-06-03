<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class weidian extends wx
{
    function __construct($data)
    {
        $this->data = $data;
    }


    //获取广告信息,ad_type 为0时不区分
    function GetCommAd($v_shop='',$sort='DESC',$limit=1,$ad_type=0,$default_style='default')
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_AD." "
            ." WHERE default_style='".$default_style."' "
            ." AND ad_type='".$ad_type."' "
            ." AND v_shop='".$v_shop."' "
            ." ORDER BY ry_order ".$sort." LIMIT 0,".$limit."");
        return $data;
    }


    function GetProduct()
    {
        $page_size = 6;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = intval($this->data['page']);
        }else{
            $page = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." "
            ." WHERE store_id='".$this->GetStoreId()."' AND is_del=0 AND product_status=0");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_PRODUCT." WHERE "
            ."store_id='".$this->GetStoreId()."' AND is_del=0 AND product_status=0 "
            ." ORDER BY product_id DESC LIMIT ".($page-1)*$page_size.",".$page_size." ");
        $array = array('data'=>$data,'pages'=>ceil($count['total']/$page_size));
        if(regExp::is_ajax())
        {
            echo json_encode($array);exit;
        }
        return $array;
    }







}