<?php
class wallet extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //余额明细
    function GetUserMoneyDetails()
    {
        $where = $canshu = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_BALANCE_DETAILS." WHERE trans_userid='".SYS_USERID."'");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_BALANCE_DETAILS." "
            ." WHERE trans_userid='".SYS_USERID."' ORDER BY id DESC "
            ." LIMIT ".($page-1)*$page_size.", ".$page_size." ");
        $array = array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size)
        );
        if(!regExp::is_ajax())
        {
            return $array;
        }
        echo json_encode($array);exit;
    }

    //费用明细
    function getUserCommFee($type)
    {
        $where = $canshu = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $where .=  " AND fee_type=".$type;
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_COMM_FEE." WHERE userid='".SYS_USERID."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_FEE." "
            ." WHERE userid='".SYS_USERID."' ".$where." ORDER BY id DESC "
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





    //获取收益
    function GetUserProfit($userid)
    {
        return $this->GetDBSlave1()->queryrow("SELECT IF(SUM(profit_money)>0,SUM(profit_money),0) "
            ." AS money_total FROM ".TABLE_PROFIT." WHERE "
            ." userid='".$userid."' AND profit_status=0");
    }

    //查询本月提现次数
    function GetToMonthMoneyOutNum()
    {
        return $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_WITHDRAW." "
            ." WHERE userid='".SYS_USERID."' AND LEFT(withdraw_apply_date,7)='".date("Y-m",time())."' "
            ." AND withdraw_sourse_type=1");
    }
}