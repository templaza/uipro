<?php
/**
 * UIPro Gallery Posts config class
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

if ( ! class_exists( 'UIPro_Config_Gallery_Portfolio' ) ) {
	/**
	 * Class UIPro_Config_Accordion
	 */
	class UIPro_Config_Gallery_Portfolio extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Gallery_Portfolio constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'gallery-portfolio';
			self::$name = esc_html__( 'TemPlaza: Gallery Portfolio', 'uipro' );
			self::$desc = esc_html__( 'Display Gallery Portfolio.', 'uipro' );
			self::$icon = 'eicon-gallery-masonry';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
				array(
					'type'      => Controls_Manager::SELECT,
                    'name'        => 'cat',
					'label'     => esc_html__( 'Select Category', 'uipro' ),
					'options'     => UIPro_Helper::get_cat_taxonomy( 'portfolio-category',
                        array('all'  => esc_html__( 'All', 'uipro' ) ) ),
				),

//				array(
//					'type'          => Controls_Manager::SELECT,
//                    'name'            => 'layout',
//					'label'         => esc_html__( 'Layout', 'uipro' ),
//					'options'       => array(
//                        ''          => esc_html__( 'Default', 'uipro' ),
//                        'grid-masonry'   => esc_html__( 'Grid Masonry', 'uipro' ),
////                        'isotope'   => esc_html__( 'Isotope', 'uipro' ),
//					),
//                    /* vc */
//                    'admin_label' => true,
//				),

				array(
					'type'              => Controls_Manager::SELECT,
					'label'             => esc_html__( 'Columns', 'uipro' ),
					'name'                => 'columns',
//					'responsive_mode'   => true,
					'options'           => array(
                        ''      => esc_html__( 'Select', 'uipro' ),
                        '1'     => esc_html__( '1', 'uipro' ),
                        '2'     => esc_html__( '2', 'uipro' ),
                        '3'     =>esc_html__( '3', 'uipro' ),
						'4'     => esc_html__( '4', 'uipro' ),
						'5'     => esc_html__( '5', 'uipro' ),
						'6'     => esc_html__( '6', 'uipro' ),
					),
                    /* vc */
                    'admin_label' => true,
                ),

				array(
					'type'          => Controls_Manager::SWITCHER,
                    'name'            => 'filter',
                    'default'       => 'yes',
					'label'         => esc_html__( 'Show Filter', 'uipro' ),
                    /* vc */
                    'admin_label'   => true,
				),

				array(
					'type'          => Controls_Manager::NUMBER,
                    'name'            => 'limit',
                    'default'       => '8',
					'label'         => esc_html__( 'Limit', 'uipro' ),
                    /* vc */
                    'admin_label'   => true,
				),
			);
		}

        public function get_template_name() {
            return 'base';
        }
	}
}