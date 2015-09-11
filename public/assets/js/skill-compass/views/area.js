define([
    "backbone",    
    "backbone.epoxy",
    "text!../templates/area.html"
], function( Backbone, Epoxy, tpl ) {

    var view = Backbone.Epoxy.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),
        tagName: 'li',
        events: {
            'click [data-eid="area-btn"]': "showSelection",
            'click [data-eid="msk-btn"]': "setMoskow",
            'click [data-eid="spb-btn"]': "setSpb",
        },

        initialize : function( options ) {
            this.collection = new Backbone.Collection([{'id' : 1, 'name' : 'Москва'},{'id' : 2, 'name' : 'Санкт-Петербург'}]);
            this.setModel( localStorage.getItem('areaId') || 1);
        },

        render : function() {
            // Отключаем привязанные события, очищаем элемент и
            // добавляем в верстку шаблон
            this.$el.empty().append( this.template() );  
            this.popup = this.$('#areaModal');            
            this.applyBindings();
            return this;
        },
        
        setModel : function(id) {
            this.model = this.collection.get(id);
            localStorage.setItem('areaId', id);
        },
        
        showSelection : function() {
            this.popup.modal();        
        },
        
        setMoskow : function() {
            this.setModel(1);
            this.applyBindings();
            this.popup.modal('hide')
        },
        
        setSpb : function() {
            this.setModel(2);
            this.applyBindings();
            this.popup.modal('hide')
        }

    });

    return view;
});