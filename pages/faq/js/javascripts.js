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
        $('#belcms_section_faq_content').slideUp("fast", function() {
            $('#belcms_section_faq_content > div').hide("fast", function() {
                $(id).show("fast", function() {
                    $('#belcms_section_faq_content').slideDown("fast");
                });
            });
        });
    });;

    $("#site_search").on("keyup", function() {
        var value = $(this).val();
        if (!$(this).val()) {
            $('#bel_cms_accordion_search').slideUp('fast', function() {
                $('#belcms_section_faq_cat').slideDown();
            });
        }
    });

    $("#site_search").on("keypress", function(e) {
        if (e.keyCode === 13) {
            var value = $(this).val();
            if (!$(this).val()) {
                $('#bel_cms_accordion_search').slideUp('fast', function() {
                    $('#belcms_section_faq_search').slideDown();
                });
            } else {
                $.ajax({
                    url: 'faq/search?echo&search=' + value,
                    dataType: 'html',
                    success : function(html) {
                        $('#belcms_section_faq_cat').slideUp();
                        $('#belcms_section_faq_cat').after(html);
                    },
                    beforeSend: function() {
                        $('#bel_cms_accordion_search').empty();
                    }
                });
            }
        }
    });

    console.log("Chargement du script FAQ Ok");
})(jQuery);