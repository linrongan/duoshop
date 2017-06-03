<?php
$data = $obj->GetOneApply();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/rest.css?66666">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/main.css?99999aaa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/newmain.css?1010aaa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/ggPublic.css?8888aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/weixin/css/moban1.css?777777">
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <title>店铺申请</title>
    <style>
		.weui-label{width:5rem;}
    	.weui-cell{padding:.5rem 3%;}
		.apply-shop-title{height:2rem; line-height:2rem; text-align:center;}
		.apply-shop-title>span{position:relative;}
		.apply-shop-title>span::before,.apply-shop-title>span::after{content:''; width:50px; height:1px; border-top:1px solid #ededed; position:absolute; top:50%; z-index:2;}
		.apply-shop-title>span::before{left:-60px;}
		.apply-shop-title>span::after{right:-60px;}
		
		::-webkit-input-placeholder { /* WebKit browsers */
			color: #d9d9d9;
		}
		:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
			color: #d9d9d9;
		}
		::-moz-placeholder { /* Mozilla Firefox 19+ */
			color: #d9d9d9;
		}
		:-ms-input-placeholder { /* Internet Explorer 10+ */
			color: #d9d9d9;
		}
    </style>
</head>
<body>
    <?php
        if($data)
        {
            if($data['status']==0)
            {
                if(isset($_GET['show_info']))
                {
                    ?>
                    <h1 class="tc apply-shop-title"><span class="f16">我的申请</span></h1>
                    <div class="weui-cells" style="margin-top:0;">
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label f14">店铺名：</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input  f14" maxlength="26" id="shop_name" value="<?php echo $data['shop_name']; ?>" type="text"  placeholder="请输入您的店铺名称">
                            </div>
                        </div>

                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label f14">真实姓名：</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input  f14" maxlength="30" id="name" type="text" value="<?php echo $data['name']; ?>"  placeholder="请输入您的姓名">
                            </div>
                        </div>

                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label f14">手机(管理账号)：</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input  f14" maxlength="11" id="phone" type="number" value="<?php echo $data['phone']; ?>" placeholder="请输入您的手机">
                            </div>
                        </div>

                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label f14">管理密码：</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input  f14" maxlength="16" id="password" value="<?php echo $data['password']; ?>" type="text"  placeholder="请输入您的管理密码">
                            </div>
                        </div>

                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label f14">邮箱地址：</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input  f14" maxlength="11" id="email" value="<?php echo $data['email']; ?>" type="text"  placeholder="请输入您的常用邮箱地址">
                            </div>
                        </div>

                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label f14">联系地址：</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input  f14" maxlength="150" id="address" value="<?php echo $data['address']; ?>" type="text"  placeholder="请输入您的联系地址">
                            </div>
                        </div>

                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label f14">经营类型：</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input  f14" maxlength="150" id="miaoshu" value="<?php echo $data['miaoshu']; ?>" type="text"  placeholder="请输入经营类型">
                            </div>
                        </div>

                    </div>
                    <div  style="padding:0 15%; margin-top:20px;">
                        <a href="javascript:;" onclick="apply('update')" class="weui-btn weui-btn_primary" style="font-size:16px;">修改</a>
                        <a href="/?mod=apply&_index=_shop" class="weui-btn weui-btn_default" style="font-size:16px;">返回</a>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="page msg_success js_show">
                        <div class="weui-msg">
                            <div class="weui-msg__icon-area"><i class="weui-icon_msg weui-icon-warn"></i></div>
                            <div class="weui-msg__text-area">
                                <h2 class="weui-msg__title">申请资料提交成功</h2>
                                <p class="weui-msg__desc">1-7个工作日我们将通过电话联系到您  请保持接听状态</p>
                            </div>
                            <div class="weui-msg__opr-area">
                                <p class="weui-btn-area">
                                    <a href="/?mod=apply&_index=_shop&show_info" class="weui-btn weui-btn_default">查看</a>
                                    <a href="javascript:;" onclick="WeixinJSBridge.call('closeWindow')" class="weui-btn weui-btn_primary">关闭</a>
                                </p>
                            </div>
                            <div class="weui-msg__extra-area">
                                <div class="weui-footer">
                                    <p class="weui-footer__links">
                                        <a href="?mod=weixin" class="weui-footer__link"><?php echo WEBNAME; ?></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }elseif($data['status']==1){
                //不通过
                ?>
                <div class="page msg_success js_show">
                    <div class="weui-msg">
                        <div class="weui-msg__icon-area"><i class="weui-icon_msg weui-icon-warn"></i></div>
                        <div class="weui-msg__text-area">
                            <h2 class="weui-msg__title">你的入驻申请不通过</h2>
                            <p class="weui-msg__desc">请修改你的申请资料</p>
                        </div>
                        <div class="weui-msg__opr-area">
                            <p class="weui-btn-area">
                                <a href="?mod=apply&_index=_shop_edit" class="weui-btn weui-btn_default">修改</a>
                                <a href="javascript:;" onclick="WeixinJSBridge.call('closeWindow')" class="weui-btn weui-btn_primary">关闭</a>
                            </p>
                        </div>
                        <div class="weui-msg__extra-area">
                            <div class="weui-footer">
                                <p class="weui-footer__links">
                                    <a href="?mod=weixin" class="weui-footer__link"><?php echo WEBNAME; ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                //通过
            }
        }else{
            ?>
            <h1 class="tc apply-shop-title"><span class="f16">商家店铺入驻申请</span></h1>
            <div class="weui-cells" style="margin-top:0;">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label f14">店铺名：</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input  f14" maxlength="26" id="shop_name" type="text"  placeholder="请输入您的店铺名称">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label f14">真实姓名：</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input  f14" maxlength="30" id="name" type="text"  placeholder="请输入您的姓名">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label f14">手机：</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input  f14" maxlength="11" id="phone" type="number"  placeholder="请输入您的手机">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label f14">管理密码：</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input  f14" maxlength="16" id="password" type="text"  placeholder="请输入您的管理密码">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label f14">邮箱地址：</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input  f14" maxlength="50" id="email" type="text"  placeholder="请输入您的常用邮箱地址">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label f14">联系地址：</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input  f14" maxlength="150" id="address" type="text"  placeholder="请输入您的联系地址">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label f14">经营类型：</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input  f14" maxlength="150" id="miaoshu" type="text"  placeholder="请输入经营类型">
                    </div>
                </div>
            </div>
            <div  style="padding:0 15%; margin-top:20px;">
                <a href="javascript:;" onclick="apply('add')" class="weui-btn weui-btn_primary" style="font-size:16px;">申请店铺</a>
            </div>
            <?php
        }
    ?>
	<script src="/template/source/weixin/js/jquery-2.1.4.js"></script>
    <script src="/template/source/weixin/js/jquery-weui.min.js"></script>
    <script src="/template/source/weixin/js/fastclick.js"></script>
    <script src="/template/source/weixin/js/guageEdit.js"></script>
    <script src="/tool/layer/layer/layer.js"></script>
</body>
<script>
function apply(action)
{
    var shop_name = $("#shop_name").val();
    var name = $("#name").val();
    var phone = $("#phone").val();
    var address = $("#address").val();
    var miaoshu = $("#miaoshu").val();
    var password = $("#password").val();
    var email = $("#email").val();
    if(shop_name.length<=0)
    {
        if(name.length<=0)
        {
            layer.msg('请输入您需要申请的店铺名');
            return false;
        }
    }
    if(name.length<=0)
    {
        layer.msg('请输入您的姓名');
        return false;
    }
    if(phone.length<=0)
    {
        layer.msg('请输入您的手机');
        return false;
    }else if(isNaN(phone) || phone.length!=11)
    {
        layer.msg('手机号码位数不够');
        return false;
    }
    if(password.length<=0)
    {
        layer.msg('请输入管理密码');
        return false;
    }else if(password.length<6)
    {
        layer.msg('管理密码至少输入6位');
        return false;
    }
    if(email.length<=0)
    {
        layer.msg('请输入邮箱地址');
        return false;
    }
    if(address.length<=0)
    {
        layer.msg('请输入地址');
        return false;
    }
    if(miaoshu.length<=0)
    {
        layer.msg('请输入描述');
        return false;
    }
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        type:'post',
        url:'/?mod=apply&_index=_shop&_action=ActionShopApply',
        data:{
            name:name,
            phone:phone,
            address:address,
            miaoshu:miaoshu,
            shop_name:shop_name,
            password:password,
            type:action,
            email:email
        },
        dataType:'json',
        success:function (data)
        {
            layer.close(index);
            if(action=='add')
            {
                location.href='/?mod=apply&_index=_shop';
            }else{
                layer.msg('修改成功');
            }
        },
        error:function ()
        {
            layer.close(index);
        }
    });
}
</script>
</html>