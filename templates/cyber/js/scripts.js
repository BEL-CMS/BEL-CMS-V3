function initCyberbook() {
    "use strict";
    //   loader ------------------
    firstLoad();
    function firstLoad() {
        TweenMax.to($(".loading-spinner img"), 1.0, {
            force3D: true,
            scale: "0.9",
            opacity: 0,

            ease: Expo.easeInOut,
            delay: 0.5,
            onComplete: function () {
                $(".main-loader-wrap").fadeOut(100, function () {
                    $("#main").animate({
                        opacity: "1"
                    }, 1200);

                });
            }
        });
    }
    //   duplicate ------------------	
    $.fn.duplicate = function (a, b) {
        const c = [];
        for (var d = 0; d < a; d++) $.merge(c, this.clone(b).get());
        return this.pushStack(c);
    };
    $("<span class='pr-button-dot'></span>").duplicate(4).appendTo(".pr_btn_dots");
    $("<div class='container full-height'></div>").appendTo(".sec-lines");
    $("<div class='line-item'></div>").duplicate(5).appendTo(".sec-lines .container");
    $("<span class='arrow_dec_dot'></span>").duplicate(9).appendTo(".arrow_dec");
    $("<span class='overlay-dec-dot'></span>").duplicate(9).appendTo(".overlay-dec");
    $("<span class='hsd_dec-dot'><i class='fas fa-caret-up'></i></span>").duplicate(3).appendTo(".hdec_d");
    $("<span class='h_a-dot'><i class='fas fa-caret-right'></i></span>").duplicate(4).appendTo(".hero-arrows_dec");

    //   Background image ------------------
    const a = $(".bg");
    a.each(function (a) {
        if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
    });
    const totsec = $(".scroll_sec").length;
    $(".section-counter_total").text("0" + totsec);
    //   menu ------------------		
    $("#menu").menu();
    $(".sliding-menu li a.nav").parent("li").addClass("submen-dec");
    $(".nav-container").on({
        mouseenter: function () {
            $(".nav_arrow span").removeClass("df_close");
        },
        mouseleave: function () {
            $(".nav_arrow span").addClass("df_close");
        }
    });
    const navover = $(".nav-overlay"),
        navholder = $(".nav-holder"),
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
    //  list ------------------	
    $(".list-item_link").on("click", function () {
        $(this).parents(".list-item").find(".list-item_content").slideToggle(500);
        $(this).toggleClass("actdetlink");
        const cbc = $(".piechart-holder").attr("data-skcolor");
        $(this).parents(".list-item").find(".chart").easyPieChart({
            barColor: cbc,
            trackColor: "#000",
            scaleColor: "#000",
            size: "180",
            lineWidth: "12",
            lineCap: "square",
            animate: 3500,
            onStep: function (value) {
                this.$el.parents(".piechart-item").find('.percentage').text(~~value + 1);
            }
        });
    });
    $('.list-item').on('mouseover', function () {
        const hidworit_index_each = $(this).data("bgsrc");
        $(this).find(".reval-image .bg").css("background-image", "url(" + hidworit_index_each + ")");
    });
    //   Isotope------------------
    function nc() {
        if ($(".gallery-items").length) {
            const $grid = $(".gallery-items").isotope({
                singleMode: true,
                columnWidth: ".grid-sizer, .grid-sizer-second, .grid-sizer-three",
                itemSelector: ".gallery-item",
                transformsEnabled: false,
                transitionDuration: "700ms",
            });
            $grid.imagesLoaded(function () {
                $grid.isotope("layout");
            });
            const b = $(".gallery-item").length;
            $(".all-album , .num-album_total").html(b);
            $(".gallery-filters").on("click", "a.gallery-filter", function (b) {
                if ($(window).width() < 1068) {
                    $(".hid-filter").fadeOut(500);
                }
                b.preventDefault();
                $(".folio-mask").fadeIn(1);
                const c = $(this).attr("data-filter"),
                    d = $(this).find("strong").text();
                TweenMax.to($(".folio-category_item"), 0.5, {
                    force3D: true,
                    y: -10,
                    opacity: 0,
                    ease: Power2.easeOut,
                    onComplete: function () {
                        $(".folio-category_item").text(d);
                        TweenMax.to($(".folio-category_item"), 0.1, {
                            force3D: true,
                            y: 10
                        });
                    }
                });
                TweenMax.to($(".num-album"), 0.5, {
                    force3D: true,
                    y: 10,
                    opacity: 0,
                    ease: Power2.easeOut,
                    onComplete: function () {
                        TweenMax.to($(".num-album"), 0.1, {
                            force3D: true,
                            y: -10
                        });
                    }
                });
                if ($(".gallery-items").hasClass('sf_true')) {
                    TweenMax.to(portfolio, 1.0, {
                        scrollTop: 0,
                        force3D: true
                    });
                    TweenMax.to(portfolio, 1.0, {
                        scrollLeft: 0,
                        force3D: true
                    });
                    setTimeout(function () {
                        $grid.isotope({
                            filter: c
                        });
                    }, 1200);
                } else if ($(".gallery-items").hasClass('sctt_true')) {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 800);
                    setTimeout(function () {
                        $grid.isotope({
                            filter: c
                        });
                    }, 1200);
                } else {
                    $grid.isotope({
                        filter: c
                    });
                }
                $(".gallery-filters a").removeClass("gallery-filter-active");
                $(this).addClass("gallery-filter-active");
            });
        }
        $(".gallery-items").isotope("on", "layoutComplete", function (a, b) {
            $(".folio-mask").fadeOut(1);
            var b = a.length;
            $(".num-album").html(b);
            TweenMax.to($(".folio-category_item"), 0.5, {
                force3D: true,
                y: 0,
                opacity: 1,
                ease: Power2.easeOut
            });
            TweenMax.to($(".num-album"), 0.5, {
                force3D: true,
                y: 0,
                opacity: 1,
                ease: Power2.easeOut
            });
        });
        const portfolio = $('.hero-showcase'),
            wrapScreenHeight = portfolio.height(),
            wrapHeight = portfolio.height(),
            listHeight = portfolio.find('.gallery-items').height(),
            wrapScreenwidht = portfolio.width(),
            wrapwidth = portfolio.width(),
            listwidth = portfolio.find('.gallery-items').width();
        portfolio.on('mousemove', function (e) {
            const dP = ((e.pageY / wrapHeight));
            const dP2 = ((e.pageX / wrapwidth));
            TweenMax.to(portfolio, 2.9, {
                scrollTop: ((listHeight * dP) - wrapScreenHeight / 2),
                force3D: true,
            });
            TweenMax.to(portfolio, 2.9, {
                scrollLeft: ((listwidth * dP2) - wrapScreenwidht / 2),
                force3D: true,
            });
        });
    }
    nc();
    function postGrid() {
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
    postGrid();
    function hoverdirInit() {
        $(" .init_hoverdir .gallery-item").each(function () {
            $(this).hoverdir();
        });
    }
    hoverdirInit();
    function csselem() {
        $(".fs-slider-item ").css({
            height: $(".fs-slider").outerHeight(true)
        });
        $(".height-emulator").css({
            height: $(".main-footer").outerHeight(true)
        });
    }
    $(window).on("resize", function () {
        csselem();
    });
    csselem();
    //   sliders ------------------
    if ($(".fs-slider").length > 0) {
        const mouseContr2 = $(".fs-slider").data("mousecontrol2");
        const j3 = new Swiper(".fs-slider .swiper-container", {
            preloadImages: false,
            loop: true,
            grabCursor: true,
            speed: 1800,
            spaceBetween: 0,
            effect: "slide",
            mousewheel: mouseContr2,
            parallax: true,
            pagination: {
                el: '.hero-slider-wrap_pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.hsc-next',
                prevEl: '.hsc-prev',
            },
            autoplay: {
                delay: 3500,
                disableOnInteraction: false
            },
            on: {
                init: function () {
                    const fsslideract = $(".fs-slider .swiper-slide-active").data("fsslideropt1"),
                        fsslideract2 = $(".fs-slider .swiper-slide-active").data("fsslideropt2"),
                        fsslideract3 = $(".fs-slider .swiper-slide-active").data("fsslideropt3"),
                        fsslideurl = $(".fs-slider .swiper-slide-active").data("fssurl");
                    $(".opt-one").html(fsslideract);
                    $(".opt-two").html(fsslideract2);
                    $(".opt-three").html(fsslideract3);
                    $(".hero-slider_details_url").attr("href", fsslideurl);
                },
            }
        });
        j3.on("slideChangeTransitionStart", function () {
            sliderDetailsChangeStart();
            $(".slide-progress").css({
                width: 0,
                transition: "width 0s"
            });
        });
        j3.on("slideChangeTransitionEnd", function () {
            sliderDetailsChangeEnd();

            $(".slide-progress").css({
                width: "100%",
                transition: "width 2000ms"
            });
        });
        const autobtn = $(".play-pause_slider");
        function autoEnd() {
            autobtn.removeClass("auto_actslider");
            j3.autoplay.stop();
        }
        function autoStart() {
            autobtn.addClass("auto_actslider");
            j3.autoplay.start();
        }
        autobtn.on("click", function () {
            if (autobtn.hasClass("auto_actslider")) autoEnd();
            else autoStart();
            return false;
        });
        j3.on('slideChange', function () {
            const csli = j3.realIndex + 1,
                curnum = $('.current_s');
            TweenMax.to(curnum, 0.2, {
                force3D: true,
                y: -10,
                opacity: 0,
                ease: Power2.easeOut,
                onComplete: function () {
                    TweenMax.to(curnum, 0.1, {
                        force3D: true,
                        y: 10
                    });
                    curnum.html("0" + csli);
                }
            });
            TweenMax.to(curnum, 0.2, {
                force3D: true,
                y: 0,
                delay: 0.3,
                opacity: 1,
                ease: Power2.easeOut
            });
        });
        const totalSlides = j3.slides.length - 2;
        $('.total_s').html("0" + totalSlides);
    }
    const sliderDetailsItem = $(".hero-slider_details li");
    function sliderDetailsChangeStart() {
        TweenMax.to(sliderDetailsItem, 0.8, {
            force3D: true,
            x: "-30px",
            opacity: "0",
            ease: Power2.easeOut,
            onComplete: function () {
                TweenMax.to(sliderDetailsItem, 0.1, {
                    force3D: true,
                    x: "30px",
                    ease: Power2.easeOut,

                });
                const fsslideract = $(".fs-slider .swiper-slide-active").data("fsslideropt1"),
                    fsslideract2 = $(".fs-slider .swiper-slide-active").data("fsslideropt2"),
                    fsslideract3 = $(".fs-slider .swiper-slide-active").data("fsslideropt3"),
                    fsslideurl = $(".fs-slider .swiper-slide-active").data("fssurl");
                $(".opt-one").html(fsslideract);
                $(".opt-two").html(fsslideract2);
                $(".opt-three").html(fsslideract3);
                $(".hero-slider_details_url").attr("href", fsslideurl);
            }
        });
    }
    function sliderDetailsChangeEnd() {
        sliderDetailsItem.each(function (ace) {
            const bp2 = $(this);
            setTimeout(function () {
                TweenMax.to(bp2, 0.6, {
                    force3D: true,
                    x: "0",
                    opacity: "1",
                    ease: Power2.easeOut
                });
            }, 110 * ace);
        });
    }
    if ($(".half-carousel").length > 0) {
        const hc = new Swiper(".half-carousel .swiper-container", {
            preloadImages: true,
            loop: true,
            centeredSlides: true,
            freeMode: false,
            slidesPerView: 2,
            spaceBetween: 10,
            grabCursor: true,
            mousewheel: false,
            parallax: true,
            speed: 1400,
            navigation: {
                nextEl: '.hcw-cont-next',
                prevEl: '.hcw-cont-prev',
            },
            pagination: {
                el: '.cen-slider-pagination',
                clickable: true,
            },
 
            breakpoints: {
 
                768: {
                    slidesPerView: 1,
                },

            }
        });
    }
    if ($(".testimonilas-carousel").length > 0) {
        const ms1 = new Swiper(".testimonilas-carousel .swiper-container", {
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: true,
            slidesPerView: 3,
            spaceBetween: 0,
            speed: 1400,
            pagination: {
                el: '.tc-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.tc-button-next',
                prevEl: '.tc-button-prev',
            },
            breakpoints: {
                1920: {
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
    if ($(".clients-carousel").length > 0) {
        const ms1 = new Swiper(".clients-carousel .swiper-container", {
            loop: true,
            grabCursor: true,
            autoHeight: false,
            centeredSlides: false,
            slidesPerView: 4,
            spaceBetween: 0,
            speed: 1400,
            mousewheel: false,
            navigation: {
                nextEl: '.serv-carousel-next',
                prevEl: '.serv-carousel-prev',
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
    if ($(".single-slider").length > 0) {
        const j2 = new Swiper(".single-slider .swiper-container", {
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
    if ($(".center-carousel").length > 0) {
        const j5 = new Swiper(".center-carousel .swiper-container", {
            preloadImages: true,
            slidesPerView: 'auto',
            spaceBetween: 10,
            loop: true,
            grabCursor: true,
            mousewheel: false,
            centeredSlides: true,
            autoHeight: false,
            pagination: {
                el: '.cen-slider-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.ccsw-next',

                prevEl: '.ccsw-prev',
            },
            on: {
                init: function () {
                    const ccslideract = $(".center-carousel .swiper-slide-active .center-carousel_item").data("imagedetails");
                    $(".img_details_title span").html(ccslideract);

                },
            }
        });
        const itc = $(".img_details_title span");
        j5.on("slideChangeTransitionStart", function () {
            TweenMax.to(itc, 0.8, {
                force3D: true,
                y: "10px",
                opacity: "0",
                ease: Power2.easeOut,
                onComplete: function () {
                    TweenMax.to(itc, 0.1, {
                        force3D: true,
                        y: "-10px",
                        ease: Power2.easeOut,

                    });

                }
            });
        });
        j5.on("slideChangeTransitionEnd", function () {
            TweenMax.to(itc, 0.8, {
                force3D: true,
                delay: 0.4,
                y: "0",
                opacity: "1",
                ease: Power2.easeOut,

            });
            setTimeout(function () {
                const ccslideract = $(".center-carousel .swiper-slide.swiper-slide-active .center-carousel_item").data("imagedetails");
                itc.html(ccslideract);
            }, 400);
        });
        const totalSlides = $(".center-carousel .swiper-slide:not(.swiper-slide-duplicate) img").length;
        $('.total').html('0' + totalSlides);
        j5.on('slideChange', function () {
            const csli = j5.realIndex + 1,
                curnum = $('.current'),
                curnumanm = $('.hs_counter .current');
            TweenMax.to(curnumanm, 0.2, {
                force3D: true,
                y: -10,
                opacity: 0,
                ease: Power2.easeOut,
                onComplete: function () {
                    TweenMax.to(curnumanm, 0.1, {
                        force3D: true,
                        y: 10
                    });
                    curnum.html('0' + csli);
                }
            });
            TweenMax.to(curnumanm, 0.2, {
                force3D: true,
                y: 0,
                delay: 0.3,
                opacity: 1,
                ease: Power2.easeOut
            });
        });
    }
    if ($(".hero-carousel ").length > 0) {
        const totalSlides3 = $(".hero-carousel .swiper-slide").length;
        const heroCarusel = new Swiper(".hero-carousel .swiper-container", {
            preloadImages: false,
            loop: true,
            centeredSlides: true,
            freeMode: false,
            slidesPerView: 3,
            spaceBetween: 6,
            grabCursor: true,
            mousewheel: false,
            parallax: true,
            speed: 1400,
            effect: "slide",
            init: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            pagination: {
                el: '.hero-carousel_pagination',
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
        const autobtn = $(".play-pause_slider");
        function autoEnd() {
            autobtn.removeClass("auto_actslider");
            heroCarusel.autoplay.stop();
        }
        function autoStart() {
            autobtn.addClass("auto_actslider");
            heroCarusel.autoplay.start();
        }
        autobtn.on("click", function () {
            if (autobtn.hasClass("auto_actslider")) autoEnd();
            else autoStart();
            return false;
        });
        heroCarusel.on('slideChange', function () {
            const csli2 = heroCarusel.realIndex + 1,
                curnum2 = $('.current_s');
            TweenMax.to(curnum2, 0.2, {
                force3D: true,
                y: -10,
                opacity: 0,
                ease: Power2.easeOut,
                onComplete: function () {
                    TweenMax.to(curnum2, 0.1, {
                        force3D: true,
                        y: 10
                    });
                    curnum2.html("0" + csli2);
                }
            });
            TweenMax.to(curnum2, 0.2, {
                force3D: true,
                y: 0,
                delay: 0.3,
                opacity: 1,
                ease: Power2.easeOut
            });
        });
        const totalSlides2 = $(".hero-carousel .swiper-slide:not(.swiper-slide-duplicate) .bg").length;
        $('.total_s').html('0' + totalSlides2);
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
                el: '.hero-carousel_pagination',
                clickable: true,
            },
        });
        ms1.on('slideChange', function () {
            const csli3 = ms1.realIndex + 1,
                curnum3 = $('.current_s');
            TweenMax.to(curnum3, 0.2, {
                force3D: true,
                y: -10,
                opacity: 0,
                ease: Power2.easeOut,
                onComplete: function () {
                    TweenMax.to(curnum3, 0.1, {
                        force3D: true,
                        y: 10
                    });
                    curnum3.html("0" + csli3);
                }
            });
            TweenMax.to(curnum3, 0.2, {
                force3D: true,
                y: 0,
                delay: 0.3,
                opacity: 1,
                ease: Power2.easeOut
            });
        });
        const totalSlides3 = $(".slideshow-container_wrap .swiper-slide:not(.swiper-slide-duplicate) .bg").length;
        $('.total_s').html('0' + totalSlides3);
    }
    if ($(".multi-slideshow_1").length > 0) {
        const ms34 = new Swiper(".multi-slideshow_1 .swiper-container", {
            preloadImages: false,
            loop: true,
            speed: 1400,
            spaceBetween: 0,
            effect: "slide",
            direction: "vertical",
            parallax: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false
            },
            pagination: {
                el: '.hero-carousel_pagination',
                clickable: true,
            },
        });
        const ms44 = new Swiper(".multi-slideshow_2 .swiper-container", {
            preloadImages: false,
            loop: true,
            speed: 1400,
            spaceBetween: 0,
            parallax: true,
            effect: "slide",
        });
        ms44.controller.control = ms34;
        ms34.controller.control = ms44;
        ms34.on('slideChange', function () {
            const csli5 = ms34.realIndex + 1,
                curnum5 = $('.current_s');
            TweenMax.to(curnum5, 0.2, {
                force3D: true,
                y: -10,
                opacity: 0,
                ease: Power2.easeOut,
                onComplete: function () {
                    TweenMax.to(curnum5, 0.1, {
                        force3D: true,
                        y: 10
                    });
                    curnum5.html("0" + csli5);
                }
            });
            TweenMax.to(curnum5, 0.2, {
                force3D: true,
                y: 0,
                delay: 0.3,
                opacity: 1,
                ease: Power2.easeOut
            });
        });
        const totalSlides5 = $(".multi-slideshow_1 .swiper-slide:not(.swiper-slide-duplicate) .bg").length;
        $('.total_s').html('0' + totalSlides5);
    }
    var lsct2 = 0;
    $(window).on("scroll", function () {
        var wst = $(this).scrollTop();
        if (wst < lsct2) {
            $(".dir-arrow").addClass("dird");
        } else {
            $(".dir-arrow").removeClass("dird");
        }
        lsct2 = wst;
    });
    //   appear------------------
    $(".stats").appear(function () {
        $(".num").countTo();
    });
    //   skills ------------------	
    $(".skillbar-box").appear(function () {
        $(this).find("div.skillbar-bg").each(function () {
            $(this).find(".custom-skillbar").delay(600).animate({
                width: $(this).attr("data-percent")
            }, 1500);
        });
    });
    //   accordion ------------------
    $(".accordion a.toggle").on("click", function (a) {
        a.preventDefault();
        $(".accordion a.toggle").removeClass("act-accordion");
        $(this).addClass("act-accordion");
        if ($(this).next('div.accordion-inner').is(':visible')) {
            $(this).next('div.accordion-inner').slideUp();
        } else {
            $(".accordion a.toggle").next('div.accordion-inner').slideUp();
            $(this).next('div.accordion-inner').slideToggle();
        }
    });
    //   lightGallery------------------
    $(".image-popup , .single-popup-image").lightGallery({
        selector: "this",
        cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
        download: false,
        counter: false
    });
    const o = $(".lightgallery"),
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
    const vid_src = $(".popup_video").data("videolink");
    $(".lg-video-object").find("source").attr("src", vid_src);
    //   buttons ------------------		
    $(".filter-button").on("click  ", function () {
        $(".hid-filter").fadeToggle(500);
    });
    $(".blog-btn").on("click", function () {
        $(".blog-filter-wrap").fadeToggle(500);
    });
    $(".gallery-filters a").on("click", function () {
        if ($(window).width() < 768) {
            $(".hid-filter").delay(1000).slideUp(300);
        }
    });
    $(".mob-filter_btn").on("click  ", function () {
        $(".gfm").slideToggle(500);
    });
    const textTitle = $(".hero-title h2").text();
    $(".dec-title span").text(textTitle);
    $(".content-nav li a ").on({
        mouseenter: function () {
            const textAnim = $(this).find("strong").text();
            $(".dec-title span").text(textAnim);
        },
        mouseleave: function () {
            $(".dec-title span").text(textTitle);
        }
    });
    const sh_wrap = $(".share-wrapper"),
        sh_cont = $(".share-container"),
        sh_over = $(".share-overlay"),
        ssbtn = $(".show_share"),
        clsh = $(".cl_sh");
    // Share   ------------------
    sh_cont.share({
        networks: ['facebook', 'pinterest', 'twitter', 'linkedin']
    });
    function showShare() {
        sh_wrap.removeClass("isShare").fadeIn(1);
        sh_over.fadeIn(300);
        setTimeout(function () {
            sh_cont.addClass("visshcon");
        }, 500);
    }
    function hideShare() {
        sh_cont.removeClass("visshcon");
        sh_over.delay(300).fadeOut(500);
        setTimeout(function () {
            sh_wrap.addClass("isShare").fadeOut(1);
        }, 500);
    }
    ssbtn.on("click", function () {
        if (sh_wrap.hasClass("isShare")) showShare();
        else hideShare();
    });
    clsh.on("click", function () {
        hideShare();
    });
    //   scrollToFixed ------------------	
    $(".scroll-fixed-column-content").scrollToFixed({
        zIndex: 112,
        bottom: 0,
        removeOffsets: true,
        limit: function () {
            const a = $(".limit-box").offset().top - $(".scroll-fixed-column-content").outerHeight(true);
            return a;
        }
    });
    $(".init-fix-column").scrollToFixed({
        minWidth: 1064,
        zIndex: 12,
        marginTop: 120,
        removeOffsets: true,
        limit: function () {
            const a = $(".limit-box").offset().top - $(".init-fix-column").outerHeight(true);
            return a;
        }
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
    //   scroll to------------------
    $(".custom-scroll-link").on("click", function () {
        const a = 70;
        if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") || location.hostname == this.hostname) {
            const b = $(this.hash);
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
    $(".page-scroll-nav_wrap ").singlePageNav({
        filter: ":not(.external)",
        updateHash: false,
        offset: 110,
        threshold: 120,
        speed: 1200,
        currentClass: "act-sec"
    });
    $(".hidden_wrap_btn").on("click", function () {
        $(".page-scroll-nav_wrap").fadeToggle(500);
    });
    const $window = $(window);
    $window.on("scroll", function (a) {
        var a = $(document).height(),
            b = $(window).height(),
            c = $(this).scrollTop(),
            d = c / (a - b) * 100;
        $('.fixed-column-image .hor_scroll').css('transform', 'translateX( ' + (d * 1) + 'px)');
        if (c + b > a - 100) {
            $(".scroll-nav-container").addClass("hidesnc");
        } else {

            $(".scroll-nav-container").removeClass("hidesnc");
        }
        $(".ver_progress-bar").css({
            height: d + "%"
        });
    });
    $(".page-scroll-nav_wrap a").on("click", function () {
        if ($(window).width() < 1064) {
            $(".page-scroll-nav_wrap").delay(1300).fadeOut(500);
        }
    });
    //   Contact form------------------
    const coninw = $(".contact-form-content"),
        coninbtn = $(".contact-form-btn");
    function showConInfo() {
        $(".contact-form-wrap").fadeIn(100);
        coninw.addClass("vis-coninfwrap");
        coninbtn.removeClass("isconin-btn_vis");
    }
    function hideConInfo() {
        coninw.removeClass("vis-coninfwrap");
        coninbtn.addClass("isconin-btn_vis");
        $(".contact-form-wrap").fadeOut(100);
    }
    coninbtn.on("click", function () {
        if ($(this).hasClass("isconin-btn_vis")) showConInfo();
        else hideConInfo();
    });
    $(".act-cf").on("click", function () {
        showConInfo();
    });
    $(".close-cf , .contact-form-overlay").on("click", function (e) {
        e.preventDefault();
        hideConInfo();
        $("#message").slideUp(200);
        $(".custom-form").find("input[type=text], textarea").val("");
    });
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
    $('.out_label').on('focusin', function () {
        $(this).parents(".input-holder").find('label').addClass('active_lab');
    });
    $('.out_label').on('focusout', function () {
        if (!this.value) {
            $(this).parents(".input-holder").find('label').removeClass('active_lab');
        }
    });
    //   heroAnim ------------------		
    function heroAnim() {
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
        const b = $(".overlay-dec-dot");
        $(a(b).slice(0, $(".overlay-dec").data("ran"))).each(function (a) {
            const bc = $(this);
            b.removeClass("overlay-dec-vis")
            bc.addClass("overlay-dec-vis");

        });
    }
    setInterval(function () {
        heroAnim();
    }, 2000);
    // folio hover------------------
    const hidworit = $('.projects-list_item'),
        hidworit_length = hidworit.length;
    $("<div class='bg'></div>").duplicate(hidworit_length).appendTo(".bg-list");
    const hidworit_actin = $('.projects-list .projects-list_item.act-index'),
        actbgindex = hidworit_actin.data("bgscr");
    hidworit_actin.addClass("act-index");
    $('.bg-list .bg:first-child').addClass('active').css("background-image", "url(" + actbgindex + ")");
    hidworit_actin.find(".bg-reval .bg").css("background-image", "url(" + actbgindex + ")");
    $('.projects-list_item').on('mouseover', function () {
        $('.projects-list_item').removeClass("act-index");
        $(this).addClass("act-index");
        const hidworit_index = $('.projects-list_item').index(this),
            hidworit_index_each = $(this).data("bgscr");
        $('.bg-list .bg').removeClass('active').eq(hidworit_index).addClass('active').css("background-image", "url(" + hidworit_index_each + ")");
        $(this).find(".bg-reval .bg").css("background-image", "url(" + hidworit_index_each + ")");
    });
    $('.projects-list_item h3 a').on({
        mouseenter: function () {
            const menuItemWidth = $(this).width();
            const listItemWidth = $(this).parent().width();
            if (menuItemWidth > listItemWidth) {
                const scrollDistance = menuItemWidth - listItemWidth;
                const listItem = $(this).parent();
                listItem.stop();
                listItem.animate({
                    scrollLeft: scrollDistance
                }, 1000, 'linear');
            }
        },
        mouseleave: function () {
            var listItem = $(this).parent();
            listItem.stop();
            listItem.animate({
                scrollLeft: 0
            }, 'medium', 'swing');
        }
    });


    //  cursor  ------------------
    $("a , .btn ,   textarea,   input  , .leaflet-control-zoom , .share_btn , .close-contact_form , .hc-single_btn  , .nav-button, .swiper-pagination-bullets , .to-top-btn  , .gc-slider-cont  , .hp_popup , button  , .fw_cb , .promo-video-btn , .fsc , .hsc , .play-pause_slider , .act-cf , .blog-btn , .ss-slider-cont , .shop-opt_btn , .nice-select , .irs  , .add_cart , .pr-remove , .cbc_btn").on({
        mouseenter: function () {
            $(".element-item").addClass("elem_hover");
        },
        mouseleave: function () {
            $(".element-item").removeClass("elem_hover");
        }
    });
    $(".swiper-slide").on({
        mouseenter: function () {
            $(".element-item").addClass("slider_hover");
        },
        mouseleave: function () {
            $(".element-item").removeClass("slider_hover");
        }
    });
    $(".swiper-slide a.box-media-zoom , .hero-carousel_project-title , .fs-slider_align_title h2 a , .hero-btn ").on({
        mouseenter: function () {
            $(".element-item").removeClass("slider_hover");
        },
        mouseleave: function () {
            $(".element-item").addClass("slider_hover");
        }
    });
    $(".share-overlay , .nav-overlay , .contact-form-overlay").on({
        mouseenter: function () {
            $(".element-item").addClass("close-icon");
        },
        mouseleave: function () {
            $(".element-item").removeClass("close-icon");
        }
    });
    $(".color-bg , .hero-slider-controls-top , .column-footer").on({
        mouseenter: function () {
            $(".element-item").addClass("dark_elem");
        },
        mouseleave: function () {
            $(".element-item").removeClass("dark_elem");
        }
    });
    $(".hero-showcase").on({
        mouseenter: function () {
            $(".element-item").addClass("showcase_elem");
        },
        mouseleave: function () {
            $(".element-item").removeClass("showcase_elem");
        }
    });	
    $(".hero-showcase a").on({
        mouseenter: function () {
            $(".element-item").removeClass("showcase_elem");
        },
        mouseleave: function () {
            $(".element-item").addClass("showcase_elem");
        }
    });		
	
}
if ($(".element-item").length > 0) {
    const mouse = {
        x: 0,
        y: 0
    };
    const pos = {
        x: 0,
        y: 0
    };
    const ratio = 0.15;
    const active = false;
    const ball = document.querySelector('.element-item');
    TweenLite.set(ball, {
        xPercent: -50,
        yPercent: -50
    });
    document.addEventListener("mousemove", mouseMove);
    function mouseMove(e) {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
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
$('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">');
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
//   Init All Functions------------------
$(document).ready(function () {
    initCyberbook();
});