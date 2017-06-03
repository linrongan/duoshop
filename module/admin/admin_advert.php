<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_advert extends comm
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //获取投放广告列表
    function GetAdvertRecord()
    {
        $where=$canshu="";
        $page_size = 15;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        if(isset($this->data['picture_type']) && !empty($this->data['picture_type']))
        {
            $where .= " AND A.picture_type>='".$this->data['picture_type']."'";
            $canshu .='&picture_type='.$this->data['picture_type'];
        }
        if(isset($this->data['status']) && $this->data['status']<>"")
        {
            if($this->data['status']==1)
            {
                $date=date("Y-m-d H:i:s");
                $where .= " AND A.status='".$this->data['status']."' AND A.expire_time>'".$date."' AND A.start_time<'".$date."'";
            }elseif($this->data['status']==2)
            {
                $date=date("Y-m-d H:i:s");
                $where .= " AND A.expire_time<'".$date."' AND A.status>0";
            }else
            {
                $where .= " AND A.status='".$this->data['status']."'";
            }
            $canshu .='&status='.$this->data['status'];

        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_O_ADVERT." AS A "
            ." LEFT JOIN ".TABLE_ADVERT_REGION."  AS R ON A.picture_type=R.id "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON S.store_id=A.store_id "
            ." WHERE A.advert_day>0 AND A.status>0 AND A.is_del=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,R.name,S.store_name FROM ".TABLE_O_ADVERT." AS A "
            ." LEFT JOIN ".TABLE_ADVERT_REGION." AS R ON A.picture_type=R.id  "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON S.store_id=A.store_id "
            ." WHERE A.advert_day>0 AND A.status>0 AND A.is_del=0 ".$where." ORDER BY A.picture_type ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }

    //获取广告类型
    public function getAdvertType()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ADVERT_REGION." "
            ." ORDER BY picture_type ASC,show_sort ASC ");
    }

    public function getOneAdvert()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ADVERT." "
            ." WHERE  is_del=0 AND id = '".$this->data['id']."'");
    }
    public function getOneAdvertType($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADVERT_REGION." "
            ." WHERE id = '".$id."'");
    }
    public function GetAdvertData()
    {
        $banner = $this->GetBannerPic();
        $shop = $this->GetChoiceShop();
        return array(
            'banner'=>$banner,
            'shop'=>$shop
        );
    }
    /*
     * 首页banner
     * */
    private function GetBannerPic()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_BANNER." "
            ." WHERE picture_show=0 AND expire_time>'".date("Y-m-d H:i:s")."' ORDER BY picture_sort ASC");
        $arr=array();
        $i=0;
        if(!empty($data))
        {
            foreach($data as $item)
            {
                $arr[$item['picture_type']][$i] = $item;
                $i++;
            }
        }
        return $arr;
    }
    /*
     * 首页精选店铺
     * */
    private function GetChoiceShop()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT S.*,A.admin_name FROM ".TABLE_STORE_CHOICE." AS SC "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON SC.store_id=S.store_id  "
            ."LEFT JOIN ".TABLE_ADMIN." AS A ON S.admin_id=A.admin_id "
            ." WHERE SC.show_status=0 "
            ." ORDER BY SC.pay_money DESC,SC.show_sort ASC");
        return $data;
    }

}