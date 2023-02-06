<?php
/**
 * UIPro Elementor Circle Text widget
 *
 * @version     1.0.0
 * @author      TemPlaza.com
 * @package     UIPro/Classes
 * @category    Classes
 */

use Elementor\Utils;

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'UIPro_El_CircleText' ) ) {
	/**
	 * Class UIPro_El_CircleText
	 */
	class UIPro_El_CircleText extends UIPro_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'UIPro_Config_CircleText';

        public function convert_setting($settings){

            if(isset($settings['link']['custom_attributes']) && !empty($settings['link']['custom_attributes'])) {
                $attributes = Utils::parse_custom_attributes($settings['link']['custom_attributes']);

                $settings['link']['custom_class']  = isset($attributes['class'])?' '.$attributes['class']:'';

                unset($attributes['class']);

                $this -> set_render_attribute('link_attributes', $attributes);

                $settings['link']['custom_attributes'] = $this -> get_render_attribute_string('link_attributes');
            }

		    return $settings;
        }

    }
}