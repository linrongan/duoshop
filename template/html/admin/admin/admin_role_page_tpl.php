<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetAdminAuthPage(0);
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
           <!-- <a href="javascript:;" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>-->
            <a href="javascript:;" onclick="admin_role_add('添加权限','/?mod=admin&_index=_role_page_new','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 新增</a>
        </span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">名称</th>
                <th width="50">角色</th>
                <th width="50">客户端</th>
                <th width="50">排序</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php
                if(!empty($data))
                {
                    $_role=array(1=>"管理员",2=>"普通商户");
                    $_port = array(0=>"手机端",1=>"电脑端");
                   foreach($data as $item)
                   {
                       ?>
                       <tr class="text-c" rel="1">
                           <td><input type="checkbox" value="<?php echo $item['id']; ?>" class="one_menu"></td>
                           <td class="text-l"><?php echo $item['ry_menu'];?></td>
                           <td> <?php echo $_role[$item['ry_role_id']];?></td>
                           <td> <?php echo $_port[$item['port_type']];?></td>
                           <td> <?php echo $item['ry_order'];?></td>

                           <td class="td-manage">
                               <a title="编辑" href="javascript:;" onclick="admin_role_edit('编辑','?mod=admin&_index=_role_page_edit','<?php echo $item['id']; ?>','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                               <a title="删除" href="javascript:;" onclick="admin_role_del(this,<?php echo $item['id']; ?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                           </td>
                       </tr>
                       <?php
                       if (!empty($item))
                       {
                           $array_key=array_keys($item);
                           foreach($array_key as $key=>$value)
                           {
                               if (is_array($item[$value]))
                               {
                                   ?>
                                   <tr class="text-c" rel="2">
                                       <td><input type="checkbox" value="<?php echo $item[$value]['id']; ?>" name="" class="two_menu"></td>
                                       <td class="text-l">&nbsp;&nbsp;&nbsp;|____<?php echo $item[$value]['ry_menu'];?></td>
                                       <td> <?php echo $_role[$item[$value]['ry_role_id']];?></td>
                                       <td> <?php echo $_port[$item[$value]['port_type']];?></td>
                                       <td> <?php echo $item[$value]['ry_order'];?></td>
                                       <td class="td-manage">
                                           <a title="编辑" href="javascript:;" onclick="admin_role_edit('编辑','?mod=admin&_index=_role_page_edit','<?php echo $item[$value]['id']; ?>','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                                           <a title="删除" href="javascript:;" onclick="admin_role_del(this,<?php echo $item[$value]['id']; ?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                                       </td>
                                   </tr>
                                   <?php
                                   $array_key_sub=array_keys($item[$value]);
                                   foreach ($array_key_sub as $k=>$v)
                                   {
                                       if (is_array($item[$value][$v]))
                                       {
                                           ?>
                                           <tr class="text-c" rel="3">
                                               <td><input type="checkbox" value="<?php echo $item[$value][$v]['id']; ?>" name="" class="three_menu"></td>
                                               <td class="text-l">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|________ <?php echo $item[$value][$v]['ry_menu'];?></td>
                                               <td> <?php echo $_role[$item[$value][$v]['ry_role_id']];?></td>
                                               <td> <?php echo $_port[$item[$value][$v]['port_type']];?></td>
                                               <td> <?php echo $item[$value][$v]['ry_order'];?></td>
                                               <td class="td-manage">
                                                   <a title="编辑" href="javascript:;" onclick="admin_role_edit('编辑','?mod=admin&_index=_role_page_edit','<?php echo $item[$value][$v]['id']; ?>','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                                                   <a title="删除" href="javascript:;" onclick="admin_role_del(this,<?php echo $item[$value][$v]['id']; ?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                                               </td>
                                           </tr>
                                           <?php

                                       }
                                   }
                               }
                           }
                       }
                   }
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('.table-sort').dataTable({
            "bStateSave": true,//状态保存
            "bSort": false,
            "paging": false, // 禁止分页
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,1,4]}// 制定列不参与排序
            ]
        });
    });

    /*菜单-新增*/
    function admin_role_add(title,url,w,h)
    {
        layer_show(title,url,w,h);
    }
    /*菜单-编辑*/
    function admin_role_edit(title,url,id,w,h){
        layer_show(title,url+'&id='+id,w,h);
    }

    /*菜单-删除*/
    function admin_role_del(obj,id){
        layer.confirm('确认要删除吗？',function(index)
        {
            $.ajax({
                type: 'POST',
                url: '?mod=admin&_action=DelAuthPage&id='+id,
                dataType: 'json',
                success: function(data)
                {
                    layer.msg(data.msg,{icon:1,time:1000});
                    if(data.code==0)
                    {
                        $(obj).parents("tr").remove();
                    }
                },
                error:function(data)
                {
                    console.log(data.msg);
                    alert('网络超时')
                }
            });
        });
    }

</script>
</body>
</html>