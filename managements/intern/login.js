$(document).ready(function () {
	//hang on event of form with id=sendLogin
	$('#sendLogin').submit(function(event) {
		//prevent Default functionality
		event.preventDefault();
		formSendLogin($(this),'POST');
	});
});

function formSendLogin (objet, type)
{
	var url       = objet.attr('action');
	//get the action-url of the form
	var serialize = $(objet).serialize();
	var span      = $("#loading > span");
	
	$('#loading').show();
	$('#loading').animate({ opacity: '1' }, 1000, function() {
		span.empty().append('Veuillez patienter');
	});

	setTimeout(function() {
		$.ajax({
			type: type,
			url: url,
			data: serialize,
			success: function(data) {
				var data = $.parseJSON(data);
				console.log(data);
				span.empty().append(data.ajax);

				setTimeout(function() {
					location.reload();
				}, 3250);
			},
			error: function() {
				alert('Error function ajax');
			},
			complete: function() {
			}
		});
	}, 1000);

}