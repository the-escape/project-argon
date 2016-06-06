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





