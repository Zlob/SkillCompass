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
            
            var skillIds = this.skills.filter(function(model){
                return model.get('checked');
            }).map(function(model){
                return model.get('id');
            });
            
            this.promise = $.ajax({
                method: "POST",
                url: "api/statistic-info",
                data: { 
                    skills_ids: skillIds,
                    areaId: localStorage.getItem('areaId') || 1
                }
            });
                        
            return this;
        },
                
        show : function () {
            var self = this;
            $.when(this.promise).then(function(rawData) {
                $('#step-content').animate({ opacity : 100 });
                _.each(rawData, function(statisticData, id){
                    var statisticItem = new StatisticItem({model: self.skills.get(id), popular_chart_info: statisticData.popular_chart_info, related_chart_info: statisticData.related_chart_info});
                    self.items.push(statisticItem);
                    self.$("[data-eid=statistic]").append(statisticItem.render().$el);
                });
                _.each(self.items, function(view){view.showItem()});   
            })
        }
        
        
    });

    return view;
});