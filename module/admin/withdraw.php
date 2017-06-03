<?php
class withdraw extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }



    //提现列表
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
}