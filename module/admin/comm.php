<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include_once RPC_DIR .'/module/common/common.php';
Class comm extends common{
    function __construct($data)
    {
        $this->data = daddslashes($data);
    }


    //管理员登陆
    function AdminLogin()
    {
        if (!regExp::checkNULL($this->data['username']))
        {
            return array("code"=>1,"msg"=>"管理员账号未填");
        }
        if (!regExp::checkNULL($this->data['password']))
        {
            return array("code"=>1,"msg"=>"管理员密码未填");
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADMIN." WHERE "
            ." admin_account='".$this->data['username']."'");
        $ip = getIP();
        $login_id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ADMIN_LOGIN." SET "
            ."admin_id='".$data['admin_id']."',login_date='".date("Y-m-d H:i:s",time())."',"
            ."login_ip='".$ip."',login_status=1");
        if (!empty($data) && md5($this->data['password'].APISECRET)==$data['admin_pwd'])
        {
            if ($data['admin_status']>0)
            {
                return array("code"=>1,"msg"=>"该管理员已经锁定");
            }
            if($data['role_id']==2)
            {
                $store = $this->GetDBSlave1()->queryrow("SELECT store_id FROM ".TABLE_COMM_STORE." WHERE "
                    ." admin_id='".$data['admin_id']."'");
                if(empty($store))
                {
                    return array("code"=>1,"msg"=>"无效的账号");
                }
                $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN_LOGIN." SET login_status=0 "
                    ." WHERE id='".$login_id."'");
                $_SESSION['admin_store_id'] = $store['store_id'];
            }
            //更新登陆信息
            $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN." "
                ." SET admin_last_login='".date("Y-m-d H:i:s")."',"
                ." admin_login_count=admin_login_count+1 "
                ." WHERE admin_id='".$data['admin_id']."'");
            $_SESSION['role_id']=$data['role_id'];
            $_SESSION['admin_id']=$data['admin_id'];
            $_SESSION['admin_name'] = $data['admin_name'];
            return array("code"=>0,"msg"=>"成功登陆,正在跳转..");
        }
        return array("code"=>1,"msg"=>"账号或密码错误");
    }

    //检验是否有权限
    public function CheckAdminAuth($admin_id,$ry_qx_url='err')
    {
        //获取当前菜单id
        $common=array('admin#admin#_default#',
            'admin#admin##','admin#admin#_left_menu#',
            'admin#admin#_top_menu#','admin#admin##AdminLogout',
            'admin#admin#_default_tip#','admin#wechat#_gzhcd_content#',
            'admin#admin#_nofound#','admin#upload##ActionLoadUpload');
        if (in_array($ry_qx_url,$common))
        {
            return;
        }
        if (isset($_SESSION['role_id']) && $_SESSION['role_id']==1)
        {
            $where=" AND AU.admin_id=".intval($admin_id)." ";
        }elseif(isset($_SESSION['role_id']) && $_SESSION['role_id']>1)
        {
            $where=" AND AU.role_id='".$_SESSION['role_id']."' ";
        }else
        {
            exit('Access Denied');
        }
        $data=$this->GetDBSlave1()->queryrow("SELECT AU.menu_id FROM ".TABLE_ADMIN_MENU." AS M "
            ." LEFT JOIN ".TABLE_ADMIN_AUTH." AS AU ON M.id=AU.menu_id "
            ." WHERE M.ry_qx_url='".$ry_qx_url."'  ".$where." ");
        if (empty($data['menu_id']))
        {
            $this->Error();
        }
    }

    //图片上传
    public function AjaxUpload(){
        if(!isset($_FILES['file']) || empty($_FILES['file']['tmp_name']) || $_FILES['file']['error']!=0){
            echo json_encode(array('code'=>1,'msg'=>'请选择正确的图片'));exit;
        }
        $file = $this->upload_pic($_FILES['file'],RPC_DIR.SAVE_IMG_LARGER,WEBURL.SAVE_IMG_LARGER);
        if(!$file){
            echo json_encode(array('code'=>1,'msg'=>'图片上传失败'));exit;
        }
        echo json_encode(array('code'=>0,'msg'=>'图片上传成功','file'=>$file));exit;
    }

    protected  function upload_pic($files,$tosrc,$web)
    {
        //支持的图片类型
        $imageArray = array('image/gif','image/gif', 'image/jpeg', 'image/png', 'image/bmp');
        if (is_uploaded_file($files['tmp_name']))
        {
            if($files['error']== 0 &&
                $files['size'] > 0 &&
                $files['size'] < 100 * 1024 * 1024)
            {
                $extArray = explode('.',$files['name']);
                $fileExt = $extArray[count($extArray) -1];
                $filename = md5(time()) .rand(11,99). '.' . $fileExt;
                //$filename此处随机文件名
                if(move_uploaded_file($files['tmp_name'], $tosrc.$filename))
                {
                    //成功,返回完整的图片地址
                    return  $web.$filename;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    function Error()
    {
        include RPC_DIR .TEMPLATEPATH.'/admin/_comm/_waring_1_tpl.php';exit;
    }


    //查询未读的帮助
    function GetNoSeeHelpCount()
    {
        $total = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS nums FROM ".TABLE_NEED_HELP." "
            ." WHERE see_status=0");
        return $total['nums'];
    }


}
?>