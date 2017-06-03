<?php
class ApplyAction extends apply
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionShopApply()
    {
        $data = $this->GetOneApply();
        if(!isset($this->data['type']) || $this->data['type']!='update')
        {
            if(!empty($data))
            {
                return array('code'=>1,'msg'=>'资料已提交了 请耐心等待审核');
            }
        }
        if($data)
        {
            if($data['status'])
            {
                return array('code'=>1,'msg'=>'已通过审核 刷新重试');
            }
            $res = $this->GetDBMaster()->query("UPDATE ".TABLE_SHOP_APPLY." SET "
                ." `name`='".$this->data['name']."',phone='".$this->data['phone']."',"
                ." address='".$this->data['address']."',miaoshu='".$this->data['miaoshu']."',"
                ." addtime='".date("Y-m-d H:i:s",time())."',userid='".SYS_USERID."',"
                ." shop_name='".$this->data['shop_name']."',`password`='".$this->data['password']."',"
                ." email='".$this->data['email']."',last_date='".time()."' "
                ." WHERE userid='".SYS_USERID."'");
        }else{
            $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_SHOP_APPLY." SET "
                ." `name`='".$this->data['name']."',phone='".$this->data['phone']."',"
                ." address='".$this->data['address']."',miaoshu='".$this->data['miaoshu']."',"
                ." addtime='".date("Y-m-d H:i:s",time())."',userid='".SYS_USERID."',"
                ." shop_name='".$this->data['shop_name']."',`password`='".$this->data['password']."',"
                ." email='".$this->data['email']."',last_date='".time()."'");
        }
        if($res)
        {
            return array('code'=>0,'msg'=>'提交成功');
        }
        return array('code'=>1,'msg'=>'提交失败');
    }
    function ActionShopEditApply()
    {
        $data = $this->GetOneApply();
        if(empty($data)||$data['status']!=1)
        {
            redirect(NOFOUND);
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_SHOP_APPLY." SET "
            ." `name`='".$this->data['name']."',phone='".$this->data['phone']."',"
            ." address='".$this->data['address']."',miaoshu='".$this->data['miaoshu']."',"
            ." userid='".SYS_USERID."',"
            ." shop_name='".$this->data['shop_name']."',`password`='".$this->data['password']."',"
            ." status=0,email='".$this->data['email']."',last_date='".time()."' "
            ." WHERE userid='".SYS_USERID."'");

        return array('code'=>0,'msg'=>'提交成功');
    }




}