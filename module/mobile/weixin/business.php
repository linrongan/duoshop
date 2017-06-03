<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class business extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //获取商家专享的商品列表
    function GetBusinessProduct($page_size=12)
    {
        $where = $canshu = $order =  $category_canshu = '';
        if(isset($this->data['page']) && !empty($this->data['page']) && regExp::is_positive_number($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page  = 1;
        }
        if(isset($this->data['page_size']) && regExp::is_positive_number($this->data['page_size']))
        {
            $page_size = $this->data['page_size'];
        }
        if(isset($this->data['keyword']) && !empty($this->data['keyword']))
        {
            $where .= " AND product_name LIKE '%".$this->data['keyword']."%'";
            $canshu .="&keyword=".$this->data['keyword'];
        }
        if(isset($this->data['serach']) && !empty($this->data['serach']))
        {
            $where .= " AND product_name LIKE '%".$this->data['serach']."%'";
            $canshu .="&serach=".$this->data['serach'];
        }
        if(isset($this->data['category']) && !empty($this->data['category']))
        {
            $where .= " AND category_id='".$this->data['category']."'";
            $category_canshu .= "&category=".$this->data['category'].'&category_name='.
                (isset($this->data['category_name'])?$this->data['category_name']:'');
        }

        $filed = array(
            'zh'=>' ORDER BY P.product_id DESC,P.product_sold DESC',
            'xl'=>' ORDER BY P.product_sold DESC',
            'xp'=>' ORDER BY P.product_id DESC',
            'jg-a'=>' ORDER BY P.product_price ASC',
            'jg-d'=>' ORDER BY P.product_price DESC'
        );
        $default_sort = true;
        $sort = '';
        $sort_canshu = '';
        if(isset($this->data['sort']) && array_key_exists($this->data['sort'],$filed))
        {
            $sort = $this->data['sort'];
            $order .= $filed[$this->data['sort']];
            $default_sort = false;
        }
        if($sort)
        {
            $sort_canshu.='&sort='.$sort;
        }
        if($default_sort)
        {
            $order .= $filed['zh'];
            $sort = 'zh';
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." "
            ." AS P LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id WHERE "
            ." P.product_status=0 AND P.is_del=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.product_id,P.category_id,P.category_name,"
            ." P.product_name,P.product_img,P.product_desc,P.product_unit,P.product_price,"
            ." P.product_fake_price,P.product_sold,P.comment_count,P.comment_good_count,"
            ." P.comment_bad_count,ship_methed,P.seven_return,P.ship_city,S.store_name,S.store_id FROM ".TABLE_PRODUCT."  AS P"
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 AND P.product_status=0 "
            ." AND P.business_buy>0 ".$where." ".$order."  LIMIT ".($page-1)*$page_size.",".$page_size."");
        $data = array(
            'data'=>$data,
            'pages'=>ceil($count['total'])/$page_size,
            'sort'=>$sort,
            'canshu'=>$canshu,
            'sort_canshu'=>$sort_canshu,
            'category_canshu'=>$category_canshu
        );
        if(regExp::is_ajax())
        {
            echo json_encode($data);exit;
        }
        return $data;
    }
}