(function($, window){
    "use strict";
    $(function () {
        if(typeof window.elementor !== "undefined") {
            window.elementor.hooks.addAction('panel/open_editor/widget/uipro-uiposts', function (panel, model, view) {

                var __resource  = panel.$el.find("[data-setting=\"resource\"]"),
                    // __featured_ctr = panel.$el.find("#elementor-controls .elementor-control.elementor-control-show_featured"),
                    __ordering = panel.$el.find("[data-setting=\"ordering\"]");

                if(__resource.length){
                    var __editor_settings = window.elementor__uiposts_editor !== undefined?window.elementor__uiposts_editor:{},
                        __i18n = __editor_settings.i18n !== undefined?__editor_settings.i18n:{},
                        __featured_posttypes = [];
                    if(__editor_settings.enable_featured_for_posttypes !== undefined){
                        __featured_posttypes = __editor_settings.enable_featured_for_posttypes;
                    }

                    __resource.on("change", function(event){
                        var __value = $(this).val();

                        if(__featured_posttypes.indexOf(__value) !== -1) {
                            __featured_ctr.removeClass("elementor-hidden-control");
                        }else{
                            __featured_ctr.addClass("elementor-hidden-control");
                        }
                        // if(__featured_posttypes.indexOf(__value) !== -1) {
                        //     if(!__ordering.find("option[value=\"featured\"]").length){
                        //         __ordering.append("<option value=\"featured\">"
                        //             +(__i18n.featured !== undefined?__i18n.featured_only:"Featured Only")+"</option>");
                        //     }
                        // }else if(__ordering.find("option[value=\"featured\"]").length){
                        //     __ordering.find("option[value=\"featured\"]").remove();
                        // }
                    });

                    __resource.trigger("change");
                }
            });
        }
    });
})(jQuery, window);