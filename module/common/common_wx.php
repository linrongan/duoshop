<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class wx extends common
{
    //获取指定用户的用户信息
    function Get_UserInfo($openid)
    {
        $data=$this->Get_access_token();
        if ($data['code']==1){
            return array("code"=>1,"msg"=>$data['msg']);
        }
        $para = array(
            "access_token" => $data['access_token'],
            "openid" => $openid,
            "lang"=>"zh_CN"
        );
        $url = "https://api.weixin.qq.com/cgi-bin/user/info";
        $ret=doCurlGetRequest($url, $para);
        $w_user = json_decode($ret,true);
        if (empty($w_user))
        {
            return array("code"=>1,"msg"=>"获取用户信息错误");
        }
        if ($w_user['subscribe']==1)
        {
            $user=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." "
                ." WHERE openid='".$openid."'");
            if (empty($user))
            {
                //限制在公众号内黑名单的。
                //判断是否带参数
                //redirect(NOFOUND.'&msg=系统装修中，期待中');
                $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_USER." "
                    ."(openid,subscribe,nickname,sex,city,country,province,language,"
                    ."headimgurl,subscribe_time,remark,addtime,parent_id,user_point)"
                    ."VALUES('".$openid."',"
                    ."'".$w_user['subscribe']."',"
                    ."'".$w_user['nickname']."',"
                    ."'".$w_user['sex']."',"
                    ."'".$w_user['city']."',"
                    ."'".$w_user['country']."',"
                    ."'".$w_user['province']."',"
                    ."'".$w_user['language']."',"
                    ."'".$w_user['headimgurl']."',"
                    ."'".$w_user['subscribe_time']."',"
                    ."'".$w_user['remark']."',"
                    ."'".date("Y-m-d H:i:s")."',0,0)");
                if ($id)
                {
                    $_SESSION['userid']=$id;
                }else
                {
                    return array("code"=>1,"msg"=>"系统执行异常");
                }
            }else
            {
                if ($user['status']==1)
                {
                    redirect(NOFOUND.'&msg=抱歉~暂时还没有开放，谢谢您的关注！');
                }
                $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
                    ." nickname='".addslashes($w_user['nickname'])."',"
                    ." headimgurl='".$w_user['headimgurl']."',"
                    ." province='".$w_user['province']."',"
                    ." country='".$w_user['country']."',"
                    ." city='".$w_user['city']."',"
                    ." subscribe='".$w_user['subscribe']."',"
                    ." subscribe_time='".$w_user['subscribe_time']."',"
                    ." remark='".$w_user['remark']."',"
                    ." sex='".$w_user['sex']."',"
                    ." language='".$w_user['language']."'"
                    ." WHERE openid='".$openid."'");
                $_SESSION['userid']=$user['userid'];
                $_SESSION['level'] = $user['user_level'];
            }
            $_SESSION['openid']=$openid;
            return array("code"=>0,"msg"=>"微信授权成功");
        }else
        {
            //未订阅
            redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&"
                ."redirect_uri=".urlencode(WEBURL."/?mod=auth&_auth=snsapi_userinfo&url=".$_SESSION['backurl'])."&"
                ."response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect");
        }
    }

    //获取指定用户的用户信息--未关注用户授权
    function GetUserInfoNOSubscribe($openid,$access_token)
    {
        $para = array(
            "access_token" => $access_token,
            "openid" => $openid,
            "lang"=>"zh_CN"
        );
        $url = "https://api.weixin.qq.com/sns/userinfo";
        $ret=doCurlGetRequest($url, $para);
        $w_user = json_decode($ret,true);
        if (empty($w_user) || (isset($w_user['errcode']) && $w_user['errcode']>0))
        {
            return array("code"=>1,"msg"=>"获取用户信息错误".$w_user['errcode'],"errcode"=>$w_user['errcode']);
        }

        $user=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." "
            ." WHERE openid='".$openid."'");
        if (empty($user))
        {
            //redirect(NOFOUND.'&msg=系统装修中，期待中');
            //判断是否带参数
            $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_USER." "
                ."(openid,subscribe,nickname,sex,city,country,province,language,"
                ."headimgurl,subscribe_time,remark,addtime,parent_id,user_point)"
                ."VALUES('".$openid."',"
                ."'".$w_user['subscribe']."',"
                ."'".$w_user['nickname']."',"
                ."'".$w_user['sex']."',"
                ."'".$w_user['city']."',"
                ."'".$w_user['country']."',"
                ."'".$w_user['province']."',"
                ."'".$w_user['language']."',"
                ."'".$w_user['headimgurl']."',"
                ."'".$w_user['subscribe_time']."',"
                ."'".$w_user['remark']."',"
                ."'".date("Y-m-d H:i:s")."',0,0)");
            if ($id)
            {
                $_SESSION['userid']=$id;
            }else
            {
                return array("code"=>1,"msg"=>"系统执行异常");
            }
        }else
        {
            if ($user['status']==1)
            {
                redirect(NOFOUND.'&msg=抱歉~暂时还没有开放，谢谢您的关注！');
            }
            $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
                ." nickname='".addslashes($w_user['nickname'])."',"
                ." headimgurl='".$w_user['headimgurl']."',"
                ." province='".$w_user['province']."',"
                ." country='".$w_user['country']."',"
                ." city='".$w_user['city']."',"
                ." subscribe='".$w_user['subscribe']."',"
                ." subscribe_time='".$w_user['subscribe_time']."',"
                ." remark='".$w_user['remark']."',"
                ." sex='".$w_user['sex']."',"
                ." language='".$w_user['language']."'"
                ." WHERE openid='".$openid."'");
            $_SESSION['userid']=$user['userid'];
        }
        $_SESSION['openid']=$openid;
        return array("code"=>0,"msg"=>"微信授权成功");
    }

    //获取access_token
    function Get_access_token()
    {
        $data=$this->GetMerchant();
        if (empty($data))
        {
            return array("code"=>1,"msg"=>'错误的商户信息');
        }
        //检查一下数据库中最access_token是否过期
        $token = $data['access_token'];
        $expire =$data['expire'];
        $addTimestamp = $data['addtimestamp'];
        $current = time();
        if($addTimestamp + $expire - 30 > $current){
            //有效的
            return array("code"=>0,"access_token"=>$token);
        }else{
            //过期了重新来生成
            $para = array(
                'grant_type'=>'client_credential',
                'appid'=>APPID,
                'secret'=>APPSECRET,
            );
            $url = 'https://api.weixin.qq.com/cgi-bin/token';
            $ret = doCurlGetRequest($url, $para);
            $retData = json_decode($ret, true);
            if(empty($retData) || (isset($retData['errcode']) && $retData['errcode']>0))
            {
                //错误报告
                return array("code"=>1,"msg"=>'获取失败,错误代码：'.$retData['errcode']);
            }
            $token = $retData['access_token'];
            $addtimestamp=time();
            $this->GetDBMaster()->query("UPDATE ".TABLE_MERCHANT." "
                ." SET access_token='".$token."',"
                ." addtimestamp='".$addtimestamp."'"
                ." WHERE id=1");
            return array("code"=>0,"access_token"=>$token);
        }
    }

    //重置授权码
    function Reload_Access_Token()
    {
        $data=$this->GetMerchant();
        if (empty($data))
        {
            return array("code"=>1,"msg"=>'错误的商户信息');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_MERCHANT."  "
            ." SET addtimestamp=0"
            ." WHERE id=1");
        return $this->Get_access_token();
    }

    //发送模板消息
    function SentTemplateMsg($array=array())
    {
        if (empty($array))
        {
            return array("code"=>1,"msg"=>"无发送参数");
        }
        $access_token = $this->Get_access_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token['access_token'];
        $return=json_decode(doCurlPostRequest($url,json_encode($array)),true);
        if ($return['errcode']>0)
        {
            $this->AddLogAlert("模板消息发送结果",json_encode($return).json_encode($array));
        }
    }

    //获取公众号信息
    public function GetMerchant()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_MERCHANT." WHERE id=1");
    }

    //将微信资源下载回来
    public function LocalSaveFile($serverId='')
    {
        if(empty($serverId))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $access_token=$this->Get_access_token();
        $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token['access_token']."&media_id=".$serverId."";
        $res=doCurlGetRequest($url);
        if (!empty($res))
        {
            $name = md5(date("YmdHis").rand(5000,9999));
            $file=SAVE_IMG_LARGER.$name.'.jpg';
            //创建并写入数据流，然后保存文件
            if (@$fp=fopen(RPC_DIR.$file,'w+'))
            {
                exec("chmod 777 ".RPC_DIR.$file);
                if ($fp)
                {
                    if(fwrite($fp,$res) == false)
                    {
                        return array('code'=>1,'msg'=>'图片存储失败');
                    }
                    fclose($fp);
                }
                if (is_file(RPC_DIR.$file))
                {
                    $path = WEBURL.$file;
                    return array('code'=>0,'msg'=>'success','file'=>$path);
                }
            }
            return array('code'=>1,'msg'=>'目录无可写权限');
        }
    }

    //检查验证码
    function CheckSmsCode($type_id='',$smscode='')
    {
        $log=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_LOG_SMS."  "
            ." WHERE userid='".$_SESSION['userid']."' "
            ." AND code='".$smscode."' "
            ." AND type_id='".$type_id."'"
            ." AND addtime>'".date("Y-m-d H:i:s",(time()-600))."'");
        if (empty($log))
        {
            return false;
        }
        return true;
    }

    //获取指定用户的基本信息
    protected function GetUserWxDetail($userid=0)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER."  "
            ." WHERE userid='".$userid."'");
        return $data;
    }

    //获取店铺信息
    function GetStore($type=0,$id=0)
    {
        if ($type==0)
        {
            $data= $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." WHERE store_url='".$this->data['v_shop']."'");
        }else
        {
            $data= $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." WHERE store_id='".$id."'");
        }
        if (empty($data))
        {
            redirect(NOFOUND."&msg=店铺不存在");
        }
        return $data;
    }

    //获取店铺信息
    protected function GetStoreId()
    {
        $data=$this->GetStore(0);
        return $data['store_id'];
    }



    //获取网站设置
    public function GetWebConf($key)
    {
        $conf_type = array(1=>'conf_val',2=>'conf_number',3=>'conf_text',4=>'conf_money',5=>'conf_img');
        if(is_array($key))
        {
            $where ='';
            foreach ($key as $k=>$v)
            {
                $where .= "'$v'".',';
            }
            $where .= rtrim($where,',');
            $conf = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CONF." WHERE "
                ."  conf_key IN(".$where.")");
            $conf_arr = array();
            if($conf)
            {
                foreach($conf as $v)
                {
                    $conf_arr[$v['conf_key']] = $v[$conf_type[$v['conf_type']]];
                }
                return $conf_arr;
            }
        }else{
            $conf = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CONF." WHERE "
                ." conf_key='".$key."'");
            if($conf)
            {
                return $conf[$conf_type[$conf['conf_type']]];
            }
        }
    }
}
?>