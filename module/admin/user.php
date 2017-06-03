<?php
class user extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //用户列表
    function GetUserList()
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
            $where .= " AND LEFT(SU.addtime,10)>='".$this->data['start_date']."'";
            $param.='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(SU.addtime,10)<='".$this->data['end_date']."'";
            $param.='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['nickname']) && !empty($this->data['nickname']))
        {
            $where .= " AND U.nickname LIKE '%".$this->data['nickname']."%'";
            $param.='&nickname='.$this->data['nickname'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_STORE_USER." AS SU "
            ." LEFT JOIN ".TABLE_USER." AS U ON SU.userid=U.userid WHERE SU.store_id='".$_SESSION['admin_store_id']."' "
            ." ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT U.*,SU.addtime AS saddtime FROM ".TABLE_STORE_USER." AS SU LEFT JOIN "
            ." ".TABLE_USER." AS U ON SU.userid=U.userid WHERE SU.store_id='".$_SESSION['admin_store_id']."'".$where." ORDER "
            ." BY SU.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }


    //用户咨询
    function UserFeedbackMessage()
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
            $where .= " AND LEFT(F.addtime,10)>='".$this->data['start_date']."'";
            $param.='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(F.addtime,10)<='".$this->data['end_date']."'";
            $param.='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['message']) && !empty($this->data['message']))
        {
            $where .= " AND F.message LIKE '%".$this->data['message']."%'";
            $param.='&message='.$this->data['message'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_FEEDBACK." AS F LEFT JOIN "
            ." ".TABLE_USER." AS U ON F.userid=U.userid WHERE F.store_id='".$_SESSION['admin_store_id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT F.id,F.message,F.contact,F.addtime,F.back_status,U.nickname,"
            ."U.headimgurl FROM ".TABLE_FEEDBACK." AS F LEFT JOIN ".TABLE_USER." AS U ON F.userid=U.userid WHERE "
            ."F.store_id='".$_SESSION['admin_store_id']."' ".$where." ORDER BY F.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size."");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }
    //订单列表
    function getRefundList()
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
        $count =$this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_ORDER_SHOP." AS O"
            ." LEFT JOIN ".TABLE_USER." AS U ON O.userid=U.userid "
            ." WHERE O.shop_id='".$_SESSION['admin_store_id']."' "
            ." AND O.order_status=-1".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT S.*,U.nickname,U.headimgurl,O.order_ship_name,O.order_ship_phone"
            ." FROM ".TABLE_O_ORDER_SHOP." "
            ." AS S LEFT JOIN ".TABLE_USER." AS U ON S.userid=U.userid LEFT JOIN ".TABLE_O_ORDER." AS O ON "
            ." S.orderid=O.orderid WHERE S.shop_id='".$_SESSION['admin_store_id']."' AND O.order_status=-1 "
            ." ".$where." ORDER BY S.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }

    //退款订单列表
    function GetRefundOrderList()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(RA.apply_date,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(RA.apply_date,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['refund_status']) && is_numeric($this->data['refund_status']))
        {
            $where .= " AND RA.refund_status='".$this->data['refund_status']."'";
            $canshu .='&refund_status='.$this->data['refund_status'];
        }
        if(isset($this->data['keyword']) && !empty($this->data['keyword']))
        {
            $where .= " AND S.store_name LIKE '%".$this->data['keyword']."%' OR "
                ."RA.refund_number LIKE '%".$this->data['keyword']."%' OR "
                ."RA.refund_orderid LIKE '%".$this->data['keyword']."%'";
            $canshu .='&keyword='.$this->data['keyword'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_REFUND_APPLY." AS RA "
            ." LEFT JOIN ".TABLE_USER." AS U ON RA.refund_userid=U.userid LEFT JOIN ".TABLE_COMM_STORE." "
            ." AS S ON RA.refund_order_store_id=S.store_id"
            ." WHERE RA.refund_is_valid=0 AND  RA.refund_order_store_id='".$_SESSION['admin_store_id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT RA.*,U.nickname,U.headimgurl,S.store_logo,S.store_name"
            ." FROM ".TABLE_REFUND_APPLY." AS RA LEFT JOIN ".TABLE_USER." AS U ON RA.refund_userid=U.userid "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON RA.refund_order_store_id=S.store_id WHERE "
            ." RA.refund_is_valid=0 AND RA.refund_order_store_id='".$_SESSION['admin_store_id']."' ".$where." "
            ." ORDER BY RA.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'canshu'=>$canshu
        );

    }
    //退款申请详情
    function GetRefundApplyDetails()
    {
        return $this->GetDBSlave1()->queryrow("SELECT A.*,U.nickname,U.headimgurl,S.store_name FROM ".TABLE_REFUND_APPLY." AS A "
            ." LEFT JOIN ".TABLE_USER." AS U ON A.refund_userid=U.userid "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON A.refund_order_store_id=S.store_id "
            ." WHERE A.id = '".$this->data['id']."' AND A.refund_order_store_id = '".$_SESSION['admin_store_id']."' ");
    }
    function GetOneRefund($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT RA.*,U.openid FROM ".TABLE_REFUND_APPLY." "
            ." AS RA LEFT JOIN ".TABLE_USER." AS U ON RA.refund_userid=U.userid WHERE "
            ." RA.id=".$id." AND RA.refund_order_store_id='".$_SESSION['admin_store_id']."'");
    }


}