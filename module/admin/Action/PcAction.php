<?php
class PcAction extends pc
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //添加新闻
    function ActionNewNews()
    {
        if(!regExp::checkNULL($this->data['news_title']))
        {
            return array('code'=>1,'msg'=>'请输入新闻名称');
        }
        if(!regExp::checkNULL($this->data['news_img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        if(!regExp::checkNULL($this->data['news_category']))
        {
            return array('code'=>1,'msg'=>'请选择分类');
        }
        if(!regExp::checkNULL($this->data['news_desc']))
        {
            return array('code'=>1,'msg'=>'请添加一点描述');
        }
        if(!regExp::checkNULL($this->data['news_content']))
        {
            return array('code'=>1,'msg'=>'请添加一点内容');
        }

        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GW_NEWS." "
            ."(news_title,news_category,news_img,news_desc,news_content,addtime) "
            ."VALUES('".$this->data['news_title']."',"
            ."'".$this->data['news_category']."',"
            ."'".$this->data['news_img']."',"
            ."'".$this->data['news_desc']."',"
            ."'".$this->data['news_content']."',"
            ."'".time()."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');

    }
    //编辑新闻
    function ActionEditNews()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['news_title']))
        {
            return array('code'=>1,'msg'=>'请输入新闻名称');
        }
        if(!regExp::checkNULL($this->data['news_img']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        if(!regExp::checkNULL($this->data['news_desc']))
        {
            return array('code'=>1,'msg'=>'请添加一点描述');
        }
        if(!regExp::checkNULL($this->data['news_category']))
        {
            return array('code'=>1,'msg'=>'请选择分类');
        }
        if(!regExp::checkNULL($this->data['news_content']))
        {
            return array('code'=>1,'msg'=>'请添加一点内容');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_GW_NEWS." SET news_title='".$this->data['news_title']."',"
            ." news_img='".$this->data['news_img']."',"
            ." news_desc='".$this->data['news_desc']."',"
            ." news_category='".$this->data['news_category']."',"
            ." news_content='".$this->data['news_content']."'"
            ." WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }
    //删除新闻
    function ActionDelNews()
    {
        $id = $this->getNewsDetails();
        if(empty($id))
        {
            return array('code'=>1,'msg'=>'新闻不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_GW_NEWS." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //banner图片编辑
    function ActionEditPageBanner()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['picture_path']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_GW_INDEX_BANNER." SET picture_path='".$this->data['picture_path']."'"
            ." WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }
    //新增关于我们页面
    function ActionNewAboutPage()
    {
        if(!regExp::checkNULL($this->data['page_title']))
        {
            return array('code'=>1,'msg'=>'请输入页面名称');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GW_ABOUT." "
            ."(page_title,type,page_content,addtime) "
            ."VALUES('".$this->data['page_title']."',"
            ."'".$this->data['type']."',"
            ."'".$this->data['page_content']."',"
            ."'".time()."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑关于我们
    function ActionEditAboutPage()
    {
        if(!regExp::checkNULL($this->data['page_title']))
        {
            return array('code'=>1,'msg'=>'请输入页面名称');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_GW_ABOUT." SET page_title='".$this->data['page_title']."',"
            ." page_content = '".$this->data['page_content']."'"
            ." WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }
    //删除关于我们页面
    function ActionDelAboutPage()
    {
        $id = $this->getAboutPageDetails();
        if(empty($id))
        {
            return array('code'=>1,'msg'=>'新闻不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_GW_ABOUT." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
    //添加首页图片
    function ActionAddHomePic()
    {
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_path']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GW_INDEX_BANNER." (picture_title,"
            ."picture_path,picture_url,picture_sort,ad_type,picture_show,picture_text,picture_addtime) "
            ."VALUES('".$this->data['picture_title']."',"
            ."'".$this->data['picture_path']."',"
            ."'".$this->data['picture_url']."',"
            ."'".$this->data['picture_sort']."',"
            ."'".$this->data['type']."',"
            ."'".$this->data['picture_show']."',"
            ."'".$this->data['picture_text']."',"
            ."'".date('Y-m-d')."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }
    //编辑首页图片
    function ActionEditHomePic()
    {
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_path']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        if($this->data['type']==3)
        {
            if(isset($this->data['picture_path'])
                && is_array($this->data['picture_path'])
                && count($this->data['picture_path'])>0)
            {
                $picture_path = serialize($this->data['picture_path']);
            }else{
                $picture_path = '';
            }

        }else
        {
            $picture_path = $this->data['picture_path'];
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_GW_INDEX_BANNER." SET picture_title='".$this->data['picture_title']."',"
            ." picture_path = '".$picture_path."',"
            ." picture_url = '".$this->data['picture_url']."',"
            ." picture_sort = '".$this->data['picture_sort']."',"
            ." picture_show = '".$this->data['picture_show']."',"
            ." picture_text = '".$this->data['picture_text']."'"
            ." WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }
    //删除首页图片
    function ActionDelHomePic()
    {
        $id = $this->getThisPicDetails();
        if(empty($id))
        {
            return array('code'=>1,'msg'=>'图片不存在或已删除');
        }
        $res=$this->GetDBMaster()->query("DELETE FROM ".TABLE_GW_INDEX_BANNER." "
            ." WHERE id='".$this->data['id']."'");
        if ($res)
        {
            return array("code"=>0,"msg"=>"删除成功！");
        }
        return array("code"=>1,"msg"=>"删除失败！");
    }
}