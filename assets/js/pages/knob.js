$(".knob").knob();


$('.knob-animate').each(function() {
    var $this = $(this);
    var val = $this.attr("rel");
    
    $this.knob();

    $({
        value: 0
    }).animate({
        value: val
    }, {
        duration: 2000,
        easing: 'swing',
        step: function() {
            $this.val(Math.ceil(this.value)).trigger('change');
        }
    })

});