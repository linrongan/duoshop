<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetRoleMenuDetail();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <title>添加用户 - H-ui.admin v3.0</title>
</head>
<body>
<article class="page-container">
    <form action="?mod=admin&_index=_role_page_edit&_action=EditRoleAuth&id=<?php echo $_GET['id']; ?>" method="post" class="form form-horizontal" id="form-member-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">上级菜单：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" id="ry_parent_id" name="ry_parent_id">
                       <option value="0" <?php if ($data['ry_parent_id']==0) {echo 'selected';}?>>顶级菜单</option>
                       <?php $page_array=$obj->GetAdminAuthPage(0);
                       if (!empty($page_array))
                       {
                           $i=0;
                           foreach ($page_array as $page)
                           {
                               $i++;
                               ?>
                               <option <?php if ($data['ry_parent_id']==$page['id']) {echo 'selected';}?> value="<?php echo $page['id']; ?>">
                                   <?php echo $page['ry_menu']; ?>(<?php echo $page['ry_role_id']==1?"管理员":"普通商户"; ?>)
                               </option>
                               <?php
                               if (!empty($page))
                               {
                                   $array_key=array_keys($page);
                                   ?>
                                   <?php //找出需要循环数组的二级分类
                                   foreach ($array_key as $key=>$value)
                                   {
                                       if (is_array($page[$value]))
                                       {

                                           ?>
                                           <option <?php if ($data['ry_parent_id']==$page[$value]['id']){echo 'selected';}?> value="<?php echo $page[$value]['id'];?>">
                                           |_____<?php echo $page[$value]['ry_menu'];?></option>
                                           <?php
                                       }
                                   }
                               }
                           }
                       } ?>
				</select>
				</span>
            </div>
        </div>



        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['ry_menu']; ?>" placeholder="" id="ry_menu" name="ry_menu">
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">菜单类型：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="menu_type" id="menu_type">
					<option value="" selected>请选择类型</option>
                    <option value="0" <?php if ($data['menu_type']==0) { echo 'selected';} ?>>菜单</option>
                    <option value="1" <?php if ($data['menu_type']==1) { echo 'selected';} ?>>功能</option>
				</select>
				</span> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select" size="1" id="ry_role_id" name="ry_role_id">
                    <option value="1" <?php if ($data['ry_role_id']==1){echo 'selected';} ?> >管理员</option>
                    <option value="2" <?php if ($data['ry_role_id']==2){echo 'selected';} ?>>普通商户</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> 客户端：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="select select-box" size="1" id="port_type" name="port_type">
                    <option value="0" <?php if ($data['port_type']==0){echo 'selected';} ?> >默认（手机端）</option>
                    <option value="1" <?php if ($data['port_type']==1){echo 'selected';} ?> >电脑端</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="ry_link" id="ry_link" cols="" rows="" class="textarea"  placeholder="链接地址" onKeyUp="$.Huitextarealength(this,255)"><?php echo $data['ry_link']; ?></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/255</p>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['ry_order']; ?>" placeholder="" id="ry_order" name="ry_order">
            </div>
        </div>


        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/template/source/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/template/source/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){
        $("#form-member-add").validate({
            rules:{
                ry_menu:{
                    required:true,
                    minlength:2,
                    maxlength:32
                },
                menu_type:{
                    required:true
                },
                ry_link:{
                    required:true
                },
                ry_order:{
                    required:true
                }
            }
        });
    });
    <?php
    if(isset($_return))
    {
    ?>
    alert('<?php echo $_return['msg']; ?>');
    window.parent.location.reload();
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    <?php
    }
    ?>
</script>
</body>
</html>