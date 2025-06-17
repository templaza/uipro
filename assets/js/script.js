jQuery(function($){
    "use strict";
    $(document).ready(function() {
        if ($("body").hasClass('home')) {
            $('.section_heading').addClass('home-heading');
        }
        console.log($('.as-animation-background').length);
    })

});