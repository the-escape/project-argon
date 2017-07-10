let dirtyElem = $('meta[name="_dirty"]');

window.argon = {
    setDirty: function(status) {
        let dirty = status ? 1 : 0;
        dirtyElem.attr('content', dirty);
        return true;
    },
    isDirty: function() {
        return !!+dirtyElem.attr('content');
    }
};

/**
 * Enable select 2 on the select boxes.
 */
$('.form__select').select2({
    minimumResultsForSearch: Infinity
});

/**
 * Enable Bootstrap tool tips.
 */
$('[data-toggle="tooltip"]').tooltip({
    trigger: 'hover'
});

$('[data-toggle="modal"]').on('click', function (e) {
    e.preventDefault();
});

$('.modal__link').on('click', function (e) {
    e.preventDefault();
    let href = $(this).attr('href'),
        modal = $('.modal');
    if (argon.isDirty() && !modal.is(':visible')) {
        modal.data('href', href);
        modal.modal();
    } else {
        window.location.href = href;
    }
});

/**
 * Generic modal logic.
 */
$('.modal').on('show.bs.modal', function (e) {
    let self = $(this),
        href = self.data('href');

    if (href != undefined) {
        self.find('.modal__confirm').attr('href', href);
    }
});
