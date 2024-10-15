// All functions  ------------------
function initGmag() {
    $('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">');
    "use strict";
	//   date------------------
    var date = new Date(),
        monthsCal = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
        curdate = date.getDate(),
        getMon = monthsCal[date.getMonth()],
        getyear = date.getFullYear();
    $(".date_num").text(curdate);
    $(".date_mounth").text(getMon);
    $(".date_year").text(getyear);
	//   ticker------------------
    $('.header_news-ticker').easyTicker({
        direction: 'up',
        easing: 'swing',
        interval: 2500,
        mousePause: true,
        controls: {
            up: '.n_btn',
            down: '.p_btn',

        },
    });
    $('.picker-wrap').easyTicker({
        direction: 'up',
        visible: 3,
        interval: 3500,
        controls: {
            up: '.pwc_up',
            down: '.pwc_down',
            toggle: '.pwc_pause'
        }
    });
    $(".pwc_pause").on("click", function () {
        $(this).toggleClass("pwc_tog-pp");

    });
    var maxL = 42;
    $(".grid-post-content h3 a").each(function (i, div) {
        var text = $(div).text();
        if (text.length > maxL) {
            var begin = text.substr(0, maxL),
                end = text.substr(maxL);
            $(div).html(begin).append($('<div class="hidden" />').html(end));
        }
    });
    var maxLp = 90;
    $(".grid-post-content p").each(function (i, div) {
        var textp = $(div).text();
        if (textp.length > maxLp) {
            var beginp = textp.substr(0, maxLp),
                end = textp.substr(maxLp);
            $(div).html(beginp).append($('<div class="hidden" />').html(end));
        }
    });
    $(".style-select").niceSelect();
    //   lightGallery------------------
    function lightGalleryInit() {
        $(".image-popup").lightGallery({
            selector: "this",
            cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
            download: false,
            counter: false
        });
        var o = $(".lightgallery"),
            p = o.data("looped");
        o.lightGallery({
            selector: ".lightgallery a.popup-image",
            cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
            download: false,
            loop: false,
            counter: false
        });
        $('#html5-videos').lightGallery({
            selector: 'this',
            counter: false,
            download: false,
            zoom: false
        });
    }
    lightGalleryInit();
    // tabs ------------------
    $(".tabs-menu a").on("click", function (a) {
        a.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var b = $(this).attr("href");
        $(this).parents(".tabs-act").find(".tab-content").not(b).css("display", "none");
        $(b).fadeIn();
    });
    $(".sicb_btn").on("click", function (e) {
        e.preventDefault();
        $(".cookie-info-bar").animate({
            opacity: "0",
            bottom: "-100px"
        }, 500);
        setTimeout(function () {
            $(".cookie-info-bar").remove();
        }, 1500);
    });
    // isotope------------------
    function n() {
        if ($(".gallery-items").length) {
            var $grid = $(".gallery-items").isotope({
                singleMode: true,
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".gallery-item, .gallery-item-second, .gallery-item-three"
            });
            $grid.imagesLoaded(function () {
                $grid.isotope("layout");
            });
            $(".gallery-filters").on("click", "a.gallery-filter", function (b) {
                b.preventDefault();
                var c = $(this).attr("data-filter"),
                    d = $(this).text();
                if ($(".gallery-items").hasClass('sf_true')) {
                    setTimeout(function () {
                        $grid.isotope({
                            filter: c
                        });
                    }, 500);
                    $('html, body').animate({
                        scrollTop: $("#scroll-folio").offset().top - 80
                    }, 400);
                } else {
                    $grid.isotope({
                        filter: c
                    });
                }
                $(".gallery-filters a").removeClass("gallery-filter-active");
                $(this).addClass("gallery-filter-active");
            });
            var gat = $(".gallery-filter-active").text();
        }

    }
    n();
    // Other functions ------------------
    function initbg() {
        var n = $(".bg");
        n.each(function (a) {
            if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
        });
    }
    initbg();
	//   RangeSlider------------------
    $(".rage-slider").ionRangeSlider({
        postfix: "px",
    });
    $(".shop-price").ionRangeSlider({
        keyboard: true,
        prefix: "$"
    });
    $(".smact").on("click", function (e) {
        e.preventDefault();
        $(this).toggleClass("smact_vis");
        $(this).parents(".smpar").find(".show-more-snopt-tooltip").toggleClass("show-more-snopt-tooltip_vis");
    });
    var maxL = 90;
    $(".dbig p").each(function (i, div) {
        var text = $(div).text();
        if (text.length > maxL) {
            var begin = text.substr(0, maxL),
                end = text.substr(maxL);
            $(div).html(begin).append($('<div class="hidden" />').html(end));
        }
    });
    $(".custom-scroll-link").on("click", function () {
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
    //   Contact form------------------
    $(document).on('submit', '#contactform', function () {
        var a = $(this).attr("action");
        $("#message").slideUp(750, function () {
            $("#message").hide();
            $("#submit").attr("disabled", "disabled");
            $.post(a, {
                name: $("#name").val(),
                email: $("#email").val(),
                comments: $("#comments").val()
            }, function (a) {
                document.getElementById("message").innerHTML = a;
                $("#message").slideDown("slow");
                $("#submit").removeAttr("disabled");
                if (null != a.match("success")) $("#contactform").slideDown("slow");
            });
        });
        return false;
    });
    $(document).on('keyup', '#contactform input, #contactform textarea', function () {
        $("#message").slideUp(1500);
    });
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
    $(".to-top").on("click", function (a) {
        a.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    if ($(".header-cart_wrap_container").length > 0) {
        var aps = new PerfectScrollbar('.header-cart_wrap_container', {
            swipeEasing: true,
            minScrollbarLength: 20
        });
    }
    if ($(".video-links-wrap").length > 0) {
        var aps = new PerfectScrollbar('.video-links-wrap', {
            swipeEasing: true,
            minScrollbarLength: 20
        });
    }
    var scwrp = $(".header-search-wrap"),
        swlink = $(".show_search-btn");
    function showSearch() {
        scwrp.fadeIn(1).addClass("vis-search").removeClass("novis_sarch")
        swlink.addClass("scwllink2");
        hideCart();
        hideShare();
    }
    function hideSearch() {
        scwrp.fadeOut(1).removeClass("vis-search").addClass("novis_sarch");
        swlink.removeClass("scwllink2");
    }
    swlink.on("click", function () {
        if (scwrp.hasClass("novis_sarch")) showSearch();
        else hideSearch();
    });
    var wlwrp = $(".header-cart_wrap"),
        wllink = $(".sc_btn");

    function showCart() {
        wlwrp.fadeIn(1).addClass("vis-cart").removeClass("novis_cart")
        aps.update();
        wllink.addClass("scwllink");
        hideShare();
        hideSearch();
    }
    function hideCart() {
        wlwrp.fadeOut(1).removeClass("vis-cart").addClass("novis_cart");
        wllink.removeClass("scwllink");
    }
    wllink.on("click", function () {
        if (wlwrp.hasClass("novis_cart")) showCart();
        else hideCart();
    });
    // Share   ------------------
    $(".share-container").share({
        networks: ['facebook', 'pinterest', 'twitter', 'linkedin', 'tumblr']
    });
    var swra = $(".share-wrapper"),
        clsh = $(".close-share-btn"),
        ssbtn = $(".showshare");
    function showShare() {
        ssbtn.addClass("uncl-share");
        swra.removeClass("isShare").addClass("share-wrapper_vis");
        hideSearch();
        hideCart();
    }
    function hideShare() {
        ssbtn.removeClass("uncl-share");
        swra.addClass("isShare").removeClass("share-wrapper_vis");
    }
    clsh.on("click", function () {
        hideShare();
    });
    ssbtn.on("click", function () {
        if (swra.hasClass("isShare")) showShare();
        else hideShare();
    });
    $(".show-reg-form").on("click", function () {
        showModal();
    });
    function showModal() {
        $(".main-register-container").fadeIn(1);
        $(".main-register-wrap").addClass("vis_mr");
    }
    function hideModal() {
        $(".main-register-container").fadeOut(1);
        $(".main-register-wrap").removeClass("vis_mr");
    }
    $(".close-reg-form").on("click", function () {
        hideModal();
    });
    // duplicate -----------------
    $.fn.duplicate = function (a, b) {
        var c = [];
        for (var d = 0; d < a; d++) $.merge(c, this.clone(b).get());
        return this.pushStack(c);
    };
    var cr = $(".star-rating");
    cr.each(function (cr) {
        var starcount = $(this).attr("data-starrating");
        $("<i class='fas fa-star'></i>").duplicate(starcount).prependTo(this);
    });
    $(window).on("scroll", function () {
        var a = $(document).height();
        var b = $(window).height();
        var c = $(this).scrollTop();
        var d = c / (a - b) * 100;
        $(".progress-bar").css({
            width: d + "%"
        });
        $('.hero-section_bg .bg').css('transform', 'translate3d(0, ' + +(c * 0.25) + 'px, 0)');
        if ($(this).scrollTop() > 150) {
            $(".top-bar").addClass("scroll-sticky");
            $(".aside-panel").addClass("vis_secnav");
        } else {
            $(".top-bar").removeClass("scroll-sticky");
            $(".aside-panel").removeClass("vis_secnav");
        }
    });
    // swiper -----------------
    if ($(".single-slider").length > 0) {
        var j2 = new Swiper(".single-slider .swiper-container", {
            preloadImages: false,
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoHeight: true,
            grabCursor: true,
            mousewheel: false,
            pagination: {
                el: '.ss-slider-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.ss-slider-cont-next',
                prevEl: '.ss-slider-cont-prev',
            },
        });
    }
    if ($(".video_carousel").length > 0) {
        var j2 = new Swiper(".video_carousel .swiper-container", {
            preloadImages: false,
            freeMode: false,
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            grabCursor: true,
            mousewheel: false,
            navigation: {
                nextEl: '.cc-next',
                prevEl: '.cc-prev',
            },
            pagination: {
                el: '.vc-pagination',
                clickable: true,
            },
            breakpoints: {
                1064: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                100: {
                    slidesPerView: 1,
                },
            }
        });
    }
    if ($(".single-grid-slider").length > 0) {
        var teamCarousel = new Swiper(".single-grid-slider .swiper-container", {
            preloadImages: false,
            loop: true,
            centeredSlides: false,
            freeMode: false,
            slidesPerView: 1,
            spaceBetween: 0,
            grabCursor: true,
            mousewheel: false,
            parallax: false,
            speed: 1400,
            pagination: {
                el: '.sgs-pagination',
                clickable: true,
            }
        });
    }
    if ($(".fs-carousel").length > 0) {
        var teamCarousel = new Swiper(".fs-carousel .swiper-container", {
            preloadImages: false,
            loop: true,
            centeredSlides: false,
            freeMode: false,
            slidesPerView: 4,
            spaceBetween: 0,
            grabCursor: true,
            mousewheel: false,
            parallax: true,
            speed: 1400,
            navigation: {
                nextEl: '.gc-button-next',
                prevEl: '.gc-button-prev',
            },
            breakpoints: {
                1700: {
                    slidesPerView: 4,
                },
                1268: {
                    slidesPerView: 3,
                },
                764: {
                    slidesPerView: 2,
                },
                100: {
                    slidesPerView: 1,
                },
            }
        });
    }
    if ($(".hero-carousel").length > 0) {
        var teamCarousel = new Swiper(".hero-carousel .swiper-container", {
            preloadImages: false,
            loop: true,
            centeredSlides: true,
            freeMode: false,
            slidesPerView: 3,
            spaceBetween: 10,
            grabCursor: true,
            mousewheel: false,
            parallax: false,
            speed: 1400,
            navigation: {
                nextEl: '.hc-cont-next',
                prevEl: '.hc-cont-prev',
            },
            pagination: {
                el: '.hero-carousel-pag',
                clickable: true,
            },
            breakpoints: {
                1068: {
                    slidesPerView: 3,
                },
                640: {
                    slidesPerView: 2,
                },
                100: {
                    slidesPerView: 1,
                },
            }
        });
    }
    if ($(".multi-slider").length > 0) {
        var ms2 = new Swiper(".multi-slider_control .swiper-container", {
            preloadImages: false,
            loop: true,
            speed: 2400,
            spaceBetween: 30,
            slidesPerView: 3,
            watchSlidesProgress: true,
            effect: "slide",
        });
        var ms1 = new Swiper(".multi-slider .swiper-container", {
            preloadImages: false,
            loop: true,
            speed: 2400,
            spaceBetween: 0,
            effect: "slide",
            grabCursor: true,
            parallax: false,
            pagination: {
                el: '.multi-pag',
                clickable: true,
            },
            thumbs: {
                swiper: ms2,
            },
            navigation: {
                nextEl: '.fs-slider-button-next',
                prevEl: '.fs-slider-button-prev',
            },
            autoplay: {
                delay: 3500,
                disableOnInteraction: false
            },

        });
        ms1.on("slideChangeTransitionStart", function () {
            $(".slider-progress-bar").removeClass("act-slider");
        });
        ms1.on("slideChangeTransitionEnd", function () {
            $(".slider-progress-bar").addClass("act-slider");
        });
    }

    // video -----------------
    var mianVidLink = $('.video-links-wrap .video-item'),
        mianVidLinkAct = $('.video-links-wrap .video-item.video-item_active'),
        videoHolder = $(".vh-main"),
        videoHolderTitle = $(".video-holder-title"),
        stisDataUrlPopupAct = mianVidLinkAct.data("video-link"),
        stisDataUrlAct = mianVidLinkAct.data("url"),
        stisDataUrlbgAct = mianVidLinkAct.find('img').attr("src"),
        stisDataUrlCatAct = mianVidLinkAct.find('.post-category-marker').text(),
        stisDataUrlCatUrlAct = mianVidLinkAct.find('.post-category-marker').attr("href"),
        stisTitleAct = mianVidLinkAct.find('.video-item-title h4').text(),
        stisTitleDateAct = mianVidLinkAct.find('.video-date strong').text();
    videoHolder.attr("href", stisDataUrlPopupAct);
    videoHolder.find(".bg").css("background-image", "url(" + stisDataUrlbgAct + ")");
    videoHolderTitle.find(".video-holder-title_item a").attr("href", stisDataUrlAct);
    videoHolderTitle.find(".video-holder-title_item a").text(stisTitleAct);
    videoHolderTitle.find(".video-date strong").text(stisTitleDateAct);
    videoHolderTitle.find(".post-category-marker").text(stisDataUrlCatAct);
    videoHolderTitle.find(".post-category-marker").attr("href", stisDataUrlCatUrlAct);
    mianVidLink.on("click", function () {
        var that = $(this),
            stisDataUrlPopup = that.data("video-link"),
            stisDataUrl = that.data("url"),
            stisDataUrlbg = that.find('img').attr("src"),
            stisDataUrlCat = that.find('.post-category-marker').text(),
            stisDataUrlCatUrl = that.find('.post-category-marker').attr("href"),
            stisTitle = that.find('.video-item-title h4').text(),
            stisTitleDate = that.find('.video-date strong').text();
        $(".vh-preloader ").fadeIn(400).delay(100).fadeOut(400);
        setTimeout(function () {
            videoHolder.attr("href", stisDataUrlPopup);
            videoHolder.find(".bg").css("background-image", "url(" + stisDataUrlbg + ")");
            videoHolderTitle.find(".video-holder-title_item a").attr("href", stisDataUrl);
            videoHolderTitle.find(".video-holder-title_item a").text(stisTitle);
            videoHolderTitle.find(".video-date strong").text(stisTitleDate);
            videoHolderTitle.find(".post-category-marker").text(stisDataUrlCat);
            videoHolderTitle.find(".post-category-marker").attr("href", stisDataUrlCatUrl);
        }, 500);
        mianVidLink.removeClass("video-item_active");
        that.addClass("video-item_active");
    });
    // Mob Menu------------------
    $(".nav-button-wrap").on("click", function () {
        $(".main-menu").toggleClass("vismobmenu");
    });
    function mobMenuInit() {
        var ww = $(window).width();
        if (ww < 1048) {
            $(".menusb").remove();
            $(".main-menu").removeClass("nav-holder");
            $(".main-menu nav").clone().addClass("menusb").appendTo(".main-menu");
            $(".menusb").menu();
        } else {
            $(".menusb").remove();
            $(".main-menu").addClass("nav-holder");
        }
    }
    mobMenuInit();
    $("#menu2").menu();
    $(".categories_nav-inner a.nav").parent("li").addClass("submen-dec");
    //   css ------------------
    var $window = $(window);
    $window.on("resize", function () {
        mobMenuInit();
    });
    $(".show-hidd-filters").on("click", function (w) {
        w.preventDefault();
        $(".mob-hid_filters").slideToggle(300);
    });

    // weather -----------------
    var datacityw = $("#weather-widget").data("city");
    $("#weather-widget").ideaboxWeather({
        location: datacityw,
    });
    $(".fontSize input").on("input", function () {
        $('#font_chage').find("p").css("font-size", $(this).val() + "px");
    });
    // ajax news -----------------
    $(".ajax-nav li a").click(function () {
        $("#ajax-content").animate({
            opacity: "0"
        }, 500);
        $(".ajax-nav li a").removeClass('current_page');
        $(this).addClass('current_page');
        $(".ajax-loader").fadeIn(100);
        setTimeout(function () {
            $("#ajax-content").empty();
        }, 500);
        $.ajax({
            url: this.href,
            success: function (html) {
                setTimeout(function () {
                    $("#ajax-content").animate({
                        opacity: "1"
                    }, 500);
                    $("#ajax-content").empty().append(html);
                    initbg();
                    $(".ajax-loader").fadeOut(100);
                }, 500);
            }
        });
        return false;
    });
    if ($("#ajax-content").length > 0) {
		$("#ajax-content").empty();
		$.ajax({
			url: 'ajax/category1.html',
			success: function (html) {
				$("#ajax-content").empty().append(html);
				initbg();
			}
		});
    }
    // scrolltofixed -----------------
    $(".fix-bar").scrollToFixed({
        minWidth: 1064,
        marginTop: 120,
        removeOffsets: true,
        limit: function () {
            var a = $(".limit-box").offset().top - $(".fix-bar").outerHeight(true) + 36;
            return a;
        }
    });
    $(".left_fix-bar").scrollToFixed({
        minWidth: 1064,
        marginTop: 90,
        removeOffsets: true,
        limit: function () {
            var a = $(".limit-box").offset().top - $(".left_fix-bar").outerHeight(true) + 36;
            return a;
        }
    });
    $(".single-post-content_column").scrollToFixed({
        minWidth: 856,
        marginTop: 90,
        removeOffsets: true,
        limit: function () {
            var a = $(".limit-box2").offset().top - $(".single-post-content_column").outerHeight(true);
            return a;
        }
    });
    if ($(".fixed-bar").outerHeight(true) < $(".fix-container-init").outerHeight(true)) {
        $(".fixed-bar").addClass("fixbar-action");
        $(".fixbar-action").scrollToFixed({
            minWidth: 1064,
            marginTop: function () {
                var a = $(window).height() - $(".fixed-bar").outerHeight(true) - 10;
                if (a >= 0) return 0;
                return a;
            },
            removeOffsets: true,
            limit: function () {
                var a = $(".limit-box").offset().top - $(".fixed-bar").outerHeight();
                return a;
            }
        });
    } else $(".fixed-bar").removeClass("fixbar-action");
    $(".picker-wrap-controls ul").scrollToFixed({
        marginTop: 90,
        removeOffsets: true,
        limit: function () {
            var a = $(".controls-limit").offset().top - $(".picker-wrap-controls ul").outerHeight(true);
            return a;
        }
    });
}
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
// Init all functions------------------
$(document).ready(function () {
    initGmag();
});