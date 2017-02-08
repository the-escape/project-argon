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

/**
 * Generic modal logic.
 */
$('.modal').on('show.bs.modal', function (e) {
    let self = $(this),
        triggerElem = $(e.relatedTarget),
        title = triggerElem.data('title'),
        subtitle = triggerElem.data('subtitle'),
        message = triggerElem.data('message'),
        url = triggerElem.data('url');
    if (title != undefined) {
        self.find('.modal__title').text(title);
    }
    if (subtitle != undefined) {
        self.find('.modal__subtitle').text(subtitle);
    }
    if (message != undefined) {
        self.find('.modal__message').text(message);
    }
    if (url != undefined) {
        self.find('.modal__confirm').attr('href', url);
    }
});
