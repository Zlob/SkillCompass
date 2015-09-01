define([
    "backbone",  
    "backbone.epoxy",
    "text!../templates/skill.html"
], function( Backbone, Epoxy, tpl ) {

    var view = Backbone.Epoxy.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),  
        tagName : 'div',
        className : 'col-md-4',

        initialize : function( options ) {

        },

        render : function() {      
            this.$el.empty().append( this.template() ); 
            this.applyBindings();
            return this;
        }
        
    });

    return view;
});