require( [         
    "jquery"
         ], function( ) {   
    
    $(".header-compass-img").bind("webkitAnimationEnd mozAnimationEnd animationEnd", function(){
        $(this).removeClass("animated")  
    });

    $(".header-compass-img").hover(function(){
        if(!$(this).hasClass("animated")){
            $(this).addClass("animated");
        }                
    });         

});