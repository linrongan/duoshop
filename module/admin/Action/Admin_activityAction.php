<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class Admin_activityAction extends admin_activity
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //管理员删除优惠卷
    public function ActionDelCoupon()
    {
        if(!regExp::checkNULL($this->data['id'])){
            return array('code'=>1,'msg'=>'参数错误');
        }
        //是否存在该订单
        $data = $this->getOneCoupon();
        if(!$data)
        {
            return array('code'=>1,'msg'=>'订单不存在');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_COUPON." WHERE id='".$this->data['id']."'");
        if($res)
        {
            //插入日志
            $key = "管理员:(".$_SESSION['admin_id'].")";
            $value = "删除优惠卷".$data['userid']."/".$data['coupon_name'];
            $this->AddLogAlert($key,$value);
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }
    //添加营销规则
    function ActionAddCouponType()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['coupon_money']) ||
            !regExp::checkNULL($this->data['coupon_money']) ||
            !regExp::checkNULL($this->data['min_money']) )
        {
            return array('code'=>1,'msg'=>'必填内容需要填写');
        }
        /*if(count($this->data['category_id'])>3)
        {
            return array('code'=>1,'msg'=>'分类选择不要大于3个');
        }
        $category_id='';
        $category_name ='';
        if(!empty($this->data['category_id']) && is_array($this->data['category_id']))
        {
            $cat_details = $this->getProductCategory();
            for($i=0;$i<count($this->data['category_id']);$i++)
            {
                $category_id .= $this->data['category_id'][$i].",";
                $category_name .=$cat_details['cat_details'][$this->data['category_id'][$i]]['category_name'].",";
            }
            $category_id = rtrim($category_id,',');
            $category_name = rtrim($category_name,',');
        }else
        {
            $category_id=0;
        }*/

        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_CATEGORY." "
            ." WHERE id = '".$this->data['id']."'");
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'类型不存在');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COUPON_TYPE." (type_id,"
            ."coupon_name,min_money,coupon_money,jurisdiction)"
            ."VALUES('".$this->data['id']."',"
            ."'".$this->data['coupon_name']."',"
            ."'".$this->data['min_money']."',"
            ."'".$this->data['coupon_money']."',"
            ."'".$this->data['jurisdiction']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //删除规则
    function ActionDelCouponType()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $id = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_TYPE." "
            ." WHERE id = '".$this->data['id']."'");
        if(empty($id))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_STORE_TYPE." "
            ." WHERE type_id = '".$this->data['id']."'");
        if(!empty($type))
        {
            return array('code'=>1,'msg'=>'此规则正在使用！不允许删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_COUPON_TYPE." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //新增优惠卷
    function ActionAddCoupon()
    {

        if(!regExp::checkNULL($this->data['coupon_name']) ||
            !regExp::checkNULL($this->data['coupon_money']) ||
            !regExp::checkNULL($this->data['min_money']) )
        {
            return array('code'=>1,'msg'=>'必填内容需要填写');
        }
        /*$category_id='';
        if(!empty($this->data['category_id']) && is_array($this->data['category_id']))
        {
            for($i=0;$i<count($this->data['category_id']);$i++)
            {
                $category_id .= $this->data['category_id'][$i].",";
            }
            $category_id = rtrim($category_id,',');
        }else
        {
            $category_id=0;
        }
        $this->data['category_id']=$category_id;*/
        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_CATEGORY." "
            ." WHERE id = '".$this->data['coupon_type']."'");
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'类型不存在');
        }
        include RPC_DIR . '/module/common/common_coupon.php';
        $coupon = new common_coupon($this->data);

        $res = $coupon->CreateCoupon($this->data);
        return $res;
    }
    //更改规则状态
    public function ActionChangeCouponStatus()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_TYPE." "
            ." WHERE id = '".$this->data['id']."'");
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'优惠卷不存在');
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON_TYPE." SET default_sent=IF(default_sent=0,1,0) "
            ." WHERE id='".$this->data['id']."'");
        if($row)
        {
            if($type['default_sent']==0)
            {
                return array('code'=>0,'msg'=>'优惠卷默认已发放');
            }
            return array('code'=>0,'msg'=>'优惠卷已取消默认发放');
        }
    }
    //管理员创建通用优惠卷
    function ActionAddStoreCoupon()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_TYPE." "
            ." WHERE id = '".$this->data['id']."' ");
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        $store = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_STORE_TYPE." "
            ." WHERE type_id = '".$this->data['id']."' AND store_id =0");
        if(!empty($store))
        {
            return array('code'=>1,'msg'=>'重复添加');
        }
        $time=time();
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COUPON_STORE_TYPE." (type_id,"
            ."addtime,store_id,start_time,coupon_name,end_time)"
            ."VALUES('".$this->data['id']."','".$time."',"
            ."0,'".$this->data['start_time']."','".$type['coupon_name']."',"
            ."'".$this->data['end_time']."')");
        if($id)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON_STORE_TYPE." SET "
                ." coupon_key='".md5($time.$id)."' WHERE id = '".$id."' ");
            //更新判断状态。商户不需要
            $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON_TYPE." SET "
                ." check_has=1 WHERE id = '".$this->data['id']."' ");
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //删除通用优惠卷
    function ActionDelStoreCoupon()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $type = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COUPON_STORE_TYPE." "
            ." WHERE id = '".$this->data['id']."' AND store_id =0");
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'记录不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_COUPON_STORE_TYPE." "
            ." WHERE id='".$this->data['id']."' AND store_id = 0");
        if ($res)
        {
            //更新判断状态。商户不需要
            $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON_TYPE." SET "
                ." check_has=0 WHERE id = '".$type['type_id']."' ");
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }

    //显示或隐藏优惠券显示在首页
    function ShowHideHomeIndex()
    {
        $this->GetDBMaster()->query("UPDATE ".TABLE_COUPON_STORE_TYPE." "
                ." SET is_show=".intval($this->data['is_show'])." "
                ." WHERE id='".$this->data['id']."' AND store_id=0");

    }
}