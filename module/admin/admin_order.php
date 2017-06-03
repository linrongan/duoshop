<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_order extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //订单列表
    public function GetOrderList($status=1){
        $where = $canshu ='';
        $page_size=10;
        $order = 'ORDER BY O.id DESC';
        if($status==0){
            $where .= " AND O.order_status ='-1'";
        }
        if(isset($this->data['order_status']) && is_numeric($this->data['order_status'])){
            $where .= " AND O.order_status ='".$this->data['order_status']."'";
            $canshu = "&order_status=".$this->data['order_status'];
        }
        if(isset($this->data['orderid']) && !empty($this->data['orderid']) && is_numeric($this->data['orderid'])){
            $where .= " AND O.orderid LIKE '%".$this->data['orderid']."%'";
            $canshu = "&orderid=".$this->data['orderid'];
        }
        if(isset($this->data['store_name']) && !empty($this->data['store_name'])){
            $where .= " AND S.store_name LIKE '%".$this->data['store_name']."%'";
            $canshu = "&store_name=".$this->data['store_name'];
        }
        if(isset($this->data['order_type']) && is_numeric($this->data['order_type'])){
            $where .= " AND O.order_type='".$this->data['order_type']."'";
            $canshu = "&order_type=".$this->data['order_type'];
        }
        if ((!isset($_REQUEST['curpage'])) or (!is_numeric($_REQUEST['curpage'])) or ($_REQUEST['curpage']<1))
        {
            $curpage=1;
        }
        else
        {
            $curpage=intval($_REQUEST['curpage']);
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_ORDER_SHOP." "
            ." AS O LEFT JOIN ".TABLE_USER." AS U ON O.userid=U.userid LEFT JOIN ".TABLE_COMM_STORE." "
            ." AS S ON O.shop_id=S.store_id WHERE 1 ".$where." ");

        $data = $this->GetDBSlave1()->queryrows("SELECT O.*,U.nickname,U.headimgurl,S.store_name,S.store_logo "
            ." FROM ".TABLE_O_ORDER_SHOP." "
            ." AS O LEFT JOIN ".TABLE_USER." AS U ON O.userid=U.userid LEFT JOIN "
            ." ".TABLE_COMM_STORE." AS S ON O.shop_id=S.store_id WHERE "
            ." 1 ".$where." ORDER BY O.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'curpage'=>$curpage,'page_size'=>$page_size,'canshu'=>$canshu);
    }

    //获取一条订单
    public function  GetOneOrder($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER." WHERE orderid=".$id);
    }
    //订单详情
    public function GetOrderDetail(){
        if(!isset($this->data['id']) || empty($this->data['id']) || !is_numeric($this->data['id'])){
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT O.*,U.nickname FROM ".TABLE_O_ORDER." AS O "
            ." LEFT JOIN ".TABLE_USER." AS U ON O.userid=U.userid WHERE O.id='{$this->data['id']}'");
        if(empty($data)){
            redirect(ADMIN_ERROR);
        }
        return $data;
    }
    public function GetOrderItem(){
        if(!regExp::checkNULL($this->data['orderid']))
        {
            $this->Error();
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT S.*,UD.order_ship_name,UD.order_ship_phone,"
            ."UD.order_ship_sheng,UD.order_ship_shi,UD.order_ship_qu,UD.order_ship_address,UD.liuyan,CS.store_name FROM "
            ."".TABLE_O_ORDER_SHOP." AS S LEFT JOIN ".TABLE_O_ORDER." AS UD ON S.orderid=UD.orderid "
            ."LEFT JOIN ".TABLE_COMM_STORE." AS CS ON S.shop_id=CS.store_id "
            ."WHERE S.orderid='".$this->data['orderid']."'");
        if(empty($order))
        {
            $this->Error();
        }
        $pro = $this->GetDBSlave1()->queryrows("SELECT G.*,S.store_name FROM ".TABLE_O_ORDER_GOODS." AS G "
            ."LEFT JOIN ".TABLE_COMM_STORE." AS S ON G.shop_id=S.store_id "
            ." WHERE orderid='".$this->data['orderid']."' ");
        return array('order'=>$order,'details'=>$pro);
    }
    //退款订单列表
    function GetRefundOrderList()
    {
        $where = $canshu ='';
        $page_size=10;
        if ((!isset($_REQUEST['curpage'])) or (!is_numeric($_REQUEST['curpage'])) or ($_REQUEST['curpage']<1))
        {
            $curpage=1;
        }
        else
        {
            $curpage=intval($_REQUEST['curpage']);
        }

        if(isset($this->data['orderid']) && !empty($this->data['orderid']) && is_numeric($this->data['orderid'])){
            $where .= " AND G.orderid LIKE '%".$this->data['orderid']."%'";
            $canshu = "&orderid=".$this->data['orderid'];
        }
        if(isset($this->data['store_name']) && !empty($this->data['store_name'])){
            $where .= " AND S.store_name LIKE '%".$this->data['store_name']."%' ";
            $canshu = "&store_name=".$this->data['store_name'];
        }
        if(isset($this->data['nickname']) && !empty($this->data['nickname'])){
            $where .= " AND U.nickname LIKE '%".$this->data['nickname']."%' ";
            $canshu = "&nickname=".$this->data['nickname'];
        }
        if(isset($this->data['goods_refund']) && is_numeric($this->data['goods_refund']) &&
            !empty($this->data['goods_refund'])){
            $where .= " AND G.goods_refund='".$this->data['goods_refund']."'";
            $canshu = "&goods_refund=".$this->data['goods_refund'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_ORDER_GOODS." AS G "
            ." LEFT JOIN ".TABLE_USER." AS U ON G.userid=U.userid "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON G.shop_id=S.store_id "
            ." LEFT JOIN ".TABLE_REFUND_APPLY." AS A ON G.id=A.goods_id "
            ." WHERE goods_refund>0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT G.*,U.nickname,U.headimgurl,S.store_name"
            .",A.id as apply_id,A.refund_cause,A.apply_date FROM ".TABLE_O_ORDER_GOODS." AS G "
            ." LEFT JOIN ".TABLE_USER." AS U ON G.userid=U.userid "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON G.shop_id=S.store_id "
            ." LEFT JOIN ".TABLE_REFUND_APPLY." AS A ON G.id=A.goods_id "
            ." WHERE goods_refund>0 ".$where." ORDER BY goods_refund ASC,G.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'curpage'=>$curpage,'page_size'=>$page_size,'canshu'=>$canshu);
    }
}