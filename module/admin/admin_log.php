<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_log extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //获取系统日志
    public function getLogSystem()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['title']) && !empty($this->data['title']))
        {
            $where .= " AND key_title LIKE '%".$this->data['title']."%'";
            $canshu .='&title='.$this->data['title'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_LOG_ALERTED." "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_LOG_ALERTED." WHERE 1 "
            .$where." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //获取管理员登录记录
    public function getAdminLogin()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(login_date,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(login_date,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['admin_id']) && !empty($this->data['admin_id']))
        {
            $where .= " AND admin_id = '".$this->data['admin_id']."'";
            $canshu .='&admin_id='.$this->data['admin_id'];
        }
        if(isset($this->data['login_status']) && is_numeric($this->data['login_status'])){
            $where .= " AND login_status='".$this->data['login_status']."'";
            $canshu = "&login_status=".$this->data['login_status'];
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ADMIN_LOGIN." "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ADMIN_LOGIN." WHERE 1 "
            .$where." ORDER BY login_date DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //获取短信发送日志
    public function getLogSmscode()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['nickname']) && !empty($this->data['nickname']))
        {
            $where .= " AND U.nickname LIKE '%".$this->data['nickname']."%'";
            $canshu .='&nickname='.$this->data['nickname'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_LOG_SMSCODE." "
            ." AS S LEFT JOIN ".TABLE_USER." AS U ON S.userid=U.userid WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT S.*,U.nickname FROM ".TABLE_LOG_SMSCODE." "
            ." AS S LEFT JOIN ".TABLE_USER." AS U ON S.userid=U.userid WHERE 1 "
            .$where." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //用户反馈记录
    public function getLogFeedback()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(F.addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(F.addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        if(isset($this->data['store_name']) && !empty($this->data['store_name']))
        {
            $where .= " AND S.store_name LIKE '%".$this->data['store_name']."%'";
            $canshu .='&store_name='.$this->data['store_name'];
        }
        if(isset($this->data['back_status']) && is_numeric($this->data['back_status'])){
            $where .= " AND F.back_status='".$this->data['back_status']."'";
            $canshu = "&back_status=".$this->data['back_status'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_FEEDBACK." "
            ." AS F LEFT JOIN ".TABLE_USER." AS U ON F.userid=U.userid LEFT JOIN ".TABLE_COMM_STORE." "
            ." AS S ON F.store_id=S.store_id WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT F.*,U.nickname,S.store_name FROM ".TABLE_FEEDBACK." "
            ." AS F LEFT JOIN ".TABLE_USER." AS U ON F.userid=U.userid LEFT JOIN ".TABLE_COMM_STORE." "
            ." AS S ON F.store_id=S.store_id WHERE 1 "
            .$where." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //积分日记
    public function getLogPoint()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(P.addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(P.addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_LOG_POINT." AS P "
            ." LEFT JOIN ".TABLE_USER." AS U ON P.userid=U.userid "
            ." LEFT JOIN ".TABLE_FEE_TYPE." AS T ON P.type_id=T.type_id "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,U.nickname,T.type_name FROM ".TABLE_LOG_POINT." AS P "
            ." LEFT JOIN ".TABLE_USER." AS U ON P.userid=U.userid "
            ." LEFT JOIN ".TABLE_FEE_TYPE." AS T ON P.type_id=T.type_id "
            ." WHERE 1 ".$where
            ." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
}