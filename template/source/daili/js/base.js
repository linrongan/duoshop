// JavaScript Document
 window.onload = function(){
        var ohtml = document.documentElement;
        getSize();

        window.onresize = function(){
            getSize();
        }
        function getSize(){

            var screenWidth = ohtml.clientWidth;
            if(screenWidth <= 320){
                ohtml.style.fontSize = '50px';
            }else if(screenWidth >= 640){
                ohtml.style.fontSize = '100px';
            }else{
                ohtml.style.fontSize = screenWidth/(640/100)+'px';
            }

        }

    }


