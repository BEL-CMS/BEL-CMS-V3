if (typeof jQuery === 'undefined') {
	throw new Error('BEL-CMS requires jQuery')
}
(function($) {
	"use strict";

    /*
    $('.section_downloads_cat_button').on( "click", function(event) {
        event.preventDefault();
        var DataURL = $(this).data('url');
        $('#section_download_jquery').slideUp();
        $.ajax({
            url: DataURL,
            dataType: 'html',
            success : function(html) {
                $('#section_downloads_cat_jquery').after(html);
            },
            beforeSend: function() {
            }
        });
    });
    */

    console.log("Chargement du script Dowloads Ok");
})(jQuery);