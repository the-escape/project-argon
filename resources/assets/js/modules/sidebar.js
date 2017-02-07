$(function () {
    let sidebar = $('.sidebar');

    sidebar.on('mouseenter', function () {
        let self = $(this);
        self.parent().addClass('active');
        self.prev('.sidebar__overlay').stop().fadeIn(200);
    });

    sidebar.on('mouseleave', function () {
        let self = $(this);
        self.parent().removeClass('active');
        self.prev('.sidebar__overlay').stop().fadeOut(200);
    });
});
