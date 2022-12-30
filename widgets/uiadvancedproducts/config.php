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

require_once __DIR__.'/helper.php';

if ( ! class_exists( 'UIPro_Config_UIAdvancedProducts' ) ) {
	/**
	 * Class UIPro_Config_UIPosts
	 */
	class UIPro_Config_UIAdvancedProducts extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiadvancedproducts';
			self::$name = esc_html__( 'TemPlaza: UI Advanced Products', 'uipro' );
			self::$desc = esc_html__( 'Add UI Advanced Products Box.', 'uipro' );
			self::$icon = 'eicon-posts-grid';
			self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();
		}

		public function get_styles() {
            return array(
                'ui-advanced-product-loadmore' => array(
                    'src'   =>  'style.css'
                )
            );
        }

		public function get_scripts() {
			return array(
				'ui-advanced-product-loadmore' => array(
					'src'   =>  'script.js',
					'deps'  =>  array('jquery','elementor-frontend')
				)
			);
		}

		public function get_localize() {
			global $wp_query;
			// get settings
			return array(
				'ui_advanced_product_loadmore_params'   =>  array(
					'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
					'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
				)
			);
		}

		/**
		 * @return array
		 */
		public function get_options() {

            $categories = UIPro_UIAdvancedProducts_Helper::get_custom_categories();
            // Custom fields option
            $custom_fields  = UIPro_UIAdvancedProducts_Helper::get_custom_field_options();

            $store_id   = __METHOD__;
            $store_id  .= '::'.serialize($categories);
            $store_id  .= '::'.serialize($custom_fields);
            $store_id   = md5($store_id);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }
            $slug_cat = array(
                'ap_category' => esc_html__( 'Advanced Product Category', 'uipro' ),
                'ap_branch' => esc_html__( 'Branch', 'uipro' )
            );
            $slug_tax = array();
            $options_filter = array();

		    $options    = array(
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'main_layout',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Main Layout', 'uipro' ),
                    'options'       => array(
                        'base'      => esc_html__( 'Default', 'uipro' ),
                        'archive'   => esc_html__( 'Inherit Archive', 'uipro' ),
                        'style1'   => esc_html__( 'Style 1', 'uipro' ),
                    ),
                    'default'       => 'archive',
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'ap_product_branch',
                    'label'         => esc_html__( 'Select Branch', 'uipro' ),
                    'options'       => UIPro_Helper::get_cat_taxonomy_slug( 'ap_branch' ),
                    'multiple'      => true,
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'ap_product_category',
                    'label'         => esc_html__( 'Select Category', 'uipro' ),
                    'options'       => UIPro_Helper::get_cat_taxonomy_slug( 'ap_category' ),
                    'multiple'      => true,
                ),
            );

            if(!empty($categories) && count($categories)){
                foreach ($categories as $cat){
                    $slug           = get_post_meta($cat -> ID, 'slug', true);
                    $slug_tax[''.get_post_meta($cat -> ID, 'slug', true)]   = $cat -> post_title;
                    if(!taxonomy_exists($slug)){
                        continue;
                    }

                    $cat_options    = UIPro_Helper::get_cat_taxonomy_slug( $slug );
                    if(empty($cat_options) || !count($cat_options)){
                        continue;
                    }
                    $options[]      = array(
                        'type'          => Controls_Manager::SELECT2,
                        'id'            => 'ap_product_'.$slug,
                        'label'         => sprintf(esc_html__( 'Select %s', 'uipro' ), $cat -> post_title),
                        'options'       => $cat_options,
                        'multiple'      => true,
                    );
                    $options_filter[]      = array(
                        'type'          => Controls_Manager::SELECT2,
                        'id'            => 'ap_product_'.$slug.'_filter',
                        'label'         => sprintf(esc_html__( 'Select %s', 'uipro' ), $cat -> post_title),
                        'options'       => $cat_options,
                        'multiple'      => true,
                        'condition'     => array(
                            'filter_by'    => ''.$slug.'',
                        ),
                    );
                }
            }

            $all_tax = array_merge($slug_cat,$slug_tax);

            // Custom fields option

            $options[]      = array(
                'type'          => Controls_Manager::SELECT2,
                'id'            => 'uiap_custom_fields',
                'label'         => esc_html__( 'Select Custom Field', 'uipro' ),
                'options'       => $custom_fields,
                'multiple'      => true,
            );

			// options
			$options = array_merge($options, array(
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
					'id'            => 'ordering',
					'label'         => esc_html__( 'Ordering', 'uipro' ),
					'options'       => array(
						'latest'    => esc_html__('Latest', 'uipro'),
						'oldest'    => esc_html__('Oldest', 'uipro'),
						'popular'   => esc_html__('Popular', 'uipro'),
						'random'    => esc_html__('Random', 'uipro'),
					),
					'default'       => 'latest',
					'description'   => esc_html__( 'Select products ordering from the list.', 'uipro' ),
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
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
					'section_name'      => esc_html__('Card Settings', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_background',
					'label'         => esc_html__('Card Background', 'uipro'),
					'description'   => esc_html__('Set the Background Color of Card.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .uk-card' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
						'{{WRAPPER}} .uk-card' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
						'' => esc_html__('Default', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
						'custom' => esc_html__('Custom', 'uipro'),
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'type'          => Controls_Manager::DIMENSIONS,
					'name'          =>  'card_padding',
					'label'         => esc_html__( 'Card Padding', 'uipro' ),
					'responsive'    =>  true,
					'size_units'    => [ 'px', 'em', '%' ],
					'selectors'     => [
						'{{WRAPPER}} .ui-post-info-wrap .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .ui-post-info-wrap .uk-card-footer' => 'padding: 20px {{RIGHT}}{{UNIT}} 20px {{LEFT}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
							['name' => 'card_size', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'card_border',
                    'label'         => esc_html__('Card Border', 'uipro'),
                    'selector' => '{{WRAPPER}} .ap-item .ap-inner',
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
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'filter_all',
					'label'         => esc_html__('Show all', 'uipro'),
					'description'   => esc_html__( 'Display filter all', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
				),
                array(
                    'id'    => 'filter_all_text',
                    'label' => esc_html__( 'All Text', 'uipro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'All' , 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'filter_all', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'filter_by',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Filter By', 'uipro' ),
                    'options'       => $all_tax,
                    'default'       => 'ap_category',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'ap_product_ap_category_filter',
                    'label'         => esc_html__( 'Select Category', 'uipro' ),
                    'options'       => UIPro_Helper::get_cat_taxonomy_slug( 'ap_category' ),
                    'multiple'      => true,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                            ['name' => 'filter_by', 'operator' => '===', 'value' => 'ap_category'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'ap_product_ap_branch_filter',
                    'label'         => esc_html__( 'Select Branch', 'uipro' ),
                    'options'       => UIPro_Helper::get_cat_taxonomy_slug( 'ap_branch' ),
                    'multiple'      => true,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                            ['name' => 'filter_by', 'operator' => '===', 'value' => 'ap_branch'],
                        ],
                    ],
                ),
            ));
            $options = array_merge($options,$options_filter, array(
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '===', 'value' => 'base'],
                        ],
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
						'{{WRAPPER}} .ui-post-filter' => 'width: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
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
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
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
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '==', 'value' => '1'],
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
                array(
                    'name'            => 'filter_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Filter Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon Filter.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-filter a',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'filter_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Filter Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-filter a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'filter_color_hover',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Filter Color Hover', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-filter a:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ap-filter a.active' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Filter alignment', 'uipro' ),
                    'name'          => 'filter_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-filter'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'filter_item_margin',
                    'label'         => esc_html__( 'Filter Item Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-filter a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'filter_margin',
                    'label'         => esc_html__( 'Filter Block Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'filter_loading_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Filter Loading Background', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .templaza-posts__loading' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_filter', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
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
					'section_name'  => esc_html__('Slider Settings', 'uipro'),

				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'enable_autoplay',
					'label'         => esc_html__('Autoplay', 'uipro'),
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
                    'type'          => Controls_Manager::NUMBER,
                    'id'            => 'slider_item_start',
                    'label'         => esc_html__( 'Slider item to show', 'uipro' ),
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
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
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'Bot_padding',
                    'label'         => esc_html__( 'Dot Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-dotnav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'slider_box_padding',
                    'label'         => esc_html__( 'Slider Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slider-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'slider_visible',
                    'label'         => esc_html__('Visible all slider items', 'uipro'),
                    'description'   => esc_html__( 'Visible all slider items', 'uipro' ),
                    'label_on'      => esc_html__( 'Visible', 'uipro' ),
                    'label_off'     => esc_html__( 'Hidden', 'uipro' ),
                    'return_value'  => 'visible',
                    'default'       => 'hidden',
                    'selectors'     => [
                        '{{WRAPPER}} .uk-slider-container' => 'overflow: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'slider_item_overlay',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Slider Overlay Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider-container::before' => 'background: {{VALUE}}',
                        '{{WRAPPER}} .uk-slider-container::after' => 'background: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                            ['name' => 'slider_visible', 'operator' => '===', 'value' => 'visible'],
                        ],
                    ],
                ),
                array(
                    'name'            => 'slider_item_overlay_space',
                    'label'         => esc_html__( 'Overlay Space', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => -200,
                            'max' => 500
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider-container::before' => 'margin-left: -{{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .uk-slider-container::after' => 'margin-left: {{SIZE}}{{UNIT}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'use_slider', 'operator' => '===', 'value' => '1'],
                            ['name' => 'slider_visible', 'operator' => '===', 'value' => 'visible'],
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
					'section_name'      => esc_html__('Title Settings', 'uipro'),
					'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'name'            => 'title_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-title, {{WRAPPER}} .ap-title',
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'id'            => 'custom_title_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-title > a' => 'color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),

				// Author Settings
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'show_author',
					'label'         => esc_html__('Show Author', 'uipro'),
					'description'   => esc_html__( 'Display author of product.', 'uipro' ),
					'label_on'      => esc_html__( 'Yes', 'uipro' ),
					'label_off'     => esc_html__( 'No', 'uipro' ),
					'return_value'  => '1',
					'default'       => '0',
					'start_section' => 'author_settings',
					'section_name'  => esc_html__('Author Settings', 'uipro'),
				),
                array(
                    'name'            => 'author_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Author Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for Author name.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-author-name',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'show_author', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'author_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Author Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-author-name > a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'show_author', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'author_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Author Color Hover', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-author-name > a:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'show_author', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'show_author_avatar',
                    'label'         => esc_html__('Show Author Avatar', 'uipro'),
                    'description'   => esc_html__( 'Display author avatar.', 'uipro' ),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'show_author', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'name'            => 'author_avatar_height',
                    'label'         => esc_html__( 'Avatar Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ap-author-img-box img' => 'height: {{SIZE}}{{UNIT}}; width:auto;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'show_author_avatar', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'author_margin',
                    'label'         => esc_html__( 'Author Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-author-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'show_author', 'operator' => '===', 'value' => '1'],
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
					'section_name'  => esc_html__('Image Settings', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
							['name' => 'hide_thumbnail', 'operator' => '!==', 'value' => '1'],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
							['name' => 'layout', 'operator' => '===', 'value' => ''],
						],
					],
				),
                array(
                    'id'          => 'image_width',
                    'label' => esc_html__( 'Image Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1-2'    => esc_html__('1-2', 'uipro'),
                        '1-3'    => esc_html__('1-3', 'uipro'),
                        '2-3'    => esc_html__('2-3', 'uipro'),
                        '1-4'    => esc_html__('1-4', 'uipro'),
                        '3-4'    => esc_html__('3-4', 'uipro'),
                        '1-5'    => esc_html__('1-5', 'uipro'),
                        '4-5'    => esc_html__('4-5', 'uipro'),
                        '1-6'    => esc_html__('1-6', 'uipro'),
                        '5-6'    => esc_html__('5-6', 'uipro'),
                    ),
                    'default'   => '1-2',
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                            [
                                'relation' => 'or',
                                'terms' => [
                                    ['name' => 'image_position', 'operator' => '===', 'value' => 'left'],
                                    ['name' => 'image_position', 'operator' => '===', 'value' => 'right'],
                                ],
                            ]
                        ]
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'name'            => 'thumbnail_height',
					'label'         => esc_html__( 'Thumbnail Height', 'uipro' ),
					'type'          => Controls_Manager::SLIDER,
					'devices'       => [ 'desktop', 'tablet', 'mobile' ],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
					),
					'default'       => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'type'          => \Elementor\Group_Control_Image_Size::get_type(),
					'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'large',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),

				//Content style
				array(
					'type'          => Controls_Manager::SWITCHER,
					'id'            => 'show_introtext',
					'label'         => esc_html__('Show Introtext', 'uipro'),
					'description'   => esc_html__( 'Whether to show instrotext.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '1',
					'start_section' => 'content_settings',
					'section_name'  => esc_html__('Content Settings', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'name'          => 'content_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-post-introtext',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'id'            => 'content_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Custom Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-post-introtext' => 'color: {{VALUE}}',
					],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),

				//Meta settings
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_top_position',
                    'label'         => esc_html__( 'Before Title', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                    'start_section' => 'meta_settings',
                    'section_name'  => esc_html__('Meta Settings', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_middle_position',
                    'label'         => esc_html__( 'After Title', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                    'default' => [ 'date', 'author', 'category' ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_bottom_position',
                    'label'         => esc_html__( 'After Description', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                    'default' => [ 'tags' ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'meta_footer_position',
                    'label'         => esc_html__( 'In the footer', 'uipro' ),
                    'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
                    'multiple'      => true,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_top_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Before Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-post-meta-top',
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_top_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Before Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-post-meta-top' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_top_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Before Title Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-post-meta-top a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                        'remove-vertical' => esc_html__('None', 'uipro'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_middle_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('After Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-post-meta-middle',
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_middle_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-post-meta-middle' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_middle_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Title Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-post-meta-middle a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                        'remove-vertical' => esc_html__('None', 'uipro'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_bottom_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('After Description Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-post-meta-bottom',
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_bottom_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Description Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-post-meta-bottom' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_bottom_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('After Description Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-post-meta-bottom a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'meta_footer_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Footer Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-post-meta-footer',
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_footer_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Footer Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-post-meta-footer' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'meta_footer_link_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Footer Link Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-post-meta-footer a' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
					'section_name'      => esc_html__('Button Settings', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'id'    => 'all_button_title',
					'label' => esc_html__( 'Text', 'uipro' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Read more' , 'uipro' ),
					'label_block' => true,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'id'    => 'target',
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Link New Tab', 'uipro'),
					'options' => array(
						'' => esc_html__('Same Window', 'uipro'),
						'_blank' => esc_html__('New Window', 'uipro'),
					),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
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
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
				array(
					'name'          => 'button_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'         => esc_html__('Button Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-post-button',
					'condition' => array(
						'main_layout'     => 'base',
						'button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_background',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-post-button' => 'background-color: {{VALUE}}',
					],
					'separator'     => 'before',
					'default' => '#1e87f0',
					'condition' => array(
                        'main_layout'     => 'base',
						'button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Button Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-post-button' => 'color: {{VALUE}}',
					],
					'condition' => array(
                        'main_layout'     => 'base',
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'id'            => 'button_background_hover',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Hover Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-post-button:hover' => 'background-color: {{VALUE}}',
					],
					'default' => '#0f7ae5',
					'separator'     => 'before',
					'condition' => array(
                        'main_layout'     => 'base',
						'button_style'    => 'custom'
					),
				),
				array(
					'id'            => 'button_hover_color',
					'type'          =>  Controls_Manager::COLOR,
					'label'         => esc_html__('Hover Button Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-post-button:hover' => 'color: {{VALUE}}',
					],
					'condition' => array(
                        'main_layout'     => 'base',
						'button_style'    => 'custom'
					),
				),
				array(
					'name'            => 'button_border_hover',
					'type'          =>  \Elementor\Group_Control_Border::get_type(),
					'label' => esc_html__( 'Button Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-post-button:hover',
					'conditions' => [
						'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
					),
					'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
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
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
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
					'label' => esc_html__('Margin Top', 'uipro'),
					'description' => esc_html__('Set the top margin.', 'uipro'),
					'options' => array(
						'' => esc_html__('Default', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'medium' => esc_html__('Medium', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
						'xlarge' => esc_html__('X-Large', 'uipro'),
						'remove' => esc_html__('None', 'uipro'),
					),
					'default' => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'main_layout', 'operator' => '!=', 'value' => 'archive'],
                        ],
                    ],
				),
			) );
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

		public function get_template_name() {
			return 'archive';
		}
	}
}