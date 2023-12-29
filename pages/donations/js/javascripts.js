if (typeof jQuery === 'undefined') {
	throw new Error('BEL-CMS requires jQuery')
}
(function($) {
	"use strict";
    $('#donation_ul button').on( "click", function(event) {
        event.preventDefault();
        var value = $(this).data('value');
        $('#donation_ul button').each(function() {
             $(this).removeClass('active');
        });
        $(this).addClass('active');
        $('#number_donate').val(value);
    });
    console.log("Chargement du script Donation Ok");
})(jQuery);