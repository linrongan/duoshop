<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class transaction extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    public function getUserTransactionList()
    {
        $where=$canshu="";
        $page_size = 20;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['balance_type']) && is_numeric($this->data['balance_type']))
        {
            $where .= " AND T.merchat_balance_type='".$this->data['balance_type']."'";
            $canshu .='&balance_type='.$this->data['balance_type'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total,IFNULL(SUM(fee_money),0) AS total_money FROM ".TABLE_COMM_FEE." AS F "
            ." LEFT JOIN ".TABLE_FEE_TYPE." AS T ON F.fee_type=T.type_id "
            ." WHERE store_id ='".$_SESSION['admin_store_id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT F.*,T.type_name,T.merchat_balance_type FROM ".TABLE_COMM_FEE." AS F "
            ." LEFT JOIN ".TABLE_FEE_TYPE." AS T ON F.fee_type=T.type_id "
            ." WHERE store_id ='".$_SESSION['admin_store_id']."' ".$where." "
            ." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        //收益
        $profit=$this->GetDBSlave1()->queryrow("SELECT SUM(E.fee_money) AS sum FROM ".TABLE_COMM_FEE." AS E"
            ." LEFT JOIN ".TABLE_FEE_TYPE." AS T ON E.fee_type=T.type_id "
            ." WHERE T.merchat_balance_type=3 "
            ." AND E.store_id ='".$_SESSION['admin_store_id']."' ");
        //支出
        $pay=$this->GetDBSlave1()->queryrow("SELECT SUM(E.fee_money) AS sum FROM ".TABLE_COMM_FEE." AS E"
            ." LEFT JOIN ".TABLE_FEE_TYPE." AS T ON E.fee_type=T.type_id "
            ." WHERE T.merchat_balance_type=2 "
            ." AND E.store_id ='".$_SESSION['admin_store_id']."' ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "money"=>$count['total_money'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu,
            "profit"=>$profit,
            "pay"=>$pay
        );
    }
    //折扣卷明细
    function GetDiscountLog()
    {
        $where=$canshu="";
        $page_size = 20;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['order_type']) && is_numeric($this->data['order_type']))
        {
            $where .= " AND C.order_type='".$this->data['order_type']."'";
            $canshu .='&order_type='.$this->data['order_type'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total,S.gift_balance FROM ".TABLE_DISCOUNT_COUPON." AS C "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id = S.store_id "
            ." LEFT JOIN ".TABLE_USER." AS U ON C.userid = U.userid "
            ." WHERE C.store_id = '".$_SESSION['admin_store_id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,S.store_name,U.nickname,U.headimgurl "
            ." FROM ".TABLE_DISCOUNT_COUPON." AS C "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id = S.store_id "
            ." LEFT JOIN ".TABLE_USER." AS U ON C.userid = U.userid "
            ." WHERE C.store_id = '".$_SESSION['admin_store_id']."' ".$where." "
            ." ORDER BY C.addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        //收益
        $group=$this->GetDBSlave1()->queryrows("SELECT SUM(C.money) as sum_money,order_type FROM ".TABLE_DISCOUNT_COUPON." AS C "
            ." WHERE C.store_id = '".$_SESSION['admin_store_id']."' "
            ." GROUP BY C.order_type ");
        $group_arr = array();
        if(!empty($group))
        {
            foreach($group as $item)
            {
                $group_arr[$item['order_type']] = $item;
            }
        }
        return array(
            "data"=>$data,"total"=>$count['total'],"gift_balance"=>$count['gift_balance'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu,
            "group"=>$group_arr
        );
    }
    function GetStoreDiscountConf()
    {
        $conf = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_DISCOUNT_CONF." "
            ." WHERE store_id = '".$_SESSION['admin_store_id']."'");
        return $conf;
    }
}