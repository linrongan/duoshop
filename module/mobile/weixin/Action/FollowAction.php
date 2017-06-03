<?php
class FollowAction extends follow
{
    function __construct($data)
    {
        $this->data = $data;
    }

    /*取消收藏产品*/
    function ActionDelCollectProduct()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_COLLE." WHERE "
            ." id='".$this->data['id']."' AND userid='".SYS_USERID."'");
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_PRODUCT_COLLE." WHERE "
            ." id='".$this->data['id']."' ");
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
            ." collect_count=IF(collect_count-1>0,collect_count-1,0) WHERE "
            ." product_id='".$data['product_id']."'");
        if($res && $res1)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'已取消');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'取消失败');
    }


    /*取消收藏店铺*/
    function ActionDelFollowShop()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_FOLLOW_STORE." WHERE "
            ." id='".$this->data['id']."' AND userid='".SYS_USERID."'");
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_FOLLOW_STORE." WHERE "
            ." id='".$this->data['id']."' ");
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_STORE." SET "
            ." follow_count=IF(follow_count-1>=0,follow_count-1,0) WHERE "
            ." store_id='".$data['store_id']."'");
        if($res1 && $res)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'已取消');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'取消失败');
    }



    /*
     * 关注店铺
     * */
    function ActionFollowShop()
    {
        if(!regExp::checkNULL($this->data['store_id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $shop = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_COMM_STORE." WHERE "
            ."store_id='".$this->data['store_id']."'");
        if(empty($shop))
        {
            return array('code'=>1,'msg'=>'店铺不存在');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_FOLLOW_STORE." WHERE "
            ."store_id='".$this->data['store_id']."' AND userid='".SYS_USERID."'");
        $this->GetDBMaster()->StartTransaction();
        if($data)
        {
            $type = 2;
            $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_FOLLOW_STORE." WHERE "
                ."id='".$data['id']."'");
        }else{
            $type = 1;
            $res = $this->GetDBMaster()->query("INSERT INTO ".TABLE_FOLLOW_STORE." SET "
                ."userid='".SYS_USERID."',store_id='".$this->data['store_id']."',"
                ."addtime='".date("Y-m-d H:i:s",time())."'");
        }
        if($type == 1)
        {
            $follow_count = $shop['follow_count']+1;
        }else{
            $follow_count = $shop['follow_count']-1;
        }
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_COMM_STORE." SET "
            ." follow_count='".$follow_count."' WHERE store_id='".$this->data['store_id']."'");
        if($res && $res1)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'ok','type'=>$type);
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'fail','type'=>$type);
    }


}