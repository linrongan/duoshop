<?php
class QuestionAction extends question
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionAddQuestion()
    {
        if(!isset($this->data['submit'])){return;}
        $res = $this->GetDBMaster()->query("INSERT INTO ".TABLE_QUESTION." "
            ." VALUES('','".$this->data['qusetion']."','".$this->data['answer']."',"
            ."'".$this->data['ry_order']."','".$this->data['is_show']."',"
            ."'".$this->data['is_show_answer']."','".date("Y-m-d H:i:s",time())."')");
        if($res)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }


    function ActionEditQuestion()
    {
        if(!isset($this->data['submit'])){return;}
        if(!regExp::checkNULL($this->data['id']))
        {
            $this->Error();
        }
        $data = $this->GetOneQuestion($this->data['id']);
        if(!$data)
        {
            $this->Error();
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_QUESTION." SET "
            ."qusetion='".$this->data['qusetion']."',answer='".$this->data['answer']."',"
            ."ry_order='".$this->data['ry_order']."',is_show='".$this->data['is_show']."',"
            ."is_show_answer='".$this->data['is_show_answer']."' "
            ."WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }



    function ActionDelQuestion()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            $this->Error();
        }
        $data = $this->GetOneQuestion($this->data['id']);
        if(!$data)
        {
            $this->Error();
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_QUESTION." WHERE "
            ." id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }
}