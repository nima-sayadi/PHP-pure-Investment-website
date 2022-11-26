$.validator.setDefaults({
    highlight: function(element) {
        $(element).closest('.input-group').addClass('has-error').removeClass("has-success");
    },
    unhighlight: function(element) {
        $(element).closest('.input-group').removeClass('has-error').addClass("has-success");
    },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
        if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});

$( "#form" ).validate( {
    rules: {
        old_password: {
            required: true,
            minlength: 5
        },
        password: {
            required: true,
            minlength: 5
        },
        confirm_password: {
            required: true,
            minlength: 5,
            equalTo: "#password"
        }
    },
    messages: {
        old_password: {
                required: "رمز عبور قدیم را وارد نمائید",
                minlength: "رمز عبور قدیم دست کم باید 5 کاراکتر باشد"
        },
        password: {
                required: "رمز عبور را وارد نمائید",
                minlength: "رمز عبور دست کم باید 5 کاراکتر باشد"
        },
        confirm_password: {
                required: "تائید رمزعبور را وارد نمائید",
                minlength: "تائید رمز عبور دست کم باید 5 کاراکتر باشد",
                equalTo: "رمزهای عبور یکسان نیستند"
        }
    }
} );