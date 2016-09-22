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
        },

        getUrlParam: function(paramName) {
            var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam) ;
            return (match && match.length > 1) ? match[1] : '' ;
        },

        // JSTree helper
        getIdFromNodeIdString: function(nodeIdString) {
            return nodeIdString.split('-')[1];
        }
    },

    // Observer pattern to allow event subscriptions
    // Very useful for async requests
    /* USAGE:

    $.subscribe('field/clone', function (e, data) {
        if(window.console) console.log(data);
    });

    $.publish('field/clone', {'id':field});

    */
    events: (function ($) {
        var o = $({});
        $.each({
            trigger: 'publish',
            on: 'subscribe',
            off: 'unsubscribe'
        }, function (key, val) {
            jQuery[val] = function () {
                o[key].apply(o, arguments);
            };
        });
    }(jQuery)),

    root: function() {
        return $('link[rel=adminroot]').attr('href');
    }

};

$(document).on('click', '.field-remove', function(e) {
    var $self = $(this);
    var $inputGroup = $self.parent('.input-group');

    if (argon.dialog.confirm(this)) {
        $inputGroup.remove();
    }
});

$(document).on('change', '.field-poputale', function(e) {
    var $this = $(this);
    var value = $this.val();
    if (value.replace(/\s*/g, '') != '') {
        var $target = $($this.data('target'));
        if ($target.length) {
            $target.val(value);
        }
    }
});

$('.preview').on('click', function(e) {
    e.preventDefault();
    $form = $(this).parent('form');
    $data = $form.serializeArray();
    $data.push({ name: 'preview', value: true });

    $.ajax({
        type: 'POST',
        url: $form.attr('action'),
        data: $.param($data),
        success: function(url) {
            console.log(url);
            $.fancybox.open({
                href: url,
                type: 'iframe',
                autoSize: false,
                height: '80%',
                width: '80%'
            });
        }
    });
});

var expand = {

};

$(document).on('click', '.field .field-clone', function(e) {
    e.preventDefault();

    $(this).closest('.field').trigger('clone');
})

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

$(document).on('click', '.boolean-on', function(){
    $(this).siblings('.boolean-radio-on').trigger( "click" );
});

$(document).on('click', '.boolean-off', function(){
    $(this).siblings('.boolean-radio-off').trigger( "click" );
});
$(document).on('clone', '.field-combo', function(e) {
    if (e.target == this) {
	    argon.fields.clone(this);
    }
});

/*
Revealing Module Pattern
*/
var datetime = (function () {

    function init()
    {
        build();
        subscribe();
    }

    function build($fieldDatetime)
    {
        var $collection = $fieldDatetime || $('.field-datetime');

        $collection.each(function() {
            var field = this;
            var $calendar_field = $('.calendar', field);
            var date = $calendar_field.attr('data-datetime');

            $calendar_field.datepicker({
                format: "yyyy-mm-dd",
                clearBtn: true
            });
            $calendar_field.datepicker('setDates', date);
            $calendar_field.on('changeDate', function() {
                updateValue(field);
            });

            if ($(field).attr('data-time-enabled') == 'true') {
                $('.hours, .minutes, .seconds', field).on('change', function() {
                    updateValue(field);
                });
            }
        });

        $('.field-datetime').on('focus', '.value', function(e) {
            $('.calendar').removeClass('active');
            var $fieldDateime = $(this).parents('.field-datetime');
            $fieldDateime.find('.calendar').addClass('active');
        });

        $('.field-datetime').keyup(function(e) {
            if (e.keyCode == 27) { // escape key maps to keycode `27`
                $('.calendar').removeClass('active');
            }
        });
    }

    function updateValue(field)
    {
        var time, datetime = [];
        var $calendar = $('.calendar', field);
        var date = $calendar.datepicker('getFormattedDate');
        $calendar.removeClass('active');
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

    // subscribe for notifications, see argon.events - observer pattern
    function subscribe()
    {
        $.subscribe('field/clone', function (e, data) {
            build( $('.field-'+data.id).find('.field-datetime') );
        });
    }

    return {
        init: init
    };

})();

datetime.init();





var folders = $('.media-library .folders');

folders.on("changed.jstree", function (e, data) {
    if (data.selected.length > 0) {
        var id = data.selected[0].split('-')[1];

        $('#selectedMediaItem').val('');
        $('#medialibrary .btn-submit').prop('disabled', true);
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
    $('#medialibrary .btn-submit').prop('disabled', true);
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

    $('#medialibrary .btn-submit').prop('disabled', false);
});

$('#medialibrary .btn-submit').on('click', function() {
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

$('.btn-list').click(function() {
    $('.dz .files').toggleClass('list');
});

//$(document).on('click', '.field-media .field-remove', function(e) {
//    var $self = $(this);
//    var $inputGroup = $self.parent('.input-group');
//
//    if (argon.dialog.confirm(this)) {
//        $inputGroup.remove();
//    }
//});

$(document).on('clone', '.field-select', function(e) {
    console.log("select clone");
    if (e.target == this) {
	    argon.fields.clone(this);

    }
});

$(document).on('clone', '.field-text', function(e) {
    if (e.target == this) {
	    argon.fields.clone(this);
    }
});

var WYSIWYG = {

    getToolbarOptions: function(el) {
        return (typeof el.dataset.wysiwyg_toolbar !== 'undefined')
            ? [el.dataset.wysiwyg_toolbar.split(',')]
            : [CKEDITOR.config.default_toolbar];
    },

    getExtraAllowedContent: function(el) {
        return (typeof el.dataset.wysiwyg_extraAllowedContent !== 'undefined')
            ? [el.dataset.wysiwyg_extraAllowedContent.split(',')]
            : [CKEDITOR.config.default_extraAllowedContent];
    },

    getFormatTagsOptions: function(el) {
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
    },

    getHeight: function(el) {
        if (typeof el.dataset.wysiwyg_height !== 'undefined')
        {
            var wysiwyg_height = parseInt(el.dataset.wysiwyg_height, 10);

            if (!isNaN(wysiwyg_height))
            {
                return wysiwyg_height;
            }
        }

        return CKEDITOR.config.default_height;
    },

    onClone: function(data) {

        var editors_present = $('.field-'+data.id).find('.ckeditor');

        if (editors_present && editors_present.length) {
            // force all wysiwyg fields to populate native equivalents and remove before cloning
            for (var i in CKEDITOR.instances)
            {
                CKEDITOR.instances[i].updateElement();
                CKEDITOR.instances[i].destroy();
            }
            $('.ckeditor').each(function(i, el)
            {
                CKEDITOR.config.toolbar = WYSIWYG.getToolbarOptions(el);
                CKEDITOR.config.extraAllowedContent = WYSIWYG.getExtraAllowedContent(el);
                CKEDITOR.config.height = WYSIWYG.getHeight(el);
                CKEDITOR.config.format_tags = WYSIWYG.getFormatTagsOptions(el);
                CKEDITOR.config.on = {
                    'instanceReady': function(e){}
                };
                CKEDITOR.replace(el, CKEDITOR.config); // initialize manually with custom config
            });
        }
    },

    init: function(el) {
        CKEDITOR.config.filebrowserBrowseUrl = '/admin/media/browser';
        // CKEDITOR: Custom toolbar setup and initialization
        CKEDITOR.config.fontSize_sizes = '12px;13px;14px;16px;18px;20px;22px;24px;26px;27px;28px;30px;32px;';
        CKEDITOR.replaceClass = null; // disable auto initialization by class

        CKEDITOR.config.default_height = 150;
        CKEDITOR.config.default_format_tags = 'p;h1;h2;h3;h4;h5;h6';
        CKEDITOR.config.default_toolbar = ['Source', 'Format', 'FontSize', 'Bold','Italic', 'Blockquote', 'NumberedList','BulletedList', 'Image', 'Table', 'Link', 'Unlink'];
        CKEDITOR.config.default_extraAllowedContent = 'iframe[*]';

        CKEDITOR.config.toolbar = WYSIWYG.getToolbarOptions(el);
        CKEDITOR.config.extraAllowedContent = WYSIWYG.getExtraAllowedContent(el);
        CKEDITOR.config.height = WYSIWYG.getHeight(el);
        CKEDITOR.config.format_tags = WYSIWYG.getFormatTagsOptions(el);
        CKEDITOR.replace(el, CKEDITOR.config); // initialize manually with custom config

        // this way handle ckeditor error class highlighting
        var $el = $(el);
        if ($el.hasClass('error')) {
            $el.parent().addClass('error');
        }
    }

};

$('.ckeditor').each(function(i, el) {
    WYSIWYG.init(el);
});

$.subscribe('field/clone', function (e, data) {
    WYSIWYG.onClone( data );
});

$(document).on('clone', '.field-location', function(e) {
    console.log("location clone");
    if (e.target == this) {
	    argon.fields.clone(this);
    }
});

$('.add-localisation').click(function(e) {
    e.preventDefault();

    $('#newLocalisationModal').modal();
});

//# sourceMappingURL=argon.js.map
