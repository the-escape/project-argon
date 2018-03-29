$(document).on('clone', '.field-item', function(e) {
    console.log("item clone");
    if (e.target == this) {
	    argon.fields.clone(this);

    }
});
