require( [ 
    "skill-compass/views/main",          
    "skill-compass/views/area", 
    "skill-compass/collections/groups",
    "skill-compass/collections/skills",    
    "bootstrap"
         ], function( MainView, AreaView, Groups, Skills ) { 
    
    window.app = {};
    app.groups = new Groups();

    app.skills = new Skills();

    this.promisArr = [
        app.groups.fetch(),
        app.skills.fetch()
    ];   
    
    var self = this;
    $.when.apply($, this.promisArr).then( function() {
        var areaView = new AreaView();    
        $("#area-content").append( areaView.render().$el );

        var mainView = new MainView();    
        $("#main-content").append( mainView.render().$el );             
    });
    

    
});