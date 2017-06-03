<?php
class SystemAction extends system
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionSetConf()
    {
        if(!regExp::checkNULL($this->data['submit']))
        {
            return ;
        }
        $data = $this->GetSystemConf();
        $conf_key = array();//唯一
        $type =array();//类型
        foreach($data as $item)
        {
            $conf_key[] = $item['conf_key'];
            $type[$item['conf_key']]['conf_type']=$item['conf_type'];
        }
        foreach($this->data as $k=>$v)
        {
            if(in_array($k,$conf_key))
            {
                switch($type[$k]['conf_type'])
                {
                    case 2:
                        $this->GetDBMaster()->query("UPDATE ".TABLE_CONF." "
                            ." SET conf_number='".$v."'"
                            ." WHERE conf_key='".$k."'");
                        break;
                }
            }
        }
        return array('code'=>0,'msg'=>'修改成功');
    }
}