<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->getPageBanner();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>官网咨询</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 官网咨询
    <span class="c-gray en">&gt;</span> 页面banner
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">

    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">页面banner列表</th>
        </tr>
        <tr class="text-c">
            <th>页面</th>
            <th>图片</th>
            <th>添加时间</th>
            <th>编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data)){
            foreach($data as $item){
                ?>
                <tr class="text-c">
                    <td><?php echo $item['picture_title'];?></td>
                    <td>
                        <?php
                            if($item['picture_path']){
                                ?>
                                <img src="<?php echo $item['picture_path'];?>" width="50" alt=""/>
                                <?php
                            }
                        ?>
                    </td>
                    <td><?php echo $item['picture_addtime'];?></td>
                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="banner_edit('编辑','?mod=admin&v_mod=pc&_index=_page_banner_edit','<?php echo $item['id'];?>','','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                    </td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    /*
     参数解释：
     title	标题
     url		请求的url
     id		需要操作的数据id
     w		弹出层宽度（缺省调默认值）
     h		弹出层高度（缺省调默认值）
     */
    /*增加*/
    function banner_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    //$("#txt_spCodes").val(spCodesTemp);
    /*编辑*/
    /*编辑*/
    function banner_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }




</script>
</body>
</html>