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

console.log( "Mails jQuery loaded" );