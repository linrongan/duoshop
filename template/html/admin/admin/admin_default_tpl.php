<?php
    $info = $obj->GetLastLogin();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>我的桌面</title>
</head>
<body>
<div class="page-container">
    <p class="f-20 text-success">欢迎使后台管理系统！</p>
    <p>登录次数：<?php echo $info['count']; ?> </p>
    <?php
        if($info['data'])
        {
            ?>
            <p>上次登录IP：<?php echo $info['data']['login_ip']; ?>
               上次登录时间：<?php echo $info['data']['login_date']; ?>
            </p>
            <?php
        }
    ?>

    <?php if ($_SESSION['role_id']==1){
        include RPC_DIR."/inc/serverInfo.php";
        $ServerInfo = new ServerInfo();
    ?>
    <table class="table table-border table-bordered table-bg mt-20">
        <thead>
        <tr>
            <th colspan="2" scope="col">服务器信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>服务器时间</td>
            <td><?php echo $ServerInfo->GetServerTime(); ?></td>
        </tr>
        <tr>
            <td>服务器IP地址</td>
            <td><?php echo $_SERVER['SERVER_ADDR']; ?></td>
        </tr>

        <tr>
            <td>服务器版本 </td>
            <td><?php echo $ServerInfo->GetServerSoftwares(); ?></td>
        </tr>

        <tr>
            <td>系统所在文件夹 </td>
            <td><?php echo $ServerInfo->GetDocumentRoot(); ?></td>
        </tr>

        <tr>
            <td>系统占用空间 </td>
            <td><?php echo dirSize($ServerInfo->GetDocumentRoot())/1024/1024; ?></td>
        </tr>

        <tr>
            <td>PHP版本 </td>
            <td><?php echo $ServerInfo->GetPhpVersion(); ?></td>
        </tr>


        <tr>
            <td>HTTP版本 </td>
            <td><?php echo $ServerInfo->GetHttpVersion(); ?></td>
        </tr>
        <tr>
            <td>最大执行时间 </td>
            <td><?php echo $ServerInfo->GetMaxExecutionTime(); ?></td>
        </tr>
        <tr>
            <td>文件上传 </td>
            <td><?php echo $ServerInfo->GetServerFileUpload(); ?></td>
        </tr>
        <tr>
            <td>内存占用 </td>
            <td><?php echo $ServerInfo->GetMemoryUsage(); ?></td>
        </tr>
        </tbody>
    </table>
    <?php }else{?>
        <!--
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th colspan="7" scope="col">信息统计</th>
            </tr>
            <tr class="text-c">
                <th>统计</th>
                <th>资讯库</th>
                <th>图片库</th>
                <th>产品库</th>
                <th>用户</th>
                <th>管理员</th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-c">
                <td>总数</td>
                <td>92</td>
                <td>9</td>
                <td>0</td>
                <td>8</td>
                <td>20</td>
            </tr>
            <tr class="text-c">
                <td>今日</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr class="text-c">
                <td>昨日</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr class="text-c">
                <td>本周</td>
                <td>2</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr class="text-c">
                <td>本月</td>
                <td>2</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            </tbody>
        </table>-->
    <?php } ?>
</div>
<script type="text/javascript" src="/template/source/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/template/source/admin/static/h-ui/js/H-ui.min.js"></script>
</body>
</html>