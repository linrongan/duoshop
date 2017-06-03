<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>填写订单</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <style>
        .web-opder-nav{padding:0; border-bottom:1px solid #e8e8e8;}
        .web-opder-nav>a{padding:.5rem 0;}
        .web-yp-title>span{color:#999999;}
        .web-yp-title>span::before{border-color:#999999}
        .web-yp-title>span::after{border-color:#999999;}
        .web-cells:first-child{margin-top:0}
        .web-cells:first-child::before{border-top:none}
        .web-cell__title,.web-cell__text{padding:.5rem 3%;}
        .web-cell:before{border-top:none;}
        .web-cell__text{line-height: 1.5rem;}
        .no-fg-btn{background:#ff464e; color:white; padding:0 10px; height:2rem; line-height:2rem;   }
        .web-date-bottom{position:fixed; bottom:0; left: 0; background:white;  width:100%; border-top:1px solid #e8e8e8; }
		.web-label{min-width:4rem;}
		.mui-table-view:after{height:0px;}
		.mui-table-view-radio .mui-table-view-cell .mui-navigate-right:after{color:#ff464e;}
		
		.info-discount_body{position:fixed; bottom:0; left:0; width:100%; height:100%; background:white; z-index:999;  overflow:auto;     -webkit-overflow-scrolling: touch;  transform:translate(0,110%); -webkit-transform:translate(0,110%); transition:all .2s;}
		 .web_discount_warp{padding:.5rem 3% 0;}
        .web_discount_item>ul>li{min-height:70px; position: relative; background:#fdf0bb; margin-bottom:10px;}
        .web_discount_item>ul>li>a{display: block;}
        .web_discount_price{position:absolute; left:-3px; top: 0; width: 105px; height: 70px; background:url(/template/source/default/images/yes_discount_bg.png) no-repeat; background-size:100% 100%; text-align: center; line-height: 70px; font-weight: bold;}
        .web_discount_price>span{font-size:45px; }
        .web-discount_mess{

            padding-left:120px;
            padding-top:10px;

        }
        .web-discount_mess>h1{font-size:24px; font-weight:bold;}
		
		
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>


</head>
<body >

<div class="mui-content">

	<ul class="mui-table-view mui-table-view-radio" style="margin-top:0;">
        <li class="mui-table-view-cell mui-selected">
            <a class="mui-navigate-right">
             	 <div>
                    <span class="fl cl_b3 fr14">收货人： 张三</span>
                    <span class="fr cl_b3 fr14">15816112191</span>
                    <div class="cb"></div>
                </div>
                <div class="fr12 cl_b9 mtr5 omit " style=" width:100%; word-wrap: break-word;">收货地址：广东省广州市天河区龙洞凤凰街渔兴路18号</div>
            </a>
        </li>
       	<li class="mui-table-view-cell">
            <a class="mui-navigate-right">
             	 <div>
                    <span class="fl cl_b3 fr14">收货人： 张三</span>
                    <span class="fr cl_b3 fr14">15816112191</span>
                    <div class="cb"></div>
                </div>
                <div class="fr12 cl_b9 mtr5 omit " style=" width:100%; word-wrap: break-word;">收货地址：广东省广州市天河区龙洞凤凰街渔兴路18号</div>
            </a>
        </li>
    </ul>
    <div class="web-cells" style="margin-top:0;">
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=address&_index=_add&v_shop='.$v_shop.''; ?>" class="web-cell web-cell_access" style="border-top:1px solid #e8e8e8;">
             <div class="web-cell__hd">
                <img src="/template/source/default/images/plur.png" style="width:.75rem; margin-right:10px; display:block;">
            </div>
            <div class="web-cell__bd">
                <p>添加地址</p>
            </div>
            <div class="web-cell__ft"></div>
        </a>
	</div>




    <!---待付款---->
    <div class="web-cells">
    	 <div class="web-cell__title fr14">
            <img src="/template/source/default/images/tianmao.jpg" class="mr10" style="width:1.2rem; height: 1.2rem; display: inline-block; vertical-align: bottom;">宇轩中西餐厅<i class="ml10 fa fa-chevron-right fr12"></i>
         </div>
        <div class="web-cell" style="background:#f8f8f8;">
            <div class="web-cell__hd">

                <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>">
                    <img src="/template/source/default/images/web_yp_1.jpg" class="mr10" style="width: 4rem; height: 4rem; display: block; border-radius: 3px; ">
                </a>

            </div>
            <div class="web-cell__bd">
                <div class="fr14">
                    <span class="fl mr10 omit" style="width:65%" >
                        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=product&_index=_view&v_shop='.$v_shop.''; ?>" class="cl_b3">特色黑椒牛排</a>
                    </span>
                    <span class="fr red">￥50.00</span>
                    <div class="cb"></div>
                </div>
                <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                    颜色：黑红 尺码：#41
                </div>
                <div class="mtr5 fr12 cl_b9" style="min-height: 1rem; line-height: 1rem; ">
                    数量：2
                </div>
            </div>
        </div>
        
        
        <div class="web-cell">
        	<div class="web-cell__hd">
            	<label class="fr14 web-label">购买数量</label>
            </div>
            <div class="web-cell__bd">
            	<div class="fr numbody">
                    <a href="javascript:;" class="numbody-btn numbody-reduce  fr14 ">
                        <i class="fa fa-minus"></i>
                    </a>
                    <input type="number " class="numbody-text fr12" readonly value="1">
                    <a href="javascript:;" class="numbody-btn numbody-plus  fr14 ">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="web-cell__ft"></div>
        </div>
        
        <div class="web-cell web-cell_access">
        	<div class="web-cell__hd">
            	<label class="fr14 web-label">产品优惠</label>
            </div>
            <div class="web-cell__bd mr10" id="selectYouhui">
            	<p class="tr fr14">使用优惠券</p>
            </div>
            <div class="web-cell__ft"></div>
        </div>
        <div class="web-cell">
        	<div class="web-cell__hd">
            	<label class="fr14 web-label">配送方式</label>
            </div>
            <div class="web-cell__bd">
            	<p class="tr fr14">快递 免邮</p>
            </div>
            <div class="web-cell__ft"></div>
        </div>
        
        <div class="web-cell">
        	<div class="web-cell__hd">
            	<label class="fr14 web-label">买家留言</label>
            </div>
            <div class="web-cell__bd">
            	<input type="text" class="web-input tr" placeholder="选填：对本次交易的说明">
            </div>
            <div class="web-cell__ft"></div>
        </div>
        
      
        <div class="web-cell__text fr12 tr">
            共<span class="red">2</span>件 小计：<span class="red fr16" data-sumprice="100">￥100.00</span>
            <div class="cb"></div>
        </div>
    </div>
    <!-------->





    <div style="height:2.5rem;"></div>
    <div class="web-date-bottom">
        <a href="javascript:;" class="no-fg-btn fr fr14 ml10 ">提交订单</a>
        <div class="fr fr14 order-sum_price" style="line-height:2rem;">合计：<span class="red fr16" data-sumprice="100">￥100.00</span></div>
        <div class="cb"></div>
    </div>

</div>



<div class="info-discount_body">
	<!--没有购物产品提示 -->
	<div class="web-cart-error tc" style="display: block;">
        <img src="/template/source/default/images/no_discount_i.png">
        <p class="fr16 cl_b3 mt10">没有优惠券</p>
    </div>
	<div class="web_discount_warp">
        <div class="web_discount_item">
            <ul>
                <li>
                    <a href="javascript:;">
                        <div class="web_discount_price white fr18 omit ">
                            ￥<span data-syprice="10">10</span>
                        </div>
                        <div class="web-discount_mess">
                            <h1 class="cl_b3">满<span class="red" data-maxprice="100">100</span>使用</h1>
                            <p class="cl_b9 mt5 f16">使用时间：8.13-8.25</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <div class="web_discount_price white fr18 omit ">
                            ￥<span data-syprice="40" >40</span>
                        </div>
                        <div class="web-discount_mess">
                            <h1 class="cl_b3">满<span class="red" data-maxprice="499">499</span>使用</h1>
                            <p class="cl_b9 mt5 f16">使用时间：8.13-8.25</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <div class="web_discount_price white fr18 omit ">
                            ￥<span data-syprice="60">60</span>
                        </div>
                        <div class="web-discount_mess">
                            <h1 class="cl_b3">满<span class="red" data-maxprice="899">899</span>使用</h1>
                            <p class="cl_b9 mt5 f16">使用时间：8.13-8.25</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <div class="web_discount_price white fr18 omit ">
                            ￥<span data-syprice="1000">1000</span>
                        </div>
                        <div class="web-discount_mess">
                            <h1 class="cl_b3">满<span class="red" data-maxprice="29999">29999</span>使用</h1>
                            <p class="cl_b9 mt5 f16">使用时间：8.13-8.25</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>








<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.lazyload.js"></script>
<script src="/template/source/default/js/mui.lazyload.img.js"></script>
<script>
		$(function(){
			
			
			var sibVal =  $(this).find('.numbody-text').val();
			//加数
			$(".numbody").on('click','.numbody-plus',function(){
				$(this).siblings('.numbody-text').val(parseInt(++sibVal));
				if(sibVal > 1){
					$(this).siblings('.numbody-reduce').css('color','#ff464e')
				}else{
					$(this).siblings('.numbody-reduce').css('color','#999999')
				}
			})
	
			//减数
			$(".numbody").on('click','.numbody-reduce',function(){
				if(sibVal > 1){
					$(this).siblings('.numbody-text').val(parseInt(--sibVal));
					if(sibVal == 1){
						$(this).css('color','#999999')
					}
				}else{
					$(this).siblings('.numbody-text').val(1)
				}
			})

			
			$('.web-cell_access').on('tap','#selectYouhui',function(){
				$('.info-discount_body').css({'-webkit-transform':'translate(0,0)','transform':'translate(0,0)'});
			})
			
			$('.info-discount_body').click(function(){
				$(this).css({'-webkit-transform':'translate(0,110%)','transform':'translate(0,110%)'});
			})
			
		
			$('.web_discount_warp .web_discount_item>ul>li>a').click(function(event){
				 
				var syPrice = parseInt($(this).find('.web_discount_price span').attr('data-syprice'));	
				var maxPrice= parseInt($(this).find('.web-discount_mess h1 span').attr('data-maxprice'));
				var sumPrice= parseInt($('.order-sum_price').children('span').attr('data-sumprice'));
				if(sumPrice >= maxPrice){
					$("#selectYouhui").children('p').html(syPrice);
					$('.info-discount_body').css({'-webkit-transform':'translate(0,110%)','transform':'translate(0,110%)'});
				}else{
					alert('消费额不够，暂不能使用。。')
				}
				//console.log(maxPrice+":"+sumPrice);
		
				event.stopPropagation(); 
			})
				
			
			
			
			
		})
</script>
</body>
</html>