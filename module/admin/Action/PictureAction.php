<?php
/*
class PictureAction extends picture
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //更改状态
    function ActionChangeShowStatus()
    {
        $data = $this->CheckData();
        if($data['code'])
        {
            return $data;
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_BANNER." SET picture_show=IF(picture_show=1,0,1),"
            ."picture_last_u='".time()."' WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'更改成功');
        }
        return array('code'=>1,'msg'=>'更改失败');
    }


    //删除
    function ActionDelBanner()
    {
        $data = $this->CheckData();
        if($data['code'])
        {
            return $data;
        }
        $res = $this->GetDBMaster()->queryrow("DELETE FROM ".TABLE_BANNER." WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }


    function ActionAddBanner()
    {
        if(!regExp::checkNULL($this->data['picture_title']))
        {
            return array('code'=>1,'msg'=>'请输入标题');
        }
        if(!regExp::checkNULL($this->data['picture_url']))
        {
            return array('code'=>1,'msg'=>'请输入链接');
        }
        if(!regExp::checkNULL($this->data['picture_path']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_BANNER." (picture_title,"
            ."picture_path,picture_url,picture_sort,picture_addtime,picture_last_u,"
            ."picture_show,store_id)VALUES('".$this->data['picture_title']."',"
            ."'".$this->data['picture_path']."','".$this->data['picture_url']."',"
            ."'".$this->data['picture_sort']."','".date("Y-m-d H:i:s",time())."',"
            ."'".time()."',0,'".$_SESSION['admin_store_id']."')");
        if($res)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }return array('code'=>1,'msg'=>'添加失败');
    }



    function ActionEditBanner()
    {
        $data = $this->CheckData();
        if($data['code'])
        {
            return $data;
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_BANNER." SET picture_title='".$this->data['picture_title']."',"
            ."picture_url='".$this->data['picture_url']."',picture_sort='".$this->data['picture_sort']."',"
            ."picture_path='".$this->data['picture_path']."',picture_last_u='".time()."' WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'更新成功');
        }return array('code'=>1,'msg'=>'更新失败');
    }


    function ActionMoreDelBanner()
    {
        if(!regExp::checkNULL($this->data['id']) || !is_array($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $select_id = array_filter($this->data['id']);
        $count = count($select_id);
        $where = '';
        for ($i=0;$i<$count;$i++)
        {
            $where .= $select_id[$i].',';
        }
        $where = rtrim($where,',');
        $check_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_BANNER." WHERE "
            ." id IN (".$where.") AND store_id='".$_SESSION['admin_store_id']."' ");
        if($check_count['total']<$count)
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_BANNER." WHERE id IN(".$where.") "
            ." AND store_id='".$_SESSION['admin_store_id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }
}*/