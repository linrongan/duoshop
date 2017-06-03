function getCoin(urls){
    var urls = urls;
    var num = Math.round((Math.random(3)+ 5)*7);
    var snows = new Array(num);
    snows = snows.join(",").split(",");
    var Tpl = '<div style="top: {top}; left: {left}; -webkit-animation: fade {t1} {t2}, drop {t1} {t2};">\
				<img src="{url}" style="-webkit-animation: counterclockwiseSpinAndFlip {t5};width:{width}; max-width:{maxHeight}">\
				</div>';
    var snowsHTML = iTemplate.makeList(Tpl, snows, function(k,v){
        var obj = {
            top: "-30px",
            left: Math.random()*100 +"%",
            t1:Math.random()*(8-3)+5 +"s",
            t2:Math.random()*2 +"s",
            t3:Math.random()*(11-5)+2 +"s",
            t4:Math.random()*4 +"s",
            t5:Math.random()*(8-3)+2 +"s",
            url: urls[0],
            //width: Math.round(Math.random()*(1-10)+10) + "px",
            width: Math.round(Math.random()*(1)+2) + "px",
            maxHeight:"43px"
        }
        return obj;
    });
    var div = document.createElement("div");
	var userHead = document.getElementById("moneyHead");
    div.setAttribute("class", "snower");
    div.innerHTML = snowsHTML;
    userHead.appendChild(div);
}