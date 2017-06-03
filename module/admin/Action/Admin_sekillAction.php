<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_sekillAction extends admin_sekill
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    function ActionNewSekillProduct()
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
        if(!regExp::checkNULL($this->data['seckill_stock']) ||
            !regExp::checkNULL($this->data['seckill_one_count']) ||
            !regExp::checkNULL($this->data['seckill_price']) ||
            !regExp::checkNULL($this->data['quantum_id']) ||
            !regExp::checkNULL($this->data['start_day']) ||
            !regExp::checkNULL($this->data['seckill_sort'])
            )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        //场次
        $quantum = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SEKILL_QUANTUM." "
            ." WHERE quantum_id = '".$this->data['quantum_id']."'");
        $sekill = $this->GetOneSekillProduct($this->data['id']);
        if(empty($quantum))
        {
            return array('code'=>1,'msg'=>'场次不存在');
        }
        if(!empty($sekill))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_SEKILL_PRODUCT." "
                ." SET seckill_status=0,"
                ." seckill_stock='".$this->data['seckill_stock']."',"
                ." seckill_buy_stock='".$this->data['seckill_buy_stock']."',"
                ." seckill_one_count='".$this->data['seckill_one_count']."',"
                ." seckill_price='".$this->data['seckill_price']."',"
                ." quantum_id='".$this->data['quantum_id']."',"
                ." start_day='".$this->data['start_day']."',"
                ." seckill_addtime='".date('Y-m-d H:i:s')."',"
                ." seckill_sort='".$this->data['seckill_sort']."',"
                ." store_id='".$product['store_id']."',"
                ." start_time='".$this->data['start_day'].' '.$quantum['start_time']."',"
                ." end_time='".$this->data['start_day'].' '.$quantum['end_time']."'"
                ." WHERE product_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'已更新秒杀');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_SEKILL_PRODUCT." "
            ." SET product_id='".$this->data['id']."',"
            ." seckill_stock='".$this->data['seckill_stock']."',"
            ." seckill_buy_stock='".$this->data['seckill_buy_stock']."',"
            ." seckill_one_count='".$this->data['seckill_one_count']."',"
            ." seckill_price='".$this->data['seckill_price']."',"
            ." quantum_id='".$this->data['quantum_id']."',"
            ." start_day='".$this->data['start_day']."',"
            ." seckill_sort='".$this->data['seckill_sort']."',"
            ." store_id='".$product['store_id']."',"
            ." start_time='".$this->data['start_day'].' '.$quantum['start_time']."',"
            ." end_time='".$this->data['start_day'].' '.$quantum['end_time']."',"
            ." seckill_addtime='".date("Y-m-d H:i:s",time())."'");
        if($id)
        {
            return array('code'=>0,'msg'=>'已加入秒杀');
        }
        return array('code'=>1,'msg'=>'加入秒杀失败');
    }
    function ActionCancelProductSeckill()
    {
        if(!isset($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $sekill = $this->GetOneSekillProduct($this->data['id']);
        if(empty($sekill))
        {
            return array('code'=>1,'msg'=>'秒杀不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_SEKILL_PRODUCT." "
            ." SET seckill_status=1"
            ." WHERE product_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'操作成功');
    }
}