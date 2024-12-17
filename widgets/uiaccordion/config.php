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


if ( ! class_exists( 'UIPro_Config_UIAccordion' ) ) {
	/**
	 * Class UIPro_Config_UI_Button
	 */
	class UIPro_Config_UIAccordion extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiaccordion';
			self::$name = esc_html__( 'TemPlaza: UI Accordion', 'uipro' );
			self::$desc = esc_html__( 'Add UI Accordion.', 'uipro' );
			self::$icon = 'eicon-accordion';
			parent::__construct();

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
			$repeater->add_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [],
					'include' => [],
					'default' => 'large',
				]
			);
			$repeater->add_control(
				'link',
				[
					'label' => __( 'Link', 'uipro' ),
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
			$repeater->add_control(
				'link_title', [
					'label' => __( 'Link Title', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
				]
			);
			// options
			$options = array(
				array(
					'type'      => Controls_Manager::REPEATER,
					'name'      => 'uiaccordions',
					'label'     => esc_html__( 'Items', 'uipro' ),
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'title' => 'Item',
						],
					],
					'title_field' => __( 'Item', 'uipro' ),
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'multiple',
					'label'         => esc_html__('Allow multiple open items', 'uipro'),
					'desc'          => __('To display multiple content sections at the same time without one collapsing when the other one is opened', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'closed',
					'label'         => esc_html__('Allow all items to be closed', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '1',
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'icon_align',
					'label'         => esc_html__('Left Icon Alignment', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'accordion_style',
					'label'         => esc_html__('Style', 'uipro'),
					'description'   => esc_html__('Select a predefined style for accordion', 'uipro'),
					'options'       => array(
						'' => __('None', 'uipro'),
						'default' => __('Default', 'uipro'),
						'muted' => __('Muted', 'uipro'),
						'primary' => __('Primary', 'uipro'),
						'secondary' => __('Secondary', 'uipro'),
						'hover' => __('Hover', 'uipro'),
						'custom' => __('Custom', 'uipro'),
					),
					'default'           => '',
					'start_section' => 'card_settings',
					'section_name'      => esc_html__('Card Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_background',
					'label'         => esc_html__('Card Background', 'uipro'),
					'description'   => esc_html__('Set the Background Color of Card.', 'uipro'),
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .tz-item' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'accordion_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_color',
					'label'         => esc_html__('Card Color', 'uipro'),
					'description'   => esc_html__('Set the Color of Card.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .tz-item' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'accordion_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Border::get_type(),
					'name'          => 'card_border',
					'label'         => esc_html__('Card Border', 'uipro'),
					'description'   => esc_html__('Set the Border of Card.', 'uipro'),
					'selector' => '{{WRAPPER}} .tz-item',
					'conditions' => [
						'terms' => [
							['name' => 'accordion_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
					'name'          => 'card_box_shadow',
					'label'         => esc_html__('Card Box Shadow', 'uipro'),
					'description'   => esc_html__('Set the Box Shadow of Card.', 'uipro'),
					'selector' => '{{WRAPPER}} .tz-item',
					'conditions' => [
						'terms' => [
							['name' => 'accordion_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_background_hover',
					'label'         => esc_html__('Card Background Hover', 'uipro'),
					'description'   => esc_html__('Set the Background Color of Card on mouse hover.', 'uipro'),
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .tz-item:hover' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'accordion_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_color_hover',
					'label'         => esc_html__('Card Color Hover', 'uipro'),
					'description'   => esc_html__('Set the Color of Card on mouse hover.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .tz-item:hover' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'accordion_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Border::get_type(),
					'name'          => 'card_border_hover',
					'label'         => esc_html__('Card Border Hover', 'uipro'),
					'description'   => esc_html__('Set the Border of Card on mouse hover.', 'uipro'),
					'selector' => '{{WRAPPER}} .tz-item:hover',
					'conditions' => [
						'terms' => [
							['name' => 'accordion_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
					'name'          => 'card_box_shadow_hover',
					'label'         => esc_html__('Card Box Shadow Hover', 'uipro'),
					'description'   => esc_html__('Set the Box Shadow of Card hover.', 'uipro'),
					'selector' => '{{WRAPPER}} .tz-item:hover',
					'conditions' => [
						'terms' => [
							['name' => 'accordion_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'card_size',
					'label'         => esc_html__('Size', 'uipro'),
					'description'   => esc_html__('Define the card\'s size by selecting the padding between the card and its content.', 'uipro'),
					'options'       => array(
						'' => __('Default', 'uipro'),
						'small' => __('Small', 'uipro'),
						'large' => __('Large', 'uipro'),
						'custom' => __('Custom', 'uipro'),
					),
					'default'           => 'small',
					'condition'     => array(
						'accordion_style!'    => ''
					),
				),
				array(
					'type'          => Controls_Manager::DIMENSIONS,
					'name'          =>  'card_padding',
					'label'         => __( 'Card Padding', 'uipro' ),
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

				//Title configure
				array(
					'name'            => 'title_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .tz-title',
					'start_section' => 'title_settings',
					'section_name'      => esc_html__('Title Settings', 'uipro')
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
						'{{WRAPPER}} .tz-title' => 'color: {{VALUE}}',
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

				//Content style
				array(
					'name'          => 'content_font_family',
					'type'          => Group_Control_Typography::get_type(),
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
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'content_dropcap',
					'label'         => esc_html__('Drop Cap', 'uipro'),
					'description'   => __('Display the first letter of the paragraph as a large initial.', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
				),
				array(
					'id'    => 'content_column',
					'type' => Controls_Manager::SELECT,
					'label' => __('Columns', 'uipro'),
					'description' => __('Set the number of text columns.', 'uipro'),
					'options' => array(
						'' => __('None', 'uipro'),
						'1-2' => __('Halves', 'uipro'),
						'1-3' => __('Thirds', 'uipro'),
						'1-4' => __('Quarters', 'uipro'),
						'1-5' => __('Fifths', 'uipro'),
						'1-6' => __('Sixths', 'uipro'),
					),
					'default' => '',
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'content_column_divider',
					'label'         => esc_html__('Show dividers', 'uipro'),
					'description'   => __('Show a divider between text columns.', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'condition' => array('content_column'    => ''),
				),
				array(
					'id'    => 'content_column_breakpoint',
					'type' => Controls_Manager::SELECT,
					'label' => __('Columns Breakpoint', 'uipro'),
					'description' => __('Set the device width from which the text columns should apply', 'uipro'),
					'options' => array(
						'' => __('Always', 'uipro'),
						's' => __('Small (Phone Landscape)', 'uipro'),
						'm' => __('Medium (Tablet Landscape)', 'uipro'),
						'l' => __('Large (Desktop)', 'uipro'),
						'xl' => __('X-Large (Large Screens)', 'uipro'),
					),
					'default' => 'm',
					'conditions' => [
						'terms' => [
							['name' => 'content_column', 'operator' => '!==', 'value' => ''],
						],
					],
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
					'id'    => 'positions',
					'type' => Controls_Manager::SELECT,
					'label' => __('Alignment', 'uipro'),
					'description' => __('Align the image to the top, left, right or place it between the title and the content.', 'uipro'),
					'options' => array(
						'top' => __('Top', 'uipro'),
						'bottom' => __('Bottom', 'uipro'),
						'left' => __('Left', 'uipro'),
						'right' => __('Right', 'uipro'),
					),
					'default' => 'top',
				),
				array(
					'id'    => 'grid_width',
					'type' => Controls_Manager::SELECT,
					'label' => __('Grid Width', 'uipro'),
					'description' => __('Define the width of the navigation. Choose between percent and fixed widths or expand columns to the width of their content', 'uipro'),
					'options' => array(
						'auto' => __('Auto', 'uipro'),
						'4-5' => __('80%', 'uipro'),
						'3-4' => __('75%', 'uipro'),
						'2-3' => __('66%', 'uipro'),
						'3-5' => __('60%', 'uipro'),
						'1-2' => __('50%', 'uipro'),
						'2-5' => __('40%', 'uipro'),
						'1-3' => __('33%', 'uipro'),
						'1-4' => __('25%', 'uipro'),
						'1-5' => __('20%', 'uipro'),
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'large' => __('Large', 'uipro'),
						'xlarge' => __('X-Large', 'uipro'),
						'2xlarge' => __('2X-Large', 'uipro'),
					),
					'default' => '1-2',
					'conditions' => [
						'terms' => [
							[
								'name' => 'positions',
								'operator' => '!in',
								'value' => [
									'top',
									'bottom'
								]
							]
						],
					],
				),
				array(
					'id'=>'image_grid_column_gap',
					'type' => Controls_Manager::SELECT,
					'label' => __('Grid Column Gap', 'uipro'),
					'description' => __('Set the size of the gap between the image and the content.', 'uipro'),
					'options' => array(
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'' => __('Default', 'uipro'),
						'large' => __('Large', 'uipro'),
						'collapse' => __('None', 'uipro'),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							[
								'name' => 'positions',
								'operator' => '!in',
								'value' => [
									'top',
									'bottom'
								]
							]
						],
					],
				),
				array(
					'id'    => 'image_grid_row_gap',
					'type' => Controls_Manager::SELECT,
					'label' => __('Grid Row Gap', 'uipro'),
					'description' => __('Set the size of the gap if the grid items stack.', 'uipro'),
					'options' => array(
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'' => __('Default', 'uipro'),
						'large' => __('Large', 'uipro'),
						'collapse' => __('None', 'uipro'),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							[
								'name' => 'positions',
								'operator' => '!in',
								'value' => [
									'top',
									'bottom'
								]
							]
						],
					],
				),
				array(
					'id'    => 'image_margin_top',
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
					'conditions' => [
						'terms' => [
							[
								'name' => 'positions',
								'operator' => '!in',
								'value' => [
									'top',
									'bottom'
								]
							]
						],
					],
				),
				array(
					'id'    => 'grid_breakpoint',
					'type' => Controls_Manager::SELECT,
					'label' => __('Grid Breakpoint', 'uipro'),
					'description' => __('Set the breakpoint from which the navigation and content will stack.', 'uipro'),
					'options' => array(
						's' => __('Small (Phone Landscape)', 'uipro'),
						'm' => __('Medium (Tablet Landscape)', 'uipro'),
						'l' => __('Large (Desktop)', 'uipro'),
						'xl' => __('X-Large (Large Screens)', 'uipro'),
					),
					'default' => 'm',
					'conditions' => [
						'terms' => [
							[
								'name' => 'positions',
								'operator' => '!in',
								'value' => [
									'top',
									'bottom'
								]
							]
						],
					],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'vertical_alignment',
					'label'         => esc_html__('Vertical Alignment', 'uipro'),
					'description'   => __('Vertically center the navigation and content', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'conditions' => [
						'terms' => [
							[
								'name' => 'positions',
								'operator' => '!in',
								'value' => [
									'top',
									'bottom'
								]
							]
						],
					],
				),

				//Button settings
				array(
					'id'    => 'all_button_title',
					'label' => __( 'Text', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Read more' , 'uipro' ),
					'label_block' => true,
					'start_section' => 'button',
					'section_name'      => esc_html__('Button Settings', 'uipro')
				),
				array(
					'id'    => 'target',
					'type' => Controls_Manager::SELECT,
					'label' => __('Link New Tab', 'uipro'),
					'options' => array(
						'' => __('Same Window', 'uipro'),
						'_blank' => __('New Window', 'uipro'),
					),
				),
				array(
					'id'    => 'button_style',
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
					'label'         => esc_html__('Button Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .uk-button',
					'condition' => array(
						'button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_background',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .uk-button' => 'background-color: {{VALUE}}',
					],
					'default' => '#1e87f0',
					'condition' => array(
						'button_style'    => 'custom'
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
						'button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_background_hover',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Hover Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .uk-button:hover' => 'background-color: {{VALUE}}',
					],
					'default' => '#0f7ae5',
					'condition' => array(
						'button_style'    => 'custom'
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
						'button_style'    => 'custom'
					),
				),
				array(
					'id'    => 'button_size',
					'type' => Controls_Manager::SELECT,
					'label' => __('Button Size', 'uipro'),
					'options' => array(
						'' => __('Default', 'uipro'),
						'uk-button-small' => __('Small', 'uipro'),
						'uk-button-large' => __('Large', 'uipro'),
					),
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