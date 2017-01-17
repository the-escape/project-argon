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
    if (blocksPage) {
        Sortable.create(blocksPage, {group: 'blocks'});
    }

    var blocksOptions = document.getElementById('blocks--options');
    if (blocksOptions) {
        Sortable.create(blocksOptions, {group: 'blocks'});
    }

    $('.table--sitemap .ic.ic__create').on('click', function (e) {
        e.preventDefault();
        var id = $(this).parents('tr').data('id'),
            pages = $('.table__page-attributes'),
            page = $('.table__reveal[data-id="'+id+'"]').find('.table__page-attributes');
        pages.slideUp();
        page.slideDown();
    });

    $('.table__level').on('click', function (e) {
        var self = $(this),
            row = self.parents('.table__page'),
            id = row.data('id'),
            level = row.data('level'),
            rows = $('.table__page[data-level="'+(level+1)+'"][data-parent="'+id+'"]');

        if (self.hasClass('table__level--collapsed')) {
            
            rows.slideDown();
        } else {
            rows.slideUp();
        }
    });
});
