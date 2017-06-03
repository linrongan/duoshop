<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class Admin_activeAction extends admin_active
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    function ActionAddActiveCategory()
    {
        if(!regExp::checkNULL($this->data['pid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['c_name']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['c_img']))
        {
            return array('code'=>1,'msg'=>'请上传封面图');
        }
        $type =  $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_BANNER." "
            ." WHERE id = '".$this->data['pid']."' AND picture_type=1 ");
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ACTIVE_CATEGORY." (c_name,"
            ."c_img,c_sort,c_parent_id)VALUES('".$this->data['c_name']."',"
            ."'".$this->data['c_img']."',"
            ."'".$this->data['c_sort']."',"
            ."'".$this->data['pid']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    function ActionEditActiveCategory()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['c_name']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['c_img']))
        {
            return array('code'=>1,'msg'=>'请上传封面图');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_ACTIVE_CATEGORY." SET "
            ." c_name='".$this->data['c_name']."',"
            ." c_img='".$this->data['c_img']."',"
            ." c_sort='".$this->data['c_sort']."'"
            ." WHERE id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    function ActionDelActiveCategory()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $category = $this->getActiveCategoryDetail();
        if(empty($category))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_ACTIVE_CATEGORY." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //批量添加活动产品
    function ActionAddActiveProduct()
    {
        if(!regExp::checkNULL($this->data['id']) || !is_array($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $select_id = array_filter($this->data['id']);
        $count = count($select_id);
        $where = '';
        $id=array();
        for ($i=0;$i<$count;$i++)
        {
            $where .= $select_id[$i].',';
        }
        $where = rtrim($where,',');
        $check_count = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ACTIVE_PRODUCT." "
            ." WHERE product_id IN (".$where.") ");
        if(!empty($check_count))
        {
            return array('code'=>1,'msg'=>'存在已添加过的产品，请重新选择');
        }
        for($i=0;$i<$count;$i++)
        {
            $id[] = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ACTIVE_PRODUCT." (product_id,"
                ."c_id,status,sort)VALUES('".$select_id[$i]."',"
                ."'".$this->data['cid']."',0,0)");
        }
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //主题产品编辑
    function ActionEditActiveProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_ACTIVE_PRODUCT." SET "
            ." sort='".$this->data['sort']."'"
            ." WHERE product_id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    function ActionDelActiveProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $category = $this->getActiveProductDetail();
        if(empty($category))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_ACTIVE_PRODUCT." "
            ." WHERE product_id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
}