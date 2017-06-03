<?php
class follow extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //收藏的产品
    function GetCollectProduct()
    {
        $where = $canshu = $order ='';
        if(isset($this->data['page']) && !empty($this->data['page']) && regExp::is_positive_number($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page  = 1;
        }
        $page_size = 10;
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_PRODUCT_COLLE." AS CP LEFT JOIN ".TABLE_PRODUCT." "
            ."AS P ON CP.product_id=P.product_id WHERE CP.userid='".SYS_USERID."'");
        $data = $this->GetDBSlave1()->queryrows("SELECT CP.id,CP.product_id,CP.store_id,P.product_name,"
            ."P.product_img,P.product_price,P.product_fake_price,P.collect_count,S.store_logo,S.store_name FROM "
            ." ".TABLE_PRODUCT_COLLE." AS CP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON CP.product_id=P.product_id LEFT JOIN "
            ." ".TABLE_COMM_STORE." AS S ON CP.store_id=S.store_id WHERE  CP.userid='".SYS_USERID."' "
            ."ORDER BY CP.id DESC LIMIT ".($page-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'pages'=>ceil($count['total'])/$page_size,
        );
    }




    //关注的店铺
    function GetFollowShop()
    {
        $where = $canshu = $order ='';
        if(isset($this->data['page']) && !empty($this->data['page']) && regExp::is_positive_number($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page  = 1;
        }
        $page_size = 10;
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_FOLLOW_STORE." AS FS LEFT JOIN ".TABLE_COMM_STORE." "
            ."AS S ON FS.store_id=S.store_id WHERE FS.userid='".SYS_USERID."'");
        $data = $this->GetDBSlave1()->queryrows("SELECT FS.id,FS.store_id,S.store_name,S.store_logo,"
            ."S.follow_count FROM ".TABLE_FOLLOW_STORE." AS FS LEFT JOIN ".TABLE_COMM_STORE." "
            ."AS S ON FS.store_id=S.store_id WHERE FS.userid='".SYS_USERID."' "
            ."ORDER BY FS.id DESC LIMIT ".($page-1)*$page_size.",".$page_size."");
        return array(
            'data'=>$data,
            'pages'=>ceil($count['total'])/$page_size,
        );
    }


}