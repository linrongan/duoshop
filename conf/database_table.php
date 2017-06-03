<?php
if(!defined('RUOYWCOM'))
{
exit('Access Denied');
}

//微信用户
define('TABLE_USER','wx_user');
//微信配置表
define('TABLE_MERCHANT','wx_merchant');
//vip会员卡
define('TABLE_VIP_CARD','vip_card');
//订单
define('TABLE_ORDER','d_order');
//订单物流
define('TABLE_ORDER_SHIP','d_order_ship');
//代理订单明细
define('TABLE_ORDER_DETAIL','d_order_detail');
//产品分类
define('TABLE_CATEGORY','d_category');
//产品表
define('TABLE_PRODUCT','d_product');
//产品详情表
define('TABLE_PRODUCT_DETAIL','d_product_detail');
//产品属性表
define('TABLE_ATTR','d_attr');
//产品模板表
define('TABLE_ATTR_TEMP','d_attr_temp');
//产品属性类型
define('TABLE_ATTR_TYPE','d_attr_type');
//产品购物车
define('TABLE_CART','d_cart');
//优惠卷详细
define('TABLE_COUPON','d_coupon');
//优惠卷分类
define('TABLE_COUPON_CATEGORY','d_coupon_category');
//优惠卷类型
define('TABLE_COUPON_TYPE','d_coupon_type');
//商户优惠卷类型
define('TABLE_COUPON_STORE_TYPE','d_coupon_store_type');


//余额明细
define('TABLE_USER_MONEY_DETAILS','d_user_money_details');
//日志表
define('TABLE_LOG_ALERTED','log_alerted');

//积分表
define('TABLE_LOG_POINT','log_point');
//产品评论
define('TABLE_PRODUCT_COMMENT','d_product_comment');
//用户反馈
define('TABLE_FEEDBACK','d_feedback');
//短信发送日志
define('TABLE_LOG_SMSCODE','log_smscode');
//轮播图
define('TABLE_BANNER','comm_banner');
//省
define('TABLE_PLACE_PROVINCE','place_province');
//市
define('TABLE_PLACE_CITY','place_city');
//区
define('TABLE_PLACE_AREA','place_area');
//银行卡
define('TABLE_BANK_CARD','d_bank_card');
//产品收藏
define('TABLE_PRODUCT_COLLE','d_product_colle');
//收货地址
define('TABLE_SHIP_ADDRESS','d_ship_address');
//寻求帮助
define('TABLE_NEED_HELP','d_need_help');
/*-------------公共数据表------------*/
//公共分类
define('TABLE_COMM_CATEGORY','comm_category');
//数据表公共广告位置
define('TABLE_COMM_AD','comm_ad');
//附件表
define('TABLE_ATTACH','comm_attach');
//主题表
define('TABLE_COMM_TEMPLATE','comm_template');
//模板购买订单
define('TABLE_TEMPLATE_ORDER','comm_template_order');
//店铺主题
define('TABLE_STORE_TEMPLATE','comm_store_template');
//店铺用户
define('TABLE_STORE_USER','comm_store_user');
//店铺表
define('TABLE_COMM_STORE','comm_store');
//实体店铺表
define('TABLE_COMM_STORE_PHYSICAL','comm_store_physical');
//退款表
define('TABLE_REFUND','comm_refund');
//退款原因
define('TABLE_REFUND_CAUSE','comm_refund_cause');
//退款类型
define('TABLE_REFUND_CAUSE_TYPE','comm_refund_cause_type');
//退款申请
define('TABLE_REFUND_APPLY','comm_refund_apply');
//交易流水
define('TABLE_COMM_FEE','comm_fee');
//交易盈亏类型
define('TABLE_FEE_TYPE','comm_fee_type');
//余额充值
define('TABLE_RECHARGE','comm_recharge');
//产品秒杀
define('TABLE_SEKILL_PRODUCT','d_sekill_product');
//团购产品
define('TABLE_GROUP_PRODUCT','d_group_product');
//物流表
define('TABLE_LOGISTICS','comm_logistics');
//秒杀场次
define('TABLE_SEKILL_QUANTUM','d_sekill_quantum');
//shop关注
define('TABLE_FOLLOW_STORE','d_follow_store');
//产品精选
define('TABLE_PRODUCT_CHOICE','d_product_choice');
//店铺精选
define('TABLE_STORE_CHOICE','d_store_choice');
//一键代发
define('TABLE_PRODUCT_AGENT','d_product_agent');
//订单表
define('TABLE_O_ORDER','o_order');
//订单商家表
define('TABLE_O_ORDER_SHOP','o_order_shop');
//订单产品表
define('TABLE_O_ORDER_GOODS','o_order_goods');
//团购正式表
define('TABLE_GROUP','d_group');
//团购临时订单表
define('TABLE_ORDER_GROUP','d_order_group');
//店铺申请
define('TABLE_SHOP_APPLY','d_shop_apply');
//提现
define('TABLE_WITHDRAW','d_withdraw');
//投放广告表
define('TABLE_O_ADVERT','o_advert');
//广告区域表
define('TABLE_ADVERT_REGION','o_advert_region');
//商户产品精选
define('TABLE_SHOP_PRODUCT_CHOICE','d_shop_product_choice');
//主题分类
define('TABLE_ACTIVE_CATEGORY','d_active_category');
//主题产品
define('TABLE_ACTIVE_PRODUCT','d_active_product');
//签到积分表

//银行列表
define('TABLE_BANK','comm_bank');
//问题列表
define('TABLE_QUESTION','comm_question');
//礼品分类
define('TABLE_GIFT_CATEGORY','gift_category');
//礼品商品
define('TABLE_GIFT_PRODUCT','gift_product');
//礼品购物车
define('TABLE_GIFT_CART','gift_cart');
//礼品订单
define('TABLE_GIFT_ORDER','gift_order');
//礼品订单明细
define('TABLE_GIFT_ORDER_DETAIL','gift_order_detail');

define('TABLE_SIGNED','games_signed');
//收益表
define('TABLE_PROFIT','comm_profit');
//砍价商品表
define('TABLE_GAMES_BARGAIN','games_bargain');
//砍价分享者
define('TABLE_GAMES_BARGAIN_CREATE','games_bargain_create');
//砍价参与者
define('TABLE_GAMES_BARGAIN_JOIN','games_bargain_join');
//消息提示角色
define('TABLE_ALERT_ROLE','d_alert_role');
//消息内容
define('TABLE_ALERT_LIST','d_alert_list');
//查看状态
define('TABLE_ALERT_LOOK','d_alert_look');
//用户余额消费记录
define('TABLE_BALANCE_DETAILS','d_balance_details');
define('TABLE_SHOP_WITHDRAWALS','d_shop_withdrawals');
//折扣卷使用充值记录
define('TABLE_DISCOUNT_COUPON','log_discount_coupon');
//折扣卷配置表
define('TABLE_DISCOUNT_CONF','d_discount_conf');
//代购购物车
define('TABLE_AGENT_CART','d_agent_cart');
/*-------------官方数据表------------*/
//顶部banner图
define('TABLE_O_BANNER','o_index_banner');
//商城消息
define('TABLE_O_INDEX_NOTICE','o_index_notice');
//功能导航
define('TABLE_O_NAV','o_index_nav');
//网站设置
define('TABLE_CONF','comm_conf');


/*--------小程序登录---------*/
define('TABLE_TOKEN','app_token');
?>