<?php
class order extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //订单列表
    function GetOrderlist()
    {
        $where = $order = $canshu ='';
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        if(isset($this->data['type']) && !empty($this->data['type']))
        {
            $where .= " AND O.order_status='".$this->data['type']."'";
            $canshu .="&type=".$this->data['type'];
        }
        $page_size=  20;
        $order  = " ORDER BY O.id DESC";
        $count = $this->GetDBSlave1()->queryrow("SELECT SUM(pro_count) AS count,COUNT(*) AS total "
            ." FROM ".TABLE_O_ORDER_SHOP." AS O  WHERE O.userid='".SYS_USERID."' ".$where."  "
            ." AND O.order_status>=0");
        $data = $this->GetDBSlave1()->queryrows("SELECT O.*,S.store_name,S.store_logo,S.store_url FROM ".TABLE_O_ORDER_SHOP." AS O"
            ."  LEFT JOIN ".TABLE_COMM_STORE." AS S ON O.shop_id=S.store_id "
            ."  WHERE O.userid='".SYS_USERID."' AND O.order_status>=0"
            ." ".$where." ".$order." LIMIT  ".($page-1)*$page_size.",$page_size");
        $order_id = array();
        $children_order = null;
        if($data)
        {
            foreach($data as $val)
            {
                $order_id[] = $val['orderid'];
            }
            $details = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_ORDER_GOODS." "
                ." WHERE orderid IN (".implode(',',$order_id).") AND goods_refund!=3");
            //查询订单状态
            if(!empty($details))
            {
                foreach($details as $val)
                {
                    $children_order[$val['orderid']][$val['shop_id']][] = $val;
                }
            }
        }
        $array = array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size),
            'details'=>$children_order,
            "canshu"=>$canshu
        );
        if(!regExp::is_ajax())
        {
            return $array;
        }
        $html = '';
        if($data)
        {
            $Sys_Order_Status = array(-1 => '已退款', 0 => "已取消", 1 => "未付款", 2 => "处理中", 3 => "已支付", 4 => '已发货', 5 => '已收货', 6 => '待评价', 7 => '已评价', 8 => "已完成");
            foreach ($data as $item)
            {
                $html .= '<div class="web-cells">';
                $html .= '<div class="web-cell__title fr14" onclick="location.href=\'' . $item['store_url'] . '\'">';
                $html .= '    <img src="" class="mr10" style="width:1.2rem; height: 1.2rem; display: inline-block;vertical-align: bottom;">' . $item['store_name'] . '<i class="ml10 fa fa-chevron-right fr12"></i>';
                $html .= '     <p class="fr fr14">' . $Sys_Order_Status[$item['order_status']] . '</p>';
                $html .= '</div>';
                if (!empty($data['details'][$item['orderid']][$item['shop_id']])) {
                    foreach ($data['details'][$item['orderid']][$item['shop_id']] as $value)
                    {
                        $html .= '<div class="web-cell" style="background:#f8f8f8;" onclick="location.href=\'?mod=weixin&v_mod=order&_index=_view&id=' . $value['product_id'] . '\'">';
                        $html .= ' <div class="web-cell__hd">';
                        $html .= '    <img src="' . $value['product_img'] . '" class="mr10" style="width: 4rem; height: 4rem; display: block; border-radius: 3px; ">';
                        $html .= '</div>';
                        $html .= '<div class="web-cell__bd" style="width:60%;">';
                        $html .= '   <div class="fr14">';
                        $html .= '        <span class="fl mr10 omit" style="width:65%" >';
                        if ($item['order_type']) {
                            $html .= '  <img src="/template/source/images/tem.png" style="width:20px; height:20px; display:inline-block; margin-right:5px; vertical-align:middle; margin-top:-3px;" >';
                        }
                        $html .= $value['product_name'];
                        $html .= '      </span>';
                        $html .= '      <span class="fr red">￥' . $value['product_price'] . '</span>';
                        $html .= '      <div class="cb"></div>';
                        $html .= ' </div>';
                        $html .= '<div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">' . $value['product_attr_name'] . '</div>';
                        $html .= '<div class="mtr5">';
                        $html .= '   <div class=" fr12 cl_b9 fl" style="min-height: 1.25rem; line-height: 1.25rem; ">';
                        $html .= '       数量：' . $value['product_count'];
                        $html .= '     </div>';
                        $html .= '    <div class="fr">';
                        if ($item['order_status'] >= 3 && $item['order_type'] == 0) {
                            if ($value['goods_refund'] == 1) {
                                $html .= '<a href="javascript:;" class="order-click no-fg-btn fr12 mr10">申请退款中</a>';
                            } elseif ($value['goods_refund'] == 2) {
                                $html .= '<a href="javascript:;" class="order-click no-fg-btn fr12 mr10">退款确认中</a>';
                            } elseif ($value['goods_refund'] == 3) {
                                $html .= '<a href="javascript:;" class="order-click no-fg-btn fr12 mr10">已退款</a>';
                            } elseif ($value['goods_refund'] == 5) {
                                $html .= '<a href="javascript:;" class="order-click no-fg-btn fr12 mr10">关闭退款</a>';
                            }
                        }
                        $html .= ' </div>';
                        $html .= '        <div class="cb"></div>';
                        $html .= '   </div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '<div class="web-cell__text fr12">';
                        $html .= '   共<span class="red">' . $item['pro_count'] . '</span>件';
                        $html .= ' 合计：<span class="red">￥' . $item['total_money'] . '</span>';
                        if ($item['pro_fee'] > 0) {
                            $html .= '（含运费￥' . $item['pro_fee'] . '）';
                        }
                        if ($item['order_status'] < 3) {
                            if ((strtotime($item['addtime']) + 60 * 60 * 24 < time())) {

                                $html .= '<a href="javascript:;" onclick="QxShopOrder(this,' . $item['id'] . ')" class="fr order-click no-fg-btn fr14 qx-shop-order">取消</a>';
                            } else {
                                $html .= '<a href="?mod=weixin&v_mod=checkout&_index=_shop_pay&orderid=' . $item['orderid'] . '&shop_id=' . $item['shop_id'] . '" class="fr order-click no-fg-btn fr14 ">付款</a>';
                            }
                        } elseif ($item['order_status'] == 4) {
                            $html .= '<a href="javascript:;" onclick="confirm_get_goods(' . $item['id'] . ')" class="fr order-click no-fg-btn fr14 ">确认收货</a>';
                        } elseif ($item['order_status'] == 6) {
                            $html .= '<a href="?mod=weixin&v_mod=order&_index=_get_one&id=' . $item['id'] . '" class="fr order-click no-fg-btn fr14 ">再来一单</a>';
                        }
                        $html .= '<div class="cb"></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                }
            }
        }
        echo json_encode(array('data'=>$html,'pages'=>$array['pages']));exit;
    }



    function GetOneOrder($orderid)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER." WHERE "
            ."orderid='".$orderid."'");
    }



    function GetOrderDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $where = '';
        if(!isset($this->data['view']))
        {
            $where .= "AND userid='".SYS_USERID."'";
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT O.*,S.store_name,S.store_logo "
            ." FROM ".TABLE_O_ORDER_SHOP." AS O LEFT JOIN ".TABLE_COMM_STORE." AS S "
            ." ON O.shop_id=S.store_id WHERE "
            ." id='".$this->data['id']."' ".$where." ");
        $goods = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_ORDER_GOODS." "
            ." WHERE orderid='".$data['orderid']."' AND shop_id='".$data['shop_id']."'");
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=订单不存在');
        }
        return array('data'=>$data,'goods'=>$goods);
    }


    function GetWuliuStatus($number)
    {
        $api = 'http://api.jisuapi.com/express/query?appkey='.WULIU_KEY.'&type=auto&number='.$number;
        $result = doCurlGetRequest($api);
        return json_decode($result,true);
    }



    function GetShopOrder($id,$option)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER_SHOP." WHERE "
            ." ".$option."='".$id."' AND userid='".SYS_USERID."'");
    }



    function GetRefundOrderGoods()
    {
        if(!regExp::checkNULL($this->data['goods_id']))
        {
            return array('code'=>1,'msg'=>'缺少参数');
        }
        $array = $this->GetDBSlave1()->queryrow("SELECT G.*,SO.id AS sid,SO.shop_id,SO.order_status,"
            ."SO.order_type,SO.pay_method,SO.goods_confirm,SO.refund_status,SO.refund_money,SO.order_type,"
            ."SO.total_pro_money,SO.pay_money AS shop_pay_money,"
            ."SO.coupon_money,SO.pro_fee,R.id AS refund_id,AO.pay_money AS all_pay_money,AO.is_refund,"
            ."AO.refund_money,AO.is_all_pay FROM "
            ."".TABLE_O_ORDER_GOODS." AS G LEFT JOIN ".TABLE_O_ORDER_SHOP." AS "
            ."SO ON G.orderid=SO.orderid AND G.shop_id=SO.shop_id AND SO.order_type=0 "
            ."LEFT JOIN ".TABLE_REFUND_APPLY." AS R "
            ."ON G.id=R.goods_id AND R.refund_is_valid=0 "
            ."LEFT JOIN ".TABLE_O_ORDER." AS AO ON G.orderid=AO.orderid "
            ."WHERE G.id='".$this->data['goods_id']."' "
            ."AND G.userid='".SYS_USERID."'");
        $actual_refund = $array['product_sum_price'];
        $average_coupon = 0;
        if($array['coupon_money']>0)
        {
            $average_coupon = round($array['product_sum_price']*($array['coupon_money']/($array['total_pro_money'])),2);
        }
        $average_pro_fee = 0;
        if($array['pro_fee'])
        {
            $average_pro_fee = round($array['product_sum_price']*($array['pro_fee']/($array['total_pro_money'])),2);
        }
        $actual_refund = $actual_refund-$average_coupon;
        if($array['order_status']==3)
        {
            $actual_refund +=$average_pro_fee;
        }else{
            $average_pro_fee -= $average_pro_fee;
        }
        $array['actual_refund'] = $actual_refund;   //实际退款的钱
        $array['average_coupon'] = $average_coupon;
        $array['average_pro_fee'] = $average_pro_fee;
        if(!$array)
        {
            return array('code'=>1,'msg'=>'数据不存在');
        }
        return array('code'=>0,'data'=>$array);
    }


    //退款原因
    function GetRefundCauseOpt($type_id=0)
    {
        if(!regExp::is_ajax())
        {
            $where ='';
            if($type_id)
            {
                $where .= " AND type_id=".$type_id;
            }
            return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_REFUND_CAUSE." WHERE "
                ." 1  ".$where." "
                ." ORDER BY refund_sort ASC");
        }
        if(!regExp::checkNULL($this->data['refund_type_id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_REFUND_CAUSE." "
            ." WHERE type_id='".$this->data['refund_type_id']."'");
    }



    //查询退款信息
    function GetRefundDetails()
    {
        if(!regExp::checkNULL($this->data['goods_id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT FA.*,S.store_name,S.store_logo FROM ".TABLE_REFUND_APPLY." "
            ." AS FA LEFT JOIN ".TABLE_COMM_STORE." AS S ON FA.refund_order_store_id=S.store_id WHERE "
            ." FA.goods_id='".$this->data['goods_id']."' AND FA.refund_userid='".SYS_USERID."' "
            ." AND FA.refund_is_valid=0");
        return $data;
    }


    function GetRefundType()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_REFUND_CAUSE_TYPE." "
            ." ORDER BY ry_order ASC");
    }



    function GetRefundApplyInfo($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_REFUND_APPLY." "
            ." WHERE id='".$id."' AND refund_userid='".SYS_USERID."'");
    }

  //售后订单
    function GetServiceOrder()
    {
        $where = $order = $canshu ='';
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        if(isset($this->data['type']) && !empty($this->data['type']))
        {
            $where .= " AND O.order_status='".$this->data['type']."'";
            $canshu .="&type=".$this->data['type'];
        }
        $page_size=  10;
        $order  = " ORDER BY O.id DESC";
        $count = $this->GetDBSlave1()->queryrow("SELECT SUM(pro_count) AS count,COUNT(*) AS total FROM "
            ." ".TABLE_O_ORDER_SHOP." AS O INNER JOIN ".TABLE_O_ORDER_GOODS." AS G ON "
            ." O.orderid=G.orderid AND O.shop_id=G.shop_id AND G.goods_refund>0 AND G.is_del=0 WHERE "
            ." O.userid='".SYS_USERID."' AND O.is_del=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT O.*,S.store_name,S.store_logo,S.store_url "
            ." FROM ".TABLE_O_ORDER_SHOP." AS O LEFT JOIN ".TABLE_COMM_STORE." AS S ON "
            ." O.shop_id=S.store_id INNER JOIN ".TABLE_O_ORDER_GOODS." "
            ." AS G ON O.orderid=G.orderid AND O.shop_id=G.shop_id AND G.goods_refund>0 AND G.is_del=0 "
            ." WHERE O.userid='".SYS_USERID."'"
            ." AND O.is_del=0 ".$where." ".$order." LIMIT  ".($page-1)*$page_size.",$page_size");
        $order_id = array();
        $children_order = null;
        if($data)
        {
            foreach($data as $val)
            {
                $order_id[] = $val['orderid'];
            }
            $details = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_O_ORDER_GOODS." "
                ." WHERE orderid IN (".implode(',',$order_id).") AND goods_refund>0 AND is_del=0");
            //查询订单状态
            if(!empty($details))
            {
                foreach($details as $val)
                {
                    $children_order[$val['orderid']][$val['shop_id']][] = $val;
                }
            }
        }
        return array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size),
            'details'=>$children_order,
            "canshu"=>$canshu
        );
    }



    //获取当前订单
    function GetRecurOrder()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT O.*,S.store_logo,S.store_name FROM ".TABLE_O_ORDER_SHOP." "
            ." AS O LEFT JOIN ".TABLE_COMM_STORE." AS S ON O.shop_id=S.store_id WHERE "
            ." O.id='".$this->data['id']."' AND O.userid='".SYS_USERID."'");
        if(!$data)
        {
            redirect(NOFOUND.'&msg=订单不存在');
        }
        //查询订单产品
        $products = $this->GetDBSlave1()->queryrows("SELECT G.*,P.product_id AS "
            ." pro_id,P.min_buy,P.max_buy,SP.id AS ms_id,SP.seckill_price,COUNT(A.id) as attr_count "
            ." FROM ".TABLE_O_ORDER_GOODS." AS "
            ." G LEFT JOIN ".TABLE_PRODUCT." AS P ON G.product_id=P.product_id AND P.is_del=0 "
            ." LEFT JOIN ".TABLE_SEKILL_PRODUCT." AS SP ON G.product_id=SP.product_id "
            ." AND SP.seckill_status=0 AND SP.start_time>='".date("Y-m-d H:i:s",time())."' "
            ." AND SP.end_time<'".date("Y-m-d H:i:s",time())."'"
            ." LEFT JOIN ".TABLE_ATTR." AS A ON G.product_id=A.product_id AND A.id IN(G.product_attr_id) AND A.is_del=0"
            ." WHERE G.orderid='".$data['orderid']."' AND G.shop_id='".$data['shop_id']."' "
            ."  ");
       return array('data'=>$data,'product'=>$products);
    }





    function GetLogistics()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_LOGISTICS." "
            ." ORDER BY logistics_sort ASC");
    }


    //检查产品是否允许购买
    function GetCheckProIsCanBuy()
    {

    }

}
