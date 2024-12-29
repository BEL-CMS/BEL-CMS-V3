(function($) {
	"use strict";
    $("#submit_sepa").submit(function(e) {
		e.preventDefault();
		if ($('#alrt_bel_cms').height()) {
			$('#alrt_bel_cms').remove();
		}

        alert('ok');

		$.ajax({
			url: "pricing/valid_sepa",
	  		type: "POST",
	  		data:  new FormData(this),
	 		contentType: false,
			cache: false,
	  		processData:false,
	  		beforeSend : function() {
				$('body').append('<div id="alrt_bel_cms">Chargement...</div>');
	 		}
		});
	});
})(jQuery);