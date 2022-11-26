// Initialize persian datepicker
persianDate.toLocale('en');
$(".has-persian-datepicker").pDatepicker({
    format: "YYYY/MM/DD",
    observer: true,
    autoClose: true,
    navigator: {text: {btnNextText: "«", btnPrevText: "»"}},
    onSelect: function(unix) {
        var date = new persianDate(unix).toLocale("en").format("YYYY/MM/DD");
        console.log(date);
    }
});

$(".has-persian-datepicker-long").pDatepicker({
    format: "dddd, DD MMMM YYYY",
    autoClose: true,
});

$(".has-persian-datepicker-unix").pDatepicker({
    format: "DD MMMM YYYY",
    autoClose: true,
    altField: '#alt-field'
});

$(".has-persian-datepicker-year-mode").pDatepicker({
    format: "YYYY/MM/DD",
    observer: true,
    autoClose: true,
    viewMode: "year",
    initialValue: false,
});

$(".has-time-picker").pDatepicker({
    onlyTimePicker: true,
    observer: true,
    format: "HH:mm:ss",
});



$(".has-gregorian-datepicker").pDatepicker({
    format: "YYYY-MM-DD",
    observer: true,
    autoClose: true,
    calendarType: "gregorian",
    navigator: {text: {btnNextText: "«", btnPrevText: "»"}},
    onSelect: function(unix) {
        var date = new persianDate(unix).toLocale("en").format("YYYY-MM-DD");
        console.log(date);
    }
});


// Initialize from-to type
var to, from;
to = $(".persian-datepicker-to").pDatepicker({
    format: "YYYY/MM/DD",
    observer: true,
    initialValue: false,
    autoClose: true,
    onSelect: function (unix) {
        to.touched = true;
        if (from && from.options && from.options.maxDate != unix) {
            var cachedValue = from.getState().selected.unixDate;
            from.options = {maxDate: unix};
            if (from.touched) {
                from.setDate(cachedValue);
            }
        }
    }
});
from = $(".persian-datepicker-from").pDatepicker({
    format: "YYYY/MM/DD",
    observer: true,
    initialValue: false,
    autoClose: true,
    onSelect: function (unix) {
        console.log("now");
        from.touched = true;
        if (to && to.options && to.options.minDate != unix) {
            var cachedValue = to.getState().selected.unixDate;
            to.options = {minDate: unix};
            if (to.touched) {
                to.setDate(cachedValue);
            }
        }
    }
});