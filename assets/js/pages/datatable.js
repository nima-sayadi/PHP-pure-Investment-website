var tableMain = $('#data-table').DataTable({
    "columnDefs": [{
        "targets": 4,
        "orderable": false
    }],
    "pageLength": 25
});

$(window).on( 'resize', function () {
    $('#data-table').css("width", "100%");
} );