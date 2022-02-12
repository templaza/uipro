(function($){
    "use strict";

    if (($('.ui-advanced-products .ui-post-items').length || $('.ui-advanced-products .ap-list').length)
        && $('.ui-advanced-products > .ui-post-paging').length
        && $('.ui-advanced-products > .ui-post-settings').length) {

        var canBeLoaded = true,
            bottomOffset = $(window).height(); // the distance (in px) from the page bottom when you want to load more posts

        var callUIAdProductsAjaxload = function ($selector) {
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

                        $('.ui-advanced-products .ui-post-items,.ui-advanced-products .ap-list').append( data ); // where to insert posts
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



        // var callUIAdProductsAjaxload = function ($selector) {
        //     var data = {
        //         'action': 'templaza_ui_ap_products_loadmore',
        //         'query': $selector.find('> .ui-post-paging').val(),
        //         'settings': $selector.find('> .ui-post-settings').val(),
        //         'page' : ui_advanced_product_loadmore_params.current_page,
        //     }, __bottomOffset = $(window).height();
        //     $.ajax({
        //         url : ui_advanced_product_loadmore_params.ajaxurl,
        //         data:data,
        //         type:'POST',
        //         beforeSend: function( xhr ){
        //             // you can also add your own preloader here
        //             // you see, the AJAX call is in process, we shouldn't run it again until complete
        //             // canBeLoaded = false;
        //             $selector.data("canBeLoaded", false);
        //         },
        //         success:function(data){
        //             if( data ) {
        //
        //                 $selector.find('.ui-post-items,.ap-list').append( data ); // where to insert posts
        //                 $selector.data("canBeLoaded", true); // the ajax is completed, now we can run it again
        //                 // canBeLoaded = true; // the ajax is completed, now we can run it again
        //                 ui_advanced_product_loadmore_params.current_page++;
        //                 if ( $(document).scrollTop() > ( $selector.find('.ui-post-loading').offset().top - __bottomOffset ) ) {
        //                     callUIAdProductsAjaxload($selector);
        //                 }
        //             } else {
        //                 $selector.find('.ui-post-loading').addClass('endpost');
        //             }
        //         }
        //     });
        // };
        //
        // $(".ui-advanced-products").each(function(){
        //     var el  = $(this);
        //
        //     var canBeLoaded = (typeof el.data("canBeLoaded") !== "undefined")?el.data("canBeLoaded"):true,
        //         bottomOffset = $(window).height(); // the distance (in px) from the page bottom when you want to load more posts
        //
        //     console.log(canBeLoaded);
        //     console.log(el.find('.ui-post-loading').offset().top && $(document).scrollTop() > ( el.find('.ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true);
        //     if( el.find('.ui-post-loading').offset().top && $(document).scrollTop() > ( el.find('.ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
        //         callUIAdProductsAjaxload(el);
        //     }
        //     $(window).scroll(function(){
        //         // bottomOffset = $(window).height();
        //         canBeLoaded = el.data("canBeLoaded");
        //         if( el.find('.ui-post-loading').offset().top && $(document).scrollTop() > ( el.find('.ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
        //             callUIAdProductsAjaxload(el);
        //         }
        //     });
        // });
    }


})(jQuery);