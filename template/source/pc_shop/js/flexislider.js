(function (a) {
    
    a.fn.flexislider = function (b) {

        a.fn.flexislider.defaults = {
            trigger: ".wgt-slide-trigger",
            container: ".wgt-slide-container",
            current: "current",
            event: "mouseover",
            auto: true,
            iAnim: 300,
            interval: 5000
        };

        var b = a.extend({},
		a.fn.flexislider.defaults, b);
        this.each(function () {
            var j = a(this),
			p = j.find(b.container),
			l = p.find(".item"),
			k = j.find(b.trigger),
			e = k.find(".item"),
			c = a(".btn-banner"),
			i = e.length,
			h = 1,
			f = b.current,
			g = b.iAnim,
			o;
            n();

            function n() {
                if (o) {
                    clearInterval(o)
                }
                e.bind(b.event,
				function () {
				    if (!a(this).hasClass(f)) {
				        h = e.index(this);
				        d(h);
				        h++
				    }
				});
                if (b.auto) {
                    a(".banner .g-grid").hover(function () {
                        if (o) {
                            clearInterval(o)
                        }
                    },
					function () {
					    m()
					}).trigger("mouseleave")
                }
            }

            function d(q) {
                c.css("display", "none").filter('[rel="' + q + '"]').css("display", "block");
                l.stop(true, true).eq(q).animate({
                    opacity: 1
                },
				g).css({
				    "z-index": "1"
				}).siblings().animate({
				    opacity: 0
				},
				g).css({
				    "z-index": "0"
				});
                e.removeClass(f).eq(q).addClass(f)
            }

            function m() {
                o = setInterval(function () {
                    if (h >= i) {
                        h = 0
                    }
                    d(h);
                    h++
                },
				b.interval)
            }

        })
    }
})(jQuery);