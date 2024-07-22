if (typeof jQuery === 'undefined') {
	throw new Error('BEL-CMS requires jQuery')
}
(function($) {
	"use strict";

	$(".section_gallery_title_img a").mouseover(function(){
		var img = $(this).attr('data');
		$(img).fadeIn();
	});
	
	$(".section_gallery_title_img a").mouseleave(function(){
		var img = $(this).attr('data');
		$(img).fadeOut();
	});

    console.log("Chargement JS Gallery BEL-CMS script Ok");
})(jQuery);