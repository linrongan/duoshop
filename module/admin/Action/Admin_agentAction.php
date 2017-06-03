<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_agentAction extends admin_agent
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    function ActionAddAgentProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$this->data['id']."'");
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }
        $agent = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_AGENT." WHERE "
            ." product_id='".$this->data['id']."'");
        if(!empty($agent))
        {
            return array('code'=>1,'msg'=>'重复添加');
        }
        if( !regExp::checkNULL($this->data['agent_price']) ||
            !regExp::checkNULL($this->data['agent_sort']))
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }

        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PRODUCT_AGENT." (product_id,"
            ."agent_price,agent_sort,addtime) VALUES('".$this->data['id']."',"
            ."'".$this->data['agent_price']."',"
            ."'".$this->data['agent_sort']."',"
            ."'".date('Y-m-d H:i:s')."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //代发编辑
    function ActionEditAgentProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if( !regExp::checkNULL($this->data['agent_price']) ||
            !regExp::checkNULL($this->data['agent_sort']) )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $data = $this->GetAgentProductDetail();
        if(!$data)
        {
            return array('code'=>1,'msg'=>'记录不存在');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." WHERE "
            ." product_id='".$data['product_id']."' AND is_del=0");
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品不存在或已下架');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT_AGENT." SET "
            ." agent_price='".$this->data['agent_price']."',"
            ." agent_sort='".$this->data['agent_sort']."'"
            ." WHERE id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    function ActionDelAgentProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetAgentProductDetail();
        if(!$data)
        {
            return array('code'=>1,'msg'=>'记录不存在');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT_AGENT." SET "
            ." agent_status=1 WHERE id = '".$this->data['id']."' "
        );
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功！');
        }
        return array('code'=>1,'msg'=>'删除失败！');
    }
}