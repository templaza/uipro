(function($){
    "use strict";

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        if(typeof window.elementor !== "undefined") {
            elementor.hooks.addAction('panel/open_editor/widget/uipro-uiadvanced-products-filter', function (panel, model, view) {
                // Sortable custom fields
                var $element = panel.$el.find('[data-setting="uiap_custom_fields"]').parent().find('.select2-selection__rendered');
                if ($element.length) {
                    var orderSortedValues = function() {
                        var value = '';
                        $element.children("li[title]").each(function(i, obj){
                            var element = panel.$el.find('[data-setting="uiap_custom_fields"]').children('option').filter(function () { return $(this).html() == obj.title });
                            moveElementToEndOfParent(element)
                        });
                    };
                    var moveElementToEndOfParent = function(element) {
                        var parent = element.parent();

                        element.detach();

                        parent.append(element);
                    };

                    $element.sortable({
                        /*handle: ".handle-move",*/
                        update: function(){
                            orderSortedValues();
                        },
                        stop: function (event, ui) {
                            model.setSetting("uiap_custom_fields", panel.$el.find('[data-setting="uiap_custom_fields"]').val());
                        }
                    });
                }
            });
        }
    } );
})(jQuery);