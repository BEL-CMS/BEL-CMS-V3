            $(".loader-wrap").delay(1000).fadeOut(200, function () {
                $("#main").animate({
                    opacity: "1"
                }, 500);
                var chdpt = $(".content").data("pagetitle");
                $(".header-page_title span").text(chdpt).shuffleLetters({});
            });        
var a = $(".bg");
a.each(function () {
    if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
});  
if ($(".counter-widget").length > 0) {
	var countCurrent = $(".counter-widget").attr("data-countDate");
	$(".countdown").downCount({
		date: countCurrent ,
		offset: 0
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
            $(".cs-canvas").addClass("canvas_anim")	
        });
        ms1.on("slideChangeTransitionEnd", function () {
           $(".cs-canvas").removeClass("canvas_anim")	
        });						
    }
    $(".hero_social a ").on({
        mouseenter: function () {
            $(this).shuffleLetters({});
        }
 });	
$('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">');
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
 