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

//require_once __DIR__.'/helper.php';

if ( ! class_exists( 'UIPro_Config_UIAdvanced_Products_Filter' ) ) {
	/**
	 * Class UIPro_Config_UIPosts
	 */
	class UIPro_Config_UIAdvanced_Products_Filter extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiadvanced-products-filter';
			self::$name = esc_html__( 'TemPlaza: UI Advanced Products Filter', 'uipro' );
			self::$desc = esc_html__( 'Add UI Advanced Products Filter Box.', 'uipro' );
			self::$icon = 'eicon-posts-grid';
			self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();
		}

//		public function get_styles() {
//            return array(
//                'ui-advanced-product-loadmore' => array(
//                    'src'   =>  'style.css'
//                )
//            );
//        }
//
//		public function get_scripts() {
//			return array(
//				'ui-advanced-product-loadmore' => array(
//					'src'   =>  'script.min.js',
//					'deps'  =>  array('jquery')
//				)
//			);
//		}
//
//		public function get_localize() {
//			global $wp_query;
//			// get settings
//			return array(
//				'ui_advanced_product_loadmore_params'   =>  array(
//					'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
//					'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
//				)
//			);
//		}

		/**
		 * @return array
		 */
		public function get_options() {

            // Custom fields option
            $custom_fields  = UIPro_UIAdvancedProducts_Helper::get_custom_field_options();

			// options
			$options = array(
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'uiap_custom_fields',
                    'label'         => esc_html__( 'Select Custom Field', 'uipro' ),
                    'options'       => $custom_fields,
                    'multiple'      => true,
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'uiap_enable_keyword',
                    'label'         => esc_html__( 'Filter By Keyword', 'uipro' ),
                    'default'       => 'yes'
                ),
			) ;
			return array_merge($options, $this->get_general_options());
		}

		public function get_template_name() {
			return 'base';
		}
	}
}