define([
    "backbone",    
    "text!../templates/main.html"
], function( Backbone, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),

        initialize : function( options ) {

        },

        render : function() {
            // Отключаем привязанные события, очищаем элемент и
            // добавляем в верстку шаблон
            this.$el.empty().append( this.template() );            

            return this;
        }

    });

    return view;
});