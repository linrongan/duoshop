<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class AdminAction extends admin
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //编辑权限菜单
    function EditRoleAuth()
    {
        if (regExp::checkNULL($this->data['ry_parent_id']) &&
            regExp::checkNULL($this->data['ry_menu']) &&
            regExp::checkNULL($this->data['menu_type']))
        {
            $mod=$index=$action=$ry_qx_url='';
            if (!empty($this->data['ry_link']))
            {
                $url_array=parse_url($this->data['ry_link']);
                parse_str($url_array['query'],$query);
                $mod=isset($query['mod'])?$query['mod']:"";
                $v_mod=isset($query['v_mod'])?$query['v_mod']:$mod;
                $index=isset($query['_index'])?$query['_index']:"";
                $action=isset($query['_action'])?$query['_action']:"";
                $ry_qx_url=$mod.'#'.$v_mod.'#'.$index.'#'.$action;
            }
            $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN_MENU." "
                ." SET menu_type='".$this->data['menu_type']."',"
                ." ry_menu='".$this->data['ry_menu']."',"
                ." ry_parent_id='".$this->data['ry_parent_id']."',"
                ." ry_link='".$this->data['ry_link']."',"
                ." ry_order='".$this->data['ry_order']."',"
                ." ry_qx_url='".$ry_qx_url."',"
                ." port_type='".$this->data['port_type']."',"
                ." ry_role_id='".$this->data['ry_role_id']."'"
                ." WHERE id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'编辑成功');
        }
    }

    //管理员菜单
    function NewRoleAuth()
    {
        if (regExp::checkNULL($this->data['ry_parent_id']) &&
            regExp::checkNULL($this->data['ry_menu']))
        {
            $mod=$index=$action=$ry_qx_url='';
            if (!empty($this->data['ry_link']))
            {
                $url_array=parse_url($this->data['ry_link']);
                if (!isset($url_array['query']))
                {
                    $ry_qx_url='#';
                }else
                {
                    parse_str($url_array['query'],$query);
                    $mod=isset($query['mod'])?$query['mod']:"";
                    $v_mod=isset($query['v_mod'])?$query['v_mod']:$mod;
                    $index=isset($query['_index'])?$query['_index']:"";
                    $action=isset($query['_action'])?$query['_action']:"";
                    $ry_qx_url=$mod.'#'.$v_mod.'#'.$index.'#'.$action;
                }
            }
            //获取类别ry_parent_id
            $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ADMIN_MENU." "
                ."(menu_type,port_type,ry_menu,ry_parent_id,ry_link,ry_order,ry_qx_url,ry_role_id)"
                ."VALUES('".$this->data['menu_type']."',"
                ."'".$this->data['menu_type']."',"
                ."'".$this->data['ry_menu']."',"
                ."'".$this->data['ry_parent_id']."',"
                ."'".$this->data['ry_link']."',"
                ."'".$this->data['ry_order']."',"
                ."'".$ry_qx_url."','".$this->data['ry_role_id']."')");
            if ($id)
            {
                $this->GetDBMaster()->query("INSERT INTO ".TABLE_ADMIN_AUTH." "
                    ."(admin_id,menu_id,role_id)VALUES('".$_SESSION['admin_id']."','".$id."',"
                    ." '".$this->data['ry_role_id']."')");
            }
            return array('code'=>0,'msg'=>'添加成功');
        }
    }

    //删除管理员
    function ActionDelAdmin()
    {
        $data = $this->getThisAdmin();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"数据源不存在！");
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_ADMIN." "
            ." WHERE admin_id='".$this->data['id']."' "
            ." AND admin_id>10");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }

    //新增管理员
    function ActionNewAdmin()
    {
        $res = $data=$this->GetDBSlave1()->queryrow("SELECT admin_account "
            ." FROM ".TABLE_ADMIN." AS A "
            ." WHERE A.admin_account='".$this->data['adminAccount']."'");
        if(!empty($res['admin_account']))
        {
            return array('code'=>1,'msg'=>'账号已存在');
        }
        if(regExp::checkNULL($this->data['adminName']) &&
            regExp::checkNULL($this->data['password']) &&
            regExp::checkNULL($this->data['role_id']) &&
            regExp::checkNULL($this->data['admin_status']) &&
            regExp::checkNULL($this->data['adminAccount'])){
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ADMIN."(admin_name,admin_account,admin_pwd,role_id,admin_status)"
                ." VALUES('".$this->data['adminName']."','"
                .$this->data['adminAccount']."','".MD5($this->data['password'].APISECRET)."','"
                .$this->data['role_id']."','".$this->data['admin_status']."')");
            if($id)
            {
                return array('code'=>0,'msg'=>'添加成功');
            }
            return array('code'=>1,'msg'=>'添加失败');
        }

    }
    //编辑管理员
    function EditAdmin()
    {
        $password = " ";
        $data = $this->getThisAdmin();
        if(empty($this->data['password']))
        {
            $password=$data['admin_pwd'];
        }else
        {
            $password=MD5($this->data['password'].APISECRET);
        }
        if (regExp::checkNULL($this->data['adminName']) &&
            regExp::checkNULL($this->data['role_id']) &&
            regExp::checkNULL($this->data['admin_status']))
        {

            $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN." "
                ." SET admin_name='".$this->data['adminName']."',"
                ." admin_pwd='".$password."',"
                ." role_id='".$this->data['role_id']."',"
                ." admin_account='".$this->data['adminAccount']."',"
                ." admin_status='".$this->data['admin_status']."'"
                ." WHERE admin_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'编辑成功');
        }
    }

    //切换客户端
    function ActionChangePortType()
    {
        if(isset($this->data['type']) && is_numeric($this->data['type']))
        {
            $_SESSION['menu_port'] = $this->data['type'];
        }
        return array('code'=>0);
    }

}