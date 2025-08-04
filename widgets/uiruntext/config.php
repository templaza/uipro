<?php
/**
 * UIPro Run Text config class
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


if ( ! class_exists( 'UIPro_Config_UIRunText' ) ) {
	/**
	 * Class UIPro_Config_UIRunText
	 */
	class UIPro_Config_UIRunText extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_UIRunText constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiruntext';
			self::$name = esc_html__( 'TemPlaza: Run Text', 'uipro' );
			self::$desc = esc_html__( 'Add Text running.', 'uipro' );
			self::$icon = 'eicon-ellipsis-h';
			parent::__construct();

		}
        public function get_styles() {
            return ['uiruntext' => array(
                'src'   => 'style.css',
                'ver' => time()
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

            $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'text_title', [
                    'label' => __( 'Title', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'text_image',
                [
                    'type'          =>  Controls_Manager::ICONS,
                    'id'          => 'icon',
                    'label'         => esc_html__('Select Icon:', 'uipro'),
                ]
            );

			// options
			$options = array(
				//Content Settings
                array(
                    'id'        => 'layout',
                    'label'     => esc_html__( 'Layout', 'uipro' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => array(
                        'base'      => esc_html__('Default', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
                array(
                    'type'      => Controls_Manager::REPEATER,
                    'name'      => 'uiruntext',
                    'label'     => esc_html__( 'Ui Run Text', 'uipro' ),
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'text_title' => esc_html__( 'Add Text Here', 'uipro' ),
                        ],
                    ],
                    'title_field' => __( 'Title item', 'uipro' ),
                ),

				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'text_typography',
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .text-inner',

				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'text_color',
					'label'         => esc_html__('Text Color', 'uipro'),
					'description'   => esc_html__('Set the color of content.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .text-inner' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'text_hover_color',
					'label'         => esc_html__('Text Hover Color', 'uipro'),
					'description'   => esc_html__('Set the hover color of content.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .text-inner:hover' => 'color: {{VALUE}}',
					],
				),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'text_stroke',
                    'label'         => esc_html__('Text stroke', 'uipro'),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '0',
                ),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'text_stroke_color',
					'label'         => esc_html__('Text stroke Color', 'uipro'),
					'description'   => esc_html__('Set the stroke color of content.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .text-inner' => '-webkit-text-stroke-color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'text_stroke', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
				),
                array(
                    'name'          => 'text_stroke_width',
                    'label' => __( 'Stroke width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .text-inner' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'text_stroke', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'icon_size',
                    'label' => __( 'Icon Size', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 64,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .text-icon' => 'font-size: {{SIZE}}{{UNIT}}; width:{{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .text-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .text-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'icon_margin',
                    'label'         => esc_html__( 'Icon margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .text-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'icon_color',
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'description'   => esc_html__('Set the color of icon.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .text-icon' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .text-icon svg' => 'fill: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'direction_style',
                    'label' => esc_html__( 'Direction', 'uipro' ),
                    'default' => '',
                    'options' => [
                        'left' => esc_html__('Left', 'uipro'),
                        'right' => esc_html__('Right', 'uipro'),
                        'up' => esc_html__('Right', 'uipro'),
                        'down' => esc_html__('Down', 'uipro'),
                    ],
                    'start_section' => 'animate',
                    'section_name'      => esc_html__('Animation Settings', 'uipro')
                ),
                array(
                    'name'          => 'scrollamount',
                    'label' => __( 'Sets the amount of scrolling', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 6,
                    ],
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