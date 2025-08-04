<?php
/**
 * UIPro UI Accordion Slider config class
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


if ( ! class_exists( 'UIPro_Config_UIAccordionSlider' ) ) {
	/**
	 * Class UIPro_Config_UIAccordionSlider
	 */
	class UIPro_Config_UIAccordionSlider extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_UIAccordionSlider constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiaccordionslider';
			self::$name = esc_html__( 'TemPlaza: UI Accordion Slider', 'uipro' );
			self::$desc = esc_html__( 'Add UI Accordion Slider.', 'uipro' );
			self::$icon = 'eicon-slider-push';
			parent::__construct();

		}
        public function get_styles() {
            return array(
                'uiaccordionslider' => array(
                    'src'   =>  'style.css',
                    'ver'   =>  time(),
                )
            );
        }
        public function get_scripts() {
            return array(
                'uiaccordionslider-script' => array(
                    'src'   =>  'uiaccordionslider-script.js',
                    'ver'   =>  time(),
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

			$repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'image',
                [
                    'type'          =>  Controls_Manager::MEDIA,
                    'label'         => esc_html__('Select Image:', 'uipro'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $repeater->add_control(
                'video',
                [
                    'type'          =>  Controls_Manager::MEDIA,
                    'label'         => esc_html__('Select Video:', 'uipro'),
                    'media_types'   => ['video'],
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
			$repeater->add_control(
				'letter', [
					'label' => __( 'Letter', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'title', [
					'label' => __( 'Title', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'meta', [
					'label' => __( 'Meta', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'content',
				[
					'label'         => esc_html__('Content', 'uipro'),
					'type' => Controls_Manager::WYSIWYG,
					'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in semper sem. Praesent elit erat, suscipit sed varius ut, porta sit amet lorem. Duis eget vulputate turpis. Vivamus maximus ac nisl vel suscipit.', 'uipro' ),
					'placeholder' => __( 'Type your description here', 'uipro' ),
				]
			);
            $repeater->add_control(
                'button', [
                    'label' => __( 'Button Text', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'link',
                [
                    'label' => __( 'Button Link', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'uipro' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                ]
            );

			// options
			$options = array(
				array(
					'type'      => Controls_Manager::REPEATER,
					'name'      => 'uiaccordionslider',
					'label'     => esc_html__( 'Slider Items', 'uipro' ),
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'title' => 'Item #1',
						],
					],
                    'title_field' => '{{{ title }}}',
				),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'icon',
                    'label'         => esc_html__('Select Icon:', 'uipro'),
                    'start_section' => 'icon_settings',
                    'section_name'      => esc_html__('Icon Settings', 'uipro')
                ),
                array(
                    'id'            => 'icon_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .slider-icon' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'id'            => 'icon_hover_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Icon Hover Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uiaccordion-slide:hover .slider-icon' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'icon_margin_custom',
                    'label'         => __( 'Content Custom Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .slider-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],

                ),
				//Title configure

				array(
					'name'            => 'title_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .slider-caption h2',
					'start_section' => 'title_settings',
					'section_name'      => esc_html__('Title Settings', 'uipro')
				),
				array(
					'id'            => 'custom_title_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Title Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .slider-caption h2' => 'color: {{VALUE}}',
					],
				),
                array(
                    'name'            => 'wrap_content_width',
                    'label'         => esc_html__( 'Wrap Title width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'size_units' => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 2000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 750,
                        'unit' => 'px',
                    ],

                    'selectors' => [
                        '{{WRAPPER}} .slider-caption' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'wrap_content_margin',
                    'label'         => __( 'Wrap Title Custom Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .slider-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],

                ),

				//Content style
				array(
					'name'          => 'content_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .uiaccordion-slider-content',
					'start_section' => 'content',
					'section_name'      => esc_html__('Content Settings', 'uipro')
				),
				array(
					'id'            => 'content_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .uiaccordion-slider-content' => 'color: {{VALUE}}',
					],
				),

                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'content_margin_custom',
                    'label'         => __( 'Content Custom Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uiaccordion-slider-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],

                ),

				// Image Settings
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'image_border',
					'label'         => esc_html__( 'Border', 'uipro' ),
					'description'   => esc_html__( 'Select the image\'s border style.', 'uipro' ),
					'options'       => array(
						'' => __('None', 'uipro'),
						'uk-border-circle' => __('Circle', 'uipro'),
						'uk-border-rounded' => __('Rounded', 'uipro'),
						'uk-border-pill' => __('Pill', 'uipro'),
					),
					'default'       => '',
					'start_section' => 'Image',
					'section_name'      => esc_html__('Image Settings', 'uipro')
				),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'image_first_overlay',
                    'label'         => esc_html__('Image active overlay', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .accordion-slider .uiaccordion-slide .overlay' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_margin',
                    'label'         => __( 'Button Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-accordion-slider-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'start_section' => 'Button',
                    'section_name'      => esc_html__('Button Settings', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-accordion-slider-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'button_border',
                    'label'         => esc_html__('Button Border', 'uipro'),
                    'selector' => '{{WRAPPER}} .ui-accordion-slider-btn',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_border-radius',
                    'label'         => esc_html__( 'Button border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-accordion-slider-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_color',
                    'label'         => esc_html__('Button Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-accordion-slider-btn' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_background',
                    'label'         => esc_html__('Button Background', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-accordion-slider-btn' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_color_hover',
                    'label'         => esc_html__('Button Hover', 'uipro'),
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .ui-accordion-slider-btn:hover' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_background_hover',
                    'label'         => esc_html__('Button Background Hover', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-accordion-slider-btn:hover' => 'background-color: {{VALUE}}',
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