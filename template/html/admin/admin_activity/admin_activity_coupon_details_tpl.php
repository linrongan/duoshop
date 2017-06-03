<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$details = $obj->getOneCoupon();
$data = $details['data'];
//echo "<pre>";
//var_dump($data);exit;
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>优惠卷详情</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 营销管理
    <span class="c-gray en">&gt;</span> 优惠卷详情
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="codeView cl pd-5 mt-20">
        <div class="panel panel-default">
            <div class="panel-header">详细信息</div>

            <table class="table table-border table-bordered table-bg table-hover">
                <tr>
                    <td>编号：</td>
                    <td>
                        <?php echo $data['id']; ?>
                    </td>
                </tr>
                <tr>
                    <td>使用店铺：</td>
                    <td>
                        <?php echo $data['store_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>优惠卷名字：</td>
                    <td>
                        <?php echo $data['coupon_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>优惠卷code：</td>
                    <td>
                        <?php echo $data['coupon_code']; ?>
                    </td>
                </tr>
                <tr>
                    <td>优惠卷类型：</td>
                    <td>
                        <?php echo $data['type_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>优惠卷金额：</td>
                    <td>
                        <?php echo $data['coupon_money']; ?>
                    </td>
                </tr>
                <tr>
                    <td>最小支付金额：</td>
                    <td>
                        <?php echo $data['min_money']; ?>
                    </td>
                </tr>
                <tr>
                    <td>开始时间：</td>
                    <td>
                        <?php echo $data['start_time']; ?>
                    </td>
                </tr>
                <tr>
                    <td >结束时间：</td>
                    <td>
                        <?php echo $data['expire_time']; ?>
                    </td>
                </tr>
                <tr>
                    <td>来源：</td>
                    <td>
                        <?php echo $data['source']; ?>
                    </td>
                </tr>
                <tr>
                    <td >状态：</td>
                    <td>
                        <?php echo $data['use_status']==0?'未使用':'已使用'; ?>
                    </td>
                </tr>
                <tr>
                    <td >使用时间：</td>
                    <td>
                        <?php echo $data['use_time']?$data['use_time']:'未使用'; ?>
                    </td>
                </tr>
                <tr>
                    <td>使用者：</td>
                    <td>
                        <?php echo $data['nickname']; ?>
                    </td>
                </tr>
                <tr>
                    <td>使用限制：</td>
                    <td>
                        <?php
                            $c =" ";
                            if($data['category_id'])
                            {
                                $category_id = explode(",",$data['category_id']);
                                for($i=0;$i<count($category_id);$i++)
                                {
                                    if(isset($details['category'][$category_id[$i]]))
                                    {
                                        $c .= $details['category'][$category_id[$i]]['category_name'].',';
                                    }
                                }
                                echo rtrim($c,',');
                            }else{
                                echo '无';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td >订单：</td>
                    <td >
                        <?php echo $data['orderid']?$data['orderid']:'无'; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <a href="javascript:;" onclick="javascript :history.back(-1);" class="btn btn-success-outline radius mt-20">返回上一页</a>
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


</script>
</body>
</html>