<?php
/**
 * UIPro Post config class
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

use TemPlazaFramework\Functions as TemplazaFramework_Functions;

require_once __DIR__.'/helper.php';
if ( ! class_exists( 'UIPro_Config_UIPosts' ) ) {
	/**
	 * Class UIPro_Config_UIPosts
	 */
	class UIPro_Config_UIPosts extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {			// info
			self::$base = 'uiposts';
			self::$name = esc_html__( 'TemPlaza: UI Posts', 'uipro' );
			self::$desc = esc_html__( 'Add UI Posts Box.', 'uipro' );
			self::$icon = 'eicon-posts-grid';
			self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();

            add_action( 'elementor/editor/after_enqueue_scripts', array($this, 'editor_enqueue_scripts') );
		}

		public function get_styles() {
            return array(
                'ui-post-loadmore' => array(
                    'src'   =>  'style.css'
                )
            );
        }

		public function get_scripts() {
			return array(
				'ui-post-loadmore' => array(
					'src'   =>  'script.min.js',
					'deps'  =>  array('jquery')
				)
			);
		}

		public function get_localize() {
			global $wp_query;
			// get settings
			return array(
				'ui_post_loadmore_params'   =>  array(
					'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
					'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
				)
			);
		}

        public function editor_enqueue_scripts(){
		    if(!wp_script_is('uiposts-editor')) {
                wp_enqueue_script('uiposts-editor', plugins_url('assets/js/editor.js', __FILE__));

                $uipost_editor = array(
                    'i18n'  => array(
                        'featured_only'  => esc_html__('Featured Only', 'uipro')
                    )
                );
                if (class_exists('TemPlazaFramework\Functions')) {
                    $options = TemplazaFramework_Functions::get_global_settings();

                    if (isset($options['enable-featured-for-posttypes']) && !empty($options['enable-featured-for-posttypes'])) {
                        $uipost_editor['enable_featured_for_posttypes'] = $options['enable-featured-for-posttypes'];
                    }
                }
                wp_localize_script('uiposts-editor', 'elementor__uiposts_editor', $uipost_editor);
            }
        }

		/**
		 * @return array
		 */
		public function get_options() {
		    $post_types =   UIPro_Helper::get_post_type( 'category' );

            $store_id   = __METHOD__;
            $store_id  .= '::'.serialize($post_types);
            $store_id   = md5($store_id);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

			// options
			$options = array(
                array(
                    'id'        => 'uipost_layout',
                    'label'     => esc_html__( 'Layout', 'uipro' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => array(
                        'base'      => esc_html__('Default', 'uipro'),
                        'style1'    => esc_html__('Style 1', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'resource',
					'label'         => esc_html__( 'Choose Resource', 'uipro' ),
					'options'       => $post_types,
					'default'       => 'post',
					'description'   => esc_html__( 'Select a content resource from the list. if you choose Portfolio then you must have to installed Portfolio post type.', 'uipro' ),
				),
				array(
					'type'          => Controls_Manager::SELECT2,
					'id'            => 'post_category',
					'label'         => esc_html__( 'Select Category', 'uipro' ),
					'options'       => UIPro_Helper::get_cat_taxonomy( 'category' ),
					'multiple'      => true,
					'conditions' => [
						'terms' => [
							['name' => 'resource', 'operator' => '===', 'value' => 'post'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'include_subcagories',
					'label'         => esc_html__('Include subcagories', 'uipro'),
					'description'   => esc_html__( 'Select yes to include sub categories', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '0',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'show_featured',
					'label'         => esc_html__( 'Featured', 'uipro' ),
					'options'       => array(
						''          => esc_html__('Show', 'uipro'),
						'0'         => esc_html__('Hide', 'uipro'),
						'1'         => esc_html__('Only Featured', 'uipro'),
					),
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'ordering',
					'label'         => esc_html__( 'Ordering', 'uipro' ),
					'options'       => array(
						'latest'    => esc_html__('Latest', 'uipro'),
						'oldest'    => esc_html__('Oldest', 'uipro'),
						'popular'   => esc_html__('Popular', 'uipro'),
						'sticky'   => esc_html__('Sticky Only', 'uipro'),
						'random'    => esc_html__('Random', 'uipro'),
					),
					'default'       => 'latest',
					'description'   => esc_html__( 'Select articles ordering from the list.', 'uipro' ),
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
                    'description'   => esc_html__( 'Choose Pagination type for widget. Note: This option is run for only one UI Post Widget per page.', 'uipro' ),
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
					'type'          => Controls_Manager::SELECT,
					'id'            => 'color_mode',
					'label'         => esc_html__( 'Color Mode', 'uipro' ),
					'options'       => array(
						'dark'      => esc_html__('Dark', 'uipro'),
						'light' => esc_html__('Light', 'uipro'),
					),
					'default'       => 'dark',
					'separator'     => 'before',
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
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'post_link',
					'label'         => esc_html__('Disable post link', 'uipro'),
					'description'   => esc_html__( 'Disable link to detail.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '0',
				),
            );

            // Load lead settings
            if(($lead_file = __DIR__ . '/config/lead.php') && file_exists($lead_file)) {
                $lead_options = require_once $lead_file;
                if(!empty($lead_options) && is_array($lead_options)){
                    $options    = array_merge($options, $lead_options);
                }
            }

            $options    = array_merge($options, array(
				//Card Settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'card_style',
					'label' => esc_html__( 'Card Style', 'uipro' ),
					'default' => '',
					'options' => [
						'' => esc_html__('None', 'uipro'),
						'default' => esc_html__('Card Default', 'uipro'),
						'primary' => esc_html__('Card Primary', 'uipro'),
						'secondary' => esc_html__('Card Secondary', 'uipro'),
						'hover' => esc_html__('Card Hover', 'uipro'),
						'custom' => esc_html__('Custom', 'uipro'),
					],
					'start_section' => 'card_settings',
					'section_name'      => esc_html__('Card Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_background',
					'label'         => esc_html__('Card Background', 'uipro'),
					'description'   => esc_html__('Set the Background Color of Card.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-posts.style1 .uk-card' => 'background-color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .uk-card' => 'background-color: {{VALUE}}',
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
						'{{WRAPPER}} .ui-posts.style1 .uk-card' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .uk-card' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'card_size',
					'label' => esc_html__( 'Card Size', 'uipro' ),
					'default' => '',
					'options' => [
                        'none' => esc_html__('None', 'uipro'),
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
						'{{WRAPPER}} .ui-posts-intro-item .ui-post-info-wrap .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .ui-posts-intro-item .ui-post-info-wrap .uk-card-footer' => 'padding: 20px {{RIGHT}}{{UNIT}} 20px {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .ui-posts.style1 .ui-post-info-wrap .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .ui-posts.style1 .ui-post-info-wrap .uk-card-footer' => 'padding: 20px {{RIGHT}}{{UNIT}} 20px {{LEFT}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_size', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),

                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_radius',
                    'label'         => esc_html__( 'Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'card_border',
                    'label'         => esc_html__('Card Border', 'uipro'),
                    'description'   => esc_html__('Set the Border of Card.', 'uipro'),
                    'selector' => '{{WRAPPER}} .ui-posts.style1 .uk-card'
                        .',{{WRAPPER}} .ui-posts-intro-item .uk-card',
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'card_box_shadow',
                    'label'         => esc_html__('Card Box Shadow', 'uipro'),
                    'description'   => esc_html__('Set the Box Shadow of Card.', 'uipro'),
                    'selector' => '{{WRAPPER}} .ui-posts.style1 .uk-card'
                        .',{{WRAPPER}} .ui-posts-intro-item .uk-card',
                ),
                array(
                    'type'          =>  Controls_Manager::SELECT,
                    'name'          => 'card_gutter',
                    'label'         => esc_html__('Card Gutter', 'uipro'),
                    'options'       => array(
                        ''          => esc_html__('Default', 'uipro'),
                        'small'     => esc_html__('Small', 'uipro'),
                        'medium'    => esc_html__('Medium', 'uipro'),
                        'large'     => esc_html__('Large', 'uipro'),
                        'collapse'  => esc_html__('Collapse', 'uipro'),
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::SWITCHER,
                    'name'          => 'card_divider',
                    'label'         => esc_html__('Card Divider', 'uipro'),
                ),
                array(
                    'type'          =>  Controls_Manager::SWITCHER,
                    'name'          => 'card_divider_horizontal',
                    'label'         => esc_html__('Card Divider Horizontal', 'uipro'),
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
						'{{WRAPPER}} .ui-posts.style1 .ui-post-filter' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ui-posts-intro-item .ui-post-filter' => 'width: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'filter_position', 'operator' => '!==', 'value' => 'top'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT2,
					'id'            => 'filter_type',
					'label' => esc_html__( 'Filter Type', 'uipro' ),
					'default' => 'tag',
					'multiple' => true,
					'options' => [
						'tag' => esc_html__('Tags', 'uipro'),
						'category' => esc_html__('Categories', 'uipro'),
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
					'id'            => 'use_filter_sort',
					'label'         => esc_html__('Use Filter Sort', 'uipro'),
					'description'   => esc_html__( 'Display filter sort', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
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
						'remove' => esc_html__('None', 'uipro'),
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
                    'id'            => 'enable_slider_autoplay',
                    'label'         => esc_html__('Auto Play', 'uipro'),
                    'description'   => esc_html__( 'Enable Auto Play', 'uipro' ),
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
                array(
                    'type'          => Controls_Manager::NUMBER,
                    'id'            => 'slider_autoplay_interval',
                    'label'         => esc_html__('Auto Play Interval', 'uipro'),
                    'description'   => esc_html__( 'The delay between switching slides in autoplay mode.', 'uipro' ),
                    'default'       => 7000,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                            ['name' => 'enable_slider_autoplay', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'slider_padding',
                    'label'         => esc_html__( 'Slider Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-slider-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-slider-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => array(
                        'use_slider'    => '1'
                    ),
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
                        'top-left' => esc_html__( 'Top Left', 'uipro' ),
                        'top-right' => esc_html__( 'Top Right', 'uipro' ),
                        'center-left' => esc_html__( 'Center Left', 'uipro' ),
                        'center-right' => esc_html__( 'Center Right', 'uipro' ),
                        'bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
                        'bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
                        'bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
							['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
						],
					],
				),
                    array(
                        'type'          => Controls_Manager::DIMENSIONS,
                        'name'          => 'navigation_margin_custom',
                        'label'         => esc_html__( 'Navigation Margin', 'uipro' ),
                        'responsive'    =>  true,
                        'size_units'    => [ 'px', 'em', '%' ],
                        'selectors'     => [
                            '{{WRAPPER}} .uk-nav-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        ],
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),
                    array(
                        'type'          => Controls_Manager::DIMENSIONS,
                        'name'          => 'navigation_pos_margin',
                        'label'         => esc_html__( 'Next Margin', 'uipro' ),
                        'responsive'    =>  true,
                        'size_units'    => [ 'px', 'em', '%' ],
                        'selectors'     => [
                            '{{WRAPPER}} .uk-slidenav-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        ],
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),
                    array(
                        'type'          => Controls_Manager::DIMENSIONS,
                        'name'          => 'navigation_pos_margin_pre',
                        'label'         => esc_html__( 'Preview Margin', 'uipro' ),
                        'responsive'    =>  true,
                        'size_units'    => [ 'px', 'em', '%' ],
                        'selectors'     => [
                            '{{WRAPPER}} .uk-slidenav-previous' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        ],
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),

                    array(
                        'type'          =>  \Elementor\Group_Control_Border::get_type(),
                        'name'          => 'nav_border',
                        'label'         => esc_html__('Nav Border', 'uipro'),
                        'selector' => '{{WRAPPER}} .uk-slider .uk-slidenav',
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),
                    array(
                        'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
                        'name'          => 'nav_shadow',
                        'label'         => esc_html__('Nav Shadow', 'uipro'),
                        'selector' => '{{WRAPPER}} .uk-slidenav',
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),
                    array(
                        'type'          => Controls_Manager::DIMENSIONS,
                        'name'          =>  'nav_radius',
                        'label'         => esc_html__( 'Nav radius', 'uipro' ),
                        'responsive'    =>  true,
                        'size_units'    => [ 'px', 'em', '%' ],
                        'selectors'     => [
                            '{{WRAPPER}} .uk-slider .uk-slidenav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                        ],
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),
                    array(
                        'label' => esc_html__( 'Nav background color', 'uipro' ),
                        'name'  => 'nav_bg',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .uk-slider .uk-slidenav' => 'background-color: {{VALUE}}',
                        ],
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),
                    array(
                        'label' => esc_html__( 'Nav color', 'uipro' ),
                        'name'  => 'nav_color',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .uk-slider .uk-slidenav' => 'color: {{VALUE}}',
                        ],
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),
                    array(
                        'label' => esc_html__( 'Nav Hover background color', 'uipro' ),
                        'name'  => 'nav_bg_hover',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .uk-slider .uk-slidenav:hover' => 'background-color: {{VALUE}}',
                        ],
                        'conditions' => [
                            'terms' => [
                                ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                                ['name' => 'enable_navigation', 'operator' => '===', 'value' => '1'],
                            ],
                        ],
                    ),
                    array(
                        'label' => esc_html__( 'Nav Hover color', 'uipro' ),
                        'name'  => 'nav_color_hover',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .uk-slider .uk-slidenav:hover' => 'color: {{VALUE}}',
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
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'dotnav_margin',
                    'label'         => esc_html__( 'Dot Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-dotnav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-dotnav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                            ['name' => 'enable_dotnav', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Dot Navigation Color', 'uipro' ),
                    'name'  => 'dotnav_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-dotnav li > * ' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-dotnav li > * ' => 'border-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                            ['name' => 'enable_dotnav', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Dot Navigation Active Color', 'uipro' ),
                    'name'  => 'dotnav_active_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-dotnav > .uk-active > *, {{WRAPPER}} .uk-dotnav li:hover > * ' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-dotnav > .uk-active > *, {{WRAPPER}} .ui-posts-intro-item .uk-dotnav li:hover > * ' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                            ['name' => 'enable_dotnav', 'operator' => '===', 'value' => '1'],
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
					'start_section' => 'title_settings',
					'section_name'      => esc_html__('Title Settings', 'uipro')
				),
				array(
					'name'            => 'title_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-posts.style1 .ui-title,{{WRAPPER}} .ui-posts-intro-item .ui-title',
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
					'id'            => 'custom_title_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Title Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-posts.style1 .ui-title > a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .ui-title > a' => 'color: {{VALUE}}',
					],
				),
				array(
					'id'            => 'custom_title_hover_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Title Hover Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-posts.style1 .ui-title > a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .ui-title > a:hover' => 'color: {{VALUE}}',
					],
				),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'custom_title_color_gradient',
                    'label'         => esc_html__('Title Gradient Color', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Background::get_type(),
                    'name'          => 'custom_title_hover_gradient_color',
                    'label' => __( 'Title Hover Gradient Color', 'uipro' ),
                    'default' => '',
                    'types' => [ 'gradient' ],
                    'selector' => '{{WRAPPER}} .tz-title-gradient a:hover',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'custom_title_color_gradient', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),

				array(
					'type'          => Controls_Manager::SLIDER,
					'id'            => 'title_maxwidth',
					'label'         => esc_html__('Title Max Width', 'uipro'),
					'description'   => esc_html__('Set the title max width.', 'uipro'),
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2500,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
//					'default'           => '',
                        'selectors' => [
                            '{{WRAPPER}} .ui-posts.style1 .ui-title > *' => 'max-width: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .ui-posts-intro-item .ui-title > *' => 'max-width: {{SIZE}}{{UNIT}};',
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
						'custom' => esc_html__('Custom', 'uipro'),
						'remove' => esc_html__('None', 'uipro'),
					),
					'default'           => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'title_margin_custom',
                    'label'         => esc_html__( 'Title Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_margin', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),

				// Image Settings
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'hide_thumbnail',
					'label'         => esc_html__('Hide Thumbnail', 'uipro'),
					'description'   => esc_html__( 'Whether to hide article thumbnail.', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'start_section' => 'image_settings',
					'section_name'  => esc_html__('Image Settings', 'uipro')
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'layout',
					'label' => esc_html__( 'Layout', 'uipro' ),
					'default' => '',
					'options' => [
						'' => esc_html__('Default', 'uipro'),
						'thumbnail' => esc_html__('Thumbnail', 'uipro')
					],
					'conditions' => [
						'terms' => [
							['name' => 'hide_thumbnail', 'operator' => '!==', 'value' => '1'],
						],
					],
				),
                array(
                    'type'          => \Elementor\Group_Control_Background::get_type(),
                    'name'          => 'image_background_overlay',
                    'label'         => __( 'Image Overlay Background', 'uipro' ),
                    'default'       => '',
                    'types'         => [ 'classic', 'gradient' ],
                    'selector'      => '{{WRAPPER}} .ui-posts-intro-item .uk-overlay-primary'
                        .',{{WRAPPER}} .ui-posts.style1 .uk-overlay-primary',
                    'conditions'    => [
                        'terms' => [
                            ['name' => 'hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                            ['name' => 'layout', 'operator' => '===', 'value' => 'thumbnail'],
                        ],
                    ],
                ),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'thumbnail_hover',
					'label'         => esc_html__('Content display on hover', 'uipro'),
					'description'   => esc_html__( 'Whether to enable on hover content article with thumbnail.', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'conditions' => [
						'terms' => [
							['name' => 'layout', 'operator' => '===', 'value' => 'thumbnail'],
						],
					],
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
					'type'          => Controls_Manager::SELECT,
					'id'            => 'image_position',
					'label'         => esc_html__( 'Image Position', 'uipro' ),
					'description'   => esc_html__( 'Select the image\'s position.', 'uipro' ),
					'options'       => array(
						'top'       => esc_html__('Top', 'uipro'),
						'left'      => esc_html__('Left', 'uipro'),
						'right'     => esc_html__('Right', 'uipro'),
						'bottom'    => esc_html__('Bottom', 'uipro'),
						'inside'    => esc_html__('Inside Body', 'uipro'),
					),
					'default'       => 'top',
					'conditions' => [
						'terms' => [
							['name' => 'layout', 'operator' => '===', 'value' => ''],
						],
					],
				),
                    array(
                        'id'          => 'image_width_xl',
                        'label' => esc_html__( 'Image Width Large Desktop', 'uipro' ),
                        'type' => Controls_Manager::SELECT,
                        'options'       => array(
                            '1-1'    => esc_html__('1-1', 'uipro'),
                            '1-2'    => esc_html__('1-2', 'uipro'),
                            '1-3'    => esc_html__('1-3', 'uipro'),
                            '2-3'    => esc_html__('2-3', 'uipro'),
                            '1-4'    => esc_html__('1-4', 'uipro'),
                            '3-4'    => esc_html__('3-4', 'uipro'),
                            '1-5'    => esc_html__('1-5', 'uipro'),
                            '2-5'    => esc_html__('2-5', 'uipro'),
                            '3-5'    => esc_html__('3-5', 'uipro'),
                            '4-5'    => esc_html__('4-5', 'uipro'),
                            '1-6'    => esc_html__('1-6', 'uipro'),
                            '5-6'    => esc_html__('5-6', 'uipro'),
                        ),
                        'default'   => '1-2',
                        'conditions' => [
                            'terms' =>[
                                ['name' => 'hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                                ['name' => 'layout', 'operator' => '===', 'value' => ''],
                                ['name' => 'image_position', 'operator' => 'in', 'value' => ['left','right']],
                            ],
                        ],
                    ),
                    array(
                        'id'          => 'image_width_l',
                        'label' => esc_html__( 'Image Width Desktop', 'uipro' ),
                        'type' => Controls_Manager::SELECT,
                        'options'       => array(
                            '1-1'    => esc_html__('1-1', 'uipro'),
                            '1-2'    => esc_html__('1-2', 'uipro'),
                            '1-3'    => esc_html__('1-3', 'uipro'),
                            '2-3'    => esc_html__('2-3', 'uipro'),
                            '1-4'    => esc_html__('1-4', 'uipro'),
                            '3-4'    => esc_html__('3-4', 'uipro'),
                            '1-5'    => esc_html__('1-5', 'uipro'),
                            '2-5'    => esc_html__('2-5', 'uipro'),
                            '3-5'    => esc_html__('3-5', 'uipro'),
                            '4-5'    => esc_html__('4-5', 'uipro'),
                            '1-6'    => esc_html__('1-6', 'uipro'),
                            '5-6'    => esc_html__('5-6', 'uipro'),
                        ),
                        'default'   => '1-2',
                        'conditions' => [
                            'terms' =>[
                                ['name' => 'hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                                ['name' => 'layout', 'operator' => '===', 'value' => ''],
                                ['name' => 'image_position', 'operator' => 'in', 'value' => ['left','right']],
                            ],
                        ],
                    ),
                    array(
                        'id'          => 'image_width_m',
                        'label' => esc_html__( 'Image Width Laptop', 'uipro' ),
                        'type' => Controls_Manager::SELECT,
                        'options'       => array(
                            '1-1'    => esc_html__('1-1', 'uipro'),
                            '1-2'    => esc_html__('1-2', 'uipro'),
                            '1-3'    => esc_html__('1-3', 'uipro'),
                            '2-3'    => esc_html__('2-3', 'uipro'),
                            '1-4'    => esc_html__('1-4', 'uipro'),
                            '3-4'    => esc_html__('3-4', 'uipro'),
                            '1-5'    => esc_html__('1-5', 'uipro'),
                            '2-5'    => esc_html__('2-5', 'uipro'),
                            '3-5'    => esc_html__('3-5', 'uipro'),
                            '4-5'    => esc_html__('4-5', 'uipro'),
                            '1-6'    => esc_html__('1-6', 'uipro'),
                            '5-6'    => esc_html__('5-6', 'uipro'),
                        ),
                        'default'   => '1-2',
                        'conditions' => [
                            'terms' =>[
                                ['name' => 'hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                                ['name' => 'layout', 'operator' => '===', 'value' => ''],
                                ['name' => 'image_position', 'operator' => 'in', 'value' => ['left','right']],
                            ],
                        ],
                    ),
                    array(
                        'id'          => 'image_width_s',
                        'label' => esc_html__( 'Image Width Tablet', 'uipro' ),
                        'type' => Controls_Manager::SELECT,
                        'options'       => array(
                            '1-1'    => esc_html__('1-1', 'uipro'),
                            '1-2'    => esc_html__('1-2', 'uipro'),
                            '1-3'    => esc_html__('1-3', 'uipro'),
                            '2-3'    => esc_html__('2-3', 'uipro'),
                            '1-4'    => esc_html__('1-4', 'uipro'),
                            '3-4'    => esc_html__('3-4', 'uipro'),
                            '1-5'    => esc_html__('1-5', 'uipro'),
                            '2-5'    => esc_html__('2-5', 'uipro'),
                            '3-5'    => esc_html__('3-5', 'uipro'),
                            '4-5'    => esc_html__('4-5', 'uipro'),
                            '1-6'    => esc_html__('1-6', 'uipro'),
                            '5-6'    => esc_html__('5-6', 'uipro'),
                        ),
                        'default'   => '1-2',
                        'conditions' => [
                            'terms' =>[
                                ['name' => 'hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                                ['name' => 'layout', 'operator' => '===', 'value' => ''],
                                ['name' => 'image_position', 'operator' => 'in', 'value' => ['left','right']],
                            ],
                        ],
                    ),
                    array(
                        'id'          => 'image_width',
                        'label' => esc_html__( 'Image Width Mobile', 'uipro' ),
                        'type' => Controls_Manager::SELECT,
                        'options'       => array(
                            '1-1'    => esc_html__('1-1', 'uipro'),
                            '1-2'    => esc_html__('1-2', 'uipro'),
                            '1-3'    => esc_html__('1-3', 'uipro'),
                            '2-3'    => esc_html__('2-3', 'uipro'),
                            '1-4'    => esc_html__('1-4', 'uipro'),
                            '3-4'    => esc_html__('3-4', 'uipro'),
                            '1-5'    => esc_html__('1-5', 'uipro'),
                            '2-5'    => esc_html__('2-5', 'uipro'),
                            '3-5'    => esc_html__('3-5', 'uipro'),
                            '4-5'    => esc_html__('4-5', 'uipro'),
                            '1-6'    => esc_html__('1-6', 'uipro'),
                            '5-6'    => esc_html__('5-6', 'uipro'),
                        ),
                        'default'   => '1-2',
                        'conditions' => [
                            'terms' =>[
                                ['name' => 'hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                                ['name' => 'layout', 'operator' => '===', 'value' => ''],
                                ['name' => 'image_position', 'operator' => 'in', 'value' => ['left','right']],
                            ],
                        ],
                    ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'image_margin',
                    'label'         => esc_html__('Image Margin', 'uipro'),
                    'description'   => esc_html__('Set the image margin.', 'uipro'),
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
                            ['name' => 'image_position', 'operator' => '===', 'value' => 'inside'],
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
						'{{WRAPPER}} .ui-posts-intro-item .tz-image-cover' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ui-posts.style1 .tz-image-cover' => 'height: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'cover_image', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'id'            => 'image_border',
					'label'         => esc_html__( 'Border', 'uipro' ),
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
                    'name'          =>  'image_border_radius',
                    'label'         => esc_html__( 'Image border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-thumb-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-thumb-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                    'condition'     => array(
                        'image_border'    => 'custom'
                    ),
                ),
	            array(
		            'label' => esc_html__( 'Image background color', 'uipro' ),
		            'name'  => 'image_bg',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .tz-img' => 'background-color: {{VALUE}}',
		            ],
		            'conditions' => [
			            'terms' => [
				            ['name' => 'image_border', 'operator' => '!=', 'value' => ''],
				            ['name' => 'layout', 'operator' => '!=', 'value' => 'thumbnail'],
			            ],
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
                        'ripple' => __('Ripple', 'uipro'),
                        'zoomin-roof' => __('Zoom in roof', 'uipro'),
                    ),
                    'default'       => '',
                ),
                array(
                    'id'            => 'ripple_width',
                    'label'         => __( 'Ripple Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 200,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'id'            => 'ripple_height',
                    'label'         => __( 'Ripple Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 200,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Ripple background color', 'uipro' ),
                    'name'  => 'ripple_bg',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles > div' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
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

				//Content style
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'show_introtext',
					'label'         => esc_html__('Show Introtext', 'uipro'),
					'description'   => esc_html__( 'Whether to show introtext.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '1',
					'start_section' => 'content_settings',
					'section_name'  => esc_html__('Content Settings', 'uipro')
				),
                array(
                    'type'      => Controls_Manager::NUMBER,
                    'name'      => 'introtext_number',
                    'label'     => esc_html__( 'Limit Words', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'show_introtext', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'intro_position',
                    'label'         => esc_html__( 'Position', 'uipro' ),
                    'options'       => array(
                        'absolute' => esc_html__('Absolute', 'uipro'),
                        'relative' => esc_html__('Relative', 'uipro'),
                    ),
                    'default'       => 'absolute',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-card-body' => 'position: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-card-body' => 'position: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'intro_block',
                    'label'         => esc_html__( 'Display', 'uipro' ),
                    'options'       => array(
                        'inline-block' => esc_html__('Inline', 'uipro'),
                        'block' => esc_html__('Block', 'uipro'),
                    ),
                    'default'       => 'inline-block',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-card-body' => 'display: {{VALUE}}',
                    ],
                ),
				array(
					'name'          => 'content_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-posts.style1 .ui-post-introtext'
                        .',{{WRAPPER}} .ui-posts-intro-item .ui-post-introtext',
				),
				array(
					'id'            => 'content_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-posts.style1 .ui-post-introtext' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .ui-post-introtext' => 'color: {{VALUE}}',
					],
				),
				array(
					'id'            => 'content_bg_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-posts.style1 .uk-card-body' => 'background-color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .uk-card-body' => 'background-color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                        ],
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
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'wrap_content_margin',
                    'label'         => esc_html__( 'Wrap Content Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-info-wrap .uk-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'wrap_content_hover_margin',
                    'label'         => esc_html__( 'Wrap Content Hover Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-article:hover .uk-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-article:hover .uk-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'wrap_content_box_shadow',
                    'label'         => esc_html__('Wrap Content Box Shadow', 'uipro'),
                    'description'   => esc_html__('Set the Box Shadow of Wrap Content.', 'uipro'),
                    'selector' => '{{WRAPPER}} .ui-posts.style1 .ui-post-info-wrap .uk-card-body'
                        .',{{WRAPPER}} .ui-posts-intro-item .ui-post-info-wrap .uk-card-body',
                ),

				//Meta settings
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'meta_icon_type',
                    'label'         => esc_html__( 'Icon Type', 'uipro' ),
                    'default'       => 'none',
                    'options'       => [
                                    ''  => esc_html__( 'FontAwesome', 'uipro' ),
                                    'uikit' => esc_html__( 'UIKit', 'uipro' ),
                                    'none' => esc_html__( 'None', 'uipro' ),
                    ],
                    'start_section' => 'meta_settings',
                    'section_name'  => esc_html__('Meta Settings', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'date_icon',
                    'label'         => esc_html__('Date Icon:', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'          => 'date_uikit_icon',
                    'label'         => esc_html__('Date Icon:', 'uipro'),
                    'default' => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
                        ],
                    ],
                    'options' => $this->get_font_uikit(),
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'author_icon',
                    'label'         => esc_html__('Author Icon:', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'          => 'author_uikit_icon',
                    'label'         => esc_html__('Author Icon:', 'uipro'),
                    'default' => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
                        ],
                    ],
                    'options' => $this->get_font_uikit(),
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'category_icon',
                    'label'         => esc_html__('Category Icon:', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'          => 'category_uikit_icon',
                    'label'         => esc_html__('Category Icon:', 'uipro'),
                    'default' => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
                        ],
                    ],
                    'options' => $this->get_font_uikit(),
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'tag_icon',
                    'label'         => esc_html__('Tag Icon:', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'          => 'tag_uikit_icon',
                    'label'         => esc_html__('Tag Icon:', 'uipro'),
                    'default' => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
                        ],
                    ],
                    'options' => $this->get_font_uikit(),
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'comment_icon',
                    'label'         => esc_html__('Comment Icon:', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'          => 'comment_uikit_icon',
                    'label'         => esc_html__('Comment Icon:', 'uipro'),
                    'default' => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
                        ],
                    ],
                    'options' => $this->get_font_uikit(),
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'view_icon',
                    'label'         => esc_html__('Post View Icon:', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'          => 'view_uikit_icon',
                    'label'         => esc_html__('Post View Icon:', 'uipro'),
                    'default' => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
                        ],
                    ],
                    'options' => $this->get_font_uikit(),
                ),
                array(
                    'id'            => 'meta_icon_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-article-meta i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .uk-article-meta i' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_icon_type', 'operator' => '!=', 'value' => 'none'],
                        ],
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'meta_author_avatar',
                    'label'     => esc_html__( 'Show author avatar', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_author_avatar_size',
                    'label'         => __( 'Avatar Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                            'step' => 1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-author img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                            ['name' => 'meta_author_avatar', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'id'            => 'meta_author_avatar_border',
                    'label'         => esc_html__( 'Avatar Border Radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-author img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                            ['name' => 'meta_author_avatar', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Avatar Border Custom', 'uipro' ),
                    'name'          => 'meta_author_avatar_border_custom',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-author img',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                            ['name' => 'meta_author_avatar', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),

                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_thumb_position',
                    'label'         => esc_html__( 'Meta On Thumbnail', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                        ],
                    ],
                ),

                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_top_position',
                    'label'         => esc_html__( 'Before Title', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_middle_position',
                    'label'         => esc_html__( 'After Title', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                    'default' => [ 'date', 'author', 'category' ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_bottom_position',
                    'label'         => esc_html__( 'After Description', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                    'default' => [ 'tags' ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_footer_position',
                    'label'         => esc_html__( 'In the footer', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                ),
                array(
                    'id'    => 'tag_style',
                    'type' => Controls_Manager::SELECT,
                    'label' => esc_html__('Tag Style', 'uipro'),
                    'description' => esc_html__('Select a predefined tag style.', 'uipro'),
                    'options' => array(
                        '' => esc_html__('Default', 'uipro'),
                        'plain-text' => esc_html__('Plain Text', 'uipro'),
                    ),
                    'default' => '',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'meta_on_thumb_position',
                    'label'         => esc_html__('Meta Thumb Position', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'uk-position-top-left' => esc_html__('Top Left', 'uipro'),
                        'uk-position-top-center' => esc_html__('Top Center', 'uipro'),
                        'uk-position-top-right' => esc_html__('Top Right', 'uipro'),
                        'uk-position-center' => esc_html__('Center', 'uipro'),
                        'uk-position-center-left' => esc_html__('Center Left', 'uipro'),
                        'uk-position-center-right' => esc_html__('Center Right', 'uipro'),
                        'uk-position-bottom-left' => esc_html__('Bottom Left', 'uipro'),
                        'uk-position-bottom-center' => esc_html__('Bottom Center', 'uipro'),
                        'uk-position-bottom-right' => esc_html__('Bottom Right', 'uipro'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_top_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'meta_thumb_padding',
                    'label'         => esc_html__( 'Meta Thumb Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-thumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                            ['name' => 'meta_thumb_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'meta_thumb_margin',
                    'label'         => esc_html__( 'Meta Thumb Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                            ['name' => 'meta_thumb_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_thumb_background_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Meta Thumb Background Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-thumb' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                            ['name' => 'meta_thumb_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_thumb_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Meta Thumb Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-thumb' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                            ['name' => 'meta_thumb_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_thumb_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Meta Thumb Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-thumb a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                            ['name' => 'meta_thumb_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_thumb_link_hover_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Meta Thumb Link Hover Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-thumb a:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                            ['name' => 'meta_thumb_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_top_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__('Before Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-top'
                        .',{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-top',
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_top_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_top_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Before Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-top' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-top' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_top_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_top_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Before Title Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-top a' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-top a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_top_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_top_link_hover_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Before Title Link Hover Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-top a:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-top a:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_top_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'meta_top_margin',
                    'label'         => esc_html__('Before Title Position Margin', 'uipro'),
                    'description'   => esc_html__('Set the before title margin.', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'medium' => esc_html__('Medium', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'xlarge' => esc_html__('X-Large', 'uipro'),
                        'custom' => esc_html__('Custom', 'uipro'),
                        'remove-vertical' => esc_html__('None', 'uipro'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_top_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'meta_top_margin_custom',
                    'label'         => esc_html__( 'Before Title Position Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-top' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-top' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_top_margin', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_middle_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__('After Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-middle'
                        .',{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-middle',
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_middle_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_middle_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-middle' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-middle' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_middle_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_middle_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Title Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-middle a' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-middle a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_middle_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_middle_link_hover_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Title Link Hover Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-middle a:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-middle a:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_middle_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'meta_middle_margin',
                    'label'         => esc_html__('After Title Position Margin', 'uipro'),
                    'description'   => esc_html__('Set the after title margin.', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'medium' => esc_html__('Medium', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'xlarge' => esc_html__('X-Large', 'uipro'),
                        'custom' => esc_html__('Custom', 'uipro'),
                        'remove-vertical' => esc_html__('None', 'uipro'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_middle_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'meta_middle_margin_custom',
                    'label'         => esc_html__( 'After Title Position Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-middle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-middle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_middle_margin', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_bottom_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__('After Description Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-bottom, {{WRAPPER}} .ui-posts-intro-item .ui-post-meta-bottom',
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_bottom_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_bottom_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Description Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-bottom' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-bottom' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_bottom_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_bottom_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Description Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-bottom a' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-bottom a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_bottom_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_bottom_link_hover_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Description Link Hover Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-bottom a:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-bottom a:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_bottom_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'meta_bottom_margin',
                    'label'         => esc_html__('After Description Position Margin', 'uipro'),
                    'description'   => esc_html__('Set the after description margin.', 'uipro'),
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
                            ['name' => 'meta_bottom_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_footer_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__('Footer Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-footer, {{WRAPPER}} .ui-posts-intro-item .ui-post-meta-footer',
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_footer_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_footer_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Footer Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-footer' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-footer' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_footer_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_footer_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Footer Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-meta-footer a' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-meta-footer a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_footer_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'meta_footer_margin',
                    'label'         => esc_html__('Footer Margin', 'uipro'),
                    'description'   => esc_html__('Set the after description margin.', 'uipro'),
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
                            ['name' => 'meta_footer_position', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_footer_width',
                    'label' => esc_html__( 'Footer width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px','%' ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-posts.style1 .uk-card-footer' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                        ],
                    ],
                ),

				//Button settings
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'show_readmore',
					'label'         => esc_html__('Show Readmore', 'uipro'),
					'description'   => esc_html__('Display the first letter of the paragraph as a large initial.', 'uipro'),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'start_section' => 'button_settings',
					'section_name'      => esc_html__('Button Settings', 'uipro')
				),
				array(
					'id'    => 'all_button_title',
					'label' => esc_html__( 'Text', 'uipro' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Read more' , 'uipro' ),
					'label_block' => true,
				),
				array(
					'id'    => 'target',
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Link New Tab', 'uipro'),
					'options' => array(
						'' => esc_html__('Same Window', 'uipro'),
						'_blank' => esc_html__('New Window', 'uipro'),
					),
				),
				array(
					'id'    => 'button_style',
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Style', 'uipro'),
					'description' => esc_html__('Set the button style.', 'uipro'),
					'options' => array(
						'' => esc_html__('Button Default', 'uipro'),
						'primary' => esc_html__('Button Primary', 'uipro'),
						'secondary' => esc_html__('Button Secondary', 'uipro'),
						'danger' => esc_html__('Button Danger', 'uipro'),
						'text' => esc_html__('Button Text', 'uipro'),
						'link' => esc_html__('Link', 'uipro'),
						'link-muted' => esc_html__('Link Muted', 'uipro'),
						'link-text' => esc_html__('Link Text', 'uipro'),
						'custom' => esc_html__('Custom', 'uipro'),
					),
					'default' => '',
				),
				array(
					'name'          => 'button_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'label'         => esc_html__('Button Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-posts.style1 .ui-post-button, {{WRAPPER}} .ui-posts-intro-item .ui-post-button',
					'condition' => array(
						'button_style'    => 'custom'
					),
				),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'button_icon',
                    'label'         => esc_html__( 'Button Icon', 'uipro' ),
                    'condition' => array(
                        'button_style'    => 'custom'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'button_icon_position',
                    'label'         => esc_html__( 'Button Icon Position', 'uipro' ),
                    'options'       => array(
                        'before'    => esc_html__('Before', 'uipro'),
                        'after'     => esc_html__('After', 'uipro')
                    ),
                    'default'       => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_icon', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name'          => 'button_icon_spacing',
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
                    'condition'     => array(
                        'button_icon_position'    => 'after'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .uipost-btn-icon-box' => 'margin-left: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'button_icon_spacing_right',
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
                    'condition'     => array(
                        'button_icon_position'    => 'before'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .uipost-btn-icon-box' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                ),
				array(
					'id'            => 'button_background',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-posts.style1 .ui-post-button' => 'background-color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .ui-post-button' => 'background-color: {{VALUE}}',
					],
					'separator'     => 'before',
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
						'{{WRAPPER}} .ui-posts.style1 .ui-post-button' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .ui-post-button' => 'color: {{VALUE}}',
					],
					'condition' => array(
						'button_style'    => 'custom'
					),
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => array(
                        'button_style'    => 'custom'
                    ),
                ),
				array(
					'name'            => 'button_border',
					'type'          =>  \Elementor\Group_Control_Border::get_type(),
					'label' => esc_html__( 'Button Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .ui-post-button',
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'id'            => 'button_background_hover',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Hover Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-posts-intro-item .ui-post-button:hover' => 'background-color: {{VALUE}}',
					],
					'default' => '#0f7ae5',
					'separator'     => 'before',
					'condition' => array(
						'button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_hover_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Hover Button Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-posts.style1 .ui-post-button:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ui-posts-intro-item .ui-post-button:hover' => 'color: {{VALUE}}',
					],
					'condition' => array(
						'button_style'    => 'custom'
					),
				),
				array(
					'name'            => 'button_border_hover',
					'type'          =>  \Elementor\Group_Control_Border::get_type(),
					'label' => esc_html__( 'Button Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-posts.style1 .ui-post-button:hover,'
                        .'{{WRAPPER}} .ui-posts-intro-item .ui-post-button:hover',
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'id'    => 'button_size',
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Button Size', 'uipro'),
					'options' => array(
						'' => esc_html__('Default', 'uipro'),
						'uk-button-small' => esc_html__('Small', 'uipro'),
						'uk-button-large' => esc_html__('Large', 'uipro'),
						'uk-padding-remove' => esc_html__('None', 'uipro'),
					),
					'separator'     => 'before',
				),
				array(
					'id'    => 'button_shape',
					'label' => esc_html__( 'Button Shape', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'rounded',
					'options' => [
						'rounded' => esc_html__('Rounded', 'uipro' ),
						'square' => esc_html__('Square', 'uipro' ),
						'circle' => esc_html__('Circle', 'uipro' ),
						'pill' => esc_html__('Pill', 'uipro' ),
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
					'id'    => 'button_margin_top',
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Margin', 'uipro'),
					'description' => esc_html__('Set the margin.', 'uipro'),
					'options' => array(
						'' => esc_html__('Default', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'medium' => esc_html__('Medium', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
						'xlarge' => esc_html__('X-Large', 'uipro'),
						'remove' => esc_html__('None', 'uipro'),
						'custom' => esc_html__('Custom', 'uipro'),
					),
					'default' => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_margin',
                    'label'         => esc_html__( 'Button Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => array(
                        'button_margin_top'    => 'custom'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'pagination_margin',
                    'label'         => esc_html__( 'Pagination Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-posts.style1 .ui-post-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        '{{WRAPPER}} .ui-posts-intro-item .ui-post-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'condition' => array(
                        'pagination_type!'    => 'none'
                    ),
                    'start_section' => 'pagination_settings',
                    'section_name'  => esc_html__('Pagination Settings', 'uipro')
                ),
			)
			);
			unset($post_types['post']);
            foreach ($post_types as $key => $value) {
                $post_type_category = array(
                    array(
                        'type'          => Controls_Manager::SELECT2,
                        'id'            => $key.'_category',
                        'label'         => esc_html__( 'Select Category', 'uipro' ),
                        'options'       => UIPro_Helper::get_cat_taxonomy( $key.'-category'),
                        'multiple'      => true,
                        'conditions' => [
                            'terms' => [
                                ['name' => 'resource', 'operator' => '===', 'value' => $key],
                            ],
                        ],
                    )
                );
                array_splice($options, 2, 0, $post_type_category);
            }
			$options    = array_merge($options, $this->get_general_options());

            static::$cache[$store_id]   = $options;

            return $options;
		}

	}
}