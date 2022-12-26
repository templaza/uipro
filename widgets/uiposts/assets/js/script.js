"use strict";
jQuery(function($){
    var bottomOffset = $(window).height(); // the distance (in px) from the page bottom when you want to load more posts

    var callAjaxload = function (wduipost) {
        var __canBeLoaded = wduipost.data("uipost-ajaxload"),
            __loading = wduipost.find(".ui-post-loading"),
            data = {
                'action': 'templaza_ui_post_loadmore',
                'query': wduipost.find('.ui-post-paging').val(),
                'settings': wduipost.find('.ui-post-settings').val(),
                'page' : ui_post_loadmore_params.current_page,
                "icount": wduipost.find(".ui-post-items").children().length
            };

        __canBeLoaded = __canBeLoaded !== undefined ? __canBeLoaded : true;

        if(!__canBeLoaded){
            return;
        }
        $.ajax({
            url : ui_post_loadmore_params.ajaxurl,
            data:data,
            type:'POST',
            beforeSend: function( xhr ){
                // you can also add your own preloader here
                // you see, the AJAX call is in process, we shouldn't run it again until complete
                // canBeLoaded = false;
                wduipost.data("uipost-ajaxload", false);
            },
            success:function(data){
                if( data ) {
                    var __items  = $(data);

                    __items.each(function(){
                        var __item  = $(this);
                        if(__item.hasClass("ui-posts-intro-item") && __item.hasClass("ui-posts-intro-first")){
                            if(wduipost.find(".ui-posts-intro-item.ui-posts-intro-first").length){
                                wduipost.find(".ui-posts-intro-item.ui-posts-intro-first .ui-post-items").append(__item.find("article"));
                            }else{
                                wduipost.find(".uk-posts-list-items").append(__item);
                            }
                        }else if(__item.hasClass("ui-posts-intro-item")){
                            if(wduipost.find(".ui-posts-intro-item:not(.ui-posts-intro-first)").length){
                                wduipost.find(".ui-posts-intro-item:not(.ui-posts-intro-first) .ui-post-items").append(__item.find("article"));
                            }else{
                                wduipost.find(".uk-posts-list-items").append(__item);
                            }
                        }else if(__item.hasClass("ui-posts-lead-item")){
                            if(wduipost.find(".ui-posts-lead-item").length){
                                wduipost.find(".ui-posts-lead-item .ui-post-items").append(__item.find("article"));
                            }else{
                                wduipost.find(".uk-posts-list-items").prepend(__item);
                            }
                        }else{
                            wduipost.find('.ui-posts .ui-post-items').append( __item ); // where to insert posts
                        }
                    });
                    wduipost.data("uipost-ajaxload", true); // the ajax is completed, now we can run it again
                    // canBeLoaded = true; // the ajax is completed, now we can run it again
                    ui_post_loadmore_params.current_page++;
                    if ( $(document).scrollTop() > ( __loading.offset().top - bottomOffset ) ) {
                        callAjaxload(wduipost);
                    }
                } else {
                    __loading.addClass('endpost');
                }
            }
        });
    };

    $('.templaza-widget-uiposts').each(function(){
        var __uipost    = $(this);

        if (__uipost.find('.ui-posts .ui-post-items').length && __uipost.find('.ui-post-paging').length
            && __uipost.find('.ui-post-settings').length) {
            var __canBeLoaded = __uipost.data("uipost-ajaxload");

            __canBeLoaded = __canBeLoaded !== undefined ? __canBeLoaded : true;

            if (__uipost.find('.ui-post-loading').offset().top && $(document).scrollTop()
                > (__uipost.find('.ui-post-loading').offset().top - bottomOffset) && __canBeLoaded === true) {
                callAjaxload(__uipost);
            }
            $(window).scroll(function () {
                if (__uipost.find('.ui-post-loading').offset().top && $(document).scrollTop()
                    > (__uipost.find('.ui-post-loading').offset().top - bottomOffset)  && __canBeLoaded === true) {
                    callAjaxload(__uipost);
                }
            });
        }
    });
});