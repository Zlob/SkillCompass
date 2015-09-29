require = require('amdrequire');

require( [ "./tools" ], function(Tools) {
   
    describe("Проверка округления в большую сторону", function() {    
        
        it("56 округляется до 60", function() {
            expect( Tools.getUpperRounded( 56, 10 ) ).toBe( 60 );
        });  
        
    });
    
    describe("Вычисление шага в графике", function() {    
        it("Меньше 10 значений", function() {
            expect( Tools.getStepWidth( 9 ) ).toBe( 1 );
        });  
        
        it("Меньше 100 значений", function() {
            expect( Tools.getStepWidth( 92 ) ).toBe( 10 );
        });    
        
        it("Меньше 1000 значений", function() {
            expect( Tools.getStepWidth( 123 ) ).toBe( 20 );
        });  
        
    });
    
});