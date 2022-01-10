<?php
/**
 * UIPro Visual Composer List Post shortcode
 *
 * @version     1.0.0
 * @author      TemPlaza.com
 * @package     UIPro/Classes
 * @category    Classes
 * @author      Thimpress, tuanta
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'UIPro_VC_List_Post' ) ) {
	/**
	 * Class UIPro_VC_List_Post
	 */
	class UIPro_VC_List_Post extends UIPro_VC_Shortcode {

		/**
		 * UIPro_VC_List_Post constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'UIPro_Config_List_Post';

			parent::__construct();
		}
	}
}

new UIPro_VC_List_Post();