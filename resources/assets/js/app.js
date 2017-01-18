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
        e.preventDefault();
        var self = $(this),
            row = self.parents('.table__page'),
            id = row.data('id'),
            level = row.data('level'),
            rows = $('.table__page[data-level="'+(level+1)+'"][data-parent="'+id+'"]');

        if (rows.length > 0) {
            $('.table__page-attributes').hide();
            if (self.hasClass('table__level--collapsed')) {
                self.attr('class', 'table__level table__level--open');
                rows.show();
            } else if (self.hasClass('table__level--open')) {
                self.attr('class', 'table__level table__level--collapsed');
                collapseLevels(level, id);
            }
        }
    });

    function collapseLevels(level, id)
    {
        level++;
        var rows = $('.table__page[data-level="'+level+'"][data-parent="'+id+'"]');
        rows.each(function (index, value) {
            var row = $(value);
            row.hide().find('.table__level.table__level--open').attr('class', 'table__level table__level--collapsed');
            collapseLevels(level, row.data('id'));
        });
    }

    $('.search').on('submit', function (e) {
        e.preventDefault();
    });

    var searchTimer,
        searchInput = $('.search__input');

    searchInput.on('keyup', function () {
        clearTimeout(searchTimer);
        var form = $(this).parents('form'),
            resultsContainer = form.find('.search__results'),
            resultsList = resultsContainer.find('ul'),
            value = $(this).val(),
            svg = form.find('svg');

        searchTimer = setTimeout(function () {

            if (value.length == 0) {
                resultsList.html('');
                resultsContainer.hide();
                return;
            }

            resultsList.html('');
            svg.show();
            resultsContainer.show();

            $.post('/admin/pages/search', form.serialize())
                .done(function (data) {
                    svg.hide();
                    resultsList.html(data);
            });
        }, 300);
    });

    var click;

    $(document).on('mousedown', function (e) {
        click = $(e.target);
    });

    $(document).on('mouseup', function (e) {
        click = $(e.target);
    });

    searchInput.on('blur', function () {
        var form = $(this).parents('form'),
            resultsContainer = form.find('.search__results');

        $(this).val('');

        if (click.parents('.search__results').length > 0) {
            return null;
        }

        $('.search_results ul').html('');
        resultsContainer.hide();
    });

    $('body').on('click', '.search__result', function (e) {
        e.preventDefault();
        var self = $(this),
            id = self.data('id'),
            parent = self.data('parent');

        if (id == undefined || parent == undefined) {
            return null;
        }

        var row = $('.table__page[data-id="'+id+'"]'),
            rows = $('.table__page[data-parent="'+parent+'"]');

        $('.table__page--active').removeClass('table__page--active');
        row.addClass('table__page--active');
        findPage(rows);

        $.scrollTo(row, 400);
        $('.search__results').hide();
        $('.search__results ul').html('');
    });

    function findPage(rows)
    {
        rows.each(function (index, value) {
            var row = $(value),
                parents = $('.table__page[data-id="'+row.data('parent')+'"]');

            parents.each(function (index, value) {
                $(value).find('.table__level').attr('class', 'table__level table__level--open');
            });

            row.show();
            findPage(parents);
        });
    }
});
