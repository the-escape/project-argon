$(function () {
	$('.sidebar').on('mouseenter', function (e) {
	    $(this).parent().addClass('active');
    });
    $('.sidebar').on('mouseleave', function (e) {
        $(this).parent().removeClass('active');
    })
});
