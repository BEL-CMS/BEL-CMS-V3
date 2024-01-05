if (typeof jQuery === 'undefined') {
	throw new Error('BEL-CMS requires jQuery')
}
(function($) {
	"use strict";
    $('.faq_answer').on( "click", function(event) {
        event.preventDefault();
        $('.faq_answer').parent().removeClass('active');
        $(this).parent().addClass('active');
        var id = $(this).attr('id');
        id = '#' + id + '_active';
        $('#belcms_section_faq_content').hide("fast", function() {
            $('#belcms_section_faq_content > div').hide("fast", function() {
                $(id).show("fast", function() {
                    $('#belcms_section_faq_content').show("fast");
                });
            });
        });
    });;
    console.log("Chargement du script FAQ Ok");
})(jQuery);