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

if ( ! class_exists( 'UIPro_Config_UIMarker' ) ) {
	/**
	 * Class UIPro_Config_UI_Marker
	 */
	class UIPro_Config_UIMarker extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uimarker';
			self::$name = esc_html__( 'TemPlaza: UI Marker', 'uipro' );
			self::$desc = esc_html__( 'Create a marker icon that can be displayed on top of images.', 'uipro' );
			self::$icon = 'eicon-post';
			parent::__construct();

		}

		public function get_scripts() {
			return array(
				'ui-marker-script' => array(
					'src'   =>  'script.min.js',
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
				'left_space', [
					'label' => __( 'Left', 'uipro' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 50,
					],
					'selectors' => [
						'{{WRAPPER}} .ui-popover-items {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$repeater->add_control(
				'top_space', [
					'label' => __( 'Top', 'uipro' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 50,
					],
					'selectors' => [
						'{{WRAPPER}} .ui-popover-items {{CURRENT_ITEM}}' => 'Top: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$repeater->add_control(
				'use_animation',
				[
					'label' => __( 'Use Animation', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'uipro' ),
					'label_off' => __( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '0',
					'separator'     => 'before',
				]
			);
			$repeater->add_control(
				'delay',
				[
					'label' => __( 'Delay', 'uipro' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 100,
					'max' => 5000,
					'step' => 100,
					'default' => 500,
					'conditions' => [
						'terms' => [
							['name' => 'use_animation', 'operator' => '===', 'value' => '1'],
						],
					],
				]
			);
			$repeater->add_control(
				'repeat_animation',
				[
					'label' => __( 'Repeat Animation', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'uipro' ),
					'label_off' => __( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '0',
					'conditions' => [
						'terms' => [
							['name' => 'use_animation', 'operator' => '===', 'value' => '1'],
						],
					],
				]
			);
			$repeater->add_control(
				'marker_type',
				[
					'label' => __( 'Marker Type', 'uipro' ),
					'description'   => esc_html__('Select a different type for this item.', 'uipro'),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __('Point', 'uipro'),
						'image' => __('Image', 'uipro'),
					],
					'separator'     => 'before',
				]
			);
			$repeater->add_control(
				'marker_point_image',
				[
					'type'          =>  Controls_Manager::MEDIA,
					'label'         => esc_html__('Select Point Image:', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'conditions' => [
						'terms' => [
							['name' => 'marker_type', 'operator' => '===', 'value' => 'image'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'marker_point_image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'full',
					'conditions' => [
						'terms' => [
							['name' => 'marker_type', 'operator' => '===', 'value' => 'image'],
						],
					],
				]
			);
			$repeater->add_responsive_control(
				'marker_point_image_width',
				[
					'label' => __( 'Point Image Size', 'uipro' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 50,
					],
					'selectors' => [
						'{{WRAPPER}} .ui-marker-image{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'marker_type', 'operator' => '===', 'value' => 'image'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'marker_point_image_border',
					'label' => __( 'Point Image Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-marker-image{{CURRENT_ITEM}}',
					'conditions' => [
						'terms' => [
							['name' => 'marker_type', 'operator' => '===', 'value' => 'image'],
						],
					],
					'separator'     => 'before',
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'marker_point_image_box_shadow',
					'label' => __( 'Box Shadow', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-marker-image{{CURRENT_ITEM}}',
					'conditions' => [
						'terms' => [
							['name' => 'marker_type', 'operator' => '===', 'value' => 'image'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'marker_point_image_border_hover',
					'label' => __( 'Point Image Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-marker-image{{CURRENT_ITEM}}:hover',
					'conditions' => [
						'terms' => [
							['name' => 'marker_type', 'operator' => '===', 'value' => 'image'],
						],
					],
					'separator'     => 'before',
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'marker_point_image_box_shadow_hover',
					'label' => __( 'Box Shadow', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-marker-image{{CURRENT_ITEM}}:hover',
					'conditions' => [
						'terms' => [
							['name' => 'marker_type', 'operator' => '===', 'value' => 'image'],
						],
					],
				]
			);
			$repeater->add_control(
				'marker_title', [
					'label' => __( 'Title', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
					'separator'     => 'before',
				]
			);
			$repeater->add_control(
				'marker_meta', [
					'label' => __( 'Meta', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'marker_content', [
					'label'         => esc_html__('Content', 'uipro'),
					'type' => Controls_Manager::WYSIWYG,
					'default' => __( 'Default description', 'uipro' ),
					'placeholder' => __( 'Type your description here', 'uipro' ),
					/* vc */
					'admin_label'   => true,
				]
			);
			$repeater->add_control(
				'marker_image',
				[
					'type'          =>  Controls_Manager::MEDIA,
					'label'         => esc_html__('Select Image:', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'marker_image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'full',
				]
			);
			$repeater->add_control(
				'marker_position',
				[
					'label' => __( 'Position', 'uipro' ),
					'description'   => esc_html__('Select a different position for this item.', 'uipro'),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __('None', 'uipro'),
						'top-center' => __('Top', 'uipro'),
						'bottom-center' => __('Bottom', 'uipro'),
						'left-center' => __('Left', 'uipro'),
						'right-center' => __('Right', 'uipro'),
					],
				]
			);
			$repeater->add_control(
				'link',
				[
					'label' => __( 'Link', 'uipro' ),
					'type' => Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', 'uipro' ),
					'show_external' => true,
					'default' => [
						'url' => '',
						'is_external' => false,
						'nofollow' => false,
					],
				]
			);
			$repeater->add_control(
				'button_title', [
					'label' => __( 'Button Title', 'uipro' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'button_style',
				[
					'label' => __( 'Button Style', 'uipro' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __('Default', 'uipro' ),
						'primary' => __('Primary', 'uipro') ,
						'secondary' => __('Secondary', 'uipro' ),
						'danger' => __('Danger', 'uipro' ),
						'text' => __('Text', 'uipro' ),
						'link' => __('Link', 'uipro' ),
						'link-muted' => __('Link Muted', 'uipro' ),
						'link-text' => __('Link Text', 'uipro' ),
						'custom' => __('Custom', 'uipro' ),
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
						],
					],
				]
			);
			$repeater->add_control(
				'button_shape',
				[
					'label' => __( 'Button Shape', 'uipro' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'rounded',
					'options' => [
						'rounded' => __('Rounded', 'uipro' ),
						'square' => __('Square', 'uipro' ),
						'round' => __('Round', 'uipro' ),
					],
					'conditions' => [
						'relation' => 'and',
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link-muted'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link-text'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'text'],
						],
					],
				]
			);
			$repeater->add_control(
				'button_background_color',
				[
					'label' => __( 'Button Background Color', 'uipro' ),
					'type' => Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'button_color',
				[
					'label' => __( 'Button Color', 'uipro' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'button_border',
					'label' => __( 'Button Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a',
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'button_hover_background_color',
				[
					'label' => __( 'Button Hover Background Color', 'uipro' ),
					'type' => Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'button_hover_color',
				[
					'label' => __( 'Button Hover Color', 'uipro' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'button_hover_border',
					'label' => __( 'Button Hover Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover',
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			// options
			$options = array(
				//Image Settings
				array(
					'type'          =>  Controls_Manager::MEDIA,
					'id'            => 'image',
					'label'         => esc_html__('Select Image:', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Image_Size::get_type(),
					'name'        => 'image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'full',
				),
				array(
					'type'      => Controls_Manager::REPEATER,
					'id'        => 'uimarker_items',
					'label'     => esc_html__( 'Marker Items', 'uipro' ),
					'fields'    => $repeater->get_controls(),
					'default' => [
						[
							'marker_title' => 'Marker Item',
						],
					],
					'title_field' => __( 'Marker Item', 'uipro' ),
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'popover_mode',
					'label'         => esc_html__('Mode', 'uipro'),
					'description'   => esc_html__('Display the popover on click or hover', 'uipro'),
					'options'       => array(
						'hover' => __('Hover', 'uipro'),
						'click' => __('Click', 'uipro'),
					),
					'default'           => 'hover',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'popover_position',
					'label'         => esc_html__('Position', 'uipro'),
					'description'   => esc_html__('Select the popover\'s alignment to its marker. If the popover doesn\'t fit its container, it will flip automatically.', 'uipro'),
					'options'       => array(
						'top-center' => __('Top', 'uipro'),
						'bottom-center' => __('Bottom', 'uipro'),
						'left-center' => __('Left', 'uipro'),
						'right-center' => __('Right', 'uipro'),
					),
					'default'           => 'top-center',
				),
				array(
					'id'            => 'popover_width',
					'label'         => __( 'Width', 'uipro' ),
					'type'          => Controls_Manager::SLIDER,
					'size_units'    => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ui-addon-marker .uk-drop' => 'width: {{SIZE}}{{UNIT}};',
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'popover_animation',
					'label'         => esc_html__('Animation', 'uipro'),
					'description'   => esc_html__('Apply the animations effect to the dropdown on hover/click', 'uipro'),
					'options'       => array(
						'' => __('None', 'uipro'),
						'fade' => __('Fade', 'uipro'),
						'scale-up' => __('Scale Up', 'uipro'),
						'scale-down' => __('Scale Down', 'uipro'),
						'slide-top-small' => __('Slide Top Small', 'uipro'),
						'slide-bottom-small' => __('Slide Bottom Small', 'uipro'),
						'slide-left-small' => __('Slide Left Small', 'uipro'),
						'slide-right-small' => __('Slide Right Small', 'uipro'),
						'slide-top-medium' => __('Slide Top Medium', 'uipro'),
						'slide-bottom-medium' => __('Slide Bottom Medium', 'uipro'),
						'slide-left-medium' => __('Slide Left Medium', 'uipro'),
						'slide-right-medium' => __('Slide Right Medium', 'uipro'),
						'slide-top' => __('Slide Top 100%', 'uipro'),
						'slide-bottom' => __('Slide Bottom 100%', 'uipro'),
						'slide-left' => __('Slide Left 100%', 'uipro'),
						'slide-right' => __('Slide Right 100%', 'uipro'),
					),
					'default'           => '',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'card_styles',
					'label'         => esc_html__('Style', 'uipro'),
					'description'   => esc_html__('Select a card style.', 'uipro'),
					'options'       => array(
						'default' => __('Default', 'uipro'),
						'primary' => __('Primary', 'uipro'),
						'secondary' => __('Secondary', 'uipro'),
					),
					'default'           => '',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'card_size',
					'label'         => esc_html__('Padding', 'uipro'),
					'description'   => esc_html__('Define the card\'s size by selecting the padding between the card and its content.', 'uipro'),
					'options'       => array(
						'uk-card-small' => __('Small', 'uipro'),
						'' => __('Default', 'uipro'),
						'uk-card-large' => __('Large', 'uipro'),
						'custom' => __('Custom', 'uipro'),
					),
					'default'           => 'uk-card-small',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_size_custom',
                    'label'         => esc_html__( 'Card Padding Custom', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'card_size', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
				array(
					'id'            => 'marker_background',
					'label'         => __( 'Background Color', 'uipro' ),
					'type'          => Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors'     => [
						'{{WRAPPER}} .ui-buttons' => 'background-color: {{VALUE}}',
					],
				),
				array(
					'id'            => 'marker_color',
					'label'         => __( 'Marker Color', 'uipro' ),
					'type'          => Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors'     => [
						'{{WRAPPER}} .ui-buttons' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'mobile_switcher',
					'label'         => esc_html__('Enable Mobile Switcher', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
				),

				//Title configure
				array(
					'name'            => 'title_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-title',
					'start_section' => 'title',
					'section_name'      => esc_html__('Title Settings', 'uipro')
				),
				array(
					'id'            => 'heading_style',
					'type'          => Controls_Manager::SELECT,
					'label' => __('Style', 'uipro'),
					'description' => __('Title styles differ in font-size but may also come with a predefined color, size and font.', 'uipro'),
					'options' => array(
						'' => __('None', 'uipro'),
						'heading-small' => __('Small', 'uipro'),
						'h1' => __('H1', 'uipro'),
						'h2' => __('H2', 'uipro'),
						'h3' => __('H3', 'uipro'),
						'h4' => __('H4', 'uipro'),
						'h5' => __('H5', 'uipro'),
						'h6' => __('H6', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'            => 'link_title',
					'type'          => Controls_Manager::SWITCHER,
					'label' => __('Link Title', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
				),
				array(
					'id'            => 'title_hover_style',
					'type'          => Controls_Manager::SELECT,
					'label'         => __('Hover Style', 'uipro'),
					'description'   => __('Set the hover style for a linked title.', 'uipro'),
					'options' => array(
						'reset' => __('None', 'uipro'),
						'heading' => __('Heading Link', 'uipro'),
						'' => __('Default Link', 'uipro'),
					),
					'default' => 'reset',
					'condition' => array(
						'link_title!'    => ''
					),
				),
				array(
					'id'            => 'title_decoration',
					'type'          => Controls_Manager::SELECT,
					'label'         => __('Decoration', 'uipro'),
					'description'   => __('Decorate the title with a divider, bullet or a line that is vertically centered to the heading.', 'uipro'),
					'options'       => array(
						'' => __('None', 'uipro'),
						'uk-heading-divider' => __('Divider', 'uipro'),
						'uk-heading-bullet' => __('Bullet', 'uipro'),
						'uk-heading-line' => __('Line', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'            => 'title_color',
					'type'          => Controls_Manager::SELECT,
					'label'         => __('Predefined Color', 'uipro'),
					'description'   => __('Select the predefined title text color.', 'uipro'),
					'options' => array(
						'' => __('None', 'uipro'),
						'muted' => __('Muted', 'uipro'),
						'emphasis' => __('Emphasis', 'uipro'),
						'primary' => __('Primary', 'uipro'),
						'secondary' => __('Secondary', 'uipro'),
						'success' => __('Success', 'uipro'),
						'warning' => __('Warning', 'uipro'),
						'danger' => __('Danger', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'            => 'custom_title_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-title' => 'color: {{VALUE}}',
					],
					'condition'     => array(
						'title_color'    => ''
					),
				),
				array(
					'id'            => 'title_text_transform',
					'type'          => Controls_Manager::SELECT,
					'label' => __('Transform', 'uipro'),
					'description' => __('The following options will transform text into uppercased, capitalized or lowercased characters.', 'uipro'),
					'options' => array(
						'' => __('Inherit', 'uipro'),
						'uppercase' => __('Uppercase', 'uipro'),
						'capitalize' => __('Capitalize', 'uipro'),
						'lowercase' => __('Lowercase', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'            => 'heading_selector',
					'type' => Controls_Manager::SELECT,
					'label' => __('HTML Element', 'uipro'),
					'description' => __('Choose one of the six heading elements to fit your semantic structure.', 'uipro'),
					'options' => array(
						'h1' => __('h1', 'uipro'),
						'h2' => __('h2', 'uipro'),
						'h3' => __('h3', 'uipro'),
						'h4' => __('h4', 'uipro'),
						'h5' => __('h5', 'uipro'),
						'h6' => __('h6', 'uipro'),
						'div' => __('div', 'uipro'),
					),
					'default' => 'h3',
				),
				array(
					'id'    => 'title_margin_top',
					'type' => Controls_Manager::SELECT,
					'label' => __('Title Margin', 'uipro'),
					'description' => __('Set the Title margin.', 'uipro'),
					'options' => array(
						'' => __('Default', 'uipro'),
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'large' => __('Large', 'uipro'),
						'xlarge' => __('X-Large', 'uipro'),
						'remove' => __('None', 'uipro'),
					),
					'default' => '',
				),
				
				//Meta Settings
				array(
					'name'            => 'meta_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Meta Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-meta',
					'start_section' => 'meta',
					'section_name'      => esc_html__('Meta Settings', 'uipro')
				),
				array(
					'id'        => 'meta_style',
					'type' => Controls_Manager::SELECT,
					'label' => __('Style', 'uipro'),
					'description' => __('Select a predefined meta text style, including color, size and font-family.', 'uipro'),
					'options' => array(
						'' => __('None', 'uipro'),
						'text-meta' => __('Meta', 'uipro'),
						'h1' => __('H1', 'uipro'),
						'h2' => __('H2', 'uipro'),
						'h3' => __('H3', 'uipro'),
						'h4' => __('H4', 'uipro'),
						'h5' => __('H5', 'uipro'),
						'h6' => __('H6', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'    => 'meta_color',
					'type' => Controls_Manager::SELECT,
					'label' => __('Predefined Color', 'uipro'),
					'description' => __('Select the predefined meta text color.', 'uipro'),
					'options' => array(
						'' => __('None', 'uipro'),
						'muted' => __('Muted', 'uipro'),
						'emphasis' => __('Emphasis', 'uipro'),
						'primary' => __('Primary', 'uipro'),
						'secondary' => __('Secondary', 'uipro'),
						'success' => __('Success', 'uipro'),
						'warning' => __('Warning', 'uipro'),
						'danger' => __('Danger', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'    => 'custom_meta_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-meta' => 'color: {{VALUE}}',
					],
					'condition' => array(
						'meta_color'    => ''
					),
				),
				array(
					'id'    =>  'meta_text_transform',
					'type' => Controls_Manager::SELECT,
					'label' => __('Transform', 'uipro'),
					'description' => __('The following options will transform text into uppercased, capitalized or lowercased characters.', 'uipro'),
					'options' => array(
						'' => __('Inherit', 'uipro'),
						'uppercase' => __('Uppercase', 'uipro'),
						'capitalize' => __('Capitalize', 'uipro'),
						'lowercase' => __('Lowercase', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'    => 'meta_element',
					'type' => Controls_Manager::SELECT,
					'label' => __('HTML Element', 'uipro'),
					'description' => __('Choose one of the HTML elements to fit your semantic structure.', 'uipro'),
					'options' => array(
						'h1' => __('h1', 'uipro'),
						'h2' => __('h2', 'uipro'),
						'h3' => __('h3', 'uipro'),
						'h4' => __('h4', 'uipro'),
						'h5' => __('h5', 'uipro'),
						'h6' => __('h6', 'uipro'),
						'div' => __('div', 'uipro'),
					),
					'default' => 'div',
				),
				array(
					'id'    => 'meta_alignment',
					'type' => Controls_Manager::SELECT,
					'label' => __('Alignment', 'uipro'),
					'description' => __('Align the meta text above or below the title.', 'uipro'),
					'options' => array(
						'top' => __('Above Title', 'uipro'),
						'' => __('Below Title', 'uipro'),
						'above' => __('Above Content', 'uipro'),
						'content' => __('Below Content', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'    => 'meta_margin_top',
					'type' => Controls_Manager::SELECT,
					'label' => __('Margin Top', 'uipro'),
					'description' => __('Set the top margin.', 'uipro'),
					'options' => array(
						'' => __('Default', 'uipro'),
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'large' => __('Large', 'uipro'),
						'xlarge' => __('X-Large', 'uipro'),
						'remove' => __('None', 'uipro'),
					),
					'default' => '',
				),
				array(
					'name'          => 'content_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-content',
					'start_section' => 'content',
					'section_name'      => esc_html__('Content Settings', 'uipro')
				),
				array(
					'id'    => 'content_style',
					'type' => Controls_Manager::SELECT,
					'label' => __('Style', 'uipro'),
					'description' => __('Select a predefined text style, including color, size and font-family.', 'uipro'),
					'options' => array(
						'' => __('None', 'uipro'),
						'text-lead' => __('Lead', 'uipro'),
						'text-meta' => __('Meta', 'uipro'),
					),
					'default' => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'content_graph_margin',
                    'label'         => esc_html__( 'Content row margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
				array(
					'id'            => 'content_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-content' => 'color: {{VALUE}}',
					],
				),
				array(
					'id'    => 'content_text_transform',
					'type' => Controls_Manager::SELECT,
					'label' => __('Transform', 'uipro'),
					'description' => __('The following options will transform text into uppercased, capitalized or lowercased characters.', 'uipro'),
					'options' => array(
						'' => __('Inherit', 'uipro'),
						'uppercase' => __('Uppercase', 'uipro'),
						'capitalize' => __('Capitalize', 'uipro'),
						'lowercase' => __('Lowercase', 'uipro'),
					),
					'default' => '',
				),
				array(
					'id'    => 'content_margin_top',
					'type' => Controls_Manager::SELECT,
					'label' => __('Margin Top', 'uipro'),
					'description' => __('Set the top margin.', 'uipro'),
					'options' => array(
						'' => __('Default', 'uipro'),
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'large' => __('Large', 'uipro'),
						'xlarge' => __('X-Large', 'uipro'),
						'remove' => __('None', 'uipro'),
					),
					'default' => '',
				),

				//Button settings
				array(
					'id'    => 'all_button_title',
					'label' => __( 'Text', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
					'start_section' => 'button',
					'section_name'      => esc_html__('Button Settings', 'uipro')
				),
				array(
					'id'    => 'link_new_tab',
					'type' => Controls_Manager::SELECT,
					'label' => __('Link New Tab', 'uipro'),
					'options' => array(
						'' => __('Same Window', 'uipro'),
						'_blank' => __('New Window', 'uipro'),
					),
				),
				array(
					'id'    => 'link_button_style',
					'type' => Controls_Manager::SELECT,
					'label' => __('Style', 'uipro'),
					'description' => __('Set the button style.', 'uipro'),
					'options' => array(
						'' => __('Button Default', 'uipro'),
						'primary' => __('Button Primary', 'uipro'),
						'secondary' => __('Button Secondary', 'uipro'),
						'danger' => __('Button Danger', 'uipro'),
						'text' => __('Button Text', 'uipro'),
						'link' => __('Link', 'uipro'),
						'link-muted' => __('Link Muted', 'uipro'),
						'link-text' => __('Link Text', 'uipro'),
						'custom' => __('Custom', 'uipro'),
					),
					'default' => '',
				),
				array(
					'name'          => 'button_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Button Font', 'uipro'),
					'description'   => esc_html__('Select a font family.', 'uipro'),
					'selector'      => '{{WRAPPER}} .uk-button',
				),
				array(
					'id'            => 'button_background',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .uk-button' => 'background-color: {{VALUE}}',
					],
					'condition' => array(
						'link_button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Button Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .uk-button' => 'color: {{VALUE}}',
					],
					'condition' => array(
						'link_button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_background_hover',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Hover Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .uk-button:hover' => 'background-color: {{VALUE}}',
					],
					'condition' => array(
						'link_button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_hover_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Hover Button Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .uk-button:hover' => 'color: {{VALUE}}',
					],
					'condition' => array(
						'link_button_style'    => 'custom'
					),
				),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'button_icon',
                    'label'         => esc_html__('Button Icon:', 'uipro'),
                    'condition' => array(
                        'link_button_style'    => 'custom'
                    ),
                ),
                array(
                    'id'    => 'button_icon_position',
                    'type' => Controls_Manager::SELECT,
                    'label' => __('Icon position', 'uipro'),
                    'options' => array(
                        'right' => __('Right', 'uipro'),
                        'left' => __('Left', 'uipro'),
                    ),
                    'default' => 'right',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_icon_margin',
                    'label'         => esc_html__( 'Icon margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .btn_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
				array(
					'id'    => 'link_button_size',
					'type' => Controls_Manager::SELECT,
					'label' => __('Button Size', 'uipro'),
					'options' => array(
						'' => __('Default', 'uipro'),
						'uk-button-small' => __('Small', 'uipro'),
						'uk-button-large' => __('Large', 'uipro'),
						'custom' => __('Custom', 'uipro'),
					),
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_size_custom',
                    'label'         => esc_html__( 'Button Padding Custom', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'link_button_size', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
				array(
					'id'    => 'button_margin_top',
					'type' => Controls_Manager::SELECT,
					'label' => __('Margin Top', 'uipro'),
					'description' => __('Set the top margin.', 'uipro'),
					'options' => array(
						'' => __('Default', 'uipro'),
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'large' => __('Large', 'uipro'),
						'xlarge' => __('X-Large', 'uipro'),
						'remove' => __('None', 'uipro'),
					),
					'default' => '',
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