require( [         
    "skill-compass/views/area",
    "skill-compass/views/selection",
    "skill-compass/views/statistic",  
    "skill-compass/views/jobs-table",  
    "skill-compass/views/navigation",
    "skill-compass/collections/groups",
    "skill-compass/collections/skills",
    
    "bootstrap"
         ], function( AreaView, SelectionView, StatisticView, JobsTableView, Navigation, Groups, Skills ) {   
    
    var areaView = new AreaView();    
    $("#area-content").append( areaView.render().$el );
    

    
    var Workspace = Backbone.Router.extend({
        
        initialize: function(options) {
            this.navigation = new Navigation();
            this.groups = new Groups();

            this.skills = new Skills();

            this.promisArr = [
                this.groups.fetch(),
                this.skills.fetch()
            ];   
            
            var self = this;
            $.when.apply($, this.promisArr).then( function() {                
                var storedSelection = new Backbone.Collection(JSON.parse(localStorage.getItem('selection'))); 
                self.skills.each(function(skill) {
                    var storedSkill = storedSelection.get(skill.get('id'));
                    if( storedSkill ) {
                        skill.set('checked', storedSkill.get('checked'));    
                    }
                    else{
                        skill.set('checked', false);    
                    }
                    
                    skill.on('change', self.saveSelection, self);
                })
                Backbone.history.start()
            }); 
        },
        
        saveSelection: function (){
            localStorage.setItem('selection',  JSON.stringify(this.skills));
        },
        
        routes: {
            "*any"             : "_commutator"
        },
        
        _routes: {
            ""          : "selection",
            "selection" : "selection",  
            "jobs"      : "jobs",
            "charts"    : "charts"
        },

        _commutator : function() {
            var route = Backbone.history.getFragment();
            this.navigation.setActiveTab( route );
            var self = this;
            
            $('#step-content').fadeOut(function(){
                self[ self._routes[ route ] ]( function() {
                    $('#step-content').fadeIn();
                } );
            })
        },


        selection: function(callback) {
            var selectionView = new SelectionView( {groups : this.groups, skills : this.skills} );
            $('#step-content').empty().append( selectionView.render().$el );   
            callback();

        },
        
        charts : function(callback) {
            var statistic = new StatisticView({skills : this.skills});
            $('#step-content').empty().append( statistic.render().$el );  
            statistic.show();  
            callback();
        },
        
        jobs : function(callback) {
            var jobsTable = new JobsTableView({skills : this.skills});
            $('#step-content').empty().append( jobsTable.render().$el );  
            callback();
        },
        
        
         
    });
    
    var router = new Workspace();     

});