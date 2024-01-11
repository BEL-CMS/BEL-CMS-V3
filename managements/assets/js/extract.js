(function($) {


    $('.extract').on("click",function(event) {
        event.preventDefault();
        $('body').append('<div class="warning" id="alrt_bel_cms">Installation en cours&hellip;</div>');
        $('#alrt_bel_cms').animate({ top: 0 }, 500);
        var url = $(this).attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $('#alrt_bel_cms').addClass('success').empty().append('Installation avec succès');
            },
            beforeSend:function() {
                $('#alrt_bel_cms').addClass('danger').empty().append('Installation en cours&hellip;');
            },
		    complete: function() {
                setTimeout(function() {
                    location.href = 'file_manager?management&option=extras';
                }, 3250);
			    bel_cms_alert_box_end(3);
		    }
        });

    });

    $('.delete_file').on("click",function(event) {
        event.preventDefault();
        $('body').append('<div class="warning" id="alrt_bel_cms">Suppresion en cours&hellip;</div>');
        $('#alrt_bel_cms').animate({ top: 0 }, 500);
        var url = $(this).attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $('#alrt_bel_cms').addClass('success').empty().append('Suppresion avec succès');
            },
		    complete: function() {
                setTimeout(function() {
                    location.href = 'file_manager?management&option=extras';
                }, 3250);
			    bel_cms_alert_box_end(3);
		    }
        }); 
    });

    $('.delete_file_backup').on("click",function(event) {
        event.preventDefault();
        $('body').append('<div class="warning" id="alrt_bel_cms">Suppresion en cours&hellip;</div>');
        $('#alrt_bel_cms').animate({ top: 0 }, 500);
        var url = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $('#alrt_bel_cms').addClass('success').empty().append('Suppresion avec succès');
            },
		    complete: function() {
                setTimeout(function() {
                    location.href = 'file_manager/backup?management&option=extras';
                }, 3250);
			    bel_cms_alert_box_end(3);
		    }
        }); 
    });


    $('.saveUploads').on("click",function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        $('body').append('<div class="warning" id="alrt_bel_cms">Sauvegarde en cours&hellip;</div>');
        $('#alrt_bel_cms').animate({ top: 0 }, 500);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $('#alrt_bel_cms').addClass('success').empty().append('Sauvegarde effectuée avec succès');
            },
		    complete: function() {
			    bel_cms_alert_box_end(3);
		    }
        }); 
     });

     $('.backup_cms').on("click",function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        $('body').append('<div class="warning" id="alrt_bel_cms">Sauvegarde en cours&hellip;</div>');
        $('#alrt_bel_cms').animate({ top: 0 }, 500);
        $.ajax({
            type: 'GET',
            url: url,
		    complete: function() {
                $('#alrt_bel_cms').addClass('success').empty().append('Sauvegarde effectuée avec succès');
                bel_cms_alert_box_end(5);
                setTimeout(function() {
                    bel_cms_alert_box_end(5);
                    location.href = 'file_manager/cms?management&option=extras';
                }, 3250);
		    }
        }); 
     });

    console.log("Chargement BEL-CMS script Extract Ok");

})(jQuery);
