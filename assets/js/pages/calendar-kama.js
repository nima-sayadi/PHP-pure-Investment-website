// Initialize Kama datepicker 
var datePickerOptions = {
    placeholder: "روز / ماه / سال",
    twodigit: true,
    closeAfterSelect: true,
    nextButtonIcon: "fa fa-arrow-right",
    previousButtonIcon: "fa fa-arrow-left",
    buttonsColor: "gray",
    markToday: true,
    markHolidays: true,
    highlightSelectedDay: true,
    sync: true
};
kamaDatepicker("kama-datepicker", datePickerOptions);


var datePickerOptionsEmpty = {
    placeholder: "روز / ماه / سال",
    twodigit: true,
    closeAfterSelect: true,
    nextButtonIcon: "fa fa-arrow-right",
    previousButtonIcon: "fa fa-arrow-left",
    buttonsColor: "gray",
    markToday: false,
    markHolidays: true,
    highlightSelectedDay: true,
    sync: true
};
kamaDatepicker("kama-datepicker-empty", datePickerOptionsEmpty);