<?php
/**
 * UIPro Elementor Mapping class
 *
 * @version     1.0.0
 * @author      UIPro
 * @package     UIPro/Classes
 * @category    Classes
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! class_exists( 'UIPro_Builder_El_Mapping' ) ) {
	/**
	 * Class UIPro_El_Mapping
	 */
	class UIPro_Builder_El_Mapping {

		/**
		 * Mapping Elementor type to Visual Composer
		 *
		 * @param $type
		 *
		 * @return bool|mixed
		 */
		private static function _mapping_types( $type ) {
			$mapping = array(
                Controls_Manager::NUMBER        => 'number',
                Controls_Manager::SLIDER        => 'slider',
                Controls_Manager::TEXT          => 'textfield',
                Controls_Manager::URL           => 'vc_link',
                Controls_Manager::REPEATER      => 'param_group',
                Controls_Manager::MEDIA         => 'attach_image',
                Controls_Manager::GALLERY       => 'attach_images',
                Controls_Manager::ICON          => 'iconpicker',
                Controls_Manager::SELECT        => 'dropdown',
                Controls_Manager::SELECT2       => 'dropdown_multiple',
                Controls_Manager::COLOR         => 'colorpicker',
                Controls_Manager::TEXTAREA      => 'textarea',
                Controls_Manager::SWITCHER      => 'checkbox',
                Controls_Manager::CHOOSE        => 'radio_image',
                Controls_Manager::DATE_TIME     => 'datetimepicker',
                Controls_Manager::HEADING       => 'bp_heading',
                Controls_Manager::HIDDEN        => 'bp_hidden',
                ''                              => 'loop'
			);

			if ( ! array_key_exists( $type, $mapping ) ) {
				return Controls_Manager::TEXT;
			}

			return apply_filters( 'thim-builder/el-mapping-types', $mapping[$type] );
		}

		/**
		 * @param $params
		 *
		 * @return array
		 */
		public static function mapping( $params ) {

			if ( ! is_array( $params ) ) {
				return array();
			}

			$controls = array();

			foreach ( $params as $param ) {
				if ( isset( $param['type_el'] ) ) {
					$param['type'] = $param['type_el'];
				}
                $controls[$param['name']] = $param;

			}

			return $controls;
		}
	}
}

new UIPro_Builder_El_Mapping();