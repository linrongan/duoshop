<?php
$data = $obj->GetUserList();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>客户列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 客户管理 <span class="c-gray en">&gt;</span> 客户资料 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="start_date" value="<?php if(isset($_REQUEST['start_date'])){echo $_REQUEST['start_date'];} ?>" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="end_date" value="<?php if(isset($_REQUEST['end_date'])){echo $_REQUEST['end_date'];} ?>" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" value="<?php if(isset($_REQUEST['nickname'])){echo $_REQUEST['nickname'];} ?>" style="width:250px" placeholder="输入昵称" id="" name="nickname">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="40">头像</th>
                <th width="60">昵称</th>
                <th width="80">性别</th>
                <th width="60">国家</th>
                <th width="100">省份</th>
                <th width="40">城市</th>
                <th width="40">添加时间</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
            if($data['data'])
            {
                foreach($data['data'] as $item)
                {
                    ?>
                    <tr class="text-c va-m">
                        <td><img width="50" class="avatar size-L radius" src="<?php echo $item['headimgurl']; ?>"></td>
                        <td>
                            <?php
                            if(isset($_REQUEST['nickname']) && !empty($_REQUEST['nickname']))
                            {
                                echo str_replace($_REQUEST['nickname'],'<span style="color: red;">'.$_REQUEST['nickname'].'</span>',$item['nickname']);
                            }else{
                                echo $item['nickname'];
                            }
                            ?>
                        </td>
                        <td><?php echo $item['sex']==1?'男':'女'; ?></td>
                        <td><?php echo $item['country']; ?></td>
                        <td><?php echo $item['province']; ?></td>
                        <td><?php echo $item['city']; ?></td>
                        <td><?php echo $item['saddtime']; ?></td>
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
            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['param']));
        echo $page->page_nav();
        ?>
    </div>
</div>

<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/laypage/1.2/laypage.js"></script>
</body>
<script>
    <?php
        if(!empty($data['param']) && empty($data['data']))
        {
            ?>
    layer.confirm('没有查出内容，是否初始化？',function(index)
    {
        location.href='?mod=admin&v_mod=user&_index=_list';
    });
    <?php
        }
    ?>
</script>
</html>