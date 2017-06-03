<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<div>
    <div style="height: 60px;"></div>
    <div class="web-footer bgF">
        <a href="<?php echo WEBURL.'/'.$v_shop; ?>" class="tc f12 web-activer ">
            <i class="web-footer-icon"></i>
            <span>首页</span>
        </a>
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=category&v_shop='.$v_shop.''; ?>" class="tc f12">
            <i class="web-footer-icon"></i>
            <span>分类</span>
        </a>
        <a href="<?php echo WEBURL.'/?mod=weidian&v_mod=cart&v_shop='.$v_shop.''; ?>" class="tc f12">
            <i class="web-footer-icon"></i>
            <span>购物车</span>
        </a>
        <a href="<?php echo WEBURL.'/?mod=weixin&v_mod=user&v_shop='.$v_shop.''; ?>" class="tc f12 ">
            <i class="web-footer-icon"></i>
            <span>我的</span>
        </a>
    </div>
</div>

