$(document).on('clone', '.field-combo', function(e) {
    if (e.target == this) {
        argon.fields.clone(this);
    }
});
