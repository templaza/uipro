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


if ( ! class_exists( 'UIPro_Config_UIPricing' ) ) {
	/**
	 * Class UIPro_Config_UIPricing
	 */
	class UIPro_Config_UIPricing extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uipricing';
			self::$name = esc_html__( 'TemPlaza: UI Pricing', 'uipro' );
			self::$desc = esc_html__( 'Add UI Pricing Box.', 'uipro' );
			self::$icon = 'eicon-price-table';
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
				'text',
				[
					'type'          => Controls_Manager::TEXT,
					'label'         => esc_html__( 'Item', 'uipro' ),
					'description'   => esc_html__( 'Write the title for the item.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
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
				'icon_type',
				[
					'type'          => Controls_Manager::SELECT,
					'label' => __( 'Icon Type', 'uipro' ),
					'default' => '',
					'options' => [
						''  => __( 'FontAwesome', 'uipro' ),
						'uikit' => __( 'UIKit', 'uipro' ),
					],
				]
			);
			$repeater->add_control(
				'icon',
				[
					'type'          => Controls_Manager::ICONS,
					'label'         => esc_html__('Select Icon:', 'uipro'),
					'conditions' => [
						'terms' => [
							['name' => 'icon_type', 'operator' => '===', 'value' => ''],
						],
					],
				]
			);
			$repeater->add_control(
				'uikit_icon',
				[
					'type'          => Controls_Manager::SELECT2,
					'label'         => esc_html__('Select Icon:', 'uipro'),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'icon_type', 'operator' => '===', 'value' => 'uikit'],
						],
					],
					'options' => $this->get_font_uikit(),
				]
			);

			// options

			$options = array(
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'layout',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Pricing Layout Style', 'uipro' ),
                    'options'       => array(
                        'base'      => esc_html__( 'Default', 'uipro' ),
                        'style1'   => esc_html__( 'Style 1', 'uipro' ),
                    ),
                    'default'       => 'base',
                ),
				array(
					'type'          => Controls_Manager::TEXT,
					'id'            => 'title',
					'label'         => esc_html__( 'Title', 'uipro' ),
					'default'       => __('Small Business', 'uipro'),
					'description'   => esc_html__( 'Write the title for the heading.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),

				array(
					'type'          => Controls_Manager::TEXT,
					'id'            => 'meta',
					'label'         => esc_html__( 'Meta', 'uipro' ),
					'default'       => __('billed weekly', 'uipro'),
					'description'   => esc_html__( 'Write the meta for the title.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				array(
					'id'            => 'description',
					'label'         => esc_html__('Description', 'uipro'),
					'type' => Controls_Manager::WYSIWYG,
					'default' => __( 'This plan is suitable for small businesses and offices.', 'uipro' ),
					'placeholder' => __( 'Type your description here', 'uipro' ),
					'separator'     => 'before',
				),

				array(
					'type'          => Controls_Manager::TEXT,
					'id'            => 'price',
					'label'         => esc_html__( 'Price', 'uipro' ),
					'default'       => __('69', 'uipro'),
					'description'   => esc_html__( 'Define the price for price box', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				array(
					'type'          => Controls_Manager::TEXT,
					'id'            => 'symbol',
					'label'         => esc_html__( 'Price Symbol', 'uipro' ),
					'default'       => __('$', 'uipro'),
					'description'   => esc_html__( 'Define the Symbol for price currency', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				array(
					'type'          => Controls_Manager::TEXT,
					'id'            => 'label_text',
					'label'         => esc_html__( 'Highlight', 'uipro' ),
					'default'       => __('Popular', 'uipro'),
					'description'   => esc_html__( 'Indicate important notes and highlight parts of your content.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				array(
					'id'            => 'label_styles',
					'type'          => Controls_Manager::SELECT,
					'label'         => __('Highlight Style', 'uipro'),
					'options' => array(
						''          => __('Inherit', 'uipro'),
						'uk-label-success' => __('Success', 'uipro'),
						'uk-label-warning' => __('Warning', 'uipro'),
						'uk-label-danger' => __('Danger', 'uipro'),
						'uk-label-custom' => __('Custom', 'uipro'),
					),
					'conditions' => [
						'terms' => [
							['name' => 'label_text', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'label_background_color',
					'label'         => esc_html__('Background Color', 'uipro'),
					'description'   => esc_html__('Set the Background of Highlight.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .tz-price-table_featured-inner' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'label_text', 'operator' => '!==', 'value' => ''],
							['name' => 'label_styles', 'operator' => '===', 'value' => 'uk-label-custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'label_color',
					'label'         => esc_html__('Label Color', 'uipro'),
					'description'   => esc_html__('Set the Color of Highlight.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .tz-price-table_featured-inner' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'label_text', 'operator' => '!==', 'value' => ''],
							['name' => 'label_styles', 'operator' => '===', 'value' => 'uk-label-custom'],
						],
					],
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'label_font_family',
					'label'         => esc_html__('Label Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon label.', 'uipro'),
					'selector'      => '{{WRAPPER}} .tz-price-table_featured-inner',
					'conditions' => [
						'terms' => [
							['name' => 'label_text', 'operator' => '!==', 'value' => ''],
							['name' => 'label_styles', 'operator' => '===', 'value' => 'uk-label-custom'],
						],
					],
				),

				array(
					'type'      => Controls_Manager::REPEATER,
					'id'      => 'price_items',
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
                    'name'          => 'icon_size',
                    'label' => __( 'Icon Size', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .pricing-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .pricing-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .pricing-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],

                ),

				//Link Settings
				array(
					'type'          => Controls_Manager::URL,
					'name'          => 'button_link',
					'label'         => __( 'Button Url', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					'default'       => [
						'url'       => '',
					],
					'separator'     => 'before',
				),
				array(
					'type'          => Controls_Manager::TEXT,
					'id'            => 'button_title',
					'label'         => esc_html__( 'Button Text', 'uipro' ),
					'default'       => __('Learn More', 'uipro'),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
					'conditions' => [
						'terms' => [
							['name' => 'button_link', 'operator' => '!==', 'value' => ''],
						],
					],
				),

				//Card Settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'card_style',
					'label' => __( 'Card Style', 'uipro' ),
					'default' => '',
					'options' => [
						'' => __('None', 'uipro'),
						'default' => __('Card Default', 'uipro'),
						'primary' => __('Card Primary', 'uipro'),
						'secondary' => __('Card Secondary', 'uipro'),
						'hover' => __('Card Hover', 'uipro'),
						'custom' => __('Custom', 'uipro'),
					],
					'start_section' => 'card',
					'section_name'      => esc_html__('Card Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_background',
					'label'         => esc_html__('Card Background', 'uipro'),
					'description'   => esc_html__('Set the Background Color of Card.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-pricing' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_color',
					'label'         => esc_html__('Card Color', 'uipro'),
					'description'   => esc_html__('Set the Color of Card.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-pricing' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
                array(
                    'name' => 'card_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'label' => __( 'Card Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .ui-pricing-body',
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'card_size',
					'label' => __( 'Card Size', 'uipro' ),
					'default' => '',
					'options' => [
						'' => __('Default', 'uipro'),
						'small' => __('Small', 'uipro'),
						'large' => __('Large', 'uipro'),
						'custom' => __('Custom', 'uipro'),
					],
				),
				array(
					'type'          => Controls_Manager::DIMENSIONS,
					'name'          =>  'card_padding',
					'label'         => __( 'Card Padding', 'uipro' ),
					'responsive'    =>  true,
					'size_units'    => [ 'px', 'em', '%' ],
					'selectors'     => [
						'{{WRAPPER}} .ui-pricing-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_size', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'card_font_family',
					'label'         => esc_html__('Card Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-pricing',
				),

                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'item_padding',
                    'label'         => esc_html__( 'Item Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'start_section' => 'item_settings',
                    'section_name'      => esc_html__('Item Settings', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'item_margin',
                    'label'         => esc_html__( 'Item Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'start_section' => 'item_settings',
                    'section_name'      => esc_html__('Item Settings', 'uipro')
                ),
                array(
                    'name' => 'item_order',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'label' => __( 'Item Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .ui-item',
                ),

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
					/* vc */
					'admin_label' => false,
					'start_section' => 'title_settings',
					'section_name'      => esc_html__('Title Settings', 'uipro')
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'title_typography',
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-pricing .uk-card-title',
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'title_color',
					'label'         => esc_html__('Title Color', 'uipro'),
					'description'   => esc_html__('Set the color of title.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-pricing .uk-card-title' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'title_bg_color',
					'label'         => esc_html__('Title background', 'uipro'),
					'description'   => esc_html__('Set background color of title.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-pricing .ui-pricing-header' => 'background-color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'title_padding',
                    'label'         => esc_html__( 'Title Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-pricing .ui-pricing-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
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
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'title_heading_margin',
					'label'         => esc_html__('Title Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for title.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'custom'    => esc_html__('Custom', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'title_margin_custom',
                    'label'         => esc_html__( 'Custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_heading_margin', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),

				//Meta Settings
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'meta_typography',
					'label'         => esc_html__('Meta Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-pricing .plan-period',
					'start_section' => 'meta_settings',
					'section_name'      => esc_html__('Meta Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'meta_color',
					'label'         => esc_html__('Title Color', 'uipro'),
					'description'   => esc_html__('Set the color of title.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-pricing .plan-period' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'meta_style',
					'default'       => '',
					'label'         => esc_html__('Style', 'uipro'),
					'description'   => esc_html__('Meta styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
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
						'text-meta'         => esc_html__('Text Meta', 'uipro'),
						'text-lead'         => esc_html__('Text Lead', 'uipro'),
					),
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'meta_margin',
					'label'         => esc_html__('Meta Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for title.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'custom'    => esc_html__('Custom', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'meta_margin_custom',
                    'label'         => esc_html__( 'Custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_margin', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .plan-period' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'meta_alignment',
					'label'         => esc_html__('Alignment', 'uipro'),
					'description'   => esc_html__('Align the meta text above or below.', 'uipro'),
					'options'       => array(
						'top' => __('Above', 'uipro'),
						'' => __('Below', 'uipro'),
						'inline' => __('Inline', 'uipro'),
					),
					'default'       => '',
				),

				//Description
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'description_typography',
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-pricing .plan-description',
					'start_section' => 'description_settings',
					'section_name'      => esc_html__('Description Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'description_color',
					'label'         => esc_html__('Description Color', 'uipro'),
					'description'   => esc_html__('Set the color of description.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-pricing .plan-description' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'description_margin',
					'label'         => esc_html__('Description Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for description.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
				),

				//Price Settings
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'price_typography',
					'label'         => esc_html__('Price Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon price.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-pricing .pricing-amount',
					'start_section' => 'price_settings',
					'section_name'      => esc_html__('Pricing Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'price_color',
					'label'         => esc_html__('Price Color', 'uipro'),
					'description'   => esc_html__('Set the color of price.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-pricing .pricing-amount' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'price_style',
					'default'       => 'h3',
					'label'         => esc_html__('Style', 'uipro'),
					'description'   => esc_html__('Price styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
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
						'text-meta'         => esc_html__('Text Meta', 'uipro'),
						'text-lead'         => esc_html__('Text Lead', 'uipro'),
					),
				),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'icon_price',
                    'label'         => esc_html__('Icon on price', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'icon_price_size',
                    'label' => __( 'Icon Size', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
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
                        '{{WRAPPER}} .ui_icon_on_price' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui_icon_on_price svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_price', 'operator' => '!==', 'value' => ''],
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'icon_media_color',
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui_icon_on_price' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui_icon_on_price svg' => 'fill: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_price', 'operator' => '!==', 'value' => ''],
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'icon_margin',
                    'label'         => esc_html__( 'Icon Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui_icon_on_price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_price', 'operator' => '!==', 'value' => ''],
                            ['name' => 'layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                ),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'price_margin',
					'label'         => esc_html__('Price Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for Price.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
				),

				//Symbol Settings
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'symbol_typography',
					'label'         => esc_html__('Symbol Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon symbol.', 'uipro'),
					'selector'      => '{{WRAPPER}} .pricing-symbol',
					'start_section' => 'symbol_settings',
					'section_name'      => esc_html__('Symbol Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'symbol_color',
					'label'         => esc_html__('Symbol Color', 'uipro'),
					'description'   => esc_html__('Set the color of symbol.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .pricing-symbol' => 'color: {{VALUE}}',
					],
				),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'symbol_pos',
                    'default'       => 'h3',
                    'label'         => esc_html__('Symbol Position', 'uipro'),
                    'options'       => array(
                        ''                  => esc_html__('Default', 'uipro'),
                        'right'   => esc_html__('Right', 'uipro'),
                    ),
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'symbol_style',
					'default'       => 'h3',
					'label'         => esc_html__('Style', 'uipro'),
					'description'   => esc_html__('Symbol styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
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
						'text-meta'         => esc_html__('Text Meta', 'uipro'),
						'text-lead'         => esc_html__('Text Lead', 'uipro'),
					),
				),
				array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'symbol_margin',
                    'label'         => esc_html__( 'Currency margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pricing-symbol' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
				),

				//Button Settings
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'button_typography',
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-button .uk-button',
					'start_section' => 'button_settings',
					'section_name'      => esc_html__('Button Settings', 'uipro')
				),
				array(
					'name'          => 'button_style',
					'label' => __( 'Button Style', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
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
				),
				array(
					'name'          => 'button_shape',
					'label' => __( 'Button Shape', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'rounded',
					'options' => [
						'rounded' => __('Rounded', 'uipro' ),
						'square' => __('Square', 'uipro' ),
						'circle' => __('Circle', 'uipro' ),
						'pill' => __('Pill', 'uipro' ),
						'custom' => __('Custom', 'uipro' ),
					],
					'conditions' => [
						'relation' => 'and',
						'terms' => [
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link-muted'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link-text'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'text'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'button_full_width',
					'label'         => esc_html__('Full width button', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'button_size',
					'label'         => esc_html__('Button Size', 'uipro'),
					'description'   => esc_html__('Set the size for multiple buttons.', 'uipro'),
					'options'       => array(
						'' => __('Default', 'uipro'),
						'small' => __('Small', 'uipro'),
						'large' => __('Large', 'uipro'),
					),
					'default'           => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_custom_radius',
                    'label'         => esc_html__( 'Button Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button .uk-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
				array(
					'id'          => 'background_color',
					'label' => __( 'Background Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-button .uk-button' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'id'          => 'background_color_overlay',
					'label' => __( 'Background Overlay Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-button:before' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'id'          => 'color',
					'label' => __( 'Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ui-button > a' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'name' => 'border',
					'type' => \Elementor\Group_Control_Border::get_type(),
					'label' => __( 'Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-button > a',
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'id'          => 'hover_background_color',
					'label' => __( 'Hover Background Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-button > a:hover' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'id'          => 'hover_color',
					'label' => __( 'Hover Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ui-button > a:hover' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'name' => 'hover_border',
					'type' => \Elementor\Group_Control_Border::get_type(),
					'label' => __( 'Hover Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-button > a:hover',
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'button_margin',
					'label'         => esc_html__('Button Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for Button.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'custom'    => esc_html__('Custom', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'button_margin_custom',
                    'label'         => esc_html__( 'Custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_margin', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'button_margin_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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