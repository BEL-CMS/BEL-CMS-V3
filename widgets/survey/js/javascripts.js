(function($) {
	"use strict";

    if ($('.jquery_vote').height()) {

        $('.jquery_vote').click(function(event) {
		    event.preventDefault();

            if ($('#alrt_bel_cms').height()) {
                $('#alrt_bel_cms').remove();
            }

            var formData = {
                quest:  $(this).attr("data-quest"),
                answer: $(this).attr("data-answer"),
                id:     $(this).attr("data-id")
            };

            $.ajax({
                type: "POST",
                url: "survey/sendvote?json",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(data);
                 location.reload();
            });

	    });
    }

        $("#belcms_widgets_survey_form").submit(function(event) {
            event.preventDefault();
            
            var formData = {
                name: $("#belcms_widgets_survey_form_name").val(),
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
            });

        });
})(jQuery);