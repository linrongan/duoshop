<?php
class ApplyAction extends apply
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //不通过审核
    function ActionEditApply()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetApplyDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'没有找到申请记录');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_SHOP_APPLY." "
            ." SET status=1, shop_status=0 WHERE id='".$this->data['id']."'");
        $user = $this->GetUserInfo($data['userid']);
        $array = array(
            'openid'=>$user['openid'],
            'store_name'=>$data["shop_name"],
            'text'=>$this->data['text'],
            'admin'=>'管理员'.$_SESSION['admin_id'],
            'date'=>date("Y-m-d H:i:s",time())
        );
        $this->SendApplyFailNotice($array);
        return array('code'=>0,'msg'=>'操作成功');
    }
    //删除申请
    function ActionDelApply()
    {
        $data = $this->GetApplyDetail();
        if(!$data)
        {
            return array('code'=>1,'msg'=>'申请记录不存在或已删除');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_SHOP_APPLY." WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }

    //确认通过申请
    function ActionConfirmApply()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetApplyDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'数据不存在或已删除');
        }
        if($data['shop_status']==1 && $data['status']==2)
        {
            return array('code'=>1,'msg'=>'状态错误');
        }

        //查询店铺名是否重复
        $shop = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." WHERE "
            ." store_name='".$data['shop_name']."'");
        if($shop)
        {
            //重复
            $data['shop_name'] = $data['shop_name'].'_'.$data['id'];
        }
        $account = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADMIN." WHERE "
            ." admin_account='".$data['phone']."'");
        if($account)
        {
            return array('code'=>1,'msg'=>'电话号码重复');
        }
        $url = time().rand(1000,9999);
        $this->GetDBMaster()->StartTransaction();
        //默认模板
        $default_template = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_TEMPLATE." WHERE "
            ."template_default_use=1");
        if(empty($default_template))
        {
            return array('code'=>1,'msg'=>'无默认模板');
        }
        try{
            //role_id=2 商户
            $admin_id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ADMIN." SET "
                ." admin_name='".$data['shop_name']."',admin_pwd='".md5($data['password'].APISECRET)."',"
                ." role_id=2,admin_status=0,admin_account='".$data['phone']."',"
                ." fid=0,admin_login_count=0");

            $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COMM_STORE."  SET "
                ." store_name='".$data['shop_name']."',template_id='".$default_template['template_id']."',"
                ." template='".$default_template['template_file']."',admin_id='".$admin_id."',"
                ." store_url='".$url."',store_logo='/template/source/images/店铺.png',store_status=3,store_describe='',"
                ." store_sold=0,store_product=0,follow_count=0,free_fee=0");
            $this->GetDBMaster()->query("UPDATE ".TABLE_SHOP_APPLY." SET status=2,"
            ." shop_status=1,store_id='".$res."' WHERE id='".$this->data['id']."'");

            $store_info=array("url"=>$url,"store_id"=>$res,"template"=>$default_template['template_file'],
                "store_name"=>$data['shop_name']);
            $dom = new DOMDocument('1.0', 'utf8');
            $dom->formatOutput = true;
            $xbw = $dom->createElement('xbw');
            $dom->appendChild($xbw);
            $store_url = $dom->createElement('url');
            $xbw->appendChild($store_url);
            $text = $dom->createTextNode($store_info['store_url']);
            $store_url->appendChild($text);
            $store_id = $dom->createElement('store_id');
            $xbw->appendChild($store_id);
            $text = $dom->createTextNode($store_info['store_id']);
            $store_id->appendChild($text);
            $template = $dom->createElement('template');
            $xbw->appendChild($template);
            $text = $dom->createTextNode($store_info['template']);
            $template->appendChild($text);
            $store_name = $dom->createElement('store_name');
            $xbw->appendChild($store_name);
            $text = $dom->createTextNode($store_info['store_name']);
            $store_name->appendChild($text);
            $xml_file_path = RPC_DIR.'/shop/'.$url.'.xml';
            $dom->save($xml_file_path);
            $user = $this->GetUserInfo($data['userid']);
            $this->GetDBMaster()->SubmitTransaction();
            $array = array(
                'openid'=>$user['openid'],
                'url'=>WEBURL.'/'.$url,
                'store_name'=>$data['shop_name'],
                'date'=>date("Y-m-d H:i:s",time())
            );
            $this->SendApplySuccessNotice($array);
            return array('code'=>0,'msg'=>'操作成功');
        }catch(Exception $e)
        {
            $this->GetDBMaster()->RollbackTransaction();
            return array('code'=>1,'msg'=>$e->getMessage());
        }
    }
    //添加店铺
    function ActionAddStore()
    {
        if(!regExp::checkNULL($this->data['name']))
        {
            return array('code'=>1,'msg'=>'请输入真实姓名');
        }
        if(!regExp::checkNULL($this->data['shop_name']))
        {
            return array('code'=>1,'msg'=>'请输入店铺名称');
        }
        if(!regExp::checkNULL($this->data['phone']))
        {
            return array('code'=>1,'msg'=>'请输入联系电话');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_SHOP_APPLY." SET "
            ." name='".$this->data['name']."',phone='".$this->data['phone']."',"
            ." address='".$this->data['address']."',miaoshu='".$this->data['miaoshu']."',"
            ." userid=172,shop_name='".$this->data['shop_name']."',email='".$this->data['email']."',"
            ." password=123456,addtime='".date('Y-m-d H:i:s')."'");
        if(!empty($id))
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }


}