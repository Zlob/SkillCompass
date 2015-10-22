define([
    "backbone", 
    "skill-compass/views/jobs-table-item",
    "text!../templates/jobs-table.html"
], function( Backbone, JobsTableItem, tpl ) {

    var view = Backbone.View.extend({
        // Кэшируем html-шаблон
        template : _.template( tpl ),    
        events: {
            'click [sorting-field]' : "changeSorting"
        },

        initialize : function( options ) {
            this.skills = options.skills;
            this.model = new Backbone.Model({
                'field' : 'additional_skills_count',
                'is_asc' : true
            });

        },

        render : function() {      
            var self = this;
            this.$el.empty().append( this.template() ); 

            this.loaded = $.ajax({
                method: "POST",
                url: "api/jobs-by-skills",
                data: { 
                    skillIds: self.getSkillIds(),
                    areaId: localStorage.getItem('areaId') || 1
                }
            }).done(function(data) {
                self.renderData(data);             
            });   

            return this;
        },
        
        show : function() {
            $.when(this.loaded).then( function(){
                $('#step-content').fadeIn(); 
            });            
        },
        
        renderData : function(data) {
            this.data = this.sortData(data, this.model.get('field'), this.model.get('is_asc'));
            this.setSortIcon(this.model.get('field'), this.model.get('is_asc'));
            this.showData();  
        },
            
        sortData : function(data, field, is_asc) {
            if(is_asc){
                return _.sortBy(data, function(item){
                    return item.aggregation[field];
                });                
            }               
            else{
                return _.sortBy(data, function(item){
                    return item.aggregation[field];                    
                }).reverse();
            }
        },
        
        showData : function() {
            var self = this;
            self.$("[data-eid=jobs-table]").empty();
            _.each(self.data, function(itemData) {
                var item = new JobsTableItem({model : new Backbone.Model(itemData.aggregation), detalization : new Backbone.Collection(itemData.actual_jobs)});

                self.$("[data-eid=jobs-table]").append(item.render().$el);

            })
        },        
            
        
        getSkillIds : function () {
            return this.skills
                .filter(
                function(model)
                {
                    if(model.get('checked') == true){
                        return true;
                    }   
                    return false;
                }
            )
                .map(
                function(model)
                {
                    return model.get('id');
                }
            );
        },
        
        changeSorting : function(columnEvent) {
            var field =  $(columnEvent.target).attr( "sorting-field" );
            if(this.model.get('field') === field){
                this.model.set('is_asc', !this.model.get('is_asc'));
            }
            else{
                this.model.set('field', field);
                this.model.set('is_asc', true);
            }

            this.renderData(this.data);
        },
        
        setSortIcon : function(field, is_asc) {
            this.$('.sorted-column-header').removeClass( "sorted-column-header" );
            this.$('.sorting-glyph').removeClass( "glyphicon glyphicon-triangle-bottom glyphicon-triangle-top sorted-column-header" );

            if(is_asc){
                var className = 'glyphicon glyphicon-triangle-bottom'    
            }else{
                var className = 'glyphicon glyphicon-triangle-top' 
            }       
            var btn = this.$('[sorting-field='+field+']');
            btn.addClass('sorted-column-header');
            var span = btn.find('span');
            span.addClass( className );

        }

        
        
    });

    return view;
});