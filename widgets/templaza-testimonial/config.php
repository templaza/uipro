<?php
/**
 * UIPro Ui Icon config class
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

if ( ! class_exists( 'UIPro_Config_Templaza_Testimonial' ) ) {
	/**
	 * Class UIPro_Config_Templaza_Testimonial
	 */
	class UIPro_Config_Templaza_Testimonial extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Templaza_Testimonial constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'templaza-testimonial';
			self::$name = esc_html__( 'TemPlaza: Testimonial', 'uipro' );
			self::$desc = esc_html__( 'Display Testimonial.', 'uipro' );
			self::$icon = 'eicon-blockquote';
            self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();
		}

        public function get_styles() {
            return array(
                'templaza-testimonial-style' => array(
                    'src'   =>  'style.css'
                )
            );
        }
        public function get_scripts() {
            return array(
                'templaza-testimonial-script' => array(
                    'src'   =>  'slick.js',
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

            $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'quote_title', [
                    'label' => __( 'Title', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'quote_content', [
                    'label' => __( 'Content quote', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => __( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'quote_author', [
                    'label' => __( 'Author', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'author_position', [
                    'label' => __( 'Author Position', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
			$repeater->add_control(
				'author_image',
				[
					'type'          =>  Controls_Manager::MEDIA,
					'id'          => 'image',
					'label'         => esc_html__('Select Avatar Image:', 'uipro'),
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'author_image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'full',
				]
			);
            $repeater->add_control(
                'author_rating',
                [
                    'type'          =>  Controls_Manager::SWITCHER,
                    'label'         => esc_html__('Enable Rating:', 'uipro'),
                ]
            );

			// options
			$options = array(
                array(
                    'id'        => 'layout',
                    'label'     => esc_html__( 'Layout', 'uipro' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => array(
                        'base'      => esc_html__('Default', 'uipro'),
                        'style1'    => esc_html__('Custom style 1', 'uipro'),
                        'style2'    => esc_html__('Custom style 2', 'uipro'),
                        'style3'    => esc_html__('Custom style 3', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
				array(
					'type'      => Controls_Manager::REPEATER,
                    'name'      => 'templaza-testimonial',
					'label'     => esc_html__( 'Testimonial', 'uipro' ),
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'quote_content' => ''
                        ],
                    ],
                    'title_field' => __( 'Quote item', 'uipro' ),
				),
                array(
                    'id'        => 'gap',
                    'label'     => esc_html__( 'Item Gap', 'uipro' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => array(
                        'default'      => esc_html__('Default', 'uipro'),
                        'small'    => esc_html__('Small', 'uipro'),
                        'medium'    => esc_html__('Medium', 'uipro'),
                        'large'    => esc_html__('Large', 'uipro'),
                        'collapse'    => esc_html__('Collapse', 'uipro'),
                    ),
                    'default'   => 'base',
                    'start_section' => 'item-options',
                    'section_name'  => esc_html__( 'Item options', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'testimonial_box_padding',
                    'label'         => esc_html__( 'Item Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slider-items > li .tz-testimonial-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .templaza-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],

                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'testimonial_box_margin',
                    'label'         => esc_html__( 'Item Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slider-items > li .tz-testimonial-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Item background color', 'uipro' ),
                    'name'  => 'testimonial_box_bg',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider-items > li .tz-testimonial-inner' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'item_border_radius',
                    'label'         => esc_html__( 'Item border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slider-items > li .tz-testimonial-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'item_border',
                    'label'         => esc_html__('Item Border', 'uipro'),
                    'selector' => '{{WRAPPER}} .uk-slider-items > li .tz-testimonial-inner',
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'item_shadow',
                    'label'     => esc_html__( 'Item Box Shadow', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::BOX_SHADOW,
                    'name'          =>  'item_box_shadow',
                    'label'         => esc_html__( 'Item Shadow', 'uipro' ),
                    'condition'     => array(
                        'item_shadow'    => 'yes'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider-items > li .tz-testimonial-inner' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SELECT,
                    'name'      => 'item_width',
                    'label'     => esc_html__( 'Item width', 'uipro' ),
                    'options'       => array(
                        '' => esc_html__('auto', 'uipro'),
                        'custom' => esc_html__('Custom', 'uipro'),
                    ),
                    'default'       => '',
                ),
                array(
                    'name'            => 'item_width_custom',
                    'label'         => esc_html__( 'Item width custom', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider-items > li' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'item_width'    => 'custom'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'content_margin',
                    'label'         => esc_html__( 'Content Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .templaza_quote_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'content_padding',
                    'label'         => esc_html__( 'Content Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .templaza_quote_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'content_block_padding',
                    'label'         => esc_html__( 'Content Block Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-testimonial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'avata_margin',
                    'label'         => esc_html__( 'Avatar Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-testimonial-avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'avatar_arrow',
                    'label'     => esc_html__( 'Show Avatar Arrow', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style3'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'avatar_arrow_width',
                    'label' => esc_html__( 'Arrow width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 10,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'avatar_arrow', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .style3.yes .slick-center .ui-testimonial-avatar::after' => 'border-width: {{SIZE}}{{UNIT}}; margin-left: -{{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'avatar_arrow_bottom',
                    'label' => esc_html__( 'Arrow Offset Bottom', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => -10,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'avatar_arrow', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .style3.yes .slick-center .ui-testimonial-avatar::after' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Arrow color', 'uipro' ),
                    'name'  => 'arrow_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .style3.yes .slick-center .ui-testimonial-avatar::after' => 'border-top-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'avatar_arrow', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'quote_icon',
                    'label'         => esc_html__( 'Quote Icon', 'uipro' ),
                ),
                array(
                    'type'      => Controls_Manager::SELECT,
                    'name'      => 'testimonial_slider_wrap',
                    'label'     => esc_html__( 'Slider visible', 'uipro' ),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'tz-visible' => esc_html__('Visible', 'uipro'),
                        'tz-visible-right' => esc_html__('Visible right', 'uipro'),
                        'tz-visible-left' => esc_html__('Visible left', 'uipro'),
                    ),
                    'default'       => '',
                    'start_section' => 'slider-options',
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
                    'condition'     => array(
                        'layout!'    => 'style1'
                    ),
                ),

                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'testimonial_slider_autoplay',
                    'label'     => esc_html__( 'Autoplay', 'uipro' ),
                ),

                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'testimonial_slider_effect',
                    'label'     => esc_html__( 'Fade Effect', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style3'],
                            ['name' => 'testimonial_slider_number', 'operator' => '===', 'value' => 1],
                        ],
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'testimonial_slider_center',
                    'label'     => esc_html__( 'Center', 'uipro' ),
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'testimonial_slider_navigation',
                    'label'     => esc_html__( 'Navigation', 'uipro' ),
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'testimonial_slider_navigation_margin',
                    'label'         => esc_html__( 'Nav Block Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slidenav-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => '!=', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'testimonial_slider_navigation_pre_margin',
                    'label'         => esc_html__( 'Previous Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slidenav-previous' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => '!=', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'testimonial_slider_navigation_next_margin',
                    'label'         => esc_html__( 'Next Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slidenav-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => '!=', 'value' => 'style1'],
                        ],
                    ],
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'testimonial_slider_navigation_position',
					'label'         => esc_html__( 'Navigation Position', 'uipro' ),
					'options'       => array(
						'' => __('Default', 'uipro'),
						'uk-position-top-left' => __('Top Left', 'uipro'),
						'uk-position-top-right' => __('Top Right', 'uipro'),
						'uk-position-bottom-left' => __('Bottom Left', 'uipro'),
						'uk-position-bottom-right' => __('Bottom Right', 'uipro'),
						'custom' => __('Custom', 'uipro'),
					),
					'default'       => '',
					'conditions' => [
						'terms' => [
							['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
							['name' => 'layout', 'operator' => '!=', 'value' => 'style1'],
						],
					],
				),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'testimonial_slider_navigation_outside',
                    'label'     => esc_html__( 'Navigation outside', 'uipro' ),
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
                    'conditions' => [
	                    'terms' => [
		                    ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
		                    ['name' => 'testimonial_slider_navigation_position', 'operator' => '===', 'value' => ''],
	                    ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::CHOOSE,
                    'id'            => 'testimonial_slider_nav_position_x',
                    'label'         => esc_html__( 'Nav Horizontal Orientation', 'uipro' ),
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default'       => 'left',
                    'condition'     => array(
                        'testimonial_slider_navigation_position'    => 'custom'
                    ),
                ),
                array(
                    'name'          => 'testimonial_slider_nav_offsetx',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation_position', 'operator' => '===', 'value' => 'custom'],
                            ['name' => 'testimonial_slider_nav_position_x', 'operator' => '===', 'value' => 'left'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .uk-slidenav-container' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'testimonial_slider_nav_offsetx_right',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation_position', 'operator' => '===', 'value' => 'custom'],
                            ['name' => 'testimonial_slider_nav_position_x', 'operator' => '===', 'value' => 'right'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .uk-slidenav-container' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::CHOOSE,
                    'id'            => 'testimonial_slider_nav_position_y',
                    'label'         => esc_html__( 'Nav Vertical Orientation', 'uipro' ),
                    'options' => [
                        'top' => [
                            'title' => esc_html__( 'Top', 'uipro' ),
                            'icon' => 'eicon-v-align-top',
                        ],
                        'bottom' => [
                            'title' => esc_html__( 'Bottom', 'uipro' ),
                            'icon' => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'       => 'bottom',
                    'condition'     => array(
                        'testimonial_slider_navigation_position'    => 'custom'
                    ),
                ),
                array(
                    'name'          => 'testimonial_slider_nav_offsety',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation_position', 'operator' => '===', 'value' => 'custom'],
                            ['name' => 'testimonial_slider_nav_position_y', 'operator' => '===', 'value' => 'top'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .uk-slidenav-container' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'testimonial_slider_nav_offsety_bottom',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation_position', 'operator' => '===', 'value' => 'custom'],
                            ['name' => 'testimonial_slider_nav_position_y', 'operator' => '===', 'value' => 'bottom'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .uk-slidenav-container' => 'bottom: {{SIZE}}{{UNIT}}; top:auto;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'nav_preview_icon',
                    'label'         => esc_html__( 'Nav Preview Icon', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style3']],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'nav_next_icon',
                    'label'         => esc_html__( 'Nav Next Icon', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style3']],
                        ],
                    ],
                ),

                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'nav_border',
                    'label'         => esc_html__('Nav Border', 'uipro'),
                    'selector' => '{{WRAPPER}} .uk-slider .uk-slidenav',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => '!=', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'nav_radius',
                    'label'         => esc_html__( 'Nav radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => '!=', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Nav background color', 'uipro' ),
                    'name'  => 'nav_bg',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .slick-arrow' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => '!=', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Nav color', 'uipro' ),
                    'name'  => 'nav_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav, {{WRAPPER}} .slick-arrow' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Nav Hover background color', 'uipro' ),
                    'name'  => 'nav_bg_hover',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav:hover' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .slick-arrow:hover' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => '!=', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Nav Hover color', 'uipro' ),
                    'name'  => 'nav_color_hover',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav:hover, {{WRAPPER}} .slick-arrow:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),


                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'testimonial_slider_dot',
                    'label'     => esc_html__( 'Show dots', 'uipro' ),
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
                ),
                array(
                    'label' => esc_html__( 'Dots Slider Color', 'uipro' ),
                    'name'  => 'quote_dots_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-dotnav>*>*' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .uk-dotnav>.uk-active>*, {{WRAPPER}} .uk-dotnav li:hover>*' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .slick-dots li button, .slick-dots li button:hover' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'testimonial_slider_dot_bottom',
                    'label'         => __( 'Wrap Dot Bottom', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => [ 'px'],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                            'step' => 1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style3'],
                        ],
                    ],
                ),
                array(
                    'type'      => Controls_Manager::NUMBER,
                    'name'      => 'testimonial_slider_number',
                    'label'     => esc_html__( 'Number item', 'uipro' ),
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'testimonial_slider_dot_position',
                    'label'         => esc_html__( 'Dots Position', 'uipro' ),
                    'description'   => esc_html__( 'Select the dots position.', 'uipro' ),
                    'start_section' => 'position-options',
                    'section_name'  => esc_html__( 'Position options', 'uipro' ),
                    'options'       => array(
                        ''          => esc_html__('Default', 'uipro'),
                        'absolute'  => esc_html__('absolute', 'uipro'),
                    ),
                    'default'       => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style2','base']],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-dotnav' => 'position: {{VALUE}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::CHOOSE,
                    'id'            => 'testimonial_slider_dot_position_x',
                    'label'         => esc_html__( 'Horizontal Orientation', 'uipro' ),
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default'       => 'left',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style2','base']],
                        ],
                    ],
                ),
                array(
                    'name'          => 'testimonial_slider_dot_offsetx',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot_position_x', 'operator' => '===', 'value' => 'left'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style2','base']],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-dotnav' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'testimonial_slider_dot_offsetx_right',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot_position_x', 'operator' => '===', 'value' => 'right'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style2','base']],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-dotnav' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::CHOOSE,
                    'id'            => 'testimonial_slider_dot_position_y',
                    'label'         => esc_html__( 'Vertical Orientation', 'uipro' ),
                    'options' => [
                        'top' => [
                            'title' => esc_html__( 'Top', 'uipro' ),
                            'icon' => 'eicon-v-align-top',
                        ],
                        'bottom' => [
                            'title' => esc_html__( 'Bottom', 'uipro' ),
                            'icon' => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'       => 'bottom',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style2','base']],
                        ],
                    ],
                ),
                array(
                    'name'          => 'testimonial_slider_dot_offsety',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot_position_y', 'operator' => '===', 'value' => 'top'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style2','base']],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-dotnav' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'testimonial_slider_dot_offsety_bottom',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_dot_position_y', 'operator' => '===', 'value' => 'bottom'],
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style2','base']],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-dotnav' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'testimonial_slider_icon_position',
                    'label'         => esc_html__( 'Quote icon Position', 'uipro' ),
                    'options'       => array(
                        ''          => esc_html__('Default', 'uipro'),
                        'absolute'  => esc_html__('absolute', 'uipro'),
                    ),
                    'default'       => '',
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .quote-icon' => 'position: {{VALUE}};',
                        '{{WRAPPER}} .uk-slider-items > li' => 'position: relative;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::CHOOSE,
                    'id'            => 'testimonial_slider_icon_position_x',
                    'label'         => esc_html__( 'Horizontal Orientation', 'uipro' ),
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default'       => 'left',
                    'condition'     => array(
                        'testimonial_slider_icon_position'    => 'absolute'
                    ),
                ),
                array(
                    'name'          => 'testimonial_slider_icon_offsetx',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_icon_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'testimonial_slider_icon_position_x', 'operator' => '===', 'value' => 'left'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .quote-icon' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'testimonial_slider_icon_offsetx_right',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_icon_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'testimonial_slider_icon_position_x', 'operator' => '===', 'value' => 'right'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .quote-icon' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::CHOOSE,
                    'id'            => 'testimonial_slider_icon_position_y',
                    'label'         => esc_html__( 'Vertical Orientation', 'uipro' ),
                    'options' => [
                        'top' => [
                            'title' => esc_html__( 'Top', 'uipro' ),
                            'icon' => 'eicon-v-align-top',
                        ],
                        'bottom' => [
                            'title' => esc_html__( 'Bottom', 'uipro' ),
                            'icon' => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'       => 'bottom',
                    'condition'     => array(
                        'testimonial_slider_icon_position'    => 'absolute'
                    ),
                ),
                array(
                    'name'          => 'testimonial_slider_icon_offsety',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_icon_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'testimonial_slider_icon_position_y', 'operator' => '===', 'value' => 'top'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .quote-icon' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'testimonial_slider_icon_offsety_bottom',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'testimonial_slider_icon_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'testimonial_slider_icon_position_y', 'operator' => '===', 'value' => 'bottom'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-widget-templaza-testimonial .quote-icon' => 'bottom: {{SIZE}}{{UNIT}}; top:auto;',
                    ],
                ),
				array(
					'name'          => 'testimonial_quote_size',
					'label' => esc_html__( 'Quote Size', 'uipro' ),
					'description'   => esc_html__('Size of quote icon', 'uipro'),
					'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => 5,
							'max' => 300,
							'step' => 1,
						],
					],
					'default' => [
						'size' => 50,
					],
                    'selectors' => [
                        '{{WRAPPER}} .quote-icon i' => 'font-size: {{SIZE}}px;',
                        '{{WRAPPER}} .quote-icon ' => 'width: {{SIZE}}px;',
                    ],
					'start_section' => 'style',
					'section_tab'   => Controls_Manager::TAB_STYLE,
					'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'condition'     => array(
                        'layout!'    => 'style1'
                    ),
				),
                array(
					'name'          => 'testimonial_quote_style1_size',
					'label' => esc_html__( 'Quote Size', 'uipro' ),
					'description'   => esc_html__('Size of quote icon', 'uipro'),
					'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
					],
					'default' => [
						'size' => 50,
					],
					'start_section' => 'style',
					'section_tab'   => Controls_Manager::TAB_STYLE,
					'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .quote-icon i' => 'font-size: {{SIZE}}px;',
                        '{{WRAPPER}} .quote-icon ' => 'width: {{SIZE}}px;',
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
				),
                array(
                    'label' => esc_html__( 'Quote icon Color', 'uipro' ),
                    'name'  => 'quote_icon_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .quote-icon i, {{WRAPPER}} .quote-icon ' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'name'          => 'rating_icon_size',
                    'label' => __( 'Rating icon Size', 'uipro' ),
                    'description'   => esc_html__('Size of rating icon', 'uipro'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 18,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza_quote_author_rating i' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Rating icon Color', 'uipro' ),
                    'name'  => 'rating_icon_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .templaza_quote_author_rating i' => 'color: {{VALUE}}',
                    ],
                ),
				array(
					'id'            => 'avatar_size',
					'label'         => __( 'Avatar Width', 'uipro' ),
					'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ui-testimonial-avatar .uk-inline-clip' => 'width: {{SIZE}}{{UNIT}};',
					],
				),
				array(
					'id'            => 'avatar_size_height',
					'label'         => __( 'Avatar Height', 'uipro' ),
					'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ui-testimonial-avatar .uk-inline-clip' => 'height: {{SIZE}}{{UNIT}};',
					],
				),
                array(
                    'id'            => 'avatar_center_size',
                    'label'         => __( 'Avatar Center Scale', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 0.1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .slick-center .ui-testimonial-avatar .uk-inline-clip' => 'transform: scale({{SIZE}}1);',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style3'],
                            ['name' => 'testimonial_slider_center', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'avatar_border',
					'label'         => esc_html__( 'Avatar Border', 'uipro' ),
					'description'   => esc_html__( 'Select the image\'s border style.', 'uipro' ),
					'options'       => array(
						'' => __('None', 'uipro'),
						'uk-border-circle' => __('Circle', 'uipro'),
						'uk-border-rounded' => __('Rounded', 'uipro'),
						'uk-border-pill' => __('Pill', 'uipro'),
					),
					'default'       => '',
				),
                array(
                    'label' => esc_html__( 'Avatar Border Custom', 'uipro' ),
                    'name'          => 'avatar_border_custom',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .ui-testimonial-avatar .uk-inline-clip',
                ),
                array(
                    'label' => esc_html__( 'Avatar Border Hover color', 'uipro' ),
                    'name'          => 'avatar_border_hover_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-testimonial-avatar .uk-inline-clip:hover' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .slick-current .ui-testimonial-avatar .uk-inline-clip' => 'border-color: {{VALUE}}',
                    ]
                ),
                array(
                    'id'            => 'wrap_avatar_size',
                    'label'         => __( 'Wrap Avatar max width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .testimonial-thumbs' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style3','style1']],
                        ],
                    ],
                    'separator'     => 'after',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'quote_title_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .templaza_quote_title',
                    'separator'     => 'before',

                ),
                array(
                    'label' => esc_html__( 'Title Color', 'uipro' ),
                    'name'  => 'quote_title_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .templaza_quote_title' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'quote_content_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Content Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .templaza_quote_content',
                    'separator'     => 'before',

                ),
                array(
                    'label' => esc_html__( 'Content Color', 'uipro' ),
                    'name'  => 'quote_content_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .templaza_quote_content' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Next, Preview Color', 'uipro' ),
                    'name'  => 'quote_next_preview_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-arrow' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Next, Preview Hover Color', 'uipro' ),
                    'name'  => 'quote_next_preview_hover_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-arrow:hover' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'quote_author_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Author Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .templaza_quote_author',

                ),
                array(
                    'label' => esc_html__( 'Author Color', 'uipro' ),
                    'name'  => 'quote_author_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .templaza_quote_author' => 'color: {{VALUE}}',
                    ],
                ),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'quote_designation_typography',
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Designation Font', 'uipro'),
					'selector'      => '{{WRAPPER}} .templaza_quote_author_position',

				),
                array(
                    'label' => esc_html__( 'Designation Color', 'uipro' ),
                    'name'  => 'quote_designation_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .templaza_quote_author_position' => 'color: {{VALUE}}',
                    ],
                ),

			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

	}
}