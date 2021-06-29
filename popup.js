// On load

$(document).ready(function() {
    
    /* popup */
    
    jQuery('.popup--wrapper').addClass('active-pop');
    
    jQuery('.close--popup').click(function(event){
        
        jQuery('.popup--wrapper').removeClass('active-pop');
        
        event.preventDefault();
        
        console.log('click');   
        
    });
    
    
/*
    jQuery('.popup--wrapper').click( function(e){
        console.log('click wrapper');
        e.stopPropagation();
        e.preventDefault();
        
        
    });
*/
    
    
    



	
});
