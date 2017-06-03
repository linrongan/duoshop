<?php
include RPC_DIR .'/conf/database_table_gw.php';
class pc extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //新闻列表
    function getAllNews()
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
            $where .= " AND news_title LIKE '%".$this->data['title']."%'";
            $canshu .='&title='.$this->data['title'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GW_NEWS." "
            ." WHERE 1 ".$where." ");

        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GW_NEWS." "
            ." WHERE 1 ".$where." "
            ." ORDER BY addtime DESC");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //新闻详细
    function getNewsDetails()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GW_NEWS." "
            ." WHERE id = '".$this->data['id']."'");
        return $data;
    }
    //页面的banner图
    function getPageBanner()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GW_INDEX_BANNER." "
            ." WHERE ad_type = 4 "
            ." ORDER BY id ASC");
        return $data;
    }
    //页面banner详情
    function getPageBannerDetails()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GW_INDEX_BANNER." "
            ." WHERE id = '".$this->data['id']."'");
        return $data;
    }

    //关于我们页面
    function getAboutPage()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GW_ABOUT." "
            ." ORDER BY type,id ASC");
        return $data;
    }
    //关于我们页面详情
    function getAboutPageDetails()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GW_ABOUT." "
            ." WHERE id = '".$this->data['id']."'");
        return $data;
    }
    //首页图片
    function getHomePicGroup($type,$id=0)
    {
        $where = '';
        if(!empty($id))
        {
            $where .= " AND id ='".$id."'";
        }
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GW_INDEX_BANNER." "
            ." WHERE ad_type='".$type."' ".$where." "
            ." ORDER BY picture_sort ASC");
        return $data;
    }
    //图片详情
    function getThisPicDetails()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GW_INDEX_BANNER." "
            ." WHERE ad_type='".$this->data['type']."' AND id = '".$this->data['id']."'");
        return $data;
    }


}