$( function() {
    var datepickerBaseOptions = {
        format: "yyyymmdd",
        endDate: new Date(),
        maxViewMode: 0,
        language: "de",
        todayHighlight: true
    };

    var fromDatePicker = $('#fromDatePicker');
    fromDatePicker.datepicker(datepickerBaseOptions);
    fromDatePicker.on('changeDate', function() {
        $('#fromDate').val(
            fromDatePicker.datepicker('getFormattedDate')
        );
    });

    var toDatePicker = $('#toDatePicker');
    toDatePicker.datepicker(datepickerBaseOptions);
    toDatePicker.on('changeDate', function() {
        $('#toDate').val(
            toDatePicker.datepicker('getFormattedDate')
        );
    });
} );