$(document).on('clone', '.field-button', function(e) {
    if (e.target == this) {
	    argon.fields.clone(this);
    }
});
