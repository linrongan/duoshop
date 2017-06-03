<?php
class order extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //订单列表
    function GetOrderList()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(O.order_addtime,10)>='".$this->data['start_date']."'";
            $param .= "&start_date=".$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(O.order_addtime,10)<='".$this->data['end_date']."'";
            $param .= "&end_date=".$this->data['end_date'];
        }
        if(isset($this->data['search']) && !empty($this->data['search']))
        {
            $where .= " AND (O.orderid LIKE '%".$this->data['search']."%' OR "
                ." U.nickname LIKE '%".$this->data['search']."%' OR "
                ." O.order_ship_name LIKE '%".$this->data['search']."%' OR "
                ." O.order_total LIKE '%".$this->data['search']."%')";
            $param .= "&search=".$this->data['search'];
        }
        if(isset($this->data['order_status']) && $this->data['order_status']!='')
        {
            $where .= " AND O.order_status='".$this->data['order_status']."'";
            $param .= "&order_status=".$this->data['order_status'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_ORDER_SHOP." AS S "
            ." LEFT JOIN ".TABLE_USER." AS U ON S.userid=U.userid "
            ." LEFT JOIN ".TABLE_O_ORDER." AS O ON S.orderid=O.orderid "
            ." WHERE S.shop_id='".$_SESSION['admin_store_id']."' AND S.is_del=0"
            ." ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT S.*,U.nickname,U.headimgurl "
            ." FROM ".TABLE_O_ORDER_SHOP." "
            ." AS S LEFT JOIN ".TABLE_USER." AS U ON S.userid=U.userid LEFT JOIN ".TABLE_O_ORDER." AS O ON "
            ." S.orderid=O.orderid WHERE S.shop_id='".$_SESSION['admin_store_id']."' AND S.is_del=0 "
            ." ".$where." ORDER BY S.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }


    //订单详情
    function GetOrderDetails()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            $this->Error();
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT S.*,UD.order_ship_name,UD.order_ship_phone,"
            ."UD.order_ship_sheng,UD.order_ship_shi,UD.order_ship_qu,UD.order_ship_address,UD.liuyan FROM "
            ."".TABLE_O_ORDER_SHOP." AS S LEFT JOIN ".TABLE_O_ORDER." AS UD ON S.orderid=UD.orderid "
            ."WHERE S.orderid='".$this->data['orderid']."' AND S.shop_id='".$_SESSION['admin_store_id']."'");
        if(empty($order))
        {
            $this->Error();
        }
        $pro = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_ORDER_GOODS." "
            ." WHERE orderid='".$this->data['orderid']."' ");
        return array('order'=>$order,'details'=>$pro);
    }



    //订单评论列表
    function GetOrderComment()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(C.comment_date,10)>='".$this->data['start_date']."'";
            $param.='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(C.comment_date,10)<='".$this->data['end_date']."'";
            $param.='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['search']) && !empty($this->data['search']))
        {
            $where .= " AND (C.orderid LIKE '%".$this->data['search']."%' OR "
                ." P.product_name LIKE '%".$this->data['search']."%' OR "
                ." U.nickname LIKE '%".$this->data['search']."%')";
            $param.='&search='.$this->data['search'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT_COMMENT." "
            ." AS C LEFT JOIN ".TABLE_PRODUCT." AS P ON C.product_id=P.product_id LEFT JOIN ".TABLE_USER." "
            ." AS U ON C.userid=U.userid WHERE C.store_id='".$_SESSION['admin_store_id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT C.id,C.comment,C.comment_level,C.product_show,C.comment_date,P.product_name,"
            ."P.product_img,U.nickname,U.headimgurl FROM ".TABLE_PRODUCT_COMMENT." AS C LEFT JOIN ".TABLE_PRODUCT." "
            ."AS P ON C.product_id=P.product_id LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid WHERE "
            ."C.store_id='".$_SESSION['admin_store_id']."' ".$where." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }
    //物流列表
    public function GetLogisticsList()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_LOGISTICS." "
            ." ORDER BY logistics_letter ASC ");
        return $data;
    }

}