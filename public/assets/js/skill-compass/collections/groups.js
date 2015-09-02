define([
    "backbone"
], function( Backbone ) {

    var collection = Backbone.Collection.extend({

        url : function() {
            return "/api/group";
        },
        
        comparator : 'position',

        initialize : function( options ) {
            
        }

    });

    return collection;
});