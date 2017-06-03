<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class coupon extends common
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //获取优惠券发放模板
    function GetCouponTypeDetail()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT ST.*,S.store_name,T.valid_days,T.category_name,"
            ."T.coupon_name,T.coupon_money,T.min_money,T.default_sent FROM ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON ST.store_id=S.store_id "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON ST.type_id=T.id "
            ." WHERE coupon_key='".$this->data['id']."' "
            ." AND end_time>'".date("Y-m-d H:i:s")."'");
        return $data;
    }
    /*
     * 判断用户是否领取过该优惠卷
     *
     * */
    function getCouponByStoreTypeId($id)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON." "
            ." WHERE store_type_id='".$id."' "
            ." AND userid ='".SYS_USERID."'");
        if(empty($data))
        {
            return true;
        }else
        {
            return false;
        }

    }

    //获取优惠卷详情
    private function GetCouponById($id)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT ST.*,T.coupon_name,T.type_id as type,"
            ."T.coupon_money,T.min_money,T.category_id FROM ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON ST.type_id=T.id "
            ." WHERE ST.id='".$id."' "
            ." AND ST.end_time>'".date("Y-m-d H:i:s")."'");
        return $data;
    }
    //领取优惠卷
    function ActionReceiveCoupon()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            die(json_encode(array('code'=>1,'msg'=>'参数错误')));
        }
        $coupon = $this->GetCouponById($this->data['id']);
        if(empty($coupon))
        {
            die(json_encode(array('code'=>1,'msg'=>'优惠卷不存在')));
        }
        $arr = array();
        $arr['store_id']=$coupon['store_id'];
        $arr['coupon_name']=$coupon['coupon_name'];
        $arr['coupon_money']=$coupon['coupon_money'];
        $arr['min_money']=$coupon['min_money'];
        $arr['start_time']=$coupon['start_time'];
        $arr['expire_time']=$coupon['end_time'];
        $arr['source']='商户发放';
        $arr['coupon_type']=$coupon['type'];
        $arr['store_type_id']=$coupon['id'];
        include RPC_DIR . '/module/common/common_coupon.php';
        $coupon = new common_coupon('');
        $res = $coupon->CreateCoupon($arr);
        return die(json_encode($res));
    }


}
?>