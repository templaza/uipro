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

//				$type = $param['type'];
//
//				$field = array();
//
//				// get mapping field
//
//				$field['type']        = self::_mapping_types( $type );
//				$field['label']       = isset( $param['heading'] ) ? $param['heading'] : '';
//				$field['description'] = isset( $param['description'] ) ? $param['description'] : '';
//				$field['default']     = isset( $param['std'] ) ? $param['std'] : [];
//				if ( isset( $param['start_section'] ) ) {
//					$field['start_section'] = $param['start_section'];
//					$field['section_name']  = isset( $param['section_name'] ) ? $param['section_name'] : $param['group'];
//				}
//				switch ( $param['type'] ) {
//					// common structure field
//					case 'number':
//					case 'textfield':
//					case 'checkbox':
//						break;
//					case 'iconpicker':
//						if ( isset( $param['settings'] ) ) {
//							$field['include'] = $field['options'] = apply_filters( 'thim-builder-el-' . $param['settings']['type'] . '-icon', array() );
//						}
//						break;
//					case 'attach_image':
//					case 'attach_images':
//						$field['default'] = array( 'url' => Utils::get_placeholder_image_src() );
//						break;
//					case 'vc_link':
//						$field['placeholder'] = __( 'https://your-link.com', 'thim-core' );
//						$field['default']     = array( 'url' => '#' );
//						break;
//					case 'param_group':
//						$repeater = new Repeater();
//
//						// repeats options
//						$repeats = self::mapping( $param['params'] );
//
//						foreach ( $repeats as $key => $repeat ) {
//							$repeater->add_control( $key, $repeat );
//						}
//
//						$field = array_merge(
//							$field, array(
//								'fields' => $repeater->get_controls()
//							)
//						);
//						break;
//					case 'dropdown_multiple':
//						$field['options']  = array_flip( $param['value'] );
//						$field['multiple'] = true;
//						break;
//					case 'dropdown':
//						$field['options'] = array_flip( $param['value'] );
//						break;
//					case 'radio_image':
//						$field['options'] = $param['options'];
//						foreach ( $field['options'] as $k_o => $option ) {
//							$field['options'][$k_o] = array(
//								'title' => '<img src="' . $option . '">',
//								'icon'  => 'bp_el_class'
//							);
//						}
//						break;
//					case 'slider':
//						$field['range']   = $param['range'];
//						$field['default'] = $param['el_default'];
//						break;
//					default:
//						$field = array_merge( $field, apply_filters( 'thim-builder/field-el-param', array(), $type ) );
//						break;
//				}
//
//				// handle dependency to condition
//				if ( isset( $param['dependency'] ) ) {
//					$dependency = $param['dependency'];
//					if ( isset( $dependency['element_el'] ) ) {
//						$dependency['element'] = $dependency['element_el']; // fix for eduma
//					}
//					if ( isset( $dependency['value_el'] ) ) {
//						$dependency['value'] = $dependency['value_el']; // fix for eduma
//					}
//
//					if ( isset( $dependency['value'] ) ) {
//						$field['condition'] = array( $dependency['element'] => $dependency['value'] );
//					} else if ( isset( $dependency['not_empty'] ) ) {
//						$field['condition'] = array( $dependency['element'] . '!' => '' );
//					}
//				}
//				if ( isset( $param['param_name_el'] ) ) {
//					$param['id'] = $param['param_name_el'];
//				}
//				$controls[$param['id']] = $field;
			}

			return $controls;
		}
	}
}

new UIPro_Builder_El_Mapping();