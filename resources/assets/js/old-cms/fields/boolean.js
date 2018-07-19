$(document).on('click', '.boolean-on', function () {
    $(this)
        .siblings('.boolean-radio-on')
        .trigger('click')
})

$(document).on('click', '.boolean-off', function () {
    $(this)
        .siblings('.boolean-radio-off')
        .trigger('click')
})
