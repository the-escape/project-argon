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
    searchInput.on('blur', function (e) {
        resultList.html('');
        resultContainer.hide();
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
        $('.table__page--active').removeClass('table__page--active');
        if (rows.length > 0) {
            $('.table__page-attributes').hide();
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
        $('.table__page-attributes').hide();
        $(this).parents('.table__page').trigger('click');
        if (page.is(':visible')) {
            page.hide();
        } else {
            page.show();
        }
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
            name: 'parent',
            value: page.data('id')
        });
        $.post(self.attr('action'), data)
            .done(function (data) {
                parent.after(data);
            });
    });

    $('.form__select').select2({
        minimumResultsForSearch: Infinity
    });

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
