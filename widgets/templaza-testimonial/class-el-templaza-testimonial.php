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

if ( ! class_exists( 'UIPro_El_Templaza_Testimonial' ) ) {
	/**
	 * Class UIPro_El_Templaza_Testimonial
	 */
	class UIPro_El_Templaza_Testimonial extends UIPro_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'UIPro_Config_Templaza_Testimonial';

        public function get_template_name() {
            $template_name  = parent::get_template_name();

            $settings       = $this -> get_settings_for_display();
            if(!$template_name) {
                $template_name = (isset($settings['layout']) && $settings['layout'] != '') ? $settings['layout'] : 'base';
            }

            return $template_name;

        }

//		/**
//		 * Register controls.
//		 */
//		protected function _register_controls() {
//			$this->start_controls_section(
//				'el-gallery-posts', [ 'label' => esc_html__( 'Thim: Gallery Posts', 'eduma' )]
//			);
//
//			$controls = \Thim_Builder_El_Mapping::mapping( $this->options() );
//
//			foreach ( $controls as $key => $control ) {
//				$this->add_control( $key, $control );
//			}
//
//			$this->end_controls_section();
//		}
	}
}