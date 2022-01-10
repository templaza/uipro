"use strict";
jQuery(function($){
    if ($('.ui-gallery .ui-gallery-items').length && $('.ui-gallery > .ui-gallery-settings').length) {
        var canBeLoaded = true,
            bottomOffset = $(window).height(); // the distance (in px) from the page bottom when you want to load more posts

        var callAjaxload = function () {
            var data = {
                'action': 'templaza_ui_gallery_loadmore',
                'settings': $('.ui-gallery > .ui-gallery-settings').val(),
                'page' : ui_gallery_loadmore_params.current_page,
            };
            $.ajax({
                url : ui_gallery_loadmore_params.ajaxurl,
                data:data,
                type:'POST',
                beforeSend: function( xhr ){
                    // you can also add your own preloader here
                    // you see, the AJAX call is in process, we shouldn't run it again until complete
                    canBeLoaded = false;
                },
                success:function(data){
                    if( data ) {
                        $('.ui-gallery .ui-gallery-items').append( data ); // where to insert posts
                        canBeLoaded = true; // the ajax is completed, now we can run it again
                        ui_gallery_loadmore_params.current_page++;
                        if ( $(document).scrollTop() > ( $('.ui-gallery .ui-gallery-loading').offset().top - bottomOffset ) ) {
                            callAjaxload();
                        }
                    } else {
                        $('.ui-gallery .ui-gallery-loading').addClass('endpost');
                    }
                }
            });
        }
        if( $('.ui-gallery .ui-gallery-loading').offset().top && $(document).scrollTop() > ( $('.ui-gallery .ui-gallery-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
            callAjaxload();
        }
        $(window).scroll(function(){
            if( $('.ui-gallery .ui-gallery-loading').offset().top && $(document).scrollTop() > ( $('.ui-gallery .ui-gallery-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
                callAjaxload();
            }
        });
    }
});