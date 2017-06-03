<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetUserList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>平台会员</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/tool/upload/upload.css">
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    会员管理
    <span class="c-gray en">&gt;</span>
    平台会员
</nav>
<div class="page-container">
    <form action="" method="post" class="mt-20">
        <div>
            <input type="text" class="input-text" value="<?php if(isset($_REQUEST['username'])){echo $_REQUEST['username'];} ?>"
                   style="width:250px" placeholder="输入昵称搜索" id="" name="username">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <a class="btn btn-success radius" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
        </div>

    </form>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">头像</th>
                <th width="100">昵称</th>
                <th width="100">是否订阅</th>
                <th width="100">专享会员</th>
                <th width="100">余额</th>
                <th width="100">积分总数</th>
                <th width="100">金卡</th>
                <th width="100">黑名单</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if(!empty($data['data']))
            {
                foreach($data['data'] as $item)
                {
                    ?>
                    <tr class="text-c">
                        <td width="100">
                            <img src="<?php echo $item['headimgurl']; ?>" width="50" class="picture-thumb" alt="">
                        </td>
                        <td width="100"><?php echo $item['nickname']; ?></td>
                        <td width="80"><?php echo $item['subscribe']?"已订阅":"非订阅"; ?></td>
                        <td width="80"><?php echo $item['vip_lv']==1?"是":"否"; ?></td>
                        <td width="80">￥<?php echo $item['user_money']; ?></td>
                        <td width="80"><?php echo $item['user_point']; ?></td>
                        <td width="80"><?php echo $item['gift_balance_status']==0?'未开通':$item['gift_balance']; ?></td>
                        <td width="80"><?php echo $item['status']?"黑名单":"正常"; ?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="user_edit('编辑余额','?mod=admin&v_mod=admin_user&_index=_edit',<?php echo $item['userid']; ?>)" href="javascript:;" title="编辑余额"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <?php if ($item['status']==0)
                            {?>
                                <a onclick="return confirm('确定设置黑名单吗？')" title="设置黑名单" style="text-decoration:none" class="ml-5" href="?mod=admin&v_mod=admin_user&_index=_list&_action=ActionBlackList&type=set&userid=<?php echo $item['userid']; ?>" title="编辑">
                                    <i class="Hui-iconfont">&#xe688;</i>
                                </a>
                            <?php
                            }else{?>
                                <a onclick="return confirm('确定取消黑名单吗？')" title="取消黑名单" style="text-decoration:none" class="ml-5" href="?mod=admin&v_mod=admin_user&_index=_list&_action=ActionBlackList&type=cancel&userid=<?php echo $item['userid']; ?>" title="编辑">
                                    <i class="Hui-iconfont">&#xe656;</i>
                                </a>
                            <?php } ?>

                        </td>
                    </tr>
                <?php
                }
            }
            ?>
            </tbody>
        </table>
        <?php
        include RPC_DIR ."/inc/page_nav.php";
        $page=new page_nav(array("total"=>$data['total'],
            "page_size"=>$data['page_size'],
            "curpage"=>$data['curpage'],
            "extUrl"=>"",
            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['canshu']));
        echo $page->page_nav();
        ?>
    </div>
</div>
<div id="qrcode_img" style="display: none;text-align: center"></div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/tool/upload/upload.js"></script>
<script type="text/javascript">
    //编辑余额
    function user_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    <?php
    }
    ?>
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>