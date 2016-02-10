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
