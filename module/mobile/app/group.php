<?php
class group extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    /*
     * 团购详情
     *
     */
    function GetGroupBuyDetail()
    {
        if(!regExp::checkNULL($this->data['group_id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT GB.*,P.product_name,P.product_desc,P.product_img FROM ".TABLE_GROUP." AS GB "
            ."  LEFT JOIN ".TABLE_PRODUCT." AS P ON GB.product_id=P.product_id "
            ."  WHERE GB.group_id='".$this->data['group_id']."'");
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=找不到该团购信息');
        }elseif($data['group_status']==0)
        {
            redirect(NOFOUND.'&msg=团购还没有正式开始');
        }
        return $data;
    }



    //团购参与列表
    function GetGroupBuyList($group_id)
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT GO.userid,GO.group_id,GO.group_id,"
            ."GO.pay_status,GO.product_count,GO.atrr_name,GO.pay_date,GO.group_price,"
            ."GO.group_buy_type,U.nickname,U.headimgurl FROM ".TABLE_ORDER_GROUP." AS GO "
            ."LEFT JOIN ".TABLE_USER." AS U ON GO.userid=U.userid "
            ."WHERE GO.group_id='".$group_id."' AND GO.pay_status=1 "
            ."ORDER BY GO.group_buy_type DESC,GO.id ASC");
        return $data;
    }



    //团购商品列表
    function GetGroupProduct()
    {
        $where = $order = $canshu = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        if(isset($this->data['search']) && !empty($this->data['search']))
        {
            $where .= " AND product_name LIKE '%".$this->data['search']."%'";
        }
        if(isset($this->data['category']) && !empty($this->data['category']))
        {
            $where .= " AND category_id='".$this->data['category']."'";
            $canshu .="&category=".$this->data['category'];
        }
        $filed = array(
            'zh'=>' ORDER BY G.group_sort ASC,G.product_id DESC,G.group_sold DESC',
            'xl'=>' ORDER BY G.group_sold DESC',
            'xp'=>' ORDER BY P.product_id DESC',
            'jg-a'=>' ORDER BY G.group_price ASC',
            'jg-d'=>' ORDER BY G.group_price DESC'
        );
        $default_sort = true;
        $sort = '';
        $sort_canshu = '';
        if(isset($this->data['sort']) && array_key_exists($this->data['sort'],$filed))
        {
            $sort = $this->data['sort'];
            $order .= $filed[$this->data['sort']];
            $default_sort = false;
        }
        if($sort)
        {
            $sort_canshu .= "&sort=".$sort;
        }
        if($default_sort)
        {
            $order .= $filed['zh'];
            $sort = 'zh';
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_GROUP_PRODUCT." AS G"
            ."  LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id=P.product_id  "
            ."  WHERE G.group_status=0 AND P.product_status=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT G.*,P.product_name,P.product_desc,"
            ." P.product_img,P.product_price,S.store_name,S.store_logo FROM ".TABLE_GROUP_PRODUCT." AS G "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id=P.product_id  "
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON G.store_id=S.store_id "
            ." WHERE G.group_status=0  AND P.product_status=0 ".$where." ".$order."  "
            ." LIMIT ".($page-1)*$page_size.",".$page_size."");
        $return=array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size),
            'sort'=>$sort,
            'canshu'=>$canshu,
            'sort_canshu'=>$sort_canshu
        );
        if(regExp::is_ajax())
        {
            die(json_encode($return));
        }
        return $return;
    }




    //拼团列表
    function GetGroupOrder()
    {
        $where = $order = $canshu = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        if(isset($this->data['type']) && !empty($this->data['type']))
        {
            switch ($this->data['type'])
            {
                case 1:
                    $where .= " AND G.group_status=1";
                    break;
                case 2:
                    $where .= " AND G.group_status=2";
                    break;
                case 3:
                    $where .= " AND G.group_status=-1";
                    break;
            }
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ORDER_GROUP." "
            ." AS GO LEFT JOIN ".TABLE_GROUP." AS G ON GO.group_id=G.group_id AND G.group_status!=0 WHERE  "
            ." GO.userid='".SYS_USERID."' AND GO.pay_status=1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT GO.id AS gid,GO.pro_name,GO.product_img,GO.product_count,GO.atrr_name,"
            ." G.* FROM ".TABLE_ORDER_GROUP." AS GO "
            ." LEFT JOIN ".TABLE_GROUP." AS G ON GO.group_id=G.group_id AND G.group_status!=0 WHERE "
            ." GO.userid='".SYS_USERID."' AND GO.pay_status=1 ".$where." ORDER BY GO.id DESC "
            ." LIMIT ".($page-1)*$page_size.",".$page_size." ");
        $return=array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size),
            'canshu'=>$canshu,
        );
        return $return;
    }


    //团购订单明细  非正式订单
    function GetGroupOrderDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=订单不存在');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT GO.*,S.store_name,S.store_logo,G.group_status "
            ." FROM ".TABLE_ORDER_GROUP." "
            ." AS GO LEFT JOIN ".TABLE_COMM_STORE." AS S ON GO.store_id=S.store_id "
            ." LEFT JOIN ".TABLE_GROUP." AS G ON GO.group_id=G.group_id WHERE "
            ." GO.id='".$this->data['id']."' AND GO.userid='".SYS_USERID."'");
        if(!$data)
        {
            redirect(NOFOUND.'&msg=订单不存在');
        }
        return $data;
    }
}