(function($) {
	"use strict";

    $("#belcms_widgets_survey_page_form").submit(function(event) {
        event.preventDefault();
        
        var formData = {
            name: $("#belcms_widgets_survey_page_form_name").val(),
            id: $("#belcms_widgets_survey_form_id").val()
        };

        $.ajax({
            type: "POST",
            url: "survey/Newsurvey?json",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data);
            location.reload();
        });
    });

    console.log("Chargement JS Sondage BEL-CMS script Ok");

})(jQuery);