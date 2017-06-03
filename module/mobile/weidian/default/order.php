<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class order extends wx
{
    protected $store_id;
    function __construct($data,$store_id)
    {
        $this->data = $data;
        $this->store_id = $store_id;
    }


    //订单列表
    function GetOrder($order_status=true)
    {
        $where = '';
        $page_size = 3;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $status_option = array(1,2,3);
        if($order_status)
        {
            if(isset($this->data['type']) && !empty($this->data['type']) && in_array($this->data['type'],$status_option))
            {
                if($this->data['type']==1)
                {
                    $where .= " AND order_status<3";
                }elseif($this->data['type']==2)
                {
                    $where .= " AND order_status=3";
                }elseif($this->data['type']==3)
                {
                    $where .= " AND order_status=4";
                }
            }
        }else{
            $where .= " AND order_status=-1";
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ORDER." "
            ." WHERE store_id='".$this->store_id."' ".$where." ");
        $data =  $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER." WHERE "
            ." store_id='".$this->store_id."' ".$where." ORDER BY id DESC LIMIT "
            ." ".($page-1)*$page_size.",".$page_size." ");
        if($count['total'])
        {
            $new_data = array();
            $order_items = array();
            foreach($data as $item)
            {
                $new_data[$item['orderid']] = $item;
                $order_items[] = $item['orderid'];
            }
            $details = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER_DETAIL." WHERE "
                ." orderid IN (".implode(',',$order_items).")");
            foreach($details as $val)
            {
                $new_data[$val['orderid']]['details'][] = $val;
            }
            $array =array('code'=>0,'data'=>$new_data,'pages'=>ceil($count['total']/$page_size));
            if(regExp::is_ajax())
            {
                echo json_encode($array);exit;
            }
            return $array;
        }
        if(regExp::is_ajax())
        {
            echo json_encode(array('code'=>1,'data'=>''));exit;
        }
        return array('code'=>1);
    }
}