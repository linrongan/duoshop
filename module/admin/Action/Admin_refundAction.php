<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_refundAction extends admin_refund
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //添加退款原因
    function ActionAddRefundCause()
    {
        if( !regExp::checkNULL($this->data['refund_title']) ||
            !regExp::checkNULL($this->data['type_id']) )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_REFUND_CAUSE." (refund_title,"
            ."refund_sort,type_id,addtime) VALUES('".$this->data['refund_title']."',"
            ."'".$this->data['refund_sort']."',"
            ."'".$this->data['type_id']."',"
            ."'".date('Y-m-d H:i:s')."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }



    //编辑退款原因
    function ActionEditRefundCause()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if( !regExp::checkNULL($this->data['refund_title']) ||
            !regExp::checkNULL($this->data['type_id']) )
        {
            return array('code'=>1,'msg'=>'必要信息都要填写');
        }
        $data = $this->GetRefundCauseDetail();
        if(!$data)
        {
            return array('code'=>1,'msg'=>'记录不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND_CAUSE." SET "
            ." refund_title='".$this->data['refund_title']."',"
            ." refund_sort='".$this->data['refund_sort']."',"
            ." type_id='".$this->data['type_id']."'"
            ." WHERE id = '".$this->data['id']."' "
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
    //删除退款原因
    function ActionDelRefundCause()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetRefundCauseDetail();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }

        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_REFUND_CAUSE." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }


    //处理申请
    function ActionRegApply()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'缺少关键参数');
        }
        $refund_data = $this->GetOneRefund(intval($this->data['id']));
        if($refund_data['refund_status']!=0)
        {
            return array('code'=>1,'msg'=>'退款单状态错误');
        }
        $status = array(2,3,6);
        if(!isset($this->data['refund_status']) || empty($this->data['refund_status']) ||
            !in_array($this->data['refund_status'],$status))
        {
            return array('code'=>1,'msg'=>'未识别参数');
        }
        $this->GetDBMaster()->StartTransaction();
        //更新状态
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND_APPLY." SET "
            ." refund_status='".$this->data['refund_status']."',"
            ." refund_operator_name='".$_SESSION['admin_name']."',"
            ." refund_operator_id='".$_SESSION['admin_id']."' "
            ." WHERE id='".$this->data['id']."'");
        if($this->data['refund_status']==2 || $this->data['refund_status']==6)
        {
            $goods_refund_status = 5;
        }else{
            $goods_refund_status = 2;
        }
        if($refund_data['refund_type_id']==1)
        {
            $title = '等待处理';
        }else{
            $title = '请回馈您的退款物流信息';
        }
       if($goods_refund_status == 2)
       {
           /*--------发送模板消息 start------ */
           require_once RPC_DIR.'/module/common/common_wx.php';
           $wx = new wx('');
           $access_token = $wx->Get_access_token();
           $api = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token['access_token'];
           $_template = array(
               'touser'=>$refund_data['openid'],
               'template_id'=>'90iWUruvz01b_dYq3H4CcxzEmyrcysbi-EGcjicBqH8',
               'url'=>WEBURL.'/?mod=weixin&v_mod=order&_index=_refund_details&goods_id='.$refund_data['goods_id'],
               'data'=>array(
                   'first'=>array('value'=>'您的退款申请已经通过了','color'=>'#173177'),
                   'keyword1'=>array('value'=>$refund_data['refund_money'],'color'=>'#173177'),
                   'keyword2'=>array('value'=>$refund_data['refund_product_name'],'color'=>'#173177'),
                   'keyword3'=>array('value'=>$refund_data['refund_orderid'],'color'=>'#173177'),
                   'remark'=>array('value'=>$title,'color'=>'#173177')
               )
           );
           doCurlPostRequest($api,json_encode($_template,true));
           /*--------发送模板消息 end------ */
       }
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_GOODS." SET "
            ." goods_refund=".$goods_refund_status." WHERE id='".$refund_data['goods_id']."'");
        if($res1 && $res2)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'操作成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'操作失败 刷新再试');
    }


    //开始退款
    function ActionStartRefund()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'error');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT RA.*,U.openid FROM ".TABLE_REFUND_APPLY." as RA "
            ." LEFT JOIN ".TABLE_USER." AS U ON RA.refund_userid=U.userid WHERE "
            ." RA.id='".$this->data['id']."'");
        if(!$data)
        {
            return array('code'=>1,'msg'=>'退款不存在或退款订单不存在');
        }elseif($data['refund_is_valid'])
        {
            return array('code'=>1,'msg'=>'退款申请无效');
        }elseif($data['refund_status']<3 || $data['refund_status']>4)
        {
            return array('code'=>1,'msg'=>'状态错误');
        }
        $refund_trans_type = $data['refund_order_pay_method'];
        //订单的产品笔数
        $shop_pro_arr = $this->GetDBSlave1()->queryrows("SELECT id,goods_refund FROM ".TABLE_O_ORDER_GOODS." "
            ." WHERE orderid='".$data['refund_orderid']."'");
        $refund_count = 0;
        foreach($shop_pro_arr as $v)
        {
            if($v['goods_refund']==3)
            {
                $refund_count ++;
            }
        }
        $this->GetDBMaster()->StartTransaction();
        if($refund_count+1 == count($shop_pro_arr))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET "
                ." order_status=-1 WHERE orderid='".$data['refund_orderid']."'");
        }
        if($refund_trans_type=='user_money')
        {
            $success_method_title = '余额';
            $res = $this->ActionRefundUserMoney($data);
        }else{
            $success_method_title = '付款账户';
            $res = $this->ActionRefundWeChat($data);
        }
        if($res['code']==0)
        {
            $this->GetDBMaster()->SubmitTransaction();
            /*--------发送模板消息 start------ */
            require_once RPC_DIR.'/module/common/common_wx.php';
            $wx = new wx('');
            $access_token = $wx->Get_access_token();
            $api = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token['access_token'];
            $_template = array(
                'touser'=>$data['openid'],
                'template_id'=>'9_utWhnxpvtHSeIavHGZrVQq0kHV01JkarrcpksModA',
                'url'=>WEBURL.'/?mod=weixin&v_mod=order&_index=_refund_details&goods_id='.$data['goods_id'],
                'data'=>array(
                    'first'=>array('value'=>'您的订单已经完成退款，¥'.$data['refund_money'].'已经退回您的'.$success_method_title,'color'=>'#173177'),
                    'orderProductPrice'=>array('value'=>'￥'.$data['refund_money'],'color'=>'#173177'),
                    'orderProductName'=>array('value'=>$data['refund_product_name'],'color'=>'#173177'),
                    'orderName'=>array('value'=>$data['refund_orderid'],'color'=>'#173177'),
                    'remark'=>array('value'=>'请留意查收','color'=>'#173177')
                )
            );
            doCurlPostRequest($api,json_encode($_template,true));
            /*--------发送模板消息 end------ */
            return array('code'=>0,'msg'=>'退款成功');
        }else{
            $this->GetDBMaster()->RollbackTransaction();
            return array('code'=>1,'msg'=>'退款失败');
        }
    }



    //退款到余额
    private function ActionRefundUserMoney($data)
    {
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND_APPLY." SET "
            ." refund_status=5,refund_confirm_date='".date("Y-m-d H:i:s",time())."' "
            ." WHERE id='".$data['id']."'");
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_GOODS." SET "
            ." goods_refund=3 WHERE id='".$data['goods_id']."'");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
            ." user_money=user_money+'".$data['refund_money']."' "
            ." WHERE userid='".$data['refund_userid']."'");
        $res3 = $this->GetDBMaster()->query("INSERT INTO ".TABLE_BALANCE_DETAILS." ".
            " SET trans_terrace_orderid='".$data['refund_trans_orderid']."',"
            ." trans_title='订单退款',trans_type=1,"
            ." trans_money='".$data['refund_money']."',"
            ." trans_wx_orderid='',"
            ." trans_userid='".$data['refund_userid']."',"
            ." trans_addtime='".date("Y-m-d H:i:s",time())."'");
        $res4 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET "
            ." refund_money=refund_money+'".$data['refund_money']."' WHERE "
            ." orderid='".$data['refund_orderid']."' AND shop_id='".$data['refund_order_store_id']."'");
        $_fee_array=array(
            "fee_type"=>9,
            "fee_money"=>$data['refund_money'],
            'balance_type'=>5,
            "title"=>'售后退款',
            "beizhu"=>'余额退款',
            "transaction_id"=>0,
            "orderid"=>$data['refund_orderid'],
            "userid"=>$data['refund_userid'],
            "adminid"=>0,
            "pay_type"=>1,
            "store_id"=>$data['refund_order_store_id']
        );
        $res5 = $this->AddCommFee($_fee_array);
        if($res && $res1 && $res2 && $res3 && $res4 && $res5)
        {
            return array('code'=>0);
        }
        return array('code'=>1,'error'=>'退款失败');
    }

    //退款到微信
    private function ActionRefundWeChat($data)
    {
        require_once RPC_DIR.'/pay/weixin/wechat_refund.php';
        $refund = new WeChat_Refund('OrderRefund','订单退款');
        //更新状态
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND_APPLY." SET "
            ." refund_status=5,refund_confirm_date='".date("Y-m-d H:i:s",time())."' "
            ." WHERE id='".$data['id']."'");
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_GOODS." SET "
            ." goods_refund=3 WHERE id='".$data['goods_id']."'");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_SHOP." SET "
            ." refund_money=refund_money+'".$data['refund_money']."' WHERE "
            ." orderid='".$data['refund_orderid']."' AND shop_id='".$data['refund_order_store_id']."'");
        $_fee_array=array(
            "fee_type"=>9,
            "fee_money"=>$data['refund_orderid'],
            'balance_type'=>5,
            "title"=>'售后退款',
            "beizhu"=>'微信退款',
            "transaction_id"=>0,
            "orderid"=>$data['refund_orderid'],
            "userid"=>$data['refund_userid'],
            "adminid"=>0,
            "pay_type"=>1,
            "store_id"=>$data['refund_order_store_id']
        );
        $res3 = $this->AddCommFee($_fee_array);
        $array = array(
            'out_trade_no'=>$data['refund_trans_orderid'],
            'total_fee'=>$data['refund_trans_money'],
            'refund_fee'=>$data['refund_money'],
            'op_user_id'=>$data['refund_orderid']
        );
        $refund_result = $refund->init($array);
        if($res && $res1 && $res2 && $res3 && $refund_result['code']==0)
        {
            return array('code'=>0,'msg'=>'ok');
        }
        return array('code'=>1,'msg'=>'退款失败');
    }


    //撤销退款  撤销后可重新退款
    function ActionCpanelRefund()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'error');
        }
        $data = $this->GetOneRefund($this->data['id']);
        if(!$data)
        {
            return array('code'=>1,'msg'=>'数据不存在或已删除');
        }elseif($data['refund_is_valid'])
        {
            return array('code'=>1,'msg'=>'退款单已失效');
        }elseif($data['refund_status']>=5)
        {
            return array('code'=>1,'msg'=>'无法撤销');
        }

        $this->GetDBMaster()->StartTransaction();
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_REFUND_APPLY." SET "
            ." refund_status=-1,refund_is_valid=1 "
            ." WHERE id='".$data['id']."'");
        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_O_ORDER_GOODS." SET "
            ." goods_refund=0 WHERE id='".$data['goods_id']."'");
        if($res1 && $res2)
        {
            $this->GetDBMaster()->SubmitTransaction();
            /*--------发送模板消息 start------ */
            require_once RPC_DIR.'/module/common/common_wx.php';
            $wx = new wx('');
            $access_token = $wx->Get_access_token();
            $api = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token['access_token'];
            $_template = array(
                'touser'=>$data['openid'],
                'template_id'=>'7reXI33Ye4DrMBS_a2StGUVpev4Y3337oQBcVG1gNM8',
                'url'=>WEBURL.'/?mod=weixin&v_mod=order',
                'data'=>array(
                    'first'=>array('value'=>'您的退款/售后申请已被撤回 有效期内可重新申请','color'=>'#173177'),
                    'keyword1'=>array('value'=>$data['refund_orderid'],'color'=>'#173177'),
                    'keyword2'=>array('value'=>$data['apply_date'],'color'=>'#173177'),
                    'keyword3'=>array('value'=>$data['refund_product_name'],'color'=>'#173177'),
                    'remark'=>array('value'=>'...','color'=>'#173177')
                )
            );
            doCurlPostRequest($api,json_encode($_template,true));
            /*--------发送模板消息 end------ */
            return array('code'=>0,'msg'=>'撤销成功');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'撤销失败');
    }
}