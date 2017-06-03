<?php
class point extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //积分类别
    function GetPointCategory()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_CATEGORY.""
            ." ORDER BY ry_order ASC");
        return $data;
    }

    //积分商品
    function GetPointProduct()
    {
        $where='';
        if (isset($this->data['category_id']) && $this->data['category_id']<>"")
        {
            $where.=" AND category_id='".$this->data['category_id']."'";
        }elseif(isset($this->data['category_id']) && $this->data['category_id']==0)
        {
            $user=$this->GetUserInfo(SYS_USERID);
            //自己能兑换的
            $where.=" AND gift_point<=".$user['point']."";
        }
        //所有类别
        if (isset($this->data['category_id']) && $this->data['category_id']=="-1")
        {
            $where='';
        }
        if (isset($this->data['keyword']) && $this->data['keyword']<>"")
        {
            $where.=" AND gift_name like '%".$this->data['keyword']."%'";
        }
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_PRODUCT." WHERE 1 ".$where." "
            ." ORDER BY ry_order ASC");
        if(regExp::is_ajax())
        {
            echo json_encode(array("data"=>$data));exit;
        }
        return array("data"=>$data);
    }
    //获取积分产品列表
    function GetPointProductList()
    {
        $where='';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $title = '全部产品';
        if(isset($this->data['category']) && !empty($this->data['category']))
        {
            $category = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_CATEGORY." WHERE "
                ." category_id='".$this->data['category']."'");
            if($category)
            {
                $title = $category['category_name'];
            }
            $where .= " AND category_id='".$this->data['category']."'";
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_GIFT_PRODUCT." WHERE qty>0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_PRODUCT." "
            ." WHERE qty>0 ".$where." ORDER BY id DESC LIMIT ".($page-1)*$page_size.","
            ." ".$page_size." ");
        return array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size),
            'title'=>$title
        );
    }
    //积分商品详情
    function GetPointProductDetail()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_PRODUCT." "
            ." WHERE id='".$this->data['id']."'");
        if (empty($data))
        {
            redirect(NOFOUND);
        }
        return $data;
    }
    //获取购物车商品select 1为选中的商品
    function GetCart($select=0)
    {
        $where='';
        if ($select)
        {
            $where.=' AND C.select_status=0';
        }
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_CART." AS C "
            ." LEFT JOIN ".TABLE_GIFT_PRODUCT." AS P ON C.gift_id=P.id"
            ." WHERE C.userid='".SYS_USERID."' "
            ." AND P.id>0 ".$where.""
            ." ORDER BY C.addtime DESC");
        return array("data"=>$data);
    }
    //获取购物车中的某商品
    function GetProductDetail($gift_id=0)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_CART." "
            ." WHERE userid='".SYS_USERID."' "
            ." AND gift_id='".$gift_id."'");
        return $data;
    }
    //获取购物车总积分数select 1为选中的商品
    function GetCartTotal($select=0)
    {
        $where='';
        if ($select)
        {
            $where.=' AND C.select_status=0';
        }
        $data=$this->GetDBSlave1()->queryrow("SELECT SUM(C.cart_qty) AS count,SUM(P.gift_point*C.cart_qty) AS total "
            ." FROM ".TABLE_GIFT_CART." AS C"
            ." LEFT JOIN ".TABLE_GIFT_PRODUCT." AS P ON C.gift_id=P.id"
            ." WHERE C.userid='".SYS_USERID."' "
            ." AND P.id>0 ".$where."");
        return $data;
    }

    //礼品订单详情
    function GiftOrderDetail()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_ORDER." "
            ." WHERE userid='".SYS_USERID."' "
            ." AND orderid='".$this->data['id']."'");
        if (empty($data))
        {
            redirect(NOFOUND.'&msg=找不到该礼品订单');
        }
        $detail=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_ORDER_DETAIL." "
            ." WHERE userid='".SYS_USERID."' "
            ." AND orderid='".$this->data['id']."'");
        return array("data"=>$data,"detail"=>$detail);
    }
    //获取礼品订单列表
    function GiftOrderList()
    {
        $page_size = 10;
        $where = $canshu = ' ';
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page  = $this->data['page'];
        }else{
            $page = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT count(*) AS count "
            ." FROM ".TABLE_GIFT_ORDER." WHERE "
            ." userid='".SYS_USERID."' ".$where."");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_ORDER." WHERE "
            ." userid='".SYS_USERID."' "
            ." ".$where." ORDER BY orderid DESC LIMIT ".($page-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'pages'=>ceil($count['count']/$page_size));
    }
    //获取礼品订单列表
    function GiftOrderDetailList()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GIFT_ORDER_DETAIL." "
            ." WHERE userid='".SYS_USERID."' "
            ." AND orderid='".$this->data['orderid']."'");
        return array("data"=>$data);
    }
    //获取积分日记列表
    function GetPointLog()
    {
        //积分获得总数
        $get=$this->GetDBSlave1()->queryrow("SELECT SUM(point) AS point FROM ".TABLE_LOG_POINT." "
            ." WHERE userid='".SYS_USERID."' AND point>0");
        $fee=$this->GetDBSlave1()->queryrow("SELECT SUM(point) AS point FROM ".TABLE_LOG_POINT." "
            ." WHERE userid='".SYS_USERID."' AND point<0");
        //积分消费总数
        $data=$this->GetDBSlave1()->queryrows("SELECT P.*,T.type_name FROM ".TABLE_LOG_POINT." AS P "
            ." LEFT JOIN ".TABLE_FEE_TYPE." AS T ON T.type_id=P.type_id"
            ." WHERE P.userid='".SYS_USERID."' ORDER BY P.addtime DESC");
        return array("data"=>$data,"get"=>$get['point'],"fee"=>$fee['point']);
    }
    //执行礼品核销
    function ActionGiftClosure($data)
    {
        //检验礼品
        $order=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_ORDER_DETAIL." "
            ." WHERE hx_code='".$data['hx_code']."'");
        if (empty($order))
        {
            return array("code"=>1,"msg"=>"找不到该礼品");
        }else
        {
            if ($order['hx_status'])
            {
                return array("code"=>1,"msg"=>"该商品已经在".$order['hx_date']."核销过了");
            }else
            {
                $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_ORDER_DETAIL." "
                    ." SET hx_status=1,hx_date='".date("Y-m-d H:i:s")."' "
                    ." WHERE hx_code='".$data['hx_code']."'");

                $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_PRODUCT." "
                    ." SET hx_sale=hx_sale+".intval($order['qty'])." "
                    ." WHERE id='".$order['gift_id']."'");

                return array("code"=>0,"msg"=>"该礼品核销成功！","gift_name"=>$order['gift_name'],"qty"=>$order['qty']);
            }
        }
    }
    //积分日记表
    protected function AddPointLog($type_id=0,$point=0,$userid=0,$orderid=0)
    {
        if (empty($userid))
        {
            $userid=SYS_USERID;
        }
        $user=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." WHERE userid='".$userid."'");
        $this->GetDBMaster()->query("INSERT INTO ".TABLE_LOG_POINT." "
            ." (point,addtime,type_id,userid,orderid,point_banlace)VALUES('".$point."',"
            ."'".date("Y-m-d H:i:s")."','".$type_id."',"
            ."'".$userid."','".$orderid."','".$user['user_point']."')");
    }
    //积分明细
    function GetPointList()
    {

        $page_size = 10;
        $where = $canshu = ' ';
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page  = $this->data['page'];
        }else{
            $page = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT count(*) AS count,SUM(point) AS point "
            ." FROM ".TABLE_POINT_DETAIL." WHERE "
            ." userid='".SYS_USERID."' ".$where."");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_POINT_DETAIL." WHERE "
            ." userid='".SYS_USERID."' "
            ." ".$where." ORDER BY id DESC LIMIT ".($page-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'pages'=>ceil($count['count']/$page_size),'money_total'=>$count['point']);
    }
}