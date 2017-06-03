<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

Class shop extends comm
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //店铺模板
    function GetStoreTemplate()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_STORE_TEMPLATE." WHERE "
            ." store_id='".$_SESSION['admin_store_id']."'");
        return $data;
    }


    //店铺信息
    function GetStoreInfo()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." WHERE admin_id='".$_SESSION['admin_id']."'");
    }


    //模板列表
    function GetShopTemplate()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_COMM_TEMPLATE." WHERE 1 ".$where." "
            ." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_TEMPLATE." WHERE 1 ".$where." "
            ." ORDER BY template_sort ASC,template_id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }


    //预览模板
    function GetTemplatePhoto()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $template = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_TEMPLATE." WHERE template_id='".$this->data['id']."'");
        if(empty($template))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $array = array(
            'title'=>'banner',
            'id'=>1,
            'start'=>0,
            'data'=>array()
        );
        if(!empty($template['template_preview']))
        {
            $template_preview = json_decode($template['template_preview']);
            for($i=0;$i<count($template_preview);$i++)
            {
                $array['data'][$i]['alt'] = $template['template_name'];
                $array['data'][$i]['pid'] = $i;
                $array['data'][$i]['src'] = $template_preview[$i];
                $array['data'][$i]['thumb'] = $template_preview[$i];
            }
        }
        return $array;
    }

    //获取当前用户信息
    public function getUserInfo()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADMIN." WHERE admin_id='".$_SESSION['admin_id']."'");
    }
    //店铺banner
    public function getShopCommAD($typeid=0)
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_AD." WHERE ad_type='".$typeid."' AND store_id='".$_SESSION['admin_store_id']."'"
            ." ORDER BY ry_order ASC");
    }
    //一条店铺banner
    public function GetOneShopCommAD($typeid=0)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_AD." WHERE ad_type='".$typeid."' AND id='".$this->data['id']."' AND store_id='".$_SESSION['admin_store_id']."'");
    }


    //查询可提现的金额
    function GetShopSumMoney()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT SUM(fee_money) AS total_money FROM ".TABLE_COMM_FEE." WHERE "
            ." is_valid=0 AND fee_type IN(SELECT type_id FROM ".TABLE_FEE_TYPE." WHERE "
            ." merchat_balance_type=3) AND store_id='".$_SESSION['admin_store_id']."'");
        if(empty($data['total_money']))
        {
            $data['total_money'] = 0;
        }
        return $data;
    }






    //商家提现记录
    function GetShopOutMoneyList()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['start_date']) && !empty($this->data['start_date']))
        {
            $where .= " AND LEFT(SW.addtime,10)>='".$this->data['start_date']."'";
            $param .= "&start_date=".$this->data['start_date'];
        }
        if(isset($this->data['end_date']) && !empty($this->data['end_date']))
        {
            $where .= " AND LEFT(SW.addtime,10)<='".$this->data['end_date']."'";
            $param .= "&end_date=".$this->data['end_date'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_SHOP_WITHDRAWALS." AS "
            ."SW LEFT JOIN ".TABLE_COMM_STORE." AS CS ON SW.store_id=CS.store_id WHERE SW.store_id='".$_SESSION['admin_store_id']."' "
            ."".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT SW.*,CS.store_logo,CS.store_name FROM ".TABLE_SHOP_WITHDRAWALS." "
            ."AS SW LEFT JOIN ".TABLE_COMM_STORE." AS CS ON SW.store_id=CS.store_id WHERE SW.store_id='".$_SESSION['admin_store_id']."' "
            ."".$where." ORDER BY id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }
}