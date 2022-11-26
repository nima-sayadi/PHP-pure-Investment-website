$(".select2").select2({
    rtl: true
});
$(".select2.round").select2({
    rtl: true,
    containerCssClass: "round"
});
$(".select2.curve").select2({
    rtl: true,
    containerCssClass: "curve"
});

$(".allow-cancel").select2({
    rtl: true,
    allowClear: true,
    placeholder: {
        id: "",
        placeholder: "..."
    }
});
        