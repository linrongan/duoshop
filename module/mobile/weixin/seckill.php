<?php
class seckill extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //获取所有场次的数据
    function GetToDayQuantum()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_SEKILL_QUANTUM."  "
            ." WHERE end_time>'".date("Y-m-d H:i:s",time())."' ORDER BY start_time ASC");
    }

    //获取某场次的数据
    protected function GetTheDayQuantum($quantum_id=0)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SEKILL_QUANTUM."  "
            ." WHERE quantum_id='".intval($quantum_id)."'");
    }

    //获取某场次的产品
    function GetQuantumProduct($quantum_id,$date)
    {
        $where=$canshu=$order ='';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else
        {
            $page = 1;
        }
        $quantum=$this->GetTheDayQuantum($quantum_id);
        if (empty($quantum))
        {
           redirect(NOFOUND.'&msg=找不到该场次');
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total "
            ." FROM ".TABLE_SEKILL_PRODUCT." AS S "
            ." WHERE S.quantum_id='".$quantum_id."' "
            ." AND S.seckill_status=0"
            ." ".$where."");
        $data = $this->GetDBSlave1()->queryrows("SELECT S.product_id,S.seckill_stock,S.start_time,"
            ." S.seckill_buy_stock,S.seckill_one_count,S.seckill_addtime,S.seckill_sort,S.quantum_id,"
            ." S.seckill_price,S.start_day,S.seckill_status,S.store_id,P.product_name,P.product_img,"
            ." P.product_price FROM ".TABLE_SEKILL_PRODUCT." AS S "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON S.product_id=P.product_id "
            ." WHERE S.quantum_id='".$quantum_id."' "
            ." AND S.seckill_status=0 "
           // ." AND S.start_time<='".$date."'"
            ." AND S.end_time>='".$date."'"
            ." ORDER BY S.seckill_sort ASC LIMIT ".($page-1)*$page_size.",".$page_size."");
        return array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size)
        );
    }

    /*
     * 获取当前时间的秒杀
     * */
    function GetToTimeQuantum()
    {
        //查询当前是否有秒杀场
        $time = date("H:i:s",time());
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SEKILL_QUANTUM."  "
            ." WHERE start_time<'".$time."' AND end_time>'".$time."'");
    }


    /*
     * 根据场次查询所有产品
     * */
    function GetQuantumPro($quantum_id)
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_SEKILL_PRODUCT." WHERE "
            ." start_day='".date("Y-m-d",time())."' AND quantum_id='".$quantum_id."'");
    }


    /*
     * 查询当前时间的秒杀
     * */
    function GetToTimeQuantumPro()
    {
        $date = date("Y-m-d H:i:s",time());
        return $this->GetDBSlave1()->queryrows("SELECT SP.*,Q.quantum FROM ".TABLE_SEKILL_PRODUCT." AS SP "
            ." LEFT JOIN ".TABLE_SEKILL_QUANTUM." AS Q ON SP.quantum_id=Q.quantum_id "
            ." WHERE SP.start_day='".date("Y-m-d",time())."' "
            ." AND Q.start_time<='".$date."' "
            ." AND Q.end_time>='".$date."'");
    }

    /*
     * 查询今日之后的秒杀预演
     */
    function GetLastQuantum()
    {
        return $this->GetDBSlave1()->queryrow("SELECT start_day,quantum_id,end_time FROM ".TABLE_SEKILL_PRODUCT."  "
            ." WHERE start_day>'".date("Y-m-d")."' "
            ." ORDER BY quantum_id ASC LIMIT 0,1");
    }

}