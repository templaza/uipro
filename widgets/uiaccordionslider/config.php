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
                        '{{WRAPPER}} .slide:hover .slider-icon' => 'color: {{VALUE}}',
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
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'content_margin_custom',
                    'label'         => __( 'Content Custom Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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