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

if ( ! class_exists( 'UIPro_Config_UIGallery' ) ) {
	/**
	 * Class UIPro_Config_UIGallery
	 */
	class UIPro_Config_UIGallery extends UIPro_Abstract_Config {

		/*
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uigallery';
			self::$name = esc_html__( 'TemPlaza: UI Gallery', 'uipro' );
			self::$desc = esc_html__( 'Add UI Gallery Box.', 'uipro' );
			self::$icon = 'eicon-gallery-justified';
			self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();
		}

		public function get_styles() {
            return array(
                'ui-gallery-loadmore' => array(
                    'src'   =>  'style.css'
                )
            );
        }

		public function get_scripts() {
			return array(
				'ui-gallery-loadmore' => array(
					'src'   =>  'script.min.js',
					'deps'  =>  array('jquery')
				)
			);
		}

		public function get_localize() {
			// get settings
			return array(
				'ui_gallery_loadmore_params'   =>  array(
					'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
					'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
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

			// options
			$options = array(
                array(
                    'type'          => Controls_Manager::GALLERY,
                    'id'            => 'gallery',
                    'default' => [],
                    'label'         => esc_html__( 'Gallery', 'uipro' ),
                    'description'   => esc_html__( 'Choose your images of gallery.', 'uipro' ),
                ),
				array(
					'type'          => Controls_Manager::NUMBER,
					'id'            => 'limit',
					'label'         => esc_html__( 'Limit', 'uipro' ),
					'description'   => esc_html__( 'Set the number of articles you want to display.', 'uipro' ),
					'min' => 1,
					'max' => 90,
					'step' => 1,
					'default' => 3,
				),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'pagination_type',
                    'label'         => esc_html__( 'Pagination Type', 'uipro' ),
                    'options'       => array(
                        'none'      => esc_html__('None', 'uipro'),
                        'default'   => esc_html__('Default', 'uipro'),
                        'ajax'      => esc_html__('Ajax Loading', 'uipro'),
                    ),
                    'default'       => 'none',
                    'description'   => esc_html__( 'Choose Pagination type for widget. Note: This option is run for only one UI Gallery Widget per page.', 'uipro' ),
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
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'lightbox',
                    'label'         => esc_html__('Use Lightbox', 'uipro'),
                    'description'   => esc_html__( 'Whether to enable lightbox.', 'uipro' ),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '1',
                ),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'masonry',
					'label'         => esc_html__('Enable Masonry', 'uipro'),
					'description'   => esc_html__( 'Select yes to enable Masonry Grid.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '0',
				),

				//Card Settings
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'card_size',
					'label' => esc_html__( 'Card Size', 'uipro' ),
					'default' => '',
					'options' => [
						'' => esc_html__('Default', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
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
						'{{WRAPPER}} .ui-gallery-info-wrap .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .ui-gallery-info-wrap .uk-card-footer' => 'padding: 20px {{RIGHT}}{{UNIT}} 20px {{LEFT}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_size', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),

				//Filter Settings
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'use_filter',
					'label'         => esc_html__('Use Filter', 'uipro'),
					'description'   => esc_html__( 'Display filter articles', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'start_section' => 'filter_settings',
					'section_name'  => esc_html__('Filter Settings', 'uipro')
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'filter_position',
					'label' => esc_html__( 'Filter Position', 'uipro' ),
					'default' => 'top',
					'options' => [
						'top' => esc_html__('Top', 'uipro'),
						'left' => esc_html__('Left', 'uipro'),
						'right' => esc_html__('Right', 'uipro'),
					],
				),
				array(
					'id'            => 'filter_width',
					'label'         => esc_html__( 'Filter Width', 'uipro' ),
					'type'          => Controls_Manager::SLIDER,
					'devices'       => [ 'desktop', 'tablet', 'mobile' ],
					'responsive'    => true,
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 1000,
							'step'=> 1,
						],
					],
					'desktop_default' => [
						'size' => 250,
						'unit' => 'px',
					],
					'tablet_default' => [
						'size' => 250,
						'unit' => 'px',
					],
					'mobile_default' => [
						'size' => 250,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .ui-gallery-filter' => 'width: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'filter_position', 'operator' => '!==', 'value' => 'top'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'filter_grid_gap',
					'label'         => esc_html__('Filter Gap', 'uipro'),
					'description'   => esc_html__('Modified Filter Gap Column', 'uipro'),
					'options'       => array(
						'' => esc_html__('Default', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'medium' => esc_html__('Medium', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
						'collapse' => esc_html__('Collapse', 'uipro'),
					),
					'default'           => '',
					'conditions' => [
						'terms' => [
							['name' => 'filter_position', 'operator' => '!==', 'value' => 'top'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'display_filter_header',
					'label'         => esc_html__('Display Header', 'uipro'),
					'description'   => esc_html__( 'Whether display filter header', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '1',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'filter_container',
					'label'         => esc_html__('Filter Container', 'uipro'),
					'description'   => esc_html__('Add the uk-container class to widget to give it a max-width and wrap the main content', 'uipro'),
					'options'       => array(
						'' => esc_html__('None', 'uipro'),
						'default' => esc_html__('Default', 'uipro'),
						'xsmall' => esc_html__('X-Small', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
						'xlarge' => esc_html__('X-Large', 'uipro'),
						'expand' => esc_html__('Expand', 'uipro'),
					),
					'default'           => '',
					'conditions' => [
						'terms' => [
							['name' => 'filter_position', 'operator' => '===', 'value' => 'top'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'filter_block_align',
					'label'         => esc_html__('Block Alignment', 'uipro'),
					'description'   => esc_html__('Define the alignment in case the container exceeds the element\'s max-width.', 'uipro'),
					'options'       => array(
						''=>__('Left', 'uipro'),
						'center'=>__('Center', 'uipro'),
						'right'=>__('Right', 'uipro'),
					),
					'default'           => '',
					'conditions' => [
						'terms' => [
							['name' => 'filter_container', 'operator' => '!==', 'value' => ''],
							['name' => 'filter_position', 'operator' => '===', 'value' => 'top'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'filter_block_align_breakpoint',
					'label'         => esc_html__('Block Alignment Breakpoint', 'uipro'),
					'description'   => esc_html__('Define the device width from which the alignment will apply.', 'uipro'),
					'options'       => array(
						''=>__('Always', 'uipro'),
						's'=>__('Small (Phone Landscape)', 'uipro'),
						'm'=>__('Medium (Tablet Landscape)', 'uipro'),
						'l'=>__('Large (Desktop)', 'uipro'),
						'xl'=>__('X-Large (Large Screens)', 'uipro'),
					),
					'default'           => '',
					'conditions' => [
						'terms' => [
							['name' => 'filter_position', 'operator' => '===', 'value' => 'top'],
							['name' => 'filter_container', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'filter_block_align_fallback',
					'label'         => esc_html__('Block Alignment Fallback', 'uipro'),
					'description'   => esc_html__('Define the alignment in case the container exceeds the element\'s max-width.', 'uipro'),
					'options'       => array(
						''=>__('Left', 'uipro'),
						'center'=>__('Center', 'uipro'),
						'right'=>__('Right', 'uipro'),
					),
					'default'           => '',
					'conditions' => [
						'relation' => 'and',
						'terms' => [
							['name' => 'filter_position', 'operator' => '===', 'value' => 'top'],
							['name' => 'filter_container', 'operator' => '!==', 'value' => ''],
							['name' => 'filter_block_align_breakpoint', 'operator' => '!==', 'value' => ''],
						],
					],

				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'filter_text_alignment',
					'label' => esc_html__( 'Text Alignment', 'uipro' ),
					'options'       => array(
						'' => esc_html__('None', 'uipro'),
						'left' => esc_html__('Left', 'uipro'),
						'center' => esc_html__('Center', 'uipro'),
						'right' => esc_html__('Right', 'uipro'),
					),
					'default'           => '',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'filter_text_alignment_breakpoint',
					'label'         => esc_html__('Text Alignment Breakpoint', 'uipro'),
					'description'   => esc_html__('Display the button alignment only on this device width and larger', 'uipro'),
					'options'       => array(
						'' => esc_html__('Always', 'uipro'),
						's' => esc_html__('Small (Phone Landscape)', 'uipro'),
						'm' => esc_html__('Medium (Tablet Landscape)', 'uipro'),
						'l' => esc_html__('Large (Desktop)', 'uipro'),
						'xl' => esc_html__('X-Large (Large Screens)', 'uipro'),
					),
					'default'           => '',
					'conditions' => [
						'terms' => [
							['name' => 'filter_text_alignment', 'operator' => '!==', 'value' => ''],
						],
					],

				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'filter_text_alignment_fallback',
					'label'         => esc_html__('Text Alignment Fallback', 'uipro'),
					'description'   => esc_html__('Define an alignment fallback for device widths below the breakpoint.', 'uipro'),
					'options'       => array(
						'' => esc_html__('None', 'uipro'),
						'left' => esc_html__('Left', 'uipro'),
						'center' => esc_html__('Center', 'uipro'),
						'right' => esc_html__('Right', 'uipro'),
					),
					'default'           => '',
					'conditions' => [
						'relation' => 'and',
						'terms' => [
							['name' => 'filter_text_alignment', 'operator' => '!==', 'value' => ''],
							['name' => 'filter_text_alignment_breakpoint', 'operator' => '!==', 'value' => ''],
						],
					],

				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'filter_animate',
					'label'         => esc_html__( 'Filter Animate', 'uipro' ),
					'options'       => array(
						'slide'     => esc_html__('Slide', 'uipro'),
						'fade'      => esc_html__('Fade', 'uipro'),
						'delayed-fade'    => esc_html__('Delayed Fade', 'uipro'),
					),
					'default'       => 'slide',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'filter_margin',
					'label'         => esc_html__('Margin Bottom', 'uipro'),
					'description'   => esc_html__('Set the bottom margin.', 'uipro'),
					'options'       => array(
						'' => esc_html__('Default', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'medium' => esc_html__('Medium', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
						'xlarge' => esc_html__('X-Large', 'uipro'),
						'remove-vertical' => esc_html__('None', 'uipro'),
					),
					'default'           => '',
					'conditions' => [
						'terms' => [
							['name' => 'filter_position', 'operator' => '===', 'value' => 'top'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'filter_visibility',
					'label'         => esc_html__('Visibility', 'uipro'),
					'description'   => esc_html__('Display the element only on this device width and larger.', 'uipro'),
					'options'       => array(
						'' => esc_html__('Always', 'uipro'),
						'@s' => esc_html__('Small (Phone Landscape)', 'uipro'),
						'@m' => esc_html__('Medium (Tablet Landscape)', 'uipro'),
						'@l' => esc_html__('Large (Desktop)', 'uipro'),
						'@xl' => esc_html__('X-Large (Large Screens)', 'uipro'),
					),
					'default'           => '',
				),

				//Slider Settings
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'use_slider',
					'label'         => esc_html__('Display Articles as Slider', 'uipro'),
					'description'   => esc_html__( 'Display Articles as Carousel Slider', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'start_section' => 'slider_settings',
					'section_name'  => esc_html__('Slider Settings', 'uipro')
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'enable_navigation',
					'label'         => esc_html__('Navigation', 'uipro'),
					'description'   => esc_html__( 'Enable Navigation', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '1',
					'conditions' => [
						'terms' => [
							['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'navigation_position',
					'label' => esc_html__( 'Navigation Position', 'uipro' ),
					'default' => '',
					'options' => [
						'' => esc_html__('Outside', 'uipro'),
						'inside' => esc_html__('Inside', 'uipro'),
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
							['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'enable_dotnav',
					'label'         => esc_html__('Dot Navigation', 'uipro'),
					'description'   => esc_html__( 'Enable Dot Navigation', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '1',
					'conditions' => [
						'terms' => [
							['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'center_slider',
					'label'         => esc_html__('Center Slider', 'uipro'),
					'description'   => esc_html__( 'To center the list items', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'conditions' => [
						'terms' => [
							['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
						],
					],
				),

				//Title configure
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'title_display',
                    'label'         => esc_html__('Show Title', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '1',
                    'start_section' => 'title_settings',
                    'section_name'      => esc_html__('Title Settings', 'uipro')
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_display', 'operator' => '===', 'value' => '1'],
                        ],
                    ],

				),
				array(
					'name'            => 'title_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-title',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_display', 'operator' => '===', 'value' => '1'],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_display', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
				),
				array(
					'id'            => 'custom_title_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-title > a, {{WRAPPER}} .ui-title' => 'color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_display', 'operator' => '===', 'value' => '1'],
                        ],
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
					),
					'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_display', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
				),

				// Image Settings
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'thumbnail_hover',
					'label'         => esc_html__('Content display on hover', 'uipro'),
					'description'   => esc_html__( 'Whether to enable on hover content article with thumbnail.', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
                    'start_section' => 'image_settings',
                    'section_name'  => esc_html__('Image Settings', 'uipro')
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'thumbnail_hover_transition',
					'label' => esc_html__( 'Hover Transition', 'uipro' ),
					'default' => 'fade',
					'options' => [
						'fade' => esc_html__('Fade', 'uipro'),
						'scale-up' => esc_html__('Scale Up', 'uipro'),
						'scale-down' => esc_html__('Scale Down', 'uipro'),
						'slide-top' => esc_html__('Slide Top', 'uipro'),
						'slide-bottom' => esc_html__('Slide Bottom', 'uipro'),
						'slide-left' => esc_html__('Slide Left', 'uipro'),
						'slide-right' => esc_html__('Slide Right', 'uipro'),
						'slide-top-small' => esc_html__('Slide Top Small', 'uipro'),
						'slide-bottom-small' => esc_html__('Slide Bottom Small', 'uipro'),
						'slide-left-small' => esc_html__('Slide Left Small', 'uipro'),
						'slide-right-small' => esc_html__('Slide Right Small', 'uipro'),
						'slide-top-medium' => esc_html__('Slide Top Medium', 'uipro'),
						'slide-bottom-medium' => esc_html__('Slide Bottom Medium', 'uipro'),
						'slide-left-medium' => esc_html__('Slide Left Medium', 'uipro'),
						'slide-right-medium' => esc_html__('Slide Right Medium', 'uipro'),
					],
					'conditions' => [
						'terms' => [
							['name' => 'thumbnail_hover', 'operator' => '===', 'value' => '1'],
						],
					],
				),
                array(
                    'type'          => \Elementor\Group_Control_Background::get_type(),
                    'name'          => 'image_overlay_color',
                    'label' => __( 'Image Overlay Hover Color', 'uipro' ),
                    'default' => '',
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .ui-gallery .uk-overlay-primary',
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
                        'ripple' => __('Ripple', 'uipro'),
                        'zoomin-roof' => __('Zoom in roof', 'uipro'),
                    ),
                    'default'       => '',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'roof_border_color',
                    'label'         => esc_html__('Roof Border Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::before' => 'border-right-color: {{VALUE}}',
                        '{{WRAPPER}} .zoomin-roof a::after' => 'border-left-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'roof_border_hover_color',
                    'label'         => esc_html__('Roof Border Hover Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'border-right-color: {{VALUE}}',
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'border-left-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'roof_left_hover_radius',
                    'label'         => esc_html__( 'Roof left hover Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'roof_right_hover_radius',
                    'label'         => esc_html__( 'Roof right hover Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'roof_hover-rotate',
                    'label' => __( 'Roof Hover rotate', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'deg' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -360,
                            'max' => 360,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'deg',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'transform: rotate({{SIZE}}{{UNIT}});',
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'transform: rotate(-{{SIZE}}{{UNIT}});',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_transform_left_hover',
                    'label'         => esc_html__( 'Roof left transform hover', 'uipro' ),
                    'description'   => esc_html__( 'Example: [translateX(-100%)] Read more: https://www.w3schools.com/cssref/css3_pr_transform.php ', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'transform: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_transform_right_hover',
                    'label'         => esc_html__( 'Roof right transform hover', 'uipro' ),
                    'description'   => esc_html__( 'Example: [translateX(100%)] Read more: https://www.w3schools.com/cssref/css3_pr_transform.php ', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'transform: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_left_transform',
                    'label'         => esc_html__( 'Roof left transform', 'uipro' ),
                    'description'   => esc_html__( 'Example: [top right] Read more: https://www.w3schools.com/cssref/css3_pr_transform-origin.php', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::before' => 'transform-origin: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_right_transform',
                    'label'         => esc_html__( 'Roof right transform', 'uipro' ),
                    'description'   => esc_html__( 'Example: [top left] Read more: https://www.w3schools.com/cssref/css3_pr_transform-origin.php', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::after' => 'transform-origin: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
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
					'label'         => esc_html__( 'Thumbnail Height', 'uipro' ),
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
					'type'          => Controls_Manager::SELECT,
					'id'            => 'image_border_radius',
					'label'         => esc_html__( 'Border Radius', 'uipro' ),
					'description'   => esc_html__( 'Select the image\'s border style.', 'uipro' ),
					'options'       => array(
						'' => esc_html__('None', 'uipro'),
						'uk-border-circle' => esc_html__('Circle', 'uipro'),
						'uk-border-rounded' => esc_html__('Rounded', 'uipro'),
						'uk-border-pill' => esc_html__('Pill', 'uipro'),
						'custom' => esc_html__('Custom', 'uipro'),
					),
					'default'       => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'image_custom_radius',
                    'label'         => esc_html__( 'Image Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-gallery-items .uk-article' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_border_radius', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
				array(
					'type'          => \Elementor\Group_Control_Image_Size::get_type(),
					'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'large'
				),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'article_border',
                    'label'         => esc_html__( 'Border', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .uk-article',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'article_box_shadow',
                    'label'         => esc_html__( 'Box Shadow', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .uk-article',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'article_border_hover',
                    'label'         => esc_html__( 'Border Hover', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .uk-article:hover',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'article_box_shadow_hover',
                    'label'         => esc_html__( 'Box Shadow Hover', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .uk-article:hover',
                ),

				//Content style
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'show_introtext',
					'label'         => esc_html__('Show Introtext', 'uipro'),
					'description'   => esc_html__( 'Whether to show instrotext.', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '1',
					'start_section' => 'content_settings',
					'section_name'  => esc_html__('Content Settings', 'uipro')
				),
				array(
					'name'          => 'content_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-gallery-introtext',
				),
				array(
					'id'            => 'content_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-gallery-introtext' => 'color: {{VALUE}}',
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

				//Meta settings
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'caption_position',
                    'label'         => esc_html__('Choose Caption Position', 'uipro'),
                    'description'   => esc_html__('Set the position of Caption.', 'uipro'),
                    'options'       => array(
                        'before_title' => esc_html__('Before Title', 'uipro'),
                        'after_title' => esc_html__('After Title', 'uipro'),
                        'after_description' => esc_html__('After Description', 'uipro'),
                    ),
                    'default'           => 'before_title',
                    'start_section' => 'meta_settings',
                    'section_name'  => esc_html__('Meta Settings', 'uipro')
                ),
                array(
                    'name'          => 'caption_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Before Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-gallery-item-caption',
                    'separator'     => 'before',
                ),
                array(
                    'id'            => 'caption_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Before Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-gallery-item-caption' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'caption_top_margin',
                    'label'         => esc_html__('Caption Top Margin', 'uipro'),
                    'description'   => esc_html__('Set the caption top margin.', 'uipro'),
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
                    'id'            => 'caption_bottom_margin',
                    'label'         => esc_html__('Caption Bottom Margin', 'uipro'),
                    'description'   => esc_html__('Set the caption bottom margin.', 'uipro'),
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