<?php
class user extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    /*
     * 银行卡列表
     * */
    function GetBankCardList()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_BANK_CARD." WHERE "
            ." userid='".SYS_USERID."' ORDER BY id ASC");
    }


    /*
     * 隐藏卡号
     * */
    function GetCardTran($str)
    {
        $len = strlen($str);
        $tran_len = $len-4;
        $fuhao = '';
        for($i=0;$i<$tran_len;$i++)
        {
            $fuhao .= '*';
        }
        return str_replace(substr($str,0,$tran_len),$fuhao,$str);
    }



    //银行卡详情
    function GetBankDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $bank = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANK_CARD." WHERE "
            ." id='".$this->data['id']."' AND userid='".SYS_USERID."'");
        if(!$bank)
        {
            redirect(NOFOUND.'&msg=无此卡');
        }
        return $bank;
    }


    //统计订单数量
    function GetOrderStatusCount()
    {
        $total = $this->GetDBSlave1()->queryrows("SELECT orderid,order_status,addtime FROM ".TABLE_O_ORDER_SHOP." "
            ." WHERE userid='".SYS_USERID."' AND order_status<6 AND order_status>=0");
        $refund_total = $this->GetDBSlave1()->queryrow("SELECT count(*) as total FROM ".TABLE_O_ORDER_GOODS." "
            ." WHERE userid='".SYS_USERID."' AND goods_refund>0 AND goods_refund<3");
        $array = array(
            'not_pay'=>0,
            'seed_goods'=>0,
            'get_goods'=>0,
            'service'=>$refund_total['total']
        );
        if($total)
        {
            foreach($total as $item)
            {
                if($item['order_status']<3 && (strtotime($item['addtime'])+60 * 60 * 24)>time())
                {
                    $array['not_pay']++;
                }elseif($item['order_status']==3)
                {
                    $array['seed_goods']++;
                }elseif($item['order_status']==4)
                {
                    $array['get_goods']++;
                }
            }
        }
        //查询正在开团且未过期
        $group_total = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS group_count FROM "
            ." ".TABLE_GROUP."  ".
            "  WHERE group_status=1 "
            ." AND end_time>'".date("Y-m-d H:i:s",time())."' "
            ." AND userid='".SYS_USERID."'");
        $array['group_total'] = $group_total['group_count'];
        return $array;
    }


    //获取银行列表
    function GetBankList()
    {
        $label = array();
        $bank = array();
        $data =  $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_BANK." WHERE 1"
            ."  ORDER BY bank_initial,bank_sort ASC");
        if($data)
        {
            foreach($data as $item)
            {
                if(!in_array($item['bank_initial'],$label))
                {
                    $label[] = $item['bank_initial'];
                }
                $bank[$item['bank_initial']][] = $item;
            }
        }
        return array('bank'=>$bank,'label'=>$label);
    }


    function GetOneBank($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANK." WHERE "
            ." id='".$id."'");
    }

    //问题列表
    function GetQuestion()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_QUESTION." "
            ." WHERE is_show=0 ORDER BY ry_order ASC,id DESC");
    }

    //获取会员卡信息
    function GetVipCard()
    {
        return $this->GetDBSlave1()->queryrows("SELECT V.*,U.headimgurl,U.gift_balance FROM ".TABLE_VIP_CARD." AS V"
            ." LEFT JOIN ".TABLE_USER." AS U ON V.userid=U.userid"
            ." WHERE V.userid='".SYS_USERID."'");
    }

}