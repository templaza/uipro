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

        // if( $('.ui-advanced-products .ui-post-loading').offset().top && $(document).scrollTop() > ( $('.ui-advanced-products .ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
        //     callUIAdProductsAjaxload();
        // }
        // $(window).scroll(function(){
        //     if( $('.ui-advanced-products .ui-post-loading').offset().top && $(document).scrollTop() > ( $('.ui-advanced-products .ui-post-loading').offset().top - bottomOffset ) && canBeLoaded === true ) {
        //         callUIAdProductsAjaxload();
        //     }
        // });

    }
    if ($('.ui-advanced-products .ap-filter').length){
        $('.ap-filter a').on('click',function(){
            var has_active = $(this).hasClass('active');
            if(has_active ===false) {
                $(this).parents('.ui-advanced-products').find('.ap-product-container').addClass('tz-loading').append('<div class="templaza-posts__loading show"><span class="templaza-loading"></span> </div>');
                $(this).parent().find('a').removeClass('active');
                $(this).addClass('active');
                var filter_tax = $(this).attr('data-value'),
                    filter_by = $(this).parent().attr('data-filter'),
                    module = $(this).parent().attr('data-module');
                var data = {
                    'action': 'templaza_ui_ap_products_filter',
                    'query': $('.ui-advanced-products > .ui-post-paging').val(),
                    'settings': $('.ui-advanced-products > .ui-post-settings').val(),
                    'page': ui_advanced_product_loadmore_params.current_page,
                    'filter_by': filter_by,
                    'filter_value': filter_tax,
                };
                $.ajax({
                    url: ui_advanced_product_loadmore_params.ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function (data) {
                        if (data) {
                            var ap_container = $('.' + module + '');
                            ap_container.empty();
                            ap_container.append(data);
                            ap_container.find('.ap-item').each(function (index, product) {
                                $(product).css('animation-delay', index * 100 + 'ms');
                            });

                        }
                    }
                });
            }
        })
    }


})(jQuery);