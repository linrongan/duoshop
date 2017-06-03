<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

Class coupon extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //获取有效的优惠券列表
    function GetValidCouponList()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT C.*,S.store_name FROM ".TABLE_COUPON." AS C "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id=S.store_id "
            ." WHERE C.userid='".SYS_USERID."' "
            ." AND C.use_status=0 "
            ." AND C.expire_time>='".date("Y-m-d")."'");
        return array("data"=>$data);
    }

    //获取无效的优惠券
    function GetUnValidCouponList()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COUPON." "
            ." WHERE userid='".SYS_USERID."' "
            ." AND use_status=1");
        return array("data"=>$data);
    }

    //获取过期的优惠券
    function GetExpireCouponList()
    {
        //取出订单号
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COUPON." "
            ." WHERE userid='".SYS_USERID."' "
            ." AND use_status=0 "
            ." AND expire_time<'".date("Y-m-d")."'");
        return array("data"=>$data);
    }

    //接口验证获取优惠券信息
    function GetCouponInfo($array=array())
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT coupon_code,userid,coupon_name,orderid,coupon_money,"
            ." min_money,start_time,expire_time,oil_type,use_status FROM ".TABLE_COUPON." "
            ." WHERE coupon_code='".$array['coupon_code']."'");
        return $data;
    }

    /*
     * 优惠卷领取操作
     * */
    //获取优惠券发放模板
    function GetCouponTypeDetail()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT ST.*,S.store_name,T.valid_days,T.category_name,"
            ."T.coupon_name,T.coupon_money,T.min_money,T.default_sent FROM ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON ST.store_id=S.store_id "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON ST.type_id=T.id "
            ." WHERE ST.coupon_key='".$this->data['id']."' "
            ." AND ST.end_time>='".date("Y-m-d")."'");
        return $data;
    }
    /*
     * 判断用户是否领取过该优惠卷
     *
     * */
    function getCouponByStoreTypeId($id)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON." "
            ." WHERE store_type_id='".$id."' AND use_status = 0 "
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
        $data=$this->GetDBSlave1()->queryrow("SELECT ST.*,T.type_id as type,S.store_name,"
            ."T.coupon_money,T.min_money,T.category_id FROM ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON ST.type_id=T.id "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON ST.store_id=S.store_id "
            ." WHERE ST.id='".$id."' "
            ." AND ST.end_time>='".date("Y-m-d H:i:s")."'");
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
        $if_has = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON." "
            ." WHERE store_type_id='".$coupon['id']."' AND userid ='".SYS_USERID."' "
            ." AND use_status=0");
        if(!empty($if_has))
        {
            die(json_encode(array('code'=>1,'msg'=>'已领取过一次了！')));
        }
        $arr = array();
        $arr['store_id']=$coupon['store_id'];
        $arr['store_name']=$coupon['store_name']?$coupon['store_name']:'';
        $arr['coupon_name']=$coupon['coupon_name'];
        $arr['coupon_money']=$coupon['coupon_money'];
        $arr['min_money']=$coupon['min_money'];
        $arr['start_time']=$coupon['start_time'];
        $arr['expire_time']=$coupon['end_time'];
        $arr['source']=$coupon['store_id']==0?'管理员发放':'商户发放';
        $arr['coupon_type']=$coupon['type'];
        $arr['store_type_id']=$coupon['id'];
        include RPC_DIR . '/module/common/common_coupon.php';
        $coupon = new common_coupon('');
        $res = $coupon->CreateCoupon($arr);
        return die(json_encode($res));
    }

    //会员折扣券
    function GetDiscountCoupon()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." "
            ." WHERE userid='".SYS_USERID."' AND gift_balance>0");
        return $data;
    }

    //获取会员折扣券百分比
    function GetDiscountCouponPer()
    {
        $conf=$this->GetCommonConf(8);
        if ($conf['conf_number']>0 && $conf['conf_number']<100)
        {
            return $conf['conf_number']/100;
        }else
        {
            return 0;
        }
    }
    //折扣卷详情
    function GetDiscountDetail()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT C.*,S.gift_balance FROM ".TABLE_DISCOUNT_CONF." AS C "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id=S.store_id "
            ." WHERE share_key='".$this->data['id']."' ");
        return $data;
    }
    //判断是否领取过折扣卷
    function CheckHasDiscount($store_id=0)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_DISCOUNT_COUPON." "
            ." WHERE store_id='".$store_id."' AND userid ='".$_SESSION['userid']."' AND order_type = 2");
        return $data;
    }
    //获得金卡初始金额
    function GetGoldenCardMoney()
    {
        $conf=$this->GetCommonConf(9);
        if ($conf['conf_number']>10 && $conf['conf_number']<1000)
        {
            return $conf['conf_number'];
        }else
        {
            return 10;
        }
    }
}