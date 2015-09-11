define([
    "backbone",    
    "Chart",
    "text!../templates/popular-chart.html"
], function( Backbone, Chart, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),       

        initialize : function( options ) {
//             this.skills = options.skills;
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
                data: { id: self.model.get('id') },
                headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                }
            }).done(function(data) {
                var ctx = self.$("#popular-chart").get(0).getContext('2d');
                self.myNewChart = new Chart(ctx).Line(data);
            });          
        }        
       
    });

    return view;
});