(function ($) {
    'use strict';

    var ControlFMautocomplete = elementor.modules.controls.BaseData.extend({
        onReady: function () {

            this.uiAutocomplete(this);

            this.uiRemoveData(this);

            this.uiSortable(this);

            this.uiOnRender(this);
        },
        uiAutocomplete: function (self) {
            var $input_value = self.$el.find('.ui_autocomplete_value'),
                self_value = $input_value.val(),
                multiple = $input_value.data('multiple'),
                step = '',
                item_value = '';

            self.$el.find('.ui_autocomplete_param').autocomplete({
                minLength: 1,
                source: function (request, response) {
                    $.ajax({
                        url: ajaxurl,
                        dataType: 'json',
                        method: 'post',
                        data: {
                            action: 'ui_get_autocomplete_suggest',
                            term: request.term,
                            source: $input_value.data('source'),
                            source_type: $input_value.data('source_type')
                        },
                        success: function (data) {
                            response(data.data);
                        }
                    })
                },
                response: function (event, ui) {
                    self.$el.find('.ui_autocomplete').removeClass('loading');
                },
                search: function (event, ui) {
                    self.$el.find('.ui_autocomplete').addClass('loading');
                },
                select: function (event, ui) {

                    item_value = ui.item.value;

                    if (item_value === 'nothing-found') {
                        return false;
                    }
                    self_value = $input_value.val();
                    if (self_value !== '') {
                        step = ',';
                    }

                    var template = '<li class="ui_autocomplete-label" data-value="' + item_value + '">' +
                        '<span class="ui_autocomplete-data">' + ui.item.label + '</span>' +
                        '<a href="#" class="ui_autocomplete-remove">×</a>' +
                        '</li>';

                    if (multiple) {
                        self.$el.find('.ui_autocomplete').append(template);
                        self_value = self_value + step + item_value;
                    } else {
                        if( self.$el.find('.ui_autocomplete .ui_autocomplete-label').length > 0 ) {
                            self.$el.find('.ui_autocomplete .ui_autocomplete-label').replaceWith(template);
                        } else {
                            self.$el.find('.ui_autocomplete').append(template);
                        }
                        self.$el.find('.ui_autocomplete .ui_autocomplete-label').replaceWith(template);
                        self_value = item_value;
                    }

                    self.$el.find('.ui_autocomplete_param').val('');
                    $input_value.val(self_value);
                    self.setValue(self_value);

                    return false;
                },
                open: function (event) {
                    $(event.target).data('uiAutocomplete').menu.activeMenu.addClass('elementor-autocomplete-menu fm-autocomplete-menu');
                }
            }).autocomplete('instance')._renderItem = function (ul, item) {
                return $('<li>')
                    .attr('data-value', item.value)
                    .append(item.label)
                    .appendTo(ul);
            };
            return self_value;
        },
        uiRemoveData: function (self) {
            var $input_value = self.$el.find( '.ui_autocomplete_value' );
			self.$el.find( '.ui_autocomplete' ).on( 'click', '.ui_autocomplete-remove', function ( e ) {
				e.preventDefault();
				var $this = $( this ),
					self_value = '';

				$this.closest( '.ui_autocomplete-label' ).remove();

				self.$el.find( '.ui_autocomplete' ).find( '.ui_autocomplete-label' ).each( function () {
					self_value = self_value + ',' + $( this ).data( 'value' );
				} );
				$input_value.val(self_value);
                self.setValue( self_value );

            } );
            
            
        },
        uiSortable: function (self) {
            var sortable = self.$el.find('.ui_autocomplete_value').data('sortable'),
                self_value = '';
            if (sortable) {
                self.$el.find('.ui_autocomplete').sortable({
                    items: 'li.ui_autocomplete-label',
                    update: function (event, ui) {

                        self_value = '';

                        self.$el.find('.ui_autocomplete').find('li.ui_autocomplete-label').each(function () {
                            self_value = self_value + ',' + $(this).data('value');
                        });

                        self.setValue(self_value);
                    }
                });
            }
        },
        uiOnRender: function (self) {
            var $input_value = self.$el.find('.ui_autocomplete_value'),
                self_value = $input_value.val();

            $.ajax({
                url: ajaxurl,
                dataType: 'json',
                method: 'post',
                data: {
                    action: 'ui_get_autocomplete_render',
                    term: self_value,
                    source: $input_value.data('source'),
                    source_type: $input_value.data('source_type')
                },
                success: function (data) {
                    if (data) {
                        self.$el.find('.ui_autocomplete').append(data.data);
                        self.$el.find('.ui_autocomplete').find('li.ui_autocomplete-loading').remove();
                    }
                }
            });
        },
        onBeforeDestroy: function () {
            if (this.ui.input.data('autocomplete')) {
                this.ui.input.autocomplete('destroy');
            }

            this.$el.remove();
        }
    });
    elementor.addControlView('uiautocomplete', ControlFMautocomplete);

})
(jQuery);