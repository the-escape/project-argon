var folders = $('.media-library .folders');

folders.on("changed.jstree", function (e, data) {
    if (data.selected.length > 0) {
	var id = data.selected[0].split('-')[1];

	$('#selectedMediaItem').val('');
	$('#medialibrary .btn-primary').prop('disabled', true);
	loadItems(id);
    }
});

folders
    .children()
    .children()
    .attr('data-jstree', '{"opened":true,"selected":true}');

folders.jstree({
    plugins: [
	'dnd',
	'search'
    ],
    "core" : {
	// so that create works
	"check_callback" : true,
	"multiple": false
    }
});

argon.dialog.medialibrary = function (settings, callback) {
    folders.jstree().deselect_all();
    folders.jstree().select_node(['[data-id=1]']);
    $('#selectedMediaItem').val('');
    $('#medialibrary .btn-primary').prop('disabled', true);
    $('#medialibrary .media-item').removeClass('selected');

    $('#medialibrary').off('hidden.bs.modal');
    $('#medialibrary').on('hidden.bs.modal', function() {
	var value = $('#selectedMediaItem').val();
	if (value) {
	    callback(value);
	}
    });
    $('#medialibrary').modal();
}

function loadItems(id) {
    $.ajax(
	'../../../media/items',
	{
	    data: {
		folderId: id
	    }
	}
    ).done(function(data) {
	$('#current-folder').val(id);

	$('.dz .files').empty();

	for (var i in data) {
	    var file = data[i];

	    var node = $('#preview-template .media-item').clone();

	    node.attr('data-id', file.id);
	    node.find('img').attr('src', file.thumbUrl);
	    node.find('[data-dz-name]').text(file.filename);
	    node.find('[data-dz-size]').html(argon.helpers.filesize(file.filesize));
	    node.find('progress').hide();

	    $('form.dz .files').append(node);
	}

	sortItems();
    });
}

function sortItems() {
    var list = $('.files .media-item').get();
    list.sort(compareItems);
    for (var i = 0; i < list.length; i++) {
	list[i].parentNode.appendChild(list[i]);
    }
}

function compareItems(a, b) {
    var nameA = $(a).find('.filename').text(),
	nameB = $(b).find('.filename').text();
    return nameA.localeCompare(nameB);
}

loadItems(1);

$('.files').on('click', '.media-item', function() {
    $('.files .media-item').removeClass('selected');

    $(this).addClass('selected');

    var id = $(this).attr('data-id');

    $('#selectedMediaItem').val(id);

    $('#medialibrary .btn-primary').prop('disabled', false);
})

$('#medialibrary .btn-primary').on('click', function() {
    $('#medialibrary').modal('hide');
});

$('.field-file').on('click', '.field-add-file', function(e) {
    argon.dialog.medialibrary({}, function(selected) {

	var field = $(e.target).closest('.field');

	$.ajax(
	    '../../../media/items/' +selected
	).done(function(data) {

	    var settings = JSON.parse(field.attr('data-settings'));
	    var fieldName = field.attr('data-name');
	    var files = field.find('.files');

	    if (!settings.multiple) {
		files.empty();
	    }

	    var container = $('<div/>').addClass('input-group sortable-item');

	    $('<input type="hidden" />').attr('name', fieldName).val(data.id).appendTo(container);

	    if (settings.multiple)
	    {
		$('<div/>').addClass('input-group-addon sortable-handle').text("⇅").appendTo(container);
	    }

	    $('<div/>').addClass('file-name form-control').text(data.filename + '.' + data.extension).appendTo(container);

	    $('<div/>').addClass('input-group-addon field-remove').text("\u2715").appendTo(container);

	    files.append(container);


	});
    });
});

$('.field-file').on('click', '.field-remove', function()
{
    console.log('remove');

    var $self = $(this);
    var $inputGroup = $self.parent('.input-group');


    if(argon.dialog.confirm(this))
    {
	$inputGroup.remove();
    }
});
