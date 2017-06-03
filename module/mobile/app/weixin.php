<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class weixin extends common
{
    function __construct($data)
    {
        $this->data = $data;
    }

    /*
     * 首页banner
     * */
    function GetHomeTopBanner($type=0,$number=0)
    {
        $limit = '';
        if($number)
        {
            $limit .= ' LIMIT '.$number;
        }
        $date=date("Y-m-d H:i:s");
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_BANNER."  "
            ." WHERE picture_show=0 "
            ." AND picture_type = '".$type."' "
            ." AND start_status=1 "
            ." AND start_time<'".$date."'"
            ." AND expire_time>'".$date."'"
            ." ORDER BY pay_money DESC,picture_sort ASC ".$limit);
    }

    /*
     *消息通知
     * */
    function GetHomeNotice()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_INDEX_NOTICE." WHERE "
            ." notice_show=0 ORDER BY notice_sort ASC");
    }

    /*
     * 功能导航
     * */
    function GetHomeNav()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_NAV." WHERE "
            ." nav_show=0 ORDER BY nav_sort ASC");
    }

    /*
     * 首页数据
     * */
    function GetHomeData()
    {
        $array = array();
        $conf = $this->GetWebConf(array('index_banner_show_count','index_group_show_count','index_product_show_count','index_shop_show_count'));
        $array['banner'] = $this->GetHomeTopBanner(0,8);
        $array['notice'] = $this->GetHomeNotice();
        $array['nav'] = $this->GetHomeNav();
        $array['seckill'] = $this->GetTodayTimeSeckill();
        $array['group'] = $this->GetGroupProduct();
        $array['choice_pro'] = $this->GetChoicePro();
        $array['choice_shop'] = $this->GetChoiceShop();
        $array['coupon'] = $this->GetUniversalCoupon();
        return $array;
    }

    /*
     * 优惠券首页
     */
    function GetUniversalCoupon()
    {
        $date = date("Y-m-d H:i:s");
        $data= $this->GetDBSlave1()->queryrows("SELECT ST.*,T.min_money,T.coupon_money FROM  ".TABLE_COUPON_STORE_TYPE." AS ST "
            ." LEFT JOIN ".TABLE_COUPON_TYPE." AS T ON T.id=ST.type_id"
            ." WHERE ST.store_id=0 AND ST.start_time<'".$date."' "
            ." AND ST.end_time>'".$date."' "
            ." AND T.default_sent=1 "
            ." ORDER BY coupon_money ASC LIMIT 0,8");
        return $data;
    }

    //获取当前秒杀
    function GetTodayTimeSeckill()
    {
        $date = date("Y-m-d H:i:s");
        $array = array();
        $seckill= $this->GetDBSlave1()->queryrows("SELECT SP.product_id,SP.seckill_price,"
            ." P.product_name,P.product_img,P.product_price FROM  ".TABLE_SEKILL_PRODUCT." AS SP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON SP.product_id=P.product_id "
            ." WHERE SP.end_time>'".$date."' AND seckill_status=0"
            ." ORDER BY SP.end_time ASC,SP.seckill_sort ASC LIMIT 0,8");
        if($seckill)
        {
            $array['data'] = $seckill;
            return $array;
        }
        return null;
    }


    //团购产品
    function GetGroupProduct()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT G.product_id,G.store_id,G.people_nums,"
            ." G.allow_buy_nums,G.group_price,G.group_sold,P.product_name,P.product_img "
            ." FROM ".TABLE_GROUP_PRODUCT." AS G  "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id=P.product_id WHERE G.group_status=0 "
            ." ORDER BY G.group_sort ASC LIMIT 3");
        return $data;
    }

    //精选产品
    function GetChoicePro()
    {
        /*$date=date("Y-m-d H:i:s");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.* FROM ".TABLE_PRODUCT_CHOICE." AS CP"
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON CP.product_id=P.product_id  "
            ." WHERE P.product_status=0 "
            ." AND CP.show_status=0 "
            ." ORDER BY CP.show_sort ASC");
        return $data;*/
        $where = $canshu = '';
        $page_size = 6;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_PRODUCT_CHOICE." AS CP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON CP.product_id=P.product_id  "
            ." WHERE P.product_status=0 AND CP.show_status=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.* FROM ".TABLE_PRODUCT_CHOICE." AS CP"
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON CP.product_id=P.product_id  "
            ." WHERE P.product_status=0 AND CP.show_status=0 "
            ." ORDER BY CP.show_sort ASC "
            ." LIMIT ".($page-1)*$page_size.", ".$page_size." ");
        $data = array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size)
        );
        if(regExp::is_ajax())
        {
            echo json_encode($data);exit;
        }
        return $data;
    }

    //精选店铺
    function GetChoiceShop()
    {
        $date=date("Y-m-d H:i:s");
        $data = $this->GetDBSlave1()->queryrows("SELECT S.* FROM ".TABLE_STORE_CHOICE." AS SC "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON SC.store_id=S.store_id  "
            ." WHERE SC.show_status=0 "
            //." AND SC.start_status=1 "
            //." AND SC.start_time<'".$date."'"
            //." AND SC.expire_time>'".$date."'"
            ." ORDER BY SC.pay_money DESC,SC.show_sort ASC LIMIT 0,8");
        return $data;
    }



}