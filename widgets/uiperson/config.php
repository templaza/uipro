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
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;

if ( ! class_exists( 'UIPro_Config_UIPerson' ) ) {
	/**
	 * Class UIPro_Config_UIPerson
	 */
	class UIPro_Config_UIPerson extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiperson';
			self::$name = esc_html__( 'TemPlaza: UI Person', 'uipro' );
			self::$desc = esc_html__( 'Add UI Person Box.', 'uipro' );
			self::$icon = 'eicon-person';
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
				'social_icon',
				[
					'type'          => Controls_Manager::SELECT,
					'label'         => esc_html__('Social Icon', 'uipro'),
					'description'   => esc_html__('Select a social icon', 'uipro'),
					'options'       => array(
						'' => __( 'Select an Icon', 'uipro' ),
						'500px' => __( '500px', 'uipro' ),
						'behance' => __( 'Behance', 'uipro' ),
						'dribbble' => __( 'Dribbble', 'uipro' ),
						'facebook' => __( 'Facebook', 'uipro' ),
						'flickr' => __( 'Flickr', 'uipro' ),
						'foursquare' => __( 'Foursquare', 'uipro' ),
						'github' => __( 'Github', 'uipro' ),
						'github-alt' => __( 'Github-alt', 'uipro' ),
						'gitter' => __( 'Gitter', 'uipro' ),
						'google' => __( 'Google', 'uipro' ),
						'google-plus' => __( 'Google-plus', 'uipro' ),
						'instagram' => __( 'Instagram', 'uipro' ),
						'joomla' => __( 'Joomla', 'uipro' ),
						'linkedin' => __( 'Linkedin', 'uipro' ),
						'pinterest' => __( 'Pinterest', 'uipro' ),
						'soundcloud' => __( 'Soundcloud', 'uipro' ),
						'tripadvisor' => __( 'Tripadvisor', 'uipro' ),
						'tumblr' => __( 'Tumblr', 'uipro' ),
						'twitter' => __( 'Twitter', 'uipro' ),
						'twitch' => __( 'Twitch', 'uipro' ),
						'discord' => __( 'Discord', 'uipro' ),
						'etsy' => __( 'Etsy', 'uipro' ),
						'tiktok' => __( 'Tiktok', 'uipro' ),
						'vimeo' => __( 'Vimeo', 'uipro' ),
						'whatsapp' => __( 'Whatsapp', 'uipro' ),
						'wordpress' => __( 'Wordpress', 'uipro' ),
						'xing' => __( 'Xing', 'uipro' ),
						'yelp' => __( 'Yelp', 'uipro' ),
						'youtube' => __( 'Youtube', 'uipro' ),
						'reddit' => __( 'Reddit', 'uipro' ),
					),
					'default'           => '',
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
			// options
			$options = array(
				array(
					'type'          =>  Controls_Manager::MEDIA,
					'name'          => 'image',
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
					'name'          => 'name',
					'label'         => esc_html__( 'Name', 'uipro' ),
					'default'       => __('Alex Raykowitz', 'uipro'),
					'description'   => esc_html__( 'Write the Name for the person.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				array(
					'type'          => Controls_Manager::TEXT,
					'name'          => 'designation',
					'label'         => esc_html__( 'Designation', 'uipro' ),
					'placeholder'       => __('Your Designation Here', 'uipro'),
					'description'   => esc_html__( 'Write the title for the designation.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				array(
					'type'          => Controls_Manager::TEXT,
					'name'          => 'email',
					'label'         => esc_html__( 'Email', 'uipro' ),
					'placeholder'       => __('Your Email Here', 'uipro'),
					'description'   => esc_html__( 'Write the address for the email.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				//Content Settings
				array(
					'name'          => 'text',
					'label'         => esc_html__('Content', 'uipro'),
					'type' => Controls_Manager::WYSIWYG,
					'default' => __( 'Animal mnesarchum et sea, ad sale luptatum mea.', 'uipro' ),
					'placeholder' => __( 'Type your description here', 'uipro' ),
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'text_typography',
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-card .ui-card-text',
					'condition'     => array(
						'text!'    => ''
					),
				),
				array(
					'type'      => Controls_Manager::REPEATER,
					'id'      => 'social_items',
					'label'     => esc_html__( 'Social Items', 'uipro' ),
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'link' => 'Social Item',
						],
					],
					'title_field' => __( 'Social Item', 'uipro' ),
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
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'media_margin',
					'label'         => esc_html__('Media Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for Image.', 'uipro'),
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

				//Social Settings
				array(
					'id'          => 'overlay_positions',
					'label' => __( 'Overlay Positions', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'center',
					'options' => array(
						'top' => __( 'Top', 'uipro' ),
						'bottom' => __( 'Bottom', 'uipro' ),
						'left' => __( 'Left', 'uipro' ),
						'right' => __( 'Right', 'uipro' ),
						'top-left' => __( 'Top Left', 'uipro' ),
						'top-center' => __( 'Top Center', 'uipro' ),
						'top-right' => __( 'Top Right', 'uipro' ),
						'bottom-left' => __( 'Bottom Left', 'uipro' ),
						'bottom-center' => __( 'Bottom Center', 'uipro' ),
						'bottom-right' => __( 'Bottom Right', 'uipro' ),
						'center' => __( 'Center', 'uipro' ),
						'center-left' => __( 'Center Left', 'uipro' ),
						'center-right' => __( 'Center Right', 'uipro' ),
						'after-des' => __( 'After Description', 'uipro' ),
					),
					'start_section' => 'social_settings',
					'section_name'      => esc_html__('Social Settings', 'uipro')
				),
				array(
					'id'    =>  'overlay_alignment',
					'type' => \Elementor\Controls_Manager::SELECT,
					'label' => __( 'Alignment', 'uipro' ),
					'options' => array(
						'' => __( 'None', 'uipro' ),
						'left' => __( 'Left', 'uipro' ),
						'center' => __( 'Center', 'uipro' ),
						'right' => __( 'Right', 'uipro' ),
					),
					'default' => 'center',
				),
				array(
					'id'            => 'vertical_icons',
					'type'          => Controls_Manager::SWITCHER,
					'label' => __('Vertical Social Icons', 'uipro'),
					'label_on'      => __( 'Yes', 'uipro' ),
					'label_off'     => __( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'social_box_margin',
                    'label'         => esc_html__( 'Social Box Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .tz-social-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'social_box_color',
                    'label'         => esc_html__('Social Box Background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of social box.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .tz-social-box' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'social_item_bg_color',
                    'label'         => esc_html__('Social Item Background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of social item.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-icon-link .uk-icon' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'social_color',
                    'label'         => esc_html__('Social Item Color', 'uipro'),
                    'description'   => esc_html__('Set the color of social item.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-icon-link' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'name'            => 'social_width_custom',
                    'label'         => esc_html__( 'Item width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-icon-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'social_item_padding',
                    'label'         => esc_html__( 'Item Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-icon-link .uk-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'social_item_margin',
                    'label'         => esc_html__( 'Item Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .tz-social-box li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'social_item_border',
                    'label'         => esc_html__( 'Item Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .uk-icon-link .uk-icon',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'social_item_bg_color_hover',
                    'label'         => esc_html__('Hover Item Background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color hover of social item.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-icon-link .uk-icon:hover' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'social_color_hover',
                    'label'         => esc_html__('Hover Social Item Color', 'uipro'),
                    'description'   => esc_html__('Set the color hover of social item.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-icon-link:hover' => 'color: {{VALUE}}',
                    ],
                ),

                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'social_border_color_hover',
                    'label'         => esc_html__('Hover Border Color', 'uipro'),
                    'description'   => esc_html__('Set the border color hover of social item.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-icon-link .uk-icon:hover' => 'border-color: {{VALUE}}',
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