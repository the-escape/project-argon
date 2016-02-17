$(document).on('clone', '.field-location', function(e) {
    console.log("location clone");
    if (e.target == this) {
	    argon.fields.clone(this);
    }
});
