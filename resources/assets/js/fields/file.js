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
        argon.root() + '/media/items',
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
});

$('#medialibrary .btn-primary').on('click', function() {
    $('#medialibrary').modal('hide');
});

$(document).on('click', '.field-file .field-add-file', function(e) {
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

            if (settings.multiple) {
                $('<div/>').addClass('input-group-addon sortable-handle').text("⇅").appendTo(container);
            }

            $('<div/>').addClass('file-name form-control').text(data.filename + '.' + data.extension).appendTo(container);

            $('<div/>').addClass('input-group-addon field-remove').text("\u2715").appendTo(container);

            files.append(container);
        });
    });
});

$(document).on('click', '.field-image .field-add-file', function(e) {
    argon.dialog.medialibrary({}, function(selected) {

        var field = $(e.target).closest('.field');

        $.ajax(
            '../../../media/items/' +selected
        ).done(function(data) {
            var guid = new Date().valueOf();
            var settings = JSON.parse(field.attr('data-settings'));
            var fieldName = field.attr('data-name')+'['+guid+']';
            var files = field.find('.files');

            if (!settings.multiple) {
               files.empty();
            }

            var container = $('<div/>').addClass('input-group sortable-item');

            if (settings.multiple) {
                $('<div/>').addClass('input-group-addon sortable-handle').text("⇅").appendTo(container);
            }

            var $content = $('<div/>').addClass('form-control').appendTo(container);

            $('<input type="hidden" />').attr('name', fieldName+'[id]').val(data.id).appendTo($content);
            $('<input type="hidden" />').attr('name', fieldName+'[width]').val(data.meta.width).appendTo($content);
            $('<input type="hidden" />').attr('name', fieldName+'[height]').val(data.meta.height).appendTo($content);

            var $preview = $('<div/>').addClass('media-preview').appendTo($content);
            $('<img/>').attr('src', data.url).appendTo($preview);

            $('<div/>').addClass('file-name').text('Name: ' + data.filename + '.' + data.extension).appendTo($content);
            $('<div/>').addClass('file-name').text('Size: ' + data.filesize_formatted).appendTo($content);
            $('<div/>').addClass('file-name').text('Dimensions: ' + data.meta.width + ' x ' + data.meta.height + ' pixels').appendTo($content);

            $('<input type="text"/>').addClass('form-control inline').attr({'name': fieldName+'[alt]', 'placeholder': "Alt text"}).appendTo($content);

            $('<div/>').addClass('input-group-addon field-remove').text("\u2715").appendTo(container);

            files.append(container);
            files.find('.hdnImageId').remove();
        });
    });
});

// Used master blade version, as it doesn't allow last item to be deleted. This one does.
//$(document).on('click', '.field-media .field-remove', function(e) {
//    var $self = $(this);
//    var $inputGroup = $self.parent('.input-group');
//
//    if (argon.dialog.confirm(this)) {
//        $inputGroup.remove();
//    }
//});
