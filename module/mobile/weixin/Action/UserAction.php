<?php
class UserAction extends user
{
    function __construct($data)
    {
        $this->data = $data;
    }

    function ActionAddFeedback()
    {
        if(!regExp::checkNULL($this->data['message']))
        {
            return array('code'=>1,'msg'=>'请输入您的意见');
        }
        if(!regExp::checkNULL($this->data['contact']))
        {
            return array('code'=>1,'msg'=>'请输入您的联系方式');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_FEEDBACK."(userid,message,"
            ."contact,store_id,addtime,back_status) VALUES('".SYS_USERID."',"
            ." '".$this->data['message']."','".$this->data['contact']."','".$this->data['store_id']."',"
            ."'".date("Y-m-d H:i:s",time())."',0)");
        if($res)
        {
            return array('code'=>0,'msg'=>'反馈成功');
        }
        return array('code'=>1,'msg'=>'反馈成功');
    }


    /*
   * 绑定银行卡
   * */
    function ActionNewBankCard()
    {
        if(!regExp::checkNULL($this->data['bank_id']))
        {
            return array('code'=>1,'msg'=>'请选择银行');
        }
        if(!regExp::checkNULL($this->data['bank_username']))
        {
            return array('code'=>1,'msg'=>'请输入持卡人');
        }
        if(!regExp::checkNULL($this->data['bank_card_number']))
        {
            return array('code'=>1,'msg'=>'请输入卡号');
        }
        if(!regExp::checkNULL($this->data['bank_user_card']))
        {
            return array('code'=>1,'msg'=>'请输入身份证号');
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_BANK_CARD."  "
            ." WHERE userid='".SYS_USERID."'");
        if($count['count']>=3)
        {
            return array('code'=>1,'msg'=>'您绑定的银行卡已达上限');
        }
        $is_repeat = $this->GetDBSlave1()->queryrow("SELECT id FROM ".TABLE_BANK_CARD."  "
            ." WHERE bank_card_number='".$this->data['bank_card_number']."' AND userid='".SYS_USERID."'");
        if($is_repeat)
        {
            return array('code'=>1,'msg'=>'您输入的银行卡已经绑定过了');
        }
        $bank = $this->GetOneBank($this->data['bank_id']);
        if(!$bank)
        {
            return array('code'=>1,'msg'=>'银行不存在');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_BANK_CARD."(userid,bank_username,bank_name,"
            ."bank_card_number,bank_user_card,addtime) VALUES('".SYS_USERID."','".$this->data['bank_username']."',"
            ."'".$bank['bank_name']."','".$this->data['bank_card_number']."','".$this->data['bank_user_card']."',"
            ."'".date("Y-m-d H:i:s",time())."')");
        if($res)
        {
            return array('code'=>0,'msg'=>'绑定成功');
        }
        return array('code'=>1,'msg'=>'绑定失败');
    }


    /*
     * 取消银行卡绑定
     * */
    function ActionCpanelBank()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $bank = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_BANK_CARD." WHERE "
            ." id='".$this->data['id']."' AND userid='".SYS_USERID."'");
        if(empty($bank))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_BANK_CARD." WHERE "
            ." id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'解绑成功');
        }
        return array('code'=>1,'msg'=>'解绑失败');
    }


    /*
     * 设置会员信息
     */
    function ActionSetUserInfo()
    {
        if(!regExp::checkNULL($this->data['nickname']))
        {
            return array('code'=>1,'msg'=>'昵称不能为空');
        }
        if(!regExp::checkNULL($this->data['phone']))
        {
            return array('code'=>1,'msg'=>'手机不能为空');
        }
        $user = $this->GetUserInfo(SYS_USERID);
        if(regExp::checkNULL($this->data['password1']))
        {
            if(empty($user['pay_password']))
            {
                //未设置支付密码
                if(empty($this->data['password2']) || $this->data['password1']!=$this->data['password2'])
                {
                    return array('code'=>1,'msg'=>'两次密码输入不一致');
                }
            }else
            {
                //修改支付密码
                if(MD5($this->data['password1'])!=$user['pay_password'])
                {
                    return array('code'=>1,'msg'=>'原密码错误');
                }
            }
            $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
                ." SET pay_password='".MD5($this->data['password2'])."' "
                ." WHERE userid='".SYS_USERID."'");
        }
        $sex = $this->data['sex']=='男'?1:2;
        $this->GetDBMaster()->query("UPDATE ".TABLE_USER." "
            ." SET nickname='".$this->data['nickname']."',phone='".$this->data['phone']."',sex='".$sex."' "
            ." WHERE userid='".SYS_USERID."'");
        return array('code'=>0,'msg'=>'信息修改成功');
    }

    /*
     * 申请会员卡
     */
    function ActionApplyVipCard()
    {
        die(json_encode($this->ApplyVipCard()));
    }
    private function ApplyVipCard()
    {
        if(!regExp::checkNULL($this->data['username']))
        {
            return array('code'=>1,'msg'=>'姓名不能为空');
        }
        if(!regExp::checkNULL($this->data['phone']))
        {
            return array('code'=>1,'msg'=>'手机不能为空');
        }
        if(!regExp::checkNULL($this->data['birthday']))
        {
            return array('code'=>1,'msg'=>'生日不能为空');
        }
        if(!regExp::checkNULL($this->data['code']))
        {
            return array('code'=>1,'msg'=>'验证码不能为空');
        }
        $check = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_VIP_CARD."  "
            ." WHERE userid='".SYS_USERID."'");
        if ($check['count']>0)
        {
            return array('code'=>1,'msg'=>'您已经申请过会员卡');
        }
        $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_VIP_CARD." "
            ." (store_id,card_no,username,create_time,company_name,birthday,userid)"
            ." VALUES(0,'".$this->data['phone']."','".$this->data['username']."',"
            ."'".date("Y-m-d H:i:s")."','".$this->data['company_name']."','".$this->data['birthday']."','".SYS_USERID."')");
        if ($id)
        {
            return array('code'=>0,'msg'=>'会员卡申请成功');
        }else
        {
            return array('code'=>1,'msg'=>'会员卡申请失败');
        }
    }
}