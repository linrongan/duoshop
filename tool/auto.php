<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
include '../config_wx.php';
include RPC_DIR .'/conf/conf.php';
include RPC_DIR .'/conf/config.php';
include RPC_DIR .'/module/common/common.php';
Class auto extends common
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //程序入口
    function index()
    {
        //取出需要处理的订单
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_D_ORDER." "
            ." WHERE this_parent_status=1 "
            ." AND to_parent_id>0"
            ." ORDER BY order_addtime ASC LIMIT 0,1");
        if (!empty($data))
        {
            $parent=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_AUTHORIZE_USER_DETAIL." "
                ." WHERE auth_status=3 "
                ." AND userid='".$data['to_parent_id']."'");
            if (!empty($parent))
            {
                $this->GetDBMaster()->StartTransaction();
                //设置订单分佣现在开始
                $order=$this->GetDBSlave1()->queryrows("SELECT D.product_id,D.product_count,P.category_id "
                    ." FROM ".TABLE_D_ORDER_DETAIL." AS D "
                    ." LEFT JOIN ".TABLE_AUTHORIZE_TO_PRODUCT." AS P ON D.product_id=P.product_id"
                    ." WHERE D.orderid='".$data['orderid']."' "
                    ." AND D.userid='".$data['userid']."' "
                    ." AND P.category_id>0");
                if (!empty($order))
                {
                    foreach($order as $item)
                    {
                        //项目获取不同等级的价格
                        //项目和用户获取两个不同用户之间的级别

                    }
                }




                $this->GetDBMaster()->query("UPDATE ".TABLE_D_ORDER." "
                    ." SET this_parent_status=2,"
                    ." to_parent_id='".$parent['parent_id']."',"
                    ." from_parent_id='".$data['to_parent_id']."'"
                    ." WHERE id='".$data['id']."'");










            }else
            {
                //完成本次佣金分配
                $this->GetDBMaster()->query("UPDATE ".TABLE_D_ORDER." "
                    ." SET this_parent_status=3,"
                    ." to_parent_id=0,"
                    ." from_parent_id='".$data['to_parent_id']."'"
                    ." WHERE id='".$data['id']."'");
                //上级非代理或者已经取消代理
                $this->AddLogAlert("订单(".$data['id'].")完成分佣任务","订单(".$data['id'].")从".$data['from_parent_id']."到".$data['to_parent_id']."");
            }
        }

        //手机号码绑定同步
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." "
            ." WHERE phone>0 AND phone_status=1 ORDER BY userid DESC LIMIT 0,1");
        if (!empty($data))
        {
            $parameter=array("userid"=>$data['userid'],"telephoneNum"=>$data['phone']);
            //发送给中控
            $return=SentCMSParameter($parameter,'NewWXClient');
            if ($return['result']==0)
            {
                $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                    ." SET phone='".$data['phone']."',"
                    ." phone_status=0"
                    ." WHERE userid='".$data['userid']."'");
            }
            return false;
        }

        //发送短信开始
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." "
            ." WHERE phone>0 AND vip_day_sms=1 ORDER BY userid DESC LIMIT 0,1");
        if (!empty($data))
        {
            //获取发送的模板消息
            $temp=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_LOG_SMS_TEMP." "
                ." WHERE start_status=1 ORDER BY default_sent DESC LIMIT 0,1");
            if (!empty($temp))
            {
                $i=0;
                $array=array(
                    "whatsms"=>$temp['whatsms'],
                    "phone"=>$data['phone']
                );
                $canshu=explode(',',$temp['geshi']);
                foreach($canshu as $item)
                {
                    $i++;
                    if (($temp['canshu'.$i])=='SYSTEM')
                    {
                        $array['name']=$data['username']?$data['username']:WEBNAME;
                    }else
                    {
                        $array[$item]=$temp['canshu'.$i];
                    }
                }
                $json=doCurlPostRequest(WEBURL.'/api/',GetSentParameter($array,$temp['method']));
                $return=json_decode(base64_decode($json),true);
                if (isset($return['data']['code']) && $return['data']['code']==0)
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                        ." SET vip_day_sms=3 WHERE userid='".$data['userid']."'");
                }else
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                        ." SET vip_day_sms=2 WHERE userid='".$data['userid']."'");
                    $this->AddLogAlert(''.$data['phone'].'短信发送错误',json_encode($return).json_encode($array));
                }
            }
            return false;
        }
    }

    private function GetGetMoney($user1,$user2,$category_id,$product_id)
    {
        $user1_data=$this->GetDBSlave1()->queryrow("SELECT L.id,L.level_id FROM ".TABLE_AUTHORIZE_TO_USER." AS A "
            ." LEFT JOIN ".TABLE_AUTHORIZE_LEVEL." AS L ON A.level_id=L.level_id AND A.category_id=L.category_id"
            ." WHERE A.userid='".$user1."'"
            ." AND A.category_id='".$category_id."' "
            ." ORDER BY L.id DESC LIMIT 0,1");
        if (empty($user1_data))
        {
            //用户1未匹配到对应的级别可能是未授权或者级别错误
            return 0;
        }
        $user2_data=$this->GetDBSlave1()->queryrow("SELECT L.id,L.level_id FROM ".TABLE_AUTHORIZE_TO_USER." AS A "
            ." LEFT JOIN ".TABLE_AUTHORIZE_LEVEL." AS L ON A.level_id=L.level_id AND A.category_id=L.category_id"
            ." WHERE A.userid='".$user2."'"
            ." AND A.category_id='".$category_id."' "
            ." ORDER BY L.id DESC LIMIT 0,1");
        //通过级别获得相对应的价格差
        if (empty($user2_data))
        {
            //用户1未匹配到对应的级别可能是未授权或者级别错误
            return 0;
        }
        if ($user1_data['level_id']<=$user2_data['level_id'])
        {
            //该商品等级不符合
            return 0;
        }else
        {
            //获取用户1的价格
            $user1_price=$this->GetDBSlave1()->queryrow("SELECT price FROM ".TABLE_PRICE." "
                ." WHERE level_auto_id='".$user1_data['id']."'"
                ." AND product_id='".$product_id."'");
            if (empty($user1_price))
            {
                //价格不符合
                return 0;
            }
            //获取用户1的价格
            $user2_price=$this->GetDBSlave1()->queryrow("SELECT price FROM ".TABLE_PRICE." "
                ." WHERE level_auto_id='".$user2_data['id']."'"
                ." AND product_id='".$product_id."'");
            if (empty($user1_price))
            {
                //价格不符合
                return 0;
            }
            if ($user2_price['price']-$user1_price['price']<0)
            {
                //价格等级错误
                return 0;
            }
            else
            {
                return $user2_price['price']-$user1_price['price'];
            }
        }
    }
}
$auto=new auto(array());
die(json_encode($auto->index()));