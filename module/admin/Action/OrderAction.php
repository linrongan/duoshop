<?php
class OrderAction extends order
{
    function __construct($data)
    {
        $this->data = $data;
    }

    //删除订单
    function ActionDelOrder()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT id FROM ".TABLE_O_ORDER_SHOP." "
            ." WHERE orderid='".$this->data['orderid']."' AND shop_id='".$_SESSION['admin_store_id']."' "
            ." AND is_del=0");
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'订单不存在');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET is_del=1 "
            ." WHERE orderid='".$this->data['orderid']."'"
            ." AND shop_id='".$_SESSION['admin_store_id']."'");

        if($res)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'订单已删除');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'订单已删除失败');
    }


    //批量删除订单
    function ActionMoreDelOrder()
    {
        if(!regExp::checkNULL($this->data['orderid']) || !is_array($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $select_id = array_filter($this->data['orderid']);
        $count = count($select_id);
        $where = '';
        for ($i=0;$i<$count;$i++)
        {
            $where .= $select_id[$i].',';
        }
        $where = rtrim($where,',');
        $check_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ORDER." WHERE "
            ." orderid IN (".$where.") AND store_id='".$_SESSION['admin_store_id']."' AND is_del=0");
        if($check_count['total']<$count)
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET is_del=1 WHERE "
            ." orderid IN(".$where.") AND store_id='".$_SESSION['admin_store_id']."'");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_DETAIL." SET is_del=1 "
            ." WHERE orderid IN(".$where.") ");
        if($res && $res2)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'删除成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'删除失败');
    }


    //批量更改订单状态
    function ActionMoreChangeOrderStatus()
    {
        $Sys_Order_Status =array(-1=>"已退款",0=>"已取消",1=>"未付款",2=>"处理中",3=>"已支付",4=>'已发货',5=>'已收货',6=>'待评价',7=>'已评价',8=>"已完成");
        if(!regExp::checkNULL($this->data['orderid']) || !is_array($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!isset($this->data['order_status']) || $this->data['order_status']=='' || !array_key_exists($this->data['order_status'],$Sys_Order_Status))
        {
            return array('code'=>1,'msg'=>'请选择订单状态');
        }
        $select_id = array_filter($this->data['orderid']);
        $count = count($select_id);
        $where = '';
        for ($i=0;$i<$count;$i++)
        {
            $where .= $select_id[$i].',';
        }
        $where = rtrim($where,',');
        $check_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ORDER." WHERE "
            ." orderid IN (".$where.") AND store_id='".$_SESSION['admin_store_id']."' AND is_del=0");
        if($check_count['total']<$count)
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET order_status='".$this->data['order_status']."' "
            ." WHERE orderid IN (".$where.") AND store_id='".$_SESSION['admin_store_id']."' AND is_del=0");
        return array('code'=>0,'msg'=>'更改成功','status'=>$Sys_Order_Status[$this->data['order_status']]);
    }


    //更改订单状态
    function ActionChangeOrderStatus()
    {
        $Sys_Order_Status =array(-1=>"已退款",0=>"已取消",1=>"未付款",2=>"处理中",3=>"已支付",4=>'已发货',5=>'已收货',6=>'待评价',7=>'已评价',8=>"已完成");
        if(!regExp::checkNULL($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!isset($this->data['order_status']) || $this->data['order_status']=='' || !array_key_exists($this->data['order_status'],$Sys_Order_Status))
        {
            return array('code'=>1,'msg'=>'请选择订单状态');
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER_SHOP." WHERE "
            ." orderid ='".$this->data['orderid']."' AND shop_id='".$_SESSION['admin_store_id']."' AND is_del=0");
        if(empty($order))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET order_status='".$this->data['order_status']."' "
            ." WHERE orderid='".$this->data['orderid']."'");
        if($order['order_status']<3 && $this->data['order_status']==3)
        {
            $res = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ORDER." WHERE order_id='".$this->data['orderid']."'");
            if(!$res['allow_pay'])
            {
                $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER." SET allow_pay=1 WHERE "
                    ." order_id='".$this->data['orderid']."'");
            }
        }
        if($row)
        {
            return array('code'=>0,'msg'=>'订单状态更新成功');
        }
        return array('code'=>1,'msg'=>'订单状态更新失败');
    }

    function ActionChangeLogistics()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT order_status FROM ".TABLE_O_ORDER_SHOP." WHERE "
            ." orderid ='".$this->data['orderid']."' AND shop_id='".$_SESSION['admin_store_id']."' AND "
            ." is_del=0");
        if($order['order_status']<3)
        {
            return array('code'=>1,'msg'=>'订单还未支付');
        }
        if(!regExp::checkNULL($this->data['logistics_name']))
        {
            return array('code'=>1,'msg'=>'请输入物流公司');
        }
        if(!regExp::checkNULL($this->data['logistics_number']))
        {
            return array('code'=>1,'msg'=>'请输入物流单号');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET logistics_name='".$this->data['logistics_name']."',"
            ."logistics_number='".$this->data['logistics_number']."' WHERE orderid='".$this->data['orderid']."'");
        return array('code'=>0,'msg'=>'物流已更新');
    }


    function ActionDelComment()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_COMMENT." WHERE "
            ." id='".$this->data['id']."'");
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'数据不存在或已删除');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_PRODUCT_COMMENT." WHERE "
            ." id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }
}