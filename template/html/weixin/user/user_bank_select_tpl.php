<?php
$banks = $obj->GetBankList();
if(!isset($_GET['callback']) || empty($_GET['callback']))
{
    redirect(NOFOUND.'&msg=回调地址错误');
}
$call_back = urldecode($_GET['callback']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="/template/source/default/css/mui.min.css" rel="stylesheet" />
    <link href="/template/source/default/css/mui.indexedlist.css" rel="stylesheet" />
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
            font-size:14px;
        }
        .mui-bar {
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    </style>
</head>
<body>
<header class="mui-bar mui-bar-nav">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">选择银行</h1>
</header>
<div class="mui-content">
    <div id='list' class="mui-indexed-list">
        <div class="mui-indexed-list-search mui-input-row mui-search">
            <input type="search" class="mui-input-clear mui-indexed-list-search-input" placeholder="搜索银行">
        </div>
        <div class="mui-indexed-list-bar">
            <?php
                if($banks['label'])
                {
                    for($i=0;$i<count($banks['label']);$i++)
                    {
                        ?>
                        <a><?php echo $banks['label'][$i]; ?></a>
                        <?php
                    }
                }
            ?>
        </div>
        <div class="mui-indexed-list-alert"></div>
        <div class="mui-indexed-list-inner">
            <div class="mui-indexed-list-empty-alert">没有数据</div>
            <ul class="mui-table-view">
                <?php
                    if($banks['bank'])
                    {
                        foreach($banks['bank'] as $k=>$val)
                        {
                            ?>
                            <li data-group="<?php echo $k; ?>" class="mui-table-view-divider mui-indexed-list-group"><?php echo $k; ?></li>
                            <?php
                            if(!empty($val))
                            {
                                foreach ($val as $v)
                                {
                                    ?>
                                    <li data-value="<?php echo $v['bank_keyword']; ?>" data-tags="<?php echo $v['bank_english_name']; ?>"
                                       data-bank="<?php echo $v['id']; ?>" class="mui-table-view-cell mui-indexed-list-item"><?php echo $v['bank_name']; ?></li>
                                    <?php
                                }
                            }
                        }
                    }
                ?>
            </ul>
            <input type="hidden" id="return" value="<?php echo isset($_GET['return']) && !empty($_GET['return'])?'&return='.urlencode($_GET['return']) :''; ?>">
        </div>
    </div>
</div>
<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.indexedlist.js"></script>
<script src="/template/source/default/js/jquery_1.1.1.js"></script>
<script type="text/javascript" charset="utf-8">
    mui.init();
    mui.ready(function() {
        var header = document.querySelector('header.mui-bar');
        var list = document.getElementById('list');
        //calc hieght
        list.style.height = (document.body.offsetHeight - header.offsetHeight) + 'px';
        //create
        window.indexedList = new mui.IndexedList(list);

        $(".mui-indexed-list-item").click(function ()
        {
            var param = '&bank_id='+$(this).attr('data-bank');
            location.href='<?php echo $call_back; ?>'+param+$("#return").val();
        });
    });
</script>
</body>
</html>