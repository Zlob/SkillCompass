define([
    "backbone",    
    "text!../templates/error.html"
], function( Backbone, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),    

        initialize : function( options ) {
        },

        render : function() {      
            this.$el.empty().append( this.template() ); 
            return this;
        },
        
        show : function() {
            $('#step-content').animate({opacity : 100}); 
        }
        
    });

    return view;
});