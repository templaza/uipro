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
use Elementor\Core\Schemes\Typography;

if ( ! class_exists( 'UIPro_Config_UIImage' ) ) {
	/**
	 * Class UIPro_Config_UIImage
	 */
	class UIPro_Config_UIImage extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiimage';
			self::$name = esc_html__( 'TemPlaza: UI Image', 'uipro' );
			self::$desc = esc_html__( 'Add UI Image Box.', 'uipro' );
			self::$icon = 'eicon-image';
			parent::__construct();

		}

        public function get_styles() {
            return array(
                'ui-image' => array(
                    'src'   =>  'style.css'
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
					'label'         => esc_html__('Select Image:', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Image_Size::get_type(),
					'name' => 'image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [],
					'include' => [],
					'default' => 'large',
				),
				array(
					'type'          => Controls_Manager::TEXT,
					'id'            => 'caption',
					'label'         => esc_html__( 'Caption', 'uipro' ),
					'default'       => __('Your Caption Text Here', 'uipro'),
					'description'   => esc_html__( 'Write the caption for the image.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
					'conditions' => [
						'terms' => [
							['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'image_border',
					'label'         => esc_html__( 'Border Radius', 'uipro' ),
					'description'   => esc_html__( 'Select the image\'s border radius style.', 'uipro' ),
					'options'       => array(
						'' => __('None', 'uipro'),
						'uk-border-circle' => __('Circle', 'uipro'),
						'uk-border-rounded' => __('Rounded', 'uipro'),
						'uk-border-pill' => __('Pill', 'uipro'),
						'border-custom' => __('Custom', 'uipro'),
					),
					'separator'     => 'before',
					'default'       => '',
					'conditions' => [
						'terms' => [
							['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
						],
					],
				),
                array(
                    'name'          => 'border_radius',
                    'label'         => esc_html__( 'Custom Border Radius', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'devices'       => [ 'desktop', 'tablet', 'mobile' ],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 500
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 15,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 10,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 5,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-image-detail' => 'border-radius: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_border', 'operator' => '===', 'value' => 'border-custom'],
                        ],
                    ],
                ),

				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'image_panel',
					'label'         => esc_html__('Blend Mode Settings', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'separator'     => 'before',
					'conditions' => [
						'terms' => [
							['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'id'            => 'blend_bg_color',
					'label'         => esc_html__('Background Color', 'uipro'),
					'description'   => esc_html__('Use the background color in combination with blend modes.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-blend' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
							['name' => 'image_panel', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'image_blend_modes',
					'label'         => esc_html__( 'Blend modes', 'uipro' ),
					'description'   => esc_html__( 'Determine how the image will blend with the background color.', 'uipro' ),
					'options'       => array(
						'' => __('None', 'uipro'),
						'uk-blend-multiply' => __('Multiply', 'uipro'),
						'uk-blend-screen' => __('Screen', 'uipro'),
						'uk-blend-overlay' => __('Overlay', 'uipro'),
						'uk-blend-darken' => __('Darken', 'uipro'),
						'uk-blend-lighten' => __('Lighten', 'uipro'),
						'uk-blend-color-dodge' => __('Color Dodge', 'uipro'),
						'uk-blend-color-burn' => __('Color Burn', 'uipro'),
						'uk-blend-hard-light' => __('Hard Light', 'uipro'),
						'uk-blend-soft-light' => __('Soft Light', 'uipro'),
						'uk-blend-difference' => __('Difference', 'uipro'),
						'uk-blend-exclusion' => __('Exclusion', 'uipro'),
						'uk-blend-hue' => __('Hue', 'uipro'),
						'uk-blend-color' => __('Color', 'uipro'),
						'uk-blend-luminosity' => __('Luminosity', 'uipro'),
					),
					'default'       => '',
					'conditions' => [
						'terms' => [
							['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
							['name' => 'image_panel', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'link_type',
					'label'         => esc_html__( 'Link Type', 'uipro' ),
					'options'       => array(
						'' => __('None', 'uipro'),
						'use_link' => __('Link', 'uipro'),
						'use_modal' => __('Modal', 'uipro'),
					),
					'separator'     => 'before',
					'default'       => '',
					'conditions' => [
						'terms' => [
							['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'type'          => Controls_Manager::URL,
					'id'            => 'link',
					'label'         => __( 'Image Url', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					'default'       => [
						'url'       => '',
					],
					'conditions' => [
						'terms' => [
							['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
							['name' => 'link_type', 'operator' => '===', 'value' => 'use_link'],
						],
					],
				),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'flash_effect',
                    'label'         => esc_html__('Flash Effect', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                    'start_section' => 'image_settings',
                    'section_name'  => esc_html__('Image Settings', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'image_transition',
                    'label'         => esc_html__( 'Transition', 'uipro' ),
                    'description'   => esc_html__( 'Select the image\'s transition style.', 'uipro' ),
                    'options'       => array(
                        '' => __('None', 'uipro'),
                        'scale-up' => __('Scales Up', 'uipro'),
                        'scale-down' => __('Scales Down', 'uipro'),
                        'ripple' => __('Ripple', 'uipro'),
                        'zoomin-roof' => __('Zoom in roof', 'uipro'),
                    ),
                    'default'       => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'ripple_width',
                    'label'         => __( 'Ripple Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 200,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'id'            => 'ripple_height',
                    'label'         => __( 'Ripple Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 200,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Ripple background color', 'uipro' ),
                    'name'  => 'ripple_bg',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles > div' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'roof_border_color',
                    'label'         => esc_html__('Roof Border Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::before' => 'border-right-color: {{VALUE}}',
                        '{{WRAPPER}} .zoomin-roof a::after' => 'border-left-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'roof_border_hover_color',
                    'label'         => esc_html__('Roof Border Hover Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'border-right-color: {{VALUE}}',
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'border-left-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'roof_left_hover_radius',
                    'label'         => esc_html__( 'Roof left hover Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'roof_right_hover_radius',
                    'label'         => esc_html__( 'Roof right hover Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'roof_hover-rotate',
                    'label' => __( 'Roof Hover rotate', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'deg' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -360,
                            'max' => 360,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'deg',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'transform: rotate({{SIZE}}{{UNIT}});',
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'transform: rotate(-{{SIZE}}{{UNIT}});',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_transform_left_hover',
                    'label'         => esc_html__( 'Roof left transform hover', 'uipro' ),
                    'description'   => esc_html__( 'Example: [translateX(-100%)] Read more: https://www.w3schools.com/cssref/css3_pr_transform.php ', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'transform: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_transform_right_hover',
                    'label'         => esc_html__( 'Roof right transform hover', 'uipro' ),
                    'description'   => esc_html__( 'Example: [translateX(100%)] Read more: https://www.w3schools.com/cssref/css3_pr_transform.php ', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'transform: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_left_transform',
                    'label'         => esc_html__( 'Roof left transform', 'uipro' ),
                    'description'   => esc_html__( 'Example: [top right] Read more: https://www.w3schools.com/cssref/css3_pr_transform-origin.php', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::before' => 'transform-origin: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_right_transform',
                    'label'         => esc_html__( 'Roof right transform', 'uipro' ),
                    'description'   => esc_html__( 'Example: [top left] Read more: https://www.w3schools.com/cssref/css3_pr_transform-origin.php', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::after' => 'transform-origin: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'border',
                    'label'         => esc_html__( 'Border', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-image-detail',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'box_shadow',
                    'label'         => esc_html__( 'Box Shadow', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-image-detail',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'image_cover',
                    'label'         => esc_html__( 'Image Cover', 'uipro' ),
                    'default'       => '',
                    'responsive'    => true,
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'border_hover',
                    'label'         => esc_html__( 'Border Hover', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-image-detail:hover',
                    'start_section' => 'image_hover_settings',
                    'section_name'  => esc_html__('Hover Settings', 'uipro')
                ),
                array(
                    'type'          => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'box_shadow_hover',
                    'label'         => esc_html__( 'Box Shadow Hover', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-image-detail:hover',
                    'separator'     => 'before',
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