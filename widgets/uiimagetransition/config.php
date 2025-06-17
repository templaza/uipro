<?php
/**
 * UIPro Heading config class
 *
 * @version     1.0.0
 * @author      TemPlaza
 * @package     UIPro/Classes
 * @category    Classes
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


if ( ! class_exists( 'UIPro_Config_UIImageTransition' ) ) {
	/**
	 * Class UIPro_Config_UIImageTransition
	 */
	class UIPro_Config_UIImageTransition extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiimagetransition';
			self::$name = esc_html__( 'TemPlaza: UI Image Transition', 'uipro' );
			self::$desc = esc_html__( 'Add UI Image Transition.', 'uipro' );
			self::$icon = 'eicon-e-image';
			parent::__construct();

		}

        public function get_styles() {
            return array(
                'uiimagetransition' => array(
                    'src'   =>  'style.css'
                )
            );
        }
        public function get_scripts() {
            return array(
                'uipro-imagetransition' => array(
                    'src'   =>  'hover-effect.umd.js',
                    'deps'  =>  array('jquery')
                )
            );
        }

		/**
		 * @return array
		 */
		public function get_options() {

            $store_id   = md5(__METHOD__);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

			// options
			$options = array(
				//Image Settings
				array(
					'type'          =>  Controls_Manager::MEDIA,
					'id'          => 'image1',
					'label'         => esc_html__('Image 1', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				),

				array(
					'type'          =>  Controls_Manager::MEDIA,
					'id'          => 'image2',
					'label'         => esc_html__('Image 2', 'uipro'),
					'description'         => esc_html__('Choose image same scale image 1', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				),
                array(
                    'name'            => 'image_width',
                    'label'         => esc_html__( 'Image width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'size_units' => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 2000
                        ],
                    ],
                    'default' => [
                        'size' => 450,
                        'unit' => 'px',
                    ],

                    'selectors' => [
                        '{{WRAPPER}} .grid__item' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'start_section' => 'image_settings',
                    'section_name'  => esc_html__('Image Settings', 'uipro')
                ),
                array(
                    'name'            => 'image_height',
                    'label'         => esc_html__( 'Image Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'size_units' => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 2000
                        ],
                    ],
                    'default' => [
                        'size' => 450,
                        'unit' => 'px',
                    ],

                    'selectors' => [
                        '{{WRAPPER}} .grid__item' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ),

                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'image2_radius',
                    'label'         => esc_html__( 'Image border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .grid__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'id'        => 'image_transition_style',
                    'label'     => esc_html__( 'Images Transition', 'uipro' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => array(
                        '1'    => esc_html__('Style 1', 'uipro'),
                        '2'    => esc_html__('Style 2', 'uipro'),
                        '3'    => esc_html__('Style 3', 'uipro'),
                        '4'    => esc_html__('Style 4', 'uipro'),
                        '5'    => esc_html__('Style 5', 'uipro'),
                        '6'    => esc_html__('Style 6', 'uipro'),
                        '7'    => esc_html__('Style 7', 'uipro'),
                        '8'    => esc_html__('Style 8', 'uipro'),
                        '9'    => esc_html__('Style 9', 'uipro'),
                        '10'    => esc_html__('Style 10', 'uipro'),
                        '11'    => esc_html__('Style 11', 'uipro'),
                        '12'    => esc_html__('Style 12', 'uipro'),
                        '13'    => esc_html__('Style 13', 'uipro'),
                        '14'    => esc_html__('Style 14', 'uipro'),
                        '15'    => esc_html__('Style 15', 'uipro'),
                        '16'    => esc_html__('Style 16', 'uipro'),
                    ),
                    'default'   => '1',
                    'start_section' => 'image_transition',
                    'section_name'  => esc_html__('Image Transition', 'uipro')
                ),
                array(
                    'id'        => 'image_easing',
                    'label'     => esc_html__( 'Easing', 'uipro' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => array(
                        'power1.in'    => esc_html__('power1.in', 'uipro'),
                        'power1.inOut'    => esc_html__('power1.inOut', 'uipro'),
                        'power1.out'    => esc_html__('power1.out', 'uipro'),
                        'power2.in'    => esc_html__('power2.in', 'uipro'),
                        'power2.inOut'    => esc_html__('power2.inOut', 'uipro'),
                        'power2.out'    => esc_html__('power2.out', 'uipro'),
                        'power3.in'    => esc_html__('power3.in', 'uipro'),
                        'power3.inOut'    => esc_html__('power3.inOut', 'uipro'),
                        'power3.out'    => esc_html__('power3.out', 'uipro'),
                        'power4.in'    => esc_html__('power4.in', 'uipro'),
                        'power4.inOut'    => esc_html__('power4.inOut', 'uipro'),
                        'power4.out'    => esc_html__('power4.out', 'uipro'),
                        'back.in'    => esc_html__('back.in', 'uipro'),
                        'back.inOut'    => esc_html__('back.inOut', 'uipro'),
                        'back.out'    => esc_html__('back.out', 'uipro'),
                        'circ.in'    => esc_html__('circ.in', 'uipro'),
                        'circ.inOut'    => esc_html__('circ.inOut', 'uipro'),
                        'circ.out'    => esc_html__('circ.out', 'uipro'),
                        'Sine.easeOut'    => esc_html__('Sine.easeOut', 'uipro'),
                        'Circ.easeOut'    => esc_html__('Circ.easeOut', 'uipro'),
                        'steps'    => esc_html__('steps', 'uipro'),
                    ),
                    'default'   => 'Sine.easeOut',
                ),
                array(
                    'name'            => 'image_intensity',
                    'label'         => esc_html__( 'Intensity', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'default'   => array(
                        'size'  => -0.65,
                        'unit'  => 'px'
                    ),
                ),
                array(
                    'name'            => 'image_speedin',
                    'label'         => esc_html__( 'SpeedIn', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'default'   => array(
                        'size'  => 1.2,
                        'unit'  => 'px'
                    ),
                ),
                array(
                    'name'            => 'image_speedout',
                    'label'         => esc_html__( 'SpeedOut', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'default'   => array(
                        'size'  => 1.2,
                        'unit'  => 'px'
                    ),
                ),
			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

		public function get_template_name() {
			return 'base';
		}
	}
}