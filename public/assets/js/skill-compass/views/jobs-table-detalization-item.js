define([
    "backbone", 
    "backbone.epoxy",
    "text!../templates/jobs-table-detalization-item.html"
], function( Backbone, Epoxy, tpl ) {

    var view = Backbone.Epoxy.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),     
        tagName: 'div',
        className: 'detalization-item row',


        initialize : function( options ) {
            this.$el.append( this.template() ); 
            this.applyBindings();
        },
        

        render : function() {      



            return this;
        }             
        
    });

    return view;
});