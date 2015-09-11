define([
    "backbone", 
    "skill-compass/views/popular-chart", 
    "skill-compass/views/related-chart", 
    "text!../templates/statistic-item.html"
], function( Backbone, PopularChart, RelatedChart, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),       

        initialize : function( ) {
            
        },

        render : function() {      
            this.$el.empty().append( this.template(this.model.toJSON()) );  
            
            this.popularChart = new PopularChart({model: this.model});
            this.$('[data-eid="popular-chart"]').empty().append(this.popularChart.render().$el);
            
            this.relatedChart = new RelatedChart({model: this.model});
            this.$('[data-eid="related-chart"]').empty().append(this.relatedChart.render().$el);
            
            return this;
        },
        
        showItem : function () {
            this.popularChart.showChart(); 
            this.relatedChart.showChart();          
        }
        
        
    });

    return view;
});