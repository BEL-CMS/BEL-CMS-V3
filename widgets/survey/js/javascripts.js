(function($) {
	"use strict";

    if ($('.jquery_vote').height()) {

        $('.jquery_vote').click(function(event) {
		    event.preventDefault();

            if ($('#alrt_bel_cms').height()) {
                $('#alrt_bel_cms').remove();
            }

            var id = $(this).attr("data-id");

            $.ajax({
                url: "survey/sendvote?ajax=" + id,
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function() {
                    $('body').append('<div id="alrt_bel_cms">Le vote a été pris en compte</div>');
                },
                success: function(data) {
                    
                }
            });

	    });
    }
})(jQuery);