<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$page_array=$obj->GetAdminAuthPage($_SESSION['role_id']);
?>
<aside class="Hui-aside">
	<input runat="server" id="divScrollValue" type="hidden" value="" />
	<div class="menu_dropdown bk_2">
        <?php
        if (!empty($page_array))
        {
            $auth_menu=$obj->GetMyAuthMenu();
            foreach ($page_array as $page)
            {
                if(isset($page['id']))
                {
                if (!in_array($page['id'],$auth_menu) || $page['menu_type'])
                {
                    continue;
                }
                ?>
                <dl id="menu-article">
                    <dt><i class="Hui-iconfont">&#xe616;</i>  <?php echo $page['ry_menu'];?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
                    <?php //找出需要循环数组的二级分类
                    if(!empty($page)) {
                        ?>
                        <dd>
                        <ul>
                        <?php
                        $array_key=array_keys($page);
                        foreach ($array_key as $key => $value) {
                            if (is_array($page[$value])) {
                                if (!in_array($page[$value]['id'], $auth_menu) || $page[$value]['menu_type']) {
                                    continue;
                                }
                                ?>
                                        <li><a data-href="<?php echo $page[$value]['ry_link']; ?>" data-title="<?php echo $page[$value]['ry_menu']; ?>"
                                               href="javascript:void(0)"> <?php echo $page[$value]['ry_menu']; ?></a>
                                        </li>
                            <?php }
                        }
                    }
                    ?>
                        </ul>
                        </dd>
                            <?php
                    ?>
                </dl>
                <?php
                }
            }
        }
        ?>
	</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
