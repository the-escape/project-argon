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


});
