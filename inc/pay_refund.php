<?php
//退款
error_reporting(E_ALL);
ini_set('display_errors', '1');
class pay_refund extends common
{
    private $API = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
    private $appid = APPID;
    private $mchid = MCHID;    //商户id
    private $mchkey = KEY;   //商户key
    public $op_user_id = 0;
    function __construct($data)
    {
        parent::__construct($data);
    }

    public function request_refund($array)
    {
        $array = array(
            'appid'=>$this->appid,
            'mch_id'=>$this->mchid,
            'nonce_str'=>$this->getNonceStr(),
            'out_trade_no'=>$array['out_trade_no'],
            'out_refund_no'=>$array['out_refund_no'],
            'total_fee'=>$array['total_fee'],
            'refund_fee'=>$array['refund_fee'],
            'op_user_id'=>$this->op_user_id
        );
        $array['sign'] = $this->Sign($array);
        $res = $this->post($this->API,$this->gen_xml($array), true);
        $return = xmlToArray($res);
    }

    private function Sign($array){
        ksort($array);
        $beSign = array_filter($array, 'strlen');
        $pairs = array();
        foreach ($beSign as $k => $v)
        {
            $pairs[] = "$k=$v";
        }
        $sign_data = implode('&', $pairs);
        $sign_data.='&key='.$this->mchkey;
        return strtoupper(md5($sign_data));
    }



    private function gen_xml($params) {
        $xml = '<xml>';
        $fmt = '<%s><![CDATA[%s]]></%s>';
        foreach($params as $key=>$val){
            $xml.=sprintf($fmt, $key, $val, $key);
        }
        $xml.='</xml>';
        return $xml;
    }

    public function post($url, $strXml, $CA = true)
    {
        $SSL = substr($url, 0, 8) == "https://" ? true : false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($SSL && $CA) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
            curl_setopt($ch, CURLOPT_SSLCERT,RPC_DIR.'/pay/weixin/WxPayPubHelper/cert/apiclient_cert.pem');
            curl_setopt($ch, CURLOPT_SSLKEY,RPC_DIR.'/pay/weixin/WxPayPubHelper/cert/apiclient_key.pem');
            curl_setopt($ch, CURLOPT_CAINFO, RPC_DIR.'/pay/weixin/WxPayPubHelper/cert/rootca.pem'); // CA根证书（用来验证的网站证书是否是CA颁布）
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
        }else if ($SSL && !$CA) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $strXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    private function getNonceStr()
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $noceStr = "";
        for ($i = 0; $i < 32; $i++) {
            $noceStr .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $noceStr;
    }
}