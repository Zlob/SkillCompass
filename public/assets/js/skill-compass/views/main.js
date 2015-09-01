define([
    "backbone",    
    "skill-compass/views/selection",  
    "skill-compass/collections/groups",
    "skill-compass/collections/skills", 
    "text!../templates/main.html"
], function( Backbone, Selection, Groups, Skills, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),
        
        events: {
            'click [data-eid="btn-nav-skills"]' : "showStep",
        },

        initialize : function( options ) {

            this.groups = new Groups();

            this.skills = new Skills();

            this.promisArr = [
                this.groups.fetch(),
                this.skills.fetch()
            ];   
            
            var self = this;
            $.when.apply($, this.promisArr).then( function() {
                var storedSelection = new Backbone.Collection(JSON.parse(localStorage.getItem('selection'))); 
                self.skills.each(function(skill) {
                    var storedSkill = storedSelection.get(skill.get('id'));
                    if( storedSkill ) {
                        skill.set('checked', storedSkill.get('checked'));    
                    }
                    else{
                        skill.set('checked', false);    
                    }
                    
                    skill.on('change', self.saveSelection, self);
                })
                self.showStep();
            });
            
            this.currentStep = 'Skills';            
        },

        render : function() {
            // Отключаем привязанные события, очищаем элемент и
            // добавляем в верстку шаблон
            this.$el.empty().append( this.template() ); 

            return this;
        },
        
        showStep : function() {
            var stepView = new Selection({groups : this.groups, skills : this.skills});
            this.$('[data-eid="step-view"]').empty().append(stepView.render().$el);
        },
        
        saveSelection: function (){
            localStorage.setItem('selection',  JSON.stringify(this.skills));
        }

    });

    return view;
});