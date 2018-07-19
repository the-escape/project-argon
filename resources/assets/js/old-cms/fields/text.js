$(document).on('clone', '.field-text', function (e) {
    if (e.target == this) {
        argon.fields.clone(this)
    }
})
