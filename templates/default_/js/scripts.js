function initTrion() {
    //   loader ------------------
    "use strict";
    firstLoad();
    function firstLoad() {
        setTimeout(function () {
            $(".main-loader-wrap .loader-spin").addClass("novisspin");
        }, 1500);
        setTimeout(function () {
            $(".main-loader-wrap").fadeOut(500);
        }, 2200);
        var chdpt = $(".content-holder").data("pagetitle");
        $(".breadcrumb-wrap span").text(chdpt);
    }
    //   Background image ------------------
    var a = $(".bg");
    a.each(function (a) {
        if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
    });
    //  scrollToFixed------------------
    $(".scroll-nav-wrap ").scrollToFixed({
        minWidth: 1068,
        zIndex: 112,
        marginTop: 90,
    });
    $(".boxed-filter").scrollToFixed({
        minWidth: 1068,
        zIndex: 112,
        marginTop: 60,
    });
    $(".fix-tab").scrollToFixed({
        minWidth: 1068,
        zIndex: 112,
        marginTop: 170,
        removeOffsets: true,
        limit: function () {
            var a = $(".limit-box").offset().top - $(".fix-tab").outerHeight(true) + 10;
            return a;
        }
    });
    $(".fix-aside").scrollToFixed({
        minWidth: 1258,
        zIndex: 112,
        marginTop: 110,
        removeOffsets: true,
        limit: function () {
            var a = $(".limit-box").offset().top - $(".fix-aside").outerHeight(true);
            return a;
        }
    });
    if ($(".fixed-bar").outerHeight(true) < $(".post-container").outerHeight(true)) {
        $(".fixed-bar").addClass("fixbar-action");
        $(".fixbar-action").scrollToFixed({
            minWidth: 1064,
            marginTop: function () {
                var a = $(window).height() - $(".fixed-bar").outerHeight(true) - 100;
                if (a >= 0) return 20;
                return a;
            },
            removeOffsets: true,
            limit: function () {
                var a = $(".limit-box").offset().top - $(".fixed-bar").outerHeight() - 30;
                return a;
            }
        });
    } else $(".fixed-bar").removeClass("fixbar-action");
    //   Isotope------------------
    function n() {
        if ($(".gallery-items").length) {
            var a = $(".gallery-items").isotope({
                singleMode: true,
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".gallery-item, .gallery-item-second, .gallery-item-three"
            });
            a.imagesLoaded(function () {
                a.isotope("layout");
            });
            $(".gallery-filters").on("click  ", "a.gallery-filter", function (b) {
                b.preventDefault();
                var c = $(this).attr("data-filter"),
                    d = $(this).text();
                a.isotope({
                    filter: c
                });
                $(".gallery-filters a").removeClass("gallery-filter-active");
                $(this).addClass("gallery-filter-active");
            });
        }
        $(".gallery-items").isotope("on", "layoutComplete", function (a, b) {
            var b = a.length;
            $(".num-album").html(b);
        });
        var b = $(".gallery-item").length;
        $(".all-album , .num-album").html(b);
    }
    n();
    $(window).on("load", function () {
        n();
    });
    $(".gallery-item").on(' ', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });
    //   Swiper------------------
    if ($(".portfolio-wrap").length > 0) {
        var prwrap = new Swiper(".portfolio-wrap .swiper-container", {
            slidesPerView: "auto",
            centeredSlides: false,
            spaceBetween: 10,
            grabCursor: true,
            freeMode: false,


            pagination: {
                el: '.swiper-pagination',
                type: 'fraction',

            },
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
    if ($(".fs-gallery-wrap").length > 0) {
        var h = $(".fs-gallery-wrap").data("autoplayslider"),
            i = $(".fs-gallery-wrap").data("slidereffect");
        var j = new Swiper(".fs-gallery-wrap .swiper-container", {
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
            effect: i,
            speed: 1400,
            grabCursor: true,
            loop: true,
            parallax: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        j.on("slideChangeTransitionStart", function () {
            $(".slider-progress-bar").removeClass("act-slider");
        });
        j.on("slideChangeTransitionEnd", function () {
            $(".slider-progress-bar").addClass("act-slider");
        });
    }
    if ($(".hero-carousel ").length > 0) {
        var heroCarusel = new Swiper(".hero-carousel .swiper-container", {
            preloadImages: false,
            loop: true,
            centeredSlides: true,
            freeMode: false,
            slidesPerView: 2,
            spaceBetween: 10,
            grabCursor: true,
            mousewheel: false,
            parallax: true,
            speed: 1400,
            effect: "slide",
            init: false,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.fs-slider-wrap_pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                1064: {
                    slidesPerView: 2
                },
                640: {
                    slidesPerView: 1,
                    centeredSlides: false,
                },
            }
        });
        setTimeout(function () {
            heroCarusel.init();
        }, 1);
        heroCarusel.on("slideChangeTransitionStart", function () {
            $(".slider-progress-bar").removeClass("act-slider");
        });
        heroCarusel.on("slideChangeTransitionEnd", function () {
            $(".slider-progress-bar").addClass("act-slider");
        });
    }
    if ($(".single-slider").length > 0) {
        var m2 = new Swiper(".single-slider .swiper-container", {
            effect: $(".single-slider").data("effects"),
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            loop: true,
            grabCursor: true,
            autoHeight: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
    if ($(".testilider").length > 0) {
        var m = new Swiper(".testilider .swiper-container", {
            pagination: {
                el: '.swiper-pagination',
                type: 'fraction',

            },
            effect: $(".single-slider").data("effects"),
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: false,
            slidesPerView: 2,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    centeredSlides: false,
                }
            }
        });
    }
    if ($(".inline-carousel").length > 0) {
        var swiper2 = new Swiper('.inline-carousel .swiper-container', {
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            slidesPerView: 3,
            paginationClickable: true,
            spaceBetween: 10,
            loop: true,

            navigation: {
                nextEl: '.inline-car-control .swiper-button-next',
                prevEl: '.inline-car-control .swiper-button-prev',
            },
            breakpoints: {
                1064: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                520: {
                    slidesPerView: 1,
                },
            }
        });
    }
    //   lightGallery------------------
    $(".image-popup , .single-popup-image").lightGallery({
        selector: "this",
        cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
        download: false,
        counter: false
    });
    var o = $(".lightgallery"),
        p = o.data("looped");
    o.lightGallery({
        selector: ".lightgallery a.popup-image , .lightgallery  a.popgal",
        cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
        download: false,
        loop: p,
        counter: false
    });
    $('#html5-videos').lightGallery({
        selector: 'this',
        counter: false,
        download: false,
        zoom: false
    });
    $(".filter-button").on("click  ", function () {
        $(".hid-filter").slideToggle(500);
    });
    $(".mob-filter_btn").on("click  ", function () {
        $(".gfm").slideToggle(500);
    });
    //   appear------------------
    $(".stats").appear(function () {
        $(".num").countTo();
    });
    $(".inline-facts").append("<span class='dec-counter'></span>");
    $(".dec-counter").each(function () {
        var numdec = $(this).parents(".inline-facts").find("div.num").data("num");
        $(this).text(numdec)
    });
    $(".piechart-holder").appear(function () {
        $(this).find(".chart").each(function () {
            var cbc = $(".piechart-holder").attr("data-skcolor");
            $(".chart").easyPieChart({
                barColor: cbc,
                trackColor: "#3F3F44",
                scaleColor: false,
                size: "150",
                lineWidth: "45",
                lineCap: "butt",
                animate: 3500,
                easing: "easeInBounce",
                onStep: function (a, b, c) {
                    $(this.el).find(".percent").text(Math.round(c));
                }
            });
        });
    });
    $(".skillbar-box").appear(function () {
        $(this).find("div.skillbar-bg").each(function () {
            $(this).find(".custom-skillbar").delay(600).animate({
                width: $(this).attr("data-percent")
            }, 1500);
        });
    });
    // Share   ------------------
    $(".share-container").share({
        networks: ['facebook', 'pinterest', 'twitter', 'tumblr']
    });
    var shrcn = $(".share-container"),
        swra = $(".share-wrapper"),
        shic = $(".share-icon"),
        ssbtn = $(".show-share");
    function showShare() {
        swra.slideDown(300);
        ssbtn.addClass("uncl-share");
        shrcn.removeClass("isShare");
        shic.each(function (a) {
            var boi = $(this);
            setTimeout(function () {
                TweenMax.to(boi, 1.0, {
                    force3D: false,
                    opacity: "1"
                });
            }, 130 * a);
        });
    }
    function hideShare() {
        ssbtn.removeClass("uncl-share");
        shrcn.addClass("isShare");
        TweenMax.to($(".share-icon"), 1.0, {
            force3D: false,
            opacity: "0",
            onComplete: function () {
                swra.slideUp(300);
            }
        });
    }
    ssbtn.on("click", function () {
        if ($(".share-container").hasClass("isShare")) showShare();
        else hideShare();
    });
    //   tabs------------------
    $("ul.tabs li").on("click", function () {
        var a = $(this).attr("data-tab"),
            b = $("ul.tabs li");
        b.removeClass("current");
        $(".tab-content").removeClass("current");
        $(this).addClass("current");
        $("#" + a).addClass("current");
        return false;
    });
    //   scroll to------------------
    $(".custom-scroll-link").on("click", function () {
        var a = 70;
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
    $(".scroll-nav  ul").singlePageNav({
        filter: ":not(.external)",
        updateHash: false,
        offset: 140,
        threshold: 140,
        speed: 1200,
        currentClass: "act-link"
    });
    $(".onepage-nav  ul").singlePageNav({
        filter: ":not(.external)",
        updateHash: false,
        offset: 140,
        threshold: 140,
        speed: 1200,
        currentClass: "act-link"
    });
    $(".to-top").on("click", function (a) {
        a.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    $(window).on("scroll", function () {
        var a = $(document).height();
        var b = $(window).height();
        var c = $(window).scrollTop();
        var d = c / (a - b) * 100;
        $(".progress-bar").css({
            width: d + "%"
        });
    });
     //   Contact form------------------
     $("#contactform").submit(function() {
         var a = $(this).attr("action");
         $("#message").slideUp(750, function() {
             $("#message").hide();
             $("#submit").attr("disabled", "disabled");
             $.post(a, {
                 name: $("#name").val(),
                 email: $("#email").val(),
                 comments: $("#comments").val(),

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
    //  Map------------------	
    if ($("#map-single").length > 0) {
        var latlog = $('#map-single').data('latlog'),
            popupTextit = $('#map-single').data('popuptext'),
            map = L.map('map-single').setView(latlog, 15);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        var greenIcon = L.icon({
            iconUrl: 'images/marker.png',
            iconSize: [40, 40],
            popupAnchor: [0, -26]
        });
        L.marker(latlog, {
            icon: greenIcon
        }).addTo(map).bindPopup(popupTextit).openPopup();
    }
    //   mailchimp------------------
    $("#subscribe").ajaxChimp({
        language: "eng",
        url: "https://gmail.us1.list-manage.com/subscribe/post?u=1fe818378d5c129b210719d80&amp;id=a2792f681b"
    });
    $.ajaxChimp.translations.eng = {
        submit: "Submitting...",
        0: '<i class="fal fa-check"></i> We will be in touch soon!',
        1: '<i class="fal fa-exclamation-circle"></i> You must enter a valid e-mail address.',
        2: '<i class="fal fa-exclamation-circle"></i> E-mail address is not valid.',
        3: '<i class="fal fa-exclamation-circle"></i> E-mail address is not valid.',
        4: '<i class="fal fa-exclamation-circle"></i> E-mail address is not valid.',
        5: '<i class="fal fa-exclamation-circle"></i> E-mail address is not valid.'
    };
    //   Video------------------
    var v = $(".background-youtube").data("vid");
    var f = $(".background-youtube").data("mv");
    $(".background-youtube").YTPlayer({
        fitToBackground: true,
        videoId: v,
        pauseOnScroll: true,
        mute: f,
        callback: function () {
            var a = $(".background-video").data("ytPlayer").player;
        }
    });
    var w = $(".background-vimeo").data("vim");
    $(".background-vimeo").append('<iframe src="//player.vimeo.com/video/' + w + '?background=1"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ></iframe>');
    $(".video-holder").height($(".media-container").height());
    if ($(window).width() > 1024) {
        if ($(".video-holder").length > 0)
            if ($(".media-container").height() / 9 * 16 > $(".media-container").width()) {
                $(".background-vimeo iframe ").height($(".media-container").height()).width($(".media-container").height() / 9 * 16);
                $(".background-vimeo iframe ").css({
                    "margin-left": -1 * $("iframe").width() / 2 + "px",
                    top: "-75px",
                    "margin-top": "0px"
                });
            }
        else {
            $(".background-vimeo iframe ").width($(window).width()).height($(window).width() / 16 * 9);
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
    $(".video-container").css("width", $(window).width() + "px");
    $(".video-container ").css("height", 720 / 1280 * $(window).width()) + "px";
    if ($(".video-container").height() < $(window).height()) {
        $(".video-container ").css("height", $(window).height() + "px");
        $(".video-container").css("width", 1280 / 720 * $(window).height()) + "px";
    }
    $(".filter-header").on("click", function () {
        if ($(window).width() < 1258) {
            $(".fixed-filter .gallery-filters").slideToggle(400);
        }
        return false;
    });
    $("a , .btn ,   textarea,   input  , .leaflet-control-zoom , .aside-show_cf , .close-contact_form , .closedet_style  , .nav-button , .swiper-pagination-bullet , .to-top-btn  , .gc-slider-cont , .share-button , .hp_popup").on({
        mouseenter: function () {
            $(".element-item").addClass("elem_hover");
        },
        mouseleave: function () {
            $(".element-item").removeClass("elem_hover");
        }
    });
    $("  .swiper-slide ,  #portfolio_horizontal_container").on({
        mouseenter: function () {
            $(".element-item").addClass("slider_hover");
        },
        mouseleave: function () {
            $(".element-item").removeClass("slider_hover");
        }
    });
    $(".swiper-slide a , .next-project-swiper-link , #portfolio_horizontal_container a").on({
        mouseenter: function () {
            $(".element-item").removeClass("slider_hover");
        },
        mouseleave: function () {
            $(".element-item").addClass("slider_hover");
        }
    });
    $(".next-project-swiper-link").on({
        mouseenter: function () {
            $(".element-item").addClass("slider_linknext");
        },
        mouseleave: function () {
            $(".element-item").removeClass("slider_linknext");
        }
    });
    $(".psn_button").on("click", function () {
        $(".scroll-nav-wrap").slideToggle(400);

    });
    $(".scroll-nav ul li a").on("click", function () {
        if ($(window).width() < 768) {
            $(".scroll-nav-wrap").delay(1200).slideUp(400);
        }
        return false;
    });
}
// parallax ------------------
function initparallax() {
    var a = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return a.Android() || a.BlackBerry() || a.iOS() || a.Opera() || a.Windows();
        }
    };
    trueMobile = a.any();
    if (null == trueMobile) {
        var b = new Scrollax();
        b.reload();
        b.init();
    }
    if (trueMobile) $(".background-video").remove();
}
if ($(".element-item").length > 0) {
    var mouse = {
        x: 0,
        y: 0
    };
    var pos = {
        x: 0,
        y: 0
    };
    var ratio = 0.15;
    var active = false;
    var ball = document.querySelector('.element-item');
    TweenLite.set(ball, {
        xPercent: -50,
        yPercent: -50
    });
    document.addEventListener("mousemove", mouseMove);
    function mouseMove(e) {
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        mouse.x = e.pageX;
        mouse.y = e.pageY - scrollTop;
    }
    TweenMax.ticker.addEventListener("tick", updatePosition);
    function updatePosition() {
        if (!active) {
            pos.x += (mouse.x - pos.x) * ratio;
            pos.y += (mouse.y - pos.y) * ratio;
            TweenMax.set(ball, {
                x: pos.x,
                y: pos.y
            });
        }
    }
}
//  menu  ------------------
$("<div class='nav-overlay'></div>").appendTo("#main");
$(".nav-holder nav li a.act-link").closest("li").addClass("actli");
$(".nav-holder nav li ul").parent("li").append('<span class="nav-dec"></span>');
$(".nav-holder nav li").on("click", function () {
    $(this).each(function () {
        $(this).children("ul").stop().slideToggle(400);
    });
});
$('.nav-holder-wrap').perfectScrollbar();
function hideMenu() {
    $(".nav-holder-wrap").animate({
        left: -450 + "px"
    }, 550);
    $(".nav-button-wrap").addClass("vis-menbut");
	$(".nav-overlay").fadeOut(100);
}
function showMenu() {
    $(".nav-holder-wrap").animate({
        left: 0
    }, 550);
    $(".nav-button-wrap").removeClass("vis-menbut");
    if ($(window).width() < 1068) {
 		$(".nav-overlay").fadeIn(100)
    }
}
$(".nav-button").on("click  ", function () {
    if ($(this).parent(".nav-button-wrap").hasClass("vis-menbut")) showMenu();
    else hideMenu();
    return false;
});
$(".nav-overlay").on("click  ", function () {
    hideMenu();
});
$(".nav-holder nav a.ajax").on("click", function () {
    if ($(window).width() < 1068) {
        setTimeout(function () {
            hideMenu();
        }, 500);
    }
});
//   load animation------------------
$.fn.duplicate = function (a, b) {
    var c = [];
    for (var d = 0; d < a; d++) $.merge(c, this.clone(b).get());
    return this.pushStack(c);
};
$("<div class='page-load' data-ran='25'><div class='loader-spin'><span></span></div></div>").appendTo("#main");
$("<div class='pl-row'><span class='pl-row-anim'></span></div>").duplicate(25).appendTo(".page-load");
function contentAnimShow() {
    $(".share-button").removeClass("uncl-share");
    $(".page-load").fadeIn(1);
    function a(a) {
        var b = a.length,
            c, d;
        while (b) {
            d = Math.floor(Math.random() * b--);
            c = a[b];
            a[b] = a[d];
            a[d] = c;
        }
        return a;
    }
    var b = $(".pl-row-anim");
    $(a(b).slice(0, $(".page-load").data("ran"))).each(function (a) {
        var bfg = $(this);
        setTimeout(function () {
            TweenMax.to(bfg, 0.2, {
                force3D: true,
                scale: 1,
                opacity: 1,
                ease: Power2.easeOut
            });
        }, 30 * a);
    });
    setTimeout(function () {
        $(".loader-spin").addClass("visspin");
    }, 300);
    TweenMax.to($(".breadcrumb-wrap span"), 0.7, {
        force3D: true,
        y: -30,
        opacity: 0,
        delay: 0.7,
        ease: Power2.easeOut,
        onComplete: function () {
            TweenMax.to($(".breadcrumb-wrap span"), 0.1, {
                force3D: true,
                y: 30
            });
        }
    });
}
function contentAnimHide() {
    var chdpt = $(".content-hilder").data("pagetitle");
    $(".breadcrumb-wrap span").text(chdpt);
    TweenMax.to($(".breadcrumb-wrap span"), 0.7, {
        force3D: true,
        y: 0,
        opacity: 1,
        delay: 0.8,
        ease: Power2.easeOut
    });
    function a(a) {
        var b = a.length,
            c, d;
        while (b) {
            d = Math.floor(Math.random() * b--);
            c = a[b];
            a[b] = a[d];
            a[d] = c;
        }
        return a;
    }
    setTimeout(function () {
        var b = $(".pl-row-anim");
        $(a(b).slice(0, $(".page-load").data("ran"))).each(function (a) {
            var bfg = $(this);
            setTimeout(function () {
                TweenMax.to(bfg, 0.2, {
                    force3D: true,
                    scale: 0.3,
                    opacity: 0,

                    ease: Power2.easeOut
                });
            }, 30 * a);
        });
        $(".loader-spin").removeClass("visspin");
    }, 500);
    setTimeout(function () {
        $("html, body").animate({
            scrollTop: 0
        }, {
            queue: true,
            duration: 10,
        });
    }, 120);
    setTimeout(function () {
        $(".page-load").fadeOut(1);
    }, 1200);
}
$('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">');
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
//   Init Ajax------------------
$(function () {
    $.coretemp({
        reloadbox: "#wrapper",
        outDuration: 1200,
        inDuration: 100
    });
    readyFunctions();
    $(document).on({
        ksctbCallback: function () {
            readyFunctions();
        }
    });
});
//   Init All Functions------------------
function readyFunctions() {
    initTrion();
    initparallax();
}