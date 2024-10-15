window.onload = function() {
 
    $(".loader-holder").fadeOut(500, function() {
        $(".loader-holder").addClass("con-load");
        $("#main").animate({
            opacity: "1"
        }, 500);
        contanimshow();
    });
}
// All functions  ------------------
function initGrafon() {
    "use strict";
    function a() {
        $(".por-link-holder").css({
            "margin-top": -1 * $(".por-link-holder").height() / 2 + "px"
        });
        $(".nav-holder nav ul li ul").css({
            height: $(".nav-holder").outerHeight(true)
        });
        $(".slideshow-slider .item").css({
            height: $(".hero-wrap").outerHeight(true)
        });
    }
    a();
    $(window).resize(function() {
        a();
    });
    $(".style-select").niceSelect();
// magnificPopup  ------------------
    function b() {
        $(".image-popup").magnificPopup({
            type: "image",
            closeOnContentClick: false,
            removalDelay: 600,
            mainClass: "my-mfp-slide-bottom",
            image: {
                verticalFit: false
            }
        });
        $(".popup-youtube, .popup-vimeo , .show-map").magnificPopup({
            disableOn: 700,
            type: "iframe",
            removalDelay: 600,
            mainClass: "my-mfp-slide-bottom"
        });
        $(".popup-gallery").magnificPopup({
            delegate: "a",
            type: "image",
            fixedContentPos: true,
            fixedBgPos: true,
            tLoading: "Loading image #%curr%...",
            removalDelay: 600,
            closeBtnInside: true,
            zoom: {
                enabled: true,
                duration: 700
            },
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [ 0, 1 ]
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            }
        });
    }
    b();
// tabs ------------------
    $("ul.tabs li").on("click", function() {
        var a = $(this).attr("data-tab");
        $("ul.tabs li").removeClass("current");
        $(".tab-content").removeClass("current");
        $(this).addClass("current");
        $("#" + a).addClass("current");
		return false;
    });
// OwlCarousel ------------------
    var c = $(".home-slider");
    c.owlCarousel({
        margin: 0,
        items: 1,
        smartSpeed: 1300,
        loop: true,
        nav: false,
        autoHeight: false
    });
    $(".home-slider-holder a.next-slide").on("click", function() {
        $(this).closest(".home-slider-holder").find(c).trigger("next.owl.carousel");
        return false;
    });
    $(".home-slider-holder a.prev-slide").on("click", function() {
        $(this).closest(".home-slider-holder").find(c).trigger("prev.owl.carousel");
        return false;
    });
    var d = $(".single-slider");
    d.owlCarousel({
        margin: 0,
        items: 1,
        smartSpeed: 1300,
        loop: true,
        nav: false,
        autoHeight: false
    });
    $(".single-slider-holder a.next-slide").on("click", function() {
        $(this).closest(".single-slider-holder").find(d).trigger("next.owl.carousel");
        return false;
    });
    $(".single-slider-holder a.prev-slide").on("click", function() {
        $(this).closest(".single-slider-holder").find(d).trigger("prev.owl.carousel");
        return false;
    });
    d.on("changed.owl.carousel", function(a) {
        b();
    });
    var e = $(".single-carousel");
    e.owlCarousel({
        margin: 0,
        items: 3,
        smartSpeed: 1300,
        loop: true,
        dots: false,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1e3: {
                items: 3
            }
        }
    });
    $(".single-carousel-holder a.next-slide").on("click", function() {
        $(this).closest(".single-carousel-holder").find(e).trigger("next.owl.carousel");
        return false;
    });
    $(".single-carousel-holder a.prev-slide").on("click", function() {
        $(this).closest(".single-carousel-holder").find(e).trigger("prev.owl.carousel");
        return false;
    });
    e.on("changed.owl.carousel", function(a) {
        b();
    });
    var f = $(".testimon-slider");
    f.owlCarousel({
        margin: 0,
        items: 1,
        smartSpeed: 1300,
        loop: true,
        nav: false,
        autoHeight: true,
        dots: false
    });
    $(".testimon-slider-holder a.next-slide").on("click", function() {
        $(this).closest(".testimon-slider-holder").find(f).trigger("next.owl.carousel");
    });
    $(".testimon-slider-holder a.prev-slide").on("click", function() {
        $(this).closest(".testimon-slider-holder").find(f).trigger("prev.owl.carousel");
    });
    var g = $(".slideshow-slider");
    g.owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        items: 1,
        dots: false,
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        autoplay: true,
        autoplayTimeout: 4100,
        autoplayHoverPause: false,
        autoplaySpeed: 3600
    });
 
 
//scroll animation------------------
    $(".animaper").appear();
    $(document.body).on("appear", ".piechart-holder", function() {
        $(this).find(".chart").each(function() {
            var a = $(".piechart-holder").data("skcolor");
            var b = $(".piechart-holder").data("trcolor");
            $(".chart").easyPieChart({
                barColor: a,
                trackColor: b,
                scaleColor: "#9ACFB7",
                size: "150",
                lineWidth: "30",
                lineCap: "butt",
                onStep: function(a, b, c) {
                    $(this.el).find(".percent").text(Math.round(c));
                }
            });
        });
    });
    $(document.body).on("appear", ".skillbar-box", function() {
        $(this).find("div.skillbar-bg").each(function() {
            $(this).find(".custom-skillbar").delay(600).animate({
                width: $(this).attr("data-percent")
            }, 1500);
        });
    });
// isotope------------------
    function l() {
        if ($(".gallery-items").length) {
            var a = $(".gallery-items").isotope({
                singleMode: true,
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".gallery-item, .gallery-item-second, .gallery-item-three"
            });
            a.imagesLoaded(function() {
                a.isotope("layout");
            });
            $(".gallery-filters").on("click", "a.gallery-filter", function(b) {
                b.preventDefault();
                var c = $(this).attr("data-filter");
                a.isotope({
                    filter: c
                });
                $(".gallery-filters a.gallery-filter").removeClass("gallery-filter-active");
                $(this).addClass("gallery-filter-active");
                return false;
            });
            a.isotope("on", "layoutComplete", function(a, b) {
                var c = b.length;
                $(".num-album").html(c);
            });
        }
    }
    var m = $(".gallery-item").length;
    $(".all-album , .num-album").html(m);
    l();
 
// Other functions ------------------
    var n = $(".bg");
    n.each(function(a) {
        if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
    });
    $(".fix-bar").scrollToFixed({
        minWidth: 1224,
        marginTop: $(".top-bar-header").outerHeight() + 10,
        removeOffsets: true,
        limit: function() {
            var a = $(".limit-box").offset().top - $(".fix-bar").outerHeight(true) - 10;
            return a;
        }
    });
    function o() {
        $("form[name=cart]").jAutoCalc("destroy");
        $("form[name=cart]").jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
    }
    o();
    $(".rage-slider").ionRangeSlider();
    $(".custom-scroll-link").on("click", function() {
        var a = 50;
        if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") || location.hostname == this.hostname) {
            var b = $(this.hash);
            b = b.length ? b : $("[name=" + this.hash.slice(1) + "]");
            if (b.length) {
                $("html,body").animate({
                    scrollTop: b.offset().top - a
                }, {
                    queue: false,
                    duration: 1200,
                    easing: "easeInOutExpo"
                });
                return false;
            }
        }
    });
// Map------------------
    var p = $("#map-canvas").data("lat"), q = $("#map-canvas").data("lang"), r = $("#map-canvas").data("maptext");
    $("#map-canvas").gmap3({
        action: "init",
        marker: {
            values: [ {
                latLng: [ p, q ],
                data: r,
                options: {
                    icon: "images/marker.png"
                }
            } ],
            options: {
                draggable: false
            },
            events: {
                mouseover: function(a, b, c) {
                    var d = $(this).gmap3("get"), e = $(this).gmap3({
                        get: {
                            name: "infowindow"
                        }
                    });
                    if (e) {
                        e.open(d, a);
                        e.setContent(c.data);
                    } else $(this).gmap3({
                        infowindow: {
                            anchor: a,
                            options: {
                                content: c.data
                            }
                        }
                    });
                },
                mouseout: function() {
                    var a = $(this).gmap3({
                        get: {
                            name: "infowindow"
                        }
                    });
                    if (a) a.close();
                }
            }
        },
        map: {
            options: {
                zoom: 14,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                scrollwheel: false,
                streetViewControl: true,
                draggable: true,
                styles: [ {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [ {
                        color: "#e9e9e9"
                    }, {
                        lightness: 17
                    } ]
                }, {
                    featureType: "landscape",
                    elementType: "geometry",
                    stylers: [ {
                        color: "#f5f5f5"
                    }, {
                        lightness: 20
                    } ]
                }, {
                    featureType: "road.highway",
                    elementType: "geometry.fill",
                    stylers: [ {
                        color: "#ffffff"
                    }, {
                        lightness: 17
                    } ]
                }, {
                    featureType: "road.highway",
                    elementType: "geometry.stroke",
                    stylers: [ {
                        color: "#ffffff"
                    }, {
                        lightness: 29
                    }, {
                        weight: .2
                    } ]
                }, {
                    featureType: "road.arterial",
                    elementType: "geometry",
                    stylers: [ {
                        color: "#ffffff"
                    }, {
                        lightness: 18
                    } ]
                }, {
                    featureType: "road.local",
                    elementType: "geometry",
                    stylers: [ {
                        color: "#ffffff"
                    }, {
                        lightness: 16
                    } ]
                }, {
                    featureType: "poi",
                    elementType: "geometry",
                    stylers: [ {
                        color: "#f5f5f5"
                    }, {
                        lightness: 21
                    } ]
                }, {
                    featureType: "poi.park",
                    elementType: "geometry",
                    stylers: [ {
                        color: "#dedede"
                    }, {
                        lightness: 21
                    } ]
                }, {
                    elementType: "labels.text.stroke",
                    stylers: [ {
                        visibility: "on"
                    }, {
                        color: "#ffffff"
                    }, {
                        lightness: 16
                    } ]
                }, {
                    elementType: "labels.text.fill",
                    stylers: [ {
                        saturation: 36
                    }, {
                        color: "#333333"
                    }, {
                        lightness: 40
                    } ]
                }, {
                    elementType: "labels.icon",
                    stylers: [ {
                        visibility: "off"
                    } ]
                }, {
                    featureType: "transit",
                    elementType: "geometry",
                    stylers: [ {
                        color: "#f2f2f2"
                    }, {
                        lightness: 19
                    } ]
                }, {
                    featureType: "administrative",
                    elementType: "geometry.fill",
                    stylers: [ {
                        color: "#fefefe"
                    }, {
                        lightness: 20
                    } ]
                }, {
                    featureType: "administrative",
                    elementType: "geometry.stroke",
                    stylers: [ {
                        color: "#fefefe"
                    }, {
                        lightness: 17
                    }, {
                        weight: 1.2
                    } ]
                } ]
            }
        }
    });
// Contact form ------------------
    $("#contactform").submit(function() {
        var a = $(this).attr("action");
        $("#message").slideUp(750, function() {
            $("#message").hide();
            $("#submit").attr("disabled", "disabled");

            $.post(a, {
                name: $("#name").val(),
                email: $("#email").val(),
                comments: $("#comments").val(),
				phone: $("#phone").val()
            }, function(a) {
                document.getElementById("message").innerHTML = a;
                $("#message").slideDown("slow");
                $("#submit").removeAttr("disabled");
                if (null != a.match("success")) $("#contactform").slideDown("slow");
            });
        });
        return false;
    });
    $("#contactform input, #contactform textarea").keyup(function() {
        $("#message").slideUp(1500);
    });
// Bg video------------------
    var s = $(".background-youtube").data("vid");
    var t = $(".background-youtube").data("mv");
    $(".background-youtube").YTPlayer({
        fitToBackground: true,
        videoId: s,
        pauseOnScroll: false,
        mute: t,
        width: $(".media-container"),
        callback: function() {
            var a = $(".background-youtube").data("ytPlayer").player;
        }
    });
    var u = $(".background-vimeo").data("vim");
    $(".background-vimeo").append('<iframe src="//player.vimeo.com/video/' + u + '?background=1"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ></iframe>');
    $(".video-holder").height($(".media-container").height());
    if ($(window).width() > 1024) {
        if ($(".video-holder").length > 0) if ($(".media-container").height() / 9 * 16 > $(".media-container").width()) {
            $(".background-vimeo iframe ").height($(".media-container").height()).width($(".media-container").height() / 9 * 16);
            $(".background-vimeo iframe ").css({
                "margin-left": -1 * $("iframe").width() / 2 + "px",
                top: "-75px",
                "margin-top": "0px"
            });
        } else {
            $(".background-vimeo iframe ").width($(".media-container").width()).height($(".media-container").width() / 16 * 9);
            $(".background-vimeo iframe ").css({
                "margin-left": -1 * $("iframe").width() / 2 + "px",
                "margin-top": -1 * $("iframe").height() / 2 + "px",
                top: "50%"
            });
        }
    } else if ($(window).width() < 760) {
        $(".video-holder").height($(".media-container").height());
        $(".background-vimeo iframe ").height($(".media-container").height());
    } else {
        $(".video-holder").height($(".media-container").height());
        $(".background-vimeo iframe ").height($(".media-container").height());
    }
// Important add or init your functions after this text ------------------






}
// parallax------------------
function initparallax() {
 
    var a = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return a.Android() || a.BlackBerry() || a.iOS() || a.Opera() || a.Windows();
        }
    };
    trueMobile = a.any();
    if (null == trueMobile) {
        var b = $("#main");
        b.find("[data-top-bottom]").length > 0 && b.waitForImages(function() {
            s = skrollr.init();
            s.destroy();
            $(window).resize(function() {
                var a = $(window).width();
                if (a < 1036) s.destroy(); else skrollr.init({
                    forceHeight: !1,
                    easing: "easeInOutElastic",
                    mobileCheck: function() {
                        return !1;
                    }
                });
            });
            skrollr.init({
                forceHeight: !1,
                easing: "easeInOutElastic",
                mobileCheck: function() {
                    return !1;
                }
            });
        });
        var c = $(window).width();
        if (c < 1036) {
            s = skrollr.init();
            s.destroy();
        }
    }
    if (trueMobile) $(".background-youtube , .background-vimeo").remove();
}
//  papge  load transitions------------------
function contanimshow() {
 
    $(".content-holder").removeClass("scale-bg2");
    var a = window.location.href, b = $(".content-holder").data("dyntitle"), c = $(".content-holder").data("bgs"), d = $("#bgd");

    $(".loader-holder ").addClass("con-load");
    d.css("background-image", "url(" + c + ")");
    setTimeout(function() {
        $(".fix-bg-wrap").removeClass("open-image");
    }, 450);
    if ($(".content-holder").hasClass("home-content")) {
        $("nav a").removeClass("act-link");
        $(".hm-link").addClass("act-link");
    } else if ($(".content-holder").hasClass("prj-content")) {
        $("nav a").removeClass("act-link");
        $(".pr-link").addClass("act-link");
    } else if ($(".content-holder").hasClass("serv-content")) {
        $("nav a").removeClass("act-link");
        $(".sr-link").addClass("act-link");
    } else if ($(".content-holder").hasClass("blg-content")) {
        $("nav a").removeClass("act-link");
        $(".bl-link").addClass("act-link");
    } else if ($(".content-holder").hasClass("abt-content")) {
        $("nav a").removeClass("act-link");
        $(".ab-link").addClass("act-link");
    }
}
function contanimhide() {
    setTimeout(function() {
        $(".content-holder").addClass("scale-bg2");
        $(".fix-bg-wrap").addClass("open-image");
    }, 450);
}
$("body").append('<div class="l-line"><span></span></div>');
// to top------------------
$(window).scroll(function() {
    if ($(this).scrollTop() > 150) $(".to-top").fadeIn(500); else $(".to-top").fadeOut(500);
    if ($(this).scrollTop() > 50) $("header").addClass("nhm"); else $("header").removeClass("nhm");
});
$(".to-top").on("click", function() {
    $("html, body").animate({
        scrollTop: 0
    }, {
        queue: false,
        duration: 1200,
        easing: "swing"
    });
	return false;
});
// mobile menu------------------
$(".nav-button").on("click", function() {
	"use strict";
    $(".nav-holder").slideToggle(500);
	return false;
});
$(".panel-button").on("click", function() {
	"use strict";
    $(".top-bar").slideToggle(500);
	return false;
});
function csd() {
	"use strict";
    var a = $("header").height();
    var b = $(window).height();
    if (b < a) $(".top-bar-header , header").addClass("nofix"); else $(".top-bar-header , header").removeClass("nofix");
}
csd();
$(window).resize(function() {
	"use strict";
    var a = $(window).width();
    if (a < 1036) $(".top-bar , .nav-holder").css("display", "none");
    if (a > 1036) $(".top-bar , .nav-holder").css("display", "block");
    csd();
});
$("nav a.ajax").on("click", function() {
	"use strict";
    $("nav a").removeClass("act-link");
    $(this).addClass("act-link");

});
$(function() {
    $.coretemp({
        reloadbox: "#wrapper",
        loadErrorMessage: "<h2>404</h2> <br> page not found.",
        loadErrorBacklinkText: "Back to the last page",
        outDuration: 150,
        inDuration: 450
    });
    readyFunctions();
    $(document).on({
        ksctbCallback: function() {
            readyFunctions();
        }
    });
});
document.addEventListener('gesturestart', function (e) {
	e.preventDefault();
});
// Init all functions------------------
function readyFunctions() {
    initGrafon();
    initparallax();
}