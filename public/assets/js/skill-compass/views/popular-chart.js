define([
    "backbone",    
    "Chart",
    "text!../templates/popular-chart.html"
], function( Backbone, Chart, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),       

        initialize : function( options ) {
        },

        render : function() {      
            this.$el.empty().append( this.template() );           
            return this;
        },
        
        showChart : function () {
            var self = this;
            
            $.ajax({
                method: "POST",
                url: "api/popular-chart-info",
                data: { 
                    id: self.model.get('id'),
                    areaId: localStorage.getItem('areaId') || 1
                },
                headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                }
            }).done(function(rawData) {
                var data = self.prepareData(rawData);
                var ctx = self.$("#popular-chart").get(0).getContext('2d');
                self.myNewChart = new Chart(ctx).Line(
                    data
                );
            });          
        },
        
        prepareData : function(rawData) {
            var data = {
                labels: [],
                datasets: [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(215,75,75,0.5)",
                        strokeColor: "rgba(215,75,75,0.8)",
                        highlightFill: "rgba(215,75,75,0.75)",
                        highlightStroke: "rgba(215,75,75,1)",
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