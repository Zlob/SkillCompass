define([
    "backbone", 
], function( Backbone ) {

    var view = Backbone.View.extend({
        tagName: "span",
        className: "label label-default json-table-item-label light-color",
        initialize: function() {
            this.$el.text( this.model.get("name") );
        }
    });   

    return view;
});    

