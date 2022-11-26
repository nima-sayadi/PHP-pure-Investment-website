$(".summernote").summernote({
    tooltip: false,
    airMode: false,
    direction: "rtl",
    fontNames: ['Tahoma', 'IranSans', 'B Nazanin', 'B Yekan', 'Parastoo', 'Arial' ],
    fontNamesIgnoreCheck: ['Tahoma', 'B Nazanin', 'B Yekan', 'Parastoo', 'Arial', 'IranSans' ]
});

$(".summernote-ltr").summernote({
    tooltip: false,
    airMode: false,
    direction: "ltr",
    fontNames: ['Tahoma', 'Arial'],
});

// Temporary trick for dropdown in bootstrap5
var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl)
});

