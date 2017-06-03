<?php
class AgentAction extends agent
{
    function __construct($data)
    {
        $this->data = $data;
    }


    function ActionGetNewAttrData()
    {
        $attr = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR."  "
            ." WHERE id='".$this->data['id']."' "
            ." AND is_del=0");
        if(!$attr)
        {
            return array('code'=>1,'msg'=>'属性不存在或已经下架');
        }
        $product = $this->GetOneAgentProduct($attr['product_id']);
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品不存在或已下架');
        }
        $price = $attr['attr_change_price'];
        if($product['agent_price']!=$product['product_price'])
        {
            $price = round($price*($product['agent_price']/$product['product_price']),2);
        }
        $stock = $attr['product_stock'];
        return array('code'=>0,'price'=>$price,'stock'=>$stock);
    }


    function ActionAddAgent()
    {
        if(!regExp::checkNULL($this->data['product_id']))
        {
            return array('code'=>1,'msg'=>'产品错误');
        }
        if(!regExp::checkNULL($this->data['product_count']) ||
            !regExp::is_positive_number($this->data['product_count']))
        {
            return array('code'=>1,'msg'=>'数量不正确');
        }
        $data = $this->GetOneAgentProduct($this->data['product_id']);
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR."  "
            ." WHERE product_id='".$this->data['product_id']."' AND is_del=0");
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
        $product_count = $this->data['product_count']?$this->data['product_count']:1;
        $reg = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_AGENT_CART." WHERE "
            ."status=0 AND userid='".$_SESSION['userid']."'");
        if($reg)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_AGENT_CART." SET "
                ." status=1 WHERE userid='".$_SESSION['userid']."'");
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_AGENT_CART." "
            ."(userid,agent_id,attr_id,attr_name,product_count,store_id,"
            ."addtime) VALUES('".$_SESSION['userid']."','".$this->data['product_id']."',"
            ."'".implode(',',$attr_id)."','".implode(',',$attr_name)."',"
            ."'".$product_count."','".$data['store_id']."','".date("Y-m-d H:i:s",time())."')");
        if($res)
        {
            return array('code'=>0,'msg'=>'ok','id'=>$res);
        }
        return array('code'=>1,'msg'=>'提交失败');
    }
}