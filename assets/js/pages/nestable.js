// Nestable in general mode
$(".nestable").nestable({
    group: 1
});

// Nestable for curve mode
$(".nestable-list.curve").nestable({
    group: 1,
    dragClass: "dd-dragel curve"
});

// Nestable for round mode
$(".nestable-list.round").nestable({
    group: 1,
    dragClass: "dd-dragel round"
});

// Nestable via output preview
$("#nestable-via-output").nestable().on("change", updateOutput);
updateOutput($("#nestable-via-output").data("output", $("#nestable-output")));

function updateOutput(e) {
    var list = e.length ? e : $(e.target),
        output = list.data("output");
    if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable("serialize")));
    } else {
        output.val("JSON browser support required.");
    }
}