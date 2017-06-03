<?php
class ProductAction extends product
{
    function __construct($data)
    {
        $this->data = $data;
    }

    function ActionGetSearch()
    {
        redirect('/?mod=weixin&v_mod=product&search='.$this->data['search']);
    }

    function ActionProductColle()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        $product = $this->GetOneProduct($this->data['id']);
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品参数错误');
        }
        $data = $this->GetProductColle($this->data['id']);
        if($data)
        {
            $this->GetDBMaster()->StartTransaction();
            $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_PRODUCT_COLLE." WHERE id='".$data['id']."'");
            $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
                ." collect_count=IF(collect_count>0,collect_count-1,0),last_update='".time()."' "
                ." WHERE product_id='".$this->data['id']."'");
            $msg = '取消收藏';
            $status = 2;
            if($res && $res1)
            {
                $this->GetDBMaster()->SubmitTransaction();
                return array('code'=>0,'msg'=>$msg.'成功','status'=>$status);
            }else{
                $this->GetDBMaster()->RollbackTransaction();
                return array('code'=>1,'msg'>$msg.'失败');
            }
        }else{
            $this->GetDBMaster()->StartTransaction();
            $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PRODUCT_COLLE." SET "
                ."userid='".SYS_USERID."',product_id='".$this->data['id']."',"
                ."store_id='".$product['store_id']."'");
            $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET ".
                " collect_count=collect_count+1,last_update='".time()."' "
                ." WHERE product_id='".$this->data['id']."'");
            $msg = '收藏';
            $status = 1;
            if($res && $res1)
            {
                $this->GetDBMaster()->SubmitTransaction();
                return array('code'=>0,'msg'=>$msg.'成功','status'=>$status);
            }else{
                $this->GetDBMaster()->RollbackTransaction();
                return array('code'=>1,'msg'>$msg.'失败');
            }
        }
    }

    //添加到购物车
    function ActionAddCart($array=null)
    {
        if($array)
        {
            $this->data['id'] = $array['id'];
            $this->data['product_count'] = $array['product_count'];
            $this->data['attr_id'] = $array['attr_id'];
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品错误');
        }
        if(!regExp::checkNULL($this->data['product_count']) ||
            !regExp::is_positive_number($this->data['product_count']))
        {
            return array('code'=>1,'msg'=>'数量不正确');
        }
        $date=date("Y-m-d H:i:s");
        $product = $this->GetDBSlave1()->queryrow("SELECT P.*,SP.seckill_price,BA.min_price AS bargain_price,SP.seckill_price FROM ".TABLE_PRODUCT." AS P"
            ." LEFT JOIN ".TABLE_SEKILL_PRODUCT." AS SP ON SP.product_id=P.product_id AND SP.start_time<'".$date."' AND SP.end_time>'".$date."' AND SP.seckill_status=0 AND SP.seckill_stock>0 AND SP.seckill_stock>SP.seckill_buy_stock"
            ." LEFT JOIN ".TABLE_GAMES_BARGAIN_CREATE." AS BA ON BA.product_id=P.product_id AND BA.userid='".SYS_USERID."' AND BA.reach_status=1 AND BA.over_status=0"
            ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON P.store_id=S.store_id   "
            ." WHERE P.product_id='".$this->data['id']."' LIMIT 0,1");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        elseif($product['product_status']!=0)
        {
            return array('code'=>1,'msg'=>'产品已下架');
        }
        if ($product['business_buy'])
        {
            //商家专享权限判断
            $user=$this->GetUserWxDetail(SYS_USERID);
            if ($user['vip_lv']<$product['business_buy'])
            {
                return array('code'=>1,'msg'=>'该商品为商家专享，您暂无购买权限,请与客服联系');
            }
        }
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR."  "
            ." WHERE product_id='".$this->data['id']."' AND is_del=0");
        $attr_id = $attr_name=array();
        if($attr)
        {
            if(!regExp::checkNULL($this->data['attr_id']))
            {
                return array('code'=>1,'msg'=>'请选择产品属性');
            }
            $attr_id_array = $attr_val_array=array();
            foreach($attr as $item)
            {
                $attr_id_array[] = $item['id'];
                $attr_val_array[$item['id']] = $item['attr_temp_name'];
            }
            foreach($this->data['attr_id'] as $k=>$val)
            {
                if(!in_array($val,$attr_id_array))
                {
                    return array('code'=>1,'msg'=>'产品属性'.$attr_val_array[$k].'已下架');
                }
                $attr_id[]= $val;
                $attr_name[]=addslashes($attr_val_array[$val]);
            }
        }
        $cart = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CART." "
            ." WHERE product_id='".$this->data['id']."' "
            ." AND userid='".SYS_USERID."' "
            ." AND attr_id='".implode(',',$attr_id)."'");
        $product_count = $this->data['product_count']?$this->data['product_count']:1;
        if($cart)
        {
            if (!empty($product['bargain_price']) || !empty($product['seckill_price']))
            {
                return array('code'=>1,'msg'=>'该类型商品只能购买一件');
            }
            $count = $cart['product_count']+$product_count;
            $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." "
                ." SET product_count='".$count."' "
                ." WHERE product_id='".$this->data['id']."' "
                ." AND userid='".SYS_USERID."' "
                ." AND attr_id='".implode(',',$attr_id)."'");
        }else
        {
            $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_CART." "
                ." SET userid='".SYS_USERID."',"
                ." product_id='".$this->data['id']."',"
                ." attr_id='".implode(',',$attr_id)."',"
                ." attr_name='".implode(',',$attr_name)."',"
                ." product_count='".$product_count."',"
                ." select_status=1,"
                ." update_date='".date("Y-m-d H:i:s",time())."',"
                ." store_id='".$product['store_id']."'");
        }
        if($res)
        {
            //直接购买
            if (isset($this->data['method']) && $this->data['method']<>'cart')
            {
                $this->GetDBMaster()->query("UPDATE ".TABLE_CART." "
                    ." SET select_status=0 "
                    ." WHERE userid='".SYS_USERID."' "
                    ." AND product_id!=".$this->data['id']."");
            }
            return array('code'=>0,'msg'=>'已成功加入购物车');
        }
        return array('code'=>1,'msg'=>'加入购物车失败');
    }



    //获取属性相关的信息
    function ActionGetNewAttrData()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR."  "
            ." WHERE id='".$this->data['id']."' "
            ." AND is_del=0");
        if (empty($data))
        {
            die(json_encode(array("code"=>1,"msg"=>"该属性不存在或已下架")));
        }else
        {
            die(json_encode(array("code"=>0,
                "price"=>$data['attr_change_price'],
                "stock"=>$data['product_stock'])));
        }
    }

}