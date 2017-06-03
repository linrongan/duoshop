<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_refund extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //退款列表  团购退款列表
    function GetRefundList()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_REFUND." AS R "
            ." LEFT JOIN ".TABLE_USER." AS U ON R.userid=U.userid "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT R.*,U.nickname,U.headimgurl FROM ".TABLE_REFUND." AS R "
            ." LEFT JOIN ".TABLE_USER." AS U ON R.userid=U.userid "
            ." WHERE 1 ".$where." "
            ." ORDER BY R.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    //退款申请列表
    function GetRefundApplyList()
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
            ." WHERE RA.refund_is_valid=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT RA.*,U.nickname,U.headimgurl,S.store_logo,S.store_name"
            ." FROM ".TABLE_REFUND_APPLY." AS RA LEFT JOIN ".TABLE_USER." AS U ON RA.refund_userid=U.userid "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON RA.refund_order_store_id=S.store_id WHERE RA.refund_is_valid=0 ".$where." "
            ." ORDER BY RA.id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'canshu'=>$canshu
        );
    }
    //退款原因列表
    function GetRefundCase()
    {
        $where=$canshu="";
        $page_size = 25;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_REFUND_CAUSE." "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_REFUND_CAUSE." "
            ." WHERE 1 ".$where." "
            ." ORDER BY refund_sort ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    //退款原因详情
    function GetRefundCauseDetail()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_REFUND_CAUSE." "
            ." WHERE id = '".$this->data['id']."' ");
    }
    //退款申请详情
    function GetRefundApplyDetails()
    {
        return $this->GetDBSlave1()->queryrow("SELECT A.*,U.nickname,U.headimgurl,S.store_name FROM ".TABLE_REFUND_APPLY." AS A "
            ." LEFT JOIN ".TABLE_USER." AS U ON A.refund_userid=U.userid "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON A.refund_order_store_id=S.store_id "
            ." WHERE A.id = '".$this->data['id']."' ");
    }


    function GetOneRefund($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT RA.*,U.openid FROM ".TABLE_REFUND_APPLY." "
            ." AS RA LEFT JOIN ".TABLE_USER." AS U ON RA.refund_userid=U.userid WHERE RA.id='".$id."'");
    }



}