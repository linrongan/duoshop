<header class="navbar-wrapper">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid cl">
            <a class="logo navbar-logo f-l mr-10 hidden-xs" href=""><?php echo WEBNAME; ?></a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs">v1.0</span>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
			<!--<nav class="nav navbar-nav">
				<ul class="cl">
					<li class="dropDown dropDown_hover"><a href="javascript:;" class="dropDown_A"><i class="Hui-iconfont">&#xe600;</i> 新增 <i class="Hui-iconfont">&#xe6d5;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="javascript:;" onclick="article_add('添加资讯','article-add.html')"><i class="Hui-iconfont">&#xe616;</i> 资讯</a></li>
							<li><a href="javascript:;" onclick="picture_add('添加资讯','picture-add.html')"><i class="Hui-iconfont">&#xe613;</i> 图片</a></li>
							<li><a href="javascript:;" onclick="product_add('添加资讯','product-add.html')"><i class="Hui-iconfont">&#xe620;</i> 产品</a></li>
							<li><a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')"><i class="Hui-iconfont">&#xe60d;</i> 用户</a></li>
						</ul>
					</li>
				</ul>
			</nav>-->
			<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
				<ul class="cl">



					<li>
                        <?php
                        echo $_SESSION['role_id']==1?"管理员":"普通商户";
                        ?>
                    </li>
					<li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A"><?php echo $_SESSION['admin_name']; ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="#">个人信息</a></li>
							<li><a href="?mod=admin&_action=AdminLogout">切换账户</a></li>
							<li><a href="?mod=admin&_action=AdminLogout">退出</a></li>
						</ul>
					</li>
                    <?php
                        if($_SESSION['role_id']==1)
                        {
                            //管理员
                            $no_see = $obj->GetNoSeeHelpCount();
                            ?>
                            <li id="Hui-msg">
                                <a href="?mod=admin&v_mod=admin_seekhelp&_index=_list" target="content" title="消息">
                                    <?php
                                        if($no_see)
                                        {
                                            ?>
                                            <span class="badge badge-danger"><?php echo $no_see; ?></span>
                                            <?php
                                        }
                                    ?>
                                    <i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i>
                                </a>
                            </li>
                            <li class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="切换客户端"><i class="Hui-iconfont" style="font-size:18px">&#xe63c;</i></a>
                                <ul class="dropDown-menu menu radius box-shadow" id="port_tab">
                                    <li><a href="javascript:;" onclick="port_tab(0)">默认（手机端）</a></li>
                                    <li><a href="javascript:;" onclick="port_tab(1)">电脑端</a></li>
                                </ul>
                            </li>
                            <?php
                        }else
                        {
                            ?>
                            <li id="Hui-msg"><a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
                            <?php
                        }
                    ?>

					<li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
							<li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
							<li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
							<li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
							<li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
							<li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>
<script>
    function port_tab(type){
        $.ajax({
            type: 'POST',
            url: '/?mod=admin&_action=ActionChangePortType&type='+type,
            data:{'type':type},
            dataType: 'json',
            success: function(res)
            {
                if (res.code==0)
                {
                    window.location.href='/?mod=admin';
                }
            },
            error:function(res) {
                console.log(res.msg);
                alert('网络超时')
            }
        });
    }
</script>