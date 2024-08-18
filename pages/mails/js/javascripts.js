$('#belcms_mails_new_author').autocomplete({
    source: function (request, response) {
        $.getJSON("Mails/getUsers?json&term=" + request.term, function (data) {
            response($.map(data.username, function (value, key) {
                return {
                    label: value,
                    value: value
                };
            }));
        });
    },
    minLength: 3,
    delay: 100
});

document.getElementById('checkbox_all_mails').addEventListener('change', function() {
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

$("#checkbox_trash").click(function(event){
    event.preventDefault();
    var form      = "#belcms_section_mails_form";
    var formData  = $(form).serializeArray();
    var route     = $(form).attr('action');
    $.ajax({
        type: "POST", //we are using POST method to submit the data to the server side
        url: route, // get the route value
        data: formData, // our serialized array data for server side
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
			$('body').append('<div id="alrt_bel_cms">Chargement...</div>');
			$('#alrt_bel_cms').animate({ top: '0px' }, 300,);
        },
        success: function (response) {//once the request successfully process to the server side it will return result here
            $('#alrt_bel_cms').addClass('success').empty().append(('Suppression avec succès'));
        },
        complete: function() {
            bel_cms_alert_box_end(2);
            setTimeout(function() {
                //location.reload(true);
            }, 2250);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            // You can put something here if there is an error from submitted request
        }
    });
});

console.log( "Mails jQuery loaded" );