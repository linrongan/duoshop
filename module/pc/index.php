<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

class index extends common_gw
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //获取广告信息,ad_type 为0时不区分
    function GetCommAd($sort='DESC',$limit=1,$ad_type=0)
    {
        $data = $this->GetDBSlave2()->queryrows("SELECT * FROM ".TABLE_GW_INDEX_BANNER." "
            ." WHERE picture_show=1 AND ad_type='".$ad_type."' "
            ." ORDER BY picture_sort ".$sort." LIMIT 0,".$limit."");
        return $data;
    }

    function GetSevenPicture($id)
    {
        $data = $this->GetDBSlave2()->queryrow("SELECT * FROM ".TABLE_GW_INDEX_BANNER." "
            ." WHERE id= '".$id."'");
        return $data;
    }

    //获取新闻列表
    function getNewsList()
    {
        $where=$canshu="";
        $page_size=3;
        if ((!isset($_REQUEST['curpage'])) or (!is_numeric($_REQUEST['curpage'])) or ($_REQUEST['curpage']<1))
        {
            $curpage=1;
        }
        else
        {
            $curpage=intval($_REQUEST['curpage']);
        }
        if (isset($_REQUEST['page_size']))
        {
            $page_size=intval($_REQUEST['page_size']);
        }
        if (isset($_REQUEST['category']))
        {
            $where .= 'AND news_category='.intval($_REQUEST['category']);
        }else
        {
            $where .= 'AND news_category=0';
        }

        $total = $this->GetDBSlave2()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GW_NEWS." "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave2()->queryrows("SELECT * FROM ".TABLE_GW_NEWS." "
            ." WHERE 1 ".$where." ORDER BY id DESC "
            ." LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$total['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //新闻详细
    function getNewsDetails($id)
    {
        $data = $this->GetDBSlave2()->queryrow("SELECT * FROM ".TABLE_GW_NEWS." "
            ." WHERE id = '".$id."'");
        return $data;
    }
    //关于我们页面详情
    function getAboutPageDetail($id=1)
    {
        $data = $this->GetDBSlave2()->queryrow("SELECT * FROM ".TABLE_GW_ABOUT." "
            ." WHERE id = '".$id."'");
        return $data;
    }
    //关于我们页面
    function getAboutPage($type=1)
    {
        $data = $this->GetDBSlave2()->queryrows("SELECT * FROM ".TABLE_GW_ABOUT." "
            ." WHERE type = '".$type."'");
        return $data;
    }
    //首页最新新闻0行业资讯1公司新闻
    function getHomeNews($type=0)
    {
        $data = $this->GetDBSlave2()->queryrows("SELECT * FROM ".TABLE_GW_NEWS." "
            ." WHERE news_category = '".$type."' ORDER BY addtime DESC "
            ." LIMIT 5 ");
        return $data;
    }
    /*
     * 获取页面banner
     * ad_type=4
     * @param $id 页面id。
     * 12 新闻动态，13招商加盟，14关于我们，15联系我们
     * */
    function getPageBanner($id)
    {
        $data = $this->GetDBSlave2()->queryrow("SELECT * FROM ".TABLE_GW_INDEX_BANNER." "
            ." WHERE id= '".$id."' AND ad_type=4");
        return $data;
    }

    //pc_shop
    //商城分类
    public function GetCategory()
    {
        $data = $this->GetDBSlave2()->queryrows("SELECT * FROM ".TABLE_COMM_CATEGORY." "
            ." WHERE category_show=0 ORDER BY category_parent_id,category_sort,category_id ASC");
        $category = array();
        $category_info=array();
        $i=0;
        foreach($data as $item)
        {
            $category_info[$item['category_id']] = $item;
            $category[$item['category_parent_id']][$i] = $item;
            $i++;
        }
        return array('category'=>$category,'data'=>$data,'category_info'=>$category_info);
    }
    //banner轮播
    public function GetHomeBanner()
    {
        $data = $this->GetDBSlave2()->queryrows("SELECT * FROM ".TABLE_PC_PICTURE." "
            ." WHERE ad_type= 0 AND picture_show=1 ORDER BY picture_sort ASC LIMIT 8");
        return $data;
    }
    //获取当前秒杀
    function GetTodayTimeSeckill()
    {
        $date = date("Y-m-d H:i:s");
        $seckill= $this->GetDBSlave2()->queryrows("SELECT SP.product_id,SP.seckill_price,"
            ." P.product_name,P.product_img,P.product_price FROM  ".TABLE_SEKILL_PRODUCT." AS SP "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON SP.product_id=P.product_id "
            ." WHERE SP.end_time>'".$date."' AND seckill_status=0"
            ." ORDER BY SP.end_time ASC,SP.seckill_sort ASC LIMIT 0,8");
        if($seckill)
        {
            return $seckill;
        }
        return null;
    }
}