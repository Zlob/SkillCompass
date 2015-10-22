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
        itemView : Backbone.View.extend({
            tagName: "span",
            className: "label label-success json-table-item-label",
            initialize: function() {
                this.$el.text( this.model.get("name") );
            }
        }),


        initialize : function( options ) {
            this.collection = new Backbone.Collection(this.model.get('have_skills'));
            this.$el.append( this.template() ); 
            this.applyBindings();
        },
        

        render : function() {      



            return this;
        }             
        
    });

    return view;
});