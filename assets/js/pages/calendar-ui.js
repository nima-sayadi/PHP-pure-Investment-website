$('.has-datepicker').datepicker({
    defaultDate: new JalaliDate(1365, 0, 1),
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy/mm/dd',
    yearRange: '-70:-1'
});

$(".has-datepicker-now").each(function() {    
    $(this).datepicker({
        'setDate': $(this).val(),
        dateFormat: 'yy/mm/dd'
    });
});
        