function generateLayout(layout, layoutTitle) {
    noty({
        text: layoutTitle,
        type: "alert",
        dismissQueue: true,
        layout: layout,
        timeout: 5000,
        theme: "flat"
    });
}

function generateType(type, text) {
    var notyObj = noty({
        text: text,
        type: type,
        dismissQueue: true,
        timeout: 5000,
        layout: "topRight",
        closeWith: ["click"],
        maxVisible: 10,
        theme: "flat"
    });
    return notyObj;
}

function generateWithButtons() {
    noty({
        text: "آیا ادامه می دهید؟",
        type: "alert",
        dismissQueue: true,
        layout: "center",
        theme: "flat",
        buttons: [
            {addClass: "btn btn-primary btn-round", text: "تائید", onClick: function($noty) {
                    $noty.close();
                    noty({dismissQueue: true, force: true, layout: "center", theme: "flat", text: "شما 'تائید' را انتخاب کردید", type: "success"});
                }
            },
            {addClass: "btn btn-danger btn-round", text: "لغو", onClick: function($noty) {
                    $noty.close();
                    noty({dismissQueue: true, force: true, layout: "center", theme: "flat", text: "شما 'لغو' را انتخاب کردید", type: "error"});
                }
            }
        ]
    });
}


$(".btn-noty").click(function() {
    layout = $(this).attr("data-layout");
    text = $(this).attr("data-text");

    generateLayout(layout, text);
});

$(".btn-noty-type").click(function() {
    type = $(this).attr("data-type");
    generateType(type, "متن پیام در این قسمت قرار می گیرد.");
});

$(".btn-noty-with-buttons").click(function() {
    generateWithButtons();
});
