$(document).on('clone', '.field-select', function(e) {
    console.log("select clone");
    if (e.target == this) {
	argon.fields.clone(this);
    }
});
