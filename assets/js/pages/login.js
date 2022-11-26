$(document).ready(function(){
    $.validator.setDefaults({
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error').removeClass("has-success");
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass("has-success");
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

    $("#form").validate(); 
});