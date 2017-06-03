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
        }elseif($product['product_status']!=0)
        {
            return array('code'=>1,'msg'=>'产品已下架');
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


    //加入团购临时信息
    public function ActionAddTempGroup()
    {
        if(!regExp::checkNULL($this->data['group_id']))
        {
            return array('code'=>1,'msg'=>'团购参数错误');
        }
        if(!regExp::checkNULL($this->data['product_count']))
        {
            return array('code'=>1,'msg'=>'数量错误');
        }
        $group = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GROUP_PRODUCT." WHERE "
            ." id='".$this->data['group_id']."'");
        if(empty($group))
        {
            return array('code'=>1,'msg'=>'团购不存在');
        }elseif($group['allow_buy_nums'])
        {
            if($this->data['product_count']>$group['allow_buy_nums'])
            {
                return array('code'=>1,'msg'=>'最大允许数量'.$group['allow_buy_nums']);
            }
        }
        $attr_array = array();
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." WHERE "
            ." product_id='".$group['product_id']."' AND is_del=0");
        $attr_temp_id = $attr_temp_type_id = $attr_temp_name = $attr_temp_type_name ='';
        if($attr)
        {
            if(!regExp::checkNULL($this->data['attr_id']) || !is_array($this->data['attr_id']))
            {
                return array('code'=>1,'msg'=>'请选择产品参数');
            }
            $attr_temp = array();
            foreach($attr as $k=>$v)
            {
                $attr_temp[$v['id']] = $v;
            }
            foreach($this->data['attr_id'] as $k=>$v)
            {
                if(!array_key_exists($v,$attr_temp))
                {
                    return array('code'=>1,'msg'=>'产品参数错误');
                    break;
                }
                $attr_temp_id .= $attr_temp[$v]['attr_temp_id'].',';
                $attr_temp_type_id .= $v.',';
                $attr_temp_name .= $attr_temp[$v]['attr_type_name'].',';
                $attr_temp_type_name .= $attr_temp[$v]['attr_temp_name'].',';
            }
            $attr_temp_id = rtrim($attr_temp_id,',');
            $attr_temp_type_id = rtrim($attr_temp_type_id,',');
            $attr_temp_name = rtrim($attr_temp_name,',');
            $attr_temp_type_name = rtrim($attr_temp_type_name,',');
        }
        $temp = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADD_GROUP_TEMP."  "
            ." WHERE group_id='".$this->data['group_id']."' "
            ." AND userid='".SYS_USERID."' "
            ." AND status=0");
        if($temp)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_ADD_GROUP_TEMP." SET status=5 "
                ." WHERE group_id='".$this->data['group_id']."' AND userid='".SYS_USERID."' "
                ." AND status=0");
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ADD_GROUP_TEMP." "
            ."(userid,group_id,product_id,product_count,addtime,attr_temp_id,attr_temp_type_id,"
            ."attr_temp_name,attr_temp_type_name) "
            ."VALUES('".SYS_USERID."','".$this->data['group_id']."',"
            ."'".$group['product_id']."','".$this->data['product_count']."',"
            ."'".date("Y-m-d H:i:s",time())."','".$attr_temp_id."',"
            ."'".$attr_temp_type_id."','".$attr_temp_name."',"
            ."'".$attr_temp_type_name."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'query ok','group_id'=>$id);
        }
        return array('code'=>1,'msg'=>'团购失败');
    }



    //参与团购
    function ActionJoinGroupBuy()
    {
        if(!regExp::checkNULL($this->data['group_number']))
        {
            return array('code'=>1,'msg'=>'缺少参数');
        }
        $group_buy = $this->GetDBSlave1()->queryrow("SELECT GB.*,GP.allow_buy_nums FROM ".TABLE_GROUP_BUY." "
            ."AS GB LEFT JOIN ".TABLE_GROUP_PRODUCT." AS GP ON GB.group_id=GP.id WHERE "
            ."group_number='".$this->data['group_number']."' AND GB.group_status>0");
        if(empty($group_buy))
        {
            return array('code'=>1,'msg'=>'团购不存在');
        }
        if($group_buy['group_status']==2)
        {
            return array('code'=>1,'msg'=>'团购已完成');
        }
        if($group_buy['group_number_people']==$group_buy['group_join_people'])
        {
            return array('code'=>1,'msg'=>'团购已完成');
        }
        if($group_buy['group_over']<date("Y-m-d H:i:s",time()))
        {
            return array('code'=>1,'msg'=>'团购已结束');
        }
        if(!regExp::checkNULL($this->data['product_count']))
        {
            return array('code'=>1,'msg'=>'产品数量错误');
        }elseif($group_buy['allow_buy_nums'] && $this->data['product_count']>$group_buy['allow_buy_nums'])
        {
            return array('code'=>1,'msg'=>'最大允许数量'.$group_buy['allow_buy_nums']);
        }
        $check = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GROUP_BUY_ORDER." WHERE "
            ." group_number='".$this->data['group_number']."' AND userid='".SYS_USERID."' "
            ." AND order_status=1");
        if($check)
        {
            return array('code'=>1,'msg'=>'已经参与过了');
        }
        $attr_array = array();
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." WHERE "
            ." product_id='".$group_buy['product_id']."' AND is_del=0");
        $attr_temp_id = $attr_temp_type_id = $attr_temp_name = $attr_temp_type_name ='';
        if($attr)
        {
            if(!regExp::checkNULL($this->data['attr_id']) || !is_array($this->data['attr_id']))
            {
                return array('code'=>1,'msg'=>'请选择产品参数');
            }
            $attr_temp = array();
            foreach($attr as $k=>$v)
            {
                $attr_temp[$v['id']] = $v;
            }
            foreach($this->data['attr_id'] as $k=>$v)
            {
                if(!array_key_exists($v,$attr_temp))
                {
                    return array('code'=>1,'msg'=>'产品参数错误');
                    break;
                }
                $attr_temp_id .= $attr_temp[$v]['attr_temp_id'].',';
                $attr_temp_type_id .= $v.',';
                $attr_temp_name .= $attr_temp[$v]['attr_type_name'].',';
                $attr_temp_type_name .= $attr_temp[$v]['attr_temp_name'].',';
            }
            $attr_temp_id = rtrim($attr_temp_id,',');
            $attr_temp_type_id = rtrim($attr_temp_type_id,',');
            $attr_temp_name = rtrim($attr_temp_name,',');
            $attr_temp_type_name = rtrim($attr_temp_type_name,',');
        }
        try
        {
            //TABLE_JOIN_GROUP_TEMP
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_JOIN_GROUP_TEMP." "
                ." SET userid='".SYS_USERID."',"
                ." group_id='".$group_buy['group_id']."',"
                ." product_id='".$group_buy['product_id']."',"
                ." group_number='".$this->data['group_number']."',"
                ." product_count='".$this->data['product_count']."',"
                ." group_price='".$group_buy['group_price']."',"
                ." addtime='".date("Y-m-d H:i:s",time())."',"
                ." status=0,attr_temp_id='".$attr_temp_id."',"
                ." attr_temp_type_id='".$attr_temp_type_id."',"
                ." attr_temp_name='".$attr_temp_name."',"
                ." attr_temp_type_name='".$attr_temp_type_name."'");
        }catch(Exception $e)
        {
            return array('code'=>1,'msg'=>'error');
        }
        return array('code'=>0,'msg'=>'success','id'=>$id);
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