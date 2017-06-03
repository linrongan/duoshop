<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_bargainAction extends admin_bargain
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //添加
    function ActionAddBargainProduct()
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
        if( !regExp::checkNULL($this->data['min_price']) ||
            !regExp::checkNULL($this->data['sort']) ||
            !regExp::checkNULL($this->data['start_time']) ||
            !regExp::checkNULL($this->data['end_time']) ||
            !regExp::checkNULL($this->data['float_price']) )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        if($this->data['min_price']<$this->data['float_price'])
        {
            return array('code'=>1,'msg'=>'一刀最大价钱不能大于底价');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GAMES_BARGAIN." (product_id,"
            ."min_price,sort,addtime,start_time,end_time,float_price) VALUES('".$this->data['id']."',"
            ."'".$this->data['min_price']."',"
            ."'".$this->data['sort']."',"
            ."'".date('Y-m-d H:i:s')."',"
            ."'".$this->data['start_time']."','".$this->data['end_time']."',"
            ."'".$this->data['float_price']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑
    function ActionEditBargainProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if( !regExp::checkNULL($this->data['min_price']) ||
            !regExp::checkNULL($this->data['sort']) ||
            !regExp::checkNULL($this->data['start_time']) ||
            !regExp::checkNULL($this->data['end_time']) ||
            !regExp::checkNULL($this->data['float_price']) )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $data = $this->getBargainProductDetail();
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
        $this->GetDBMaster()->query("UPDATE ".TABLE_GAMES_BARGAIN." SET "
            ." min_price='".$this->data['min_price']."',"
            ." sort='".$this->data['sort']."',"
            ." start_time='".$this->data['start_time']."',"
            ." end_time='".$this->data['end_time']."',"
            ." float_price='".$this->data['float_price']."'"
            ." WHERE id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除
    function ActionDelBargainProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->getBargainProductDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        if($data['end_time']>date('Y-m-d H:i:s') && $data['join_count']>0)
        {
            return array('code'=>1,'msg'=>'这游戏已经有人参与啦，请不要随意删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_GAMES_BARGAIN." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
}