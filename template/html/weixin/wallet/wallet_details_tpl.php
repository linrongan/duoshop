<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetUserMoneyDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>个人中心-我的余额</title>
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/font.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/weui.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/rest.css?6666">
    <link rel="stylesheet" type="text/css" href="/template/source/css/main.css?66565864aa">
    <link rel="stylesheet" type="text/css" href="/template/source/css/ggPublic.css?66565864aa">
    <style type="text/css">
        .weui-cell{padding:.2rem 4%;}
        .user-img>img{width:1rem; height:1rem; display:block; margin-right:.1rem; border-radius: 50%;}
        .weui-cell__bd>p{line-height:.4rem;}
        .weui-cells:before {
            border-top:none;
        }
        .address-img>img{width:.5rem; height:.5rem; display: block; margin-right:.2rem;}
        .moren{dislay:inline-block; padding:.04rem .1rem  ; border-radius:.4rem; border: 1px solid #43AC43; color:#43AC43}
        .weui-select,.weui-textarea{font-family: '微软雅黑'}
        .user-money_header{
            height:auto;
            background:#F76809;
            color: #fff;
            text-align: center;
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            padding:.4rem 0;
        }
        .greenColor{
            color: #008000;
        }
    </style>
</head>
<body>
<div id="content" style="">
    <div class="gg-detail-header">
        <span class="gg-detail_title sz16r">费用明细</span>
        <div class="return-back" onclick="javascript :history.back(-1);"></div>
    </div>
    <div class="weui-cells" style="margin-top:0">
        <div class="weui-cell weui-cell_access" >
            <div class="weui-cell__bd">
                <p class="omit sz14r">交易记录</p>
            </div>
        </div>
    </div>
    <div class="weui-tab">
        <div class="weui-tab__panel">
            <section class="tt-record" id="load">

                <?php
                    if($data['data'])
                    {
                        foreach($data['data'] as $v)
                        {
                            ?>
                            <div class="tt-record-item">
                                <div class="weui-cells" style="margin-top: 0;">
                                    <a class="weui-cell weui-cell_access" href="">
                                        <div class="weui-cell__bd">
                                            <p class="sz14r">
                                                <?php echo $v['trans_title']; ?>
                                            </p>
                                            <p class="sz12r cl999 omit">
                                                <?php echo $v['trans_addtime']; ?>
                                            </p>
                                        </div>
                                        <div class="weui-cell__tf">
                                            <span class="sz16r redColor">
                                            <?php
                                                echo ($v['trans_type']==1?'+':'-') . $v['trans_money'];
                                            ?>
                                        </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript" src="/template/source/js/zepto.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script src="/tool/layer/layui/layui/layui.js"></script>
<script src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script>
    var pages = <?php echo $data['pages'];?>;
    if(pages>1)
    {
        layui.use('flow', function()
        {
            var flow = layui.flow;
            flow.load({
                elem: '#load' //指定列表容器
                ,done: function(page, next)
                {
                    var lis = [];
                    $.getJSON('/?mod=weixin&v_mod=wallet&_index=_details&page='+page, function(res)
                    {
                        var type = '';
                        layui.each(res.data, function(index, item)
                        {

                            if(item.trans_type==1)
                            {
                                type = '+';
                            }else{
                                type = '-';
                            }
                            lis.push('<div class="tt-record-item">'
                                +'<div class="weui-cells" style="margin-top: 0;">'
                            +'<a class="weui-cell weui-cell_access" href="">'
                            +'<div class="weui-cell__bd">'
                            +'<p class="sz14r">'+item.trans_title+'</p>'
                            +'<p class="sz12r cl999 omit">'+item.trans_addtime+'</p>'
                            +'</div>'
                            +'<div class="weui-cell__tf">'
                            +'<span class="sz16r redColor">'
                            + type+item.trans_money
                            +'</span>'
                            +'</div>'
                            +'</a>'
                            +'</div>'
                            +'</div>');
                        });
                        next(lis.join(''), page < res.pages);
                    });
                }
            });
        });
    }
</script>
</body>
</html>
