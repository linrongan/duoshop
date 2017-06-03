<?php

//查询物流用
class admin_logistics extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function Selectlogistics()
    {
        //查询物流
        if(!regExp::checkNULL($this->data['logistics_number']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $api = 'http://api.jisuapi.com/express/query?appkey='.WULIU_KEY.'&type=auto&number='.$this->data['logistics_number'];
        $result = doCurlGetRequest($api);
        return json_decode($result,true);
    }
    //物流列表
    function GetLogisticsList()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['bank_name']) && !empty($this->data['bank_name']))
        {
            $where .= " AND bank_name like '%".$this->data['bank_name']."%'";
            $canshu .='&bank_name='.$this->data['bank_name'];
        }
        if(isset($this->data['logistics_letter']) && !empty($this->data['logistics_letter']))
        {
            $where .= " AND logistics_letter = '".strtoupper(trim($this->data['logistics_letter']))."'";
            $canshu .='&logistics_letter='.$this->data['logistics_letter'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_LOGISTICS." "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_LOGISTICS." "
            ." WHERE 1 ".$where." "
            ." ORDER BY logistics_letter ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //物流详情
    function GetLogisticsDetail()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_LOGISTICS." "
            ." WHERE logistics_id ='".$this->data['id']."'");
    }



}