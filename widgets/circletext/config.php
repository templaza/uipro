<?php
/**
 * UIPro Circle Text config class
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


if ( ! class_exists( 'UIPro_Config_CircleText' ) ) {
	/**
	 * Class UIPro_Config_CircleText
	 */
	class UIPro_Config_CircleText extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_CircleText constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'circletext';
			self::$name = esc_html__( 'TemPlaza: Circle Text', 'uipro' );
			self::$desc = esc_html__( 'Add Text rotate circle.', 'uipro' );
			self::$icon = 'eicon-circle-o';
			parent::__construct();

		}
        public function get_styles() {
            return ['circletext' => array(
                'src'   => 'style.css'
            )];
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
				//Content Settings
				array(
					'name'          => 'text',
					'label'         => esc_html__('Content', 'uipro'),
					'type' => Controls_Manager::TEXTAREA,
					'default' => __( 'Lorem ipsum dolor sit amet porta lobortis.', 'uipro' ),
					'placeholder' => __( 'Type your description here', 'uipro' ),
					'separator'     => 'before',
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'text_typography',
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .circletext textPath',
					'condition'     => array(
						'text!'    => ''
					),
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'text_color',
					'label'         => esc_html__('Text Color', 'uipro'),
					'description'   => esc_html__('Set the color of content.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} svg.circletext textPath' => 'color: {{VALUE}}',
					],
				),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'text_bg_color',
                    'label'         => esc_html__('Text Background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of content.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .circletext' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'text_radius',
                    'label'         => esc_html__( 'Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} svg.circletext' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),

                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'text_padding',
                    'label'         => esc_html__( 'Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} svg.circletext' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ),

                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'            => 'text_width',
                    'label'         => esc_html__( 'Width', 'uipro' ),
                    'responsive'    => true,
                    'size_units'    => ['px', '%'],
                    'range'         => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                        ],
                    ],
                    'default'   => [
                        'unit' => 'px',
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} svg.circletext' => 'max-width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .circletext-icon' => 'max-width: {{SIZE}}{{UNIT}};'
                    ]
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'icon',
                    'label'         => esc_html__('Select Icon:', 'uipro'),
                    'separator'     => 'before',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'icon_color',
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'description'   => esc_html__('Set the color of icon.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .circletext-icon i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .circletext-icon svg' => 'fill: {{VALUE}}',
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'text_hover_rotate',
                    'label'     => esc_html__( 'Rotate when hover', 'uipro' ),
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'text_hover_rotate_automatic',
                    'label'     => esc_html__( 'Auto Rotate', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'            => 'text_hover_duration',
                    'label'         => esc_html__( 'Duration', 'uipro' ),
                    'description'   => esc_html__( 'Duration (s)', 'uipro' ),
                    'responsive'    => true,
                    'size_units'    => ['s'],
                    'range'         => [
                        's' => [
                            'min' => 0,
                            'max' => 50,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'text_hover_rotate', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                    'selectors'  => ['{{WRAPPER}} svg.circletext' => 'animation-duration: {{SIZE}}{{UNIT}};']
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