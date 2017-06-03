<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetStoreInfo();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>店铺装修</title>
    <?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_meta_tpl.php';?>
    <link rel="stylesheet" href="/tool/upload/upload.css">
    <style type="text/css">
        .row{margin-top: 10px;}
    </style>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    商城管理
    <span class="c-gray en">&gt;</span>
    系统设置
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div id="tab-system" class="HuiTab">
        <div class="tabBar cl">
            <span>店铺信息</span>
            <span>首页Banner</span>
            <span>首页导航</span>
            <span>广告图</span>
        </div>
        <div class="tabCon">
            <form id="form-store-edit" action="?mod=admin&v_mod=shop&_index=_decorate&_action=ActionEditStoreInfo" method="post">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>
                            店铺名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" maxlength="32" minlength="3" id="store_name" name="store_name" placeholder="" value="<?php echo $data['store_name']; ?>" class="input-text">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>
                            店铺网址：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" maxlength="32" minlength="2" placeholder="" id="store_url" name="store_url" value="<?php echo $data['store_url']; ?>" class="input-text">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>
                            店铺logo：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <div id="store_load_upload">
                                <input type="hidden" name="store_logo"  value="<?php echo $data['store_logo']; ?>" id="store_logo">
                            </div>
                            <div id="store_load_pic">
                                <br/>
                                <img width="80" src="<?php echo $data['store_logo']; ?>" alt="">
                            </div>
                        </div>
                </div>


                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">
                        <span class="c-red">*</span>包邮开关：</label>
                    <div class="formControls col-xs-4 col-sm-4"> <span class="select-box">
                        <select onchange="if($(this).val()==1){$('#free_fee_money_div').show()}" name="free_fee" id="free_fee" class="select">
                            <option value="0" <?php echo $data['free_fee']==0?'selected':''; ?>>不包邮</option>
                            <option value="1" <?php echo $data['free_fee']==1?'selected':''; ?>>包邮</option>
                        </select>
                    </span>
                    </div>
                    <div class="formControls col-xs-4 col-sm-4">
                        <a href="javascript:void(0)" onClick="modaldemo()" style="color: #0000ff">不知道怎么设置?查看设置说明？</a>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">
                        <span class="c-red">*</span>单品运费开关：</label>
                    <div class="formControls col-xs-4 col-sm-4"> <span class="select-box">
                        <select name="product_ship_fee" id="product_ship_fee" class="select">
                            <option value="0" <?php echo $data['product_ship_fee']==0?'selected':''; ?>>不收单品运费</option>
                            <option value="1" <?php echo $data['product_ship_fee']==1?'selected':''; ?>>收取单品运费</option>
                        </select>
                    </span>
                    </div>

                    <div class="formControls col-xs-4 col-sm-4">
                        提示：单品运费意思是按商品本身填写的运费计算
                    </div>
                </div>

                <div class="row cl" id="free_fee_money_div" style="display:<?php echo $data['free_fee']?'block':'none'; ?>;">
                    <label class="form-label col-xs-4 col-sm-2">
                        <span class="c-red">*</span>满足包邮金额(元)：</label>
                    <div class="formControls col-xs-4 col-sm-4">
                        <input type="number" placeholder="请输入包邮金额(元)" id="free_fee_money" name="free_fee_money" value="<?php echo $data['free_fee_money']; ?>" class="input-text">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">
                        <span class="c-red">*</span>店铺运费(元)：</label>
                    <div class="formControls col-xs-4 col-sm-4">
                        <input type="number" placeholder="请输入运费金额(元)" id="ship_fee_money" name="ship_fee_money" value="<?php echo $data['ship_fee_money']; ?>" class="input-text">
                    </div>
                    <div class="formControls col-xs-4 col-sm-4">
                        提示：关闭或不满足包邮金额时收取的运费金额
                    </div>
                </div>


                <div class="row cl" id="store_qq_div">
                    <label class="form-label col-xs-4 col-sm-2">
                        <span class="c-red">*</span>
                        客服QQ：</label>
                    <div class="formControls col-xs-4 col-sm-2">
                        <input type="text" placeholder="请输入客服QQ" id="store_qq" name="store_qq" value="<?php echo $data['store_qq']; ?>" class="input-text">
                    </div>

                    <div class="formControls col-xs-4 col-sm-7">
                        链接QQ需要开通QQ的商户功能请移步到<a style="color: red" target="_blank" href="http://shang.qq.com/v3/widget.html">QQ商家沟通组件</a>进行开通设置
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">
                        <span class="c-red">*</span>
                        店铺介绍：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" id="store_describe" name="store_describe" placeholder="空制在80个汉字，160个字符以内" value="<?php echo $data['store_describe']; ?>" class="input-text">
                    </div>
                </div>

                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary radius" id="confirm_shop_info"><i class="Hui-iconfont">&#xe632;</i> 修改</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tabCon">
            <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
                <a class="btn btn-primary radius" onclick="banner_add('添加图片','?mod=admin&v_mod=shop&_index=_banner_add&type=0')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加图片</a>
            </div>
            <!--     banner       -->
            <?php $banner = $obj->getShopCommAD(0); ?>
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">图片</th>
                    <th width="100">标题</th>
                    <th width="100">链接</th>
                    <th width="150">排序</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody id="tbody">
                <?php
                if($banner)
                {
                    $i=0;
                    foreach($banner as $item)
                    {
                        $i++;
                        ?>
                        <tr class="text-c">
                            <td><img src="<?php echo $item['img']; ?>" width="50" class="picture-thumb" alt=""></td>
                            <td><?php echo $item['title']; ?></td>
                            <td><?php echo $item['page_url']; ?></td>
                            <td>第<?php echo $i; ?>张</td>
                            <td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" onClick="banner_edit('轮播图编辑','?mod=admin&v_mod=shop&_index=_banner_edit&type=0',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,0)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="tabCon">
            <!--      导航      -->
            <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
                <a class="btn btn-primary radius" onclick="banner_add('添加菜单','?mod=admin&v_mod=shop&_index=_banner_add&type=1')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加菜单</a>

            </div>
            <?php $banner = $obj->getShopCommAD(1); ?>
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">图片</th>
                    <th width="100">标题</th>
                    <th width="100">链接</th>
                    <th width="150">排序</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody id="tbody">
                <?php
                if($banner)
                {
                    $i=0;
                    foreach($banner as $item)
                    {
                        $i++;
                        ?>
                        <tr class="text-c">
                            <td><img src="<?php echo $item['img']; ?>" width="50" class="picture-thumb" alt=""></td>
                            <td><?php echo $item['title']; ?></td>
                            <td><?php echo $item['page_url']; ?></td>
                            <td>第<?php echo $i; ?>个</td>
                            <td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" onClick="banner_edit('菜单编辑','?mod=admin&v_mod=shop&_index=_banner_edit&type=1',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,1)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="tabCon">
            <!--      广告      -->
            <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
                <a class="btn btn-primary radius" onclick="banner_add('添加广告','?mod=admin&v_mod=shop&_index=_banner_add&type=2')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加广告</a>

            </div>
            <?php $banner = $obj->getShopCommAD(2); ?>
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">图片</th>
                    <th width="100">标题</th>
                    <th width="100">链接</th>
                    <th width="150">排序</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody id="tbody">
                <?php
                if($banner)
                {
                    $i=0;
                    foreach($banner as $item)
                    {
                        $i++;
                        ?>
                        <tr class="text-c">
                            <td><img src="<?php echo $item['img']; ?>" width="50" class="picture-thumb" alt=""></td>
                            <td><?php echo $item['title']; ?></td>
                            <td><?php echo $item['page_url']; ?></td>
                            <td>第<?php echo $i; ?>张</td>
                            <td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" onClick="banner_edit('广告图编辑','?mod=admin&v_mod=shop&_index=_banner_edit&type=2',<?php echo $item['id']; ?>)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="banner_del(this,<?php echo $item['id']; ?>,2)" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<div id="ship_fee_div" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content radius">
            <div class="modal-header">
                <h3 class="modal-title">运费设置提示说明</h3>
                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
            </div>
            <div class="modal-body">
                <p>

                    1、如打开了包邮开关，即购物金额达到满足包邮金额所填写的数字及可免邮，如关闭了包邮开关分两种情况：
                    <br/>
                    a、开了单品运费，商品运费按购物车内运费最高的计算。
                    <br/>
                    b、未开启单品运费，订单的运费为所填写的店铺运费。

                </p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
    </div>
</div>


<?php include RPC_DIR.TEMPLATEPATH.'/admin/_comm/_footer_tpl.php';?>
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

        $("#confirm_shop_info").click(function ()
        {
            var store_name = $("#store_name").val();
            var store_url = $("#store_url").val();
            var store_logo = $("#store_logo").val();
            var store_describe = $("#store_describe").val();
        });


        //店铺logo上传
        $('#store_load_upload').upload({
            auto:true,  //自动上传
            fileTypeExts:'*.jpg;*.png;*.exe',   //允许文件后缀
            multi:true, //多文件上传
            buttonText:'选择logo',
            fileSizeLimit:2048, //文件最大
            showUploadedPercent:true,//是否实时显示上传的百分比
            showUploadedSize:true,  //显示上传文件的大小
            removeTimeout:1000,  //超时时间
            uploader:'/tool/upload/upload.php',  //服务器地址
            onUploadSuccess:function(file,res,response)
            {
                var result = $.parseJSON(res);
                $("#store_load_pic").empty();
                $("#store_load_pic").append('<img src="'+result.path+'" width="100">')
                $("#store_logo").val(result.path);
            }
        });


        $("#form-store-edit").validate();

    });
    function modaldemo()
    {
        $("#ship_fee_div").modal("show")
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