function initTerris() {
    //   loader -----
    "use strict";
            $(".loader-wrap").delay(1000).fadeOut(200, function () {
                $("#main").animate({
                    opacity: "1"
                }, 500);
                var chdpt = $(".content").data("pagetitle");
                $(".header-page_title span").text(chdpt).shuffleLetters({});
            });
    //   Background image -----
    var a = $(".bg");
    a.each(function (a) {
        if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
    });
    //  scrollToFixed------
    $(".srcl_init").scrollToFixed({
        zIndex: 112,
        marginTop: 0,
        preFixed: function () {
            $(this).addClass("fix_act")
        },
        postFixed: function () {
            $(this).removeClass("fix_act")
        }
    });

    $(".fbi_init").scrollToFixed({
        minWidth: 1068,
        zIndex: 111,
        marginTop: 90,
        removeOffsets: true,
        limit: function () {
            var acv = $(".limit-box").offset().top - $(".fbi_init").outerHeight() - 180;
            return acv;
        }
    });
    $(".scroll-fixed-column-content").scrollToFixed({
        zIndex: 1112,
        bottom: 0,
        removeOffsets: true,
        limit: function () {
            var a = $(".limit-box").offset().top - $(".scroll-fixed-column-content").outerHeight(true);
            return a;
        }
    });
    //   lightGallery--------
    function initlightgallery() {
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
            loop: true,
            counter: false
        });
        $('#html5-videos').lightGallery({
            selector: 'this',
            counter: false,
            download: false,
            zoom: false
        });
        const vid_src = $(".popup_video").data("videolink");
        $(".lg-video-object").find("source").attr("src", vid_src);
    }
    initlightgallery();
    //   Isotope-------
    function n() {
        if ($(".gallery-items").length) {
            var a = $(".gallery-items").isotope({
                singleMode: true,
                transformsEnabled: true,
                transitionDuration: "500ms",
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".gallery-item, .gallery-item-second, .gallery-item-three",
            });
            a.imagesLoaded(function () {
                a.isotope("layout");
            });
            $(".gallery-filters").on("click  ", "a.gallery-filter", function (b) {
                b.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#port-scroll').offset().top - 180
                }, 600);
                var c = $(this).attr("data-filter"),
                    d = $(this).text();
                setTimeout(function () {
                    a.isotope({
                        filter: c
                    });
                }, 700);
                $(".gallery-filters a").removeClass("gallery-filter-active");
                $(this).addClass("gallery-filter-active");
            });
        }
        $(".gallery-items").isotope("on", "layoutComplete", function (a, b) {
            var b = a.length;
            $(".num-album").html(b);
        });
        var b = $(".gallery-item").length;
        $(".num-album_total , .num-album").html(b);
        $(".load-more").on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            setTimeout(function () {
                $this.addClass("compload");
                $(".portfolio-msg").addClass("vismsg");
            }, 700);
            a.infinitescroll({
                navSelector: "#infiniti_nav",
                nextSelector: "#infiniti_nav a",
                itemSelector: ".gallery-item, .gallery-item-second, .gallery-item-three"
            }, function (b) {
                a.isotope("appended", $(b));
                a.imagesLoaded(function () {
                    a.isotope("layout");
                    $(".gallery-item").each(function (i) {
                        $(this).find(".pr_num").text("0" + ++i + ".");
                    });
                });
                var b = $(".gallery-item").length;
                $(".num-album_total").html(b);

                $(".gallery-item").on({
                    mouseenter: function () {
                        $(this).find(".grid-det_link span").shuffleLetters({});
                    }
                });
                hoverdirInit();
                initlightgallery();
            });
        });
        $(".gallery-item").each(function (i) {
            $(this).find(".pr_num").text("0" + ++i + ".");
        });
    }
    function postGrid2() {
        if ($(".post-items").length) {
            const $grid2 = $(".post-items").isotope({
                singleMode: true,
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".post-item",
            });
            $grid2.imagesLoaded(function () {
                $grid2.isotope("layout");
            });
        }
    }
    postGrid2();
    n();
    $(window).on("load", function () {
        n();
        postGrid2();
    });
    //   mobile filter ------------------
    $(".show-filter").on("click", function () {
        $(".init_hidden_filter").fadeToggle(300);
    });
    $(".gallery-filters a").on("click", function () {
        if ($(window).width() < 1064) {
            $(".init_hidden_filter").delay(1000).fadeOut(300);
        }
    });
    //   Swiper------------------
    if ($(".hero-slider").length > 0) {
        var hcarosel = new Swiper(".hero-slider  .swiper-container", {
            preloadImages: false,
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            grabCursor: true,
            mousewheel: false,
            centeredSlides: false,
            parallax: true,
            speed: 1000,
            autoHeight: true,
            pagination: {
                el: '.hc-pag',
                clickable: true,
            },
            navigation: {
                nextEl: '.hc_btn_next',
                prevEl: '.hc_btn_prev',
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
        });
        hcarosel.on("slideChangeTransitionStart", function () {
            $(".hero-blur-container").addClass("hideblur");
            $(".slide-progress").css({
                width: 0,
                transition: "width 0s"
            });
            $(".hero-slider-container-zoom").addClass("hide_hrz");
        });
        hcarosel.on("slideChangeTransitionEnd", function () {
            var actslidec = $(".hero-slider .swiper-slide.swiper-slide-active .hero-carousel_item").attr('data-imbg');
            $('.hero-blur-container .bg').css("background-image", "url(" + actslidec + ")");
            $(".hero-blur-container").removeClass("hideblur");
            $(".hero-slider-container-zoom").attr("href", actslidec);
            $(".hero-slider-container-zoom").removeClass("hide_hrz");
            $(".slide-progress").css({
                width: "100%",
                transition: "width 2000ms"
            });
        });
        var actslidec = $(".hero-slider .swiper-slide.swiper-slide-active .hero-carousel_item").attr('data-imbg');
        $('.hero-blur-container .bg').css("background-image", "url(" + actslidec + ")");
        $(".hero-slider-container-zoom").attr("href", actslidec);
        var totalSlides2 = $(".hero-slider .swiper-slide:not(.swiper-slide-duplicate)").length;
        $('.total_c').html("0" + totalSlides2);
        hcarosel.on('slideChange', function () {
            var csli2 = hcarosel.realIndex + 1,
                curnum2 = $('.current_c'),
                curnumanm2 = $('.hc_counter .current_c');
            curnum2.html("0" + csli2);
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
                delay: 4000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.hc-pag',
                clickable: true,
            },
        });
        ms1.on("slideChangeTransitionStart", function () {
            $(".slide-progress").css({
                width: 0,
                transition: "width 0s"
            });
        });
        ms1.on("slideChangeTransitionEnd", function () {
            $(".slide-progress").css({
                width: "100%",
                transition: "width 2000ms"
            });
        });
    }
    if ($(".single-slider").length > 0) {
        var m2 = new Swiper(".single-slider .swiper-container", {
            effect: $(".single-slider").data("effects"),
            pagination: {
                el: '.ss-slider-pagination',
                clickable: true,
            },
            loop: true,
            grabCursor: true,
            autoHeight: true,
            navigation: {
                nextEl: '.ss-slider-cont-next',
                prevEl: '.ss-slider-cont-prev',
            },
        });
    }
    if ($(".testimonilas-carousel").length > 0) {
        const ms1 = new Swiper(".testimonilas-carousel .swiper-container", {
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: true,
            slidesPerView: 3,
            spaceBetween: 20,
            speed: 1400,
            pagination: {
                el: '.testi-slider-pagination',
                clickable: true,

            },
            navigation: {
                nextEl: '.tc-button-next',
                prevEl: '.tc-button-prev',
            },
            breakpoints: {
                1620: {
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
    if ($(".team-carousel").length > 0) {
        const ms2 = new Swiper(".team-carousel .swiper-container", {
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: false,
            slidesPerView: 3,
            spaceBetween: 0,
            speed: 1400,
            pagination: {
                el: '.team-carousel-slider-pagination',
                clickable: true,

            },
            navigation: {
                nextEl: '.tmc-button-next',
                prevEl: '.tmc-button-prev',
            },
            breakpoints: {
                1464: {
                    slidesPerView: 2,

                    centeredSlides: true,
                },
                768: {
                    slidesPerView: 1,

                    centeredSlides: false,
                },
            }
        });
    }
    if ($(".center-carousel").length > 0) {
        var j5 = new Swiper(".center-carousel .swiper-container", {
            preloadImages: true,
            slidesPerView: 'auto',
            spaceBetween: 4,
            loop: true,
            grabCursor: true,
            mousewheel: false,
            centeredSlides: true,
            autoHeight: false,
            speed: 1400,
            pagination: {
                el: '.sin-carousel-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    autoHeight: true,
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
            },
            navigation: {
                nextEl: '.ccsw-next',

                prevEl: '.ccsw-prev',
            },
        });
        var totalSlides = $(".center-carousel .swiper-slide:not(.swiper-slide-duplicate) img").length;
        $('.total').html('0' + totalSlides);
        j5.on('slideChange', function () {
            const csli = j5.realIndex + 1,
                curnum = $('.current'),
                curnumanm = $('.hs_counter .current');
            curnum.html('0' + csli);
        });
    }
    if ($(".clients-carousel").length > 0) {
        const ms1 = new Swiper(".clients-carousel .swiper-container", {
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: false,
            slidesPerView: 5,
            spaceBetween: 1,
            speed: 1400,
            mousewheel: false,
            navigation: {
                nextEl: '.cc-button-next',
                prevEl: '.cc-button-prev',
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
                540: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
            }
        });
    }
    if ($(".half-carousel-conatiner").length > 0) {
        const halfCarousel = new Swiper(".half-carousel .swiper-container", {
            preloadImages: false,
            loop: true,
            centeredSlides: false,
            freeMode: false,
            slidesPerView: 2,
            spaceBetween: 1,
            grabCursor: true,
            mousewheel: false,
            parallax: true,
            speed: 1400,
            pagination: {
                el: '.cen-slider-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.hcw-cont-next',
                prevEl: '.hcw-cont-prev',
            },
            breakpoints: {
                1258: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
            }
        });
        const totalSlides2 = $(".half-carousel .swiper-slide:not(.swiper-slide-duplicate) .half-carousel-item").length;
        $('.total').html('0' + totalSlides2);
        halfCarousel.on('slideChange', function () {
            const csli2 = halfCarousel.realIndex + 1,
                curnum2 = $('.current'),
                curnumanm2 = $('.hs_counter .current');
            curnum2.html('0' + csli2);
        });
    }
    function hoverdirInit() {
        $(" .init_hoverdir .gallery-item").each(function () {
            $(this).hoverdir();
        });
    }
    hoverdirInit();
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
    $(".dec-counter").each(function () {
        var numdec = $(this).parents(".inline-facts").find("div.num").data("num");
        $(this).text(numdec)
    });
    //   tabs------------------
    $(".tabs-menu a").on("click", function (a) {
        $(".tabs-menu li").removeClass("selectedLava");
        $(this).parent("li").addClass("selectedLava");
        var tcitem = $(".tc_item"),
            tbamDat = $(this).data("tabnum");
        tcitem.html(tbamDat);
        a.preventDefault();
        var b = $(this).attr("href");
        $(".tab-content").not(b).css("display", "none");
        $(b).css({
            display: "block",
            visibility: 'visible'
        });

        if ($("#map-single").length > 0) {
            setTimeout(function () {
                map.invalidateSize()
            }, 400);
        }

        n();
    });
    //   scroll to------------------
    $(".custom-scroll-link").on("click", function () {
        var a = 90;
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
    $(".init_onepagenav  ul").singlePageNav({
        filter: ":not(.external)",
        updateHash: false,
        offset: 90,
        threshold: 1,
        speed: 1200,
        currentClass: "act-sec",
        onComplete: function () {
            hideMenu();
        }
    });
    $(".to-top").on("click", function (a) {
        a.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    var progressBar = $(".js-progress-bar");
    var $window = $(window);
    $window.on("scroll", function () {
        var a = $(document).height();
        var b = $window.height();
        var c = $window.scrollTop();
        var d = c / (a - b) * 100;
        progressBar.css("stroke-dashoffset", 100 - (d));
    });
    //   Contact form------------------
    $("#contactform").submit(function () {
        const a = $(this).attr("action");
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
    $(".toglle-header").on("click", function () {
        $(this).parent(".toogle-item").find(".toglle-content").slideToggle(200);
        $(this).parent(".toogle-item").delay(200).toggleClass("toogle-item_vis");
    });
    $(".shuffleLetter , .header-social a , .share-container a , .footer-contacts a , .footer-social a , .main-social a , .commentform button , .custom-form button , .team-nav a strong , .box_gallery-filters a strong ,  .tabs-menu a , .shb_init span , .home_services_list a strong , .half-carousel-content h3 a , .hc_controls_link a , .team-social li a  , .home_services_btn_wrap a  , .team-content h4 , .testi-link").on({
        mouseenter: function () {
            $(this).shuffleLetters({});
        }
    });
    $(".gallery-item").on({
        mouseenter: function () {
            $(this).find(".grid-det_link span").shuffleLetters({});
        }
    });
    $(".share-button-wrap").on({
        mouseenter: function () {
            $(this).find(".share-button_title").shuffleLetters({});
        }
    });
    $(".nav-button-container").on({
        mouseenter: function () {
            $(this).find(".menu-button-text").shuffleLetters({});
        }
    });
    $(".btn , .fixed-bar_item_btn , .strt_btn , .post-item_footer a ").on({
        mouseenter: function () {
            $(this).find("span").shuffleLetters({});
        }
    });
    // serv hover------------------
    var hidworit_actin = $('.home_services_list .hidden-works-item:first-child'),
        actbgindex = hidworit_actin.data("bgscr");
    $('.bg-ser .bg').css("background-image", "url(" + actbgindex + ")");
    $('.hidden-works-item').on({
        mouseenter: function () {
            $(this).find("strong").shuffleLetters({});
            $(".hsbw_bg").addClass("hideblur");
            setTimeout(function () {
                $(".hsbw_bg").removeClass("hideblur");
            }, 400);
            var hidworit_index_each = $(this).data("bgscr");
            $('.bg-ser .bg').css("background-image", "url(" + hidworit_index_each + ")");
        },
        mouseleave: function () {
            var hidworit_actin = $('.home_services_list .hidden-works-item:first-child'),
                actbgindex = hidworit_actin.data("bgscr");
            $('.bg-ser .bg').css("background-image", "url(" + actbgindex + ")");
        }
    });
    $('.hidden-works-item').on("click", function (e) {
        e.preventDefault();
        $(".services-modal-wrap").fadeIn(1);
        $(".services-overlay").fadeIn(400);
        $(this).parents(".home_services_list_item").find(".serv-details").clone().appendTo(".serv-post");
        var hidworit_index_each = $(this).data("bgscr");
        $('.services-modal-bg .bg').css("background-image", "url(" + hidworit_index_each + ")");
        var hidworit_index_num = $(this).find("span").text();
        $('.serv_numder').text(hidworit_index_num);
        setTimeout(function () {
            $(".services-modal-wrap_item").addClass("smod_vis");

        }, 200);
    });
    $(".cmod_ser").on("click", function (e) {
        $(".services-modal-wrap_item").removeClass("smod_vis");
        setTimeout(function () {
            $(".services-overlay").fadeOut(400);
            $(".serv-post").find(".serv-details").remove();
        }, 400);
        $(".services-modal-wrap").delay(600).fadeOut(1);

    });
    $(".show_team-info").on("click", function () {
        $(this).parents(".team-item").find(".team-info-wrap").addClass("tiw_visible");
    });
    $(".ti_close").on("click", function () {
        $(this).parents(".team-item").find(".team-info-wrap").removeClass("tiw_visible");
    });
    $(".offer-box").on({
        mouseenter: function () {
            $(".offer-box").removeClass("offb_visbg");
            $(this).addClass("offb_visbg");
        }
    });
    $('.block_img_fs-let').rotaterator({
        fadeSpeed: 800,
        pauseSpeed: 1500
    });
    //  menu  ------------------
    var $window = $(window);
    //  Css------------------
    function csselem() {
        $(".height-emulator").css({
            height: $(".main-footer").outerHeight(true)
        });
        var ap = $(".tabs-menu li").length;
        var bp = $(".tabs-menu").width();
        $(".tabs-menu li").css({
            width: bp / ap - 0.5
        });
    }
    csselem();
    //   css ------------------
    $window.on("resize", function () {
        csselem();
    });
    //   Video------------------	
    if ($(".video-holder-wrap").length > 0) {
        function videoint() {
            const w = $(".background-vimeo").data("vim"),
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
}
$("#menu_init").menu();
$(".sliding-menu li a.nav").parent("li").addClass("submen-dec");
var navover = $(".nav-ovelay"),
    navholder = $(".nav-wrapper"),
    navcon = $(".nav-container"),
    hevis = $(".hid_vismen"),
    ndw = $(".nav-button-wrap");
function showMenu() {
    navholder.removeClass("isvis_menu").addClass("nh_vis");
    navover.fadeIn(400);
    navcon.addClass("nav-container_vis");
    ndw.addClass("cmenu");
    setTimeout(function () {
        hevis.addClass("hid_vismen_act");
    }, 800);
    hideShare();
}
function hideMenu() {
    navcon.removeClass("nav-container_vis");
    ndw.removeClass("cmenu");
    navover.fadeOut(400);
    setTimeout(function () {
        hevis.removeClass("hid_vismen_act");
        navholder.addClass("isvis_menu").removeClass("nh_vis");
    }, 400);
}
ndw.on("click", function () {
    if (navholder.hasClass("isvis_menu")) showMenu();
    else hideMenu();
});
navover.on("click", function () {
    hideMenu();
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
    hideMenu();
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
$.Scrollax();
function initcanvas() {
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
     var parcount = $(".partcile-dec").data("parcount");
    $(".partcile-dec").each(function () {
        var parcount = $(this).data("parcount");
        $(this).jParticle({
            background: "rgba(255,255,255,0.01)",
            color: "#ccc",
            particlesNumber: parcount,
            particle: {
                speed: 20
            }
        });
    });
    }
    if (trueMobile) {
        $(".partcile-dec").remove();
    }
}
//   load animation------------------
$.fn.duplicate = function (a, b) {
    var c = [];
    for (var d = 0; d < a; d++) $.merge(c, this.clone(b).get());
    return this.pushStack(c);
};
$("<span class='arrow_dec_dot'></span>").duplicate(9).appendTo(".arrow_dec");
$('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">');
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
//   Init All Functions------------------
$(document).ready(function () {
    initTerris();
    initcanvas();
});