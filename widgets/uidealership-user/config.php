<?php
/**
 * UIPro UIDealership_User config class
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
use Elementor\Group_Control_Border;


if ( ! class_exists( 'UIPro_Config_UIDealership_User' ) ) {
	/**
	 * Class UIPro_Config_UIDealership_User
	 */
	class UIPro_Config_UIDealership_User extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_UIDealership_User constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uidealership-user';
			self::$name = esc_html__( 'TemPlaza: User', 'uipro' );
			self::$desc = esc_html__( 'Show Users.', 'uipro' );
			self::$icon = 'eicon-user-circle-o';
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
            global $wp_roles;
            $roles = array();
            $role_name = $wp_roles->get_names();
            if ( $role_name ) {
                foreach ( $role_name as $key => $value ){
                    $roles[$key] = $value;
                }
            }
			// options
			$options = array(
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'layout',
                    'show_label'    => true,
                    'label'         => esc_html__( 'User Layout', 'uipro' ),
                    'options'       => array(
                        'base'      => esc_html__( 'Default', 'uipro' ),
                    ),
                    'default'       => 'base',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'user_source',
                    'show_label'    => true,
                    'label'         => esc_html__( 'User Source', 'uipro' ),
                    'options'       => array(
                        'role'      => esc_html__( 'User role', 'uipro' ),
                        'custom'   => esc_html__( 'Custom', 'uipro' ),
                    ),
                    'default'       => 'role',
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'user_role',
                    'label'         => esc_html__( 'Select Roles', 'uipro' ),
                    'options'       => $roles,
                    'multiple'      => true,
                    'condition'     => array(
                        'user_source'    => 'role'
                    ),
                ),
                array(
                    'type'      => Controls_Manager::NUMBER,
                    'name'      => 'user_limit',
                    'label'     => esc_html__( 'Limit User', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'user_orderby',
                    'label'         => esc_html__( 'User orderby ', 'uipro' ),
                    'options'       => array(
                        'ID'      => esc_html__( 'ID', 'uipro' ),
                        'display_name'   => esc_html__( 'Display Name', 'uipro' ),
                        'user_name'   => esc_html__( 'User Name', 'uipro' ),
                        'user_login'   => esc_html__( 'User Login', 'uipro' ),
                        'user_email'   => esc_html__( 'User Email', 'uipro' ),
                        'registered'   => esc_html__( 'Registered Date', 'uipro' ),
                        'post_count'   => esc_html__( 'Post Count', 'uipro' ),
                    ),
                    'default'       => 'login',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'user_order',
                    'label'         => esc_html__( 'User order', 'uipro' ),
                    'options'       => array(
                        'ASC'      => esc_html__( 'Ascending', 'uipro' ),
                        'DESC'   => esc_html__( 'Descending ', 'uipro' ),
                    ),
                    'default'       => 'ASC',
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'user_email',
                    'label'         => esc_html__( 'Show Email', 'uipro' ),
                    'default'       => 'yes'
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'user_address',
                    'label'         => esc_html__( 'Show Address', 'uipro' ),
                    'default'       => 'no'
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'user_number',
                    'label'         => esc_html__( 'Show Phone Number', 'uipro' ),
                    'default'       => 'no'
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'user_product_number',
                    'label'         => esc_html__( 'Show Product Number', 'uipro' ),
                    'default'       => 'yes'
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
                    'default'   => '3',
                    'separator'     => 'before',
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
                    'default'   => '3',
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
                    'default'   => '3'
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
                    'default'   => '2'
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
                    'default'   => '1'
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'column_grid_gap',
                    'label'         => esc_html__('Column Gap', 'uipro'),
                    'description'   => esc_html__('Modified Gap Column', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'medium' => esc_html__('Medium', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'collapse' => esc_html__('Collapse', 'uipro'),
                    ),
                    'default'           => '',
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
						'{{WRAPPER}} .ui-card' => 'background-color: {{VALUE}}',
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
						'{{WRAPPER}} .ui-card' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
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
                        'custom' => esc_html__('Custom', 'uipro'),
					],
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_radius',
                    'label'         => esc_html__( 'Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_padding',
                    'label'         => esc_html__( 'Card Padding', 'uipro' ),
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

				//Image Settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'image_appear',
					'label' => __( 'Image Appear', 'uipro' ),
					'default' => 'top',
					'options' => [
						'top'        => __( 'Top', 'uipro' ),
						'inside'   => __( 'Inside', 'uipro' ),
						'bottom'   => __( 'Bottom', 'uipro' ),
					],
					'start_section' => 'image_settings',
					'section_name'      => esc_html__('Image Settings', 'uipro')
				),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'cover_image',
                    'label'         => esc_html__('Cover Image', 'uipro'),
                    'description'   => esc_html__( 'Whether to display image cover.', 'uipro' ),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                ),
                array(
                    'name'            => 'thumbnail_height',
                    'label'         => esc_html__( 'Image Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 220,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 220,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 220,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tz-image-cover' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'cover_image', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),

                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'image_border_radius',
                    'label'         => esc_html__( 'Image border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'flash_effect',
                    'label'         => esc_html__('Flash Effect', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0'
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
                    ),
                    'default'       => '',
                ),

				//Name settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'name_tag',
					'label'         => esc_html__( 'Name tag', 'uipro' ),
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
					'start_section' => 'name_settings',
					'section_name'      => esc_html__('Name Settings', 'uipro')
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'name_typography',
					'label'         => esc_html__('Name Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon name.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-name',
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'name_color',
					'label'         => esc_html__('Title Color', 'uipro'),
					'description'   => esc_html__('Set the color of name.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-name' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'name_color_hover',
					'label'         => esc_html__('Title Color Hover', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-name:hover a' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'name_heading_style',
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
					'name'          => 'name_position',
					'label'         => esc_html__('Icon/Image Position', 'uipro'),
					'description'   => esc_html__('Set the icon/image position.', 'uipro'),
					'options'       => array(
						'after'     => esc_html__('Before Title', 'uipro'),
						'before'    => esc_html__('After Title', 'uipro'),
					),
					'default'       => 'after',
				),
				array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'name_heading_margin',
                    'label'         => esc_html__( 'Title Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
				),
                //Address settings
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'address_typography',
					'label'         => esc_html__('Address Font', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-address',
                    'start_section' => 'address_settings',
                    'section_name'      => esc_html__('Address Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'address_color',
					'label'         => esc_html__('Address Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-address' => 'color: {{VALUE}}',
					],
				),
				array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'address_padding',
                    'label'         => esc_html__( 'Address Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-address' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
				),
				array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'address_margin',
                    'label'         => esc_html__( 'Address Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-address' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
				),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'address_icon',
                    'label'         => esc_html__( 'Address Icon', 'uipro' ),
                ),
                array(
                    'name'          => 'address_icon_size',
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
                        'size' => 14,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-address i' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-address svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'icon_address_color',
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-address i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-address svg' => 'fill: {{VALUE}}',
                    ],
                ),
                array(
                    'name'          => 'address_icon_spacing',
                    'label' => esc_html__( 'Icon Spacing', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 5,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-address span' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'            => 'address_border',
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'label' => esc_html__( 'Address Border', 'uipro' ),
                    'description'   => esc_html__( 'Address Border.', 'uipro' ),
                    'selector' => '{{WRAPPER}} .ui-address',
                ),

				//Product Number settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'product_number_tag',
					'label'         => esc_html__( 'Product Number tag', 'uipro' ),
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
						'lead'      => 'lead',
						'meta'      => 'meta'
					),
					'default'       => 'meta',
					'description'   => esc_html__( 'Choose Product Number element.', 'uipro' ),
					/* vc */
					'admin_label' => false,
					'start_section' => 'product_number_settings',
					'section_name'      => esc_html__('Product Number Settings', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_product_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
				array(
					'type'          => Controls_Manager::TEXT,
					'name'          => 'product_label',
					'label'         => esc_html__('Product Number Label', 'uipro'),
					'default'      => esc_html__('Products', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_product_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
				array(
					'type'          => Controls_Manager::TEXT,
					'name'          => 'product_label_regular',
					'label'         => esc_html__('1 Product Label', 'uipro'),
					'default'      => esc_html__('Product', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_product_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'product_number_typography',
					'label'         => esc_html__('Product Number Font', 'uipro'),
					'description'   => esc_html__('Select a font family', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-product-number',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_product_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'product_number_color',
					'label'         => esc_html__('Product Number Color', 'uipro'),
					'description'   => esc_html__('Set the color of Product Number.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-product-number' => 'color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_product_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'product_number_margin',
                    'label'         => esc_html__( 'Product Number Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-product-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_product_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),

				//Email settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'email_tag',
					'label'         => esc_html__( 'Email tag', 'uipro' ),
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
						'lead'      => 'lead',
						'meta'      => 'meta'
					),
					'default'       => 'meta',
					'description'   => esc_html__( 'Choose Email element.', 'uipro' ),
					/* vc */
					'admin_label' => false,
					'start_section' => 'email_settings',
					'section_name'      => esc_html__('Email Settings', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_email', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'email_typography',
					'label'         => esc_html__('Email Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-email',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_email', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'email_color',
					'label'         => esc_html__('Email Color', 'uipro'),
					'description'   => esc_html__('Set the color of email.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-email' => 'color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_email', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
				array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'email_margin',
                    'label'         => esc_html__( 'Email Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-email' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_email', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'email_icon',
                    'label'         => esc_html__( 'Email Icon', 'uipro' ),
                ),
                array(
                    'name'          => 'email_icon_size',
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
                        'size' => 14,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-email i' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-email svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'icon_email_color',
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-email i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-email svg' => 'fill: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_email', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'email_icon_spacing',
                    'label' => esc_html__( 'Icon Spacing', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 5,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-email span' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                ),
                //Phone Number settings

				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'phone_typography',
					'label'         => esc_html__('Phone Font', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-phone',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                    'start_section' => 'phone_settings',
                    'section_name'      => esc_html__('Phone Settings', 'uipro'),
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'phone_color',
					'label'         => esc_html__('Phone Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-phone' => 'color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
				array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'phone_margin',
                    'label'         => esc_html__( 'Phone Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-phone' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
				),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'phone_icon',
                    'label'         => esc_html__( 'Phone Icon', 'uipro' ),
                ),
                array(
                    'name'          => 'phone_icon_size',
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
                        'size' => 14,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-phone i' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-phone svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'icon_phone_color',
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-phone i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-phone svg' => 'fill: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'user_number', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'phone_icon_spacing',
                    'label' => esc_html__( 'Icon Spacing', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 5,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-phone span' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                ),


			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

	}
}