define([
    "backbone", 
    "skill-compass/views/statistic-item", 
    "text!../templates/statistic.html"
], function( Backbone, StatisticItem, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),       

        initialize : function( options ) {
            this.skills = options.skills;
            this.items = [];
        },

        render : function() {      
            var self = this;
            this.$el.empty().append( this.template() ); 
            this.skills.each(function(model){
                if(model.get('checked') == true){
                    var statisticItem = new StatisticItem({model: model});
                    this.items.push(statisticItem);
                     self.$("[data-eid=statistic]").append(statisticItem.render().$el);
                }
            }, this);
            return this;
        },
                
        show : function () {
            _.each(this.items, function(view){view.showItem()});    
            $('#step-content').fadeIn();
        }
        
        
    });

    return view;
});