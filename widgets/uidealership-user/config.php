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
use Elementor\Core\Schemes\Typography;

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
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'user_email',
                    'label'         => esc_html__( 'Show Email', 'uipro' ),
                    'default'       => 'yes'
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
					'scheme'        => Typography::TYPOGRAPHY_1,
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
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'name_heading_margin',
					'label'         => esc_html__('Title Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for name.', 'uipro'),
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

				//Designation settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'designation_tag',
					'label'         => esc_html__( 'Designation tag', 'uipro' ),
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
					'description'   => esc_html__( 'Choose Designation element.', 'uipro' ),
					/* vc */
					'admin_label' => false,
					'start_section' => 'designation_settings',
					'section_name'      => esc_html__('Designation Settings', 'uipro')
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'designation_typography',
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Designation Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-designation',
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'designation_color',
					'label'         => esc_html__('Designation Color', 'uipro'),
					'description'   => esc_html__('Set the color of designation.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-designation' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'designation_margin',
					'label'         => esc_html__('Designation Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for designation.', 'uipro'),
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
					'section_name'      => esc_html__('Email Settings', 'uipro')
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'email_typography',
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Email Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-email',
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'email_color',
					'label'         => esc_html__('Email Color', 'uipro'),
					'description'   => esc_html__('Set the color of email.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-email' => 'color: {{VALUE}}',
					],
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'email_margin',
					'label'         => esc_html__('Email Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for email.', 'uipro'),
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


			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

	}
}