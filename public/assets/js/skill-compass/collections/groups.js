define([
    "backbone"
], function( Backbone ) {

    var collection = Backbone.Collection.extend({

        url : function() {
            return "/api/group";
        },

        initialize : function( options ) {
            
        }

    });

    return collection;
});