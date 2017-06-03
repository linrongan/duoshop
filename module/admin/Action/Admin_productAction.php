<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_productAction extends admin_product
{
    //删除商品
    function ActionDelProduct()
    {
        $product = $this->GetOneProduct($this->data['id']);
        if(!$product)
        {
            return array("code"=>1,"msg"=>"产品不存在或已被删除！");
        }
        $res=$this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
            ." is_del = 1 WHERE product_id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //编辑产品
    function ActionEditProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id,is_del FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."' "
            ." AND is_del=0");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['product_name']))
        {
            return array('code'=>1,'msg'=>'请输入产品名称');
        }
        if(!regExp::checkNULL($this->data['category_id']))
        {
            return array('code'=>1,'msg'=>'请选择分类');
        }
        if(!regExp::checkNULL($this->data['product_fake_price']))
        {
            return array('code'=>1,'msg'=>'请输入原价');
        }
        if(!regExp::checkNULL($this->data['product_price']))
        {
            return array('code'=>1,'msg'=>'请输入售价');
        }
        if(!regExp::checkNULL($this->data['product_img']))
        {
            return array('code'=>1,'msg'=>'请上传产品封面');
        }
        if(!regExp::checkNULL($this->data['product_flash']))
        {
            return array('code'=>1,'msg'=>'请上传产品轮播图');
        }
        if(!regExp::checkNULL($this->data['product_text']))
        {
            return array('code'=>1,'msg'=>'请输入图文描述');
        }
        $category = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE "
            ." category_id='".$this->data['category_id']."'");
        if(empty($category))
        {
            return array('code'=>1,'msg'=>'分类是不存在的');
        }
        $check_is_last = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE category_parent_id='".$this->data['category_id']."'");
        if($check_is_last)
        {
            return array('code'=>1,'msg'=>'请选择最底下级分类');
        }
        $is_create_details = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_DETAIL." WHERE product_id='".$this->data['id']."'");
        if(!$is_create_details)
        {
            $this->GetDBMaster()->query("INSERT INTO ".TABLE_PRODUCT_DETAIL." SET product_id='".$this->data['id']."',"
                ." product_text='',product_flash=''");
        }
        $product_flash = !empty($this->data['product_flash']) && is_array($this->data['product_flash'])?json_encode($this->data['product_flash']):'';
        $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET category_id='".$this->data['category_id']."',"
            ." category_name='".$category['category_name']."',product_name='".$this->data['product_name']."',"
            ." product_img='".$this->data['product_img']."',product_desc='".$this->data['product_desc']."',"
            ." product_unit='".$this->data['product_unit']."',product_price='".$this->data['product_price']."',"
            ." product_fake_price='".$this->data['product_fake_price']."',product_sort='".$this->data['product_sort']."',"
            ." min_buy='".$this->data['min_buy']."',max_buy='".$this->data['max_buy']."',"
            ." product_status='".$this->data['product_status']."' WHERE product_id='".$this->data['id']."'");
        $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT_DETAIL." SET product_text='".$this->data['product_text']."',"
            ." product_param = '".$this->data['product_param']."', product_flash='".$product_flash."' WHERE product_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }

    //新增产品属性
    public function ActionNewProductAttr()
    {
        //exit;
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['product']))
        {
            return array('msg'=>'产品参数错误');
        }
        if(!regExp::checkNULL($this->data['attr_temp_id']))
        {
            return array('msg'=>'请选择属性');
        }
        $res = $this->GetDBSlave1()->queryrow("SELECT AT.attr_name,A.attr_type_name FROM "
            ." ".TABLE_ATTR_TEMP." AS AT LEFT JOIN ".TABLE_ATTR_TYPE." AS A "
            ." ON AT.attr_type_id=A.attr_type_id WHERE AT.attr_id='".$this->data['attr_temp_id']."'");
        if(!$res)
        {
            return array('msg'=>'属性不存在或已删除');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ATTR." "
            ."(product_id,attr_temp_id,attr_type_name,attr_temp_name,"
            ."product_attr_sort) VALUES('".$this->data['product']."',"
            ."'".$this->data['attr_temp_id']."','".$res['attr_type_name']."',"
            ."'".$res['attr_name']."','".$this->data['product_attr_sort']."')");
        if($res)
        {
            redirect('/?mod=admin&v_mod=admin_product&_index=_attr&id='.$this->data['product']);
        }
        return array("code"=>1,'msg'=>'添加失败');
    }

    //删除属性
    public function ActionDelProductAttr()
    {
        if(!regExp::checkNULL($this->data['product']) ||
            !regExp::checkNULL($this->data['id']))
        {
            return array('msg'=>'参数错误');
        }
        $res = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE id='".$this->data['id']."' AND product_id='".$this->data['product']."' "
            ." AND is_del=0");
        if(!$res)
        {
            return false;
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR." SET is_del=1 WHERE id='".$this->data['id']."'");
        if($row)
        {
            return array("code"=>0,'msg'=>'删除成功');
        }
        //redirect('/?mod=admin&v_mod=admin_product&_index=_attr&id='.$this->data['product']);
    }
    //新增分类
    public function ActionNewCategory()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!isset($this->data['category_id'])){
            return array('code'=>1,'msg'=>'请选择分类');
        }
        if(!regExp::checkNULL($this->data['category_name'])){
            return array('code'=>1,'msg'=>'分类名不能为空');
        }
        $parent_id = $this->data['category_id']?$this->data['category_id']:0;
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COMM_CATEGORY." "
            ."(category_name,category_sort,category_parent_id,category_img) VALUES('".$this->data['category_name']."',"
            ."'".$this->data['ry_order']."','".$parent_id."','".$this->data['category_img']."')");
        if($res){
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //删除分类
    public function ActionDelCategory(){
        if(!regExp::checkNULL($this->data['id'])){
            return array('code'=>1,'msg'=>'请选择删除的对象');
        }
        $info = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE "
            ." category_id='{$this->data['id']}'");
        if(!$info){
            return array('code'=>1,'msg'=>'分类不存在或已删除');
        }
        if($info['category_parent_id']==0){
            $count = $this->GetDBSlave1()->queryrow("SELECT count(*) AS total FROM ".TABLE_COMM_CATEGORY." "
                . " WHERE category_parent_id='{$this->data['id']}'");
            if($count['total']!=0){
                return array('code'=>1,'msg'=>'请先删除子类');
            }
        }
        $this->GetDBMaster()->query("DELETE FROM ".TABLE_COMM_CATEGORY." WHERE category_id='{$this->data['id']}'");
        return array('code'=>0,'msg'=>'删除成功');
    }
    //编辑分类
    public function ActionEditCategory()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id'])){
            return array('code'=>1,'msg'=>'请选择编辑的对象');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." "
            ." WHERE category_id='{$this->data['id']}'");
        if(!$data){
            return array('code'=>1,'msg'=>'数据不存在或已删除');
        }
        if(!regExp::checkNULL($this->data['category_name']))
        {
            return array('code'=>1,'msg'=>'分类名不能为空');
        }
        $parent_id = (!isset($this->data['category_id']) && $data['parent_id']==0)?0:$this->data['category_id'];
        $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_CATEGORY." SET category_img='".$this->data['category_img']."',"
            ." category_name='".$this->data['category_name']."',category_sort='".$this->data['ry_order']."',"
            ." category_show='".$this->data['show_status']."',category_parent_id='".$parent_id."' "
            ." WHERE category_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'操作成功');
    }

    //新增产品属性类别
    public function ActionNewAttrType()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['attr_type_name']))
        {
            return array('code'=>1,'msg'=>'请输入属性内容');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ATTR_TYPE." "
            ." SET attr_type_name='".$this->data['attr_type_name']."',"
            ." attr_sort='".$this->data['attr_sort']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'新增成功');
        }
        return array('code'=>1,'msg'=>'新增失败');
    }
    //删除属性类型
    public function ActionDelAttrType()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $check = $this->GetAttrType($this->data['id']);
        if(!$check)
        {
            return false;
        }
        $res = $this->GetDBMaster()->queryrow("SELECT * FROM ".TABLE_ATTR_TEMP." "
            ." WHERE attr_type_id='".$this->data['id']."' ");
        if($res)
        {
            return array('code'=>1,'msg'=>'属性正在使用，无法删除');
        }
        $this->GetDBMaster()->query("DELETE FROM ".TABLE_ATTR_TYPE." "
            ." WHERE attr_type_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'删除成功');
    }
    public function ActionEditAttrType()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $check = $this->GetAttrType($this->data['id']);
        if(!$check)
        {
            redirect(ADMIN_ERROR);
        }
        if(!regExp::checkNULL($this->data['attr_type_name']))
        {
            return array('code'=>1,'msg'=>'请输入属性内容');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR_TYPE." "
            ." SET attr_type_name='".$this->data['attr_type_name']."',"
            ." attr_sort='".$this->data['attr_sort']."' "
            ." WHERE attr_type_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //新增子属性
    public function ActionNewAttrValue()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'请选择属性分类');
        }
        $check = $this->GetAttrType($this->data['id']);
        if(!$check)
        {
            return array('code'=>1,'msg'=>'该分类不存在');
        }
        if(!regExp::checkNULL($this->data['attr_name']))
        {
            return array('code'=>1,'msg'=>'请输入属性对应内容');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ATTR_TEMP." "
            ." SET attr_type_id='".$this->data['id']."',"
            ." attr_name='".$this->data['attr_name']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'新增成功');
        }
        return array('code'=>1,'msg'=>'新增失败');
    }
    //删除子属性
    public function ActionDelAttrValue()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data =  $this->GetOneAttrValue($this->data['id']);
        if(!$data)
        {
            return false;
        }

        $check = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE attr_temp_id='".$this->data['id']."' LIMIT 1");
        //exit;
        if($check)
        {
            return array('code'=>1,'msg'=>'属性模板正在使用，无法删除');
        }
        $this->GetDBMaster()->query("DELETE FROM ".TABLE_ATTR_TEMP." "
            ." WHERE attr_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'删除成功');
    }
    //编辑子属性模板
    public function ActionEditAttrValue()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data =  $this->GetOneAttrValue($this->data['id']);
        if(!$data)
        {
            redirect(ADMIN_ERROR);
        }
        if(!regExp::checkNULL($this->data['attr_type_id']))
        {
            return array('code'=>1,'msg'=>'请选择属性分类');
        }
        $check = $this->GetAttrType($data['attr_type_id']);
        if(!$check)
        {
            return array('code'=>1,'msg'=>'该分类不存在');
        }
        if(!regExp::checkNULL($this->data['attr_name']))
        {
            return array('code'=>1,'msg'=>'请输入属性对应内容');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR_TEMP." "
            ." SET attr_name='".$this->data['attr_name']."' "
            ." WHERE attr_id='".$this->data['id']."' AND attr_type_id='".$data['attr_type_id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'编辑成功');
        }
        return array('code'=>1,'msg'=>'编辑失败');
    }

    //产品精选推荐
    function ActionChangeProductShowStatus()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."' AND  is_del=0");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'无此产品');
        }
        $status = $this->GetDBSlave1()->queryrow("SELECT id,show_status FROM ".TABLE_PRODUCT_CHOICE." WHERE "
            ." product_id='".$this->data['id']."'");
        if(empty($status))
        {
            $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PRODUCT_CHOICE." "
                ." SET product_id='".$this->data['id']."' ");
            if($res)
            {
                return array('code'=>0,'msg'=>'产品已添加到推荐');
            }
        }else
        {
            $row = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT_CHOICE." SET show_status=IF(show_status=0,1,0) "
                ." WHERE product_id='".$this->data['id']."'");
            if($row)
            {
                if($status['show_status']==0)
                {
                    return array('code'=>0,'msg'=>'产品已取消推荐');
                }
                return array('code'=>0,'msg'=>'产品已添加到推荐');
            }
        }
        return array('code'=>1,'msg'=>'操作失败');
    }
    //添加特色子类
    function ActionAddSpecCategory()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        if(empty($this->data['category_id']))
        {
            return array('code'=>1,'msg'=>'请选择一个子类');
        }
        $count = count($this->data['category_id']);
        if($count>3)
        {
            return array('code'=>1,'msg'=>'特色子类不要超出3个');
        }
        $id = '';
        for($i=0;$i<$count;$i++)
        {
            $id .= $this->data['category_id'][$i].',';
        }
        $id = rtrim($id,',');
        $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_CATEGORY." SET "
            ." category_spec = '".$id."'"
            ." WHERE category_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'操作成功');
    }
}