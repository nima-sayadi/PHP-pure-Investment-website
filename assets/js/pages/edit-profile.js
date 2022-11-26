$(".select2.round").select2({
    rtl: true,
    containerCssClass: "round",
    width: "100%"
});

$(".iban").mask("IR00 0000 0000 0000 0000 00", {
    placeholder: "IR__ ____ ____ ____ ____ __"
});

$(".card").mask("0000 0000 0000 0000", {
    placeholder: "____ ____ ____ ____"
});

$(".mobile").mask("ZN00 000 0000", {
    placeholder: "09__ ___ ____",
    translation: {
        'Z': {
            pattern: /0/, optional: false
        },
        'N': {
            pattern: /9/, optional: false
        },
    }
});