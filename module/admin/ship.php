<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

Class ship extends comm
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //发货订单列表
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
                ." O.order_ship_name LIKE '%".$this->data['search']."%')";
            $param .= "&search=".$this->data['search'];
        }

        $count =$this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_ORDER_SHOP." AS S "
            ." LEFT JOIN ".TABLE_USER." AS U ON S.userid=U.userid "
            ." LEFT JOIN ".TABLE_O_ORDER." AS O ON S.orderid=O.orderid "
            ." LEFT JOIN ".TABLE_ORDER_SHIP." AS OS ON S.orderid=OS.orderid "
            ." WHERE S.shop_id='".$_SESSION['admin_store_id']."' "
            ." AND S.order_status>3 AND S.is_del=0".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT S.*,O.order_img,"
            ."U.nickname,U.headimgurl FROM ".TABLE_O_ORDER_SHOP." AS S "
            ." LEFT JOIN ".TABLE_USER." AS U ON S.userid=U.userid "
            ." LEFT JOIN ".TABLE_O_ORDER." AS O ON S.orderid=O.orderid "
            ." LEFT JOIN ".TABLE_ORDER_SHIP." AS OS ON S.orderid=OS.orderid "
            ." WHERE S.shop_id='".$_SESSION['admin_store_id']."' AND S.order_status>3 AND S.is_del=0".$where
            ." ORDER BY O.id DESC LIMIT "
            ."".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }
    //获取物流信息
    public function getLogisticsDetails()
    {
        if(!regExp::checkNULL($this->data['number']))
        {
            return array('code'=>1,'msg'=>'订单号不能为空');
        }
        $host = "http://jisukdcx.market.alicloudapi.com";
        $path = "/express/query";
        $method = "GET";
        $appcode = "05c56fbd3909431b864e0cd16647a59d";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $number = $this->data['number'];
        $type = !empty($this->data['com_type'])?$this->data['com_type']:'auto';
        $querys = "number=".$number."&type=".$type."";
        $url = $host . $path . "?" . $querys;
        $res = $this->GetCurlContent($url,$method,$headers,$host);
        $data = json_decode($res,true);
        if($data['status']!=0){
            return array('code'=>1,'msg'=>$data['msg']);
        }
        return $data;
    }

    function  GetCurlContent($url,$method,$headers,$host)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        return curl_exec($curl);
    }
    public function getLogisticsCompany()
    {
        $host = "http://jisukdcx.market.alicloudapi.com";
        $path = "/express/type";
        $method = "GET";
        $appcode = "05c56fbd3909431b864e0cd16647a59d";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        //$querys = "";
        //$bodys = "";
        $url = $host . $path;
        $res = $this->GetCurlContent($url,$method,$headers,$host);
        return json_decode($res,true);
    }
}