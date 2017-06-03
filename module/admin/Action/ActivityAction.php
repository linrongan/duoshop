<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class ActivityAction extends activity
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //商户添加优惠卷类型
    function ActionAddStoreCoupon()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['start_time']) ||
            !regExp::checkNULL($this->data['end_time']) ||
            !regExp::checkNULL($this->data['coupon_name']))
        {
            return array('code'=>1,'msg'=>'请填写必要信息！');
        }
        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_TYPE." "
            ." WHERE id = '".$this->data['id']."' AND jurisdiction = 1 AND store_id = 0");
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        $store = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_STORE_TYPE." "
            ." WHERE type_id = '".$this->data['id']."' AND store_id ='".$_SESSION['admin_store_id']."'");
        if(!empty($store))
        {
            return array('code'=>1,'msg'=>'重复添加');
        }
        $time = time();
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COUPON_STORE_TYPE." (type_id,"
            ."addtime,coupon_name,store_id,start_time,end_time)"
            ."VALUES('".$this->data['id']."','".$time."','".$this->data['coupon_name']."',"
            ."'".$_SESSION['admin_store_id']."','".$this->data['start_time']."',"
            ."'".$this->data['end_time']."')");
        if($id)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON_STORE_TYPE." SET "
                ." coupon_key='".md5($time.$id)."' WHERE id = '".$id."' ");
            return array('code'=>0,'msg'=>'已成功添加此规则');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //删除卷模板
    function ActionDelStoreCoupon()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_STORE_TYPE." "
            ." WHERE id = '".$this->data['id']."' AND store_id ='".$_SESSION['admin_store_id']."'");
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_COUPON_STORE_TYPE." "
            ." WHERE id='".$this->data['id']."' AND store_id ='".$_SESSION['admin_store_id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }

}