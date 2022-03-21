(function($) {
    /**
     *   inquire us button
     */ 
        function inquireUsButton(value){
            if(value == true){
                $("#_wooaddtocart_inquire").show();
            } else {
                $("#_wooaddtocart_inquire").hide();
            }
        }
        //inquire us 
        var inquire_us =  $('input[name=_wooaddtocart_inquire_us]:checked').val();
        inquire_us = inquire_us ? true : false
        inquireUsButton(inquire_us);
        
        // when inquire us change
        $("#_wooaddtocart_inquire_us").change(function(e){
            var value = e.target.checked; 
            inquireUsButton(value);
        });

})( jQuery );
    