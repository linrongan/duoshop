<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetBargainUserList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
</head>
<body>
<div class="page-container">

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">用户头像</th>
                <th width="80">用户昵称</th>
                <th width="100">帮砍人数</th>
                <th width="80">产品原价</th>
                <th width="80">最低底价</th>
                <th width="80">已砍价钱</th>
                <th width="80">砍价时间</th>
                <th width="80">帮他砍的人</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data['data'])
            {
                foreach($data['data'] as $item)
                {
                    ?>
                    <tr class="text-c">
                        <td><img width="50" src="<?php echo $item['headimgurl'];?>" alt=""/></td>
                        <td><?php echo $item['nickname']?></td>
                        <td><?php echo $item['help_count'];?></td>
                        <td><?php echo $item['product_price'];?></td>
                        <td><?php echo $item['min_price'];?></td>
                        <td><?php echo $item['minus_money']+$item['help_money'];?></td>
                        <td><?php echo $item['addtime'];?></td>
                        <td>
                            <a style="text-decoration:none" class="ml-5"
                               onclick="help_user('帮他砍价的人','?mod=admin&v_mod=admin_bargain&_index=_user_help',<?php echo $item['id']; ?>)"
                               href="javascript:;" title="查看帮他砍价的人"><i class="Hui-iconfont">&#xe62b;</i></a>
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
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
    });

    //参与用户
    function help_user(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id,
            end:function(){
                window.location.reload();
            }
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