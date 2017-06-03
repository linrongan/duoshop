<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class common_coupon extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //优惠券code生成机器
    protected function MakeCouponCode()
    {
        $id=$this->OrderMakeOrderId();
        if ($id)
        {
            return 'C'.$id;
        }else
        {
            return false;
        }
    }

    //优惠券生成
    public function CreateCoupon($array=array())
    {

        $coupon_code=$this->MakeCouponCode();
        if ($coupon_code)
        {
            $store_id = isset($array['store_id'])?$array['store_id']:'0';
            $store_name = isset($array['store_name'])?$array['store_name']:'';
            $userid = defined('SYS_USERID')?SYS_USERID:'0';
            $store_type_id = isset($array['store_type_id'])?$array['store_type_id']:'0';

            $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COUPON.""
                ."(coupon_code,userid,coupon_name,store_id,store_name,store_type_id,"
                ."coupon_money,min_money,start_time,expire_time,"
                ."source,addtime,use_status,coupon_type)"
                ."VALUES('".$coupon_code."',"
                ."'".$userid."',"
                ."'".$array['coupon_name']."',"
                ."'".$store_id."',"
                ."'".$store_name."',"
                ."'".$store_type_id."',"
                ."'".$array['coupon_money']."',"
                ."'".$array['min_money']."',"
                ."'".$array['start_time']."',"
                ."'".$array['expire_time']."',"
                ."'".$array['source']."',"
                ."'".date("Y-m-d H:i:s")."',0,"
                ."'".$array['coupon_type']."'"
                .")");
            if ($id)
            {
                return array("code"=>0,"msg"=>"优惠券领取成功！");
            }else
            {
                return array("code"=>1,"msg"=>"优惠券领取失败！");
            }
        }
        return array("code"=>1,"msg"=>"优惠券领取失败！");
    }

}