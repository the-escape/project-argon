var expand = {

};

$(document).on('click', '.field .field-clone', function(e) {
    e.preventDefault();

    $(this).closest('.field').trigger('clone');
})

$(document).on('click', '.field--options-toggle', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $options = $this.closest('.field--options-parent').find(".field--options");
    if ($options.length) {
        $options.slideToggle();
    }
});

argon.fields = {};

argon.fields.clone = function(field) {
    var $field = $(field);
    var $values = $field.find('.field-values').first();

    if (typeof field.dataset.field !== 'undefined')
    {
        var fieldId = parseInt(field.dataset.field, 10);

        if (isNaN(fieldId)) {
            console.error('Field ID missing');
        }

        var postdata = {};

        if (typeof field.dataset.hash !== 'undefined')
        {
            postdata.hash = field.dataset.hash;
        }

        $.post("/admin/clone/" + fieldId, postdata)
            .done(function(data) {

                $values.append($(data));

                // notify all observers
                $.publish('field/clone', {'id': fieldId});
	    })
	    .fail(function() {
			console.error('Clone request failed.');
	    });

    }
};
