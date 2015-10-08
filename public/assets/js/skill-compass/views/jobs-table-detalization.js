define([
    "backbone", 
    "backbone.epoxy",
    "skill-compass/views/jobs-table-detalization-item"
], function( Backbone, Epoxy, DetalizationItem ) {

    var view = Backbone.Epoxy.View.extend({
        el: "<div data-bind='collection:$collection' class='json-table-detalization'></div>",
        itemView: DetalizationItem,

        initialize : function( options ) {

        },

        render : function() {   
            this.applyBindings();
            return this;
        }             
        
    });

    return view;
});