jQuery(document).ready(function($) {
	console.log( "inbox jQuery loaded" );
	autoGetUsers();
	_initTinymceInbox();

	$('#delete_inbox_message').click(function(e) {
		e.preventDefault();
		tinyMCE.activeEditor.setContent('');
	});

});

function _initTinymceInbox () {
	tinymce.init({
		selector: 'textarea.bel_cms_textarea_inbox',
		browser_spellcheck: true,
		language: 'fr_FR',
		theme: 'modern',
		menubar: false,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks',
			'insertdatetime media table contextmenu paste'
		],
		toolbar: 'bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | table',
		content_css: '//www.tinymce.com/css/codepen.min.css'
	});
}

function autoGetUsers () {
	$('#bel_cms_inbox_get_users').autocomplete({
		source: function (request, response) {
			$.getJSON("Inbox/getUsers?json&term=" + request.term, function (data) {
				response($.map(data.username, function (value, key) {
					return {
						label: value,
						value: value
					};
				}));
			});
		},
		minLength: 2,
		delay: 100
	});
}
