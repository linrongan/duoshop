<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

Class choice extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //轮播
    private function GetBanner()
    {
        $date=date("Y-m-d H:i:s");
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_BANNER."  "
            ." WHERE picture_show=0 "
            ." AND picture_type = 3 "
            //." AND start_status=1 "
            //." AND start_time<'".$date."'"
            //." AND expire_time>'".$date."'"
            ." ORDER BY pay_money DESC,picture_sort ASC LIMIT 3");
    }
    //精选产品
    private function GetChoicePro()
    {
        $date=date("Y-m-d H:i:s");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,S.store_name FROM ".TABLE_PRODUCT_CHOICE." AS CP"
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON CP.product_id=P.product_id  "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id  "
            ." WHERE P.product_status=0 "
            ." AND CP.show_status=0 "
            //." AND CP.start_status=1 "
            //." AND CP.start_time<'".$date."'"
            //." AND CP.expire_time>'".$date."'"
            ." ORDER BY CP.show_sort ASC");

        return $data;
    }
    //精选店铺
    private function GetChoiceShop()
    {
        $date=date("Y-m-d H:i:s");
        $data = $this->GetDBSlave1()->queryrows("SELECT S.* FROM ".TABLE_STORE_CHOICE." AS SC "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON SC.store_id=S.store_id  "
            ." WHERE SC.show_status=0 "
            //." AND SC.start_status=1 "
            //." AND SC.start_time<'".$date."'"
            //." AND SC.expire_time>'".$date."'"
            ." ORDER BY SC.show_sort ASC");
        $sql ='SELECT product_img,store_id FROM '.TABLE_PRODUCT.' AS P1 '
            .' WHERE (SELECT COUNT(*) FROM '.TABLE_PRODUCT.' AS p2'
            .' WHERE P1.store_id = P2.store_id and P1.product_id <= P2.product_id) <= 3 '
            .' ORDER BY P1.product_id DESC';
        $product = $this->GetDBSlave1()->queryrows($sql);
        $arr = array();
        $i=0;
        if(!empty($product))
        {
            foreach($product as $item)
            {
                $arr[$item['store_id']][$i]=$item;
                $i++;
            }
        }
        return array('data'=>$data,'pro'=>$arr);
    }
    public function GetChoiceData()
    {
        $banner = $this->GetBanner();
        $product = $this->GetChoicePro();
        $shop = $this->GetChoiceShop();
        return array(
            'banner'=>$banner,
            'product'=>$product,
            'shop'=>$shop
        );
    }
}