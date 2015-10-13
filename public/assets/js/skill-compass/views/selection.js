define([
    "backbone",  
    "skill-compass/views/group",   
    "text!../templates/selection.html"
], function( Backbone, Group, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),       

        initialize : function( options ) {
            this.groups = options.groups;
            this.skills = options.skills;

        },

        render : function() {      
            var self = this;
            self.$el.empty().append( self.template() ); 
            this.groups.each( function( m ) {
                var groupView = new Group({
                    model : m,
                    collection : self.skills
                });
                self.$("[data-eid=groups]").append( groupView.render().$el );
            } );

            return this;
        },
        
        show : function() {
            $('#step-content').fadeIn();
        }
        
        
        
    });

    return view;
});