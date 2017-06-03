<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class weidian extends wx
{
    protected $store_id;
    function __construct($data,$store_id)
    {
        $this->data = $data;
        $this->store_id = $store_id;
    }

    /*
    * 优惠券首页
    */
    function GetStoreCoupon()
    {
        $date = date("Y-m-d H:i:s");
        $data= $this->GetDBSlave1()->queryrows("SELECT ST.*,T.min_money,T.coupon_money FROM  ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON T.id=ST.type_id"
            ." WHERE ST.store_id='".$this->store_id."' "
            ." AND ST.start_time<'".$date."' "
            ." AND ST.end_time>'".$date."' "
            ." AND T.default_sent=1 "
            ." ORDER BY coupon_money ASC LIMIT 0,8");
        return $data;
    }

    //获取广告信息,ad_type 为0时不区分
    function GetCommAd($sort='DESC',$limit=1,$ad_type=0)
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_AD." "
            ." WHERE ad_type='".$ad_type."' "
            ." AND store_id='".$this->store_id."' "
            ." ORDER BY ry_order ".$sort." LIMIT 0,".$limit."");
        return $data;
    }


    //选择商品
    function GetProduct()
    {
        $page_size = 24;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = intval($this->data['page']);
        }else{
            $page = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." "
            ." WHERE store_id='".$this->store_id."' AND is_del=0 AND product_status=0 AND is_home=1");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_PRODUCT." WHERE "
            ." store_id='".$this->store_id."' AND is_del=0 AND product_status=0 AND is_home=1"
            ." ORDER BY product_id DESC LIMIT ".($page-1)*$page_size.",".$page_size." ");
        $array = array('data'=>$data,'pages'=>ceil($count['total']/$page_size));
        if(regExp::is_ajax())
        {
            echo json_encode($array);exit;
        }
        return $array;
    }

    //选择精选商品
    function GetChoiceProduct()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,P.product_img,P.product_price,P.product_fake_price FROM "
            ." ".TABLE_SHOP_PRODUCT_CHOICE." AS C "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON C.product_id=P.product_id "
            ." WHERE P.store_id='".$this->store_id."'  AND P.is_del=0 AND P.product_status=0 "
            ." AND C.choice_status=0 "
            ." ORDER BY C.choice_sort ASC LIMIT 6 ");
        return $data;
    }
}