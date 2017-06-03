<?php
class system extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //获取基本配置信息
    function GetSystemConf()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CONF." ORDER BY conf_sort ASC");
    }

}