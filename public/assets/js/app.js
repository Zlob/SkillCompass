require( [ 
    "skill-compass/views/main",          
    "skill-compass/views/area",   
    "bootstrap"
         ], function( MainView, AreaView ) {   
    
        var areaView = new AreaView();    
        $("#area-content").append( areaView.render().$el );

        var mainView = new MainView();    
        $("#main-content").append( mainView.render().$el );             

    
});