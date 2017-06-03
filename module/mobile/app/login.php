<?php
class login extends common
{
    const appid = 'wxab0353b6e20fdab7';
    const secret = '71c1c9fd365a4578bee325df3034aadf';
    function __construct($data)
    {
        parent::__construct($data);
    }

    //获取openid
    function GetUserOpenid()
    {
        if(!regExp::checkNULL($this->data['code']))
        {
            return array('code'=>1,'msg'=>'no code');
        }
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.login::appid.'&secret='.login::secret
            .'&js_code='.$this->data['code'].'&grant_type=authorization_code';
        $result = json_decode(doCurlGetRequest($url),true);
        if(isset($result['errcode']))
        {
            return array('code'=>1,'err'=>$result['errmsg']);
        }
        $openid = $result['openid'];
        $session_key = $result['session_key'];
        //随机数
        $token = exec('head -n 80 /dev/urandom | tr -dc A-Za-z0-9 | head -c 168');
        $this->GetDBMaster()->query("UPDATE ".TABLE_TOKEN." SET "
            ." status=1 WHERE openid='".$openid."'");
        $this->GetDBMaster()->query("INSERT INTO ".TABLE_TOKEN." SET "
            ." token='".$token."',openid='".$openid."',session_key='".$session_key."',"
            ." addtime='".date("Y-m-d H:i:s",time())."',status=0");
        return array('code'=>0,'token'=>$token,'msg'=>'ok');
    }
}