define([
    "backbone",    
    "text!../templates/navigation.html"
], function( Backbone, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),    
        el: '#navigation',

        initialize : function( options ) {
            this.render();
        },

        render : function() {      
            this.$el.empty().append( this.template() ); 
            return this;
        },
        
        
        setActiveTab : function(tab){
            this.clearActive();
            var tabName = '.' + tab;
            this.$(tabName).addClass('active');
        },
                
        clearActive : function() {
            this.$('.active').removeClass('active');
        }
        
        
        
    });

    return view;
});