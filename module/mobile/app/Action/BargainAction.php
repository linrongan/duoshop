<?php
class BargainAction extends bargain
{
    function __construct($data)
    {
        $this->data = $data;
    }
    //砍价操作
    function ActionBargain()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            die(json_encode(array('code'=>1,'msg'=>'参数错误')));
        }
        $bargain = $this->GetBargainProductDetail();
        if (empty($bargain))
        {
            die(json_encode(array("code"=>1,"msg"=>"产品已过期或不存在哦！")));
        }
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GAMES_BARGAIN_CREATE." "
            ." WHERE bargain_id='".$this->data['id']."' "
            ." AND userid='".SYS_USERID."'");
        if (!empty($data))
        {
            die(json_encode(array("code"=>1,"msg"=>"你已经砍过此商品一次啦！")));
        }
        //随机数
        $money=mt_rand(0,$bargain['float_price']*100)/100;
        $this->GetDBMaster()->StartTransaction();
        $id = $this->OrderMakeOrderId();
        $this->GetDBMaster()->query("INSERT INTO ".TABLE_GAMES_BARGAIN_CREATE.""
            ."(id,userid,addtime,bargain_id,product_id,min_price,minus_money,help_count)"
            ."VALUES('".$id."','".SYS_USERID."',"
            ."'".date("Y-m-d H:i:s")."','".$this->data['id']."',"
            ."'".$bargain['product_id']."','".$bargain['min_price']."',"
            ."'".$money."',1)");
        if($id)
        {
            $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GAMES_BARGAIN_JOIN.""
                ."(userid,addtime,bargain_id,minus_money,help_userid,create_id)"
                ."VALUES('".SYS_USERID."',"
                ."'".date("Y-m-d H:i:s")."','".$this->data['id']."',"
                ."'".$money."','".SYS_USERID."','".$this->data['id']."')");
            $this->GetDBMaster()->query("UPDATE ".TABLE_GAMES_BARGAIN." SET "
                ."join_count = join_count+1 WHERE id = '".$this->data['id']."'");
            $this->GetDBMaster()->SubmitTransaction();
            die(json_encode(array("code"=>0,"money"=>$money,"msg"=>"砍价成功，一刀砍出".$money.'元','id'=>$id)));
        }
        $this->GetDBMaster()->RollbackTransaction();
        die(json_encode(array("code"=>1,"msg"=>"砍价失败！")));
    }
    //帮别人砍
    function ActionBargainHelpFriend()
    {
        if(!regExp::checkNULL($this->data['id'])){
            die(json_encode(array('code'=>1,'msg'=>'参数错误')));
        }
        $create_data = $this->getCreateDetails();
        if (empty($create_data))
        {
            die(json_encode(array("code"=>1,"msg"=>"该用户还没发起砍价！")));
        }
        $bargain = $this->GetBargainProductDetail($create_data['bargain_id']);
        if (empty($bargain))
        {
            die(json_encode(array("code"=>1,"msg"=>"产品已过期或不存在哦！")));
        }
        $join = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_GAMES_BARGAIN_JOIN." "
            ." WHERE create_id='".$create_data['id']."' AND userid ='".SYS_USERID."'");
        if(!empty($join))
        {
            die(json_encode(array("code"=>1,"msg"=>"你已经砍过他一刀了！")));
        }
        //剩下的钱
        $spare = $bargain['product_price']-($create_data['minus_money']+$create_data['help_money']);
        //随机数
        if($spare-$bargain['float_price']>=$bargain['min_price'])
        {
            $money=mt_rand(0,$bargain['float_price']*100)/100;
        }else
        {
            $money=$bargain['float_price'];
            $this->GetDBMaster()->query("UPDATE ".TABLE_GAMES_BARGAIN_CREATE." SET "
                ." reach_status = 1 WHERE id = '".$create_data['id']."'");
        }
        $this->GetDBMaster()->StartTransaction();
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_GAMES_BARGAIN_JOIN.""
            ."(userid,addtime,bargain_id,minus_money,help_userid,create_id)"
            ."VALUES('".SYS_USERID."',"
            ."'".date("Y-m-d H:i:s")."','".$create_data['bargain_id']."',"
            ."'".$money."','".$create_data['userid']."','".$create_data['id']."')");
        if($id)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_GAMES_BARGAIN." SET "
                ."join_count = join_count+1 WHERE id = '".$create_data['bargain_id']."'");

            $this->GetDBMaster()->query("UPDATE ".TABLE_GAMES_BARGAIN_CREATE." SET "
                ." help_count = help_count+1,help_money=help_money+'".$money."' "
                ." WHERE id = '".$create_data['id']."'");
            $this->GetDBMaster()->SubmitTransaction();
            die(json_encode(array("code"=>0,"money"=>$money,"msg"=>"砍价成功，一刀砍出".$money.'元')));
        }
        $this->GetDBMaster()->RollbackTransaction();
        die(json_encode(array("code"=>1,"msg"=>"砍价失败！")));

    }
}
