<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Admin_pointAction extends admin_point
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    function ActionAddGift()
    {
        if(!regExp::checkNULL($this->data['gift_name']))
        {
            return array('code'=>1,'msg'=>'请输入礼品名称');
        }
        if(!regExp::checkNULL($this->data['gift_img']))
        {
            return array('code'=>1,'msg'=>'请上传封面图');
        }

        $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GIFT_PRODUCT."(gift_name,source_img,"
            ."gift_img,ry_order,content,gift_point,sale,qty,category_id,unit)"
            ."VALUES('".$this->data['gift_name']."',"
            ."'".$this->data['source_img']."',"
            ."'".$this->data['gift_img']."','".$this->data['ry_order']."','".$this->data['content']."',"
            ."'".$this->data['gift_point']."',0,"
            ."'".$this->data['qty']."','".$this->data['category_id']."',"
            ."'".$this->data['unit']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    function ActionEditGift()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['gift_name']))
        {
            return array('code'=>1,'msg'=>'请输入礼品名称');
        }
        if(!regExp::checkNULL($this->data['gift_img']))
        {
            return array('code'=>1,'msg'=>'请上传封面图');
        }
        if (!empty($this->data['source_img']))
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_PRODUCT." "
                ." SET source_img='".$this->data['source_img']."'"
                ." WHERE id='".$this->data['id']."'");
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_PRODUCT." "
            ." SET gift_name='".$this->data['gift_name']."',"
            ." ry_order='".$this->data['ry_order']."',"
            ." content='".$this->data['content']."',"
            ." gift_point='".$this->data['gift_point']."',"
            ." gift_img='".$this->data['gift_img']."',"
            ." qty='".$this->data['qty']."',"
            ." category_id='".$this->data['category_id']."',"
            ." unit='".$this->data['unit']."'"
            ." WHERE id='".$this->data['id']."'");


        return array('code'=>0,'msg'=>'修改成功');
    }
    function ActionDelGift()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->getGiftDetail();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"礼品不存在或已删除！");
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_GIFT_PRODUCT." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //礼品订单删除
    function ActionDelRecord()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->getRecordDetail();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"订单不存在或已删除！");
        }
        $res=$this->GetDBMaster()->query("UPDATE ".TABLE_POINT_RECORD." SET "
            ." is_del=1 WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }

    //编辑礼品订单地址
    function ActionEditGiftOrder()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if (!regExp::checkNULL($this->data['wuliu_com']))
        {
            return array("code"=>1,"msg"=>"物流公司不能为空");
        }
        if (!regExp::checkNULL($this->data['wuliu_no']))
        {
            return array("code"=>1,"msg"=>"物流单号不能为空");
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_ORDER." SET "
            ." ship_status=4,"
            ." wuliu_com='".$this->data['wuliu_com']."',"
            ." wuliu_no='".$this->data['wuliu_no']."'"
            ." WHERE orderid='".$this->data['orderid']."'");
        return array("code"=>0,"msg"=>"编辑成功");
    }
    //添加礼品分类
    function ActionAddCategory()
    {
        if (!regExp::checkNULL($this->data['category_name']))
        {
            return array("code"=>1,"msg"=>"信息内容填写不全!");
        }
        $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GIFT_CATEGORY." "
            ."(category_name,ry_order,category_img)"
            ."VALUES('".$this->data['category_name']."','".$this->data['ry_order']."',"
            ."'".($this->data['fields_image']?$this->data['fields_image']:'')."')");
        if ($id)
        {
            return array("code"=>0,"msg"=>"新增成功");
        }
        return array("code"=>1,"msg"=>"新增失败");
    }
    //编辑礼品分类
    function ActionEditCategory()
    {
        if (!regExp::checkNULL($this->data['id']))
        {
            return array("code"=>1,"msg"=>"参数错误!");
        }
        if (!regExp::checkNULL($this->data['category_name']))
        {
            return array("code"=>1,"msg"=>"信息内容填写不全!");
        }
        $data = $this->GetCategoryDetail();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"分类不存在");
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_GIFT_CATEGORY." SET "
            ." category_name='".$this->data['category_name']."',"
            ." ry_order='".$this->data['ry_order']."',"
            ." category_img='".$this->data['fields_image']."'"
            ." WHERE category_id='".$this->data['id']."'");
        return array("code"=>0,"msg"=>"编辑成功");
    }
    //删除礼品分类
    function ActionDelCategory()
    {
        if (!regExp::checkNULL($this->data['id']))
        {
            return array("code"=>1,"msg"=>"参数错误!");
        }
        $data = $this->GetCategoryDetail();
        if(empty($data))
        {
            return array("code"=>1,"msg"=>"分类不存在");
        }
        $this->GetDBMaster()->query("DELETE FROM ".TABLE_GIFT_CATEGORY." "
            ." WHERE category_id='".$this->data['id']."'");
        return array("code"=>0,"msg"=>"操作成功!");
    }
}