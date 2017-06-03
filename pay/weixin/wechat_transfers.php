<?php
class transfers extends common
{
    public $api;
    private $params = array();
    private $op_user_id = 1;
    function __construct($api,$params)
    {
        $this->api = $api;
        $this->params = $params;
    }



    //查询订单
    function order_query()
    {
        $array = array(
            'appid'=>APPID,
            'mch_id'=>MCHID,
            'out_trade_no'=>$this->params['out_trade_no'],
            'nonce_str'=>$this->createNoncestr()
        );
        $array['sign'] = $this->getSign($array);
        $xml = $this->arrayToXml($array);
        return xmlToArray(doCurlPostRequest($this->api,$xml));
    }


    //企业付款
    private function request_refund()
    {
        $array = array(
            'mch_appid'=>APPID,
            'mchid'=>MCHID,
            'nonce_str'=>$this->createNoncestr(),
            'partner_trade_no'=>$this->params['partner_trade_no'],
            'openid'=>$this->params['openid'],
            'check_name'=>$this->params['check_name'],
            'amount'=>$this->params['amount'],
            'desc'=>$this->params['desc'],
            'spbill_create_ip'=>$this->params['spbill_create_ip']
        );
        $array['sign'] = $this->getSign($array);
        $res = $this->post_ssl($this->api,$this->arrayToXml($array), true);
        return xmlToArray($res);
    }

    public function transfers($function)
    {
        return $this->$function();
    }

    /**
     * 	作用：生成签名
     */
    public function getSign($Obj)
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String."&key=".KEY;
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }

    /**
     * 	作用：格式化参数，签名过程需要使用
     */
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }

    /**
     * 	作用：产生随机字符串，不长于32位
     */
    public function createNoncestr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }



    /**
     * 	作用：array转xml
     */
    function arrayToXml($arr)
    {

        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if(is_array($val)){
                $xml.="<".$key.">".arrayToXml($val)."</".$key.">";
            }else{
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml ;
    }


    public function post_ssl($url, $strXml, $CA = true)
    {
        $SSL = substr($url, 0, 8) == "https://" ? true : false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($SSL && $CA) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSLCERT,RPC_DIR.'/pay/weixin/WxPayPubHelper/cert/apiclient_cert.pem');
            curl_setopt($ch, CURLOPT_SSLKEY,RPC_DIR.'/pay/weixin/WxPayPubHelper/cert/apiclient_key.pem');
            curl_setopt($ch, CURLOPT_CAINFO, RPC_DIR.'/pay/weixin/WxPayPubHelper/cert/rootca.pem');
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }else if ($SSL && !$CA) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $strXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }







}