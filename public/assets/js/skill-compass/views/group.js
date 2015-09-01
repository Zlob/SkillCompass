define([
    "backbone",  
    "backbone.epoxy",
    "text!../templates/group.html"
], function( Backbone, Epoxy, tpl ) {

    var view = Backbone.Epoxy.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),  
        tagName : 'div',
        className : 'panel',

        initialize : function( options ) {
            var id = this.model.get('id');
            this.collection = app.skills.filter(function (skill) {
                if(skill.get('group_id') === id){
                    return true;
                }
            });
        },

        render : function() {      
            this.$el.empty().append( this.template() ); 
            this.applyBindings();
            return this;
        }
        
    });

    return view;
});