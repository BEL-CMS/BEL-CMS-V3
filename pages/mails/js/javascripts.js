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
console.log( "Mails jQuery loaded" );