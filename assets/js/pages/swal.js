$("#btn-success").click(function() {
    swal(
        'انجام گردید.',
        'عملیات ثبت محصول با موفقیت به پایان رسید.',
        'success');
});

$("#btn-error").click(function() {
    swal(
        'ناموفق',
        'عملیات مورد نظر ناموفق بود، مجددا تلاش کنید.',
        'error');
});

$("#btn-warning").click(function() {
    swal(
        'اخطار',
        'این عملیات برگشت پذیر نیست!',
        'warning');
});

$("#btn-info").click(function() {
    swal(
        '',
        'درخواست شما در حال بررسی می باشد، لطفا شکیبا باشید.',
        'info');
});

$("#btn-question").click(function() {
    swal({
        title: 'آیا اطمینان دارید؟',
        text: "این عملیات برگشت پذیر نیست...",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f44336',
        cancelButtonColor: '#777',
        confirmButtonText: 'بله، حذف شود. '
    }).then(function () {
        swal(
          'انتخاب شما حذف کردن بود.',
          'فایل شما با موفقیت حذف گردید.',
          'success'
        ).catch(swal.noop);
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            swal(
                'لغو گردید',
                'فایل شما همچنان وجود دارد.',
                'error'
            ).catch(swal.noop);;
        }
    }).catch(swal.noop);
});

$("#btn-timer").click(function() {
    swal({
        title: 'بسته شدن خودکار',
        text: 'این پیام به صورت خوکار بعد از 2 ثانیه بسته می شود.',
        timer: 2000
    }).catch(swal.noop);
});

$("#btn-simple").click(function() {
    swal('شماره پیگیری: 12345');
});