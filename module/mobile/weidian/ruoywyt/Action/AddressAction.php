<?php
class AddressAction extends address
{
    function __construct($data)
    {
        $this->data = $data;
    }


    function ActionDelAddress()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $id = $this->GetOneAddress($this->data['id']);
        if($id)
        {
            $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_SHIP_ADDRESS." "
                ." WHERE id='".$this->data['id']."'");
            if($res)
            {
                return array('code'=>0,'msg'=>'删除成功');
            }else{
                return array('code'=>1,'msg'=>'删除失败');
            }
        }else{
            return array('code'=>1,'msg'=>'地址不存在');
        }
    }


    function ActionAddAddress()
    {
        if(!regExp::checkNULL($this->data['shop_name']))
        {
            return array('code'=>1,'msg'=>'请输入姓名');
        }
        if(!regExp::checkNULL($this->data['shop_phone']))
        {
            return array('code'=>1,'msg'=>'请输入手机');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_SHIP_ADDRESS."(userid,shop_name,"
            ."shop_phone,address_details,addtime,default_select,address_location,last_upd_date) VALUES"
            ."('".SYS_USERID."','".$this->data['shop_name']."','".$this->data['shop_phone']."',"
            ."'".$this->data['address_details']."','".date("Y-m-d H:i:s",time())."','".$this->data['select_status']."',"
            ."'".$this->data['address_location']."','".time()."')");
        if($this->data['select_status'])
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_SHIP_ADDRESS." SET default_select=0 "
                ." WHERE userid='".SYS_USERID."' AND id!='".$res."'");
        }
        if($res)
        {
            return array('code'=>0,'msg'=>'新增成功');
        }
        return array('code'=>1,'msg'=>'新增失败');
    }


    function ActionEditAddress()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetOneAddress($this->data['id']);
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'查无地址');
        }
        if(!regExp::checkNULL($this->data['shop_name']))
        {
            return array('code'=>1,'msg'=>'请输入姓名');
        }
        if(!regExp::checkNULL($this->data['shop_phone']))
        {
            return array('code'=>1,'msg'=>'请输入手机');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_SHIP_ADDRESS." SET shop_name='".$this->data['shop_name']."',"
            ."shop_phone='".$this->data['shop_phone']."',address_location='".$this->data['address_location']."',"
            ."address_details='".$this->data['address_details']."',default_select='".$this->data['select_status']."',"
            ."last_upd_date='".time()."' WHERE id='".$this->data['id']."'");
        if($data['default_select']!=$this->data['select_status'] && !$data['default_select'])
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_SHIP_ADDRESS." SET default_select=0 "
                ." WHERE userid='".SYS_USERID."' AND id!='".$this->data['id']."'");
        }
        if($res)
        {
            return array('code'=>0,'msg'=>'编辑成功');
        }
        return array('code'=>1,'msg'=>'编辑失败');
    }


    //设置默认收货地址
    function ActionSetDefault()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetOneAddress($this->data['id']);
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'查无地址');
        }
        if($data['default_select'])
        {
            return array('code'=>1,'msg'=>'已经是默认地址了');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_SHIP_ADDRESS." SET default_select=IF(id='".$this->data['id']."',1,0),"
            ." last_upd_date='".time()."' WHERE userid='".SYS_USERID."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'设置默认成功');
        }
        return array('code'=>1,'msg'=>'设置默认失败');
    }
}