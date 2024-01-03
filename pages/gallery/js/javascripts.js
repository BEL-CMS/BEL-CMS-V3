if (typeof jQuery === 'undefined') {
	throw new Error('BEL-CMS requires jQuery')
}
(function($) {
	"use strict";

    $("#jQuery_cat").on( "change", function() {
        var id = $(this).val();
        if (id != 0) {
            var url = "Gallery/Category/" + id;
            $(location).attr('href', url);
        } else {
            var url = "Gallery";
            $(location).attr('href', url);
        }
        $(location).attr('href', url);
    });

    console.log("Chargement JS Gallery BEL-CMS script Ok");
})(jQuery);