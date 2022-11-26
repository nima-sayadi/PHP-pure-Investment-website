$("#txt-search").keyup(function(){
    var key = $(this).val().trim();
    if(key){
        $(".icon-box, .alert").css("display", "none");
        $(".icon-box .item").each(function(){
            if($(this).text().indexOf(key)>=0){
                $(this).parent().css("display", "block");
            }
        });
        
    }else{
        $(".icon-box, .alert").css("display", "block");
    }
});