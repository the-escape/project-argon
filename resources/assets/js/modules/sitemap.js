$(function () {
    let searchTimer = null,
        searchInput = $('.search__input'),
        searchForm = searchInput.parents('form'),
        resultContainer = searchForm.find('.search__results'),
        resultList = resultContainer.find('ul');

    /**
     * TABLE SEARCH
     */

    searchInput.on('keyup', function () {
        clearTimeout(searchTimer);
        let self = $(this),
            searchValue = self.val(),
            resultLoading = searchForm.find('svg');
        searchTimer = setTimeout(function () {
            resultList.html('');
            if (searchValue.length == 0) {
                resultContainer.hide();
                return null;
            }
            resultLoading.show();
            resultContainer.show();
            $.post('/admin/pages/search', searchForm.serialize())
                .done(function (results) {
                    resultLoading.hide();
                    resultList.html(results);
                })
        }, 300);
    });
    searchInput.on('blur', function () {
        if (!$('.search__results:hover').length) {
            $(this).val('');
            resultList.html('');
            resultContainer.hide();
        }
    });

    $('body').on('click', '.search__result', function (e) {
        e.preventDefault();
        let self = $(this),
            pageId = self.data('id'),
            pageParent = self.data('parent');
        if (pageId == undefined || pageParent == undefined) {
            return null;
        }
        let row = $('.table__page[data-id="' + pageId + '"]'),
            rows = $('.table__page[data-parent="' + pageParent + '"]');
        $('.table__page--active').removeClass('table__page--active');
        row.addClass('table__page--active');
        findPage(rows);
        $.scrollTo(row, 600);
        $('.search__results').hide();
        $('.search__results ul').html('');
    });

    /**
     * TABLE ROWS
     */

    $('.table__page').on('click', function (e) {
        let target = $(e.target);
        if (target.hasClass('ic') || target.hasClass('form__btn')) {
            return null;
        }
        e.preventDefault();
        let self = $(this),
            levelElem = self.find('.table__level'),
            pageId = self.data('id'),
            level = self.data('level'),
            rows = $('.table__page[data-level="' + (level + 1) + '"][data-parent="' + pageId + '"]');
        if (rows.length > 0) {
            if (levelElem.hasClass('table__level--collapsed')) {
                levelElem.attr('class', 'table__level table__level--open');
                rows.show();
            } else if (levelElem.hasClass('table__level--open')) {
                levelElem.attr('class', 'table__level table__level--collapsed');
                collapseLevels(level, pageId);
            }
        }
    });

    $('.ic__create').on('click', function (e) {
        e.preventDefault();
        let pageId = $(this).parents('tr').data('id'),
            page = $('.table__reveal[data-id="' + pageId + '"]').find('.table__page-attributes');
        $('.table__page-attributes').removeClass('table__page--attributes-show');
        $('.table__page').removeClass('table__page--active');
        if (page.hasClass('table__page--attributes-show')) {
            page.removeClass('table__page--attributes-show');
            page.parents('.table__reveal').prev('.table__page').removeClass('table__page--active');
        } else {
            page.addClass('table__page--attributes-show');
            page.parents('.table__reveal').prev('.table__page').addClass('table__page--active');
        }
    });

    $('.table__reveal-cancel').on('click', function (e) {
        e.preventDefault();
        $('.table__page-attributes').removeClass('table__page--attributes-show');
        $('.table__page').removeClass('table__page--active');
    });

    $('.page__create').on('submit', function (e) {
        e.preventDefault();
        let self = $(this),
            parent = self.parents('.table__reveal'),
            page = parent.prev('.table__page'),
            data = self.serializeArray();
        data.push({
            name: 'level',
            value: (page.data('level') + 1)
        }, {
            name: 'parent_id',
            value: page.data('id')
        });
        $.post(self.attr('action'), data)
            .done(function (data) {
                let row = $(data);
                parent.find('.table__reveal-cancel').trigger('click');
                row.removeClass('table__page--hidden');
                parent.after(row);
            });
    });

    $('.form__select').select2({
        minimumResultsForSearch: Infinity
    });

    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });

    function findPage(rows) {
        rows.each(function (i, v) {
            let row = $(v),
                parents = $('.table__page[data-id="' + row.data('parent') + '"]');
            parents.each(function (i, v) {
                $(v).find('.table__level').attr('class', 'table__level table__level--open');
            });
            row.show();
            findPage(parents);
        });
    }

    function collapseLevels(level, pageId) {
        level++;
        let rows = $('.table__page[data-level="' + level + '"][data-parent="' + pageId + '"');
        rows.each(function (index, value) {
            let row = $(value);
            row.hide().find('.table__level.table__level--open').attr('class', 'table__level table__level--collapsed');
            collapseLevels(level, row.data('id'));
        });
    }
});
