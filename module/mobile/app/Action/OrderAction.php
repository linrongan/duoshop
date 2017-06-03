<?php
class OrderAction extends order
{
    function __construct($data)
    {
        $this->data = $data;
    }

    function ActionShouhuo()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'订单号错误');
        }
        $order = $this->GetOneOrder($this->data['orderid']);
        if(!$order || $order['userid']!=SYS_USERID)
        {
            return array('code'=>1,'msg'=>'订单号错误');
        }elseif($order['order_status']!=4)
        {
            return array('code'=>1,'msg'=>'订单未处于已发货状态');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET order_status=6,"
            ."goods_confirm='".date("Y-m-d H:i:s",time())."' WHERE "
            ."orderid='".$this->data['orderid']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'操作成功');
        }
        return array('code'=>1,'msg'=>'订单更新状态失败');
    }


    function ActionQxShopOrder()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'error');
        }
        $data = $this->GetShopOrder($this->data['id'],'id');
        if(!$data)
        {
            return array('code'=>1,'msg'=>'无此订单信息');
        }
        $order_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_O_ORDER_SHOP." "
            ." WHERE orderid='".$data['orderid']."'");
        $this->GetDBMaster()->StartTransaction();
        //删除店铺订单
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_O_ORDER_SHOP." WHERE "
            ." id='".$this->data['id']."'");
        $res1 = $this->GetDBMaster()->query("DELETE FROM ".TABLE_O_ORDER_GOODS." WHERE "
            ." orderid='".$data['orderid']."' AND shop_id='".$data['shop_id']."'");
        //删除店铺产品
        if($order_count['count']<=1)
        {
            $res2 = $this->GetDBMaster()->query("DELETE FROM ".TABLE_O_ORDER." "
                ." WHERE orderid='".$data['orderid']."'");
        }else{
            $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER." SET "
                ." total_money=IF(total_money>='".$data['total_money']."',"
                ." total_money-'".$data['total_money']."',0),"
                ." pro_count=IF(pro_count>='".$data['pro_count']."',"
                ." pro_count-'".$data['pro_count']."',0),".
                "  shop_count=shop_count-1,"
                ." freight_money=IF(freight_money>='".$data['pro_fee']."',".
                "  freight_money-'".$data['pro_fee']."',0) "
                ." WHERE orderid='".$data['orderid']."'");
        }
        if($res && $res1 && $res2)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'已取消');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'取消失败');
    }


    function ActionConfirmGetPro()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $order = $this->GetShopOrder($this->data['id'],'id');
        if(!$order)
        {
            return array('code'=>1,'msg'=>'未找到此订单');
        }elseif ($order['order_status']!=4)
        {
            return array('code'=>1,'msg'=>'订单状态错误');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET order_status=6,"
            ." goods_confirm='".date("Y-md H:i:s",time())."'"
            ." WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'确认成功');
        }
        return array('code'=>1,'msg'=>'确认失败');
    }


    function ActionAddRefundApply()
    {
        if(!regExp::checkNULL($this->data['goods_id']) ||
            !regExp::is_positive_number($this->data['goods_id']))
        {
            return array('code'=>1,'msg'=>'missing parameter');
        }
        //验证退款状态
        $data = $this->GetRefundOrderGoods();
        if($data['code'])
        {
            return $data;
        }elseif($data['data']['goods_refund'])
        {
            return array('code'=>1,'msg'=>'退款申请已经提交');
        }elseif($data['data']['order_status']<3)
        {
            return array('code'=>1,'msg'=>'订单未完成支付 无法申请售后');
        }elseif($data['data']['order_status']>=6 && //已确认收货并且收货距今超过1周
            strtotime($data['data']['goods_confirm']) + strtotime("+1 week")>time())
        {
            return array('code'=>1,'msg'=>'已超过售后时间');
        }
        //检查提交参数
        if(!regExp::checkNULL($this->data['refund_type_id']) ||
            !regExp::is_positive_number($this->data['refund_type_id']))
        {
            return array('code'=>1,'msg'=>'请选择退款原因');
        }
        if(!regExp::checkNULL($this->data['refund_cause']) ||
            !regExp::is_positive_number($this->data['refund_cause']))
        {
            return array('code'=>1,'msg'=>'请选择退款原因');
        }
        if(!regExp::checkNULL($this->data['refund_money']) ||
            $this->data['refund_money']<=0)
        {
            return array('code'=>1,'msg'=>'金额输入错误');
        }elseif(trim($this->data['refund_money'])>trim($data['data']['actual_refund']))
        {
            return array('code'=>1,'msg'=>'金额超出允许范围');
        }
        //退款类型
        $refund_cause = $this->GetDBSlave1()->queryrow("SELECT RC.*,RCY.title FROM ".TABLE_REFUND_CAUSE." "
            ." AS RC INNER JOIN ".TABLE_REFUND_CAUSE_TYPE." AS RCY ON RC.type_id=RCY.type_id WHERE "
            ." RC.id='".$this->data['refund_cause']."' AND RC.type_id='".$this->data['refund_type_id']."'");
        if(empty($refund_cause))
        {
            return array('code'=>1,'msg'=>'退款原因不存在或已删除');
        }
        if($this->data['refund_type_id']==1 && $data['data']['order_status']!=3)
        {
            return array('code'=>1,'msg'=>'订单状态已更新 请重新退款');
        }
        $refund_remark = $this->data['refund_remark']?trim($this->data['refund_remark']):'';
        //上传了附件
        $refund_certificates_arr = array();
        if(isset($this->data['refund_certificates_img']) && is_array($this->data['refund_certificates_img'])
            && sizeof($this->data['refund_certificates_img'])>0)
        {
            $refund_certificates_img = array_filter($this->data['refund_certificates_img']);
            for($i=0;$i<sizeof($refund_certificates_img);$i++)
            {
                $res = $this->LocalSaveFile($refund_certificates_img[$i]);
                if($res['code']==0)
                {
                    $refund_certificates_arr[] = $res['file'];
                }
            }
        }
        if($refund_certificates_arr)
        {
            $refund_certificates_arr = json_encode($refund_certificates_arr);
        }else{
            $refund_certificates_arr = '';
        }
        $this->GetDBMaster()->StartTransaction();
        //更新产品退款状态
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_GOODS." SET "
            ."goods_refund=1 WHERE id='".$data['data']['id']."'");
        //更新
        if(!$data['data']['refund_status'])
        {
            $order_refund = $data['data']['product_sum_price'];
        }else{
            $order_refund = $data['data']['refund_money'] + $data['data']['product_sum_price'];
        }
        //获取退款支付单号
        if($data['data']['is_all_pay']==1)
        {
            $refund_order = $data['data']['orderid'];
        }else{
            $refund_order = $data['data']['orderid'].'_'.$data['data']['orderid'];
        }
        $refund_number = date('ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET "
            ." refund_status=1,refund_money='".$order_refund."' WHERE "
            ." orderid='".$data['data']['orderid']."' AND shop_id='".$data['data']['shop_id']."' ");
        if($data['data']['is_all_pay']==1)
        {
            $refund_max_money = $data['data']['all_pay_money'];
        }else{
            $refund_max_money = $data['data']['shop_pay_money'];
        }
        //写入退款申请
        $res2 = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_REFUND_APPLY." "
            ."(goods_id,refund_cause,refund_money,refund_remark,refund_trans_orderid,"
            ."refund_status,refund_order_type,refund_goods_money,refund_goods_count,"
            ."refund_userid,refund_certificates_img,refund_product_name,refund_product_img,"
            ."refund_product_attr,refund_order_pay_method,refund_order_store_id,refund_type_name,"
            ."refund_type_id,refund_number,apply_date,refund_orderid,refund_max_money,refund_trans_money)"
            ." VALUES('".$data['data']['id']."','".$refund_cause['refund_title']."',"
            ."'".$this->data['refund_money']."','".$refund_remark."','".$refund_order."',"
            ."0,'".$data['data']['order_type']."','".$data['data']['product_sum_price']."',"
            ."'".$data['data']['product_count']."','".$data['data']['userid']."',"
            ."'".$refund_certificates_arr."','".$data['data']['product_name']."',"
            ."'".$data['data']['product_img']."','".$data['data']['product_attr_name']."',"
            ."'".$data['data']['pay_method']."','".$data['data']['shop_id']."',"
            ."'".$refund_cause['title']."','".$this->data['refund_type_id']."','".$refund_number."',"
            ."'".date("Y-m-d H:i:s",time())."','".$data['data']['orderid']."',"
            ."'".$data['data']['actual_refund']."','".$refund_max_money."') ");
        if($res && $res1 && $res2)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'query ok','id'=>$res2);
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'申请失败');
    }


    //取消退款申请
    function ActionQXRefundApply()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'撤销失败');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_REFUND_APPLY." WHERE "
            ." id='".$this->data['id']."' AND refund_is_valid=0 AND refund_userid='".SYS_USERID."'");
        if(!$data)
        {
            return array('code'=>1,'msg'=>'退款不存在或未通过退款');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND_APPLY." SET "
            ." refund_confirm_date='".date("Y-m-d H:i:s",time())."',"
            ." refund_status=1 WHERE id='".$this->data['id']."'");
        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_GOODS." SET "
            ." goods_refund=5 WHERE id='".$data['goods_id']."'");
        //如果有影响行数
        if($res)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'退款申请撤销成功');
        }else{
            $this->GetDBMaster()->RollbackTransaction();
            return array('code'=>1,'msg'=>'退款状态已更新');
        }
    }


    //编辑退款内容
    function ActionEditRefundApply()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'error');
        }
        $data = $this->GetRefundApplyInfo($this->data['id']);
        if(!$data)
        {
            return array('code'=>1,'msg'=>'数据不存在或已删除');
        }elseif(0!=$data['refund_is_valid'])
        {
            return array('code'=>1,'msg'=>'退款已失效');
        }elseif(null!=$data['refund_upd_date'])
        {
            return array('code'=>1,'msg'=>'已经修改过了');
        }elseif($data['refund_status'])
        {
            return array('code'=>1,'msg'=>'退款申请已处理或无法编辑');
        }
        if($data['refund_type_id']==2 && !regExp::checkNULL($this->data['refund_money']))
        {
            return array('code'=>1,'msg'=>'请输入退款金额');
        }
        if($data['refund_type_id']==2)
        {
            $refund_money = $this->data['refund_money'];
        }else{
            $refund_money = $data['refund_money'];
        }
        if($refund_money>$data['refund_max_money'])
        {
            return array('code'=>1,'msg'=>'超过最大可以金额');
        }
        $refund_certificates_img = array();
        $refund_remark = isset($this->data['refund_remark']) && !empty($this->data['refund_remark']) ?trim($this->data['refund_remark']) :'';
        if(isset($this->data['refund_certificates_img']) && is_array($this->data['refund_certificates_img'])
            && sizeof($this->data['refund_certificates_img'])>0)
        {
            $refund_certificates_img_arr = $this->data['refund_certificates_img'];
            for($i=0;$i<count($refund_certificates_img_arr);$i++)
            {
                if(count(explode('.',$refund_certificates_img_arr[$i]))>1)
                {
                    $refund_certificates_img[] = $refund_certificates_img_arr[$i];
                }else{
                    $res = $this->LocalSaveFile($refund_certificates_img_arr[$i]);
                    if($res['code']==0)
                    {
                        $refund_certificates_img[] = $res['file'];
                    }
                }
            }
        }
        if($refund_certificates_img && count($refund_certificates_img)>0)
        {
            $refund_certificates_img = json_encode($refund_certificates_img);
        }else{
            $refund_certificates_img = '';
        }
        //refund_cause
        $refund_cause = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_REFUND_CAUSE." WHERE "
            ." id='".$this->data['refund_cause']."'");
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND_APPLY." SET "
            ." refund_cause='".$refund_cause['refund_title']."',"
            ." refund_money='".$refund_money."',"
            ." refund_remark='".$refund_remark."',"
            ." refund_certificates_img='".$refund_certificates_img."',"
            ." refund_upd_date='".date("Y-m-d H:i:s",time())."' WHERE "
            ." id='".$data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'ok');
        }
        return array('code'=>1,'msg'=>'修改失败');
    }

    function ActionRefundWuliu()
    {
       if(!regExp::checkNULL($this->data['id']))
       {
            return array('code'=>1,'msg'=>'参数错误');
       }
       $data = $this->GetRefundApplyInfo($this->data['id']);
        if(!$data)
        {
            return array('code'=>1,'msg'=>'数据不存在');
        }elseif($data['refund_is_valid'])
        {
            return array('code'=>1,'msg'=>'已失效');
        }elseif($data['refund_type_id']!=2 || $data['refund_status']!=3)
        {
            return array('code'=>1,'msg'=>'数据已提交或订单已更新');
        }
        if(!regExp::checkNULL($this->data['refund_logistics_id']))
        {
            return array('code'=>1,'msg'=>'缺少物流参数');
        }
        if(!regExp::checkNULL($this->data['refund_logistics_number']))
        {
            return array('code'=>1,'msg'=>'缺少物流单号');
        }
        $sel_logistics = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_LOGISTICS." WHERE "
            ." logistics_id='".$this->data['refund_logistics_id']."'");
        if(!$sel_logistics)
        {
            return array('code'=>1,'msg'=>'所选物流无效或已删除');
        }
        if(strlen($this->data['refund_logistics_number'])<10 ||
            strlen($this->data['refund_logistics_number'])>20)
        {
            return array('code'=>1,'msg'=>'物流单号格式错误');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND_APPLY." SET "
            ." refund_status=4,refund_logistics_name='".$sel_logistics['logistics_name']."',"
            ." refund_logistics_number='".$this->data['refund_logistics_number']."', "
            ." refund_logistics_addtime='".date("Y-m-d H:i:s",time())."' "
            ." WHERE id='".$data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'OK');
        }
        return array('code'=>1,'msg'=>'提交失败 请重新提交');
    }


    function ActionCopyOrderToCart()
    {
        if(!regExp::checkNULL($this->data['product_id']
            || !is_array($this->data['product_id']))
            || count($this->data['product_id'])<=0)
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        require_once RPC_DIR.'/module/mobile/weixin/product.php';
        require_once 'ProductAction.php';
        $ProductAction = new ProductAction($this->data);
        $this->GetDBMaster()->StartTransaction();
        foreach($this->data['product_id'] as $k=>$v)
        {
            if(!isset($this->data['quantity'][$v]) || empty($this->data['quantity'][$v]))
            {
                redirect(NOFOUND.'&msg=数量错误');
            }
            $param = array(
                'id'=>$v,
                'product_count'=>$this->data['quantity'][$v],
                'attr_id'=>$this->data['attr_id'][$v]
            );
            $res = $ProductAction->ActionAddCart($param);
            if($res['code'])
            {
                $this->GetDBMaster()->RollbackTransaction();
                redirect(NOFOUND.'&msg='.$res['msg']);
            }
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_CART." SET "
            ." select_status=0 WHERE product_id NOT IN(".implode(',',$this->data['product_id']).") "
            ." AND userid='".SYS_USERID."'");
        $this->GetDBMaster()->SubmitTransaction();
        redirect('?mod=weixin&v_mod=checkout');
    }



    //取消售后订单
    function ActionCancelServiceOrder()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'err');
        }
        $goods = $this->GetDBSlave1()->queryrow("SELECT OG.*,OS.order_status FROM ".TABLE_O_ORDER_GOODS." "
            ."AS OG INNER JOIN ".TABLE_O_ORDER_SHOP." AS OS ON OG.orderid=OG.orderid AND "
            ."OG.shop_id=OS.shop_id AND OS.userid='".SYS_USERID."' "
            ."WHERE OG.id='".$this->data['id']."' AND OG.is_del=0");
        if(!$goods)
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }elseif($goods['goods_refund']!=3)
        {
            return array('code'=>1,'msg'=>'状态错误');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_GOODS." SET is_del=1 "
            ." WHERE id='".$this->data['id']."'");
        if($goods['order_status']==-1)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET is_del=1 WHERE "
                ." orderid='".$goods['orderid']."' AND shop_id='".$goods['shop_id']."'");
        }
        if($res)
        {
            return array('code'=>0,'msg'=>'已取消');
        }
        return array('code'=>0,'msg'=>'取消失败');
    }
}