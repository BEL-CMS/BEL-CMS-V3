(function($) {
	"use strict";
	$(document).on('submit', "#belcms_shoutbox_form", function(e) {
		e.preventDefault();
		if ($('#alrt_bel_cms').height()) {
			$('#alrt_bel_cms').remove();
		}

		$.ajax({
			url: "shoutbox/send?ajax",
	  		type: "POST",
	  		data:  new FormData(this),
	 		contentType: false,
			cache: false,
	  		processData:false,
	  		beforeSend : function() {
				$('body').append('<div id="alrt_bel_cms">Chargement...</div>');
	 		},
	  		success: function(data) {
				$('#belcms_shoutbox_input').val('');
				$('#belcms_shoutbox_main li:first').attr('id', number);
				getLastshoutbox();
	 		}
		});
	});
})(jQuery);

function getLastshoutboxSend(time) {
	if ($('#belcms_shoutbox_main').height()) {
		setTimeout( function(){
			var id = $('#belcms_shoutbox_main li:first').attr('id');
			if (id === undefined) {
				id = 0;
			} else {
				id = id.replace('id_', '');
			}
			id++;
			$.ajax({
				url : "shoutbox/html?echo&id=" + id,
				type: 'GET',
				success : function(html){
					if (html != 'true') {
						$('#belcms_shoutbox_main ul').prepend(html);
					}
				},
				complete: function() {
					getLastshoutboxSend(time);
				}
			});
		}, time);
	}
}

getLastshoutboxSend(10000);

function getLastshoutbox() {
	if ($('#belcms_shoutbox_main').height()) {
		var id = $('#belcms_shoutbox_main li:first').attr('id');
		if (id === undefined) {
			id = 0;
		} else {
			id = id.replace('id_', '');
		}
		id++;
		$.ajax({
			url : "shoutbox/html?echo&id=" + id,
			type: 'GET',
			success : function(html){
				if (html != 'true') {
					$('#belcms_shoutbox_main ul').prepend(html);
				}
			},
			complete: function() {
				getLastshoutbox(time);
			}
		});
	}
}