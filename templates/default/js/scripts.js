function initDiamant() {
    "use strict";
    firstLoad();
    function firstLoad() {
        $(".loader").delay(500).fadeOut(300, function () {
            setTimeout(function () {
                $('.cd-loader-layer').addClass('closing');
                $("#main").animate({
                    opacity: 1
                }, 500);
            }, 300);
            setTimeout(function () {
                $(".loader-wrap").fadeOut(1);
            }, 1200);
        });
    }
    //   Background image ------------------
    var a = $(".bg");
    a.each(function (a) {
        if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
    });
    //   Isotope------------------
    function nrg() {
        if ($(".gallery-items").length) {
            var a = $(".gallery-items").isotope({
                singleMode: true,
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".gallery-item, .gallery-item-second, .gallery-item-three",
                singleMode: true,
                transformsEnabled: true,
                transitionDuration: "900ms"
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
    }
    nrg();
    function postGrid() {
        if ($(".post-items").length) {
            var $grid2 = $(".post-items").isotope({
                singleMode: true,
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".post-item",
            });
            $grid2.imagesLoaded(function () {
                $grid2.isotope("layout");
            });
        }
    }
    postGrid();
    function csselem() {
        $(".anim-fw").css({
            height: $(".fw-carousel_hight").outerHeight(true)
        });
        $(".fs-slider-item").css({
            height: $(".fs-slider").outerHeight(true)
        });
        $(".first-slide_wrap").css({
            height: $(".fw-carousel_hight").outerHeight(true)
        });
        $(".height-emulator").css({
            height: $(".main-footer").outerHeight(true)
        });
    }
    csselem();
    //   swiper------------------
    if ($(".clients-carousel").length > 0) {
        var ms2 = new Swiper(".clients-carousel .swiper-container", {
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: false,
            slidesPerView: 4,
            spaceBetween: 0,
            speed: 1400,
            mousewheel: false,
            navigation: {
                nextEl: '.cc-next',
                prevEl: '.cc-prev',
            },
            breakpoints: {
                1064: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 0,
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                }
            }
        });
    }
    if ($(".fs-slider").length > 0) {
        var hcarosel = new Swiper(".fs-slider .swiper-container", {
            preloadImages: false,
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            grabCursor: true,
            mousewheel: false,
            centeredSlides: true,
            parallax: true,
            speed: 1400,
            pagination: {
                el: '.hero-slider-pag',
                clickable: true,
            },
            navigation: {
                nextEl: '.hs_btn_next',
                prevEl: '.hs_btn_prev',
            },
        });
        var ssnd = $('.fs-slider .swiper-container .swiper-wrapper .swiper-slide:not(.swiper-slide-duplicate)');
        var nxSlide = ssnd.eq(hcarosel.realIndex).next();
        var pvSlide = ssnd.eq(hcarosel.realIndex).prev();
        $('.hs_btn_next .hs_btn_wrap_preview .bg').css("background-image", "url(" + nxSlide.find('.bg').attr("data-bg") + ")");
        $('.hs_btn_prev .hs_btn_wrap_preview .bg').css("background-image", "url(" + pvSlide.find('.bg').attr("data-bg") + ")");
        hcarosel.on('slideChange', function () {
            var nxSlide = ssnd.eq(hcarosel.realIndex).next();
            var pvSlide = ssnd.eq(hcarosel.realIndex).prev();
            $('.hs_btn_next .hs_btn_wrap_preview .bg').css("background-image", "url(" + nxSlide.find('.bg').attr("data-bg") + ")");
            $('.hs_btn_prev .hs_btn_wrap_preview .bg').css("background-image", "url(" + pvSlide.find('.bg').attr("data-bg") + ")");
        });
    }
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
                nextEl: '.fw-carousel-button-next',
                prevEl: '.fw-carousel-button-prev',
            },
        });
    }
    if ($(".testimonilas-carousel").length > 0) {
        var ms1 = new Swiper(".testimonilas-carousel .swiper-container", {
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: true,
            slidesPerView: 3,
            spaceBetween: 20,
            speed: 1400,
            navigation: {
                nextEl: '.tc-button-next',
                prevEl: '.tc-button-prev',
            },
            pagination: {
                el: '.tcs-pagination_init',
                clickable: true,
            },
            breakpoints: {
                1064: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
            }
        });
    }
    if ($(".rooms-carousel").length > 0) {
        var ec = new Swiper(".rooms-carousel .swiper-container", {
            preloadImages: true,
            loop: true,
            centeredSlides: false,
            freeMode: false,
            slidesPerView: 3,
            spaceBetween: 10,
            grabCursor: true,
            mousewheel: false,
            speed: 1400,
            navigation: {
                nextEl: '.rc-button-next',
                prevEl: '.rc-button-prev',
            },
            pagination: {
                el: '.ss-slider-pagination',
                clickable: true,
            },
            breakpoints: {
                1564: {
                    slidesPerView: 2,
                },
                640: {
                    slidesPerView: 1,
                },
            }
        });
    }
    if ($(".events-carousel").length > 0) {
        var ec = new Swiper(".events-carousel .swiper-container", {
            preloadImages: false,
            slidesPerView: 2,
            spaceBetween: 20,
            loop: true,
            grabCursor: true,
            mousewheel: false,
            centeredSlides: false,
            navigation: {
                nextEl: '.ec-button-next',
                prevEl: '.ec-button-prev',
            },
            breakpoints: {
                1064: {
                    slidesPerView: 2,
                },
                640: {
                    slidesPerView: 1,
                },
            }
        });
    }
    if ($(".single-carousel").length > 0) {
        var totalSlides2 = $(".single-carousel .swiper-slide").length;
        var j2 = new Swiper(".single-carousel .swiper-container", {
            preloadImages: false,
            loop: true,
            freeMode: false,
            slidesPerView: 'auto',
            spaceBetween: 10,
            grabCursor: true,
            mousewheel: false,
            speed: 1400,
            centeredSlides: true,
            effect: "slide",
            pagination: {
                el: '.ss-slider-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.fw-carousel-button-next',
                prevEl: '.fw-carousel-button-prev',
            },
        });
    }
    if ($(".single-carousel2").length > 0) {
        var j2 = new Swiper(".single-carousel2 .swiper-container", {
            preloadImages: false,
            loop: true,
            freeMode: false,
            slidesPerView: 'auto',
            spaceBetween: 10,
            grabCursor: true,
            mousewheel: false,
            speed: 1400,
            centeredSlides: true,
            effect: "slide",
            pagination: {
                el: '.ss-slider-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.fw-carousel-button-next',
                prevEl: '.fw-carousel-button-prev',
            },
        });
    }
    if ($(".slideshow-container_wrap").length > 0) {
        const ms1 = new Swiper(".slideshow-container_wrap .swiper-container", {
            preloadImages: false,
            loop: true,
            speed: 1400,
            spaceBetween: 0,
            effect: "fade",
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            pagination: {
                el: '.hero-slider-pag',
                clickable: true,
            },
        });
        ms1.on("slideChangeTransitionStart", function () {
            $(".slide-progress").css({
                height: 0,
                transition: "height 0s"
            });
        });
        ms1.on("slideChangeTransitionEnd", function () {
            $(".slide-progress").css({
                height: "100%",
                transition: "height 2000ms"
            });
        });
    }
    //   lightGallery------------------
    $(".image-popup , .single-popup-image").lightGallery({
        selector: "this",
        cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
        download: false,
        counter: false
    });
    $(".lightgallery").lightGallery({
        selector: ".lightgallery a.popup-image , .lightgallery  a.popgal",
        cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
        download: false,
        loop: false,
        counter: false
    });
    $('#html5-videos , .inithtml5video').lightGallery({
        selector: 'this',
        counter: false,
        download: false,
        zoom: false
    });
    var vid_src = $(".popup_video").data("videolink");
    $(".lg-video-object").find("source").attr("src", vid_src);	
    //   appear------------------
    $(".stats").appear(function () {
        $(".num").countTo();
    });
    // Share   ------------------
    $(".sfcs").on("click", function () {
        $(this).toggleClass("vis-buts h");
        $(".fixed-scroll-column-share-container").slideToggle(400);
    });
    $(".share-container").share({
        networks: ['facebook', 'pinterest', 'tumblr', 'twitter', 'linkedin']
    });
    var shrcn = $(".share-wrapper"),
        clsh = $(".share-container a");

    function showShare() {
        shrcn.addClass("visshare").removeClass("isShare");
        setTimeout(function () {
            clsh.each(function (a) {
                var b = $(this);
                setTimeout(function () {
                    b.addClass("vissharea")
                }, 50 * a);
            });
        }, 300);
        $(".showshare").addClass("vis-shar");
    }
    function hideShare() {
        clsh.removeClass("vissharea")
        setTimeout(function () {
            shrcn.removeClass("visshare").addClass("isShare");
        }, 300);
        $(".showshare").removeClass("vis-shar");
    }
    $(".showshare").on("click", function () {
        if ($(".share-wrapper").hasClass("isShare")) showShare();
        else hideShare();
    });
    var wlwrp = $(".wish-list-wrap"),
        wllink = $(".sc_btn"),
        ho = $(".header-overlay");
    function showCart() {
        wlwrp.fadeIn(1).addClass("vis-cart").removeClass("novis_cart");
        ho.fadeIn(500);
        wllink.addClass("scwllink");
        hideShare();
    }
    function hideCart() {
        wlwrp.fadeOut(1).removeClass("vis-cart").addClass("novis_cart");
        wllink.removeClass("scwllink");
        ho.fadeOut(500);
    }
    wllink.on("click", function () {
        if (wlwrp.hasClass("novis_cart")) showCart();
        else hideCart();
    });
    $(".close_cart-init").on("click", function () {
        hideCart();
    });
    //   scrollToFixed ------------------
    $(".init-fix-header").scrollToFixed({
        marginTop: 0,
        removeOffsets: true,
    });
    $(".fix-bar-init").scrollToFixed({
        minWidth: 1064,
        zIndex: 112,
        marginTop: 110,
        removeOffsets: true,
        limit: function () {
            const a = $(".limit-box").offset().top - $(".fix-bar-init").outerHeight(true);
            return a;
        }
    });
    if ($(".fixed-bar").outerHeight(true) < $(".post-container").outerHeight(true)) {
        $(".fixed-bar").addClass("fixbar-action");
        $(".fixbar-action").scrollToFixed({
            minWidth: 1064,
            marginTop: function () {
                var a = $(window).height() - $(".fixed-bar").outerHeight(true) - 120;
                if (a >= 0) return 20;
                return a;
            },
            removeOffsets: true,
            limit: function () {
                var a = $(".limit-box").offset().top - $(".fixed-bar").outerHeight() + 30;
                return a;
            }
        });
    } else $(".fixed-bar").removeClass("fixbar-action");
    //   Video------------------	
    if ($(".video-holder-wrap").length > 0) {
        function videoint() {
            var w = $(".background-vimeo").data("vim"),
                bvc = $(".background-vimeo"),
                bvmc = $(".media-container"),
                bvfc = $(".background-vimeo iframe "),
                vch = $(".video-container");
            bvc.append('<iframe src="//player.vimeo.com/video/' + w + '?background=1"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ></iframe>');
            $(".video-holder").height(bvmc.height());
            if ($(window).width() > 1024) {
                if ($(".video-holder").length > 0)
                    if (bvmc.height() / 9 * 16 > bvmc.width()) {
                        bvfc.height(bvmc.height()).width(bvmc.height() / 9 * 16);
                        bvfc.css({
                            "margin-left": -1 * $("iframe").width() / 2 + "px",
                            top: "-75px",
                            "margin-top": "0px"
                        });
                    } else {
                        bvfc.width($(window).width()).height($(window).width() / 16 * 9);
                        bvfc.css({
                            "margin-left": -1 * $("iframe").width() / 2 + "px",
                            "margin-top": -1 * $("iframe").height() / 2 + "px",
                            top: "50%"
                        });
                    }
            } else if ($(window).width() < 760) {
                $(".video-holder").height(bvmc.height());
                bvfc.height(bvmc.height());
            } else {
                $(".video-holder").height(bvmc.height());
                bvfc.height(bvmc.height());
            }
            vch.css("width", $(window).width() + "px");
            vch.css("height", Number(720 / 1280 * $(window).width()) + "px");
            if (vch.height() < $(window).height()) {
                vch.css("height", $(window).height() + "px");
                vch.css("width", Number(1280 / 720 * $(window).height()) + "px");
            }
        }
        videoint();
    }
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
    $(".to-top").on("click", function (a) {
        a.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    //   Contact form------------------
    $("#contactform").submit(function () {
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
    $("#contactform input, #contactform textarea").keyup(function () {
        $("#message").slideUp(1500);
    });
    function cardRaining() {
        $.fn.duplicate = function (a, b) {
            var c = [];
            for (var d = 0; d < a; d++) $.merge(c, this.clone(b).get());
            return this.pushStack(c);
        };
        var cr = $(".star-rating");
        cr.each(function (cr) {
            var starcount = $(this).attr("data-starrating");
            $("<i class='fa-solid fa-star'></i>").duplicate(starcount).prependTo(this);
        });
    }
    cardRaining();
    //   forms js------------------
    $('.quantity-item').each(function () {
        var spinner = $(this),
            input = spinner.find('input[type="text"]'),
            btnUp = spinner.find('.plus'),
            btnDown = spinner.find('.minus'),
            min = input.attr('data-min'),
            max = input.attr('data-max');
        btnUp.click(function () {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input.qty").val(newVal);
            spinner.find("input.qty").trigger("change");
        });
        btnDown.click(function () {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input.qty").val(newVal);
            spinner.find("input.qty").trigger("change");
        });
    });
    $('.chosen-select').niceSelect();
    $('#res_date').daterangepicker({
        autoUpdateInput: false,
        parentEl: $(".date-container"),
        singleDatePicker: false,
        timePicker: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $('#res_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'))
    });
    $('#res_date').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
    var $window = $(window);
    $window.scroll(function () {
        if ($(this).scrollTop() > 150) {
            $("header.header_half , .logo-holder").addClass("scroll-sticky");
        } else {
            $("header.header_half , .logo-holder").removeClass("scroll-sticky");
        }
    });
    //   mailchimp------------------
    $("#subscribe").ajaxChimp({
        language: "eng",
        url: "https://gmail.us1.list-manage.com/subscribe/post?u=1fe818378d5c129b210719d80&amp;id=a2792f681b"
    });
    $.ajaxChimp.translations.eng = {
        submit: "Submitting...",
        0: ' We will be in touch soon!',
        1: ' You must enter a valid e-mail address.',
        2: ' E-mail address is not valid.',
        3: ' E-mail address is not valid.',
        4: ' E-mail address is not valid.',
        5: ' E-mail address is not valid.'
    };
    $('.svg-corner_dark').append('<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M40 40V0C40 22.0914 22.0914 40 0 40H40Z" fill="#000000"></path></svg>');
    $('.svg-corner_white').append('<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M40 40V0C40 22.0914 22.0914 40 0 40H40Z" fill="#ffffff"></path></svg>');
    //   tabs------------------
    $(".first-tab .hero-menu-item").addClass("uvis-hmi");
    $(".tabs-menu a").on("click", function (a) {
        $(".hero-menu-item").removeClass("uvis-hmi");
        a.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var b = $(this).attr("href");
        $(this).parents(".tabs-act").find(".tab-content").not(b).css("display", "none");
        $(b).fadeIn(1);
        setTimeout(function () {
            $(b).find(".hero-menu-item").each(function (a) {
                var boi = $(this);
                setTimeout(function () {
                    boi.addClass("uvis-hmi ")
                }, 130 * a);
            });

        });
    });
    $(".fw-aminit-item").on({
        mouseenter: function () {
            var bgt2 = $(this).data("bgtab");
            $(".cd-link-overlay-layer").addClass('opening ');
            setTimeout(function () {
                $(".chgbg_it").css("background-image", "url(" + bgt2 + ")");
                $(".cd-link-overlay-layer").addClass('closing ');
            }, 500);
            setTimeout(function () {
                $(".cd-link-overlay-layer").removeClass('opening closing');
            }, 501);
        }
    });
    var hidworit = $('.fw-aminit-item'),
        hidworit_length = hidworit.length;
    $("<div class='bg'></div>").duplicate(hidworit_length).appendTo(".bg-ser");
    var hidworit_actin = $('.fw-aminit-wrap').children('.fw-aminit-item').eq(1),
        actbgindex = hidworit_actin.data("bgtab");
    hidworit_actin.addClass("act-index");
    $('.bg-ser').children('.bg').eq(1).addClass('active').css("background-image", "url(" + actbgindex + ")");
    $('.fw-aminit-item').on('mouseover', function () {
        $('.fw-aminit-item').removeClass("act-index");
        $(this).addClass("act-index");
        var hidworit_index = $('.fw-aminit-item').index(this),
            hidworit_index_each = $(this).data("bgtab");
        $('.bg-ser .bg').removeClass('active').eq(hidworit_index).addClass('active').css("background-image", "url(" + hidworit_index_each + ")");
    });
    // Mob Menu------------------
    $(".nav-button-wrap").on("click", function () {
        $(".main-menu").toggleClass("vismobmenu");
    });
    function mobMenuInit() {
        var ww = $(window).width();
        if (ww < 1068) {
            $(".menusb").remove();
            $(".main-menu").removeClass("nav-holder");
            $(".main-menu nav").clone().addClass("menusb").appendTo(".main-menu");
            $(".menusb").menu();
            $(".menusb.scroll-init a").on("click", function () {
                $(".main-menu").removeClass("vismobmenu");
            });
        } else {
            $(".menusb").remove();
            $(".main-menu").addClass("nav-holder");
        }
    }
    mobMenuInit();
    //   css ------------------
    var $window = $(window);
    $window.on("resize", function () {
        csselem();
        mobMenuInit();
    });
    //   scrollnav  ------------------
    $(".scroll-init").singlePageNav({
        filter: ":not(.external)",
        updateHash: false,
        offset: 150,
        threshold: 120,
        speed: 1200,
        currentClass: "actscr-link"
    });
    //   Parallax ------------------
    var b = new Scrollax();
    b.reload();
    b.init();
}
$('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">');
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
//   Init All ------------------
$(document).ready(function () {
    initDiamant();
});