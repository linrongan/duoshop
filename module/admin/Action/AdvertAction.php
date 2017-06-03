<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class AdvertAction extends advert
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
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
        if(!regExp::checkNULL($this->data['picture_type']))
        {
            return array('code'=>1,'msg'=>'请选择投放的区域');
        }
        if(!regExp::checkNULL($this->data['picture_img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $type = $this->getOneAdvertType($this->data['picture_type']);
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'区域不存在');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_O_ADVERT." (picture_title,"
            ."picture_link,picture_img,picture_type,ad_creater,store_id)VALUES('".$this->data['picture_title']."',"
            ."'".$this->data['picture_link']."',"
            ."'".$this->data['picture_img']."',"
            ."'".$this->data['picture_type']."',"
            ."'".$_SESSION['admin_id']."','".$_SESSION['admin_store_id']."')");
        if($res)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
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

        if(!regExp::checkNULL($this->data['picture_img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $advert = $this->getOneAdvert();
        if(empty($advert))
        {
            return array('code'=>1,'msg'=>'广告删除或不存在');
        }
        if($advert['pay_status']>=3)
        {
            return array('code'=>1,'msg'=>'已支付不能修改');
        }
        $type = $this->getOneAdvertType($this->data['picture_type']);
        if(empty($type))
        {
            return array('code'=>1,'msg'=>'区域不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_O_ADVERT." SET "
            ." picture_title='".$this->data['picture_title']."',"
            ." picture_link='".$this->data['picture_link']."',"
            ." picture_img='".$this->data['picture_img']."'"
            ." WHERE id = '".$this->data['id']."'"
        );
        return array('code'=>0,'msg'=>'编辑成功');
    }
}