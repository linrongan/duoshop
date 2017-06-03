<?php
class ProductAction extends product
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //新增产品
    function ActionNewProduct()
    {
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
        if(empty($this->data['product_flash']))
        {
            return array('code'=>1,'msg'=>'请上传产品轮播图');
        }
        $category = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE "
            ." category_id='".$this->data['category_id']."'");
        if(empty($category))
        {
            return array('code'=>1,'msg'=>'分类是不存在的');
        }
        $check_is_last = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." "
            ." WHERE category_parent_id='".$this->data['category_id']."'");
        if($check_is_last)
        {
            return array('code'=>1,'msg'=>'请选择最底下级分类');
        }
        if($check_is_last)
        {
            return array('code'=>1,'msg'=>'请输入图文描述');
        }
        if (!isset($this->data['product_flash']))
        {
            $this->data['product_flash']=array();
        }
        $this->GetDBMaster()->StartTransaction();
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PRODUCT."(category_id,category_name,product_name,"
            ."product_img,product_desc,product_unit,product_price,product_fake_price,product_sort,product_status,store_id,"
            ."product_addtime,min_buy,max_buy,ship_fee,product_sold,product_stock)VALUES('".$this->data['category_id']."','".$category['category_name']."',"
            ."'".$this->data['product_name']."','".$this->data['product_img']."','".$this->data['product_desc']."',"
            ."'".$this->data['product_unit']."','".$this->data['product_price']."','".$this->data['product_fake_price']."',"
            ."'".$this->data['product_sort']."',0,'".$_SESSION['admin_store_id']."','".date("Y-m-d H:i:s",time())."',"
            ."'".$this->data['min_buy']."','".$this->data['max_buy']."','".$this->data['ship_fee']."',"
            ."'".$this->data['product_sold']."','".intval($this->data['product_stock'])."') ");
        $details = $this->GetDBMaster()->query("INSERT INTO ".TABLE_PRODUCT_DETAIL."(product_id,product_text,product_flash,product_param)"
            ." VALUES('".$id."','".$this->data['product_text']."','".json_encode($this->data['product_flash'])."',"
            ."'".$this->data['product_param']."')");
        if($id && $details)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'产品发布成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'产品发布失败');
    }


    //产品下架
    function ActionChangeproductStatus()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id,product_status FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."' AND store_id='".$_SESSION['admin_store_id']."' AND is_del=0");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'无此产品');
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET product_status=IF(product_status=0,1,0) "
            ." WHERE product_id='".$this->data['id']."'");
        if($row)
        {
            if($product['product_status']==0)
            {
                return array('code'=>0,'msg'=>'产品已下架');
            }
            return array('code'=>0,'msg'=>'产品已发布');
        }
        return array('code'=>1,'msg'=>'操作失败');
    }
    //推荐到首页
    function ActionChangeIsHome()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id,is_home FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$this->data['id']."' AND store_id='".$_SESSION['admin_store_id']."' AND is_del=0");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'无此产品');
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET is_home=IF(is_home=0,1,0) "
            ." WHERE product_id='".$this->data['id']."'");
        if($row)
        {
            if($product['is_home']==0)
            {
                return array('code'=>0,'msg'=>'产品已推荐到首页');
            }
            return array('code'=>0,'msg'=>'已取消在首页显示');
        }
        return array('code'=>1,'msg'=>'操作失败');
    }


    //删除产品
    function ActionDelProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id,is_del FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."' AND store_id='".$_SESSION['admin_store_id']."' "
            ." AND is_del=0");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'无此产品');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET is_del=1 WHERE "
            ." product_id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'已删除');
        }
        return array('code'=>1,'msg'=>'操作失败');
    }


    //批量删除
    function ActionMoreDelProduct()
    {
        if(!regExp::checkNULL($this->data['id']) || !is_array($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $select_id = array_filter($this->data['id']);
        $count = count($select_id);
        $where = '';
        for ($i=0;$i<$count;$i++)
        {
            $where .= $select_id[$i].',';
        }
        $where = rtrim($where,',');
        $check_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." WHERE "
            ." product_id IN (".$where.") AND store_id='".$_SESSION['admin_store_id']."' AND is_del=0");
        if($check_count['total']<$count)
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET is_del=1 WHERE "
            ." product_id IN(".$where.") AND store_id='".$_SESSION['admin_store_id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }

    //编辑产品
    function ActionEditProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id,is_del FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."' AND store_id='".$_SESSION['admin_store_id']."' "
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

        $category = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_CATEGORY." WHERE "
            ." category_id='".$this->data['category_id']."'");
        if(empty($category))
        {
            return array('code'=>1,'msg'=>'分类是不存在的');
        }
        $check_is_last = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." WHERE parent_id='".$this->data['category_id']."'");
        if($check_is_last)
        {
            return array('code'=>1,'msg'=>'请选择最底下级分类');
        }
        if(!regExp::checkNULL($this->data['product_text']))
        {
            return array('code'=>1,'msg'=>'请输入图文描述');
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
            ." product_sold='".$this->data['product_sold']."',ship_fee='".$this->data['ship_fee']."',"
            ." min_buy='".$this->data['min_buy']."',max_buy='".$this->data['max_buy']."',"
            ." product_stock='".intval($this->data['product_stock'])."'"
            ." WHERE product_id='".$this->data['id']."' AND store_id='".$_SESSION['admin_store_id']."'");
        $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT_DETAIL." SET product_text='".$this->data['product_text']."',"
            ." product_param ='".$this->data['product_param']."', product_flash='".$product_flash."'"
            ." WHERE product_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }
    //产品精选
    function ActionAddProductChoice()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$this->data['id']."'");
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        if(!regExp::checkNULL($this->data['choice_sort']))
        {
            return array('code'=>1,'msg'=>'请输入排序值');
        }
        $choice = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SHOP_PRODUCT_CHOICE." "
            ." WHERE product_id='".$this->data['id']."'");
        if(!empty($choice))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_SHOP_PRODUCT_CHOICE." "
                ." SET choice_status=0,"
                ." choice_sort='".$this->data['choice_sort']."'"
                ." WHERE product_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'已加入精选');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_SHOP_PRODUCT_CHOICE." "
            ." SET product_id='".$this->data['id']."',"
            ." choice_sort='".$this->data['choice_sort']."',"
            ." addtime='".date("Y-m-d H:i:s",time())."'");
        if($id)
        {
            return array('code'=>0,'msg'=>'已加入精选');
        }
        return array('code'=>1,'msg'=>'加入精选失败');
    }
    //取消精选
    function ActionCancelProductChoice()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$this->data['id']."'");
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_SHOP_PRODUCT_CHOICE." "
            ." SET choice_status=1"
            ." WHERE product_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'已取消精选');
    }

    //新增产品属性
    public function ActionNewProductAttr()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('msg'=>'产品参数错误');
        }
        if(!regExp::checkNULL($this->data['attr_temp_id']))
        {
            return array('msg'=>'请选择属性');
        }
        $product = $this->getCheckMyProduct($this->data['id']);
        if(empty($product))
        {
            include RPC_DIR .TEMPLATEPATH.'/admin/_comm/_waring_1_tpl.php';exit;
        }
        $res = $this->GetDBSlave1()->queryrow("SELECT AT.attr_name,A.attr_type_name FROM ".TABLE_ATTR_TEMP." AS AT "
            ." LEFT JOIN ".TABLE_ATTR_TYPE." AS A ON AT.attr_type_id=A.attr_type_id "
            ." WHERE AT.attr_id='".$this->data['attr_temp_id']."'");
        if(!$res)
        {
            return array('msg'=>'属性不存在或已删除');
        }
        //属性价格浮动计算
        if (!is_numeric($this->data['attr_change_price']) || $this->data['attr_change_price']<=0)
        {
            return array('msg'=>'金额不正确');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ATTR." "
            ."(product_id,attr_temp_id,attr_type_name,attr_temp_name,"
            ."product_attr_sort,attr_change_price,product_stock)"
            ."VALUES('".$this->data['id']."','".$this->data['attr_temp_id']."','".$res['attr_type_name']."',"
            ."'".$res['attr_name']."','".$this->data['product_attr_sort']."',"
            ."'".$this->data['attr_change_price']."','".intval($this->data['product_stock'])."')");
        if($res)
        {
            return array("code"=>0,'msg'=>'添加成功');
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
        $product = $this->getCheckMyProduct($this->data['product']);
        if(empty($product))
        {
            include RPC_DIR .TEMPLATEPATH.'/admin/_comm/_waring_1_tpl.php';exit;
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
    //新增产品属性类别（商户）
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
            ." attr_sort='".$this->data['attr_sort']."',store_id='".$_SESSION['admin_store_id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'新增成功');
        }
        return array('code'=>1,'msg'=>'新增失败');
    }
    //编辑属性
    public function ActionEditAttrType()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $check = $this->GetAttrTypeDetails();
        if(!$check)
        {
            return array('code'=>1,'msg'=>'属性不存在或无权限修改');
        }
        if(!regExp::checkNULL($this->data['attr_type_name']))
        {
            return array('code'=>1,'msg'=>'请输入属性内容');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR_TYPE." "
            ." SET attr_type_name='".$this->data['attr_type_name']."',"
            ." attr_sort='".$this->data['attr_sort']."' "
            ." WHERE attr_type_id='".$this->data['id']."' AND store_id = '".$_SESSION['admin_store_id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除属性类型
    public function ActionDelAttrType()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $check = $this->GetAttrTypeDetails();
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
        $row =$this->GetDBMaster()->query("DELETE FROM ".TABLE_ATTR_TYPE." "
            ." WHERE attr_type_id='".$this->data['id']."' AND store_id = '".$_SESSION['admin_store_id']."'");
        if(!empty($row))
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>0,'msg'=>'删除失败');
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
        $check = $this->GetAttrTypeDetails();
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
    //编辑子属性模板
    public function ActionEditAttrValue()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data =  $this->GetAttrValueDetails();
        if(!$data)
        {
            return array('code'=>1,'msg'=>'不存在或已删除');
        }
        $check = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR_TYPE." "
            ." WHERE attr_type_id='".$data['attr_type_id']."' AND store_id = '".$_SESSION['admin_store_id']."'");
        if(!$check)
        {
            return array('code'=>1,'msg'=>'该分类不存在');
        }
        if(!regExp::checkNULL($this->data['attr_name']))
        {
            return array('code'=>1,'msg'=>'请输入属性对应内容');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR_TEMP." SET "
            ." attr_name='".$this->data['attr_name']."' "
            ." WHERE attr_id='".$this->data['id']."' AND attr_type_id ='".$data['attr_type_id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'编辑成功');
        }
        return array('code'=>1,'msg'=>'编辑失败');
    }
    //删除子属性
    public function ActionDelAttrValue()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data =  $this->GetAttrValueDetails();
        if(!$data)
        {
            return array('code'=>1,'msg'=>'不存在或已删除');
        }
        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR_TYPE." "
            ." WHERE attr_type_id='".$data['attr_type_id']."' AND store_id = '".$_SESSION['admin_store_id']."'");
        if(!$type)
        {
            return array('code'=>1,'msg'=>'该分类不存在');
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
    //产品属性编辑
    public function ActionEditProductAttr()
    {
        if(!regExp::checkNULL($this->data['id']) ||
            !regExp::checkNULL($this->data['aid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id,is_del FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."' AND store_id='".$_SESSION['admin_store_id']."' "
            ." AND is_del=0");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'无权限');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR." SET "
            ." attr_change_price='".$this->data['attr_change_price']."',"
            ." product_stock='".$this->data['product_stock']."',"
            ." product_attr_sort='".$this->data['product_attr_sort']."'"
            ." WHERE id='".$this->data['aid']."' AND product_id ='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }
}