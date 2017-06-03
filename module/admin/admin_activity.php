<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_activity extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //获取优惠卷分类
    public function getCouponCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COUPON_CATEGORY." WHERE 1=1 "
            ." ORDER BY id ASC");
        return $data;
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
        if(isset($this->data['store_name']) && !empty($this->data['store_name']))
        {
            $where .= " AND S.store_name LIKE '%".$this->data['store_name']."%'";
            $canshu .= "&store_name=".$this->data['store_name'];
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
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            .TABLE_COUPON." AS C LEFT JOIN ".TABLE_COUPON_CATEGORY." AS CC ON "
            ."C.coupon_type=CC.id LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id=S.store_id WHERE 1 "
            .$where." ");


        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,CC.type_name,U.nickname,S.store_name "
            ."FROM ".TABLE_COUPON." AS C LEFT JOIN ".TABLE_COUPON_CATEGORY." AS CC ON "
            ."C.coupon_type=CC.id LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid "
            ."LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id=S.store_id WHERE 1 "
            .$where." ORDER BY C.id ASC "
            ." LIMIT ".($curpage-1)*$page_size.",".$page_size." ");

        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    //获得一条优惠卷信息
    public function getOneCoupon()
    {

        $data = $this->GetDBSlave1()->queryrow("SELECT C.*,CC.type_name,U.nickname,S.store_name "
            ."FROM ".TABLE_COUPON." AS C LEFT JOIN ".TABLE_COUPON_CATEGORY." AS CC ON "
            ."C.coupon_type=CC.id LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid "
            ."LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id=S.store_id WHERE 1 "
            ." AND C.id='".$this->data['id']."' ");
        $category = $this->getCouponProductCategory();
        $cat = array();
        if(!empty($category))
        {
            foreach($category as $item)
            {
                $cat[$item['category_id']]=$item;
            }
        }
        return array('data'=>$data,'category'=>$cat);
    }
    //优惠卷限制分类的名称
    public function getCouponProductCategory()
    {
        $category = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CATEGORY." ");
        return $category;
    }
    //分类下的优惠卷
    public function getCouponByCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT T.*,S.store_name FROM ".TABLE_COUPON_TYPE." AS T "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON T.store_id=S.store_id "
            ." WHERE T.type_id ='".$this->data['id']."' "
            ." ORDER BY id DESC");
        return $data;
    }
    //产品分类
    public function getProductCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_CATEGORY." "
            ." WHERE category_parent_id = 0 "
            ." ORDER BY category_id ASC ");
        $cat_details =array();
        if(!empty($data))
        {
            foreach ($data as $item)
            {
                $cat_details[$item['category_id']] = $item;
            }
        }
        return array('data'=>$data,'cat_details'=>$cat_details);
    }
    //公用卷模板
    public function getStoreCouponType()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT T.*,C.type_name,ST.id as tid,ST.coupon_key"
            .",ST.start_time,ST.end_time,ST.is_show FROM ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON ST.type_id = T.id "
            ." LEFT JOIN ".TABLE_COUPON_CATEGORY." AS C ON T.type_id = C.id "
            ." WHERE ST.store_id =0 "
            ." ORDER BY id DESC");
        return $data;
    }
}