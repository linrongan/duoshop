<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class Games_signedAction extends games_signed
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //签到操作
    function ActionSigned()
    {
        //今日签到
        $now_log=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SIGNED." "
            ." WHERE adddate_all='".date("Y-m-d")."' "
            ." AND userid='".SYS_USERID."'");
        if (!empty($now_log))
        {
            die(json_encode(array("code"=>1,"msg"=>"您好勤奋啊,今日已经签过到了,您可以明天再来哦。")));
        }
        //已连续签到
        $user=$this->GetUserInfo(SYS_USERID);
        //昨天
        $tom=date("Y-m-d",strtotime("-1 day"));
        $tom_log=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SIGNED." "
            ." WHERE adddate_all='".$tom."' "
            ." AND userid='".SYS_USERID."'");
        if (!empty($tom_log))
        {
            //连续
            $point=$this->GetPoint($user['lianxu_signed']);
            $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
                ." lianxu_signed=lianxu_signed+1,"
                ." user_point=user_point+".intval($point)." "
                ." WHERE userid='".SYS_USERID."'");
            $lianxu_signed=$user['lianxu_signed']+1;

        }else
        {
            //不连续
            $point=$this->GetPoint(0);
            $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
                ." lianxu_signed=1,"
                ." user_point=user_point+".intval($point)." "
                ." WHERE userid='".SYS_USERID."'");
            $lianxu_signed=1;
        }
        //插入赠送积分记录表
        $this->GetDBMaster()->query("INSERT INTO ".TABLE_SIGNED.""
            ."(userid,addtime,adddate,adddate_all,addmonth_all,point)"
            ."VALUES('".SYS_USERID."',"
            ."'".date("Y-m-d H:i:s")."','".date("d")."',"
            ."'".date("Y-m-d")."','".date("Y-m")."','".$point."')");
        //积分记录表
        $this->GetDBMaster()->query("INSERT INTO ".TABLE_LOG_POINT." "
            ." (point,addtime,type_id,userid,point_banlace)VALUES('".$point."',"
            ."'".date("Y-m-d H:i:s")."',99,"
            ."'".SYS_USERID."','".($user['user_point']+$point)."')");
        die(json_encode(array("code"=>0,"totalcount"=>$lianxu_signed,"totalpoint"=>$user['user_point']+$point,"msg"=>"签到成功,您已连续签到".$lianxu_signed."天,获得".$point."积分")));
    }
    //添加礼品
    function ActionPointExchange()
    {
        die(json_encode($this->PointExchange()));
    }

    private function PointExchange()
    {
        $this->data['qty']=intval($this->data['qty']);
        if (regExp::is_positive_number($this->data['id']) &&
            $this->data['qty']>0)
        {
            //购物车总计
            $need_point=0;

            $user=$this->GetUserInfo(SYS_USERID);
            $data=$this->GetPointGiftDetail();
            $need_point+=$this->data['qty']*$data['need_point'];

            if ($need_point>$user['user_point'])
            {
                return array("code"=>1,"msg"=>"积分不够");
            }
            if ($data['sales']/$data['stock']>1)
            {
                return array("code"=>1,"msg"=>"库存不足");
            }
            $address = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SHIP_ADDRESS."  "
                ." WHERE id='".$this->data['address_id']."' "
                ." AND userid='".SYS_USERID."'");
            if(empty($address))
            {
                return array('code'=>1,'msg'=>'地址信息错误');
            }
            $address_location = explode(' ',$address['address_location']);
            //插入记录
            $this->GetDBMaster()->StartTransaction();
            $id=$this->GetDBMaster()->query("INSERT INTO ".TABLE_POINT_RECORD." "
                ." (qty,userid,gift_id,addtime,ship_name,ship_phone,ship_address,ship_province"
                .",ship_city,ship_area)VALUES(".$this->data['qty'].","
                ."'".SYS_USERID."','".$this->data['id']."','".time()."',"
                ."'".$address['shop_name']."','".$address['shop_phone']."','".$address['address_details']."',"
                ."'".$address_location[0]."','".$address_location[1]."','".$address_location[2]."')");
            if($id)
            {
                //扣积分
                $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                    ." SET user_point=user_point-".$need_point." "
                    ." WHERE userid='".SYS_USERID."' ");
                //加兑换量
                $this->GetDBMaster()->query("UPDATE ".TABLE_POINT_GIFT." "
                    ." SET sales=sales+".$this->data['qty'].""
                    ." WHERE gift_id='".$this->data['id']."' ");
                $this->GetDBMaster()->SubmitTransaction();
                return array("code"=>0,"msg"=>"兑换成功");
            }
        }
        return array("code"=>1,"msg"=>"参数错误");
    }
}