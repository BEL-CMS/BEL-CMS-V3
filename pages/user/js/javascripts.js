jQuery(document).ready(function($){

	$('#belcms_main_user_left_menu li a').click(function(event) {
		event.preventDefault();
		var id = $(this).attr('href').replace('#', '');
		$('#belcms_main_user_left_menu li a').each(function() {
			$(this).removeClass('active');
		});
	});

    $('.user_add_avatar').click(function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
		$('body').append('<div class="danger" id="alrt_bel_cms">Chargement...</div>');
        $.ajax({
            url: url,
            dataType: 'html',
			type: 'GET',
            success : function(data) {
				console.log(data);
				$('#alrt_bel_cms').addClass('success').empty().append('Avatar mise en place');
			},
			complete: function() {
				bel_cms_alert_box_end(3250);
				setTimeout(function() {
					location.reload(true);
				}, 3250);
			},
			beforeSend:function() {
				$('#alrt_bel_cms').animate({ top: '0px' }, 300);
			},
        });
    });
	
    $('.user_del_avatar').click(function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
		$('body').append('<div class="danger" id="alrt_bel_cms">Chargement...</div>');
        $.ajax({
            url: url,
            dataType: 'html',
			type: 'GET',
            success : function(data) {
				console.log(data);
				$('#alrt_bel_cms').addClass('success').empty().append('Image effacé');
			},
			complete: function() {
				bel_cms_alert_box_end(3250);
				setTimeout(function() {
					//location.reload(true);
				}, 3250);
			},
			beforeSend:function() {
				$('#alrt_bel_cms').animate({ top: '0px' }, 300);
			},
        });
    });

	$(".getNewPass").click(function(){
		var field = $(this).closest('div').find('input[rel="gp"]');
		field.val(randString(field));
	});

// Generate a password string
function randString(id){
	var dataSet = $(id).attr('data-character-set').split(',');  
	var possible = '';
	if($.inArray('a-z', dataSet) >= 0){
	  possible += 'abcdefghijklmnopqrstuvwxyz';
	}
	if($.inArray('A-Z', dataSet) >= 0){
	  possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	}
	if($.inArray('0-9', dataSet) >= 0){
	  possible += '0123456789';
	}
	if($.inArray('#', dataSet) >= 0){
	  possible += '![]{}()%&*$#^<>~@|';
	}
	var text = '';
	for(var i=0; i < $(id).attr('data-size'); i++) {
	  text += possible.charAt(Math.floor(Math.random() * possible.length));
	}
	return text;
  }
  
  // Create a new password on page load
  $('input[rel="gp"]').each(function(){
	$(this).val(randString($(this)));
  });
  
  // Create a new password
  $(".getNewPass").click(function(){
	var field = $(this).closest('div').find('input[rel="gp"]');
	field.val(randString(field));
  });
  
  // Auto Select Pass On Focus
  $('input[rel="gp"]').on("click", function () {
	 $(this).select();
  });

	// avatar upload

	var $dropzone = $('.image_picker'),
    $droptarget = $('.drop_target'),
    $dropinput = $('#inputFile'),
    $dropimg = $('.image_preview'),
    $remover = $('[data-action="remove_current_image"]');

	$dropzone.on('dragover', function() {
	$droptarget.addClass('dropping');
	return false;
	});

	$dropzone.on('dragend dragleave', function() {
	$droptarget.removeClass('dropping');
	return false;
	});

	$dropzone.on('drop', function(e) {
		$droptarget.removeClass('dropping');
		$droptarget.addClass('dropped');
		$remover.removeClass('disabled');
		e.preventDefault();
  
  	var file = e.originalEvent.dataTransfer.files[0],
  	 reader = new FileReader();

  reader.onload = function(event) {
    $dropimg.css('background-image', 'url(' + event.target.result + ')');
  };
  
  console.log(file);
  reader.readAsDataURL(file);

  return false;
});

$dropinput.change(function(e) {
  $droptarget.addClass('dropped');
  $remover.removeClass('disabled');
  $('.image_title input').val('');
  
  var file = $dropinput.get(0).files[0],
      reader = new FileReader();
  
  reader.onload = function(event) {
    $dropimg.css('background-image', 'url(' + event.target.result + ')');
  }
  
  reader.readAsDataURL(file);
});

$remover.on('click', function() {
  $dropimg.css('background-image', '');
  $droptarget.removeClass('dropped');
  $remover.addClass('disabled');
  $('.image_title input').val('');
});

$('.image_title input').blur(function() {
  if ($(this).val() != '') {
    $droptarget.removeClass('dropped');
  }
});

});

function randString(id){
	var dataSet = $(id).attr('data-character-set').split(',');  
	var possible = '';
	if($.inArray('a-z', dataSet) >= 0){
		possible += 'abcdefghijklmnopqrstuvwxyz';
	}
	if($.inArray('A-Z', dataSet) >= 0){
		possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	}
	if($.inArray('0-9', dataSet) >= 0){
		possible += '0123456789';
	}
	if($.inArray('#', dataSet) >= 0){
		possible += '![]{}()%&*$#^<>~@|';
	}
	var text = '';
	for(var i=0; i < $(id).attr('data-size'); i++) {
			text += possible.charAt(Math.floor(Math.random() * possible.length));
	}
	return text;
}