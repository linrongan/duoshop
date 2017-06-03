<?php
class Choice_productAction extends choice_product
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionEditChoiceProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['show_sort']))
        {
            return array('code'=>1,'msg'=>'请输入排序值');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."'");
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        $group = $this->GetOneChoiceProduct($this->data['id']);
        if(!empty($group))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT_CHOICE." "
                ." SET show_status=0,"
                ." show_sort='".$this->data['show_sort']."'"
                ." WHERE product_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'已更新精选');
        }

        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GROUP_PRODUCT." "
            ." SET product_id='".$this->data['id']."',"
            ." show_sort='".$this->data['show_sort']."'");
        if($id)
        {
            return array('code'=>0,'msg'=>'已加入精选');
        }
        return array('code'=>1,'msg'=>'新增失败');
    }



}