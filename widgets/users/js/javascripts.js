(function($) {

	var width = $('#bel_cms_widgets_user_log').width();

	if (width < 200) {
		$('#bel_cms_widgets_user_log a').css({
			display: 'block',
			width: '100%',
			float: 'none'
		});
	}

	var link = "Inbox/countUnreadMessage?json";
	$.getJSON(link, {
		format: "json"
	}).done(function(data) {
		$('#bel_cms_widgets_user_count_msg').append(data);
	});

})(jQuery);
