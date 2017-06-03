<?php
class Group_productAction extends group_product
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionNewGroupProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."'");
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        $group = $this->GetOneGroupProduct($this->data['id']);
        if(!empty($group))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP_PRODUCT." "
                ." SET group_status=0,"
                ." people_nums='".$this->data['people_nums']."',"
                ." group_price='".$this->data['group_price']."',"
                ." group_sort='".$this->data['group_sort']."',"
                ." group_sold='".$this->data['group_sold']."'"
                ." WHERE product_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'已更新团购');
        }
        if(!regExp::checkNULL($this->data['people_nums']))
        {
            return array('code'=>1,'msg'=>'请输入几人团');
        }
        if(!regExp::checkNULL($this->data['allow_buy_nums']))
        {
            return array('code'=>1,'msg'=>'请输入允许最大购买数量');
        }
        if(!regExp::checkNULL($this->data['group_price']))
        {
            return array('code'=>1,'msg'=>'请输入团购价');
        }

        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GROUP_PRODUCT." "
            ." SET product_id='".$this->data['id']."',"
            ." store_id='".$product['store_id']."',"
            ." people_nums='".$this->data['people_nums']."',"
            ." group_price='".$this->data['group_price']."',"
            ." group_sort='".$this->data['group_sort']."',"
            ." group_sold='".$this->data['group_sold']."',"
            ." addtime='".date("Y-m-d H:i:s",time())."'");
        if($id)
        {
            return array('code'=>0,'msg'=>'已加入团购');
        }
        return array('code'=>1,'msg'=>'新增失败');
    }

    //取消团购
    public function ActionCancelGroupProduct()
    {

        if(!isset($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $group = $this->GetOneGroupProduct($this->data['id']);
        if(empty($group))
        {
            return array('code'=>1,'msg'=>'团购不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP_PRODUCT." "
            ." SET group_status=1"
            ." WHERE product_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'操作成功');
    }



}