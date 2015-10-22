define([
    "backbone",    
    "Chart",
    "../utils/tools",
    "text!../templates/popular-chart.html"
], function( Backbone, Chart, Tools, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),       

        initialize : function( options ) {
            this.chart_info = options.chart_info;
            this.dispetcher = Backbone.Events;
            this.dispetcher.on('area-change', this.showChart, this);
        },

        render : function() {      
            this.$el.empty().append( this.template() );           
            return this;
        },
        
        showChart : function () {
            var data = this.prepareData(this.chart_info);
            var ctx = this.$("#popular-chart").get(0).getContext('2d');
            this.myNewChart = new Chart(ctx).Line(
                data,
                this.getChartOptions(data)                    
            );        
        },
        
        prepareData : function(rawData) {
            var data = {
                labels: [],
                datasets: [
                    {
                        label: "График частоты навыка в вакансиях",
                        fillColor: "rgba(209,89,38,0.5)",
                        strokeColor: "rgba(209,89,38,0.8)",
                        highlightFill: "rgba(209,89,38,0.75)",
                        highlightStroke: "rgba(209,89,38,1)",
                        data: []
                    }
                ]
            };
            _.each(rawData, function(column) {
                data.labels.push(column.name);
                data.datasets[0].data.push(parseInt(column.total_count));
            })
            return data;
        },
        
        getChartOptions : function(data) {            
            var max = Math.max.apply(Math, data.datasets[0].data);
            var options = {
                scaleOverride: true,
                scaleSteps: 10,
                scaleStepWidth: Tools.getStepWidth(max),
                scaleStartValue: 0,
                responsive: true,
            };      
            return options;
        },
        
       
    });

    return view;
});