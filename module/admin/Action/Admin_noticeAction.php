<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_noticeAction extends admin_notice
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //新增消息
    function ActionAddNotice()
    {

        if( !regExp::checkNULL($this->data['title']) ||
            !regExp::checkNULL($this->data['alert_role_id']) ||
            !regExp::checkNULL($this->data['img']) ||
            !regExp::checkNULL($this->data['abstract']) ||
            !regExp::checkNULL($this->data['open_way']) )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $field = 'alert_text';
        $value = $this->data['alert_text'];
        if($this->data['open_way']==0)
        {
            if(!regExp::checkNULL($this->data['alert_text']))
            {
                return array('code'=>1,'msg'=>'图文不能为空');
            }
            $field = 'alert_text';
            $value = $this->data['alert_text'];
        }elseif($this->data['open_way']==1){
            if(!regExp::checkNULL($this->data['alert_link']))
            {
                return array('code'=>1,'msg'=>'外链不能为空');
            }
            $field = 'alert_link';
            $value = $this->data['alert_link'];
        }

        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ALERT_LIST." (title,alert_role_id"
            .",img,abstract,open_way,".$field.",addtime,alert_date) VALUES('".$this->data['title']."',"
            ."'".$this->data['alert_role_id']."',"
            ."'".$this->data['img']."',"
            ."'".$this->data['abstract']."','".$this->data['open_way']."',"
            ."'".$value."','".date('Y-m-d H:i:s')."',"
            ."'".date('Y-m-d')."')");

        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑消息
    function ActionEditNotice()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if( !regExp::checkNULL($this->data['title']) ||
            !regExp::checkNULL($this->data['alert_role_id']) ||
            !regExp::checkNULL($this->data['img']) ||
            !regExp::checkNULL($this->data['abstract']) ||
            !regExp::checkNULL($this->data['open_way']) )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $field = 'alert_text';
        $value = $this->data['alert_text'];
        if($this->data['open_way']==0)
        {
            if(!regExp::checkNULL($this->data['alert_text']))
            {
                return array('code'=>1,'msg'=>'图文不能为空');
            }
            $field = 'alert_text';
            $value = $this->data['alert_text'];
        }elseif($this->data['open_way']==1){
            if(!regExp::checkNULL($this->data['alert_link']))
            {
                return array('code'=>1,'msg'=>'外链不能为空');
            }
            $field = 'alert_link';
            $value = $this->data['alert_link'];
        }
        $data = $this->getNoticeDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'消息不存在或已删除');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_ALERT_LIST." SET "
            ." title='".$this->data['title']."',"
            ." img='".$this->data['img']."',"
            ." abstract='".$this->data['abstract']."',"
            ." alert_role_id='".$this->data['alert_role_id']."',"
            ." open_way='".$this->data['open_way']."',"
            ." {$field}='".$value."'"
            ." WHERE alert_id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除消息
    function ActionDelNotice()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->getNoticeDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'消息不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_ALERT_LIST." "
            ." WHERE alert_id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //添加消息分类
    function ActionAddNoticeRole()
    {
        if( !regExp::checkNULL($this->data['name']) ||
            !regExp::checkNULL($this->data['icon']) ||
            !regExp::checkNULL($this->data['alert_type']))
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ALERT_ROLE." (name,icon"
            .",alert_type,role_id,addtime) VALUES('".$this->data['name']."',"
            ."'".$this->data['icon']."',"
            ."'".$this->data['alert_type']."',"
            ."'".$this->data['role_id']."',"
            ."'".date('Y-m-d H:i:s')."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑消息分类
    function ActionEditNoticeRole()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if( !regExp::checkNULL($this->data['name']) ||
            !regExp::checkNULL($this->data['icon']) ||
            !regExp::checkNULL($this->data['alert_type']) ||
            !regExp::checkNULL($this->data['open_status']) ||
            !regExp::checkNULL($this->data['role_id']) )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $data = $this->getNoticeRoleDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'消息分类不存在或已删除');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_ALERT_ROLE." SET "
            ." role_id='".$this->data['role_id']."',"
            ." name='".$this->data['name']."',"
            ." icon='".$this->data['icon']."',"
            ." alert_type='".$this->data['alert_type']."',"
            ." open_status='".$this->data['open_status']."'"
            ." WHERE alert_role_id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除消息分类
    function ActionDelNoticeRole()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->getNoticeRoleDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'消息分类不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_ALERT_ROLE." "
            ." WHERE alert_role_id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
}