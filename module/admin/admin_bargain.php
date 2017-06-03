<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class admin_bargain extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //砍价商品
    function getBargainProduct()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['product_name']) && !empty($this->data['product_name']))
        {
            $where .= " AND product_name LIKE '%".$this->data['product_name']."%'";
            $where .= " OR P.product_id = '".$this->data['product_name']."'";
            $canshu .= "&product_name=".$this->data['product_name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GAMES_BARGAIN." AS B "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON B.product_id = P.product_id "
            ." WHERE P.is_del=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT B.*,P.product_name,P.product_img,P.product_fake_price,P.product_price"
            ." FROM ".TABLE_GAMES_BARGAIN." AS B "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON B.product_id = P.product_id "
            ." WHERE P.is_del=0 ".$where." "
            ." ORDER BY B.end_time DESC,B.sort ASC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    //商品列表
    public function GetProductList()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['product_name']) && !empty($this->data['product_name']))
        {
            $where .= " AND P.product_name LIKE '%".$this->data['product_name']."%' OR S.store_name LIKE '%".$this->data['product_name']."%' ";
            $param .= "&product_name=".$this->data['product_name'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,S.store_name FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id "
            ." WHERE P.is_del=0 ".$where." "
            ." ORDER BY P.product_id DESC LIMIT "
            ." ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }
    //砍价详情
    public function getBargainProductDetail()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GAMES_BARGAIN." AS B "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON B.product_id = P.product_id "
            ." WHERE P.is_del=0 AND B.id='".$this->data['id']."'");
        return $data;
    }
    //参与用户
    function getBargainUserList()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GAMES_BARGAIN_CREATE." AS BC "
            ." LEFT JOIN ".TABLE_USER." AS U ON BC.userid = U.userid "
            ." LEFT JOIN ".TABLE_GAMES_BARGAIN." AS B ON BC.bargain_id = B.id "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON B.product_id = P.product_id "
            ." WHERE bargain_id ='".$this->data['id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT BC.*,U.nickname,U.headimgurl,P.product_price"
            .",B.min_price FROM ".TABLE_GAMES_BARGAIN_CREATE." AS BC "
            ." LEFT JOIN ".TABLE_USER." AS U ON BC.userid = U.userid "
            ." LEFT JOIN ".TABLE_GAMES_BARGAIN." AS B ON BC.bargain_id = B.id "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON B.product_id = P.product_id "
            ." WHERE bargain_id ='".$this->data['id']."' ".$where." "
            ." ORDER BY BC.addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
    //帮助者
    public function GetBargainUserHelp()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GAMES_BARGAIN_JOIN." AS BJ "
            ." LEFT JOIN ".TABLE_USER." AS U ON BJ.userid = U.userid "
            ." WHERE create_id ='".$this->data['id']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT BJ.*,U.nickname,U.headimgurl"
            ." FROM ".TABLE_GAMES_BARGAIN_JOIN." AS BJ "
            ." LEFT JOIN ".TABLE_USER." AS U ON BJ.userid = U.userid "
            ." WHERE create_id ='".$this->data['id']."' ".$where." "
            ." ORDER BY BJ.addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }
}