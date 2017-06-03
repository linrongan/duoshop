<?php
class question extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function GetQuestionList()
    {
        $where = $param = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['keyword']) && !empty($this->data['keyword']))
        {
            $where .= " AND qusetion LIKE '%".trim($this->data['keyword'])."%' "
                ." AND answer LIKE '%".trim($this->data['keyword'])."%'";
            $param .= '&keyword='.$this->data['keyword'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_QUESTION." "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_QUESTION." "
            ." WHERE 1 ".$where." "
            ." ORDER BY ry_order ASC,id DESC LIMIT "
            ." ".($curpage-1)*$page_size.",".$page_size." ");
        return array(
            'data'=>$data,
            'total'=>$count['total'],
            'curpage'=>$curpage,
            'page_size'=>$page_size,
            'param'=>$param
        );
    }

    function GetOneQuestion($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_QUESTION." WHERE "
            ." id='".$id."'");
    }


    function GetEditQuestion()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            $this->Error();
        }
        $data = $this->GetOneQuestion($this->data['id']);
        if(!$data)
        {
            $this->Error();
        }
        return $data;
    }
}