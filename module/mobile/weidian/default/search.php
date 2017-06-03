<?php
class search extends wx
{
    function __construct($data,$store_id)
    {
        $this->data = $data;
        $this->store_id = $store_id;
    }



    function Search()
    {
        $keyword = $this->data['search']?$this->data['search']:'';
        redirect('/?mod=weidian&v_shop='.$this->data['v_shop'].'&v_mod=category&_index=_product&keyword='.$keyword);
    }
}