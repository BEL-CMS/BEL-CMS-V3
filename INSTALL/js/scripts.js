var i = 0;
(function($) {
	"use strict";

	$('#submit_bdd').click( function() {
		ajax(i);
	});

	var particles = Particles.init({
		selector: '.background',
	  	color: ['#FFFFFF', '#FFFFFF'],
	  	connectParticles: true,
	  	responsive: [{
		  breakpoint: 800,
		options: {
			color: '#FFFFFF',
			maxParticles: 550,
		  	connectParticles: true
		}
	  }]
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
				ajaxSQLInstall(i, req);
		} else {
			$('#submit_bdd').hide();
			$('#next_link').removeClass('hidden');
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
			$('#code').append('<div id="'+ e +'" class="row_table"><span class="title">'+ e +'</span><span class="wait"><i class="fa-solid fa-spinner fa-spin-pulse"></i></span></div>');
			document.getElementById('code').scrollTop = 5000;
		},
		complete: function() {
			setTimeout(function() {
				$('#code #'+e ).remove();
				$('#code').append('<div id="'+ e +'" class="row_table"><span class="title">'+ e +'</span><span class="green"><i class="fa-regular fa-thumbs-up"></i></span></div>');
				ajax(i);
			}, 150);
		}
	});
}