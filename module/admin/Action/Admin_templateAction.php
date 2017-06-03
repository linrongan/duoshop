<?php
Class Admin_templateAction extends admin_template
{
    //添加主题
    function ActionNewTemplate()
    {
        if(regExp::checkNULL($this->data['template_name']) &&
            regExp::checkNULL($this->data['template_file']) &&
            regExp::checkNULL($this->data['price'])){
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COMM_TEMPLATE." "
                ."(template_name,template_file,price) "
                ."VALUES('".$this->data['template_name']."','"
                .$this->data['template_file']."','"
                .$this->data['price']."')");
            if($id)
            {
                return array('code'=>0,'msg'=>'添加成功');
            }
            return array('code'=>1,'msg'=>'添加失败');
        }
    }
    //删除主题
    function ActionDelTemplate()
    {
        $data = $this->getThisTemplate();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"数据源不存在！");
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_COMM_TEMPLATE." "
            ." WHERE template_id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //编辑主题
    function ActionEditTemplate()
    {
        $data = $this->getThisTemplate();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"数据源不存在！");
        }
        if (regExp::checkNULL($this->data['template_name']) &&
            regExp::checkNULL($this->data['template_file']) &&
            regExp::checkNULL($this->data['price']))
        {

            $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_TEMPLATE." "
                ." SET template_name='".$this->data['template_name']."',"
                ." template_file='".$this->data['template_file']."',"
                ." price='".$this->data['price']."'"
                ." WHERE template_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'编辑成功');
        }
        return array('code'=>1,'msg'=>'编辑失败');
    }

}