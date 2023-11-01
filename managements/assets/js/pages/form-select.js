
//===============================
document.addEventListener("DOMContentLoaded", function (e) {
    // default
    var els = document.querySelectorAll(".selectize");
    els.forEach(function (select) {
        NiceSelect.bind(select);
    });
});

//
document.addEventListener("DOMContentLoaded", function (e) {
    // seachable 
    var options = {
        searchable: true
    };
    NiceSelect.bind(document.getElementById("search-select"), options);
})
