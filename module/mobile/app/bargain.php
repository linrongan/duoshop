<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class bargain extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //轮播
    public function getBargainBanner()
    {
        $date=date("Y-m-d H:i:s");
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_BANNER."  "
            ." WHERE picture_show=0 "
            ." AND picture_type = 4 "
            //." AND start_status=1 "
            //." AND start_time<'".$date."'"
            //." AND expire_time>'".$date."'"
            ." ORDER BY pay_money DESC,picture_sort ASC LIMIT 3");
    }
    //产品列表
    public function GetBargainProductList()
    {
        $date=date("Y-m-d H:i:s");
        $page_size = 8;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        //参与人数
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_GAMES_BARGAIN_JOIN." ");
        //分页
        $total = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GAMES_BARGAIN." AS B "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON B.product_id=P.product_id "
            ." WHERE P.product_status=0 "
            ." AND B.start_time<'".$date."'"
            ." AND B.end_time>'".$date."'");
        $data = $this->GetDBSlave1()->queryrows("SELECT B.*,P.* FROM ".TABLE_GAMES_BARGAIN." AS B "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON B.product_id=P.product_id  "
            ." WHERE P.product_status=0 "
            ." AND B.start_time<'".$date."'"
            ." AND B.end_time>'".$date."'"
            ." ORDER BY B.sort ASC "
            ." LIMIT ".($page-1)*$page_size.", ".$page_size." ");
        if(regExp::is_ajax())
        {
            echo json_encode(array('data'=>$data,'count'=>$count,'pages'=>ceil($total['total']/$page_size)));exit;
        }
        return array('data'=>$data,'count'=>$count,'pages'=>ceil($total['total']/$page_size));
    }
    //产品详情
    public function GetBargainProductDetail($id='')
    {
        if(isset($id) && !empty($id))
        {
            $bargain_id = $id;
        }else
        {
            $bargain_id = $this->data['id'];
        }
        $date=date("Y-m-d H:i:s");
        $data = $this->GetDBSlave1()->queryrow("SELECT B.*,P.* FROM ".TABLE_GAMES_BARGAIN." AS B "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON B.product_id=P.product_id  "
            ." WHERE P.product_status=0 "
            ." AND B.start_time<'".$date."'"
            ." AND B.end_time>'".$date."'"
            ." AND B.id='".$bargain_id."'");
        return $data;
    }
    //实力总榜
    public function GetBargainRankingList()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT BC.*,U.nickname,U.headimgurl FROM ".TABLE_GAMES_BARGAIN_CREATE." AS BC "
            ." LEFT JOIN ".TABLE_USER." AS U ON BC.userid=U.userid  "
            ." WHERE BC.bargain_id='".$this->data['id']."' ORDER BY BC.minus_money+BC.help_money DESC");
        $arr = array();
        if(!empty($data))
        {
            foreach($data as $item)
            {
                $arr[$item['bargain_id']][$item['userid']]=$item;
            }
        }
        return array('data'=>$data,'my'=>$arr);
    }
    //我的运气榜
    public function GetMyRankingList()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT BJ.*,U.nickname,U.headimgurl FROM ".TABLE_GAMES_BARGAIN_JOIN." AS BJ "
            ." LEFT JOIN ".TABLE_USER." AS U ON BJ.userid=U.userid  "
            ." WHERE BJ.bargain_id='".$this->data['id']."' AND BJ.help_userid='".SYS_USERID."'"
            ." ORDER BY BJ.minus_money DESC ");
        return $data;
    }
    //创建者砍价详情
    public function getCreateDetails()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT BC.* FROM ".TABLE_GAMES_BARGAIN_CREATE." AS BC "
            ." WHERE BC.id = '".$this->data['id']."'");
        return $data;
    }

    //Create运气榜
    public function GetCreateRankingList()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT BJ.*,U.nickname,U.headimgurl FROM ".TABLE_GAMES_BARGAIN_JOIN." AS BJ "
            ." LEFT JOIN ".TABLE_USER." AS U ON BJ.userid=U.userid  "
            ." WHERE BJ.create_id='".$this->data['id']."' ORDER BY BJ.minus_money DESC");
        $arr = array();
        if(!empty($data))
        {
            foreach($data as $item)
            {
                $arr[$item['userid']]=$item;
            }
        }
        return array('data'=>$data,'my'=>$arr);
    }
}