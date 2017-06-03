<?php
class product extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    /*
     * 产品列表
     * */
    function  GetAllProduct($page_size=8)
    {
        $where = $canshu = $order =  $category_canshu = '';
        if(isset($this->data['page']) && !empty($this->data['page']) && regExp::is_positive_number($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page  = 1;
        }
        if(isset($this->data['page_size']) && regExp::is_positive_number($this->data['page_size']))
        {
            $page_size = $this->data['page_size'];
        }
        if(isset($this->data['keyword']) && !empty($this->data['keyword']))
        {
            $where .= " AND product_name LIKE '%".$this->data['keyword']."%'";
            $canshu .="&keyword=".$this->data['keyword'];
        }
        if(isset($this->data['serach']) && !empty($this->data['serach']))
        {
            $where .= " AND product_name LIKE '%".$this->data['serach']."%'";
            $canshu .="&serach=".$this->data['serach'];
        }
        if(isset($this->data['category']) && !empty($this->data['category']))
        {
            $where .= " AND category_id='".$this->data['category']."'";
            $category_canshu .= "&category=".$this->data['category'].'&category_name='.
                (isset($this->data['category_name'])?$this->data['category_name']:'');
        }

        $filed = array(
            'zh'=>' ORDER BY P.product_id DESC,P.product_sold DESC',
            'xl'=>' ORDER BY P.product_sold DESC',
            'xp'=>' ORDER BY P.product_id DESC',
            'jg-a'=>' ORDER BY P.product_price ASC',
            'jg-d'=>' ORDER BY P.product_price DESC'
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
            $sort_canshu.='&sort='.$sort;
        }
        if($default_sort)
        {
            $order .= $filed['zh'];
            $sort = 'zh';
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." "
            ." AS P LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id WHERE "
            ." P.product_status=0 AND P.is_del=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.product_id,P.category_id,P.category_name,"
            ."P.product_name,P.product_img,P.product_desc,P.product_unit,P.product_price,"
            ."P.product_fake_price,P.product_sold,P.comment_count,P.comment_good_count,"
            ."P.comment_bad_count,ship_methed,P.seven_return,P.ship_city,"
            ."S.store_name,S.store_id FROM ".TABLE_PRODUCT." "
            ." AS P LEFT JOIN ".TABLE_COMM_STORE." "
            ."AS S ON P.store_id=S.store_id  WHERE P.is_del=0 AND "
            ."product_status=0 ".$where." ".$order."  LIMIT ".($page-1)*$page_size.",".$page_size."");
        $data = array(
            'data'=>$data,
            'pages'=>ceil($count['total'])/$page_size,
            'sort'=>$sort,
            'canshu'=>$canshu,
            'sort_canshu'=>$sort_canshu,
            'category_canshu'=>$category_canshu
        );
        if(regExp::is_ajax())
        {
            echo json_encode($data);exit;
        }
        return $data;
    }


    /*
     * 产品详情展示
     * */
    function GetProductViewData()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $date=date("Y-m-d H:i:s");
        $product=$this->GetDBSlave1()->queryrow("SELECT P.*,COALESCE(BA.min_price,SP.seckill_price,P.product_price) AS product_price,PD.product_flash,"
            ." PD.product_text,PD.product_param,S.store_name,S.store_url,S.store_logo,S.store_describe,"
            ." S.store_sold,S.store_product,S.follow_count,S.free_fee,S.free_fee_money,S.store_qq,S.ship_fee_money,S.product_ship_fee "
            ." FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_PRODUCT_DETAIL." AS PD ON P.product_id=PD.product_id "
            ." LEFT JOIN ".TABLE_SEKILL_PRODUCT." AS SP ON SP.product_id=P.product_id AND SP.start_time<'".$date."' AND SP.end_time>'".$date."' AND SP.seckill_status=0 AND SP.seckill_stock>0 AND SP.seckill_stock>SP.seckill_buy_stock"
            ." LEFT JOIN ".TABLE_GAMES_BARGAIN_CREATE." AS BA ON BA.product_id=P.product_id AND BA.userid='".SYS_USERID."' AND BA.reach_status=1 AND BA.over_status=0"
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id   "
            ." WHERE P.product_id='".$this->data['id']."'");
        if(!$product)
        {
            redirect(NOFOUND.'&msg=产品不存在');
        }

        $data = array();
        $colle = $this->GetProductColle($this->data['id']);
        $attr = $this->GetProductAttr($this->data['id']);
        $follow_shop = $this->GetShopFollow($product['store_id']);
        $data['product'] = $product;
        $count=$this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_PRODUCT." WHERE is_del=0 AND store_id='".$product['store_id']."' AND product_status=0");
        $data['product']['store_product']=$count['count'];
        $data['colle'] = $colle;
        $data['attr'] = $attr;
        $data['follow_shop'] = $follow_shop;
        //本时间段的团场次
        $Qutantum = module('seckill')->GetToTimeQuantum();
        if($Qutantum)
        {
            $seckill_pro = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SEKILL_PRODUCT."  "
                ." WHERE product_id='".$this->data['id']."' "
                ." AND quantum_id='".$Qutantum['quantum_id']."' "
                ." AND seckill_buy_stock<seckill_stock"
                ." AND start_day='".date("Y-m-d",time())."'");
            if($seckill_pro)
            {
                $data['quantum'] = $Qutantum;
                $data['seckill_pro'] = $seckill_pro;
            }else
            {
                $data['seckill_pro'] = null;
                $data['quantum'] = null;
            }
        }
        $group = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GROUP_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."' AND group_status=0");
        if($group)
        {
            $data['is_group'] = $group;
            $data['group_list'] = $this->GetProductToTimeGroup($this->data['id']);
            //获取正在团购的产品
        }else{
            $data['is_group'] = null;
            $data['group_list'] = null;
        }
        return $data;
    }


    function GetProductToTimeGroup($product_id)
    {
        return $this->GetDBSlave1()->queryrows("SELECT GB.*,U.nickname,U.headimgurl FROM ".TABLE_GROUP." "
            ." AS GB LEFT JOIN ".TABLE_USER." AS U ON GB.userid=U.userid WHERE "
            ." GB.product_id='".$product_id."' AND GB.start_time<='".date("Y-m-d H:i:s",time())."' "
            ." AND GB.end_time>='".date("Y-m-d H:i:s",time())."' AND GB.group_status=1 ORDER BY "
            ." RAND()  LIMIT 2");
    }


    function GetOneProduct($product_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT P.*,PD.product_text,PD.product_flash,"
            ." S.store_name,S.store_url,S.store_logo,S.store_describe,S.store_sold,"
            ." S.store_product FROM ".TABLE_PRODUCT." AS P LEFT JOIN ".TABLE_PRODUCT_DETAIL." "
            ." AS PD ON P.product_id=PD.product_id LEFT JOIN ".TABLE_COMM_STORE." AS S "
            ." ON P.store_id=S.store_id WHERE P.product_id='".$product_id."'");
    }


    //获取产品的属性
    public function GetProductAttr($product_id)
    {
        $array = array();
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,T.attr_type_id FROM "
            ." ".TABLE_ATTR." AS A LEFT JOIN ".TABLE_ATTR_TEMP." AS T ON "
            ." A.attr_temp_id=T.attr_id WHERE A.product_id='".$product_id."' "
            ." AND is_del=0");
        if(!empty($data)){
            foreach($data as $item)
            {
                $array[$item['attr_type_id']]['attr_type'] = $item['attr_type_name'];
                $array[$item['attr_type_id']]['attr'][] = $item;
            }
        }
        return $array;
    }


    /*产品收藏*/
    function GetProductColle($product_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_COLLE."  "
            ." WHERE userid='".SYS_USERID."' AND product_id='".$product_id."' ");
    }

    //店铺关注
    function GetShopFollow($store_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_FOLLOW_STORE."  "
            ." WHERE userid='".SYS_USERID."' AND store_id='".$store_id."' ");
    }


    /*
     * 秒杀场次
     * */
    function GetOneQuantum($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SEKILL_QUANTUM."  "
            ." WHERE quantum_id='".$id."'");
    }
}
?>
