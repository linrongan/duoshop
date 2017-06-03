<?php
class search extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }




    //店铺列表
    function GetStoreList()
    {
        $where = '';
        $where1 = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        if(isset($this->data['keyword']) && !empty($this->data['keyword']))
        {
            $where .= " AND s.store_name LIKE '%".$this->data['keyword']."%' OR "
                ." P.product_name LIKE '%".$this->data['keyword']."%'";
        }
        $data = $this->GetDBSlave1()->queryrows("SELECT s.store_name,s.store_id,s.store_logo,s.store_describe,s.follow_count,"
            ."s.store_url,GROUP_CONCAT(p.product_id,'&',p.product_name,'&',p.product_img SEPARATOR '&&') AS shop_pro FROM "
            ."comm_store AS s LEFT JOIN ".TABLE_PRODUCT." AS p ON s.store_id = p.store_id "
            ."WHERE p.product_id IN (SELECT product_id FROM d_product WHERE "
            ."store_id = s.store_id ORDER BY product_sold DESC) "
            ." ".$where." GROUP BY s.store_id ORDER BY s.follow_count DESC LIMIT 0,10");
        return $data;
    }


    function Search()
    {
        $keyword = $this->data['search']?$this->data['search']:'';
        $search_type = $this->data['search_type']
        && ($this->data['search_type']==1 || $this->data['search_type']==2)?
            $this->data['search_type']:1;
        if($search_type==1)
        {
            redirect('/?mod=weixin&v_mod=product&keyword='.$keyword);
        }else{
            redirect('/?mod=weixin&v_mod=search&_index=_shop&keyword='.$keyword);
        }
    }
}