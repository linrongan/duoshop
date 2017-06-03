<?php
class admin_withdraw extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }



    //用户提现列表
    function GetUserMoneyOutList()
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
            $where .= " AND LEFT(W.withdraw_apply_date,10)>='".$this->data['start_date']."'";
            $param .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(W.withdraw_apply_date,10)<='".$this->data['end_date']."'";
            $param .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['withdraw_status']) && is_numeric($this->data['withdraw_status']))
        {
            $where .= " AND W.withdraw_status='".$this->data['withdraw_status']."'";
            $param .='&withdraw_status='.$this->data['withdraw_status'];
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_WITHDRAW." AS W "
            ." LEFT JOIN ".TABLE_USER." AS U ON W.userid=U.userid "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT W.*,U.nickname,U.headimgurl FROM ".TABLE_WITHDRAW." AS W "
            ." LEFT JOIN ".TABLE_USER." AS U ON W.userid=U.userid "
            ." WHERE 1 ".$where." "
            ." ORDER BY W.id DESC LIMIT "
            ." ".($curpage-1)*$page_size.",".$page_size." ");

        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }

    function GetOneUserWithdraw($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT W.*,U.nickname,U.headimgurl,U.openid FROM "
            ." ".TABLE_WITHDRAW." AS W LEFT JOIN ".TABLE_USER." AS U ON W.userid=U.userid "
            ." WHERE W.id='".$id."'");
    }


    function GetOneShopWithdraw($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT W.*,S.store_name,S.store_logo FROM "
            ." ".TABLE_SHOP_WITHDRAWALS." AS W LEFT JOIN ".TABLE_COMM_STORE." AS S ON W.store_id=S.store_id "
            ." WHERE W.id='".$id."'");
    }

    function GetUserWithdrawDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            $this->Error();
        }
        $data = $this->GetOneUserWithdraw($this->data['id']);
        if(!$data)
        {
            $this->Error();
        }
        return $data;
    }


    function GetShopWithdrawList()
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
            $where .= " AND LEFT(SW.addtime,10)>='".$this->data['start_date']."'";
            $param .= "&start_date=".$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(SW.addtime,10)<='".$this->data['end_date']."'";
            $param .= "&end_date=".$this->data['end_date'];
        }
        if(isset($this->data['store_name']) && !empty($this->data['store_name']))
        {
            $where .= " AND CS.store_name LIKE '%".$this->data['store_name']."%'";
            $param .= "&store_name=".$this->data['store_name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_SHOP_WITHDRAWALS." AS "
            ."SW LEFT JOIN ".TABLE_COMM_STORE." AS CS ON SW.store_id=CS.store_id WHERE 1 "
            ."".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT SW.*,CS.store_logo,CS.store_name FROM ".TABLE_SHOP_WITHDRAWALS." "
            ."AS SW LEFT JOIN ".TABLE_COMM_STORE." AS CS ON SW.store_id=CS.store_id WHERE 1 "
            ."".$where." ORDER BY id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }


    function GetShopWithdrawDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            $this->Error();
        }
        $data = $this->GetOneShopWithdraw($this->data['id']);
        if(!$data)
        {
            $this->Error();
        }
        return $data;
    }



}