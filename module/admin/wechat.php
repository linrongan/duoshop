<?php
require_once RPC_DIR.'/pay/weixin/wechat_transfers.php';
class wechat extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    /**
     * 查询微信交易订单
     */
    function SelectWeChatTrans()
    {
        if(!regExp::checkNULL($this->data['out_trade_no']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = array(
            'out_trade_no'=>$this->data['out_trade_no']
        );
        $transfers = new transfers('https://api.mch.weixin.qq.com/pay/orderquery',$data);
        $res = $transfers->order_query();
        return $res;
    }
}