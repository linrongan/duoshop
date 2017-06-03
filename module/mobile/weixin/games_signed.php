<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class games_signed extends wx{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //签到记录
    function GetLianXuLog($addmonth_all='')
    {
        if ($addmonth_all=='')
        {
            $addmonth_all=date("Y-m");
        }
        
        //默认本月
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_SIGNED." "
            ." WHERE userid='".SYS_USERID."' "
            ." AND addmonth_all='".$addmonth_all."'");
        $signed=array();
        foreach($data as $item)
        {
            $signed[$item['adddate']]=$item;
        }
        return $signed;
    }

    //获取多少积分
    function GetPoint($lianxu_signed=0)
    {
        $point_array=array(0=>5,1=>10,2=>15,3=>20);
        $point=0;
        //判断签到得分
        if ($lianxu_signed>=4)
        {
            $point=20;
        }else
        {
            $point=$point_array[$lianxu_signed];
        }
        return $point;
    }
    //获取积分礼品
    public function getPointGift()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_PRODUCT." "
            ." ORDER BY ry_order ASC ");
        return $data;
    }
    //礼品详情
    public function GetPointGiftDetail()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_PRODUCT." "
            ." WHERE id = '".$this->data['id']."'");
        return $data;
    }
}
?>