<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Business_buyAction extends business_buy
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //添加专享商品
    function ActionAddBusinessBuyProduct()
    {
        if(!regExp::checkNULL($this->data['id']) || !is_array($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $select_id = array_filter($this->data['id']);
        $count = count($select_id);

        for($i=0;$i<$count;$i++)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
                ." business_buy = 1 "
                ." WHERE product_id = '".$this->data['id'][$i]."'");
        }
        return array('code'=>0,'msg'=>'添加成功');
    }
    function ActionDelBusinessProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
            ." business_buy = 0 "
            ." WHERE product_id = '".$this->data['id']."'");
        return array('code'=>0,'msg'=>'删除成功');
    }
}