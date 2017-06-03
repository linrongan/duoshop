<?php
include RPC_DIR .'/conf/database_table_gw.php';
class pc_banner extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //首页图片
    function GetBannerPic()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_PC_PICTURE." "
            ." WHERE 1 ORDER BY picture_sort ASC");
        $arr=array();
        $i=0;
        if(!empty($data))
        {
            foreach($data as $item)
            {
                $arr[$item['ad_type']][$i] = $item;
                $i++;
            }
        }
        return $arr;
    }
}