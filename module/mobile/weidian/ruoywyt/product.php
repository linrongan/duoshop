<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class product extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function GetShowProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT P.*,PD.product_text,PD.product_flash FROM "
            ." ".TABLE_PRODUCT." AS P LEFT JOIN ".TABLE_PRODUCT_DETAIL." AS PD ON P.product_id=PD.product_id "
            ." WHERE P.product_id='".$this->data['id']."' AND P.is_del=0 AND P.product_status=0 "
            ." AND P.store_id='".$this->GetStoreId()."'");
        if(empty($product))
        {
            redirect(NOFOUND.'&msg=产品不存在');
        }
        return $product;
    }


    //产品月销量
    function GetProductMonthSold($product_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_ORDER_DETAIL." WHERE "
            ." product_id='".$product_id."' AND store_id='".$this->GetStoreId()."' AND is_del=0 AND "
            ." LEFT(addtime,7)='".date("Y-m",time())."'");
    }


    //获取产品的属性
    public function GetProductAttr($product_id)
    {
        $array = array();
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,T.attr_type_id FROM "
            ." ".TABLE_ATTR." AS A LEFT JOIN ".TABLE_ATTR_TEMP." AS T ON "
            ." A.attr_temp_id=T.attr_id WHERE A.product_id='".$product_id."' "
            ." AND is_del=0");
        if($data){
            foreach($data as $item)
            {
                $array[$item['attr_type_id']]['attr_type'] = $item['attr_type_name'];
                $array[$item['attr_type_id']]['attr'][] = $item;
            }
        }
        return $array;
    }


    //获取收藏产品
    function GetProductColle($product_id)
    {
        $shouchang = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_COLLE." WHERE "
            ." userid='".SYS_USERID."' AND product_id='".$product_id."' ");
        return $shouchang;
    }
}