<?php
class admin_placeAction extends admin_place
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //增加省
    function ActionNewProvince()
    {
        if(!regExp::checkNULL($this->data['province_id']))
        {
            return array('code'=>1,'msg'=>'请输入省ID');
        }
        if(!regExp::checkNULL($this->data['name']))
        {
            return array('code'=>1,'msg'=>'请输入省名');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PLACE_PROVINCE." "
            ."(id,name) "
            ." VALUES('".$this->data['province_id']."','"
            .$this->data['name']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑省
    function ActionEditProvince()
    {
        $data = $this->getOneProvince();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"数据源不存在！");
        }
        if(!regExp::checkNULL($this->data['province_id']))
        {
            return array('code'=>1,'msg'=>'请输入省ID');
        }
        if(!regExp::checkNULL($this->data['name']))
        {
            return array('code'=>1,'msg'=>'请输入省名');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_PLACE_PROVINCE." "
            ." SET id='".$this->data['province_id']."',"
            ." name='".$this->data['name']."'"
            ." WHERE autoid='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除省
    function ActionDelProvince()
    {
        $data = $this->getOneProvince();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"省不存在或已删除！");
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_PLACE_PROVINCE." "
            ." WHERE autoid='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //增加市
    function ActionNewCity()
    {
        if(!regExp::checkNULL($this->data['father']))
        {
            redirect(ADMIN_ERROR);
        }
        if(!regExp::checkNULL($this->data['city_id']))
        {
            return array('code'=>1,'msg'=>'请输入市ID');
        }
        if(!regExp::checkNULL($this->data['name']))
        {
            return array('code'=>1,'msg'=>'请输入市名');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PLACE_CITY." "
            ."(id,name,father) "
            ." VALUES('".$this->data['city_id']."','"
            .$this->data['name']."','".$this->data['father']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑市
    function ActionEditCity()
    {
        $data = $this->getOneCity();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"数据源不存在！");
        }
        if(!regExp::checkNULL($this->data['city_id']))
        {
            return array('code'=>1,'msg'=>'请输入市ID');
        }
        if(!regExp::checkNULL($this->data['name']))
        {
            return array('code'=>1,'msg'=>'请输入市名');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_PLACE_CITY." "
            ." SET id='".$this->data['city_id']."',"
            ." name='".$this->data['name']."'"
            ." WHERE autoid='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除市
    function ActionDelCity()
    {
        $data = $this->getOneCity();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"市不存在或已删除！");
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_PLACE_CITY." "
            ." WHERE autoid='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //增加区域
    function ActionNewArea()
    {
        if(!regExp::checkNULL($this->data['father']))
        {
            redirect(ADMIN_ERROR);
        }
        if(!regExp::checkNULL($this->data['area_id']))
        {
            return array('code'=>1,'msg'=>'请输入市ID');
        }
        if(!regExp::checkNULL($this->data['name']))
        {
            return array('code'=>1,'msg'=>'请输入市名');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PLACE_AREA." "
            ."(id,name,father) "
            ." VALUES('".$this->data['area_id']."','"
            .$this->data['name']."','".$this->data['father']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑市
    function ActionEditArea()
    {
        $data = $this->getOneArea();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"数据源不存在！");
        }
        if(!regExp::checkNULL($this->data['area_id']))
        {
            return array('code'=>1,'msg'=>'请输入区域ID');
        }
        if(!regExp::checkNULL($this->data['name']))
        {
            return array('code'=>1,'msg'=>'请输入区域名');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_PLACE_AREA." "
            ." SET id='".$this->data['area_id']."',"
            ." name='".$this->data['name']."'"
            ." WHERE autoid='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除区域
    function ActionDelArea()
    {
        $data = $this->getOneArea();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"区域不存在或已删除！");
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_PLACE_AREA." "
            ." WHERE autoid='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
}