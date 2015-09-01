define([
    "backbone"
], function( Backbone ) {

    var collection = Backbone.Collection.extend({

        url : function() {
            return "/api/skill";
        },

        initialize : function( options ) {
            
        }

    });

    return collection;
});