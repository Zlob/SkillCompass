define([
    "backbone", 
    "backbone.epoxy",
    "skill-compass/views/jobs-table-item-label",
    "skill-compass/views/jobs-table-detalization",
    "text!../templates/jobs-table-item.html"
], function( Backbone, Epoxy, Label, Detalization, tpl ) {

    var view = Backbone.Epoxy.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),   
        className: "jobs-table-item",
        itemView: Label,
        
        events: {
            'click [data-eid="item-info"]' : "toggleDetalization"
        },

        initialize : function( options ) {
            this.collection = new Backbone.Collection(this.model.get('additional_skills'));
            this.detalization = options.detalization;
            this.showDetalization = false;
        },

        render : function() {      
            this.$el.empty().append( this.template() ); 
            this.applyBindings();
            return this;
        },
        
        toggleDetalization : function() {
            this.showDetalization = !this.showDetalization;
            if(this.showDetalization){
                console.log('toggle');
                var  detalization= new Detalization({collection : this.detalization}); 
                this.$('[data-eid="item-detalization"]').empty().append(detalization.render().$el);  
            }
            else{
                this.$('[data-eid="item-detalization"]').empty();  
            }
        }
    });
    


    return view;
});