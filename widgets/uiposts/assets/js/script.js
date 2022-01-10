"use strict";
jQuery(function($){
    if ($('.ui-posts .ui-post-items').length && $('.ui-posts > .ui-post-paging').length && $('.ui-posts > .ui-post-settings').length) {
        var canBeLoaded = true,
            bottomOffset = $(window).height(); // the distance (in px) from the page bottom when you want to load more posts

        var callAjaxload = function () {
            var data = {
                'action': 'templaza_ui_post_loadmore',
                'query': $('.ui-posts > .ui-post-paging').val(),
                'settings': $('.ui-posts > .ui-post-settings').val(),
                'page' : ui_post_loadmore_params.current_page,
            };
            $.ajax({
                url : ui_post_loadmore_params.ajaxurl,
                data:data,
                type:'POST',
                beforeSend: function( xhr ){
                    // you can also add your own preloader here
                    // you see, the AJAX call is in process, we shouldn't run it again until complete
                    canBeLoaded = false;
                },
                success:function(data){
                    if( data ) {
                        $('.ui-posts .ui-post-items').append( data ); // where to insert posts
                        canBeLoaded = true; // the ajax is completed, now we can run it again
                        ui_post_loadmore_params.current_page++;
                        if ( $(document).scrollTop() > ( $('.ui-posts .ui-post-loading').offset().top - bottomOffset ) ) {
                            callAjaxload();
                        }
                    } else {
                        $('.ui-posts .ui-post-loading').addClass('endpost');
                    }
                }
            });
        }
        if( $('.ui-posts .ui-post-loading').offset().top && $(document).scrollTop() > ( $('.ui-posts .ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
            callAjaxload();
        }
        $(window).scroll(function(){
            if( $('.ui-posts .ui-post-loading').offset().top && $(document).scrollTop() > ( $('.ui-posts .ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
                callAjaxload();
            }
        });
    }
});