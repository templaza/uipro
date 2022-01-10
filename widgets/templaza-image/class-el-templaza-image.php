<?php
/**
 * TemPlaza Elements Elementor Testimonial
 *
 * @version     1.0.0
 * @author      TemPlaza
 * @package     TemPlaza/Classes
 * @category    Classes
 */


/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'UIPro_El_Templaza_Image' ) ) {
	/**
	 * Class UIPro_El_Templaza_Image
	 */
	class UIPro_El_Templaza_Image extends UIPro_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'UIPro_Config_Templaza_Image';

        public function get_template_name() {
            $template_name  = parent::get_template_name();

            $settings       = $this -> get_settings_for_display();
            if(!$template_name) {
                $template_name = (isset($settings['layout']) && $settings['layout'] != '') ? $settings['layout'] : 'base';
            }

            return $template_name;

        }

	}
}