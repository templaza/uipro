<?php
/**
 * UIPro Timeline config class
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

if ( ! class_exists( 'UIPro_Config_UITimeline' ) ) {
	/**
	 * Class UIPro_Config_UI_Button
	 */
	class UIPro_Config_UITimeline extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uitimeline';
			self::$name = esc_html__( 'TemPlaza: UI Timeline', 'uipro' );
			self::$desc = esc_html__( 'Add UI Timeline.', 'uipro' );
			self::$icon = 'eicon-button';
			parent::__construct();

		}

        public function get_styles() {
            return array(
                'ui-timeline' => array(
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

			$repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'title', [
                    'label' => __( 'Title', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'date',
                [
                    'label' => __( 'Timeline Date', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'meta', [
                    'label' => __( 'Meta Text', 'uipro' ),
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
                'image',
                [
                    'type'          =>  Controls_Manager::MEDIA,
                    'label'         => esc_html__('Select Image:', 'uipro'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );

			// options
			$options = array(
				array(
					'type'      => Controls_Manager::REPEATER,
					'name'      => 'timeline',
					'label'     => esc_html__( 'Timeline', 'uipro' ),
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'title' => 'Title Item',
						],
					],
					'title_field' => '{{{title}}}',
				),
                array(
                    'type'          => \Elementor\Group_Control_Image_Size::get_type(),
                    'name'          => 'image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                    'exclude'       => [ 'custom' ],
                    'include'       => [],
                    'default'       => 'large'
                ),
                array(
                    'id'            => 'layout',
                    'label'         => esc_html__( 'Layout', 'uipro' ),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => array(
                        'base'      => esc_html__('Default', 'uipro'),
                        'style1'    => esc_html__('Custom style 1', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
                array(
                    'id'            => 'timeline_background',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Time Line Background Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-timeline .uk-card' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'timeline_shadow',
                    'label'         => esc_html__('Time Line Box Shadow', 'uipro'),
                    'description'   => esc_html__('Set the Box Shadow of Time Line Box.', 'uipro'),
                    'selector' => '{{WRAPPER}} .ui-timeline .uk-card',

                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'item_margin_custom',
                    'label'         => esc_html__( 'Item custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-timeline-inner .uk-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),
                array(
                    'id'          => 'large_desktop_columns',
                    'label' => esc_html__( 'Large Desktop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '5',
                    'start_section' => 'timeframe_settings',
                    'section_name'      => esc_html__('Time Frame Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                ),
                array(
                    'id'          => 'desktop_columns',
                    'label' => esc_html__( 'Desktop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '5',
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                ),
                array(
                    'id'          => 'laptop_columns',
                    'label' => esc_html__( 'Laptop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '3',
                    'condition'     => array(
                'layout'    => 'base'
            ),
                ),
                array(
                    'id'          => 'tablet_columns',
                    'label' => esc_html__( 'Tablet Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '2',
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                ),
                array(
                    'id'          => 'mobile_columns',
                    'label' => esc_html__( 'Mobile Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '1',
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'timeframe_on_title',
                    'label'         => esc_html__('Time Frame on Title', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'timeframe_margin',
                    'label'         => esc_html__('Time Frame Margin', 'uipro'),
                    'description'   => esc_html__('Set the time frame margin.', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'medium' => esc_html__('Medium', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'xlarge' => esc_html__('X-Large', 'uipro'),
                        'remove' => esc_html__('None', 'uipro'),
                    ),
                    'default'           => '',
                    'separator'     => 'before',
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'timeframe_margin_custom',
                    'label'         => esc_html__( 'Time Frame custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-timeline-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .frame-even .ui-timeline-date' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),
                array(
                    'name'            => 'timeframe_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Time Frame Font', 'uipro'),
                    'description'   => esc_html__('Select a font family.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-timeline-date',
                ),
                array(
                    'id'            => 'timeframe_background',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Time Frame Background Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-timeline-date' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'id'            => 'timeframe_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Time Frame Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-timeline-date, {{WRAPPER}} .ui-timeline-date a' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'timeframe_padding',
                    'label'         => esc_html__( 'Time Frame padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-timeline-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'timeframe_border_radius',
                    'label'         => esc_html__( 'Time Frame border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-timeline-date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'image_margin',
                    'label'         => esc_html__( 'Image box margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .image-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'start_section' => 'image_settings',
                    'section_name'      => esc_html__('Image Box Settings', 'uipro'),
                    'condition'     => array(
                        'timeframe_on_title'    => '0'
                    ),
                ),
                array(
                    'name'          => 'image_box_space',
                    'label' => esc_html__( 'Image Space', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
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
                    'default' => [
                        'size' => 100,
                    ],
                    'condition'     => array(
                        'timeframe_on_title'    => '1'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .image-space' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'image_position',
                    'label'         => esc_html__( 'Image Position', 'uipro' ),
                    'description'   => esc_html__( 'Select the image position.', 'uipro' ),
                    'options'       => array(
                        'left'      => esc_html__('Left', 'uipro'),
                        'right'     => esc_html__('Right', 'uipro'),
                        'inside'    => esc_html__('Inside Body', 'uipro'),
                    ),
                    'default'       => 'left',
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'image_cover',
                    'label'         => esc_html__('Enable Image Cover', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                ),
                array(
                    'name'          => 'image_box_line',
                    'label' => esc_html__( 'Line box width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
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
                    'default' => [
                        'size' => 100,
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .line-box, {{WRAPPER}} .line ' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'line_thin',
                    'label' => esc_html__( 'Line Thin', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 50,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 1,
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .line ' => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-timeline-inner::before ' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'short_line_height',
                    'label' => esc_html__( 'Short Line Height', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 50,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 1,
                    ],
                    'condition'     => array(
                        'timeframe_on_title'    => '1'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .line-box .line ' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ),

                array(
                    'id'            => 'line_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Line Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .line, {{WRAPPER}} .ui-timeline-inner::before' => 'background-color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),
                array(
                    'id'          => 'circle_position',
                    'label' => esc_html__( 'Circle Position', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-position-relative'    => esc_html__('Middle', 'uipro'),
                        'uk-position-top'    => esc_html__('Top', 'uipro'),
                        'uk-position-bottom'    => esc_html__('Bottom', 'uipro'),
                    ),
                    'default'   => 'uk-position-relative',
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),
                array(
                    'name'          => 'circle_size',
                    'label' => esc_html__( 'Circle size', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 10,
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .line::before ' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'circle_padding',
                    'label'         => esc_html__( 'Circle padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .line::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),
                array(
                    'label' => esc_html__( 'Cicle border', 'uipro' ),
                    'name'          => 'circle_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .line::before',
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::BOX_SHADOW,
                    'name'          =>  'circle_box_shadow',
                    'label'         => esc_html__( 'Circle Shadow', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .line::before' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),
                array(
                    'name'          => 'circle_vertical',
                    'label' => esc_html__( 'Circle Vertical position', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => -10,
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .line::before ' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'circle_horizontal',
                    'label' => esc_html__( 'Circle Left position', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => -10,
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .frame-old .line::before ' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'circle_horizontal_right',
                    'label' => esc_html__( 'Circle Right position', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => -10,
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .frame-even .line::before ' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'id'            => 'circle_bg',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Circle Background Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .line::before' => 'background-color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),

                //Title configure
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'title_tag',
                    'label'         => esc_html__( 'Title tag', 'uipro' ),
                    'options'       => array(
                        'h1'        => 'h1',
                        'h2'        => 'h2',
                        'h3'        => 'h3',
                        'h4'        => 'h4',
                        'h5'        => 'h5',
                        'h6'        => 'h6',
                        'div'       => 'div',
                        'span'      => 'span',
                        'p'         => 'p',
                    ),
                    'default'       => 'h3',
                    'description'   => esc_html__( 'Choose heading element.', 'uipro' ),
                    'start_section' => 'title_settings',
                    'section_name'      => esc_html__('Title Settings', 'uipro')
                ),
                array(
                    'name'            => 'title_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-timeline-title',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'title_heading_style',
                    'default'       => 'h3',
                    'label'         => esc_html__('Style', 'uipro'),
                    'description'   => esc_html__('Heading styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
                    'options'       => array(
                        ''                  => esc_html__('None', 'uipro'),
                        'heading-2xlarge'   => esc_html__('2XLarge', 'uipro'),
                        'heading-xlarge'    => esc_html__('XLarge', 'uipro'),
                        'heading-large'     => esc_html__('Large', 'uipro'),
                        'heading-medium'    => esc_html__('Medium', 'uipro'),
                        'heading-small'     => esc_html__('Small', 'uipro'),
                        'h1'                => esc_html__('H1', 'uipro'),
                        'h2'                => esc_html__('H2', 'uipro'),
                        'h3'                => esc_html__('H3', 'uipro'),
                        'h4'                => esc_html__('H4', 'uipro'),
                        'h5'                => esc_html__('H5', 'uipro'),
                        'h6'                => esc_html__('H6', 'uipro'),
                    ),
                ),
                array(
                    'id'            => 'custom_title_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Custom Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-timeline-title' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'title_margin',
                    'label'         => esc_html__('Title Margin', 'uipro'),
                    'description'   => esc_html__('Set the title margin.', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'medium' => esc_html__('Medium', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'xlarge' => esc_html__('X-Large', 'uipro'),
                        'remove' => esc_html__('None', 'uipro'),
                        'custom' => esc_html__('Custom', 'uipro'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'title_margin_custom',
                    'label'         => esc_html__( 'Title custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-timeline-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'title_margin'    => 'custom'
                    ),
                ),

                //Meta configure
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'meta_tag',
                    'label'         => esc_html__( 'Meta tag', 'uipro' ),
                    'options'       => array(
                        'h1'        => 'h1',
                        'h2'        => 'h2',
                        'h3'        => 'h3',
                        'h4'        => 'h4',
                        'h5'        => 'h5',
                        'h6'        => 'h6',
                        'div'       => 'div',
                        'span'      => 'span',
                        'p'         => 'p',
                    ),
                    'default'       => 'h5',
                    'description'   => esc_html__( 'Choose heading element.', 'uipro' ),
                    'start_section' => 'meta_settings',
                    'section_name'      => esc_html__('Meta Settings', 'uipro')
                ),
                array(
                    'name'            => 'meta_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Meta Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-timeline-meta',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'meta_heading_style',
                    'default'       => 'h5',
                    'label'         => esc_html__('Style', 'uipro'),
                    'description'   => esc_html__('Heading styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
                    'options'       => array(
                        ''                  => esc_html__('None', 'uipro'),
                        'heading-2xlarge'   => esc_html__('2XLarge', 'uipro'),
                        'heading-xlarge'    => esc_html__('XLarge', 'uipro'),
                        'heading-large'     => esc_html__('Large', 'uipro'),
                        'heading-medium'    => esc_html__('Medium', 'uipro'),
                        'heading-small'     => esc_html__('Small', 'uipro'),
                        'h1'                => esc_html__('H1', 'uipro'),
                        'h2'                => esc_html__('H2', 'uipro'),
                        'h3'                => esc_html__('H3', 'uipro'),
                        'h4'                => esc_html__('H4', 'uipro'),
                        'h5'                => esc_html__('H5', 'uipro'),
                        'h6'                => esc_html__('H6', 'uipro'),
                    ),
                ),
                array(
                    'id'            => 'custom_meta_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Custom Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-timeline-meta' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'meta_margin',
                    'label'         => esc_html__('Meta Margin', 'uipro'),
                    'description'   => esc_html__('Set the title margin.', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'medium' => esc_html__('Medium', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'xlarge' => esc_html__('X-Large', 'uipro'),
                        'remove' => esc_html__('None', 'uipro'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'meta_position',
                    'label'         => esc_html__('Meta Position', 'uipro'),
                    'description'   => esc_html__('Choose the Meta Position.', 'uipro'),
                    'options'       => array(
                        'before-title' => esc_html__('Before Title', 'uipro'),
                        'after-title' => esc_html__('After Title', 'uipro'),
                    ),
                    'default'           => 'before-title',
                ),

                //Content style
                array(
                    'name'          => 'content_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Content Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-timeline-description',
                    'start_section' => 'content_settings',
                    'section_name'  => esc_html__('Content Settings', 'uipro')
                ),
                array(
                    'id'            => 'content_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Custom Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-timeline-description' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'content_dropcap',
                    'label'         => esc_html__('Drop Cap', 'uipro'),
                    'description'   => esc_html__('Display the first letter of the paragraph as a large initial.', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'content_padding',
                    'label'         => esc_html__( 'Content Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-timeline-content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

	}
}