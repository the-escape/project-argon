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
            return parseInt(nodeIdString.split('-')[1], 10);
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

$('.preview-page').on('click', function(e) {
    e.preventDefault();
    $form = $(this).parent('form');
    $data = $form.serializeArray();
    $data.push({ name: 'preview_page', value: true });

    $.ajax({
        type: 'POST',
        url: $form.attr('action'),
        data: $.param($data),
        success: function(url, status) {
            if (status === 'success') {
                $.fancybox.open({
                    href: url,
                    type: 'iframe',
                    autoSize: false,
                    height: '90%',
                    width: '90%'
                });
            } else {
                // TODO: Display error?
            }
        }
    });
});

$('.save-revision').on('click', function(e) {
    e.preventDefault();
    $form = $(this).parent('form');
    $form.attr('action', $(this).data('form-action'));
    $form.submit();
});

$('#pageEditForm').submit(function(){

});