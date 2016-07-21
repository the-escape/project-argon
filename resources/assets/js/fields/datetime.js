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




