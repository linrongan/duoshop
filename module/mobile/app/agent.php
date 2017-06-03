<?php
class agent extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //代发商品列表
    function GetAgentProduct()
    {
        $where = $order = $canshu = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        if(isset($this->data['search']) && !empty($this->data['search']))
        {
            $where .= " AND product_name LIKE '%".$this->data['search']."%'";
        }
        if(isset($this->data['category']) && !empty($this->data['category']))
        {
            $where .= " AND category_id='".$this->data['category']."'";
            $canshu .="&category=".$this->data['category'];
        }
        $filed = array(
            'zh'=>' ORDER BY A.agent_sort ASC,A.product_id DESC',
            'xl'=>' ORDER BY A.agent_sold DESC',
            'xp'=>' ORDER BY A.addtime DESC',
            'jg-a'=>' ORDER BY A.agent_price ASC',
            'jg-d'=>' ORDER BY A.agent_price DESC'
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
            $sort_canshu .= "&sort=".$sort;
        }
        if($default_sort)
        {
            $order .= $filed['zh'];
            $sort = 'zh';
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT_AGENT." AS A"
            ."  LEFT JOIN ".TABLE_PRODUCT." AS P ON A.product_id=P.product_id  "
            ."  WHERE A.agent_status=0 AND P.product_status=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,P.product_name,P.product_desc,"
            ." P.product_img,P.product_price,S.store_name,S.store_logo FROM ".TABLE_PRODUCT_AGENT." AS A "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON A.product_id=P.product_id  "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE A.agent_status=0  AND P.product_status=0 ".$where." ".$order."  "
            ." LIMIT ".($page-1)*$page_size.",".$page_size."");
        $return=array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size),
            'sort'=>$sort,
            'canshu'=>$canshu,
            'sort_canshu'=>$sort_canshu
        );
        if(regExp::is_ajax())
        {
            die(json_encode($return));
        }
        return $return;
    }
    /*
     *
     * */
    function GetCheckIsAgentProduct()
    {
        $data =  $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_AGENT." "
            ." WHERE agent_status=0  AND product_id = '".$this->data['id']."'");
        if(!empty($data))
        {
            return true;
        }
        return false;
    }
}