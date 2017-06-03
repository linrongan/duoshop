<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetAdvertRecord();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>广告投放</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/tool/upload/upload.css">
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    广告投放
    <span class="c-gray en">&gt;</span>
    投放记录
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">


    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
         <a class="btn btn-primary radius" onclick="banner_add('新增投放','?mod=admin&v_mod=advert&_index=_picture_add')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i>新增投放</a>
    </div>
    <div class="mt-20">
        <?php  ?>
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">图片</th>
                <th width="100">标题</th>
                <th width="150">链接</th>
                <th width="150">区域</th>
                <th width="100">投放时长</th>
                <th width="100">投放时段</th>
                <th width="100">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data['data'])
            {
                $date=date("Y-m-d H:i:s");
                foreach($data['data'] as $item)
                {
                    ?>
                    <tr class="text-c">
                        <td width="100"><img src="<?php echo $item['picture_img']; ?>" width="50" class="picture-thumb" alt=""></td>
                        <td><?php echo $item['picture_title']; ?></td>
                        <td width="150"><?php echo $item['picture_link']; ?></td>
                        <td width="80"><?php echo $item['name']; ?></td>

                        <td width="80"><?php echo $item['advert_day']; ?>小时</td>
                        <td width="150">
                            <?php echo $item['start_time']; ?><br/>至<br/>
                            <?php echo $item['expire_time']; ?>
                        </td>
                        <td width="80">
                            <?php
                            if($item['status']==0)
                            {
                                echo '<span class="label label-default radius">待审核</span>';
                            }elseif($item['status']==1)
                            {
                                if (strtotime($date)>strtotime($item['expire_time']))
                                {
                                    echo '<span class="label label-danger radius">已过期</span>';
                                }elseif(strtotime($date)>strtotime($item['start_time']))
                                {
                                    echo '<span class="label label-danger radius">未开始</span>';
                                }
                                else
                                {
                                    echo '<span class="label label-success radius">已生效</span>';
                                }
                            }else
                            {
                                echo '<span class="label label-danger radius">已过期</span>';
                            }
                            ?>
                        </td>
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5"
                               onClick="advert_pay('微信扫码支付','<?php echo $item['id']; ?>')"
                               href="javascript:;" title="支付投放费用"><i class="Hui-iconfont">&#xe6cb;</i>
                            </a>
                            <a style="text-decoration:none" class="ml-5" onClick="banner_edit('编辑','?mod=admin&v_mod=advert&_index=_picture_edit',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,0)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
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
<script type="text/javascript" src="/template/source/admin/lib/qrcode/jquery.qrcode.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/qrcode/qrcode.js"></script>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/tool/upload/upload.js"></script>
<script type="text/javascript">
    $(function(){


        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click","0");


    });
    //
    function advert_pay(title,id){
        //$('#qrcode_img').html('');
        $('#qrcode_img').html('').qrcode({
            // render	: "table",
            width:200,
            height:200,
            text	: '<?php echo WEBURL;?>?mod=weixin&v_mod=advert&_index=_pay&a_id='+id
        });
        var index = layer.open({
            type: 1,
            title: title,
            closeBtn: 0,
            area: '230px',
            //skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: $('#qrcode_img').show()
        });
        //layer.full(index);
    }

    //首页banner
    function banner_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url+'&id='+id
        });
        layer.full(index);
    }
    /*图片-添加*/
    function banner_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-删除*/
    function banner_del(obj,id,type){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '?mod=admin&v_mod=shop&_action=ActionDelShopBanner',
                data:{id:id,type:type},
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:data.code==1?5:6,time:1000});
                    if(data.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
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