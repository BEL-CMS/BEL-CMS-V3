if (typeof jQuery === 'undefined') {
	throw new Error('BEL-CMS requires jQuery')
}
(function($) {
	"use strict";

    _initTinymceSimple();

    $('a.jquery').click(function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        $('#section_links_ul').remove();
        jQuery.ajax({  
            url: url,  
            type: 'GET',
            success: function(data) { 
                $("#loader").delay(1000).hide('fast', function() {
                    $("#section_ajax").html(data);
                });
            },
            complete: function() {
                $("#section_ajax").show();
            },
            beforeSend:function() {
                $('#loader').show('fast');
            }
        });
    });

    console.log("Chargement JS Liens BEL-CMS script Ok");
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