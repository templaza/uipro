"use strict";
jQuery(function($){
    if ($('.ui-addon-marker').length) {
        $('.ui-addon-marker').find('.ui-marker').on('click', function(e){
            e.preventDefault();
        });
    }
});