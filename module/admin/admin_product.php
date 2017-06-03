<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_product extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //商品列表
    public function GetProductList($product_status=0)
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['product_name']) && !empty($this->data['product_name']))
        {
            $where .= " AND P.product_name LIKE '%".$this->data['product_name']."%'";
            $where .= " OR S.store_name LIKE '%".$this->data['product_name']."%'";
            $where .= " OR P.product_id = '".$this->data['product_name']."'";
            $canshu .= "&product_name=".$this->data['product_name'];
        }
        if(isset($this->data['category_name']) && !empty($this->data['category_name']))
        {
            $where .= " AND P.category_name LIKE '%".$this->data['category_name']."%'";
            $canshu .= "&category_name=".$this->data['category_name'];
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." AS P "
            ."LEFT JOIN ".TABLE_COMM_CATEGORY." AS PC ON P.category_id=PC.category_id "
            ."LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ."LEFT JOIN ".TABLE_PRODUCT_CHOICE." AS C ON P.product_id=C.product_id "
            ."LEFT JOIN ".TABLE_SEKILL_PRODUCT." AS SP ON P.product_id=SP.product_id "
            ."WHERE P.is_del=0 AND P.product_status='".$product_status."' ".$where." ");


        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,PC.category_name,S.store_name"
            .",IFNULL(C.show_status,1) AS show_status,IFNULL(G.group_status,1) AS group_status"
            .",IFNULL(SP.seckill_status,1) AS seckill_status FROM ".TABLE_PRODUCT." AS P "
            ."LEFT JOIN ".TABLE_COMM_CATEGORY." AS PC ON P.category_id=PC.category_id "
            ."LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ."LEFT JOIN ".TABLE_PRODUCT_CHOICE." AS C ON P.product_id=C.product_id "
            ."LEFT JOIN ".TABLE_GROUP_PRODUCT." AS G ON P.product_id=G.product_id "
            ."LEFT JOIN ".TABLE_SEKILL_PRODUCT." AS SP ON P.product_id=SP.product_id "
            ."WHERE P.is_del=0 AND P.product_status='".$product_status."' "
            .$where." ORDER BY P.product_id DESC "
            ." LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }

    //取一条产品
    public function GetOneProduct($product_id)
    {
         $product = $this->GetDBSlave1()->queryrow("SELECT P.*,PD.product_text,PD.product_flash"
             .",PD.product_param FROM ".TABLE_PRODUCT." "
            ." AS P LEFT JOIN ".TABLE_PRODUCT_DETAIL." AS PD ON P.product_id=PD.product_id "
            ." WHERE P.product_id='".$product_id."' AND  P.is_del=0");
            if(empty($product))
            {
                include RPC_DIR .TEMPLATEPATH.'/admin/_comm/_waring_1_tpl.php';exit;
            }
        return $product;
    }
    //产品分类
    public function GetCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE 1 "
            ." ORDER BY category_sort ASC,category_id DESC");
        $array = array();
        $array1 = array();
        $i = 0;
        foreach($data as $item){
            $array[$item['category_parent_id']][$i] = $item;
            $array1[$item['category_id']] = $item['category_name'];
            $i++;
        }
        return array('category'=>$array,'type'=>$array1);
    }
    //产品详情
    public function GetProductDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $product = $this->GetOneProduct($this->data['id']);
        if(!$product)
        {
            redirect(ADMIN_ERROR);
        }
        return $product;
    }
    //产品属性列表
    public function GetProductAttr()
    {
        $product = $this->GetProductDetails();
        $attr = $this->GetProductAttrList($product['product_id']);
        return array('product'=>$product,'attr'=>$attr);
    }
    //产品属性列表
    public function GetProductAttrList($product_id)
    {
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE product_id='".$product_id."' AND is_del=0 "
            ." ORDER BY attr_type_name ASC");
        return $attr;
    }
    //产品属性
    public function GetProductAttrValue()
    {
        return $this->GetDBSlave1()->queryrows("SELECT TE.attr_name,TE.attr_id,TE.attr_type_id,T.attr_type_name FROM ".TABLE_ATTR_TEMP." "
            ." AS TE LEFT JOIN ".TABLE_ATTR_TYPE." AS T ON TE.attr_type_id=T.attr_type_id "
            ." ORDER BY TE.attr_type_id ASC");
    }
    //分类详情
    public function GetCategoryDetail(){
        if(!regExp::checkNULL($this->data['id'])){
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE "
            ." category_id='".$this->data['id']."'");
        if(!$data){
            redirect(ADMIN_ERROR);
        }
        $str = 0;
        if($data['category_parent_id']==0){
            $res = $this->GetDBSlave1()->queryrow("SELECT count(*) AS total FROM ".TABLE_COMM_CATEGORY." "
                ." WHERE category_parent_id='{$this->data['id']}'");
            if($res['total']>0){
                $str = 1;
            }
        }
        return array('data'=>$data,'str'=>$str);
    }

    //产品属性类型列表
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
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ATTR_TYPE." AS T "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON T.store_id=s.store_id "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT T.*,S.store_name FROM ".TABLE_ATTR_TYPE." AS T "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON T.store_id=s.store_id "
            ." WHERE 1 ".$where." ORDER BY T.store_id ASC,T.attr_type_id DESC "
            ." LIMIT ".($curpage-1)*$page_size.", ".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'page_size'=>$page_size,'canshu'=>$canshu,'curpage'=>$curpage);
    }
    //取一条产品属性类型
    public function GetAttrType($attr_type)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR_TYPE." "
            ." WHERE attr_type_id='".$attr_type."'");
    }
    //获取产品属性类型详情
    public function GetAttrTypeDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetAttrType($this->data['id']);
        if(!$data)
        {
            redirect(ADMIN_ERROR);
        }
        return $data;
    }
    //产品子属性列表
    public function GetAttrValueList()
    {
        $where = $canshu  = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $where .= " AND TE.attr_type_id='".$this->data['id']."' ";
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ATTR_TEMP." AS TE "
            ."WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT TE.*,T.attr_type_name FROM ".TABLE_ATTR_TEMP." AS "
            ."TE LEFT JOIN ".TABLE_ATTR_TYPE." AS T ON TE.attr_type_id=T.attr_type_id WHERE 1 ".$where." "
            ."ORDER BY TE.attr_id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'page_size'=>$page_size,'canshu'=>$canshu,'curpage'=>$curpage);
    }
    //子属性模板取一条
    public function GetOneAttrValue($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR_TEMP." "
            ." WHERE attr_id='".$id."'");
    }
    //子属性属性模板详情
    public function GetAttrValueDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetOneAttrValue($this->data['id']);
        if(!$data)
        {
            redirect(ADMIN_ERROR);
        }
        return $data;
    }
    //获取团购产品
    function GetGroupProduct()
    {
        $array = array();
        $data = $this->GetDBSlave1()->queryrows("SELECT product_id FROM ".TABLE_GROUP_PRODUCT." ");
        if($data)
        {
            foreach($data as $item)
            {
                $array[] = $item['product_id'];
            }
        }
        return $array;
    }

}