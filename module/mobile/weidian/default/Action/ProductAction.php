<?php
class ProductAction extends product
{
    function __construct($data)
    {
        $this->data = $data;
    }

    function ActionColleProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT product_id,store_id FROM ".TABLE_PRODUCT." WHERE  "
            ." product_id='".$this->data['id']."' AND store_id='".$this->GetStoreId()."'");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        $shouchang = $this->GetProductColle($this->data['id']);
        if($shouchang)
        {
            $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_PRODUCT_COLLE." WHERE id='".$shouchang['id']."'");
            $msg = '取消收藏';
            $dz = 2;
        }else{
            $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PRODUCT_COLLE." SET "
                ."userid='".SYS_USERID."',product_id='".$this->data['id']."',"
                ."store_id='".$product['store_id']."'");
            $msg = '收藏';
            $dz = 1;
        }
        if($res)
        {
            return array('code'=>0,'msg'=>$msg.'成功','dz'=>$dz);
        }
        return array('code'=>1,'msg'>$msg.'失败');
    }



    function ActionAddCart()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'产品错误');
        }
        if(!regExp::checkNULL($this->data['product_count']) ||
            !regExp::is_positive_number($this->data['product_count']))
        {
            return array('code'=>1,'msg'=>'数量不正确');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$this->data['id']."'");
        if(empty($product))
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }elseif($product['product_status']!=0)
        {
            return array('code'=>1,'msg'=>'产品已下架');
        }


        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." WHERE "
            ." product_id='".$this->data['id']."' AND is_del=0");
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
                ." select_status=0,"
                ." update_date='".date("Y-m-d H:i:s",time())."',"
                ." store_id='".$product['store_id']."'");
        }
        if($res)
        {
            return array('code'=>0,'msg'=>'已成功加入购物车');
        }
        return array('code'=>1,'msg'=>'加入购物车失败');
    }
}