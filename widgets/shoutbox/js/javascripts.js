(function($) {
	$('#bel_cms_widgets_shoutbox_form').submit(function(e) {
		e.preventDefault();
		var d  = $(this).serializeArray();
		var l = d.length;
		var obj = {};
		for (i=0; i<l; i++) {
			obj[d[i].name] = d[i].value;
		}
		bel_cms_alert_box($(this));
		if (
			obj['username'] != '' &&
			obj['avatar'] != '' &&
			obj['text'] != '' &&
			obj['time'] != ''
		) {
			getLastshoutboxSend(2500);
		}
	});
})(jQuery);

function getLastshoutboxSend(time) {
	if ($('#bel_cms_widgets_shoutbox').height()) {
		setTimeout( function(){
			var id = $('#bel_cms_widgets_shoutbox_msg li:first').attr('id');
			if (id === undefined) {
				id = 0;
			} else {
				id = id.replace('id_', '');
			}
			$.ajax({
				url : "shoutbox/get&echo?id=" + id,
				type: 'GET',
				success : function(html){
					$('#bel_cms_widgets_shoutbox_msg').prepend(html);
				},
			});
		}, time);
	}
}

function getLastshoutbox(time) {
	if ($('#bel_cms_widgets_shoutbox').height()) {
		setTimeout( function(){
			var id = $('#bel_cms_widgets_shoutbox_msg li:first').attr('id');
			if (id === undefined) {
				id = 0;
			} else {
				id = id.replace('id_', '');
			}
			$.ajax({
				url : "shoutbox/get&echo?id=" + id,
				type: 'GET',
				success : function(html){
					$('#bel_cms_widgets_shoutbox_msg').prepend(html);
				},
				complete: function() {
					getLastshoutbox(time);
				}
			});
		}, time);
	}
}
getLastshoutbox(15000);