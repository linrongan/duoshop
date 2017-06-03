<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class address extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //收货地址
    public function GetShipAddress()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_SHIP_ADDRESS." WHERE "
            ." userid='".SYS_USERID."' ORDER BY id DESC");
    }

    //取一条地址
    public function GetOneAddress($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SHIP_ADDRESS." "
            ." WHERE id='".$id."' AND userid='".SYS_USERID."'");
    }


    function GetViewAddress()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=地址不存在');
        }
        $data = $this->GetOneAddress($this->data['id']);
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=地址不存在');
        }
        return $data;
    }


}