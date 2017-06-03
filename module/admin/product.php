<?php
class product extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //产品分类
    function GetProductCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_CATEGORY." "
            ." WHERE category_show=0 ORDER BY category_id ASC,category_id ASC");
        $category = array();
        $i = 0;
        foreach($data as $item)
        {
            $category[$item['category_parent_id']][$i] = $item;
            $i ++;
        }
        return $category;
    }


    //产品列表
    function GetProductList()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(product_addtime,10)>='".$this->data['start_date']."'";
            $param .= "&start_date=".$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(product_addtime,10)<='".$this->data['end_date']."'";
            $param .= "&end_date=".$this->data['end_date'];
        }
        if(isset($this->data['product_name']) && !empty($this->data['product_name']))
        {
            $where .= " AND P.product_name LIKE '%".$this->data['product_name']."%'";
            $param .= "&product_name=".$this->data['product_name'];
        }
        if(isset($this->data['category_name']) && !empty($this->data['category_name']))
        {
            $where .= " AND P.category_name LIKE '%".$this->data['category_name']."%'";
            $param .= "&category_name=".$this->data['category_name'];
        }
        if(isset($this->data['is_home']) && is_numeric($this->data['is_home']))
        {
            $where .= " AND P.is_home = '".$this->data['is_home']."'";
            $param .= "&is_home=".$this->data['is_home'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_SHOP_PRODUCT_CHOICE." AS C ON P.product_id=C.product_id "
            ." WHERE P.store_id='".$_SESSION['admin_store_id']."' AND P.is_del=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,IFNULL(C.choice_status,1) AS choice_status FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_SHOP_PRODUCT_CHOICE." AS C ON P.product_id=C.product_id "
            ." WHERE P.store_id='".$_SESSION['admin_store_id']."' AND P.is_del=0 ".$where." "
            ." ORDER BY P.product_id DESC LIMIT "
            ." ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }

    //产品编辑
    function GetProductDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            include RPC_DIR .TEMPLATEPATH.'/admin/_comm/_waring_1_tpl.php';exit;
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT P.*,PD.product_text,PD.product_flash,PD.product_param FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_PRODUCT_DETAIL." AS PD ON P.product_id=PD.product_id  "
            ." WHERE P.product_id='".$this->data['id']."' "
            ." AND P.store_id='".$_SESSION['admin_store_id']."' "
            ." AND P.is_del=0");
        if(empty($product))
        {
            include RPC_DIR .TEMPLATEPATH.'/admin/_comm/_waring_1_tpl.php';exit;
        }
        return $product;
    }

    //产品属性页面
    public function GetProductAttr()
    {
        $product = $this->GetProductDetails();
        $attr = $this->GetProductAttrList($product['product_id']);
        return array('product'=>$product,'attr'=>$attr);
    }
    //产品属性列表
    public function GetProductAttrList($product_id)
    {
        $product = $this->getCheckMyProduct($product_id);
        if(empty($product))
        {
            include RPC_DIR .TEMPLATEPATH.'/admin/_comm/_waring_1_tpl.php';exit;
        }
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE product_id='".$product_id."' AND is_del=0 "
            ." ORDER BY attr_type_name ASC");
        return $attr;
    }

    //产品属性
    public function GetProductAttrValue()
    {
        return $this->GetDBSlave1()->queryrows("SELECT TE.attr_name,TE.attr_id,TE.attr_type_id,"
            ."T.attr_type_name FROM ".TABLE_ATTR_TEMP." AS TE "
            ." LEFT JOIN ".TABLE_ATTR_TYPE." AS T ON TE.attr_type_id=T.attr_type_id "
            ." WHERE T.store_id = '".$_SESSION['admin_store_id']."' OR  T.store_id=0 "
            ." ORDER BY TE.attr_type_id ASC");
    }
    //判断是否是自己的商品
    protected function getCheckMyProduct($id)
    {
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$id."' AND store_id='".$_SESSION['admin_store_id']."' AND is_del=0");
        return $product;
    }

    //产品属性类型列表（商户）
    public function GetAttributesList()
    {
        $where = $canshu = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM  ".TABLE_ATTR_TYPE." "
            ." WHERE store_id = '".$_SESSION['admin_store_id']."' OR store_id=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR_TYPE." "
            ." WHERE store_id = '".$_SESSION['admin_store_id']."' OR store_id=0 ".$where." "
            ." ORDER BY store_id ASC,attr_sort DESC LIMIT ".($curpage-1)*$page_size.", ".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'page_size'=>$page_size,'canshu'=>$canshu,'curpage'=>$curpage);
    }
    //获取产品属性类型详情
    public function GetAttrTypeDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR_TYPE." "
            ." WHERE attr_type_id='".$this->data['id']."' AND store_id = '".$_SESSION['admin_store_id']."'");
    }
    //产品子属性列表
    public function GetAttrValueList()
    {
        $where = $canshu  = '';
        $page_size = 99;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $where .= " AND TE.attr_type_id='".$this->data['id']."' AND T.store_id = '".$_SESSION['admin_store_id']."'";
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ATTR_TEMP." AS TE "
            ." LEFT JOIN ".TABLE_ATTR_TYPE." AS T ON TE.attr_type_id=T.attr_type_id "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT TE.*,T.attr_type_name FROM ".TABLE_ATTR_TEMP." AS TE "
            ." LEFT JOIN ".TABLE_ATTR_TYPE." AS T ON TE.attr_type_id=T.attr_type_id "
            ." WHERE 1 ".$where." "
            ."ORDER BY TE.attr_id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'page_size'=>$page_size,'canshu'=>$canshu,'curpage'=>$curpage);
    }
    //子属性属性模板详情
    public function GetAttrValueDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR_TEMP." "
            ." WHERE attr_id='".$this->data['id']."'");
    }
    //产品属性编辑
    public function GetProductAttrDetails()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE product_id='".$this->data['id']."' AND is_del=0 "
            ." AND id = '".$this->data['aid']."'");
        return $data;
    }
}