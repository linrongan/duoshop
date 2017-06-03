<?php
class category extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    /*
     * 一级分类
     * */
    function GetAllCategory()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_CATEGORY."  "
            ." WHERE category_show=0 ORDER BY category_sort ASC");
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

    /*
     * 指定分类
     * */
    function GetOneCategory($category_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY."  "
            ." WHERE category_id='".$category_id."' "
            ."");
    }

    //获取分类
    public function GetCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_CATEGORY." "
            ." WHERE category_show=0 "
            ." ORDER BY category_parent_id,category_sort,category_id ASC");
        $category = array();
        $category_info = array();
        $i=0;
        foreach($data as $item)
        {
            $category[$item['category_parent_id']][$i] = $item;
            $category_info[$item['category_parent_id']][$item['category_id']] = $item;
            $i++;
        }
        return array('category'=>$category,'data'=>$data,'info'=>$category_info);
    }

}