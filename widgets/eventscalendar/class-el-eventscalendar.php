<?php
/**
 * TemPlaza Elements Elementor Events Calendar widget
 *
 * @version     1.0.0
 * @author      TemPlaza
 * @package     TemPlaza/Classes
 * @category    Classes
 */


use Elementor\Controls_Manager;

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'UIPro_El_EventsCalendar' ) ) {
    /**
     * Class UIPro_El_EventsCalendar
     */
    class UIPro_El_EventsCalendar extends UIPro_El_Widget {

        /**
         * @var string
         */
        protected $config_class = 'UIPro_Config_EventsCalendar';

        public function render() {
            $return = parent::render();

            wp_reset_postdata();

            return $return;
        }

        /**
         * Convert and prepare settings before render
         */
        public function convert_setting($settings) {

            if (isset($settings['link']['custom_attributes']) && !empty($settings['link']['custom_attributes'])) {
                $attributes = Utils::parse_custom_attributes($settings['link']['custom_attributes']);
                $settings['link']['custom_class'] = isset($attributes['class']) ? ' ' . $attributes['class'] : '';

                unset($attributes['class']);

                $this->set_render_attribute('link_attributes', $attributes);
                $settings['link']['custom_attributes'] = $this->get_render_attribute_string('link_attributes');
            }


            $settings['events'] = $this->get_events($settings);

            if (isset($settings['list_icon']['value'])) {
                $settings['list_icon'] = $settings['list_icon']['value'];
            }

            return $settings;
        }


        public function get_template_name() {
            $temp       = parent::get_template_name();
            $settings   = $this->get_settings_for_display();

            if (isset($settings['layout']) && !empty($settings['layout'])) {
                $temp = $settings['layout'];
            }

            return $temp;
        }

        protected $cache = [];

        protected function get_events($settings) {
            $store_id   = __METHOD__;
            $store_id  .= '::' . serialize($settings);
            $store_id   = md5($store_id);

            if (isset($this->cache[$store_id])) {
                return $this->cache[$store_id];
            }

            $number_events_calendars = !empty($settings['number_events_calendars']) ? $settings['number_events_calendars'] : 4;

            $query_args = [
                'events_type'      => 'tribe_events',
                'events_per_page' => $number_events_calendars,
                'events_status'    => 'publish',
            ];

            if (!empty($settings['cat_id']) && $settings['cat_id'] !== 'all') {
                $query_args['tax_query'] = [
                    [
                        'taxonomy' => 'tribe_events_cat',
                        'field'    => 'term_id',
                        'terms'    => $settings['cat_id'],
                    ],
                ];
            }

            $events = tribe_get_events($query_args);

            if (!empty($events) && !is_wp_error($events)) {
                return $this->cache[$store_id] = $events;
            }

            return false;
        }
    }
}
