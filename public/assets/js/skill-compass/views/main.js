define([
    "backbone",    
    "skill-compass/views/selection",     
    "text!../templates/main.html"
], function( Backbone, Skills, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),
        
        events: {
            'click [data-eid="btn-nav-skills"]' : "showStep",
        },

        initialize : function( options ) {
            this.currentStep = 'Skills';            
        },

        render : function() {
            // Отключаем привязанные события, очищаем элемент и
            // добавляем в верстку шаблон
            this.$el.empty().append( this.template() ); 
            this.showStep();

            return this;
        },
        
        showStep : function() {
            var stepView = new Skills();
            this.$('[data-eid="step-view"]').empty().append(stepView.render().$el);
        } 

    });

    return view;
});