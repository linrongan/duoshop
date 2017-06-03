<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_shopAction extends admin_shop
{

    //编辑店铺信息
    function EditShop()
    {
        if (regExp::checkNULL($this->data['store_name']) &&
            regExp::checkNULL($this->data['template_id']) &&
            regExp::checkNULL($this->data['store_status']) &&
            regExp::checkNULL($this->data['store_logo']))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_STORE." "
                ." SET store_name='".$this->data['store_name']."',"
                ." template_id='".$this->data['template_id']."',"
                ." store_logo='".$this->data['store_logo']."',"
                ." store_status='".$this->data['store_status']."',"
                ." store_sold='".$this->data['store_sold']."'"
                ." WHERE admin_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'编辑成功');
        }

        return array('code'=>1,'msg'=>'编辑失败');
    }

    //添加首页幻灯片
    function ActionAddHomeData()
    {
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        if(!regExp::checkNULL($this->data['picture_show']))
        {
            return array('code'=>1,'msg'=>'请选择是否可见');
        }
        if($this->data['type']==99)
        {
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_NAV." (nav_name,"
                ."nav_img,nav_link,nav_sort,nav_show,nav_addtime) "
                ."VALUES('".$this->data['picture_title']."',"
                ."'".$this->data['picture_img']."',"
                ."'".$this->data['picture_link']."',"
                ."'".$this->data['picture_sort']."',"
                ."'".$this->data['picture_show']."',"
                ."'".date('Y-m-d H:i:s')."')");
        }else
        {
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_BANNER." (picture_title,"
                ."picture_img,picture_link,picture_sort,picture_show,picture_type,picture_addtime,"
                ."start_time,expire_time) "
                ."VALUES('".$this->data['picture_title']."',"
                ."'".$this->data['picture_img']."',"
                ."'".$this->data['picture_link']."',"
                ."'".$this->data['picture_sort']."',"
                ."'".$this->data['picture_show']."',"
                ."'".$this->data['type']."',"
                ."'".date('Y-m-d H:i:s')."',"
                ."'".$this->data['start_time']."',"
                ."'".$this->data['expire_time']."')");
        }
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }

    //编辑首页幻灯片
    function ActionEditHomeData()
    {
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        if(!regExp::checkNULL($this->data['picture_show']))
        {
            return array('code'=>1,'msg'=>'请选择是否可见');
        }
        if($this->data['type']==99)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_O_NAV." "
                ." SET nav_name='".$this->data['picture_title']."',"
                ." nav_img='".$this->data['picture_img']."',"
                ." nav_link='".$this->data['picture_link']."',"
                ." nav_show='".$this->data['picture_show']."',"
                ." nav_sort='".$this->data['picture_sort']."'"
                ." WHERE id='".$this->data['id']."'");
        }else
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_O_BANNER." "
                ." SET picture_title='".$this->data['picture_title']."',"
                ." picture_img='".$this->data['picture_img']."',"
                ." picture_link='".$this->data['picture_link']."',"
                ." picture_show='".$this->data['picture_show']."',"
                ." picture_sort='".$this->data['picture_sort']."'"
                ." WHERE id='".$this->data['id']."'");
        }
        return array('code'=>0,'msg'=>'编辑成功');
    }

    //删除
    function ActionDelHomeData()
    {
        $id = $this->getThisPicDetails();
        if(empty($id))
        {
            return array('code'=>1,'msg'=>'已删除');
        }
        if($this->data['type']==99)
        {
            $table = TABLE_O_NAV;
        }elseif($this->data['type']==98)
        {
            $table = TABLE_O_INDEX_NOTICE;
        }else
        {
            $table = TABLE_O_BANNER;
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".$table." WHERE id = '".$this->data['id']."'");
        if(!empty($res))
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }

    //新增新闻通知
    function ActionAddHomeNotice()
    {
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_show']))
        {
            return array('code'=>1,'msg'=>'请选择是否可见');
        }

        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_INDEX_NOTICE." (notice_title,"
            ."notice_link,notice_sort,notice_show,notice_addtime) "
            ."VALUES('".$this->data['picture_title']."',"
            ."'".$this->data['picture_link']."',"
            ."'".$this->data['picture_sort']."',"
            ."'".$this->data['picture_show']."',"
            ."'".date('Y-m-d H:i:s')."')");

        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }

    //编辑新闻通知
    function ActionEditHomeNotice()
    {
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_show']))
        {
            return array('code'=>1,'msg'=>'请选择是否可见');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_O_INDEX_NOTICE." "
            ." SET notice_title='".$this->data['picture_title']."',"
            ." notice_link='".$this->data['picture_link']."',"
            ." notice_show='".$this->data['picture_show']."',"
            ." notice_sort='".$this->data['picture_sort']."'"
            ." WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }

    //店铺精选
    function ActionChangeShopChoice()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $shop = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." "
            ." WHERE store_id='".$this->data['id']."'");
        if(!$shop)
        {
            return array('code'=>1,'msg'=>'店铺不存在');
        }
        if(!regExp::checkNULL($this->data['show_sort']))
        {
            return array('code'=>1,'msg'=>'请输入排序值');
        }
        $choice = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_STORE_CHOICE." "
            ." WHERE store_id='".$this->data['id']."'");
        if(!empty($choice))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_STORE_CHOICE." "
                ." SET show_status=0,"
                ." show_sort='".$this->data['show_sort']."'"
                ." WHERE store_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'已加入精选');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_STORE_CHOICE." "
            ." SET store_id='".$this->data['id']."',"
            ." show_sort='".$this->data['show_sort']."',"
            ." addtime='".date("Y-m-d H:i:s",time())."'");
        if($id)
        {
            return array('code'=>0,'msg'=>'已加入精选');
        }
        return array('code'=>1,'msg'=>'加入精选失败');
    }

    //取消精选
    function ActionCancelChoice()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $shop = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." "
            ." WHERE store_id='".$this->data['id']."'");
        if(!$shop)
        {
            return array('code'=>1,'msg'=>'店铺不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_STORE_CHOICE." "
            ." SET show_status=1"
            ." WHERE store_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'已取消精选推荐');
    }

    //设置店铺实体信息
    function SetPhysical()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $shop = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." "
            ." WHERE store_id='".$this->data['id']."'");
        if(empty($shop))
        {
            return array('code'=>1,'msg'=>'店铺不存在');
        }
        $physical = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE_PHYSICAL." "
            ." WHERE store_id='".$this->data['id']."'");
        if (!empty($physical))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_STORE_PHYSICAL." "
                ." SET lng='".$this->data['lng']."',"
                ." lat='".$this->data['lat']."',"
                ." address='".$this->data['address']."',"
                ." min_ship_fee='".$this->data['min_ship_fee']."',"
                ." ship_fee='".$this->data['ship_fee']."',"
                ." status='".$this->data['status']."'"
                ." WHERE store_id='".$this->data['id']."'");
            return array('code'=>0,'msg'=>'编辑实体店铺信息成功!');
        }else
        {
            $this->GetDBMaster()->query("INSERT INTO ".TABLE_COMM_STORE_PHYSICAL." "
                ." (store_id,lng,lat,address,min_ship_fee,ship_fee,status)"
                ." VALUES('".$this->data['id']."','".$this->data['lng']."','".$this->data['lat']."',"
                ." '".$this->data['address']."','".$this->data['min_ship_fee']."',"
                ."'".$this->data['ship_fee']."','".$this->data['status']."')");
            return array('code'=>0,'msg'=>'新增实体店铺信息成功!');
        }
    }
    //折扣卷编辑
    function ActionRechargeShopBalance()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_STORE." "
            ." SET gift_balance=gift_balance+'".$this->data['gift_balance']."'"
            ." WHERE store_id='".$this->data['id']."'");
        if($row)
        {
            //store_id,userid,money,orderid,order_type,admin_id,addtime
            $data = array(
                'store_id'=>$this->data['id'],
                'userid'=>0,'money'=>$this->data['gift_balance'],
                'orderid'=>0,'order_type'=>1,
                'admin_id'=>$_SESSION['admin_id']
            );
            $this->AddDiscountCouponLog($data);
        }
        return array('code'=>0,'msg'=>'编辑成功');
    }
}
