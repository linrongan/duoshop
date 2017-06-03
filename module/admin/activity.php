<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class activity extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //获取优惠卷分类
    public function getCouponCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COUPON_CATEGORY." WHERE 1=1 "
            ." ORDER BY id ASC");
        return $data;
    }

    //分类下的优惠卷
    public function getCouponByCategory()
    {
        $type = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COUPON_STORE_TYPE." "
            ." WHERE store_id ='".$_SESSION['admin_store_id']."' ");
        $id='0,';
        for($i=0;$i<count($type);$i++)
        {
            $id .= $type[$i]['type_id'].',';
        }
        $id = rtrim($id,',');

        $data = $this->GetDBSlave1()->queryrows("SELECT T.* FROM ".TABLE_COUPON_TYPE." AS T "
            ." WHERE T.type_id ='".$this->data['id']."' AND jurisdiction = 1 AND store_id = 0 "
            ." AND T.id not in (".$id.") AND T.default_sent=1 ORDER BY id DESC");
        return $data;
    }

    //商户卷模板
    public function getStoreCouponType()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON ST.type_id = T.id "
            ." LEFT JOIN ".TABLE_COUPON_CATEGORY." AS C ON T.type_id = C.id "
            ." WHERE ST.store_id='".$_SESSION['admin_store_id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT ST.*,T.min_money,T.coupon_money,T.default_sent"
            .",C.type_name FROM ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON ST.type_id = T.id "
            ." LEFT JOIN ".TABLE_COUPON_CATEGORY." AS C ON T.type_id = C.id "
            ." WHERE ST.store_id ='".$_SESSION['admin_store_id']."' ".$where." "
            ." ORDER BY id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    //获取优惠券列表
    public function getCouponList()
    {

        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['coupon_name']) && !empty($this->data['coupon_name']))
        {
            $where .= " AND C.coupon_name LIKE '%".$this->data['coupon_name']."%'";
            $canshu .= "&coupon_name=".$this->data['coupon_name'];
        }
        if(isset($this->data['coupon_type']) && !empty($this->data['coupon_type']))
        {
            $where .= " AND C.coupon_type = '".$this->data['coupon_type']."'";
            $canshu .= "&coupon_type=".$this->data['coupon_type'];
        }
        if(isset($this->data['use_status']) && is_numeric($this->data['use_status']))
        {
            $where .= " AND C.use_status = '".$this->data['use_status']."'";
            $canshu .= "&use_status=".$this->data['use_status'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_COUPON." AS C "
            ." LEFT JOIN ".TABLE_COUPON_CATEGORY." AS CC ON C.coupon_type=CC.id "
            ." LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid "
            ." WHERE C.store_id='".$_SESSION['admin_store_id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,CC.type_name,U.nickname FROM ".TABLE_COUPON." AS C "
            ." LEFT JOIN ".TABLE_COUPON_CATEGORY." AS CC ON C.coupon_type=CC.id "
            ." LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid "
            ." WHERE C.store_id='".$_SESSION['admin_store_id']."' ".$where." ORDER BY C.id ASC "
            ." LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }

}