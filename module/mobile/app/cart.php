<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class cart extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    protected function GetStoreList($array=array())
    {
        $return=array();
        if (!empty($array))
        {
            $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_STORE." "
                ." WHERE id IN (".implode(',',$array).") ORDER BY id ASC");
            foreach($data as $item)
            {
                $return[$item['id']]=$item;
            }
        }
        return $return;
    }

    function GetCartList($select_status = false)
    {
        $where = '';
        $select_money=0;
        if($select_status)
        {
            $where .= " AND C.select_status=1";
        }
        $date=date("Y-m-d H:i:s");
        $data = $this->GetDBSlave1()->queryrows("SELECT C.id,C.userid,C.product_id,C.product_count,C.select_status,S.store_url,"
            ." C.store_id,C.attr_id,C.attr_name,P.product_name,P.product_img,P.product_status,S.store_name,P.min_buy,P.max_buy,P.product_unit,P.ship_fee,"
            ." S.store_logo,S.ship_fee_money,S.free_fee,S.free_fee_money,S.product_ship_fee,SP.id AS ms_id,SP.seckill_price,SP.seckill_stock,BA.min_price AS bargain_price,BA.id AS bargain_create_id,P.product_price AS old_price,P.is_del,"
            ." COALESCE(BA.min_price,SP.seckill_price,(select max(attr_change_price) from d_attr where find_in_set(id,c.attr_id) group by product_id),P.product_price) AS product_price"
            ." FROM ".TABLE_CART." AS C  "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON C.product_id=P.product_id  "
            ." LEFT JOIN ".TABLE_SEKILL_PRODUCT." AS SP ON SP.product_id=C.product_id AND SP.start_time<'".$date."' AND SP.end_time>'".$date."' AND SP.seckill_status=0 AND SP.seckill_stock>0 AND SP.seckill_stock>SP.seckill_buy_stock"
            ." LEFT JOIN ".TABLE_GAMES_BARGAIN_CREATE." AS BA ON BA.product_id=C.product_id AND BA.userid='".SYS_USERID."' AND BA.reach_status=1 AND BA.over_status=0"
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id=S.store_id   "
            ." WHERE C.userid='".SYS_USERID."' ".$where." ORDER BY C.id DESC");
        $cart = array();
        $goods_postage = array();   //运费 按店计算
        $goods_limit_buy =array();  //限购
        if($data)
        {
            foreach($data as &$item)
            {
                if(!isset($cart[$item['store_id']]['store_id']))
                {
                    //初始化店铺数据
                    $cart[$item['store_id']]['store_id'] = $item['store_id'];
                    $cart[$item['store_id']]['store_name'] = $item['store_name'];
                    $cart[$item['store_id']]['store_logo'] = $item['store_logo'];
                    $cart[$item['store_id']]['store_url'] = $item['store_url'];
                    $cart[$item['store_id']]['free_fee'] = $item['free_fee'];
                    $cart[$item['store_id']]['product_ship_fee'] = $item['ship_fee'];
                    $cart[$item['store_id']]['free_fee_money'] = $item['free_fee_money'];
                    $cart[$item['store_id']]['all_selected'] = 1;
                    $goods_postage[$item['store_id']]['postage_total'] =$item['ship_fee_money'];
                    $goods_postage[$item['store_id']]['shop_total'] = 0;
                    $goods_postage[$item['store_id']]['ship_fee_money'] = $item['ship_fee_money'];
                    $goods_postage[$item['store_id']]['free_fee_money'] = $item['free_fee_money'];
                    $goods_postage[$item['store_id']]['free_fee'] = $item['free_fee'];
                    $goods_postage[$item['store_id']]['product_ship_fee'] = $item['product_ship_fee'];
                    $goods_postage[$item['store_id']]['valid_coupon_total']=0;
                }

                if($item['select_status'])
                {
                    if (!isset($goods_limit_buy[$item['product_id']]))
                    {
                        //限购数据初始化
                        $goods_limit_buy[$item['product_id']]['product_count']=0;
                        $goods_limit_buy[$item['product_id']]['min_buy']=$item['min_buy'];
                        $goods_limit_buy[$item['product_id']]['max_buy']=$item['max_buy'];
                    }
                    $goods_limit_buy[$item['product_id']]['product_count']+=$item['product_count'];
                    $goods_postage[$item['store_id']]['shop_total'] += $item['product_count'] * $item['product_price'];

                    //优惠券必须去除砍价、秒杀、
                    if (empty($item['seckill_price']) &&  empty($item['bargain_price']))
                    {
                        $goods_postage[$item['store_id']]['valid_coupon_total'] += $item['product_count'] * $item['product_price'];
                    }

                    $select_money+=$goods_postage[$item['store_id']]['shop_total'];
                    if ($goods_postage[$item['store_id']]['free_fee'] && $goods_postage[$item['store_id']]['shop_total']>=$goods_postage[$item['store_id']]['free_fee_money'])
                    {
                        $goods_postage[$item['store_id']]['postage_total']=0;
                    }else
                    {
                        //假如开启了单品运费，查出本店最高那个作为运费
                        if ($goods_postage[$item['store_id']]['product_ship_fee'])
                        {
                            if ($cart[$item['store_id']]['product_ship_fee']<=$item['ship_fee'])
                            {
                                $goods_postage[$item['store_id']]['postage_total']=$item['ship_fee'];
                            }
                        }else
                        {
                            $goods_postage[$item['store_id']]['postage_total']=$goods_postage[$item['store_id']]['ship_fee_money'];
                        }
                    }
                }else
                {
                    $goods_postage[$item['store_id']]['shop_total']  += 0;
                }
                $cart[$item['store_id']]['cart_list'][$item['id']] = $item;
                //有一个没有选中
                if($cart[$item['store_id']]['cart_list'][$item['id']]['select_status']==0)
                {
                    $cart[$item['store_id']]['all_selected'] = 0;
                }
                ksort($cart[$item['store_id']]['cart_list']);
            }
        }
        return array('cart'=>$cart,'goods_postage'=>$goods_postage,"select_money"=>$select_money,"goods_limit_buy"=>$goods_limit_buy);
    }


    function GetOneCart($cart_id=0)
    {
        $date=date("Y-m-d H:i:s");
        $data = $this->GetDBSlave1()->queryrow("SELECT C.*,SP.seckill_price,BA.min_price AS bargain_price,SP.seckill_price"
            ." FROM ".TABLE_CART." AS C  "
            ." LEFT JOIN ".TABLE_SEKILL_PRODUCT." AS SP ON SP.product_id=C.product_id AND SP.start_time<'".$date."' AND SP.end_time>'".$date."' AND SP.seckill_status=0 AND SP.seckill_stock>0 AND SP.seckill_stock>SP.seckill_buy_stock"
            ." LEFT JOIN ".TABLE_GAMES_BARGAIN_CREATE." AS BA ON BA.product_id=C.product_id AND BA.userid='".SYS_USERID."' AND BA.reach_status=1 AND BA.over_status=0"
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON C.store_id=S.store_id   "
            ." WHERE C.userid='".SYS_USERID."' AND C.id='".$cart_id."'");
        return $data;
    }
}