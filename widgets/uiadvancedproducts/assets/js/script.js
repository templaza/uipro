"use strict";
jQuery(function($){
    if ($('.ui-advanced-products .ui-post-items').length && $('.ui-advanced-products > .ui-post-paging').length && $('.ui-advanced-products > .ui-post-settings').length) {
        var canBeLoaded = true,
            bottomOffset = $(window).height(); // the distance (in px) from the page bottom when you want to load more posts

        var callUIAdProductsAjaxload = function () {
            var data = {
                'action': 'templaza_ui_ap_products_loadmore',
                'query': $('.ui-advanced-products > .ui-post-paging').val(),
                'settings': $('.ui-advanced-products > .ui-post-settings').val(),
                'page' : ui_advanced_product_loadmore_params.current_page,
            };
            $.ajax({
                url : ui_advanced_product_loadmore_params.ajaxurl,
                data:data,
                type:'POST',
                beforeSend: function( xhr ){
                    // you can also add your own preloader here
                    // you see, the AJAX call is in process, we shouldn't run it again until complete
                    canBeLoaded = false;
                },
                success:function(data){
                    if( data ) {
                        $('.ui-advanced-products .ui-post-items').append( data ); // where to insert posts
                        canBeLoaded = true; // the ajax is completed, now we can run it again
                        ui_advanced_product_loadmore_params.current_page++;
                        if ( $(document).scrollTop() > ( $('.ui-advanced-products .ui-post-loading').offset().top - bottomOffset ) ) {
                            callUIAdProductsAjaxload();
                        }
                    } else {
                        $('.ui-advanced-products .ui-post-loading').addClass('endpost');
                    }
                }
            });
        };
        if( $('.ui-advanced-products .ui-post-loading').offset().top && $(document).scrollTop() > ( $('.ui-advanced-products .ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
            callUIAdProductsAjaxload();
        }
        $(window).scroll(function(){
            if( $('.ui-advanced-products .ui-post-loading').offset().top && $(document).scrollTop() > ( $('.ui-advanced-products .ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
                callUIAdProductsAjaxload();
            }
        });
    }
});