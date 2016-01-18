if ($('.field-boolean').length > 0) {


    $('.field-boolean .boolean-on').click(function() {
        var field = $(this).closest('.field-boolean');

        field.find('.boolean-radio-on').click();
    });

    $('.field-boolean .boolean-off').click(function() {
        var field = $(this).closest('.field-boolean');

        field.find('.boolean-radio-off').click();
    })

}
