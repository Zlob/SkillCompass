define([
    "backbone",  
    "skill-compass/views/group",   
    "text!../templates/selection.html"
], function( Backbone, Group, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),       

        initialize : function( options ) {

        },

        render : function() {      
            self = this;
            self.$el.empty().append( self.template() ); 
            app.groups.each( function( m ) {
                var groupView = new Group({
                    model : m
                });
                self.$("[data-eid=groups]").append( groupView.render().$el );
            } );

            return this;
        }
        
    });

    return view;
});