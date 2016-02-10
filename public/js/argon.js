var argon = {
    dialog: {
        alert: function (message, callback) {
            alert(message);

            if (callback) {
                callback();
            }
        },

        prompt: function (message, callback) {
            var result = prompt(message);

            callback(result);
        },
        // Generic js confirm window wrapper.
        // To show confirm window, just add confirm class to html elements that should trigger confirm window.
        // To show custom text either pass it as a second parameter (text) or add data-confirm attribute on html element.
        confirm: function(el, text) {
            if (!text) {
                // Get value of data-confirm attribute if present or use default confirm text.
                text = el.dataset.confirm || "Are you sure you want to continue?";
                text = text.replace(/\\n/g,"\n");// respect escaped newlines
            }
            return confirm(text);
        }
    },

    helpers: {
        filesize: function(size) {
            var cutoff, i, selectedSize, selectedUnit, unit, units, _i, _len;
            selectedSize = 0;
            selectedUnit = "b";
            if (size > 0) {
                units = ['TB', 'GB', 'MB', 'KB', 'b'];
                for (i = _i = 0, _len = units.length; _i < _len; i = ++_i) {
                    unit = units[i];
                    cutoff = Math.pow(1000, 4 - i) / 10;
                    if (size >= cutoff) {
                        selectedSize = size / Math.pow(1000, 4 - i);
                        selectedUnit = unit;
                        break;
                    }
                }
                selectedSize = Math.round(10 * selectedSize) / 10;
            }
            return "<strong>" + selectedSize + "</strong>" + selectedUnit;
        }
    }
}


var expand = {

};

//if ($('.field-boolean').length > 0) {
//
//
//    $('.field-boolean .boolean-on').click(function() {
//        var field = $(this).closest('.field-boolean');
//
//        field.find('.boolean-radio-on').click();
//    });
//
//    $('.field-boolean .boolean-off').click(function() {
//        var field = $(this).closest('.field-boolean');
//
//        field.find('.boolean-radio-off').click();
//    })
//
//}

$(document).on('click', '.boolean-on', function(){
    if(window.console) console.log($(this).siblings('.boolean-radio-on'));
    $(this).siblings('.boolean-radio-on').click();
});

$(document).on('click', '.boolean-off', function(){
    if(window.console) console.log($(this).siblings('.boolean-radio-off'));
    $(this).siblings('.boolean-radio-off').click();
});

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

$('.field-datetime').each(function() {
    var field = this;
    var date = $('.calendar', field).attr('data-datetime');

    $('.calendar', field).datepicker({
        format: "yyyy-mm-dd",
        clearBtn: true
    });
    $('.calendar', field).datepicker('setDates', date);
    $('.calendar', field).on('changeDate', function() {
        updateValue(field);
    });

    if ($(field).attr('data-time-enabled') == 'true') {
        $('.hours, .minutes, .seconds', field).on('change', function() {
            updateValue(field);
        });
    }
});


function updateValue(field)
{
    var time, datetime = [];
    var date = $('.calendar', field).datepicker('getFormattedDate');

    if (date == "") {
        $('.value', field).val('');
        return;
    }

    if ($(field).attr('data-time-enabled') == 'true') {
        var hours = $('.hours', field).val();
        var minutes = $('.minutes', field).val();
        var seconds = "00";

        if ($(field).attr('data-seconds-enabled') == 'true') {
            seconds = $('.seconds', field).val();
        }

        time = hours + ":" + minutes + ":" + seconds;
    }
    else {
        time = "00:00:00";
    }

    $('.value', field).val(date + " " + time);

}

// CKEDITOR: Custom toolbar setup and initialization
CKEDITOR.config.fontSize_sizes = '12px;13px;14px;16px;18px;20px;22px;24px;26px;27px;28px;30px;32px;';
CKEDITOR.replaceClass = null; // disable auto initialization by class

CKEDITOR.config.default_height = 150;
CKEDITOR.config.default_format_tags = 'p;h1;h2;h3;h4;h5;h6';
CKEDITOR.config.default_toolbar = ['Source', 'Format', 'FontSize', 'Bold','Italic', 'Blockquote', 'NumberedList','BulletedList', 'Image', 'Table', 'Link', 'Unlink'];

$('.ckeditor').each(function(i, el)
{
    CKEDITOR.config.toolbar = getWysiwygToolbarOptions(el);
    CKEDITOR.config.height = getWysiwygHeight(el);
    CKEDITOR.config.format_tags = getWysiwygFormatTagsOptions(el);
    CKEDITOR.replace(el, CKEDITOR.config); // initialize manually with custom config

    // this way handle ckeditor error class highlighting
    var $el = $(el);
    if ($el.hasClass('error'))
    {
        $el.parent().addClass('error');
    }
});

function getWysiwygToolbarOptions(el)
{
    return (typeof el.dataset.wysiwyg_toolbar !== 'undefined')
        ? [el.dataset.wysiwyg_toolbar.split(',')]
        : [CKEDITOR.config.default_toolbar];
}

function getWysiwygFormatTagsOptions(el)
{
    // Wysiwyg enabless 'p' tag regardless of settings, It will not show it in a Format dropdown when not explicitly enebled, but will allow within editor regardless...
    // Just make it permanently enabled. Simples! ?>

    if (typeof el.dataset.wysiwyg_format_tags !== 'undefined')
    {
        if (el.dataset.wysiwyg_format_tags)
        {
            return 'p;' + el.dataset.wysiwyg_format_tags;
        }
        else
        {
            return 'p';
        }
    }
    else
    {
        return CKEDITOR.config.default_format_tags;
    }
}

function getWysiwygHeight(el)
{
    if (typeof el.dataset.wysiwyg_height !== 'undefined')
    {
        var wysiwyg_height = parseInt(el.dataset.wysiwyg_height, 10);

        if (!isNaN(wysiwyg_height))
        {
            return wysiwyg_height;
        }
    }

    return CKEDITOR.config.default_height;
}

$('.add-localisation').click(function(e) {
    e.preventDefault();

    $('#newLocalisationModal').modal();
});

//# sourceMappingURL=argon.js.map
