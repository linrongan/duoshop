<?php
require_once 'common_wx.php';
class template_msg extends wx
{
    const URL = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=';
    private $access_token;
    public function __construct()
    {
        $this->access_token = parent::Get_access_token();
    }

}
