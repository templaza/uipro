<?php
/**
 * UIPro Image Parallax config class
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


if ( ! class_exists( 'UIPro_Config_UIImageParallax' ) ) {
	/**
	 * Class UIPro_Config_UIImageParallax
	 */
	class UIPro_Config_UIImageParallax extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiimageparallax';
			self::$name = esc_html__( 'TemPlaza: UI Image Parallax', 'uipro' );
			self::$desc = esc_html__( 'Add UI Image Parallax.', 'uipro' );
			self::$icon = 'eicon-e-image';
			parent::__construct();

		}

        public function get_styles() {
            return array(
                'uiimageparallax' => array(
                    'src'   =>  'style.css',
                    'ver'  =>  time()
                )
            );
        }
        public function get_scripts() {
            return array(
                'uipro-imageparallax' => array(
                    'src'   =>  'imageparallax.js',
                    'deps'  =>  array('jquery'),
                    'ver'  =>  time()
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
					'id'          => 'image',
					'label'         => esc_html__('Image', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				),

                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'image_radius',
                    'label'         => esc_html__( 'Image border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uiimage-parallax-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'name'            => 'image_height',
                    'label'         => esc_html__( 'Image Custom Height', 'uipro' ),
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
                        '{{WRAPPER}} .uiimage-parallax' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'image_lightbox',
                    'label'         => esc_html__('Open Lightbox', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '1'
                ),
                array(
                    'name'            => 'image_border',
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'label' => esc_html__( 'Image Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .uiimage-parallax-media',

                ),
                array(
                    'type'          => Controls_Manager::TEXTAREA,
                    'name'          => 'title',
                    'label'         => esc_html__( 'Title', 'uipro' ),
                    'default'       => __('Your Heading Text Here', 'uipro'),
                    'description'   => esc_html__( 'Write the title for the heading.', 'uipro' ),
                    'start_section' => 'Title',
                    'section_name'      => esc_html__('Title Settings', 'uipro')
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'title_typography',
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uiimage-parallax-title',
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'title_color',
                    'label'         => esc_html__('Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uiimage-parallax-title' => 'color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::TEXTAREA,
                    'name'          => 'button_text',
                    'label'         => esc_html__( 'Button Text', 'uipro' ),
                    'default'       => __('Read more', 'uipro'),
                    'start_section' => 'Button',
                    'section_name'      => esc_html__('Button Settings', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_margin',
                    'label'         => __( 'Button Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uiimage-parallax-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uiimage-parallax-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'button_border',
                    'label'         => esc_html__('Button Border', 'uipro'),
                    'selector' => '{{WRAPPER}} .uiimage-parallax-btn',
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_border-radius',
                    'label'         => esc_html__( 'Button border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uiimage-parallax-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_color',
                    'label'         => esc_html__('Button Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uiimage-parallax-btn' => 'color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_background',
                    'label'         => esc_html__('Button Background', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uiimage-parallax-btn' => 'background-color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_color_hover',
                    'label'         => esc_html__('Button Hover', 'uipro'),
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .uiimage-parallax-btn:hover' => 'color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_background_hover',
                    'label'         => esc_html__('Button Background Hover', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uiimage-parallax-btn:hover' => 'background-color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'button_border_hover',
                    'label'         => esc_html__('Button Border Hover', 'uipro'),
                    'selector' => '{{WRAPPER}} .uiimage-parallax-btn:hover',
                    'condition'     => array(
                        'button_text!'    => ''
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