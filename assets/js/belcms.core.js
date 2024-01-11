if (typeof jQuery === 'undefined') {
	throw new Error('BEL-CMS requires jQuery')
}
(function($) {
	"use strict";

	if ($("textarea").hasClass("bel_cms_textarea_simple")) {
		_initTinymceSimple();
	}

	if ($("textarea").hasClass("bel_cms_textarea_full")) {
		_initTinymceFull();
	}
	
	var copyleft = $("body").hasClass("bel_cms_copyleft");
	if (copyleft === false) {
		var new_element = jQuery('<a style="display: none;" class="bel_cms_copyleft" href="https://bel-cms.dev" title="BEL-CMS">Powered by Bel-CMS</a>');
		$('body').append(new_element);
	}

	$('.alertAjaxForm').submit(function(event) {
		event.preventDefault();
		bel_cms_alert_box($(this), 'POST');
	});

	$('.alertAjaxLink').click(function(event) {
		event.preventDefault();
		bel_cms_alert_box($(this), 'GET');
	});

	if (window.sidebar){
		//document.onmousedown = disableselect
		document.onclick = reEnable
	}
	if ($('body').hasClass("DataTableBelCMS")) {
		$('.DataTableBelCMS').DataTable({
	    "language":
			{
				"sEmptyTable":     "Aucune donnée disponible dans le tableau",
				"sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
				"sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
				"sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
				"sInfoThousands":  ",",
				"sLengthMenu":     "Afficher _MENU_ éléments",
				"sLoadingRecords": "Chargement...",
				"sProcessing":     "Traitement...",
				"sSearch":         "Rechercher :",
				"sZeroRecords":    "Aucun élément correspondant trouvé",
				"oPaginate": {
					"sFirst":    "Premier",
					"sLast":     "Dernier",
					"sNext":     "Suivant",
					"sPrevious": "Précédent"
				},
				"oAria": {
					"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
					"sSortDescending": ": activer pour trier la colonne par ordre décroissant"
				},
				"select": {
			        	"rows": {
			         		"_": "%d lignes sélectionnées",
			         		"0": "Aucune ligne sélectionnée",
			        		"1": "1 ligne sélectionnée"
			        	}  
				},
				"pageLength": 50,
				"paging": true
			},
			order: [[0, 'asc']],
		});
	}

	if ($('.colorpicker').height() != undefined) {
		$('.colorpicker').colorpicker();
	}

    var icons = {
        header: "ui-icon-circle-arrow-e",
        activeHeader: "ui-icon-circle-arrow-s"
    }

	if ($('body').hasClass("bel_cms_accordion")) {
		$(".bel_cms_accordion").accordion({
			heightStyle: "content",
			icons: icons
		});
	}

	bel_cms_private_message();

    console.log("Chargement BEL-CMS script Ok");

})(jQuery);

function _initTinymceSimple () {
	tinymce.init({
		selector: 'textarea.bel_cms_textarea_simple',
		browser_spellcheck: true,
		language: 'fr_FR',
		menubar: true,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code'
		],
		link_list: [
			{title: 'PalaceWaR', value: 'https://palacewar.eu'},
			{title: 'Bel-CMS', value: 'https://bel-cms.dev'},
			{title: 'Determe', value: 'https://determe.be'}
  		],
		toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
	});
}
function _initTinymceFull () {
	tinymce.init({
		selector: 'textarea.bel_cms_textarea_full',
		browser_spellcheck: true,
		height: 300,
		language: 'fr_FR',
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc fullscreen'
		],
		link_list: [
			{title: 'PalaceWaR', value: 'https://palacewar.eu'},
			{title: 'Bel-CMS', value: 'https://bel-cms.dev'},
			{title: 'Determe', value: 'https://determe.be'}
  		],
		toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
		image_advtab: true,
		content_css: [
		]
	});
}

function bel_cms_private_message () {
	var currentLink = $(location).attr('pathname').replace('/', '').toLowerCase();
	if (
		currentLink != 'mails'
	) {
		var link = "Mails/testMsg?json";
		$.getJSON(link, {
			format: "json"
		}).done(function(data) {
			if (data.data == true) {
				bel_cms_create_div_message();
			}
		});
	}
}

function bel_cms_create_div_message () {
	$('body').append('<div id="alrt_bel_cms" class="success">Vous avez un nouveau message <a href="Mails" title="Mail">Lire</a></div>');
	$('#alrt_bel_cms').animate({ top: 0 }, 1000);
}
/*###################################
# Function Alert box
###################################*/
function bel_cms_alert_box (objet, type) {
	/* Get Url */
	if (objet.attr('href')) {
		var url = objet.attr('href');
	} else if (objet.attr('action')) {
		var url = objet.attr('action');
	} else if (objet.data('url')) {
		var url = objet.data('url');
	} else {
		alert('No link sets');
	}
	/* serialize data */
	if ($(objet).is('form')) {
		var dataValue  = $(objet).serialize();
	} else if (objet.data('data') == 'undefined'){
		var dataValue  = objet.data('data');
	}
	/* remove div#alrt_bel_cms is exists */
	if ($('#alrt_bel_cms').height()) {
		$('#alrt_bel_cms').remove();
	}
	$('body').append('<div id="alrt_bel_cms">Chargement...</div>');
	$('#alrt_bel_cms').animate({ top: 0 }, 500);
	/* start ajax */
	$.ajax({
		type: type,
		url: url,
		data: dataValue,
		success: function(data) {
			var data = $.parseJSON(data);
			console.log(data);
			/* refresh page */
			if (data.redirect == undefined) {
				var redirect = false;
			} else {
				var redirect = true;
			}
			/* type color */
			if (data.type == undefined) {
				var type = 'blue';
			} else {
				var type = data.type;
			}
			/* link return */
			if (redirect) {
				setTimeout(function() {
					document.location.href=data.redirect;
				}, 3250);
			}
			/* add text */
			$('#alrt_bel_cms').addClass(type).empty().append(data.text);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(chr.responseText);
		},
		beforeSend:function() {
			$('body').append('<div id="alrt_bel_cms">Chargement...</div>');
		},
		complete: function() {
			$('textarea').val('');
			$('input:text').val('');
			bel_cms_alert_box_end(3);
		}
	});
}
/*###################################
# Function end Alert box
###################################*/
function bel_cms_alert_box_end (time) {
	parseInt(time);

	var time = time * 1000;

	setTimeout(function() {
		$('#alrt_bel_cms').animate({ top: '-35px' }, 300, function() {
			$(this).remove();
		});
	}, time);
}