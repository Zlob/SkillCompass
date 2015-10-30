require( [         
    "skill-compass/views/area",
    "skill-compass/views/selection",
    "skill-compass/views/statistic",  
    "skill-compass/views/jobs-table",  
    "skill-compass/views/navigation",
    "skill-compass/views/error",
    "skill-compass/collections/groups",
    "skill-compass/collections/skills",
    
    "bootstrap"
         ], function( AreaView, SelectionView, StatisticView, JobsTableView, NavigationView, ErrorView, Groups, Skills ) {   
    
    var areaView = new AreaView();    
    
    var Router = Backbone.Router.extend({
        
        initialize: function(options) {
            this.bindAnimation();

            this.groups = new Groups();
            
            this.skills = new Skills();
           

            this.promisArr = [
                this.groups.fetch(),
                this.skills.fetch()
            ];   
            
            var self = this;
            $.when.apply($, this.promisArr).then( function() { 
                self.navigation = new NavigationView();
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
            var routFunction = this._routes[ route ] ;
            this.navigation.setActiveTab( routFunction );
            var self = this;
            
            var stepView = this[routFunction]().render();          
            
            $('#step-content').animate({ opacity: 0 }, function() {
                $('#step-content').empty().append( stepView.$el );  
                stepView.show();           
            })
        },


        selection: function(callback) {
            return new SelectionView( {groups : this.groups, skills : this.skills} );
        },
        
        charts : function(callback) {
            if(this._checkSkillsSelected()){
                return new StatisticView({skills : this.skills});
            }
            else{
                return this.error();
            }

        },
        
        jobs : function(callback) {
            if(this._checkSkillsSelected()){
                return new JobsTableView({skills : this.skills});
            }
            else{
                return this.error();
            }  

        },
        
        error  : function(){
            return new ErrorView();
        },
        
        _checkSkillsSelected : function(){
            return this.skills.some(function(model){
                return model.get('checked') === true;
            });
        },
        
        bindAnimation : function() {
            $(".header-compass-img").bind("webkitAnimationEnd mozAnimationEnd animationEnd", function(){
                $(this).removeClass("animated")  
            });

            $(".header-compass-img").hover(function(){
                if(!$(this).hasClass("animated")){
                    $(this).addClass("animated");
                }                
            });
        },
        

         
    });
    
    var router = new Router();     

});