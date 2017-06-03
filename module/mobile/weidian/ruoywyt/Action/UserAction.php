<?php
class UserAction extends user
{
    function __construct($data)
    {
        $this->data = $data;
    }

    function ActionSetUserInfo()
    {
        if(!regExp::checkNULL($this->data['nickname']))
        {
            return array('code'=>1,'msg'=>'昵称不能为空');
        }
        if(!regExp::checkNULL($this->data['phone']))
        {
            return array('code'=>1,'msg'=>'手机不能为空');
        }
        $sex = $this->data['sex']=='男'?1:2;
        $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET nickname='".$this->data['nickname']."',"
            ."phone='".$this->data['phone']."',sex='".$sex."' WHERE userid='".SYS_USERID."'");
        return array('code'=>0,'msg'=>'信息修改成功');
    }


    function ActionNewFeedback()
    {
        if(!regExp::checkNULL($this->data['message']))
        {
            return array('code'=>1,'msg'=>'请输入您的意见');
        }
        if(!regExp::checkNULL($this->data['contact']))
        {
            return array('code'=>1,'msg'=>'请输入您的联系方式');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_FEEDBACK."(userid,message,"
            ."contact,store_id,addtime,back_status) VALUES('".SYS_USERID."',"
            ." '".$this->data['message']."','".$this->data['contact']."','".$this->GetStoreId()."',"
            ."'".date("Y-m-d H:i:s",time())."',0)");
        if($res)
        {
            return array('code'=>0,'msg'=>'反馈成功');
        }
        return array('code'=>1,'msg'=>'反馈成功');
    }
}