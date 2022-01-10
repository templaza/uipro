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
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {
            $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'quote_content', [
                    'label' => __( 'Content quote', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => __( '' , 'plugin-domain' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'quote_author', [
                    'label' => __( 'Author', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'plugin-domain' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'author_position', [
                    'label' => __( 'Author Position', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( '' , 'plugin-domain' ),
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
			// options
			$options = array(
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
                    'title_field' => __( 'Quote item', 'plugin-domain' ),
				),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'testimonial_slider_autoplay',
                    'label'     => esc_html__( 'Autoplay', 'uipro' ),
                    'start_section' => 'slider-options',
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
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
					'type'          => Controls_Manager::SELECT,
					'id'            => 'testimonial_slider_navigation_position',
					'label'         => esc_html__( 'Navigation Position', 'uipro' ),
					'description'   => esc_html__( 'Select the image\'s position.', 'uipro' ),
					'options'       => array(
						'' => __('Default', 'uipro'),
						'uk-position-top-left' => __('Top Left', 'uipro'),
						'uk-position-top-right' => __('Top Right', 'uipro'),
						'uk-position-bottom-left' => __('Bottom Left', 'uipro'),
						'uk-position-bottom-right' => __('Bottom Right', 'uipro'),
					),
					'default'       => '',
					'conditions' => [
						'terms' => [
							['name' => 'testimonial_slider_navigation', 'operator' => '===', 'value' => 'yes'],
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
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'testimonial_slider_dot',
                    'label'     => esc_html__( 'Show dots', 'uipro' ),
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
                ),
                array(
                    'type'      => Controls_Manager::NUMBER,
                    'name'      => 'testimonial_slider_number',
                    'label'     => esc_html__( 'Number item', 'uipro' ),
                    'section_name'  => esc_html__( 'Slider options', 'uipro' ),
                ),
				array(
					'name'          => 'testimonial_quote_size',
					'label' => __( 'Quote Size', 'uipro' ),
					'description'   => esc_html__('Size of quote icon', 'uipro'),
					'type' => Controls_Manager::SLIDER,
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
					'start_section' => 'style',
					'section_tab'   => Controls_Manager::TAB_STYLE,
					'section_name'  => esc_html__( self::$name, 'uipro' ),
				),
				array(
					'id'            => 'avatar_size',
					'label'         => __( 'Avatar Size', 'uipro' ),
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
						'{{WRAPPER}} .ui-testimonial-avatar img' => 'width: {{SIZE}}{{UNIT}};',
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
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'quote_content_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Content Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .templaza_quote_content',
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),

                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'quote_author_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Author Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .templaza_quote_author',
                    'section_name'  => esc_html__( self::$name, 'uipro' ),

                ),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'quote_designation_typography',
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Designation Font', 'uipro'),
					'selector'      => '{{WRAPPER}} .templaza_quote_author_position',
					'section_name'  => esc_html__( self::$name, 'uipro' ),

				),
			);
			return array_merge($options, $this->get_general_options());
		}

        public function get_template_name() {
            return 'base';
        }
	}
}