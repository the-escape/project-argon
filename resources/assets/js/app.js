$(function () {
    var sidebar = $('.sidebar');
    sidebar.on('mouseenter', function (e) {
        var self = $(this);
        self.parent().addClass('active');
        self.prev('.sidebar__overlay').stop().fadeIn(200);
    });
    sidebar.on('mouseleave', function (e) {
        var self = $(this);
        self.parent().removeClass('active');
        self.prev('.sidebar__overlay').stop().fadeOut(200);
    });

    var blocksPage = document.getElementById('blocks--page');
    Sortable.create(blocksPage, { group: 'blocks' });

    var blocksOptions = document.getElementById('blocks--options');
    Sortable.create(blocksOptions, { group: 'blocks' });
});
