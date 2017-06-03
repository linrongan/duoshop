<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class category extends wx
{
    function __construct($data,$store_id)
    {
        $this->data = $data;
        $this->store_id = $store_id;
    }

    /*
      * 一级分类
      * */
    function GetAllCategory()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE "
            ."category_show=0 ORDER BY category_sort ASC");
    }

    /*
     * 分类数据
     * */
    function GetCategoryInfo()
    {
        $select = 0;
        $array = array();
        $category_item = array();
        $category = $this->GetAllCategory();
        if($category)
        {
            if(isset($this->data['category']) && !empty($this->data['category']))
            {
                $select_category = $this->GetOneCategory($this->data['category']);
                if($select_category && $select_category['category_parent_id']==0)
                {
                    $select = $select_category['category_id'];
                }else{
                    $select = $category[0]['category_id'];
                }
            }else{
                $select = $category[0]['category_id'];
            }
            $parent_items = array();
            foreach($category as $item)
            {
                if($item['category_parent_id']==0)
                {
                    $parent_items[] = $item['category_id'];
                }
                if(in_array($item['category_parent_id'],$parent_items))
                {
                    unset($item);
                    continue;
                }
                $category_item[$item['category_parent_id']][$item['category_id']] = $item;
            }
        }
        $array['select'] = $select;
        $array['category'] = $category_item;
        return $array;
    }


    //分类
    function  GetAllProduct($page_size=8)
    {
        $where = $canshu = $order = $title = $category_canshu = '';
        $title = '全部产品';
        $where = " AND P.store_id=".$this->store_id."";
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
            $pro_category = $this->GetOneCategory($this->data['category']);
            if($pro_category)
            {
                $where .= " AND category_id='".$this->data['category']."'";
                $title = $pro_category['category_name'];
                $category_canshu .= "&category=".$this->data['category'];
            }
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
            ."P.product_name,P.product_img,P.product_desc,P.product_unit,P.product_price,"
            ."P.product_fake_price,P.product_sold,P.comment_count,P.comment_good_count,"
            ."P.comment_bad_count,ship_methed,P.seven_return,P.ship_city,"
            ."S.store_name,S.store_id FROM ".TABLE_PRODUCT." "
            ." AS P LEFT JOIN ".TABLE_COMM_STORE." "
            ."AS S ON P.store_id=S.store_id  WHERE P.is_del=0 AND "
            ."product_status=0 ".$where." ".$order."  LIMIT ".($page-1)*$page_size.",".$page_size."");
        $data = array(
            'data'=>$data,
            'pages'=>ceil($count['total'])/$page_size,
            'sort'=>$sort,
            'canshu'=>$canshu,
            'sort_canshu'=>$sort_canshu,
            'category_canshu'=>$category_canshu,
            'title'=>$title
        );
        if(regExp::is_ajax())
        {
            echo json_encode($data);exit;
        }

        return $data;
    }


    function GetOneCategory($category_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE "
            ."category_id='".$category_id."'");
    }



    //获取分类
    public function GetCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_CATEGORY." "
            ." WHERE category_show=0 ORDER BY category_sort,category_parent_id ASC");
        $category = array();
        foreach($data as $item)
        {
            $category[$item['category_parent_id']][$item['category_id']]['category_id'] = $item['category_id'];
            $category[$item['category_parent_id']][$item['category_id']]['category_name'] = $item['category_name'];
            $category[$item['category_parent_id']][$item['category_id']]['category_img'] = $item['category_img'];
            $category[$item['category_parent_id']][$item['category_id']]['category_parent_id'] = $item['category_parent_id'];
        }
        return array('category'=>$category,'data'=>$data);
    }


    function GetStoreProCategory()
    {
        $array =array();
        $data = $this->GetDBSlave1()->queryrows("SELECT DISTINCT LE.category_id FROM ".TABLE_PRODUCT." AS P LEFT JOIN ".TABLE_COMM_CATEGORY." "
            ." AS TH ON P.category_id=TH.category_id LEFT JOIN ".TABLE_COMM_CATEGORY." AS TW ON TH.category_parent_id=TW.category_id LEFT JOIN "
            ." ".TABLE_COMM_CATEGORY." AS LE ON TW.category_parent_id=LE.category_id WHERE P.store_id=".$this->store_id." AND LE.category_id IS NOT NULL");
        if($data)
        {
            foreach($data as $v)
            {
                $array[] = $v['category_id'];
            }
        }
        return $array;
    }





}