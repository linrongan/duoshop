<?php
class apply extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //获取申请店铺详情
    function GetOneApply()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SHOP_APPLY."  "
            ." WHERE userid='".SYS_USERID."'");
        if (!empty($data['store_id']) && $data['status']==2)
        {
            $store=$this->GetStoreDetail($data['store_id']);
            redirect('/'.$store['store_url']);
        }
        return $data;
    }

    //获取店铺信息
    private function GetStoreDetail($id)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE."  "
            ." WHERE store_id='".$id."'");
        return $data;
    }
}