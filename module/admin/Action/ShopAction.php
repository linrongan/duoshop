<?php
class ShopAction extends shop
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //更换模板
    function ActionChangeTemplate()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_STORE_TEMPLATE." WHERE "
            ." store_id='".$_SESSION['admin_store_id']."' AND template_id='".$this->data['id']."'");
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'没有找到此模板');
        }
        if($data['template_use'])
        {
            return array('code'=>1,'msg'=>'模板正在使用中...');
        }
        $this->GetDBMaster()->StartTransaction();
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_STORE_TEMPLATE." SET template_use=1 "
            ." WHERE template_id='".$this->data['id']."' AND store_id='".$_SESSION['admin_store_id']."'");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_STORE_TEMPLATE." SET template_use=0"
            ." WHERE store_id='".$_SESSION['admin_store_id']."' AND template_id<>'".$this->data['id']."'");
        $res3 = $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_STORE." SET template_id='".$this->data['id']."' "
            ." WHERE admin_id='".$_SESSION['admin_id']."'");
       if($res1 && $res2 && $res3)
       {
           $this->GetDBMaster()->SubmitTransaction();
           return array('code'=>0,'msg'=>'模板更换成功');
       }
        $this->GetDBMaster()->RollbackTransaction();
       return array('code'=>1,'msg'=>'模板更换失败');
    }


    //编辑店铺信息
    function ActionEditStoreInfo()
    {
        if(!regExp::checkNULL($this->data['store_name']))
        {
            return array('code'=>1,'msg'=>'名称不能为空');
        }
        if(!regExp::checkNULL($this->data['store_logo']))
        {
            return array('code'=>1,'msg'=>'logo不能为空');
        }
        if(!regExp::checkNULL($this->data['store_url']))
        {
            return array('code'=>1,'msg'=>'店铺地址不能为空');
        }
        $check = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." WHERE "
            ." store_id!='".trim($_SESSION['admin_store_id'])."' AND (store_name='".$this->data['store_name']."' "
            ." OR store_url='".$this->data['store_url']."')");
        if($check)
        {
            return array('code'=>1,'msg'=>'店铺名重复或链接错误');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_STORE." SET store_name='".$this->data['store_name']."',"
            ." store_logo='".$this->data['store_logo']."',store_describe='".$this->data['store_describe']."', "
            ." free_fee='".$this->data['free_fee']."',free_fee_money='".$this->data['free_fee_money']."',"
            ." store_url='".$this->data['store_url']."',"
            ." store_qq='".$this->data['store_qq']."',"
            ." ship_fee_money='".$this->data['ship_fee_money']."',product_ship_fee='".$this->data['product_ship_fee']."'"
            ." WHERE store_id='".$_SESSION['admin_store_id']."'");
        $this->ActionUpdXmlInfo();
        return array('code'=>0,'msg'=>'修改成功');
    }

    function ActionUpdXmlInfo()
    {
        $store_info = $this->GetStoreInfo();
        $Dir = RPC_DIR.'/shop/';    //存放目录
        $file_path = $Dir.$store_info['store_url'].'.xml';
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

        $dom->save($file_path);
    }

    //修改密码
    function ActionModifyPassword()
    {
        if(!regExp::checkNULL($this->data['pass']))
        {
            return array('code'=>1,'msg'=>'新密码不能为空');
        }
        if(!regExp::checkNULL($this->data['password']))
        {
            return array('code'=>1,'msg'=>'新密码不能为空');
        }
        $user = $this->getUserInfo();
        if(MD5($this->data['pass'].APISECRET)!=$user['admin_pwd'])
        {
            return array('code'=>1,'msg'=>'原密码错误，请重新输入');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN." "
            ." SET admin_pwd='".MD5($this->data['password'].APISECRET)."'"
            ." WHERE admin_id='".$_SESSION['admin_id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }

    //修改店铺banner
    function ActionEditShopBanner()
    {
        if(!regExp::checkNULL($this->data['img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        if(!regExp::checkNULL($this->data['title']))
        {
            return array('code'=>1,'msg'=>'标题不能为空');
        }
        $img = $this->GetOneShopCommAD($this->data['type']);
        if(!$img)
        {
            return array('code'=>1,'msg'=>'数据不存在或已删除');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_AD." "
            ." SET title='".$this->data['title']."',"
            ." page_url='".$this->data['page_url']."',"
            ." ry_order='".$this->data['ry_order']."',"
            ." img='".$this->data['img']."'"
            ." WHERE ad_type='".$this->data['type']."' "
            ." AND id='".$this->data['id']."' "
            ." AND store_id='".$_SESSION['admin_store_id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }

    //添加banner
    function ActionAddShopBanner()
    {
        if(!regExp::checkNULL($this->data['img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        if(!regExp::checkNULL($this->data['title']))
        {
            return array('code'=>1,'msg'=>'标题不能为空');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COMM_AD." (ad_type,"
            ."img,page_url,title,ry_order,store_id)VALUES('".$this->data['type']."',"
            ."'".$this->data['img']."','".$this->data['page_url']."',"
            ."'".$this->data['title']."','".$this->data['ry_order']."','"
            .$_SESSION['admin_store_id']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }return array('code'=>1,'msg'=>'添加失败');
    }

    //删除banner
    function ActionDelShopBanner()
    {
        $data = $this->GetOneShopCommAD($this->data['type']);
        if(!$data)
        {
            return array('code'=>1,'msg'=>'数据不存');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_COMM_AD." WHERE store_id='".$_SESSION['admin_store_id']."' AND id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }


    function ActionAddMoneyOut()
    {
        if(!isset($this->data['submit']))
        {
            return;
        }
        $money = $this->GetShopSumMoney();
        if($money['total_money']<=100)
        {
            return array('code'=>1,'msg'=>'最低提现不能低于100元');
        }
        if(!regExp::checkNULL($this->data['username']))
        {
            return array('code'=>1,'msg'=>'请输入姓名');
        }
        if(!regExp::checkNULL($this->data['phone']))
        {
            return array('code'=>1,'msg'=>'请输入手机');
        }
        if(!regExp::checkNULL($this->data['bank']))
        {
            return array('code'=>1,'msg'=>'请选择银行');
        }
        if(!regExp::checkNULL($this->data['bank_card']))
        {
            return array('code'=>1,'msg'=>'请输入银行卡号');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_FEE." SET is_valid=1"
            ." WHERE is_valid=0 AND fee_type IN(SELECT type_id FROM ".TABLE_FEE_TYPE." WHERE "
            ." merchat_balance_type=3) AND store_id='".$_SESSION['admin_store_id']."'");
        $res1 = $this->GetDBMaster()->query("INSERT INTO ".TABLE_SHOP_WITHDRAWALS." "
            ."(store_id,money,username,phone,bank,bank_card,remark,addtime) "
            ."VALUES('".$_SESSION['admin_store_id']."','".$money['total_money']."',"
            ."'".$this->data['username']."','".$this->data['phone']."',"
            ."'".$this->data['bank']."','".$this->data['bank_card']."',"
            ."'".$this->data['remark']."','".date("Y-m-d H:i:s",time())."')");
        if($res && $res1)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'操作成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'操作失败');
    }
}