<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_advertAction extends admin_advert
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //删除审核的Banner
    function ActionDelShopBanner()
    {
        die(json_encode($this->DelShopBanner()));
    }
    private function DelShopBanner()
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ADVERT."  "
            ." WHERE id='".$this->data['id']."'");
        if(!$data)
        {
            return array('code'=>1,'msg'=>'记录不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ADVERT."  SET is_del=1,status=0"
            ."  WHERE id='".$this->data['id']."'");
        $this->AddLogAlert('删除投入广告操作',json_encode($data));
        return array('code'=>0,'msg'=>'删除成功！');

    }

    //新增投入广告操作
    function ActionAddPicture()
    {
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_link']))
        {
            return array('code'=>1,'msg'=>'请输入链接');
        }
        if(!regExp::checkNULL($this->data['advert_day']))
        {
            return array('code'=>1,'msg'=>'请输入投放时长');
        }
        if(!regExp::checkNULL($this->data['picture_type']))
        {
            return array('code'=>1,'msg'=>'请选择投放的区域');
        }
        if(!regExp::checkNULL($this->data['picture_img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $id =$this->GetDBMaster()->query("INSERT INTO ".TABLE_O_ADVERT." "
            ." (picture_title,picture_link,picture_type,picture_img,advert_day"
            .",start_time,expire_time,status,ad_creater)"
            ." VALUES ('".$this->data['picture_title']."',"
            ." '".$this->data['picture_link']."',"
            ." '".$this->data['picture_type']."',"
            ." '".$this->data['picture_img']."',"
            ." '".$this->data['advert_day']."',"
            ." '0000-00-00 00:00:00',"
            ." '0000-00-00 00:00:00',"
            ." '".$this->data['status']."','".$_SESSION['admin_id']."')");

        if(!empty($id))
        {
            $this->AddLogAlert('新增投入广告操作',json_encode($_REQUEST));
            return array('code'=>0,'msg'=>'广告新增成功');
        }
    }

    //编辑投入广告操作
    function ActionEditPicture()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_link']))
        {
            return array('code'=>1,'msg'=>'请输入链接');
        }
        if(!regExp::checkNULL($this->data['picture_type']))
        {
            return array('code'=>1,'msg'=>'请选择投放的区域');
        }
        if(!regExp::checkNULL($this->data['picture_img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $advert = $this->getOneAdvert();
        if(empty($advert))
        {
            return array('code'=>1,'msg'=>'广告删除或不存在');
        }
        $type = $this->getOneAdvertType($this->data['picture_type']);
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'区域不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ADVERT." SET "
            ." picture_title='".$this->data['picture_title']."',"
            ." picture_link='".$this->data['picture_link']."',"
            ." picture_type='".$this->data['picture_type']."',"
            ." picture_img='".$this->data['picture_img']."',"
            ." start_time='".$this->data['start_time']."',"
            ." expire_time='".$this->data['expire_time']."',"
            ." status='".$this->data['status']."'"
            ." WHERE id = '".$this->data['id']."' "
            ." AND is_del=0"
        );
        $this->AddLogAlert('编辑投入广告操作',json_encode($advert));
        return array('code'=>0,'msg'=>'编辑成功');
    }

    //投放广告操作
    function ActionSubmitShopBanner()
    {
        die(json_encode($this->SubmitShopBanner()));
    }
    private function SubmitShopBanner()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $advert = $this->getOneAdvert();
        if (empty($advert))
        {
            return array('code'=>1,'msg'=>'找不到该投放记录');
        }
        if ($advert['advert_day']<=0)
        {
            return array('code'=>1,'msg'=>'投放时长不足,操作失败');
        }
        if ($advert['status']<=0)
        {
            return array('code'=>1,'msg'=>'未审核广告不能刊登');
        }
        //检测当前投放是否生效
        $check=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_ADVERT." "
            ." WHERE picture_type='".$advert['picture_type']."'  "
            ." AND expire_time>'".date("Y-m-d H:i:s")."'"
            ." ORDER BY expire_time DESC LIMIT 0,1");
        if (!empty($check))
        {
            return array('code'=>1,'msg'=>'当前已经存在投放的广告，截止时间是：'.$check['expire_time']);
        }else
        {
            $advert_region=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADVERT_REGION." "
                ." WHERE id = '".$advert['picture_type']."' AND status=0");
            if (empty($advert_region))
            {
                return array('code'=>1,'msg'=>'投放类型找不到');
            }

            $start_time=date("Y-m-d H");
            $expire_time=date("Y-m-d H",strtotime("+".$advert['advert_day']."hours"));
            if ($advert_region['data_table']==0)
            {
                //首页banner
                $banner=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_O_BANNER." "
                    ." WHERE ad_id = '".$advert['id']."'");
                $this->GetDBMaster()->StartTransaction();
                if (empty($banner))
                {
                    //新增
                    $this->GetDBMaster()->query("INSERT INTO ".TABLE_O_BANNER." "
                        ."(picture_title,picture_img,picture_link,picture_type,picture_sort,picture_show,"
                        ."picture_addtime,ad_creater,ad_id,start_time,expire_time,start_status)"
                        ."VALUES('".$advert['picture_title']."','".$advert['picture_img']."',"
                        ."'".$advert['picture_link']."','".$advert_region['picture_type']."',"
                        ."'".$advert_region['show_sort']."',0,"
                        ."'".date("Y-m-d H:i:s")."','".$advert['ad_creater']."','".$advert['id']."',"
                        ."'".$start_time."','".$expire_time."',1)");
                }else
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_O_BANNER." "
                        ." SET picture_title='".$advert['picture_title']."',"
                        ." picture_img='".$advert['picture_img']."',"
                        ." picture_link='".$advert['picture_link']."',"
                        ." picture_type='".$advert_region['picture_type']."',"
                        ." picture_sort='".$advert_region['show_sort']."',"
                        ." picture_show=0,"
                        ." picture_addtime='".date("Y-m-d H:i:s")."',"
                        ." ad_creater='".$advert['ad_creater']."',"
                        ." start_time='".$start_time."',"
                        ." expire_time='".$expire_time."',start_status=1"
                        ." WHERE ad_id='".$advert['id']."'");
                }
                //开始加时间和投放操作
                $this->GetDBMaster()->query("UPDATE ".TABLE_O_ADVERT." "
                    ." SET start_time='".$start_time."',"
                    ." expire_time='".$expire_time."',"
                    ." status=1,advert_day=0"
                    ." WHERE id='".$advert['id']."' ");
                $this->GetDBMaster()->SubmitTransaction();
                return array('code'=>0,'msg'=>'投放操作成功');
            }
            return array('code'=>1,'msg'=>'投放类型暂未开放');
        }
    }
}
