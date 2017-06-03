<?php
class CartAction extends cart
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    /*
     * 更改购物车状态  店铺
     * */
    function ActionChangeShopSelStatus()
    {
        if(!isset($this->data['store_id']) || !is_numeric($this->data['store_id']))
        {
            return array('code'=>1,'msg'=>'店铺参数错误');
        }
        $status_array = array(0,1);
        if(!isset($this->data['status']) || !in_array($this->data['status'],$status_array))
        {
            return array('code'=>1,'msg'=>'缺少关键参数');
        }
        $shop = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS nums FROM ".TABLE_CART." WHERE "
            ." userid='".SYS_USERID."' AND store_id='".$this->data['store_id']."'");
        if($shop['nums']<0)
        {
            return array('code'=>1,'msg'=>'店铺参数错误');
        }
        $status = $this->data['status']?0:1;
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." SET select_status='".$status."',"
            ." update_date='".time()."' WHERE userid='".SYS_USERID."' "
            ." AND store_id='".$this->data['store_id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'success');
        }
        return array('code'=>1,'msg'=>'更改失败');
    }


    /*
     * 更改购物车状态  产品
     * */
    function ActionChangeProSelStatus()
    {
        if(!isset($this->data['cart_id']) || !is_numeric($this->data['cart_id']))
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        $cart = $this->GetOneCart($this->data['cart_id']);
        if(empty($cart))
        {
            return array('code'=>1,'msg'=>'购物车产品不存在');
        }
        if($cart['select_status'])
        {
            $select_status = 0;
        }else{
            $select_status = 1;
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." SET select_status='".$select_status."', "
            ." update_date='".time()."' WHERE id='".$this->data['cart_id']."' AND userid='".SYS_USERID."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'success');
        }
        return array('code'=>1,'msg'=>'更改失败');
    }


    /*
     * 购物车产品全部更改状态
     * */
    function ActionChangeALLSelStatus()
    {
        if(!regExp::checkNULL($this->data['status']))
        {
            return array('code'=>1,'msg'=>'error');
        }
        if($this->data['status']==1)
        {
            $select_status = 0;
        }elseif($this->data['status']==2)
        {
            $select_status = 1;
        }else{
            return array('code'=>1,'msg'=>'error');
        }
        $res  = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." SET select_status=".$select_status.", "
            ."update_date='".time()."' WHERE userid='".SYS_USERID."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'success');
        }
        return array('code'=>1,'msg'=>'更改失败');
    }

    /*
     * 编辑购物车产品数量
     * */
    function ActionEditCartProCount()
    {
        if(!regExp::checkNULL($this->data['cart_id']))
        {
            return array('code'=>1,'msg'=>'购物车参数错误');
        }
        if(!regExp::checkNULL($this->data['quantity']) || !regExp::is_positive_number($this->data['quantity']))
        {
            return array('code'=>1,'msg'=>'购物车数量错误');
        }
        $cart = $this->GetOneCart($this->data['cart_id']);
        if(empty($cart))
        {
            return array('code'=>1,'msg'=>'购物车数据不存在');
        }

        if ((!empty($cart['bargain_price']) || !empty($cart['seckill_price'])) && $cart['product_count']<=$this->data['quantity'])
        {
            return array('code'=>1,'msg'=>'该类型商品只能购买一件');
        }
        if($this->data['quantity']==$cart['product_count'])
        {
            return array('code'=>1,'msg'=>'修改失败');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." "
            ." SET product_count='".$this->data['quantity']."',"
            ." update_date='".time()."' "
            ." WHERE userid='".SYS_USERID."' "
            ." AND id='".$this->data['cart_id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'数量修改成功');
        }
        return array('code'=>1,'msg'=>'数量修改失败');
    }


    /*
     * 删除购物车产品
     * */
    function ActionDelCart()
    {
        if(!regExp::checkNULL($this->data['cart_id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $cart = $this->GetOneCart($this->data['cart_id']);
        if(empty($cart))
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_CART." WHERE id='".$this->data['cart_id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }
}