<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class category extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //产品分类
    public function GetCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE show_status=0 ORDER BY category_id,ry_order ASC");
        $category = array();
        $parent = array();
        foreach($data as $item)
        {
            if($item['parent_id']==0)
            {
                $parent[] = $item['category_id'];
            }
            $category[$item['parent_id']][$item['category_id']]['category_id'] = $item['category_id'];
            $category[$item['parent_id']][$item['category_id']]['category_name'] = $item['category_name'];
            $category[$item['parent_id']][$item['category_id']]['category_img'] = $item['category_img'];
        }
        if(isset($this->data['category']) && !empty($this->data['category']))
        {
            $select = $this->data['category'];
        }else{
            $select = $parent[0];
        }
        return array('category'=>$category,'data'=>$data,'select'=>$select);
    }



    //分类
    function GetCategoryProduct()
    {
        $where = $param = $order ='';
        $page_size = 6;
        $title = '全部产品';
        $category = '';
        if(isset($this->data['category_id']) && !empty($this->data['category_id']))
        {
            $category = $this->GetOneCategory($this->data['category_id']);
            if(!empty($category) && $category['parent_id'])
            {
                $where .= " AND category_id='".$this->data['category_id']."'";
                $title = $category['category_name'];
            }
        }
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = intval($this->data['page']);
        }else{
            $page = 1;
        }
        $store_id = $this->GetStoreId();
        if(isset($this->data['zh']) && !empty($this->data['zh']))
        {
            $order .= " ORDER BY product_id DESC,product_sold DESC,product_price ASC";
        }elseif(isset($this->data['xl']) && !empty($this->data['xl']))
        {
            $order .= " ORDER BY product_sold DESC";
        }elseif(isset($this->data['xp']) && !empty($this->data['xp']))
        {
            $order .= " ORDER BY product_id DESC";
        }elseif(isset($this->data['jg']) && !empty($this->data['jg']))
        {
            switch ($this->data['jg'])
            {
                case 1:
                    $order .= " ORDER BY product_price DESC";
                    break;
                case 2:
                    $order .= " ORDER BY product_price ASC";
                    break;
            }
        }
        if(isset($this->data['search']) && !empty($this->data['search']))
        {
            $where .= " AND product_name LIKE '%".$this->data['search']."%'";
        }
        if(empty($order))
        {
            $order .= " ORDER BY product_id DESC,product_sold DESC,product_price ASC";
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." "
            ." WHERE 1 AND store_id='".$store_id."'");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_PRODUCT." WHERE "
            ." 1 AND store_id='".$store_id."' "
            ." ".$where." ".$order." LIMIT ".($page-1)*$page_size.",".$page_size." ");
        $array = array('data'=>$data,'category'=>$category,'pages'=>ceil($count['total']/$page_size),'title'=>$title);
        if(regExp::is_ajax())
        {
            echo json_encode($array);exit;
        }
        return $array;
    }

    function GetOneCategory($category_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." WHERE "
            ."category_id='".$category_id."'");
    }
}