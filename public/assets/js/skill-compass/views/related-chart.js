define([
    "backbone",    
    "Chart",
    "text!../templates/related-chart.html"
], function( Backbone, Chart, tpl ) {

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
            var ctx = this.$("#related-chart").get(0).getContext('2d');
            this.myNewChart = new Chart(ctx).Bar(
                data,
                {
                    tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>%",
                    scaleLabel: "<%=value%>%",
                    scaleOverride: true,
                    scaleSteps: 10,
                    scaleStepWidth: 10,
                    scaleStartValue: 0,
                    responsive: true,
                }
            );       
        },
        
        prepareData : function(rawData) {
            var data = {
                labels: [],
                datasets: [
                    {
                        label: "График часто встречающихся навыков",
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
        }
       
    });
    
    

    return view;
});