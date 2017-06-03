<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class PointAction extends point
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //添加礼品
    function ActionSubmitCart()
    {
        die(json_encode($this->SubmitCart()));
    }

    private function SubmitCart()
    {
        $this->data['qty']=intval($this->data['qty']);
        if (regExp::is_positive_number($this->data['id']) &&
            $this->data['qty']>0)
        {
            //购物车总计
            $need_point=$cart_qty=0;
            $cart=$this->GetCartTotal();
            if (!empty($cart['total']))
            {
                $need_point+=$cart['total'];
            }
            if (!empty($cart['count']))
            {
                $cart_qty+=$cart['count'];
            }
            $user=$this->GetUserInfo(SYS_USERID);
            $data=$this->GetPointProductDetail();
            $need_point+=$this->data['qty']*$data['gift_point'];
            $cart_qty+=$this->data['qty'];
            if ($need_point>$user['user_point'])
            {
                return array("code"=>1,"msg"=>"积分不够");
            }
            $cart_product=$this->GetProductDetail($this->data['id']);
            if (!empty($cart_product))
            {
                //更新数量
                $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_CART." "
                    ." SET cart_qty=cart_qty+".$this->data['qty'].""
                    ." WHERE userid='".SYS_USERID."' "
                    ." AND gift_id='".$this->data['id']."'");
            }else
            {
                //插入消息
                $this->GetDBMaster()->query("INSERT INTO ".TABLE_GIFT_CART." "
                    ." (cart_qty,userid,gift_id,addtime)VALUES(".$this->data['qty'].","
                    ."'".SYS_USERID."','".$this->data['id']."','".date("Y-m-d H:i:s")."')");
            }
            return array("code"=>0,"msg"=>"加入购物车成功","cart_qty"=>$cart_qty);
        }
        return array("code"=>1,"msg"=>"参数错误");
    }

    //操作选择状态
    function ActionSelectStatus()
    {
        if ($this->data['type_id']==0)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_CART." "
                ." SET select_status=1"
                ." WHERE userid='".SYS_USERID."'");
        }elseif($this->data['type_id']==1)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_CART." "
                ." SET select_status=0"
                ." WHERE userid='".SYS_USERID."'");

        }elseif($this->data['type_id']==2)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_CART." "
                ." SET select_status=0"
                ." WHERE userid='".SYS_USERID."' "
                ." AND gift_id='".$this->data['gift_id']."'");
        }elseif($this->data['type_id']==3)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_CART." "
                ." SET select_status=1"
                ." WHERE userid='".SYS_USERID."' "
                ." AND gift_id='".$this->data['gift_id']."'");
        }
        $cart=$this->GetCartTotal(1);
        return die(json_encode(array("code"=>0,"msg"=>"操作成功",
            "count"=>$cart['count']?$cart['count']:0,
            "point"=>$cart['total']?$cart['total']:0)));
    }


    //更新积分的数量
    function ActionUpdateCartQty()
    {
        die(json_encode($this->UpdateCartQty()));
    }
    private function UpdateCartQty()
    {
        $this->data['qty']=intval($this->data['qty']);
        if (regExp::is_positive_number($this->data['id']) &&
            $this->data['qty']>0)
        {
            //购物车总计
            $need_point=$cart_qty=0;
            $cart=$this->GetCartTotal();
            if (!empty($cart['total']))
            {
                $need_point+=$cart['total'];
            }
            if (!empty($cart['count']))
            {
                $cart_qty+=$cart['count'];
            }
            $user=$this->GetUserInfo(SYS_USERID);
            $data=$this->GetPointProductDetail();
            $thecart=$this->GetProductDetail($this->data['id']);
            $need_point=$need_point-($thecart['cart_qty']*$data['gift_point']);
            $need_point+=$this->data['qty']*$data['gift_point'];
            if ($this->data['type_id']==1)
            {
                if ($need_point>$user['user_point'])
                {
                    return array("code"=>1,"msg"=>"积分不够");
                }
                //更新数量
                $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_CART." "
                    ." SET cart_qty=".$this->data['qty'].""
                    ." WHERE userid='".SYS_USERID."' "
                    ." AND gift_id='".$this->data['id']."'");
            }else
            {
                //更新数量
                $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_CART." "
                    ." SET cart_qty=".$this->data['qty'].""
                    ." WHERE userid='".SYS_USERID."' "
                    ." AND gift_id='".$this->data['id']."'");
            }
            $cart=$this->GetCartTotal(1);
            return die(json_encode(array("code"=>0,"msg"=>"操作成功",
                "count"=>$cart['count']?$cart['count']:0,
                "point"=>$cart['total']?$cart['total']:0)));
        }
        return array("code"=>1,"msg"=>"参数错误");
    }


    function ActionDelPointCart()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'error');
        }
        $gift_cart = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GIFT_CART." WHERE "
            ." gift_id='".$this->data['id']."' AND userid='".SYS_USERID."'");
        if(!$gift_cart)
        {
            return array('code'=>1,'msg'=>'购物车不存在此礼品');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_GIFT_CART." WHERE "
            ." gift_id='".$this->data['id']."'");
        $cart=$this->GetCartTotal();
        if($res)
        {
            return array(
                'code'=>0,'msg'=>'操作成功',
                'count'=>$cart['count']?$cart['count']:0,
                'point'=>$cart['total']?$cart['total']:0
            );
        }
        return array(
            'code'=>1,'msg'=>'操作失败',
            'count'=>$cart['count']?$cart['count']:0,
            'point'=>$cart['total']?$cart['total']:0
        );
    }

    function ActionCheckPoint()
    {
        die(json_encode($this->CheckPoint()));
    }

    //检测是否积分足够
    function CheckPoint()
    {
        $total=$this->GetCartTotal(1);
        if (empty($total['count']))
        {
            return array("code"=>1,"msg"=>"购物车内无礼品");
        }
        $user=$this->GetUserInfo(SYS_USERID);
        if ($user['user_point']<$total['total'])
        {
            return array("code"=>1,"msg"=>"积分不足");
        }
        return array("code"=>0,"msg"=>"积分检验成功","data"=>$total);
    }

    //提交结算礼品
    function ActionSubmitGift()
    {
        $check=$this->CheckPoint();
        if ($check['code']==1)
        {
            redirect(NOFOUND.'&msg='.$check['msg']);
        }
        $cart=$this->GetCart(1);
        if(empty($cart))
        {
            redirect(NOFOUND.'&msg=购物车没有数据');
        }
        $order_img = $cart['data'][0]['gift_img'];
        //地址
        if(!regExp::checkNULL($this->data['address_id']))
        {
            return array('code'=>1,'msg'=>'请选择地址');
        }
        $address = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SHIP_ADDRESS."  "
            ." WHERE id='".$this->data['address_id']."' AND userid='".SYS_USERID."'");
        if(empty($address))
        {
            return array('code'=>1,'msg'=>'地址信息错误');
        }//地址end
        $this->GetDBMaster()->StartTransaction();
        try
        {
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GIFT_ORDER." "
                ."(userid,total_qty,total_point,addtime,liuyan,address,gift_img,phone,username)"
                ." VALUES('".SYS_USERID."',"
                ."'".$check['data']['count']."',"
                ."'".$check['data']['total']."',"
                ."'".date("Y-m-d H:i:s")."',"
                ."'".addslashes($this->data['liuyan'])."',"
                ."'".$address['address_location'].$address['address_details']."',"
                ."'".$order_img."','".$address['shop_phone']."','".$address['shop_name']."')");
            if(!$id)
            {
                throw new Exception('提交失败');
            }
            foreach ($cart['data'] as $item)
            {
                if($item['cart_qty']>($item['qty']-$item['sale']))
                {
                    throw new Exception($item['gift_name'].'库存不足 剩下'.$item['qty']-$item['sale']);
                }
                $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_PRODUCT." "
                    ." SET sale=sale+".$item['cart_qty']." "
                    ." WHERE id='".$item['gift_id']."'");
                if(!$res2)
                {
                    throw new Exception('更新销量失败');
                }
                $res3 = $this->GetDBMaster()->query("INSERT INTO ".TABLE_GIFT_ORDER_DETAIL." "
                    ." (orderid,gift_point,gift_id,gift_img,gift_name,qty,userid,addtime,hx_code)"
                    ." VALUES('".$id."','".$item['gift_point']."',"
                    ."'".$item['gift_id']."',"
                    ."'".$item['gift_img']."',"
                    ."'".addslashes($item['gift_name'])."',"
                    ."'".$item['cart_qty']."',"
                    ."'".SYS_USERID."',"
                    ."'".date("Y-m-d H:i:s")."','".sha1($id.'_'.$item['gift_id'].'_'.SYS_USERID)."')");
                if(!$res3)
                {
                    throw new Exception('积分详情提交失败');
                }
            }
            $res4 = $this->UsePoint(7,$check['data']['total'],$id);
            if(!$res4)
            {
                throw new Exception('积分扣除失败');
            }
            $res5 = $this->EmptyCart();
            if(!$res5)
            {
                throw new Exception('购物车清空失败');
            }
            //没问题提交
            $this->GetDBMaster()->SubmitTransaction();
            redirect('?mod=weixin&v_mod=point&_index=_checkout_result&id='.$id);
        }catch (Exception $e)
        {
            //回滚并提示错误原因
            $this->GetDBMaster()->RollbackTransaction();
            redirect(NOFOUND.'&msg='.$e->getMessage());
        }
    }


    //扣积分操作type_id 费用类型id ,
    private function UsePoint($type_id=0,$point=0,$orderid=0)
    {
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
            ." SET user_point=user_point-".$point.""
            ." WHERE userid='".SYS_USERID."'");
        //插入积分消费日记表
        $this->AddPointLog($type_id,-$point,SYS_USERID,$orderid);
        if($res)
        {
            return true;
        }
        return false;
    }

    //清空礼品购物车
    private function EmptyCart()
    {
        return $this->GetDBMaster()->query("DELETE FROM ".TABLE_GIFT_CART." "
            ." WHERE userid='".SYS_USERID."'");
    }

}