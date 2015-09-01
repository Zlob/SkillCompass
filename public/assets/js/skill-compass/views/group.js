define([
    "backbone",  
    "backbone.epoxy",
    "skill-compass/views/skill",    
    "text!../templates/group.html"
], function( Backbone, Epoxy, Skill, tpl ) {

    var view = Backbone.Epoxy.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),  
        tagName : 'div',
        className : 'panel',
        events: {
            'click [data-eid="toggle-group"]' : "toggleGroup",
        },

        initialize : function( options ) {
            this.selectedCount();
        },

        render : function() {      
            var self = this;

            self.$el.empty().append( self.template() );             
            self.applyBindings();
            self.collection.each(function(skill){
                var id = self.model.get('id');
                if(skill.get('group_id') === id){
                    var skillView = new Skill({model : skill});
                    self.$("[data-eid=group-skills]").append( skillView.render().$el );
                }
            });            

            return self;
        },
        
        toggleGroup : function() {
            this.selectedCount();
            this.$('[data-eid="group-skills"]').slideToggle();
            this.$('[data-eid="selected-count"]').toggle();
        },
        
        selectedCount : function () {
            var self = this;
            var selectedCount = self.collection.reduce(function(count, skill){
                var id = self.model.get('id');
                if(skill.get('group_id') === id && skill.get('checked') === true){
                    count++;                                                                                  
                }
                return count;
            }, 0); 
            this.model.set('selectedCount', selectedCount);
        }
        
    });

    return view;
});