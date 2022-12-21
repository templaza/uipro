(function($, window){
    "use strict";

    var __ui_posts_scroller = function(){
        if($(".ui-posts-scroller .ticker-content").length) {
            $(".ui-posts-scroller .ticker-content").each(function(){
                var __elementor_id  = $(this).closest(".elementor-element").attr("data-id"),
                    __slider_setting = $(this).closest(".ui-posts-scroller").attr("data-ui-slider-setting");
                __slider_setting    = typeof __slider_setting === "string"?JSON.parse(__slider_setting):__slider_setting;

                var __mode      = __slider_setting["mode"]!== undefined?__slider_setting["mode"]:"horizontal",
                    __minSlides = __slider_setting["minSlides"] !== undefined?__slider_setting["minSlides"]:1;

                var __breakpoints    = elementorFrontend.config.responsive.activeBreakpoints;
                var __option    = {
                    mode: __slider_setting["mode"]!== undefined?__slider_setting["mode"]:"horizontal",
                    auto: __slider_setting["auto"]!== undefined?__slider_setting["auto"]:false,
                    autoStart: __slider_setting["autoStart"]!== undefined?__slider_setting["autoStart"]:false,
                    controls: __slider_setting["controls"] !== undefined?__slider_setting["controls"]:false,
                    speed: __slider_setting["speed"]!== undefined?__slider_setting["speed"]:500,
                    touchEnabled: __slider_setting["carousel_touch"]!== undefined?__slider_setting["carousel_touch"]:false,
                    // slideWidth: 600,
                    pager: false,
                    prevText: "<i class=\"fas fa-chevron-left\"></i>",
                    nextText: "<i class=\"fas fa-chevron-right\"></i>",
                    nextSelector: ".elementor-element-" + __elementor_id + " .ticker-controller .ticker-right-control",
                    prevSelector: ".elementor-element-" + __elementor_id + " .ticker-controller .ticker-left-control"
                };

                if(typeof __minSlides === "object"){
                    $.each(__breakpoints, function (key, breakpoint) {
                        if(breakpoint.direction === "max"){
                            if($(window).width() < breakpoint.value){
                                __option["minSlides"]   = __minSlides[key];
                                __option["maxSlides"]   = __minSlides[key];
                            }
                        }else{
                            if($(window).width() >= breakpoint.value){
                                __option["minSlides"]   = __minSlides[key];
                                __option["maxSlides"]   = __minSlides[key];
                            }
                        }
                    });
                    if(__option["minSlides"] === undefined){
                        __option["minSlides"]   = __minSlides["__desktop"];
                        __option["maxSlides"]   = __minSlides["__desktop"];
                    }
                }else{
                    __option["minSlides"]   = __minSlides;
                    __option["maxSlides"]   = __minSlides;

                }

                if(__slider_setting['moveSlides'] !== undefined){
                    __option['moveSlides']  = __slider_setting['moveSlides'];
                }
                if(__mode === "vertical"){
                    __option["autoStart"]   = true;
                    __option["adaptiveHeight"]   = true;
                }

                $(this).bxSlider(__option);
            });
        }
    };
    $(document).ready(function(){
        __ui_posts_scroller();
    });

    $( window ).on( 'elementor/frontend/init', function() {
        // console.log("Frontend init");
        if(typeof window.elementor !== "undefined") {
            __ui_posts_scroller();
            // window.elementor.hooks.addAction('frontend/element_ready/widget', function ($scope) {
            //     console.log("frontend/element_ready/widget");
            //     console.log($scope);
            // });
            window.elementor.hooks.addAction('panel/open_editor/widget/uipro-uiposts-scroller', function (panel, model, view) {
                __ui_posts_scroller();
            });
        }
    });
})(jQuery, window);