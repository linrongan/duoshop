<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_shop extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //获取商铺列表
    public function getAllShop()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        if(isset($this->data['title']) && !empty($this->data['title']))
        {
            $where .= " AND S.store_name LIKE '%".$this->data['title']."%'";
            $canshu .='&title='.$this->data['title'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_COMM_STORE." AS S "
            ." LEFT JOIN ".TABLE_ADMIN." AS A ON S.admin_id=A.admin_id "
            ." LEFT JOIN ".TABLE_COMM_TEMPLATE." AS T ON S.template_id=T.template_id "
            ." LEFT JOIN ".TABLE_STORE_CHOICE." AS C ON S.store_id=C.store_id "
            ." LEFT JOIN ".TABLE_COMM_STORE_PHYSICAL." AS SP ON S.store_id=SP.store_id "
            ." WHERE 1 ".$where." ");

        $data = $this->GetDBSlave1()->queryrows("SELECT S.*,A.admin_name,T.template_name,T.template_id,IFNULL(C.show_status,1) AS show_status,IFNULL(SP.status,0) AS physical FROM ".TABLE_COMM_STORE." AS S "
            ." LEFT JOIN ".TABLE_ADMIN." AS A ON S.admin_id=A.admin_id "
            ." LEFT JOIN ".TABLE_COMM_TEMPLATE." AS T ON S.template_id=T.template_id "
            ." LEFT JOIN ".TABLE_STORE_CHOICE." AS C ON S.store_id=C.store_id "
            ." LEFT JOIN ".TABLE_COMM_STORE_PHYSICAL." AS SP ON S.store_id=SP.store_id "
            ." WHERE 1".$where." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );

    }

    //获取当前店铺
    public function getThisShop()
    {
        $where = " AND S.store_id='".$this->data['id']."'";
        $data = $this->GetDBSlave1()->queryrow("SELECT S.*,A.admin_name,T.template_name,T.template_id,SP.lng,SP.lat,SP.address,SP.min_ship_fee,SP.ship_fee,SP.status FROM ".TABLE_COMM_STORE."  AS S "
            ." LEFT JOIN ".TABLE_ADMIN." AS A ON S.admin_id=A.admin_id "
            ." LEFT JOIN ".TABLE_COMM_TEMPLATE." AS T ON S.template_id=T.template_id "
            ." LEFT JOIN ".TABLE_COMM_STORE_PHYSICAL." AS SP ON S.store_id=SP.store_id"
            ." WHERE 1".$where." ");
        return $data;
    }

    //获取主题
    public function getTemplateList()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_TEMPLATE." ");
        return $data;
    }

    /*
     * 首页banner
     * */
    function GetHomeTopBanner($type=0)
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_BANNER." "
            ." WHERE picture_type = '".$type."' ORDER BY picture_sort ASC");
    }

    /*
     * 功能导航
     * */
    function GetHomeNav()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_NAV." "
            ." ORDER BY nav_sort ASC");
    }
    /*
     * 首页数据
     * */
    function GetHomeData()
    {
        $array = array();
        $array['banner'] = $this->GetHomeTopBanner();
        $array['nav'] = $this->GetHomeNav();
        return $array;
    }
    //图片详情
    function getThisPicDetails()
    {
        if($this->data['type']==99)
        {
            $table = TABLE_O_NAV;
        }else
        {
            $table = TABLE_O_BANNER;
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".$table." "
            ." WHERE id = '".$this->data['id']."'");
        return $data;
    }
    //新闻通知
    function GetHomeNotice()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_INDEX_NOTICE." "
            ." ORDER BY notice_sort ASC");
    }
    //通知详情
    function getThisNotice()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_INDEX_NOTICE." "
            ." WHERE id = '".$this->data['id']."'");
        return $data;
    }
}