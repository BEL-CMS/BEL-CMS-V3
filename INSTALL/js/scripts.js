var i = 0;
(function($) {
	"use strict";
	$('#submit_bdd').click( function() {
		$(this).parents("div:first").remove();
		ajax(i);
	});

	$('#user').on("change",function() {
		if ($("#user").val().length >= 3 && $("#email").val().length >= 3 && $("#password").val().length >= 3) {
			$('.menuuser').show();
		}
	});

	$('#email').on("change",function() {
		if ($("#user").val().length >= 3 && $("#email").val().length >= 3 && $("#password").val().length >= 3) {
			$('.menuuser').show();
		}
	});

	$('#password').on("change",function() {
		if ($("#user").val().length >= 3 && $("#email").val().length >= 3 && $("#password").val().length >= 3) {
			$('.menuuser').show();
		}
	});

	console.log("Chargement Installation BEL-CMS script Ok");

})(jQuery);

function ajax (i) {
	var link = "/INSTALL/includes/ajax.php";
	$.getJSON(link, {
		format: "json"
	}).done(function(data) {
		req = data[i];
		i = i + 1;
		if (req != undefined) {
			setTimeout(function() {
				ajaxSQLInstall(i, req);
			}, 100);
		} else {
			$('.belcms_notification > header').removeClass('infos').addClass("success"); 
			$('#error_bdd').empty().append('Toutes les tables on bien été crée, vous pouvez passer au suivant en cliquant sur le bouton suivant.');
			$('#menu').append('<li><a href="?page=sql">Précédent</a></li><li id="next"><a href="?page=user">Suivant</a></li>');
		}
	});
}

function ajaxSQLInstall (i, e) {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "?page=create_sql",
		async: true,
		data: "table="+e,
		success: function(m) {
			if (m) {
				$('#'+ e).empty().append(m);
			} else {
				$('#error_bdd').append(m);
			}	
			console.log(m[0]);
		},
		error: function(xhr, textStatus, errorThrown) {
			console.log(xhr.responseText);
			console.log(textStatus);
			console.log(errorThrown);
		},
		beforeSend:function() {
			$('#install').append('<div><span>'+ e +'</span><span id="'+ e +'"><i class="fa-solid fa-circle-xmark"></i></span></div>');
		},
		complete: function() {
			ajax(i);
		}
	});
}