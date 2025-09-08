<?php
/**
 * UIPro Grid Slideshow config class
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


if ( ! class_exists( 'UIPro_Config_UIGridSlideshow' ) ) {
	/**
	 * Class UIPro_Config_UIGridSlideshow
	 */
	class UIPro_Config_UIGridSlideshow extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_UIGridSlideshow constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uigridslideshow';
			self::$name = esc_html__( 'TemPlaza: UI Grid Slideshow', 'uipro' );
			self::$desc = esc_html__( 'Create a slideshow that can be displayed on your site.', 'uipro' );
			self::$icon = 'eicon-slideshow';
			parent::__construct();

		}
        public function get_styles() {
            return ['el-uigridslideshow' => array(
                'src'   => 'style.css',
                'ver'   =>  time(),
            )];
        }
        public function get_scripts() {
            return array(
                'uigridslideshow-script' => array(
                    'src'   =>  'uigridslideshow-script.js',
                    'deps'  =>  array('jquery'),
                    'ver'   =>  time(),
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
			$repeater->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'full',
				]
			);

			$repeater->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'background',
					'label' => esc_html__( 'Background', 'uipro' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .ui-background-cover{{CURRENT_ITEM}}',

				]
			);

			$repeater->add_control(
				'title', [
					'label' => esc_html__( 'Title', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'label_block' => true,
					'separator'     => 'before',
				]
			);
			$repeater->add_control(
				'meta', [
					'label' => esc_html__( 'Meta', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'uipro' ),
					'type' => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'uipro' ),
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
                    'id'          => 'layout',
                    'label' => esc_html__( 'Layout', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'base'    => esc_html__('Default', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
				array(
					'type'      => Controls_Manager::REPEATER,
					'id'        => 'uislideshow_items',
					'label'     => esc_html__( 'Slideshow Items', 'uipro' ),
					'fields'    => $repeater->get_controls(),
                    'default' => [
                        [
                            'title' => 'Slideshow Item #1',
                        ],
                    ],
                    'title_field' => '{{{ title }}}',
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
                    'default'   => '4',
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
                    'default'   => '4',
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
                    'default'   => '2'
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
                    'name'            => 'uislideshow_height',
                    'label'         => esc_html__( 'Slideshow Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'size_units' => [ 'px','%','vh' ],
                    'desktop_default' => [
                        'size' => 700,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uigrid-slideshow' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'start_section' => 'slideshow_settings',
                    'section_name'      => esc_html__('Slideshow Settings', 'uipro')
                ),
                array(
                    'type'          => \Elementor\Group_Control_Background::get_type(),
                    'name'          => 'uislideshow_bg',
                    'label' => __( 'Slideshow Background', 'uipro' ),
                    'default' => '',
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .uigrid-slideshow::before',

                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'item_padding',
                    'label'         => esc_html__( 'Item Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uigrid-slideshow-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'start_section' => 'slideshow_item_settings',
                    'section_name'      => esc_html__('Item Settings', 'uipro')
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'item_border',
                    'label'         => esc_html__('Item Border', 'uipro'),
                    'selector' => '{{WRAPPER}} .uigrid-slideshow-item',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'title_margin_custom',
                    'label'         => __( 'Title Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uigrid-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],

                ),
                array(
                    'name'            => 'title_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the title.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uigrid-title',
                ),
                array(
                    'name' => 'title_color',
                    'type' => Controls_Manager::COLOR,
                    'label'     => esc_html__( 'Title Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .uigrid-title' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'name'          => 'meta_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__('Meta Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the meta.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uigrid-meta',
                ),
                array(
                    'name' => 'meta_color',
                    'type' => Controls_Manager::COLOR,
                    'label'     => esc_html__( 'Meta Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .uigrid-meta' => 'color: {{VALUE}}',
                    ],
                ),

			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}
	}
}