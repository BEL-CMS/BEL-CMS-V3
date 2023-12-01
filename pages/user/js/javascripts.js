jQuery(document).ready(function($){

	$('#belcms_main_user_left_menu li a').click(function(event) {
		event.preventDefault();
		var id = $(this).attr('href').replace('#', '');
		$('#belcms_main_user_left_menu li a').each(function() {
			$(this).removeClass('active');
		});
	});

	$('.bel_cms_jquery_avatar_sel').click(function(event) {
		event.preventDefault();
		var id   = $(this).data('id');
		var link = $(this).attr('href').replace('#', '');
		$('#sel_avatar_'+id).prop( "checked", true );
		$(this).each(function() {
			$('.bel_cms_jquery_avatar_sel').css('border', 'none');
		});
		$(this).css('border', '1px dashed grey');
	});
	
	$('#delavatar').click(function(event) {
		event.preventDefault();
		$('#selectavatar').val('delete');
		$("#avatarSubmit").submit();
	});

	$(".getNewPass").click(function(){
		var field = $(this).closest('div').find('input[rel="gp"]');
		field.val(randString(field));
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