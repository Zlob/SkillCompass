define( function() {
    return {
        
        // Считаем размер шага
        getStepWidth: function(max) {
            if(max < 10){
                return 1;
            }
            if(max < 100){
                return this.getUpperRounded(max, 10)/10;
            }
            if(max < 1000){
                return this.getUpperRounded(max, 100)/10;
            }
        },
        
        //округление в большую сторону
        getUpperRounded : function ($value, $roundStep) {
            return $value - $value % $roundStep + $roundStep;
        }
        
        
    };
} );