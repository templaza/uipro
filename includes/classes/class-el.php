<?php
/**
 * UIPro Elementor class
 *
 * @version     1.0.0
 * @author      TemPlaza
 * @package     UIPro/Classes
 * @category    Classes
 */

use Elementor\Plugin;

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'UIPro_El' ) ) {
	/**
	 * Class UIPro_El
	 */
	class UIPro_El {

		/**
		 * @var null
		 */
		private static $instance = null;

		/**
		 * UIPro_El constructor.
		 */
		public function __construct() {

			// mapping params
			require_once( __DIR__ . '/class-el-mapping.php' );

			$this -> load_ajax_widgets();

			// add widget categories
			add_action( 'elementor/init', array( $this, 'register_categories' ), 99 );

			// load widget
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'load_widgets' ) );
		}

		/**
		 * Add widget categories
		 */
		public function register_categories() {
			$result = Plugin::instance()->elements_manager->add_category(
				'uipro',
				array(
					'title' => apply_filters( 'templaza_shortcode_group_name', esc_html__( 'TemPlaza', 'templaza-elements' ) ),
					'icon'  => 'fa fa-plug'
				)
			);
		}

		/**
		 * @param $widgets_manager Elementor\Widgets_Manager
		 *
		 * @throws Exception
		 */
		public function load_widgets( $widgets_manager ) {

			// parent class
			require_once( UIPRO_CLASSES_PATH . '/class-el-widget.php' );

			$widgets = UIPro_Helper::get_elements();
			foreach ( $widgets as $group => $_widgets ) {
				foreach ( $_widgets as $widget ) {
					if ( $group != 'widgets' ) {
						$file = apply_filters( 'uipro/el-widget-file', UIPRO_WIDGETS_PATH . "/$widget/class-el-$widget.php", $widget );

						if ( file_exists( $file ) ) {
							include_once $file;
							$class = '\UIPro_El_' . str_replace( '-', '_', ucfirst( $widget ) );

							if ( class_exists( $class ) ) {
								$widgets_manager->register_widget_type( new $class() );
							}
						}
					}
				}
			}
		}

		/**
		 * Instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
		}

		/**
		 *
		 * @throws Exception
		 */
		public function load_ajax_widgets() {

			$widgets = UIPro_Helper::get_elements();
			if(empty($widgets)){
			    return;
            }
            foreach ( $widgets as $group => $_widgets ) {
                if(empty($_widgets)){
                    continue;
                }
                foreach ( $_widgets as $widget ) {
                    if ( $group != 'widgets' ) {
                        $file   = UIPRO_WIDGETS_PATH . "/$widget/ajax.php";

                        $file = apply_filters( 'templaza-elements/el-widget-file', $file, $widget );
                        $file = apply_filters( 'uipro/el-widget-file', $file, $widget );

                        if ( file_exists( $file ) ) {
                            include_once $file;
                        }
                    }
                }
            }
		}
	}
}

new UIPro_El();