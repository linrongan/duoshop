<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class shop extends wx
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //获取附件门店的列表
    function GetPhysicalList($page_size=8)
    {
        $where=$order='';
        $order=" ORDER BY ACOS(SIN((".$this->data['lat']." * 3.1415) / 180 )*SIN((lat * 3.1415) / 180 ) +COS((".$this->data['lat']." * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS((".$this->data['lng']." * 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6380 ASC ";
        if(isset($this->data['page']) && !empty($this->data['page']) && regExp::is_positive_number($this->data['page']))
        {
            $page = $this->data['page'];
        }else
        {
            $page  = 1;
        }
        if(isset($this->data['page_size']) && regExp::is_positive_number($this->data['page_size']))
        {
            $page_size = $this->data['page_size'];
        }
        if (is_numeric($this->data['lat']) && is_numeric($this->data['lng']))
        {
            if (isset($this->data['sort']))
            {
                switch($this->data['sort'])
                {
                    case 2;
                        $order=" ORDER BY S.store_level DESC";
                        break;
                    case 3;
                        $order=" ORDER BY S.store_sold DESC";
                        break;
                    case 4;
                        $order=" ORDER BY S.follow_count DESC";
                        break;
                    default:
                }
            }

            /*if (isset($_REQUEST['my']))
            {
                echo "SELECT * FROM ".TABLE_COMM_STORE_PHYSICAL." AS SP "
                ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON SP.store_id=S.store_id "
                ." WHERE lat>".$this->data['lat']."-1 "
                ." AND lat<".$this->data['lat']."+1 "
                ." AND lng>".$this->data['lng']."-1 "
                ." AND lng<".$this->data['lng']."+1 ".$where." "
                ." ORDER BY ACOS(SIN((".$this->data['lat']." * 3.1415) / 180 )*SIN((lat * 3.1415) / 180 ) +COS((".$this->data['lat']." * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS((".$this->data['lng']." * 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6380 ASC "
                ." LIMIT ".($page-1)*$page_size.",".$page_size."";
            }
            */

            $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_COMM_STORE_PHYSICAL." AS SP "
                ." LEFT JOIN ".TABLE_COMM_STORE." AS S ON SP.store_id=S.store_id "
                ." WHERE SP.status>0 "
                ." AND lat>".$this->data['lat']."-1 "
                ." AND lat<".$this->data['lat']."+1 "
                ." AND lng>".$this->data['lng']."-1 "
                ." AND lng<".$this->data['lng']."+1 "
                ." ".$where." ".$order.""
                ." LIMIT ".($page-1)*$page_size.",".$page_size."");

            $data = array(
                'code'=>0,
                'data'=>$data
                /*'sort'=>$sort,
                'canshu'=>$canshu,
                'sort_canshu'=>$sort_canshu,
                'category_canshu'=>$category_canshu*/
            );
            if(regExp::is_ajax())
            {
                $html =" ";
                if(!empty($data['data']))
                {
                    foreach($data['data'] as $item)
                    {
                        $html .= '<a href="/'.$item['store_url'].'" class="weui-cell" style="position:relative;">';
                        $html .= '<div class="weui-cell__hd" style="position:absolute; left:3%; top:.5rem;">';
                        $html .= '<div class="shop-img">';
                        $html .= '<img src="'.$item['store_logo'].'" style="width:60px; height:60px; border-radius:5px; display:block; margin-right:10px;">';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '<div class="weui-cell__bd" style="padding-left:70px;">';
                        $html .= '<div class="rf14 cl_b3">';
                        $html .= '<b class="fl omit" style="width:70%;">'.$item['store_name'].'</b>';
                        $html .= '<span class="fr rf12 cl_b9">'.$this->getDistance($item['lat'], $item['lng'], $_REQUEST['lat'], $_REQUEST['lng']).'</span>';
                        $html .= '<div class="cb"></div>';
                        $html .= '<div class="grade rf12 cl_b9 rmt5">';
                        for($i=1;$i<=$item['store_level']/2;$i++)
                        {
                            $html .= '<span class="grade-item grade-2"></span>';
                        }
                        if($item['store_level']%2>0)
                        {
                            $html .= '<span class="grade-item grade-1"></span>';
                        }
                        $html .= '<b style="color:#f8aa12; margin-right:5px;">'. $item['store_level']/2 .'</b>';
                        $html .= ' 销量 '. $item['store_sold'] .' 单';
                        $html .= '</div>';
                        $html .= '<div class="rf12 rmt5 cl_b9 cost">';
                        $html .= '<span>￥'. $item['min_ship_fee'].'起送</span>';
                        $html .= '<span>配送费￥'. $item['ship_fee'].'</span>';
                        $html .= '</div>';
                        $html .= '<div class="rf12 cl_b9 rmt5">';
                        $html .= '地址：'. $item['address'];
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</a>';
                    }
                }
                die(json_encode(array('code'=>0,'data'=>$html,'pages'=>ceil($count['total']/$page_size))));
            }
            return $data;
        }else
        {
            return array("code"=>1,"msg"=>"获取定位错误");
        }
    }

    //计算经纬度
    function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6367000; //approximate radius of earth in meters
        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;

        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;

        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        $mi = $calculatedDistance;
        return $this->GetMToKm($mi);
    }

    //获取距离单位
    protected function GetMToKm($mi)
    {
        if($mi>=1000)
        {
            return round($mi/1000,1).'公里';
        }else{
            return intval($mi).'米';
        }
    }
}