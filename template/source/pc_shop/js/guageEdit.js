
$(function() {
    FastClick.attach(document.body);
	/*
    $(document.body).append($('<div class="top"><span>Top</span></div>'));
    $(".top").css({
        "width": "2rem",
        "height": "2rem",
        "text-align": "center",
        "line-height": "2rem",
        "background": "rgba(0,0,0,0.6)",
        "color": "white",
        "position": "fixed",
        "right": "2.5%",
        "bottom": "2.5%",
        "opacity": "0",
        "transition": "all .6s",
        "-webkit-transition": "all .6s"
    });
    $(".top>span").css("font-size","14px");
    var bodyHeight = Math.floor($(document.body).height() / 2);
    $(window).scroll(function(){
        var bodyTop = $(window).scrollTop();
        if(bodyTop >= bodyHeight ){
            $(".top").css("opacity","1");
        }else{
            $(".top").css("opacity","0");
        }
    })
    $(document.body).on("click",".top",function(){
        //var seed =  $(window).scrollTop()
        $("html,body").animate({scrollTop:"0px"},666);
    });*/




});

;(function () {
    var lazyLoadImg = new LazyLoadImg({
        el: document.querySelector('.mhome'),
        mode: 'diy', //默认模式，将显示原图，diy模式，将自定义剪切，默认剪切居中部分
        time: 300, // 设置一个检测时间间隔
        complete: true, //页面内所有数据图片加载完成后，是否自己销毁程序，true默认销毁，false不销毁
        position: { // 只要其中一个位置符合条件，都会触发加载机制
            top: 0, // 元素距离顶部
            right: 0, // 元素距离右边
            bottom: 0, // 元素距离下面
            left: 0 // 元素距离左边
        },
        diy: { //设置图片剪切规则，diy模式时才有效果
            backgroundSize: 'cover',
            backgroundRepeat: 'no-repeat',
            backgroundPosition: 'center center'
        },
        before: function () { // 图片加载之前执行方法
        },
        success: function (el) { // 图片加载成功执行方法
            el.classList.add('success')
        },
        error: function (el) { // 图片加载失败执行方法
            el.src = 'img/error.png'
        }
    })
    // lazyLoadImg.start() // 重新开启懒加载程序
    // lazyLoadImg.destroy() // 销毁图片懒加载程序
})()





/**

 * parallelRoll 左右无缝滚动

 * boxName : 最外层盒子类名

 * tagName : 滚动标签元素

 * time : 滚动间隔时间

 * direction : 滚动方向  right-->向右    left-->向左

 * visual : 可视数

 * prev : 上一张

 * next : 下一张

 * author : MR chen  370489175@qq.com

 * Date: 15-03-19

 * */












