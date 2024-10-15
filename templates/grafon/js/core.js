!function(a) {
	
    var b = {
        defaults: {
            reloadbox: " ",
            loadBox: "",
            ctbTriggerBox: "",
            ctbTrigger: "a.ajax",
            loadErrorMessage: "THE PAGE YOU WERE LOOKING FOR COULD NOT BE FOUND.",
            loadErrorBacklinkText: "Back to the last page",
            bouncingBoxes: "",
            topToBottom: false,
            leftToRight: false,
            inEasing: "easeInQuint",
            outEasing: "easeInQuint",
            inDuration: 700,
            outDuration: 500,
            preloadImages: false,
            direction: "",
            positionType: "absolute"
        },
        listenToPopState: function(b, d) {
            a(window).off("popstate").on("popstate", function(a) {
                var e;
                switch (b.direction) {
                  case "left-to-right":
                    e = "ks-ctb-box-in-l-pushstate";
                    break;

                  case "right-to-left":
                    e = "ks-ctb-box-in-r-pushstate";
                    break;

                  case "top-to-bottom":
                    e = "ks-ctb-box-in-t-pushstate";
                    break;

                  case "bottom-to-top":
                    e = "ks-ctb-box-in-b-pushstate";
                    break;

                  case "":
                    e = "ks-ctb-box-in-pushstate";
                    break;

                  default:
                    alert("Kool ctb Error: \n The defined direction " + b.direction + " does not exist.");
                    return false;
                }
                c.ctbHistoryPage(b, d, e);
                a.stopPropagation();
            });
        }
    };
    var c = {
        defaults: function(c, d) {
            psSettings = c.data("kool-ctb-window");
            if ("undefined" == typeof psSettings) {
                psSettings = a.extend({}, b.defaults, d);
                c.data("kool-ctb-window", psSettings);
            } else psSettings = a.extend(psSettings, d);
            return psSettings;
        },
        init: function(d) {
            var f = window.history && history.pushState;
            return this.each(function() {
                c.defaults(a(this), d);
                var g = a(psSettings.reloadbox), h = psSettings.ctbTriggerBox, i = psSettings.ctbTrigger, j = true;
                if (f && a("html").not("[data-ks-initialised]")) {
                    a("html").attr("data-ks-initialised", "true");
                    b.listenToPopState(psSettings, a(h + " " + i));
                }
                e.trigger(psSettings, f, h, i, j);
            });
        },
        ctbHistoryPage: function(b, c, d) {
            if (a("html").is("[data-ks-history-pushed]")) {
                var f = location.pathname;
                e.ksLoadPage(b, c, f, d);
										$('nav a').removeClass('act-link');
					 var pgurl = window.location.href.substr(window.location.href
.lastIndexOf("/")+1);
     $("a.ajax").each(function(){
          if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
          $(this).addClass("act-link");
     });
            }
        },
        destroy: function(b) {
            a(document).off("click", psSettings.ctbTriggerBox + " " + psSettings.ctbTrigger);
            return a(this).each(function() {
                var b = a(this);
                b.removeData("kool-ctb-window");
            });
        }
    };
    var d = {
        defaults: function(c, d) {
            settings = c.data("kool-ctb");
            if ("undefined" == typeof settings) {
                settings = a.extend({}, b.defaults, d);
                c.data("kool-ctb", settings);
            } else settings = a.extend(settings, d);
            return settings;
        },
        init: function(b) {
            return this.each(function() {
                d.defaults(a(this), b);
                settings.reloadbox = a(this);
                var c = settings.ctbTriggerBox, f = settings.ctbTrigger, g = false;
                e.trigger(settings, true, c, f, g);
            });
        },
        destroy: function(b) {
            a(document).off("click", settings.ctbTriggerBox + " " + settings.ctbTrigger);
            return a(this).each(function() {
                var b = a(this);
                b.removeData("kool-ctb");
            });
        }
    };
    var e = {
        trigger: function(b, c, d, f, g) {
            if (c) {
                function h() {
                    var a = document.createElement("div");
                    a.setAttribute("ongesturestart", "return;");
                    return "function" === typeof a.ongesturestart;
                }
                if (h()) a(document).on("touchstart", ".abl", function() {
                    window.history.back();
 
 
                }).off("touchstart", d + " " + f).on("touchstart", d + " " + f, function(d) {
                    d.preventDefault();
                    var f = a(this);
                    e.ksDefinereloadboxIn(b, f, c, g);
                }); else a(document).on("click", ".abl", function() {
                    window.history.back();
                }).off("click", d + " " + f).on("click", d + " " + f, function(d) {
                    d.preventDefault();
                    var f = a(this);
                    e.ksDefinereloadboxIn(b, f, c, g);
 
                });
            }
        },
        ksDefinereloadboxIn: function(b, c, d, f) {
            switch (b.direction) {
              case "left-to-right":
              case "right-to-left":
              case "top-to-bottom":
              case "bottom-to-top":
              case "":
                $reloadboxIn = "ks-ctb-box-in";
                if (!a(".ks-ctb-box-in").length) {
                    var g = a(this);
                    e.ksCollectLoadPageInfo(b, c, d, $reloadboxIn, f);
                } else return false;
                break;

              default:
                alert("Kool ctb Error: \n The defined direction " + b.direction + " does not exist.");
                return false;
            }
        },
        ksCollectLoadPageInfo: function(b, c, d, f, g) {
            var h = c.attr("href");
            var f;
            switch (b.direction) {
              case "left-to-right":
                f = "ks-ctb-box-in-l";
                break;

              case "right-to-left":
                f = "ks-ctb-box-in-r";
                break;

              case "top-to-bottom":
                f = "ks-ctb-box-in-t";
                break;

              case "bottom-to-top":
                f = "ks-ctb-box-in-b";
                break;

              case "":
                f = "ks-ctb-box-in";
                break;

              default:
                alert("Kool ctb Error: \n The defined direction " + b.direction + " does not exist.");
                return false;
            }
            e.ksLoadPage(b, c, h, f, g);
            if (g) {
                history.pushState({
                    url: h
                }, null, h);
                a("html").attr("data-ks-history-pushed", "true");
            }
        },
        ksLoadPage: function(b, c, d, f, g) {
            var h = a(b.reloadbox);
            if ("" != d) {
                e.ksAddreloadboxIn(b, f);
                a.ajax({
                    type: "GET",
                    url: d,
                    data: {},
                    beforeSend: function() {
                        e.ksCreateLoadBox();
                    },
                    error: function(a, c, d) {
                        h.html('<div class= "back-link "><span>' + b.loadErrorMessage + '</span><a class="abl ajaxPageSwitchBacklink">' + b.loadErrorBacklinkText + "</a></div>");
 
                    },
                    success: function(a) {

                        if (b.bouncingBoxes) e.ksFadeSiblings(b, c, a, f, g); else e.ksPositionAndPrepare(b, c, a, f, g);
                    },
                    dataType: "html"
                });
            } else alert("There is no target defined! Please check the references (i.e. normally href) of the ctbTriggers.");
        },
        ksAddreloadboxIn: function(b, c) {
            var d = a(b.reloadbox), e = d.attr("class"), f = d.prop("tagName");
            a(document).find(".ks-ctb-box-in").remove();
            if (b.movereloadboxClasses) d.after("<" + f.toLowerCase() + ' class="ks-ctb-box-in ' + ("undefined" != typeof e ? e : "") + '" id="' + c + '"></' + f.toLowerCase() + ">"); else d.after("<" + f.toLowerCase() + ' class="ks-ctb-box-in" id="' + c + '"></' + f.toLowerCase() + ">");
            d.siblings(".ks-ctb-box-in").hide();
        },
        ksFadeSiblings: function(b, c, d, f, g) {
            a(document).find(b.bouncingBoxes).animate({
                opacity: 0
            }, 50, function() {
                e.ksPositionAndPrepare(b, c, d, f);
            });
        },
        ksPositionAndPrepare: function(b, c, d, f, g) {
            var h = a(b.reloadbox), i = h.attr("id"), j = h.position(), k = h.width(), l = h.css("margin-left"), m = h.css("margin-left"), n = j.left + parseFloat(l);
            reloadboxRightAbsolute = j.left + parseFloat(l) + k - parseFloat(m), $reloadboxIn = a("#" + f), 
            loadSelector = c.attr("data-ks-load-selector");
            if (g) var o = d.match(/<\/*html\s+.*id="([^"].*)".*>/), p = d.match(/<\/*body\s+.*id="([^"].*)".*>/), q = d.match(/<\/*html\s+.*class="([^"].*)".*>/), r = d.match(/<\/*body\s+.*class="([^"].*)".*>/), s = d.match(/<\/*title>(.*)<\/title>/);
            h.addClass("ks-ctb-box-out").css({
                position: "absolute",
                top: j.top,
                left: n,
                marginLeft: 0,
                width: k
            });
            if (reloadboxInContents = void 0 != a(d).filter("#" + i).html()) {
                if (b.loadBox) var t = a(d).filter(b.loadBox); else if (loadSelector) var t = a(d).filter(loadSelector); else var t = a(d).filter("#" + i);
                reloadboxInContents = t.html();
                var u = t.attr("class");
            } else {
                if (b.loadBox) var t = a(d).find(b.loadBox); else if (loadSelector) var t = a(d).find(loadSelector); else var t = a(d).find("#" + i);
                reloadboxInContents = t.html();
                var u = t.attr("class");
            }
            $reloadboxIn.addClass(u).css({
                position: b.positionType,
                marginLeft: 0,
                top: j.top,
                left: n
            }).html(reloadboxInContents);
            var v = $reloadboxIn.find("img");
            var w = 0;
            if (v.length && true == b.preloadImages) v.on("load", function() {
                w++;
                if (w == v.length) {
                    a(document).trigger("ksLoadCallback");
                    e.ksctbContent(b, f, c, j, n, k, o, p, q, r, s, g);
                }
            }); else {
                a(document).trigger("ksLoadCallback");
                e.ksctbContent(b, f, c, j, n, k, o, p, q, r, s, g);
            }
        },
        ksctbContent: function(b, c, d, f, g, h, i, j, k, l, m, n) {
            var o = a(b.reloadbox), p = o.attr("id"), q = a("#" + c), r = q.outerHeight(), s = q.outerWidth(), t = o.outerHeight(), u = a(window).outerHeight(), v = a(window).outerWidth(), w = d.prop("hash");
            clearTimeout(loadTimer);
            e.ksRemoveLoadBox();
            if (b.direction) {
                q.css({
                    width: h
                });
                var x = {}, y = {};
                var z;
                switch (c) {
                  case "ks-ctb-box-in-b-pushstate":
                  case "ks-ctb-box-in-t":
                    q.css("top", 2 * -r);
                    z = 3 * u;
                    break;

                  case "ks-ctb-box-in-t-pushstate":
                  case "ks-ctb-box-in-b":
                    q.css("top", 1.5 * t);
                    z = 1.5 * -t;
                    break;

                  case "ks-ctb-box-in-r-pushstate":
                  case "ks-ctb-box-in-l":
                    q.css("left", -v);
                    z = v;
                    break;

                  case "ks-ctb-box-in-l-pushstate":
                  case "ks-ctb-box-in-r":
                    q.css("left", v);
                    z = -v;
                    break;

                  default:
                    alert("Kool ctb Error: \n The reloadboxIn class is in an undefined format: " + c + ".");
                    return false;
                }
                switch (b.direction) {
                  case "left-to-right":
                  case "right-to-left":
                    var A = b.inDuration, B = b.outDuration;
                    x = {
                        left: z
                    };
                    y = {
                        left: g
                    };
                    q.css("top", f.top);
                    a("body").css({
                        overflowX: "hidden",
                        overflowY: "scroll"
                    });
                    break;

                  case "top-to-bottom":
                  case "bottom-to-top":
                    var C = t * b.inDuration / 1e3;
                    var D = C / 100;
                    var A = b.inDuration + D;
                    var B = b.outDuration;
                    y = {
                        top: f.top
                    };
                    x = {
                        top: z
                    };
                    a("body").css("overflow-y", "scroll");
                }
                o.stop().show().animate(x, B, b.outEasing, function() {
                    a(this).remove();
                    if (n) e.ksSwitchClasses(i, j, k, l, m);
                });
                q.stop().show().animate(y, A, b.inEasing, function() {
                    a(this).css({
                        display: "",
                        left: "",
                        marginLeft: "",
                        position: "",
                        top: "",
                        width: ""
                    }).attr("id", p).removeClass("ks-ctb-box-in");
                    e.animationCallback(w);
                    e.ksCheckForSiblings(b);
                });
            } else {
$('.l-line').fadeIn(10);
				$('.l-line span').animate({width:'100%'} ,{queue:false,duration:700,easing:"swing"});	
		 setTimeout(function() {
                a("html, body").animate({
                    scrollTop: 0
                }, {
                    queue: true,
                    duration: 150,
                    easing: "easeInOutQuad"
                }); 
    	}, 1250);

                a(".loader-holder").fadeIn(10);
 
 				var ww = $(window).width();
				if (ww < 1046) {
					$(".nav-holder , .top-bar").slideUp(500);
				}
                contanimhide();
                var E = a.magnificPopup.instance;
                E.close();
                o.delay(900).animate({
                    opacity: 0
                }, b.outDuration, function() {
                    a(this).remove();
                    if (n) e.ksSwitchClasses(i, j, k, l, m);
                    q.css({
                        display: "",
                        left: "",
                        marginLeft: "",
                        opacity: 0,
                        position: "",
                        top: "",
                        width: ""
                    }).animate({
                        opacity: 1
                    }, b.inDuration, function() {
                        e.animationCallback(w);
                        e.ksCheckForSiblings(b);
                        a(".loader-holder").fadeOut(10);
                        contanimshow();
						var urlHash = window.location.href.split("#")[1];
						var ah = $("header").outerHeight(true);
   		 if (urlHash &&  $('#' + urlHash).length ) {

		  			    setTimeout(function() {
          $('html,body').animate({
              scrollTop: $('#' + urlHash).offset().top - 70
          }, {                queue: false,
                duration: 800,
                easing: "easeInOutExpo"});
    }, 950);
		 }
							$('.l-line').fadeOut(10,function(){
								$('.l-line span').animate({width:'0'},10);

							});
                    }).attr("id", p).removeClass("ks-ctb-box-in");
                });
            }
        },
  
        animationCallback: function(b) {
            if (b) a("html:not(:animated),body:not(:animated)").animate({
                scrollTop: a(b).position()
            }, "normal");
        },
        ksCheckForSiblings: function(b) {
            if (b.bouncingBoxes) a(document).find(b.bouncingBoxes).animate({
                opacity: 1
            }, 1400, function() {
                e.ksctbCallback();
            }); else e.ksctbCallback();
        },
        ksSwitchClasses: function(b, c, d, e, f) {
            a("html, body").attr({
                "class": "",
                id: ""
            });
            b ? a("html").attr("id", b[1]) : "";
            c ? a("body").attr("id", c[1]) : "";
            d ? a("html").addClass(d[1]) : "";
            e ? a("body").addClass(e[1]) : "";
            f ? a("title").text(f[1]) : "";
        },
        ksCreateLoadBox: function() {
            if (!a("#ks-loading-box").length) loadTimer = setTimeout(function() {
 
            }, 10); else {
                e.ksRemoveLoadBox();
                e.ksCreateLoadBox();
            }
        },
        ksRemoveLoadBox: function() {
            a("#ks-loading-box").fadeOut("1000").remove();
        },
        ksctbCallback: function() {
            a("body").css({
                overflowX: "auto"
            });
            a(document).trigger("ksctbCallback");
        }
    };
    a.coretemp = function(b) {
        if (c[b]) return c[b].apply(a(window), Array.prototype.slice.call(arguments, 1)); else if ("object" === typeof b || !b) return c.init.apply(a(window), arguments, false); else a.error("Method " + b + " does not exist on jQuery.coretemp");
    };
    a.fn.coretemp = function(b) {
        if (d[b]) return d[b].apply(this, Array.prototype.slice.call(arguments, 1)); else if ("object" === typeof b || !b) return d.init.apply(this, arguments); else a.error("Method " + b + " does not exist on jQuery.coretemp");
    };
}(jQuery);
