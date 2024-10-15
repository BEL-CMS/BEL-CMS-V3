function initEcrait() {
    //   loader -----
    "use strict";
    firstLoad();
    function firstLoad() {
        TweenMax.to($(".double-bounce2"), 1.2, {
            force3D: true,
            right: "0",
            delay: 0.3,
            ease: Expo.easeInOut,
            onComplete: function () {
                TweenMax.to($(".spinner"), 1.0, {
                    force3D: true,
                    y: "-150px",
                    opacity: 0,
                    ease: Expo.easeInOut,

                    onComplete: function () {
                        $("#main").addClass("vis-main")
                        $(".loader .pl-row-anim").each(function (index, element) {
                            var tl = new TimelineLite();
                            tl.to(element, 0.6, {
                                force3D: true,
                                bottom: "100%",
                                ease: Expo.easeInOut
                            }, index * 0.1)
                        });
                        $(".loader .pl-row-anim2").each(function (index, element) {
                            var tl = new TimelineLite();
                            tl.to(element, 0.8, {
                                force3D: true,
                                bottom: "100%",
                                ease: Expo.easeInOut,
                                onComplete: function () {
                                    $(".loader").fadeOut(1);

                                }
                            }, index * 0.1)
                        });
                    }
                });
            }
        });
    }
    //   Background image -----
    var a = $(".bg");
    a.each(function (a) {
        if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
    });
    //  scrollToFixed------
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
    $(".init-fc").scrollToFixed({
        minWidth: 1068,
        zIndex: 111,
        marginTop: 90,
        removeOffsets: true,
        limit: function () {
            var acv = $(".limit-box").offset().top - $(".init-fc").outerHeight() - 180;
            return acv;
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
        var vid_src = $(".popup_video").data("videolink");
        $(".lg-video-object").find("source").attr("src", vid_src);
    }
    initlightgallery();
    //   Isotope-------
    function n() {
        if ($(".gallery-items").length) {
            var a = $(".gallery-items").isotope({
                singleMode: true,
                transformsEnabled: true,
                transitionDuration: "800ms",
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".gallery-item, .gallery-item-second, .gallery-item-three",
            });
            a.imagesLoaded(function () {
                a.isotope("layout");
            });
            $(".gallery-filters").on("click  ", "a.gallery-filter", function (b) {
                b.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#port-scroll').offset().top - 178
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
            $(".num-album").html("0" + b).shuffleLetters({});
        });
        var b = $(".gallery-item").length;
        $(".num-album_total , .num-album").html("0" + b);

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
    function inithorizontalPortfolio() {
        if ($("#portfolio_horizontal_container").length) {
            var d = $("#portfolio_horizontal_container");
            d.imagesLoaded(function (a, b, e) {
                var f = {
                    itemSelector: ".portfolio_item",
                    layoutMode: "packery",
                    packery: {
                        isHorizontal: true,
                        gutter: 0
                    },
                    resizable: true,
                    transformsEnabled: true,
                    transitionDuration: "700ms"
                };
                var g = {
                    itemSelector: ".portfolio_item",
                    layoutMode: "packery",
                    packery: {
                        isHorizontal: false,
                        gutter: 0
                    },
                    resizable: true,
                    transformsEnabled: true,
                    transitionDuration: "700ms"
                };
                if ($(window).width() < 764) {
                    d.isotope(g);
                    d.isotope("layout");
                    d.removeAttr('style');
                    $(".horizontal-grid-wrap").getNiceScroll().remove();
                } else {
                    d.isotope(f);
                    d.isotope("layout");
                    $(".horizontal-grid-wrap").niceScroll({
                        cursorwidth: "2px",
                        cursorborder: "none",
                        cursorborderradius: "0px",
                        touchbehavior: true,
                        autohidemode: false,
                        cursorcolor: "#F57500",
                        bouncescroll: false,
                        scrollspeed: 120,
                        mousescrollstep: 90,
                        grabcursorenabled: true,
                        horizrailenabled: true,
                        preservenativescrolling: true,
                        cursordragontouch: false,
                        railpadding: {
                            top: -70,
                            right: 0,
                            left: 0,
                            bottom: -4
                        }
                    });
                }
                $(".horizontal-grid-wrap").scroll(function () {
                    var winScroll = $("#portfolio_horizontal_container").width() - $(".horizontal-grid-wrap").width();
                    var width = $(".horizontal-grid-wrap").scrollLeft();
                    var scrolled = ((width / winScroll) * 100);
                    $(".js-progress-bar").css("stroke-dashoffset", 100 - (scrolled));
                });
                $(".gallery-filters").on("click", "a", function (a) {
                    a.preventDefault();
                    $(".horizontal-grid-wrap").animate({
                        scrollLeft: 0
                    }, 500);
                    var b = $(this).attr("data-filter");
                    setTimeout(function () {
                        d.isotope({
                            filter: b
                        });
                    }, 600);
                    $(".gallery-filters a").removeClass("gallery-filter-active");
                    $(this).addClass("gallery-filter-active");
                    if ($(window).width() < 778) {
                        setTimeout(function () {
                            $(".horizontal-grid-container").animate({
                                scrollTop: 0
                            }, 500);
                        }, 1200);
                    }

                });
                d.isotope("on", "layoutComplete", function (a, b) {
                    var b = a.length,
                        numalb = $(".num-album");
                    numalb.html("0" + b).shuffleLetters({});
                });
                var j = $(".portfolio_item").length;
                $(".num-album_total , .num-album").html("0" + j);
            });
            $(".portfolio_item").each(function (i) {
                $(this).find(".pr_num").text("0" + ++i + ".");
            });
        }
        $(".horizontal-grid-wrap").on("scroll", function () {
            var winScroll = $("#portfolio_horizontal_container").width() - $(".horizontal-grid-wrap").width();
            var width = $(".horizontal-grid-wrap").scrollLeft();
            var scrolled = ((width / winScroll) * 100);
            $(".progress-bar").css({
                height: scrolled + "%"
            });
        });
    }
    inithorizontalPortfolio();
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
    $(window).on("scroll", function () {
        var a = $(document).height();
        var b = $(window).height();
        var c = $(this).scrollTop();
        var d = c / (a - b) * 100;

        $('.hero-section_bg .bg').css('transform', 'translate3d(0, ' + +(c * 0.25) + 'px, 0)');

    });
    //  Css------------------
    var $window = $(window);
    function csselem() {
        $(".height-emulator").css({
            height: $(".main-footer").outerHeight(true)
        });
        $(".fslider-fw-item").css({
            height: $(".slider-fw").outerHeight(true)
        });
        $(".ms-item_fs").css({
            height: $(".slideshow-container").outerHeight(true)
        });
    }
    csselem();
    $window.on("resize", function () {
        csselem();
    });
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
                el: '.init-hspag',
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
        var totalSlides2 = $(".slideshow-container_wrap .swiper-slide:not(.swiper-slide-duplicate)").length;
        $('.total_c').html("0" + totalSlides2);
        ms1.on('slideChange', function () {
            var csli2 = ms1.realIndex + 1,
                curnum2 = $('.current_c'),
                curnumanm2 = $('.hc_counter .current_c');
            curnum2.html("0" + csli2).shuffleLetters({});
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
            centeredSlides: false,
            slidesPerView: 3,
            spaceBetween: 40,
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
            centeredSlides: true,
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
    if ($(".clients-carousel").length > 0) {
        const ms1 = new Swiper(".clients-carousel .swiper-container", {
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: false,
            slidesPerView: 4,
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
    $('.fw-carousel .swiper-wrapper').addClass('no-horizontal-slider');
    if ($(".fw-carousel").length > 0) {
        if ($(window).width() >= 768 && j4 == undefined) {
            var mouseContr = $(".fw-carousel").data("mousecontrol");
            var j4 = new Swiper(".fw-carousel .swiper-container", {
                preloadImages: false,
                loop: true,
                freeMode: false,
                slidesPerView: 'auto',
                spaceBetween: 2,
                grabCursor: true,
                mousewheel: mouseContr,
                speed: 1400,
                centeredSlides: true,
                direction: "horizontal",
                pagination: {
                    el: '.hc-pag',
                    clickable: true,
                },
                effect: "slide",
                navigation: {
                    nextEl: '.carousel-btn_control-next',
                    prevEl: '.carousel-btn_control-prev',
                }
            });
            var totalSlides3 = $(".fw-carousel .swiper-slide:not(.swiper-slide-duplicate)").length;
            $('.total_c').html("0" + totalSlides3);
            j4.on('slideChange', function () {
                var csli3 = j4.realIndex + 1,
                    curnum3 = $('.current_c'),
                    curnumanm3 = $('.hc_counter .current_c');
                curnum3.html("0" + csli3).shuffleLetters({});
            });
        }
        if ($(window).width() < 768 && j4 !== undefined) {
            j4.destroy();
            j4 = undefined;
            $('.fw-carousel .swiper-wrapper').removeAttr('style').addClass('no-horizontal-slider');
            $('.swiper-slide').removeAttr('style');
        }
    }
    $(".photo-info-btn").on("click", function () {
        $(".show-info_act").toggleClass("vis-phot_det");
    });

    if ($(".slider-fw").length > 0) {
        $(".slider-fw.thumb-contr .swiper-slide .bg").each(function () {
            var ccasdc3 = $(this).attr("data-bg");
            $("<div class='thumb-img'><img src='" + ccasdc3 + "'></div>").appendTo(".thumbnail-wrap");
        });
        $(".thumb-img").on('click', function () {
            if ($(window).width() > 768) {
                j32.slideTo($(this).index(), 500);
                hideThumbnails();
            }
        });
        var j32 = new Swiper(".slider-fw .swiper-container", {
            preloadImages: false,
            loop: true,
            grabCursor: true,
            slidesPerView: 1,
            centeredSlides: true,
            speed: 1400,
            spaceBetween: 0,
            effect: "slide",
            mousewheel: false,
            parallax: true,
            pagination: {
                el: '.hc-pag',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            navigation: {
                nextEl: '.hs_btn_next',
                prevEl: '.hs_btn_prev',
            }
        });
        var totalSlides = $(".slider-fw  .swiper-slide:not(.swiper-slide-duplicate) .bg").length,
            ssnd = $('.slider-fw .swiper-container .swiper-wrapper .swiper-slide:not(.swiper-slide-duplicate)');
        $('.total').html('0' + totalSlides);
        var nxSlide = ssnd.eq(j32.realIndex).next();
        var pvSlide = ssnd.eq(j32.realIndex).prev();
        $('.hs_btn_next .hs_btn_wrap_preview .bg').css("background-image", "url(" + nxSlide.find('.bg').attr("data-bg") + ")");
        $('.hs_btn_prev .hs_btn_wrap_preview .bg').css("background-image", "url(" + pvSlide.find('.bg').attr("data-bg") + ")");
        j32.on('slideChange', function () {
            var csli = j32.realIndex + 1,
                curnum = $('.current');
            curnum.html('0' + csli);
            var nxSlide = ssnd.eq(j32.realIndex).next();
            var pvSlide = ssnd.eq(j32.realIndex).prev();
            $('.hs_btn_next .hs_btn_wrap_preview .bg').css("background-image", "url(" + nxSlide.find('.bg').attr("data-bg") + ")");
            $('.hs_btn_prev .hs_btn_wrap_preview .bg').css("background-image", "url(" + pvSlide.find('.bg').attr("data-bg") + ")");
        });
        j32.on("slideChangeTransitionStart", function () {
            $(".slide-progress").css({
                width: 0,
                transition: "width 0s"
            });
        });
        j32.on("slideChangeTransitionEnd", function () {

            $(".slide-progress").css({
                width: "100%",
                transition: "width 2000ms"
            });
        });
        var totalSlides2 = $(".slider-fw .swiper-slide:not(.swiper-slide-duplicate)").length;
        $('.total_c').html("0" + totalSlides2);
        j32.on('slideChange', function () {
            var csli2 = j32.realIndex + 1,
                curnum2 = $('.current_c'),
                curnumanm2 = $('.hc_counter .current_c');
            curnum2.html("0" + csli2).shuffleLetters({});
        });
    }
    if ($(".main-hero-carousel").length > 0) {
        var heroCarusel = new Swiper(".main-hero-carousel .swiper-container", {
            preloadImages: false,
            loop: true,
            centeredSlides: true,
            freeMode: false,
            slidesPerView: 3,
            spaceBetween: 0,
            grabCursor: true,
            mousewheel: false,
            effect: "coverflow",
            speed: 1400,
            init: true,
            autoplay: {
                delay:3500,
                disableOnInteraction: false
            },
            coverflowEffect: {
                rotate: 15,
                stretch: 1,
                depth: 150,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: '.hc-pag',
                clickable: true,
            },
            navigation: {
                nextEl: '.carousel-btn_control-next',
                prevEl: '.carousel-btn_control-prev',
            },
            breakpoints: {
                1268: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 1,
                    centeredSlides: false,
					effect: "slide",	
                },
            }
        });
        heroCarusel.on("slideChangeTransitionStart", function () {
            $(".slide-progress").css({
                width: 0,
                transition: "width 0s"
            });
        });
        heroCarusel.on("slideChangeTransitionEnd", function () {
            $(".slide-progress").css({
                width: "100%",
                transition: "width 2000ms"
            });
        });
        var totalSlides2 = $(".main-hero-carousel .swiper-slide:not(.swiper-slide-duplicate)").length;
        $('.total_c').html("0" + totalSlides2);
        heroCarusel.on('slideChange', function () {
            var csli2 = heroCarusel.realIndex + 1,
                curnum2 = $('.current_c'),
                curnumanm2 = $('.hc_counter .current_c');
            curnum2.html("0" + csli2).shuffleLetters({});
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
            parallax: false,
            speed: 1400,
            pagination: {
                el: '.cen-slider-pagination',
                clickable: true,
                dynamicBullets: false,
            },
            navigation: {
                nextEl: '.hcw-cont-next',
                prevEl: '.hcw-cont-prev',
            },
            breakpoints: {
                1258: {
                    slidesPerView: 2,
                },
                1068: {
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
            curnum2.html('0' + csli2).shuffleLetters({});
        });
    }
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
            if ($(window).width() < 1258) {
                $(".main-menu").removeClass("vismobmenu");
                $(".nav-button").removeClass("cmenu");
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
    $(".shuffleLetter , .header-social a , .share-container a , .footer-contacts a , .footer-social a , .main-social a , .commentform button , .custom-form button   , .box_gallery-filters a strong   , .shb_init span , .offer-box_btn , .half-carousel-content h3 a , .hc_controls_link a , .team-social li a  , .home_services_btn_wrap a   , .testi-link  , .order-wrap_btn , .column-filters-item a , .aside-social li a").on({
        mouseenter: function () {
            $(this).shuffleLetters({});
        }
    });
    $(".gallery-item , .portfolio_item").on({
        mouseenter: function () {
            $(this).find(".grid-det_link span").shuffleLetters({});
        }
    });
    $(".share-button-wrap").on({
        mouseenter: function () {
            $(this).find(".share-button_title").shuffleLetters({});
        }
    });
    $(".btn , .fixed-bar_item_btn , .strt_btn , .post-item_footer a , .subscribe-button  , .main-hero-carousel-item_link  ").on({
        mouseenter: function () {
            $(this).find("span").shuffleLetters({});
        }
    });
    setInterval(function () {
        $(".error-wrap h2").shuffleLetters({});
    }, 5000);


    $('.block_img_fs-let').rotaterator({
        fadeSpeed: 800,
        pauseSpeed: 1500
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
    //  Map init------------------	
    if ($("#map-single").length > 0) {
        var latlog = $('#map-single').data('latlog'),
            popupTextit = $('#map-single').data('popuptext'),
            map = L.map('map-single').setView(latlog, 10);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: ''
        }).addTo(map);
        var greenIcon = L.icon({
            iconUrl: 'images/marker.png',
            iconSize: [40, 40],
            popupAnchor: [0, -26]
        });
        L.marker(latlog, {
            icon: greenIcon
        }).addTo(map).bindPopup(popupTextit);
    }
    //   cursor ------------------
    $(".dark-section , .aside-column , .main-header , .main-footer  , .fs-holder , .gallery-item , .column-filters-wrap").on({
        mouseenter: function () {
            $(".element-item").addClass("white_blur");
        },
        mouseleave: function () {
            $(".element-item").removeClass("white_blur");
        }
    });
    $("a , .btn ,   textarea,   input  , .leaflet-control-zoom , .aside-show_cf , .close-contact_form , .closedet_style  , .nav-button , .swiper-pagination-bullet , .to-top-btn  , .gc-slider-cont , .hsc , .ss-slider-cont , .fw_scb , .hsc_pp2 , .hsc_pp , .hcw_btn , .cbc_btn , .cc-button , .tc-button , .tmc-button").on({
        mouseenter: function () {
            $(".element-item").addClass("elem_hover");
        },
        mouseleave: function () {
            $(".element-item").removeClass("elem_hover");
        }
    });
    $(".swiper-slide ,  #portfolio_horizontal_container").on({
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
    $(".nav-overlay , .det-overlay").on({
        mouseenter: function () {
            $(".element-item").addClass("close-icon");
        },
        mouseleave: function () {
            $(".element-item").removeClass("close-icon");
        }
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
    $.fn.duplicate = function (a, b) {
        var c = [];
        for (var d = 0; d < a; d++) $.merge(c, this.clone(b).get());
        return this.pushStack(c);
    };
    $("<span class='arrow_dec_dot'></span>").duplicate(15).appendTo(".arrow_dec");
}
//   load animation------------------
function contentAnimShow() {
    $('.main-header  nav  a').removeClass('act-link');
    var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
    $("a.ajax").each(function () {
        if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
            $(this).addClass("act-link");
    });
    $(".page-load , .menumasc").fadeIn(1);
    $(".page-load .pl-row-anim2").each(function (index, element) {
        var tl = new TimelineLite();
        tl.to(element, 0.6, {
            force3D: true,
            bottom: "0",
            ease: Expo.easeInOut
        }, index * 0.1)
    });
    $(".page-load .pl-row-anim").each(function (index, element) {
        var tl = new TimelineLite();
        tl.to(element, 0.8, {
            force3D: true,
            bottom: "0",
            ease: Expo.easeInOut,

        }, index * 0.1)
    });
    $(".pl-spinner").addClass("act-loader");
    setTimeout(function () {
        $("html, body").animate({
            scrollTop: 0
        }, {
            queue: true,
            duration: 10,
        });
    }, 1000);
    $(".element-item").addClass("loader_element");
    $(".share-btn").removeClass("uncl-share");
    if ($(window).width() < 1258) {
        $(".main-menu").removeClass("vismobmenu");
        $(".nav-button").removeClass("cmenu");
    }
}
function contentAnimHide() {
    var chdpt = $(".content-holder").data("pagetitle");
    $(".pl-spinner strong").text(chdpt).shuffleLetters({
        step: 5,
        fps: 20,
        callback: function () {
            setTimeout(function () {
                $(".pl-spinner").removeClass("act-loader");
            }, 300);
            setTimeout(function () {
                $(".page-load .pl-row-anim").each(function (index, element) {
                    var tl = new TimelineLite();
                    tl.to(element, 0.6, {
                        force3D: true,
                        top: "100%",
                        ease: Expo.easeInOut
                    }, index * 0.1)
                });
                $(".page-load .pl-row-anim2").each(function (index, element) {
                    var tl = new TimelineLite();
                    tl.to(element, 0.8, {
                        force3D: true,
                        top: "100%",
                        ease: Expo.easeInOut
                    }, index * 0.1)
                });
                setTimeout(function () {
                    $(".page-load , .menumasc").fadeOut(1);
                    TweenMax.to($(".page-load .pl-row-anim , .page-load .pl-row-anim2"), 0.0, {
                        force3D: true,
                        bottom: "100%",
                        top: "0"
                    });
                    $(".pl-spinner strong").text('')
                }, 1400);
            }, 800);
            $(".element-item").removeClass("loader_element");
        }
    });
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
// progressBar ------------------
var $window = $(window);
$window.on("scroll", function (a) {
    var a = $(document).height();
    var b = $(window).height();
    var c = $(window).scrollTop();
    var d = c / (a - b) * 100;
    $(".progress-bar").css({
        height: d + "%"
    });
});
//   load animation------------------
$(".nav-button").on("click", function () {
    $(".main-menu").toggleClass("vismobmenu");
    $(this).toggleClass("cmenu");
});
function mobMenuInit() {
    var ww = $(window).width();
    if (ww < 1258) {
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
var $window = $(window);
$window.on("resize", function () {
    mobMenuInit();
});
$('a.ajax').on('click', function () {
    $('nav li a').removeClass('act-link');
    $(this).addClass('act-link');
});
$.fn.duplicate = function (a, b) {
    var c = [];
    for (var d = 0; d < a; d++) $.merge(c, this.clone(b).get());
    return this.pushStack(c);
};
$("<div class='page-load'><span class='pl-spinner'><strong></strong></span></div>").appendTo("#main");
$("<div class='menumasc fs-wrapper'></div>").appendTo(".nav-holder");
$("<div class='pl-row'><span class='pl-row-anim'></span><span class='pl-row-anim2'></span></div>").duplicate(5).appendTo(".loader");
$("<div class='pl-row'><span class='pl-row-anim'></span><span class='pl-row-anim2'></span></div>").duplicate(5).appendTo(".page-load");
$('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">');
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
//   Init Ajax------------------
$(function () {
    $.coretemp({
        reloadbox: "#wrapper",
        outDuration: 1000,
        inDuration: 100
    });
    readyFunctions();
    $(document).on({
        ksctbCallback: function () {
            readyFunctions();
        }
    });
});
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
//   Init All Functions------------------
function readyFunctions() {
    initEcrait();
}