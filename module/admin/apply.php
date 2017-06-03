<?php
class apply extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //审批列表
    function GetApplyList()
    {
        $where=$canshu="";
        $page_size = 20;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(A.addtime,10)>='".$this->data['start_date']."'";
            $canshu .='&start_date='.$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(A.addtime,10)<='".$this->data['end_date']."'";
            $canshu .='&end_date='.$this->data['end_date'];
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_SHOP_APPLY." AS A "
            ." LEFT JOIN ".TABLE_USER."  AS U ON A.userid=U.userid "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,U.nickname,U.headimgurl FROM ".TABLE_SHOP_APPLY." AS A "
            ." LEFT JOIN ".TABLE_USER." AS U ON A.userid=U.userid WHERE 1 "
            .$where." ORDER BY addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            "data"=>$data,
            "total"=>$count['total'],
            "curpage"=>$curpage,
            "page_size"=>$page_size,
            "canshu"=>$canshu
        );
    }
    //入驻详情
    function GetApplyDetail()
    {
        return $this->GetDBSlave1()->queryrow("SELECT A.*,U.nickname,U.headimgurl FROM ".TABLE_SHOP_APPLY." AS A "
            ." LEFT JOIN ".TABLE_USER." AS U ON A.userid=U.userid "
            ." WHERE id = '".$this->data['id']."'");
    }



    //发送审核通过消息
    function SendApplySuccessNotice($array)
    {
        $arr = array(
            'touser'=>$array['openid'],
            'template_id'=>'V3sCSGRVuCR-qE_CvIo-ya1i6iptShrGHFJxrb4r1iw',
            'url'=>$array['url'],
            'data'=>array(
                'first'=>array('value'=>'您好，您提交的门店已入驻成功','color'=>'#173177'),
                'keyword1'=>array('value'=>$array['store_name'],'color'=>'#173177'),
                'keyword2'=>array('value'=>$array['date'],'color'=>'#173177'),
                'remark'=>array('value'=>'点击进入门店','color'=>'#173177'),
            )
        );
        require_once RPC_DIR.'/module/common/common_wx.php';
        $wx = new wx($this->data);
        $access_token = $wx->Get_access_token();
        $res = json_decode(doCurlPostRequest('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.
            $access_token['access_token'],json_encode($arr),true),true);
        if($res['errcode'])
        {
            $this->AddLogAlert('入驻成功通知：',$array['store_name'].'发送失败err'.$res['errmsg']);
        }
    }
    //发送审核不通过消息
    function SendApplyFailNotice($array)
    {
        $arr = array(
            'touser'=>$array['openid'],
            //'url'=>'?mod=apply&_index=_shop_edit',
            'template_id'=>'BiiPbcZ0QzuTaJpg0CQ1f7OoguocbQI-ev5Kkyst5Hc',
            'data'=>array(
                'first'=>array('value'=>'您好，您提交的门店申请失败','color'=>'#173177'),
                'keyword1'=>array('value'=>$array['text'],'color'=>'#173177'),
                'keyword2'=>array('value'=>$array['admin'],'color'=>'#173177'),
                'remark'=>array('value'=>'点击修改入驻信息','color'=>'#173177'),
            )
        );
        require_once RPC_DIR.'/module/common/common_wx.php';
        $wx = new wx($this->data);
        $access_token = $wx->Get_access_token();
        $res = json_decode(doCurlPostRequest('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.
            $access_token['access_token'],json_encode($arr),true),true);
        if($res['errcode'])
        {
            $this->AddLogAlert('入驻失败通知：',$array['store_name'].'发送失败err'.$res['errmsg']);
        }
    }

}