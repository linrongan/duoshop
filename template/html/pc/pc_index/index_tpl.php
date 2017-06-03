<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <link type="text/css" rel="stylesheet" href="/template/source/pc_shop/css/home page.css" />
    <link type="text/css" rel="stylesheet" href="/template/source/pc_shop/css/swiper.min.css" />
</head>

<body class="mhome">

<div class="tugoobar">
    <ul class="tugoobarc">
        <li class="cspic"><a href="#"><img src="/template/source/pc_shop/img/peo.png"></a></li>
        <li class="lmd"><a href="/template/source/pc_shop/cart.aspx"><img src="/template/source/pc_shop/img/cart.png"><span>购<br>物<br>车</span></a></li>
        <li class="cspic"><a href="/template/source/pc_shop/user/collect.aspx"><img src="/template/source/pc_shop/img/col.png"></a></li>
    </ul>
    <ul class="tugoobarc1">
        <li><a href="tencent://message/?uin=2075263211&amp;Site=&amp;Menu=yes" onclick="return true;mechatClick()"><img src="/template/source/pc_shop/img/kf.png"><span>客<br>服</span></a></li>
        <li class="gotop"><a href="javascript:void(0);" class="ewm"><em><img src="/template/source/pc_shop/img/ewm.png"></em></a></li>
    </ul>
</div>


<div class="big-box">
<!--top-->
<div class="top">
    <div class="top-box">
        <ul class="top-box-Left">
            <li>
                <span>你好，欢迎来到乡粑网！</span>
            </li>
            <li>
                <a href="denglu.html">请登录</a>
            </li>
            <li>
                <a href="zhuce.html" class="ys-01">免费注册</a>
            </li>
        </ul>
        <ul class="top-box-right">
            <li>
                <a href="">购物车</a>
                <span>0</span>
            </li>
            <li>
                <a href="">我的订单</a>
            </li>
            <li>
                <a href="">我的主页</a>
            </li>
            <li>
                <a href="">卖家中心</a>
            </li>
            <li class="class=" Telephone"">
                <img src="/template/source/pc_shop/img/Telephone.png"/>
                <span class="Telephone-ys">客服热线:</span>
                <span>4008002923</span>
            </li>
        </ul>
    </div>
</div>
<!--top-->
<div class="header-big-box">
    <div class="header-box">
        <a href="" class="logo">
            <img src="/template/source/pc_shop/img/logo.png" />
        </a>
        <!--搜索-->
        <div class="search-box">
            <!--开始-->
            <div class="search">
                <!--下拉-->
                <div class="selectwrap" onclick="sodis();" onmouseout="hideso();">
                    <div id="selectvalue">商品</div>
                    <img src="/template/source/pc_shop/img/01.png" />
                    <input type="hidden" id="searchtype" name="searchtype" value="0">
                    <div id="options" style="display:none; overflow: hidden;" onmouseout="hideso();" onmouseover="showso();">
                        <a href="javascript:void(0);" onclick="setselect('0','商品');">商品</a>
                        <a href="javascript:void(0);" onclick="setselect('1','店铺');">店铺</a>
                        <a href="javascript:void(0);" onclick="setselect('2','资讯');">资讯</a>
                        <a href="javascript:void(0);" onclick="setselect('3','供求');">供求</a>
                        <a href="javascript:void(0);" onclick="setselect('4','黄页');">黄页</a>
                    </div>
                </div>
                <!--搜索-->
                <div class="keyword">
                    <input type="text" name="searchword" id="searchword" onclick="if ($(this).val() == '请输入搜索信息') $(this).val('')" onblur="if ($(this).val() == '') $(this).val('请输入搜索信息')"  placehoher="请输入搜索信息" value="请输入搜索信息">

                </div>
                <!--搜索-->
                <div class="search_btn">
                    <button type="button" onclick="search()">搜索</button>
                </div>
            </div>
            <p>
                <a href="/category.aspx?wd=苹果" target="_blank">苹果</a>
                <a href="/category.aspx?wd=榴莲" target="_blank">榴莲</a>
                <a href="/category.aspx?wd=脐橙" target="_blank">脐橙</a>
                <a href="/category.aspx?wd=有机蔬菜" target="_blank">有机蔬菜</a>
                <a href="/category.aspx?wd=牛肉" target="_blank">牛肉</a>
                <a href="/category.aspx?wd=散养土鸡" target="_blank">散养土鸡</a>
                <a href="/category.aspx?wd=三文鱼" target="_blank">三文鱼</a>
                <a href="/category.aspx?wd=开心果" target="_blank">开心果</a>
            </p>
        </div>
        <!--微信开始-->
        <div class="htwx right" style=" width:270px;">
            <em><img src="/template/source/pc_shop/img/IOS.png">苹果APP</em>
            <em style=" margin-right:12px;"><img src="/template/source/pc_shop/img/android.png">安卓APP</em>
            <span>扫一扫<br>下载App</span>
        </div>
    </div>

</div>
<!--导航开始-->
<div class="xian">
<div class="nav-box">
<div class="siderlf left">
<div class="nav clear">
<div class="navbg"></div>
<div class="wrap clear">
<div class="siderlf left">
<h2><a href="/category.aspx">全部商品分类</a></h2>
<div class="sort" style=" display:block">
<div id="newPriceLinks" class="newPriceLinks newss">
<ul>
<?php
    $category = $obj->GetCategory();
    if(isset($category['category'][0]) && !empty($category['category'][0]))
    {
        foreach($category['category'][0] as $item)
        {
            ?>
            <li class="">
                <p class="tit"><strong><i class="i1"></i><a href=""><?php echo $item['category_name'];?></a></strong>
                    <font>
                        <?php
                            if(!empty($item['category_spec']))
                            {
                                $spec = explode(",",$item['category_spec']);
                                for($i=0;$i<count($spec);$i++)
                                {
                                    if(isset($category['category_info'][$spec[$i]]))
                                    {
                                        ?>
                                        <a href="<?php echo $spec[$i];?>" target="_blank"><?php echo $category['category_info'][$spec[$i]]['category_name'];?></a>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </font>
                </p>
                <p class="arrow" style=" top:1px;"></p>
                <div style=" display: none;">
                    <span>
                        <?php
                            if(isset($category['category'][$item['category_id']]) &&
                                !empty($category['category'][$item['category_id']]))
                            {
                                foreach($category['category'][$item['category_id']] as $item)
                                {
                                    ?>
                                    <dl>
                                        <dt> <a href=""><?php echo $item['category_name'];?></a></dt>
                                        <dd>
                                            <?php
                                                if(isset($category['category'][$item['category_id']]) &&
                                                    !empty($category['category'][$item['category_id']]))
                                                {
                                                    foreach($category['category'][$item['category_id']] as $item)
                                                    {
                                                        ?>
                                                        <em><a href=""><?php echo $item['category_name'];?></a></em>
                                                        <?php
                                                    }

                                                }
                                            ?>
                                        </dd>
                                    </dl>
                                    <?php
                                }
                            }
                        ?>
                    </span>
                </div>
            </li>
            <?php
        }
    }
?>
</ul>
</div>
</div>
</div>
</div>
</div>


</div>
<ul class="nav">
    <li>
        <a href="" class="nav-01">首页</a>
        <a href="">微信拼团</a>
        <a href="">特价商品</a>
        <a href="">品质优选</a>
        <a href="">精选店铺</a>
        <a href="">商家特卖</a>
    </li>
</ul>
</div>
</div>
<!--导航结束-->

<!--banner开始-->
<div class="banner wgt-slide">
    <div class="wgt-slide-container">
        <?php $banner = $obj->GetHomeBanner();?>
        <ul>
            <?php
                if(!empty($banner))
                {
                    $i=0;
                    foreach($banner as $item)
                    {
                        if($i==0)
                        {
                            ?>
                            <li class="item current" style="opacity:1; z-index:1; background:url(<?php echo $item['picture_path'];?>) #ffffff center no-repeat"></li>
                            <?php
                        }else
                        {
                            ?>
                            <li class="item " style="opacity:; z-index:; background:url(http://www.tugoo.net/UploadFile/ggs/201705271642005311.jpg) #ffffff center no-repeat"></li>
                            <?php
                        }
                        $i++;
                    }
                }
            ?>
        </ul>
    </div>
    <div class="g-grid">
        <?php
        if(!empty($banner))
        {
            $i=0;
            foreach($banner as $item)
            {
                if($i==0)
                {
                    ?>
                    <a rel="<?php echo $i;?>" href="<?php echo $item['picture_url'];?>" class="btn-banner" target="_blank" style="display:block;">查看详情</a>
                <?php
                }else
                {
                    ?>
                    <a rel="<?php echo $i;?>" href="<?php echo $item['picture_url'];?>" class="btn-banner" target="_blank" style="display:;">查看详情</a>
                <?php
                }
                $i++;
            }
        }
        ?>
        <div class="wgt-slide-trigger">
            <?php
            if(!empty($banner))
            {
                $i=0;
                foreach($banner as $item)
                {
                    if($i==0)
                    {
                        ?>
                        <a href="javascript:;" class="item current"></a>
                    <?php
                    }else
                    {
                        ?>
                        <a href="javascript:;" class="item "></a>
                    <?php
                    }
                    $i++;
                }
            }
            ?>
        </div>


    </div>
</div>
<!--banner结束-->






<!--限时快抢和新闻-->
<div class="news">

<div class="seckill-time">
    <div class="box_hd">
        <div class="box_hd_col1">
            <i class="box_hd_dec"></i>
            <i class="box_hd_icon"></i>
            <h3 class="box_tit">限时秒杀</h3>
            <a href="" target="_blank" class="box_subtit">总有你想不到的低价<i class="box_subtit_arrow"></i></a>
        </div>

        <div class="box_hd_col2">
            <div class="J_sk_cd sk_cd">
                <span class="sk_cd_tip">当前场次</span>
                <div class="sk_cd_main J_sk_cd_main">

                </div>
                <span class="sk_cd_tip">后结束抢购</span>
            </div>
        </div>

    </div>
</div>
<div class="seckill">
    <div class="seckill_btn">
        <div class="arrow-left arrow">&lt;</div>
        <div class="arrow-right arrow">&gt;</div>
    </div>
    <!-- Swiper -->
    <div class="swiper-container swiper-no-swiping">
        <div class="swiper-wrapper">
            <?php
                $seckill = $obj->GetTodayTimeSeckill();
                if($seckill)
                {
                    foreach($seckill as $item)
                    {
                        ?>
                        <div class="swiper-slide sk_item_pic swiper-no-swiping">
                            <a href="javascript:;" class="sk_item_pic_lk">
                                <img src="<?php echo $item['product_img'];?>" alt="<?php echo $item['product_img'];?>" title="<?php echo $item['product_img'];?>" class="sk_item_img">
                                <p class="sk_item_name"><?php echo $item['product_name'];?></p>
                            </a>
                            <span class="sk_item_shadow"></span>
                            <p class="sk_item_price">
                                    <span class="mod_price sk_item_price_new">
                                        <i>¥</i><span><?php echo $item['seckill_price']; ?></span>
                                    </span>
                                    <span class="mod_price sk_item_price_origin">
                                        <i>¥</i><del><?php echo $item['product_price']; ?></del>
                                    </span>
                            </p>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
        <!-- Add Pagination
        <div class="swiper-pagination"></div>
         -->
    </div>




</div>
<div class="news-02">
    <h1>商城公告</h1>
    <span></span>
    <a href="">【公告】关于2017年村村通商城春节...</a>
    <a href="">【公告】关于2017年村村通商城春节...</a>
    <a href="">【公告】关于2017年村村通商城春节...</a>
    <a href="">【公告】关于2017年村村通商城春节...</a>
    <a href="">【公告】关于2017年村村通商城春节...</a>
    <a href="">【公告】关于2017年村村通商城春节...</a>

</div>
</div>
<!--限时快抢和新闻结束-->
<div class="selected">
    <div class="selected-box">
        <div class="selected-01">
            <h1>精选好货</h1>
            <a href="">
                <span>更多好货</span>
                <img src="/template/source/pc_shop/img/04.png" />
            </a>
        </div>
        <div class="selected-02">
            <ul class="tu-box">
                <li>
                    <a href="">
                        <div class="tu-01">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/chanp01.jpg" />
                        </div>
                        <div class="wz">
                            <p>AppleWatch</p>
                            <span>除了抬抬手就是接收通知并及时进行相应操作，还能追踪每天的运动</span>
                            <span class="wz-1">255人说好</span>
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="tu-box-01">
                <li>
                    <a href="">
                        <div class="a-02">
                            <p class="a-02-01">进口水果缤纷购</p>
                            <p class="a-02-02">直降买赠享不停</p>
                        </div>
                        <div class="img-03">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan01.jpg" />
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="tu-box-01">
                <li>
                    <a href="">
                        <div class="a-02">
                            <p class="a-02-01">时令鲜果</p>
                            <p class="a-02-02">为你搜罗全球美</p>
                        </div>
                        <div class="img-03">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan02.jpg" />
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="tu-box-02">
                <li>
                    <a href="">
                        <div class="a-02">
                            <p class="a-02-01">冷鲜牛排</p>
                            <p class="a-02-02">买1送1</p>
                        </div>
                        <div class="img-03">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan03.jpg" />
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="tu-box-02">
                <li>
                    <a href="">
                        <div class="a-02">
                            <p class="a-02-01">贝思克蛋糕</p>
                            <p class="a-02-02">女神价满100减</p>
                        </div>
                        <div class="img-03">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan04.jpg" />
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!--精选结束-->
    <div class="Ranking-box">
        <div class="selected-01 Ranking-box-01">
            <h1>排行榜</h1>
            <a href="">
                <span>更多好货</span>
                <img src="/template/source/pc_shop/img/04.png" />
            </a>
        </div>
        <div class="selected-02">
            <ul class="tu-box">
                <li>
                    <a href="">
                        <div class="tu-01">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/chanp01.jpg" />
                        </div>
                        <div class="wz">
                            <p>AppleWatch</p>
                            <span>除了抬抬手就是接收通知并及时进行相应操作，还能追踪每天的运动</span>
                            <span class="wz-1">255人说好</span>
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="tu-box-01">
                <li>
                    <a href="">
                        <div class="a-02">
                            <p class="a-02-01">进口水果缤纷购</p>
                            <p class="a-02-03">直降买赠享不停</p>
                        </div>
                        <div class="img-03">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan01.jpg" />
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="tu-box-01">
                <li>
                    <a href="">
                        <div class="a-02">
                            <p class="a-02-01">时令鲜果</p>
                            <p class="a-02-03">为你搜罗全球美</p>
                        </div>
                        <div class="img-03">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan02.jpg" />
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="tu-box-02">
                <li>
                    <a href="">
                        <div class="a-02">
                            <p class="a-02-01">冷鲜牛排</p>
                            <p class="a-02-03">买1送1</p>
                        </div>
                        <div class="img-03">
                            <img src="/template/source/pc_shop/img/default.png" data-src="img/jingxuan03.jpg" />
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="tu-box-02">
                <li>
                    <a href="">
                        <div class="a-02">
                            <p class="a-02-01">贝思克蛋糕</p>
                            <p class="a-02-03">女神价满100减</p>
                        </div>
                        <div class="img-03">
                            <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan04.jpg" />
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!--排行榜结束-->
</div>
<!--水果开始-->
<div class="Fruits-box">
    <div class="left-box">
        <div class="left-box-01">
            <a href="">
                <h1>水果蔬菜</h1>

            </a>
            <span></span>
            <p>FRUITS VEGETABLES</p>
        </div>
        <div class="img-04">
            <a href="">
                <img src="/template/source/pc_shop/img/shuiguo01.jpg" />
            </a>
        </div>
    </div>
    <!--左边结束-->
    <div class="Middle">
        <ul class="Middle-box">
            <li>
                <a href="">苹果</a>
            </li>
            <li>
                <a href="">香蕉</a>
            </li>
            <li>
                <a href="">榴莲</a>
            </li>
            <li>
                <a href="">山竹</a>
            </li>
            <li>
                <a href="">火龙果</a>
            </li>
            <li>
                <a href="">叶菜类</a>
            </li>
            <li>
                <a href="">根茎类</a>
            </li>
            <li>
                <a href="">樱桃</a>
            </li>
            <li>
                <a href="">葡萄</a>
            </li>
            <li>
                <a href="">瓜果类</a>
            </li>
        </ul>
        <!--导航结束-->
        <ul class="Middle-box-01">
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!--中间结束-->
    <div class="right-box">
        <h1>热门品牌</h1>
        <a href="">
            <div class="logo-box">
                <img src="img/default.png" data-src="img/logo01.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="img/default.png" data-src="img/logo02.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="img/logo03.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo04.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo05.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo06.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo07.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo08.png" />
            </div>
        </a>

    </div>
</div>
<!--水果结束-->

<!--米面水产开始-->
<div class="selected">
<div class="selected-box">
    <div class="mi-01">
        <a href="">
            <h1>粮油米面</h1>

        </a>
        <ul class="fenlei-box">
            <li>
                <a href="">苹果</a>
            </li>
            <li>
                <a href="">香蕉</a>
            </li>
            <li>
                <a href="">榴莲</a>
            </li>
            <li>
                <a href="">山竹</a>
            </li>
            <li>
                <a href="">火龙果</a>
            </li>
            <li>
                <a href="">叶菜类</a>
            </li>
            <li>
                <a href="">根茎类</a>
            </li>
            <li>
                <a href="">樱桃</a>
            </li>
        </ul>
    </div>
    <div class="selected-02">
        <ul class="tu-box">
            <li>
                <a href="">
                    <div class="tu-01">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/chanp01.jpg" />
                    </div>
                    <div class="wz">
                        <p>AppleWatch</p>
                        <span>除了抬抬手就是接收通知并及时进行相应操作，还能追踪每天的运动</span>
                        <span class="wz-1">255人说好</span>
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-01">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">进口水果缤纷购</p>
                        <p class="a-02-04">直降买赠享不停</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan01.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-01">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">时令鲜果</p>
                        <p class="a-02-04">为你搜罗全球美</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan02.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-02">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">冷鲜牛排</p>
                        <p class="a-02-04">买1送1</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan03.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-02">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">贝思克蛋糕</p>
                        <p class="a-02-04">女神价满100减</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan04.jpg" />
                    </div>
                </a>
            </li>
        </ul>

    </div>
</div>
<!--米面结束-->

<div class="shuichan-box">
    <div class="shuichan-01">
        <a href="">
            <h1>畜牧水产</h1>

        </a>
        <ul class="fenlei-box">
            <li>
                <a href="">苹果</a>
            </li>
            <li>
                <a href="">香蕉</a>
            </li>
            <li>
                <a href="">榴莲</a>
            </li>
            <li>
                <a href="">山竹</a>
            </li>
            <li>
                <a href="">火龙果</a>
            </li>
            <li>
                <a href="">叶菜类</a>
            </li>
            <li>
                <a href="">根茎类</a>
            </li>
            <li>
                <a href="">樱桃</a>
            </li>
        </ul>
    </div>
    <div class="selected-02">
        <ul class="tu-box">
            <li>
                <a href="">
                    <div class="tu-01">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/chanp01.jpg" />
                    </div>
                    <div class="wz">
                        <p>AppleWatch</p>
                        <span>除了抬抬手就是接收通知并及时进行相应操作，还能追踪每天的运动</span>
                        <span class="wz-1">255人说好</span>
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-01">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">进口水果缤纷购</p>
                        <p class="a-02-05">直降买赠享不停</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan01.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-01">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">时令鲜果</p>
                        <p class="a-02-05">为你搜罗全球美</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan02.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-02">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">冷鲜牛排</p>
                        <p class="a-02-05">买1送1</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan03.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-02">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">贝思克蛋糕</p>
                        <p class="a-02-05">女神价满100减</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan04.jpg" />
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--水产结束-->
</div>
<!--米面水产结束-->
<!--农业开始-->
<div class="Fruits-box">
    <div class="left-box">
        <div class="left-box-02">
            <a href="">
                <h1>农业加工</h1>

            </a>
            <span></span>
            <p>FRUITS VEGETABLES</p>
        </div>
        <div class="img-04">
            <a href="">
                <img src="/template/source/pc_shop/img/nongye01.jpg" />
            </a>
        </div>
    </div>
    <!--左边结束-->
    <div class="Middle">
        <ul class="Middle-box ningye-box">
            <li>
                <a href="">苹果</a>
            </li>
            <li>
                <a href="">香蕉</a>
            </li>
            <li>
                <a href="">榴莲</a>
            </li>
            <li>
                <a href="">山竹</a>
            </li>
            <li>
                <a href="">火龙果</a>
            </li>
            <li>
                <a href="">叶菜类</a>
            </li>
            <li>
                <a href="">根茎类</a>
            </li>
            <li>
                <a href="">樱桃</a>
            </li>
            <li>
                <a href="">葡萄</a>
            </li>
            <li>
                <a href="">瓜果类</a>
            </li>
        </ul>
        <!--导航结束-->
        <ul class="Middle-box-01">
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-01">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-01">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-01">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-01">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-01">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-01">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!--中间结束-->
    <div class="right-box">
        <h1>热门品牌</h1>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo01.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo02.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo03.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo04.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo05.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo06.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo07.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo08.png" />
            </div>
        </a>

    </div>
</div>
<!--农业结束-->

<div class="selected">
<div class="selected-box">
    <div class="mi-02">
        <a href="">
            <h1>苗木花草</h1>

        </a>
        <ul class="fenlei-box">
            <li>
                <a href="">苹果</a>
            </li>
            <li>
                <a href="">香蕉</a>
            </li>
            <li>
                <a href="">榴莲</a>
            </li>
            <li>
                <a href="">山竹</a>
            </li>
            <li>
                <a href="">火龙果</a>
            </li>
            <li>
                <a href="">叶菜类</a>
            </li>
            <li>
                <a href="">根茎类</a>
            </li>
            <li>
                <a href="">樱桃</a>
            </li>
        </ul>
    </div>
    <div class="selected-02">
        <ul class="tu-box">
            <li>
                <a href="">
                    <div class="tu-01">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/chanp01.jpg" />
                    </div>
                    <div class="wz">
                        <p>AppleWatch</p>
                        <span>除了抬抬手就是接收通知并及时进行相应操作，还能追踪每天的运动</span>
                        <span class="wz-1">255人说好</span>
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-01">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">进口水果缤纷购</p>
                        <p class="a-02-06">直降买赠享不停</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan01.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-01">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">时令鲜果</p>
                        <p class="a-02-06">为你搜罗全球美</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan02.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-02">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">冷鲜牛排</p>
                        <p class="a-02-06">买1送1</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan03.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-02">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">贝思克蛋糕</p>
                        <p class="a-02-06">女神价满100减</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan04.jpg" />
                    </div>
                </a>
            </li>
        </ul>

    </div>
</div>
<!--米面结束-->

<div class="shuichan-box">
    <div class="mi-03">
        <a href="">
            <h1>畜牧水产</h1>

        </a>
        <ul class="fenlei-box">
            <li>
                <a href="">苹果</a>
            </li>
            <li>
                <a href="">香蕉</a>
            </li>
            <li>
                <a href="">榴莲</a>
            </li>
            <li>
                <a href="">山竹</a>
            </li>
            <li>
                <a href="">火龙果</a>
            </li>
            <li>
                <a href="">叶菜类</a>
            </li>
            <li>
                <a href="">根茎类</a>
            </li>
            <li>
                <a href="">樱桃</a>
            </li>
        </ul>
    </div>
    <div class="selected-02">
        <ul class="tu-box">
            <li>
                <a href="">
                    <div class="tu-01">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/chanp01.jpg" />
                    </div>
                    <div class="wz">
                        <p>AppleWatch</p>
                        <span>除了抬抬手就是接收通知并及时进行相应操作，还能追踪每天的运动</span>
                        <span class="wz-1">255人说好</span>
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-01">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">进口水果缤纷购</p>
                        <p class="a-02-07">直降买赠享不停</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan01.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-01">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">时令鲜果</p>
                        <p class="a-02-07">为你搜罗全球美</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan02.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-02">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">冷鲜牛排</p>
                        <p class="a-02-07">买1送1</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan03.jpg" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="tu-box-02">
            <li>
                <a href="">
                    <div class="a-02">
                        <p class="a-02-01">贝思克蛋糕</p>
                        <p class="a-02-07">女神价满100减</p>
                    </div>
                    <div class="img-03">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/jingxuan04.jpg" />
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--水产结束-->
</div>
<!--米面水产结束-->

<!--中药开始-->
<div class="Fruits-box">
    <div class="left-box">
        <div class="left-box-03">
            <a href="">
                <h1>中药材</h1>

            </a>
            <span></span>
            <p>FRUITS VEGETABLES</p>
        </div>
        <div class="img-04">
            <a href="">
                <img src="/template/source/pc_shop/img/yaocai01.jpg" />
            </a>
        </div>
    </div>
    <!--左边结束-->
    <div class="Middle">
        <ul class="Middle-box zhongy-box">
            <li>
                <a href="">苹果</a>
            </li>
            <li>
                <a href="">香蕉</a>
            </li>
            <li>
                <a href="">榴莲</a>
            </li>
            <li>
                <a href="">山竹</a>
            </li>
            <li>
                <a href="">火龙果</a>
            </li>
            <li>
                <a href="">叶菜类</a>
            </li>
            <li>
                <a href="">根茎类</a>
            </li>
            <li>
                <a href="">樱桃</a>
            </li>
            <li>
                <a href="">葡萄</a>
            </li>
            <li>
                <a href="">瓜果类</a>
            </li>
        </ul>
        <!--导航结束-->
        <ul class="Middle-box-01">
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-02">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-02">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-02">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-02">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-02">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <p class="img-mane">进口水果缤纷购</p>
                    <p class="img-miao-02">直降买赠享不停</p>
                    <div class="img-box">
                        <img src="img/default.png" data-src="/template/source/pc_shop/img/shuiguo02.jpg" />
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!--中间结束-->
    <div class="right-box">
        <h1>热门品牌</h1>
        <a href="">
            <div class="logo-box">
                <img src="img/default.png" data-src="/template/source/pc_shop/img/logo01.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="img/default.png" data-src="/template/source/pc_shop/img/logo02.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="img/default.png" data-src="/template/source/pc_shop/img/logo03.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="img/default.png" data-src="/template/source/pc_shop/img/logo04.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="img/default.png" data-src="/template/source/pc_shop/img/logo05.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="img/default.png" data-src="/template/source/pc_shop/img/logo06.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo07.png" />
            </div>
        </a>
        <a href="">
            <div class="logo-box">
                <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/logo08.png" />
            </div>
        </a>

    </div>
</div>
<!--中药结束-->
<!--猜你喜欢开始-->
<div class="like-box">
    <h1>猜你喜欢</h1>
    <ul class="like-s-box">
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan01.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">正品五粮液 浓香型 52度 500ml</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan02.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">洋河 蓝色经典海之蓝52度 绵柔型480ml</p>
                </div>
                <p class="wz-3">¥<span>145</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="img/default.png" data-src="img/xihuan03.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">美国原装进口 加州乐事 红葡萄酒 柔顺红1.5L/瓶</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="img/default.png" data-src="img/xihuan04.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">香满园 超级小町 5kg/袋</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="img/default.png" data-src="img/xihuan05.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">Carlo Rossi/加州乐事 红葡萄酒750ml 美国原装进口</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
    </ul>

    <ul class="like-s-box">
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="img/default.png" data-src="img/xihuan01.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">正品五粮液 浓香型 52度 500ml</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="img/default.png" data-src="img/xihuan02.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">洋河 蓝色经典海之蓝52度 绵柔型480ml</p>
                </div>
                <p class="wz-3">¥<span>145</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="img/default.png" data-src="img/xihuan03.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">美国原装进口 加州乐事 红葡萄酒 柔顺红1.5L/瓶</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan04.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">香满园 超级小町 5kg/袋</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan05.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">Carlo Rossi/加州乐事 红葡萄酒750ml 美国原装进口</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
    </ul>
    <ul class="like-s-box">
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan01.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">正品五粮液 浓香型 52度 500ml</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan02.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">洋河 蓝色经典海之蓝52度 绵柔型480ml</p>
                </div>
                <p class="wz-3">¥<span>145</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan03.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">美国原装进口 加州乐事 红葡萄酒 柔顺红1.5L/瓶</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan04.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">香满园 超级小町 5kg/袋</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
        <li class="like-box-01">
            <a>
                <div class="img-05">
                    <img src="/template/source/pc_shop/img/default.png" data-src="/template/source/pc_shop/img/xihuan05.jpg" />
                </div>
                <div class="wz-box">
                    <p class="wz-2">Carlo Rossi/加州乐事 红葡萄酒750ml 美国原装进口</p>
                </div>
                <p class="wz-3">¥<span>899</span></p>
            </a>
        </li>
    </ul>
</div>
<!--底部开始-->
<div class="bottom-box">
    <div class="logo-box-01">
        <div class="logo-img">
            <img src="/template/source/pc_shop/img/dilogo.png"/>
            <a>
                <img src="/template/source/pc_shop/img/07.png" />
                <p>400-800-2923</p>
            </a>
        </div>
        <ul class="Navigation">
            <li>
                <span>新手指南</span>
                <p>
                    <a href="">免费注册</a>
                </p>
                <p>
                    <a href="">密码修改</a>
                </p>
                <p>
                    <a href="">订购流程</a>
                </p>
                <p>
                    <a href="">忘记密码</a>
                </p>
            </li>
            <li>
                <span>消费者保障</span>
                <p>
                    <a href="">食品安全承诺</a>
                </p>
                <p>
                    <a href="">买家防骗</a>
                </p>
            </li>
            <li>
                <span>配送方式</span>
                <p>
                    <a href="">卖家防骗</a>
                </p>
                <p>
                    <a href="">配送与运费</a>
                </p>
                <p>
                    <a href="">土购网默认运费</a>
                </p>
            </li>
            <li>
                <span>售后服务</span>
                <p>
                    <a href="">验货签收</a>
                </p>
                <p>
                    <a href="">退换须知</a>
                </p>
                <p>
                    <a href="">投诉中心</a>
                </p>
            </li>
        </ul>
        <div class="erweima">
            <p>微信公众号</p>
            <img src="/template/source/pc_shop/img/erweima.webp" />

        </div>
        <span class="xiam"></span>
        <ul class="dibu">
            <li>
                <a href="">关于我们</a>
                <a href="">联系我们</a>
                <a href="">隐私声明</a>
                <a href="">服务条款</a>
                <a href="">招贤纳士</a>
                <a href="">商家入驻</a>
            </li>
            <p>增值电信业务经营许可证赣B2-2012052 赣ICP备12003095-2号 Copyright 2013-2016 版权所有 tugoo.net</p>
        </ul>
    </div>
</div>
</div>
<script src="/template/source/pc_shop/js/jquery-2.1.4.js"></script>
<script src="/template/source/pc_shop/js/fastclick.js"></script>
<script src="/template/source/pc_shop/js/lazy-load-img.min.js"></script>
<script src="/template/source/pc_shop/js/autosize.min.js"></script>
<script src="/template/source/pc_shop/js/flexislider.js"></script>
<script src="/template/source/pc_shop/js/jquery.SuperSlide.js"></script>
<script src="/template/source/pc_shop/js/swiper.min.js"></script>
<script src="/template/source/pc_shop/js/guageEdit.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        //pagination: '.swiper-pagination',
        slidesPerView: 5,
        //paginationClickable: true,
        spaceBetween: 15,
        nextButton: '.arrow-right',
        prevButton: '.arrow-left'

    });

    $(function(){
        $(".banner").flexislider();
        var url = window.location.href;
        if (url.indexOf("category") >= 0) {
            setselect(0, "商品");
        }
        else if (url.indexOf("shop.aspx") >= 0) {
            setselect(1, "店铺");
        }
        else if (url.indexOf("news") >= 0) {
            setselect(2, "资讯");
        }
        else if (url.indexOf("supply") >= 0) {
            setselect(3, "供求");
        }
        else if (url.indexOf("company") >= 0) {
            setselect(4, "黄页");
        }
        else {
            setselect(0, "商品");
        }
    })

    function setselect(sval, ihtml) {
        document.getElementById("selectvalue").innerHTML = ihtml;
        document.getElementById("searchtype").value = sval;
    }
    function sodis() {
        if (document.getElementById("options").style.display == "none") {
            document.getElementById("options").style.display = "block";
        } else {
            document.getElementById("options").style.display = "none";
        }
    }
    function showso() { document.getElementById("options").style.display = "block"; }
    function hideso() { document.getElementById("options").style.display = "none"; }

    function search() {
        var searchtype = document.getElementById("searchtype").value;
        var word = document.getElementById("searchword").value;
        word = (word == "请输入搜索信息") ? "" : word;
        switch (searchtype) {
            case "0":
                location.href = "/category.aspx?wd=" + encodeURI(word);
                break;
            case "1":
                location.href = "/shop.aspx?wd=" + encodeURI(word);
                break;
            case "2":
                location.href = "/news.aspx?wd=" + encodeURI(word);
                break;
            case "3":
                location.href = "/supply.aspx?wd=" + encodeURI(word);
                break;
            case "4":
                location.href = "/company.aspx?wd=" + encodeURI(word);
                break;
            default:
                location.href = "/category.aspx?wd=" + encodeURI(word);
                break;
        }
    }

    //二级导航事件
    $(".newPriceLinks li").hover(
        function () {
            $(this).children("div").show();
            $(this).addClass("sfhover");
        },
        function () {
            $(this).children("div").hide();
            $(this).removeClass("sfhover"); //alert('ok');
        }
    );


    function p (n)
    {
        var a = n || '';
        return a < 10 ? '0'+ a : a;
    }
    //var countDown = 123 ;
    function newTime(){

        var EndTime= new Date('2017/06/05 00:00:00');
        var NowTime = new Date();
        var countDown =EndTime.getTime() - NowTime.getTime();
        var oDay,oHours,oMinutes,oSeconds,myMS;
        //var star_date = new Date();
        //countDown = countDown-1;
        oDay=Math.floor(countDown/1000/60/60/24);
        oHours=Math.floor(countDown/1000/60/60%24);
        oMinutes=Math.floor(countDown/1000/60%60);
        oSeconds=Math.floor(countDown/1000%60);
        var html = '';
        html +='<div class="cd clearfix">';
        html +='<div class="cd_item cd_hour">';
        html +='<span class="cd_item_txt">'+ (oDay*24)+oHours +'</span>';
        html +='</div>';
        html +='<div class="cd_split">';
        html +='<i class="cd_split_dot cd_split_top"></i>';
        html +='<i class="cd_split_dot cd_split_bottom"></i>';
        html +='</div>';
        html +='<div class="cd_item cd_minute">';
        html +='<span class="cd_item_txt">'+ p(oMinutes) +'</span>';
        html +='</div>';
        html +='<div class="cd_split">';
        html +='<i class="cd_split_dot cd_split_top"></i>';
        html +='<i class="cd_split_dot cd_split_bottom"></i>';
        html +='</div>';
        html +='<div class="cd_item cd_second">';
        html +='<span class="cd_item_txt">'+ p(oSeconds) +'</span>';
        html +='</div>';
        html +='</div>';

        if(countDown < 0){
            $('.J_sk_cd_main').html("秒杀已结束");
        }else{
            $('.J_sk_cd_main').html(html);
        }

    }
    setInterval(newTime,1000);
    newTime();






</script>


</body>
</html>
