<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class notice extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }



    function GetNoticeRoleMsg()
    {
        return $this->GetDBSlave1()->queryrows("SELECT R.*,N.alert_date FROM ".TABLE_ALERT_ROLE." "
            ." AS R INNER JOIN ".TABLE_ALERT_LIST." AS N ON R.alert_role_id=N.alert_role_id GROUP BY "
            ." R.alert_role_id ORDER BY R.ry_sort ASC,N.alert_date DESC");
    }



    function GetNoticeList()
    {
        if(!regExp::checkNULL($this->data['role_id']))
        {
            redirect(NOFOUND.'&msg=error');
        }
        $role = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ALERT_ROLE." WHERE "
            ." alert_role_id='".$this->data['role_id']."'");
        if(!$role)
        {
            redirect(NOFOUND.'&msg=无此消息分类');
        }
        $read = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ALERT_LOOK." WHERE "
            ." alert_role_id='".$this->data['role_id']."' AND userid='".SYS_USERID."'");
        if(!$read)
        {
            $this->GetDBMaster()->query("INSERT INTO ".TABLE_ALERT_LOOK." "
                ." SET userid='".SYS_USERID."',"
                ." alert_role_id='".$this->data['role_id']."',"
                ." unread=0");
        }else{
            $this->GetDBMaster()->query("UPDATE ".TABLE_ALERT_LOOK." SET "
                ." unread=0 WHERE userid='".SYS_USERID."' AND "
                ." alert_role_id='".$this->data['role_id']."'");
        }
        $where = '';
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ALERT_LIST." WHERE "
            ." alert_role_id='".$this->data['role_id']."' ".$where." ORDER BY alert_date DESC");
        return $data;
    }


    function GetNoticeText()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=error');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ALERT_LIST." "
            ." WHERE alert_id='".$this->data['id']."'");
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=数据不存在');
        }
        return $data;
    }




    function GetNoticeLookStatus()
    {
        $arr = array();
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ALERT_LOOK." "
            ." WHERE userid='".SYS_USERID."'");
        if($data)
        {
            foreach($data as $val)
            {
                $arr[$val['alert_role_id']] = $val['unread'];
            }
        }
        return $arr;
    }
}