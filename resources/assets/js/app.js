$(function () {
    var sidebar = $('.sidebar'),
        body = $('body');
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

    body.on('mouseleave', function () {
        if (sidebar.hasClass('active')) {
            sidebar.trigger('mouseleave');
        }
    });

    var blocksAll = document.getElementById('blocks-all');
    if (blocksAll) {
        Sortable.create(blocksAll, {
            group: {
                name: 'blocks',
                pull: true,
                put: false
            },
            ghostClass: 'block--ghost'
        });
    }

    var blocksSelected = document.getElementById('blocks-selected');
    if (blocksSelected) {
        Sortable.create(blocksSelected, {
            group: {
                name: 'blocks',
                pull: false,
                put: true
            },
            ghostClass: 'block--ghost',
            onSort: function (evt, originalEvent) {
                updateBlockArray($(evt.item).data('id'));
            }
        });
    }

    $('.block__add').on('click', function (e) {
        e.preventDefault();
        var self = $(this),
            block = self.parents('.block');

        block.appendTo('#blocks-selected');

        updateBlockArray(block.data('id'));
    });

    $('.block__delete').on('click', function (e) {
        e.preventDefault();
        var self = $(this),
            block = self.parents('.block');

        block.appendTo('#blocks-all');

        updateBlockArray(block.data('id'));
    });

    function updateBlockArray(itemId)
    {
        var blocks = $(blocksSelected).find('li'),
            blockArray = [],
            form = $('form'),
            current = $('input[name="groups"]'),
            item = $('.block[data-id="'+itemId+'"]');

        blocks.each(function (index, value) {
            blockArray.push($(value).data('id'));
        });

        var json = JSON.stringify(blockArray);

        if (current.val() != json) {
            current.val(JSON.stringify(blockArray));

            item.addClass('block--loading');

            $.post(form.attr('action'), form.serialize())
                .done(function (data) {
                    item.removeClass('block--loading');
                });
        }
    }

    $('.blocks__search').on('keyup', function () {
        var self = $(this),
            filter = self.val(),
            blocks = self.parents('.blocks').find('.block');

        if (filter == '') {
            blocks.removeClass('block--hidden');
        }

        blocks.each(function (index, value) {
            var elem = $(value),
                name = elem.data('name');

            if (name.indexOf(filter) > -1) {
                elem.removeClass('block--hidden');
            } else {
                elem.addClass('block--hidden');
            }
        });
    });

    body.on('click', '.ic__create', function (e) {
        e.preventDefault();
        var id = $(this).parents('tr').data('id'),
            pages = $('.table__page-attributes'),
            page = $('.table__reveal[data-id="'+id+'"]').find('.table__page-attributes');
        pages.slideUp();
        if (page.is(':visible')) {
            page.slideUp();
        } else {
            page.slideDown();
        }
    });

    $('.table__page').on('click', function (e) {

        if ($(e.target).hasClass('ic') || $(e.target).hasClass('form__btn')) {
            return null;
        }

        e.preventDefault();

        var levelElement = $(this).find('.table__level'),
            self = $(this),
            id = self.data('id'),
            level = self.data('level'),
            rows = $('.table__page[data-level="'+(level+1)+'"][data-parent="'+id+'"]');

        $('.table__page--active').removeClass('table__page--active');

        if (rows.length > 0) {
            $('.table__page-attributes').hide();
            if (levelElement.hasClass('table__level--collapsed')) {
                levelElement.attr('class', 'table__level table__level--open');
                rows.show();
            } else if (levelElement.hasClass('table__level--open')) {
                levelElement.attr('class', 'table__level table__level--collapsed');
                collapseLevels(level, id);
            }
        }

        //self.addClass('table__page--active');
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
        if (click.parents('.search__result').length == 0) {
            $('.table__page--active').removeClass('table__page--active');
        }
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

    body.on('click', '.search__result', function (e) {
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

        $.scrollTo(row, 600);
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

    $('.form__select').select2({
        placeholder: 'Dropdown',
        minimumResultsForSearch: Infinity
    });

    body.on('click', '.table__reveal-cancel', function (e) {
        e.preventDefault();
        $(this).parents('.table__page-attributes').slideUp();
    });

    body.on('submit', '.page__create', function (e) {
        e.preventDefault();
        var self = $(this),
            parent = self.parents('.table__reveal'),
            page = parent.prev('.table__page'),
            data = self.serializeArray();

        data.push({
            name: 'level',
            value: (page.data('level') + 1)
        }, {
            name: 'parent',
            value: page.data('id')
        });

        $.post(self.attr('action'), data)
            .done(function (data) {
                parent.after(data);
        });
    });
});
