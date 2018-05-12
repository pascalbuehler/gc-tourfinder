$(function() {
    /* DATEPICKER */
    var datepickerBaseOptions = {
        format: "yyyymmdd",
        endDate: new Date(),
        maxViewMode: 0,
        language: "de",
        todayHighlight: true
    };
    $('.datepicker-container').each(function() {
        var hiddenField = $(this).find('input[type="hidden"]');
        $(this).datepicker(datepickerBaseOptions);
        $(this).on('changeDate', function() {
            hiddenField.val(
                $(this).datepicker('getFormattedDate')
            );
        });
    });
});