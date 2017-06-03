<?php
class picture extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    /*
    function GetBannerList()
    {
        $data =  $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_BANNER." WHERE store_id='".$_SESSION['admin_store_id']."' "
            ." ORDER BY picture_sort ASC");
        if(!regExp::is_ajax())
        {
            return $data;
        }
        $array = array(
            'title'=>'banner',
            'id'=>1,
            'start'=>0,
            'data'=>array()
        );
        for($i=0;$i<count($data);$i++)
        {
            $array['data'][$i]['alt'] = $data[$i]['picture_title'];
            $array['data'][$i]['pid'] = $data[$i]['id'];
            $array['data'][$i]['src'] = $data[$i]['picture_path'];
            $array['data'][$i]['thumb'] = $data[$i]['picture_path'];
        }
        return $array;
    }

    function CheckData()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $banner = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANNER." WHERE id='".$this->data['id']."' "
            ." AND store_id='".$_SESSION['admin_store_id']."'");
        if(empty($banner))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        return array('code'=>0,'data'=>$banner);
    }


    function GetBannerDetail()
    {
        $data = $this->CheckData();
        if($data['code'])
        {
            $this->Error();
        }
        return $data['data'];
    }*/
}