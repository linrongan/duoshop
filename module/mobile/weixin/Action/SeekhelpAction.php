<?php
class SeekhelpAction extends seekhelp
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionAddHelp()
    {
        if(!regExp::is_ajax())
        {
            return array('code'=>1,'msg'=>'no access');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_NEED_HELP." "
            ."(userid,`name`,phone,live_area,need_goods,house,occupation,"
            ."addtime) VALUES('".SYS_USERID."','".$this->data['name']."',"
            ."'".$this->data['phone']."','".$this->data['live_area']."',".
            "'".$this->data['need_goods']."','".$this->data['house']."',"
            ."'".$this->data['occupation']."','".date("Y-m-d H:i:s",time())."')");
        if($res)
        {
            return array('code'=>0,'msg'=>'提交成功');
        }
        return array('code'=>1,'msg'=>'提交失败');
    }
}