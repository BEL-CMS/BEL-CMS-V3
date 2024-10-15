$(".header-user-name").on("click", function () {
    $(".header-user-menu_wrap").toggleClass("header-user-menu_wrap_vis");
});
    $(".tfp-btn").on("click", function () {
        $(this).toggleClass("rot_tfp-btn");
        $(".tfp-det").toggleClass("vis_tfp-det ");
    });
    $(".notification-close").on("click", function (e) {
        e.preventDefault();
        $(this).parent(".notification").slideUp(200);
    });

$('.add-acc').on('click', function (e) {
    e.preventDefault();
    var newElem = $(this).parents(".add_acc-item-wrap").find('.add_acc-item').first().clone(),
        parclone = $(this).parents(".add_acc-item-wrap").find(".add_acc-container");
    newElem.find('input').val('');
    newElem.appendTo(parclone);
 
    $(".remove-rp").on('click', function () {
        $(this).parents(".add_acc-item:not(:first-child)").remove();
    });
});
$(".remove-rp").on('click', function () {
    $(this).parents(".add_acc-item").remove();
});
$(".db-menu_modile_btn").on('click', function () {
    $(".user-dasboard-menu").slideToggle(500);
	 $(this).toggleClass('db-menu_modile_btn_cls');
});
var nowDate		= new Date();
var nowDay		= ((nowDate.getDate().toString().length) == 1) ? '0'+(nowDate.getDate()) : (nowDate.getDate());
var nowMonth	= ((nowDate.getMonth().toString().length) == 1) ? '0'+(nowDate.getMonth()+1) : (nowDate.getMonth()+1);
var nowYear		= nowDate.getFullYear();
var formatDate	= nowDay + "." + nowMonth + "." + nowYear;

$('.db-date strong').text(formatDate);