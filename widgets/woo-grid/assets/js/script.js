(function ($) {
    'use strict';
$(document).ready(function(){
    if($('.product-thumbnails--slider').length){
        var options = {
            loop: false,
            autoplay: false,
            speed: 800,
            watchOverflow: true,
            lazy: true,
            breakpoints: {}
        };
        $('.product-thumbnails--slider').each(function(){
            $(this).find('.woocommerce-loop-product__link').addClass('swiper-slide');

            options.navigation = {
                nextEl: $(this).find('.templaza-product-loop-swiper-next'),
                prevEl: $(this).find('.templaza-product-loop-swiper-prev'),
            }
            new Swiper($(this), options);
        })
    }
    if($('.product-thumbnail-zoom').length){
        $('.product-thumbnail-zoom').each(function(){
            console.log($(this));
            $(this).zoom({
                url: $(this).attr('data-zoom_image')
            });
        })
    }
})

})(jQuery);