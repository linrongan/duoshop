<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetViewAddress();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>修改-我的地址</title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">-->
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/template/source/default/css/mui.min.css">
    <link rel="stylesheet" href="/template/source/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/template/source/default/css/rest.css">
    <link rel="stylesheet" href="/template/source/default/css/main.css">
    <link rel="stylesheet"  href="/template/source/default/css/mui.picker.css"/>
    <link rel="stylesheet" href="/template/source/default/css/mui.poppicker.css"  />
    <style>
        .web-cells:first-child{margin-top:0;}
        .web-cells::before{border-top:none;}
        .web-cell:first-child::before{border-top:none;}
        .web-cell:before{left:0;}
        .web-cell__ft {
            padding-right: 20px;
        }
    </style>
    <script src="/template/source/default/js/jquery_1.1.1.js"></script>

</head>
<body >

<div class="mui-content">

    <div class="web-address-content">
        <div class="web-cells">
            <div class="web-cell">
                <div class="web-cell__hd">
                    <label class="fr14 web-label">
                        收货人：
                    </label>
                </div>
                <div class="web-cell__bd ">
                    <input type="text" class="web-input fr14 tr"  id="shop_name" value="<?php echo $data['shop_name']; ?>" placeholder="请输入收货人">
                </div>
                <div class="web-cell__ft"></div>
            </div>
            <div class="web-cell">
                <div class="web-cell__hd">
                    <label class="fr14 web-label">
                        手机号：
                    </label>
                </div>
                <div class="web-cell__bd ">
                    <input type="number" class="web-input fr14 tr" maxlength="11" id="shop_phone" value="<?php echo $data['shop_phone']; ?>" placeholder="请输入手机号">
                </div>
                <div class="web-cell__ft"></div>
            </div>
            <div class="web-cell web-cell_access">
                <div class="web-cell__hd">
                    <label class="fr14 web-label">
                        所在地址：
                    </label>
                </div>
                <div class="web-cell__bd ">
                    <input type="text" class="web-input fr14 tr" id="address_location" value="<?php echo $data['address_location']; ?>" readonly placeholder="请选择所在地址">
                </div>
                <div class="web-cell__ft"></div>
            </div>

            <div class="web-cell">
                <div class="web-cell__bd ">
                    <textarea class="web-textarea fr14" rows="3" id="address_details" placeholder="请输入详情地址" style="text-align: left;"><?php echo $data['address_details']; ?></textarea>
                </div>
            </div>
        </div>
        <div class="web-cells">
            <div class="web-cell weui-cell_switch">
                <div class="web-cell__bd">
                    <label class="fr14">设为默认收货地址</label>
                </div>
                <div class="weui-cell__ft">
                    <input class="weui-switch" id="default_select" value="1" type="checkbox" <?php echo $data['default_select']?'checked':''; ?> >
                </div>
            </div>
        </div>


        <div style="padding:0 10%;" class="tc mtr30">
            <a href="javascript:;" data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-danger fr16 " id="sumbit" style="padding:8px 60px;width: 100%; line-height: 1.7 ">修改地址</a>
        </div>

    </div>

</div>


<script src="/template/source/default/js/mui.min.js"></script>
<script src="/template/source/default/js/mui.picker.js"></script>
<script src="/template/source/default/js/mui.poppicker.js"></script>
<script src="/template/source/default/js/city.data.js" type="text/javascript" charset="utf-8"></script>
<script src="/template/source/default/js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
<script>
    /*
     mui(document.body).on('tap', '.mui-btn', function(e) {
     mui(this).button('loading');
     setTimeout(function() {
     mui(this).button('reset');
     mui.toast('地址添加成功');
     }.bind(this), 2000);
     });*/


    (function($, doc) {
        $.init();
        $.ready(function() {

            //					//级联示例
            var cityPicker3 = new $.PopPicker({
                layer: 3
            });
            cityPicker3.setData(cityData3);
            var showCityPickerButton = doc.getElementById('address_location');
            showCityPickerButton.addEventListener('tap', function(event) {
                var that = this;
                cityPicker3.show(function(items) {
                    that.value = (items[0] || {}).text + " " + (items[1] || {}).text + " " + (items[2] || {}).text;
                    //返回 false 可以阻止选择框的关闭
                    //return false;
                });
            }, false);

            //这里执行表单提交
            var ajaxBtn = doc.getElementById('sumbit')
            sumbit.addEventListener('tap',function()
            {
                var that = $(this);
                var shop_name = doc.getElementById("shop_name").value;
                var shop_phone = doc.getElementById("shop_phone").value;
                var address_location = doc.getElementById("address_location").value;
                var address_details = doc.getElementById("address_details").value;
                var default_select = doc.getElementById("default_select");
                var select_status = 0;
                if(default_select.checked==true)
                {
                    select_status = 1;
                }else{
                    select_status = 2;
                }
                if(shop_name=='')
                {
                    $.toast('请输入收货人姓名');
                    return false;
                }
                if(shop_phone=='')
                {
                    $.toast('请输入收货人手机');
                    return false;
                }
                if(address_location=='')
                {
                    $.toast('请选择所在区域');
                    return false;
                }
                if(address_details=='')
                {
                    $.toast('请输入详细地址');
                    return false;
                }
                that.button('loading');
                var data = {
                    shop_name:shop_name,
                    shop_phone:shop_phone,
                    address_location:address_location,
                    address_details:address_details,
                    select_status:select_status
                };
                var url = '<?php if(isset($_GET['callback'])){echo urldecode($_GET['callback']);}?>';
                $.ajax({
                    type:"post",
                    url:"<?php echo _URL_; ?>&_action=ActionEditAddress",
                    data:data,
                    dataType:"json",
                    success:function (data)
                    {
                        that.button('reset');
                        $.toast(data.msg);
                        if(data.code==0)
                        {
                            if(url)
                            {
                                location.href=url;
                            }else{
                                history.back();
                            }
                        }
                    },
                    error:function (data)
                    {
                        that.button('reset');
                    }
                });
            },false)




        });
    })(mui, document);




</script>

</body>
</html>